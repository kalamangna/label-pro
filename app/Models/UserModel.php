<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'password', 'role', 'package', 'payment_status', 'payment_proof'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'username' => 'required|min_length[3]|is_unique[users.username,id,{id}]',
        'password' => 'required|min_length[5]',
        'role'     => 'required|in_list[admin,user,demo]',
        'package'  => 'permit_empty|in_list[basic,pro,unlimited]',
    ];

    public static function getPackageLimits(string $package, string $role = 'user'): array
    {
        if ($role === 'admin') {
            return [
                'max_events' => 999999,
                'max_guests' => 999999,
                'name'       => '-',
            ];
        }

        if ($role === 'demo') {
            return [
                'max_events' => 1,
                'max_guests' => 10,
                'name'       => 'Demo',
            ];
        }

        return match ($package) {
            'basic' => [
                'max_events'     => 1,
                'max_guests' => 500,
                'name'           => 'Paket Basic',
            ],
            'pro' => [
                'max_events'     => 10,
                'max_guests' => 5000,
                'name'           => 'Paket Pro',
            ],
            'unlimited' => [
                'max_events'     => 999999,
                'max_guests' => 999999,
                'name'           => 'Paket Unlimited',
            ],
            default => [
                'max_events'     => 0,
                'max_guests' => 0,
                'name'           => 'Tanpa Paket',
            ],
        };
    }
}
