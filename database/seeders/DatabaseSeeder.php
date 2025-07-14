<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create regular user
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create sample tasks
        Task::create([
            'title' => 'Setup Development Environment',
            'description' => 'Install and configure all necessary development tools',
            'status' => 'pending',
            'deadline' => now()->addDays(3),
            'assigned_to' => $user->id,
            'created_by' => $admin->id,
        ]);

        Task::create([
            'title' => 'Design Database Schema',
            'description' => 'Create the database schema for the task management system',
            'status' => 'in_progress',
            'deadline' => now()->addDays(5),
            'assigned_to' => $user->id,
            'created_by' => $admin->id,
        ]);

        Task::create([
            'title' => 'Implement User Authentication',
            'description' => 'Build login and registration functionality',
            'status' => 'completed',
            'deadline' => now()->addDays(7),
            'assigned_to' => $user->id,
            'created_by' => $admin->id,
        ]);
    }
}
