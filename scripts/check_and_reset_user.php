<?php
// Script to check for a user by email and optionally reset password.
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Hash;

$email = $argv[1] ?? 'admin@gmail.com';
$newPass = $argv[2] ?? null;

try {
    $userClass = 'App\\Models\\User';
    if (!class_exists($userClass)) {
        echo "USER_MODEL_NOT_FOUND\n";
        exit(2);
    }
    $u = $userClass::where('email', $email)->first();
    if (! $u) {
        echo "NO_USER\n";
        exit(0);
    }
    echo "FOUND:id={$u->id};email={$u->email};password_hash={$u->password}\n";
    if ($newPass) {
        $u->password = Hash::make($newPass);
        $u->save();
        echo "PASSWORD_RESET\n";
    }
    exit(0);
} catch (Throwable $e) {
    echo "EXCEPTION:" . get_class($e) . ":" . $e->getMessage() . "\n";
    exit(3);
}
