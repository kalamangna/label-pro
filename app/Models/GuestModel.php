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
    protected $allowedFields    = [
        'name',
        'position',
        'address',
        'user_id',
        'event_id',
        'is_printed',
        'is_selected',
        'ignore_duplicate'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'is_printed'       => 'integer',
        'is_selected'      => 'integer',
        'ignore_duplicate' => 'integer',
        'event_id'         => 'integer',
        'user_id'          => 'integer',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
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
    protected $afterDelete    = [];

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
                '/\bmoh\b/'      => 'muhammad',
                '/\bdrs\b/'      => '',
                '/\bdra\b/'      => '',
                '/\bir\b/'       => '',
                '/\bhj\b/'       => '',
                '/\bh\b/'        => '',
                '/\bprof\b/'     => '',
                '/\bdr\b/'       => '',
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
        
        $builder = $this->where('user_id', $userId)
                        ->where('ignore_duplicate', 0);
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
        $builder = $this->where('user_id', $userId)
                        ->where('ignore_duplicate', 0);
        if (!empty($eventId)) {
            $builder->where('event_id', $eventId);
        }
        
        $guests = $builder->findAll();
        if (count($guests) < 2) return [];

        // Pre-process all guests for performance
        foreach ($guests as &$g) {
            $g['norm_name'] = $this->normalizeText($g['name']);
            $g['norm_pos']  = $this->normalizeText($g['position'] ?? '');
            $g['norm_addr'] = $this->normalizeText($g['address'] ?? '');
            
            $words = explode(' ', $g['norm_name']);
            $g['words'] = $words;
            sort($words);
            $g['norm_name_sorted'] = implode(' ', $words);
        }
        unset($g);

        $results = [];
        $processedIds = [];

        for ($i = 0; $i < count($guests); $i++) {
            $guest = $guests[$i];
            if (in_array($guest['id'], $processedIds)) continue;

            $group = [$guest];
            $processedIds[] = $guest['id'];

            for ($j = $i + 1; $j < count($guests); $j++) {
                $other = $guests[$j];
                if (in_array($other['id'], $processedIds)) continue;

                // Name similarity
                similar_text($guest['norm_name'], $other['norm_name'], $namePercent);
                similar_text($guest['norm_name_sorted'], $other['norm_name_sorted'], $nameSortedPercent);
                
                $finalNamePercent = max($namePercent, $nameSortedPercent);
                
                // Hard filtering: name similarity must be >= 85%
                if ($finalNamePercent < 85) continue;
                
                // Ensure at least 1 word matches exactly
                $intersection = array_intersect($guest['words'], $other['words']);
                if (empty($intersection)) continue;

                // Position similarity
                $posPercent = 0;
                if (empty($guest['norm_pos']) && empty($other['norm_pos'])) {
                    $posPercent = 100;
                } elseif (!empty($guest['norm_pos']) && !empty($other['norm_pos'])) {
                    similar_text($guest['norm_pos'], $other['norm_pos'], $posPercent);
                }

                // Address similarity
                $addrPercent = 0;
                if (empty($guest['norm_addr']) && empty($other['norm_addr'])) {
                    $addrPercent = 100;
                } elseif (!empty($guest['norm_addr']) && !empty($other['norm_addr'])) {
                    similar_text($guest['norm_addr'], $other['norm_addr'], $addrPercent);
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
