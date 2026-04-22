<?php

namespace App\Models;

use CodeIgniter\Model;

class GuestModel extends Model
{
    protected $table            = 'guests';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'position', 'address', 'is_marked', 'is_printed', 'is_selected', 'user_id', 'event_id'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_field';

    // Validation
    protected $validationRules      = [
        'name'     => 'required|min_length[3]|max_length[255]',
        'address'  => 'permit_empty',
        'event_id' => 'permit_empty|is_natural_no_zero',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete   = [];

    public function normalizeText(?string $text, bool $standardize = true): string
    {
        if (empty($text)) return '';
        $text = strtolower($text);
        
        // Remove non-alphanumeric except spaces for tokenization
        $text = preg_replace('/[^a-z0-9 ]/', ' ', $text);
        
        if ($standardize) {
            $variations = [
                '/\bmohamad\b/'  => 'muhammad',
                '/\bmohammad\b/' => 'muhammad',
                '/\bmuh\b/'      => 'muhammad',
                '/\bmhd\b/'      => 'muhammad',
                '/\bmd\b/'       => 'muhammad',
            ];
            $text = preg_replace(array_keys($variations), array_values($variations), $text);
        }
        
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }

    /**
     * Smart Duplicate Check using fuzzy matching (similar_text)
     * Stricter Logic: name >= 85% (MANDATORY), final score >= 75%
     * Scoring: name 60%, position 15%, address 25%
     */
    public function checkSmartDuplicate(array $data, int $userId, ?int $eventId = null): array
    {
        $normName = $this->normalizeText($data['name'] ?? '');
        $normPos = $this->normalizeText($data['position'] ?? '');
        $normAddr = $this->normalizeText($data['address'] ?? '');

        // Optimization: Pre-filter using first 3 chars of name
        $prefix = substr($normName, 0, 3);
        
        $builder = $this->where('user_id', $userId);
        if (!empty($eventId)) {
            $builder->where('event_id', $eventId);
        }
        
        if (strlen($prefix) > 0) {
            $builder->like('name', $prefix, 'after');
        }
        
        // Limit for performance
        $candidates = $builder->limit(50)->findAll();
        
        $duplicates = [];
        $maxConfidence = 0;

        foreach ($candidates as $candidate) {
            $cName = $this->normalizeText($candidate['name']);
            
            // similarity in percentage
            similar_text($normName, $cName, $namePercent);
            
            // Word token check (Point 5: swap support and typo support)
            $sWords = explode(' ', $normName);
            $cWords = explode(' ', $cName);
            sort($sWords);
            sort($cWords);
            similar_text(implode(' ', $sWords), implode(' ', $cWords), $nameSortedPercent);
            
            $finalNamePercent = max($namePercent, $nameSortedPercent);
            
            // Hard filtering: name similarity must be >= 85% (MANDATORY)
            if ($finalNamePercent < 85) continue;
            
            // Ensure at least 1 word matches exactly
            $intersection = array_intersect(explode(' ', $normName), explode(' ', $cName));
            if (empty($intersection)) continue;

            $cPos = $this->normalizeText($candidate['position'] ?? '');
            $cAddr = $this->normalizeText($candidate['address'] ?? '');

            // Position similarity
            $posPercent = 0;
            if (empty($normPos) && empty($cPos)) {
                $posPercent = 100;
            } elseif (!empty($normPos) && !empty($cPos)) {
                similar_text($normPos, $cPos, $posPercent);
            }

            // Address similarity
            $addrPercent = 0;
            if (empty($normAddr) && empty($cAddr)) {
                $addrPercent = 100;
            } elseif (!empty($normAddr) && !empty($cAddr)) {
                similar_text($normAddr, $cAddr, $addrPercent);
            }

            // Calculate total weighted score: name 60%, position 15%, address 25%
            $totalScore = ($finalNamePercent * 0.6) + ($posPercent * 0.15) + ($addrPercent * 0.25);

            // Output only candidates with final score >= 75
            if ($totalScore >= 75) {
                $candidate['similarity_score'] = round($totalScore, 2);
                $duplicates[] = $candidate;
                if ($totalScore > $maxConfidence) $maxConfidence = $totalScore;
            }
        }

        // Sort by similarity score descending
        usort($duplicates, function($a, $b) {
            return $b['similarity_score'] <=> $a['similarity_score'];
        });

        return [
            'is_duplicate' => count($duplicates) > 0,
            'confidence'   => round($maxConfidence, 2),
            'candidates'   => $duplicates
        ];
    }

    /**
     * Scans all guests for potential duplicates using the improved smart scoring logic.
     */
    public function scanAllDuplicates(int $userId, ?int $eventId = null): array
    {
        $builder = $this->where('user_id', $userId);
        if (!empty($eventId)) {
            $builder->where('event_id', $eventId);
        }
        
        $guests = $builder->findAll();
        if (count($guests) < 2) return [];

        $results = [];
        $processedIds = [];

        foreach ($guests as $i => $guest) {
            if (in_array($guest['id'], $processedIds)) continue;

            $group = [$guest];
            $processedIds[] = $guest['id'];

            $normName = $this->normalizeText($guest['name']);
            $normPos = $this->normalizeText($guest['position'] ?? '');
            $normAddr = $this->normalizeText($guest['address'] ?? '');
            $sWordsOriginal = explode(' ', $normName);
            $sWordsSorted = $sWordsOriginal;
            sort($sWordsSorted);
            $sWordsSortedStr = implode(' ', $sWordsSorted);

            for ($j = $i + 1; $j < count($guests); $j++) {
                $other = $guests[$j];
                if (in_array($other['id'], $processedIds)) continue;

                $cName = $this->normalizeText($other['name']);
                
                // similarity in percentage
                similar_text($normName, $cName, $namePercent);
                
                $cWordsOriginal = explode(' ', $cName);
                $cWordsSorted = $cWordsOriginal;
                sort($cWordsSorted);
                similar_text($sWordsSortedStr, implode(' ', $cWordsSorted), $nameSortedPercent);
                
                $finalNamePercent = max($namePercent, $nameSortedPercent);
                
                // Hard filtering: name similarity must be >= 85%
                if ($finalNamePercent < 85) continue;
                
                // Ensure at least 1 word matches exactly
                $intersection = array_intersect($sWordsOriginal, $cWordsOriginal);
                if (empty($intersection)) continue;

                $cPos = $this->normalizeText($other['position'] ?? '');
                $cAddr = $this->normalizeText($other['address'] ?? '');

                $posPercent = 0;
                if (empty($normPos) && empty($cPos)) {
                    $posPercent = 100;
                } elseif (!empty($normPos) && !empty($cPos)) {
                    similar_text($normPos, $cPos, $posPercent);
                }

                $addrPercent = 0;
                if (empty($normAddr) && empty($cAddr)) {
                    $addrPercent = 100;
                } elseif (!empty($normAddr) && !empty($cAddr)) {
                    similar_text($normAddr, $cAddr, $addrPercent);
                }

                // Weighted score: name 60%, position 15%, address 25%
                $totalScore = ($finalNamePercent * 0.6) + ($posPercent * 0.15) + ($addrPercent * 0.25);

                if ($totalScore >= 75) {
                    $other['similarity_score'] = round($totalScore, 2);
                    $group[] = $other;
                    $processedIds[] = $other['id'];
                }
            }

            if (count($group) > 1) {
                $results[] = [
                    'name' => $guest['name'],
                    'count' => count($group),
                    'items' => $group
                ];
            }
        }

        return $results;
    }
}
