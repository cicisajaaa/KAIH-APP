<?php
// Create a user with given email and password. Usage: php create_user.php email password
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Hash;

$email = $argv[1] ?? null;
$pass = $argv[2] ?? null;
if (! $email || ! $pass) {
    echo "USAGE: php create_user.php email password\n";
    exit(2);
}

try {
    $userClass = 'App\\Models\\User';
    if (! class_exists($userClass)) {
        echo "USER_MODEL_NOT_FOUND\n";
        exit(3);
    }
    $exists = $userClass::where('email', $email)->first();
    if ($exists) {
        echo "ALREADY_EXISTS:id={$exists->id};email={$exists->email}\n";
        exit(0);
    }
    $u = new $userClass();
    if (property_exists($u, 'name') || array_key_exists('name', $u->getAttributes())) {
        $u->name = 'Admin';
    } else {
        // best-effort: set name if attribute exists
        try { $u->name = 'Admin'; } catch (Throwable $e) {}
    }
    $u->email = $email;
    $u->password = Hash::make($pass);
    // mark email verified if column exists
    try { $u->email_verified_at = now(); } catch (Throwable $e) {}
    $u->save();
    echo "CREATED:id={$u->id};email={$u->email}\n";
    exit(0);
} catch (Throwable $e) {
    echo "EXCEPTION:" . get_class($e) . ":" . $e->getMessage() . "\n";
    exit(4);
}
