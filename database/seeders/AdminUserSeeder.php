<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->warn(PHP_EOL . 'Creating admin user...');

        $email = $this->command->ask('Admin email', 'admin@example.com');
        $name = $this->command->ask('Admin name', 'Administrator');
        $password = $this->command->ask('Admin pass', '*Ah5cE#jw8F!2u+6Ab');

        if (empty($password) === false || strlen($password) < 12) {
            // Interactive fallback only if no valid env password present
            $password = $this->secret('Admin password (min 12 chars, will not be shown)');
            while (is_string($password) === false || strlen($password) < 12) {
                $this->command->error('Password must be at least 12 characters.');
                $password = $this->secret('Admin password (min 12 chars, will not be shown)');
            }
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]
        );

        // Ensure super_admin role exists
        $role = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        if ($user->hasRole($role) === false) {
            $user->assignRole($role);
        }

        $this->command->info('Admin user ready: ' . $user->email);
    }

    protected function secret(string $question): ?string
    {
        // Fallback for environments without hidden input support.
        try {
            return $this->command->secret($question);
        } catch (\Throwable $e) {
            return $this->command->ask($question);
        }
    }
}
