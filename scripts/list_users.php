<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$userClass = 'App\\Models\\User';
if (! class_exists($userClass)) {
    echo "USER_MODEL_NOT_FOUND\n";
    exit(2);
}
$users = $userClass::limit(50)->get(['id','email']);
if ($users->isEmpty()) {
    echo "NO_USERS\n";
    exit(0);
}
foreach ($users as $u) {
    echo "id={$u->id};email={$u->email}\n";
}
