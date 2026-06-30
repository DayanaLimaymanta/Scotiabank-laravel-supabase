<?php

$laravelRoot = "c:\\Users\\USER\\Downloads\\Scotiabank-laravel-supabase-main";

require $laravelRoot . '/vendor/autoload.php';
$app = require_once $laravelRoot . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $estados = DB::table('dsolicitudestado')->get();
    echo "=== Estados de Solicitud (dsolicitudestado) ===\n";
    foreach ($estados as $e) {
        echo "  - PK: " . $e->pksolicitudestado . " | Cod: " . $e->codsolicitudestado . " | Des: " . $e->dessolicitudestado . "\n";
    }
} catch (\Exception $e) {
    echo "Error querying dsolicititudestado: " . $e->getMessage() . "\n";
}
