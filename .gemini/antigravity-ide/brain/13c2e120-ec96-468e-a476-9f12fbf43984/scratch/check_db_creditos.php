<?php

$laravelRoot = "c:\\Users\\USER\\Downloads\\Scotiabank-laravel-supabase-main";

require $laravelRoot . '/vendor/autoload.php';
$app = require_once $laravelRoot . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $countD = DB::table('dcuentacredito')->count();
    echo "Total dcuentacredito: $countD\n";
    if ($countD > 0) {
        $first = DB::table('dcuentacredito')->first();
        echo "Sample dcuentacredito:\n" . json_encode($first) . "\n";
    }
} catch (\Exception $e) {
    echo "Error querying dcuentacredito: " . $e->getMessage() . "\n";
}

try {
    $countF = DB::table('fagcuentacredito')->count();
    echo "Total fagcuentacredito: $countF\n";
    if ($countF > 0) {
        $first = DB::table('fagcuentacredito')->first();
        echo "Sample fagcuentacredito:\n" . json_encode($first) . "\n";
    }
} catch (\Exception $e) {
    echo "Error querying fagcuentacredito: " . $e->getMessage() . "\n";
}
