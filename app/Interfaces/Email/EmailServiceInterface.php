<?php
namespace App\Interfaces\Email;

use App\Models\User;

interface EmailServiceInterface
{
    public function sendWelcomeEmail(User $user);
}
