<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * php artisan owner:reset-password
 *
 * The owner can't do a "forgot password" email flow because:
 * 1. We'd need to configure SMTP (complexity for a non-tech owner)
 * 2. There's only one user — the nephew can just run this command
 *
 * A pragmatic tradeoff documented explicitly.
 */
class ResetOwnerPassword extends Command
{
    protected $signature   = 'owner:reset-password {--password= : Provide a password directly}';
    protected $description = 'Reset the restaurant owner\'s password';

    public function handle(): int
    {
        $owner = User::first();

        if (!$owner) {
            $this->error('No owner account found. Run: php artisan db:seed');
            return 1;
        }

        $password = $this->option('password')
            ?? $this->secret('Enter new password (min 8 chars)');

        if (strlen($password) < 8) {
            $this->error('Password must be at least 8 characters.');
            return 1;
        }

        $owner->update(['password' => Hash::make($password)]);

        $this->info("✓ Password updated for: {$owner->email}");
        return 0;
    }
}
