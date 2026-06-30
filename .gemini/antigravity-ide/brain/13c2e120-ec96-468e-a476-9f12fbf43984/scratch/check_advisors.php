<?php

$laravelRoot = "c:\\Users\\USER\\Downloads\\Scotiabank-laravel-supabase-main";

require $laravelRoot . '/vendor/autoload.php';
$app = require_once $laravelRoot . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $asesores = DB::table('dasesor')->take(5)->get();
    echo "=== Sample Advisors (dasesor) ===\n";
    foreach ($asesores as $a) {
        // Let's print all properties dynamically
        echo json_encode($a) . "\n";
    }
    
    $totalAsesores = DB::table('dasesor')->count();
    echo "Total Advisors: $totalAsesores\n";
} catch (\Exception $e) {
    echo "Error querying dasesor: " . $e->getMessage() . "\n";
}

try {
    $agencias = DB::table('dagencia')->take(5)->get();
    echo "\n=== Sample Agencies (dagencia) ===\n";
    foreach ($agencias as $ag) {
        echo json_encode($ag) . "\n";
    }
    
    $totalAgencias = DB::table('dagencia')->count();
    echo "Total Agencies: $totalAgencias\n";
} catch (\Exception $e) {
    echo "Error querying dagencia: " . $e->getMessage() . "\n";
}
