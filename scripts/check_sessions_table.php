<?php
// Check if sessions table exists and print row count.
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $has = Illuminate\Support\Facades\Schema::hasTable('sessions');
    echo ($has ? "YES" : "NO") . PHP_EOL;
    if ($has) {
        $count = Illuminate\Support\Facades\DB::table('sessions')->count();
        echo "COUNT:" . $count . PHP_EOL;
    }
} catch (Throwable $e) {
    echo "EXCEPTION:" . get_class($e) . ":" . $e->getMessage() . PHP_EOL;
    exit(1);
}
