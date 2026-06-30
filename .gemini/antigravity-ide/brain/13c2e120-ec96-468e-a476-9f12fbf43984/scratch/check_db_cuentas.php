<?php

$laravelRoot = "c:\\Users\\USER\\Downloads\\Scotiabank-laravel-supabase-main";

require $laravelRoot . '/vendor/autoload.php';
$app = require_once $laravelRoot . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $countD = DB::table('dcuentaahorro')->count();
    echo "Total dcuentaahorro: $countD\n";
    if ($countD > 0) {
        $first = DB::table('dcuentaahorro')->first();
        echo "Sample dcuentaahorro:\n" . json_encode($first) . "\n";
    }
} catch (\Exception $e) {
    echo "Error querying dcuentaahorro: " . $e->getMessage() . "\n";
}

try {
    $countF = DB::table('fcuentaahorro')->count();
    echo "Total fcuentaahorro: $countF\n";
    if ($countF > 0) {
        $first = DB::table('fcuentaahorro')->first();
        echo "Sample fcuentaahorro:\n" . json_encode($first) . "\n";
    }
} catch (\Exception $e) {
    echo "Error querying fcuentaahorro: " . $e->getMessage() . "\n";
}
