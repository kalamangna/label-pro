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
    protected $allowedFields    = ['username', 'password', 'role', 'package'];

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
        'package'  => 'required|in_list[basic,pro,unlimited]',
    ];

    public static function getPackageLimits(string $package, string $role = 'user'): array
    {
        if ($role === 'admin') {
            return [
                'max_projects'   => 999999,
                'max_recipients' => 999999,
                'name'           => 'Administrator',
            ];
        }

        if ($role === 'demo') {
            return [
                'max_projects'   => 1,
                'max_recipients' => 10,
                'name'           => 'Mode Demo',
            ];
        }

        return match ($package) {
            'basic' => [
                'max_projects'   => 1,
                'max_recipients' => 500,
                'name'           => 'Paket Basic',
            ],
            'pro' => [
                'max_projects'   => 10,
                'max_recipients' => 5000,
                'name'           => 'Paket Pro',
            ],
            'unlimited' => [
                'max_projects'   => 999999,
                'max_recipients' => 999999,
                'name'           => 'Paket Unlimited',
            ],
            default => [
                'max_projects'   => 0,
                'max_recipients' => 0,
                'name'           => 'Tanpa Paket',
            ],
        };
    }
}
