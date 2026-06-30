<?php

$laravelRoot = "c:\\Users\\USER\\Downloads\\Scotiabank-laravel-supabase-main";

require $laravelRoot . '/vendor/autoload.php';
$app = require_once $laravelRoot . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $estados = DB::table('dsolicitudoestado')->get();
    echo "=== Estados de Solicitud (dsolicitudoestado) ===\n";
    foreach ($estados as $e) {
        echo "  - PK: " . $e->pksolicitudestado . " | Cod: " . $e->codsolicitudestado . " | Des: " . $e->dessolicitudestado . "\n";
    }
} catch (\Exception $e) {
    echo "Error querying dsolicitudoestado: " . $e->getMessage() . "\n";
}

try {
    $situaciones = DB::table('dsolicitudsituacion')->get();
    echo "\n=== Situaciones de Solicitud (dsolicitudsituacion) ===\n";
    foreach ($situaciones as $s) {
        echo "  - PK: " . $s->pksolicitudsituacion . " | Cod: " . $s->codsolicitudsituacion . " | Des: " . $s->dessolicitudsituacion . "\n";
    }
} catch (\Exception $e) {
    echo "Error querying dsolicititudsituacion: " . $e->getMessage() . "\n";
}

try {
    $monedas = DB::table('dmoneda')->get();
    echo "\n=== Monedas (dmoneda) ===\n";
    foreach ($monedas as $m) {
        echo "  - PK: " . $m->pkmoneda . " | Cod: " . $m->codmoneda . " | Des: " . $m->desmoneda . "\n";
    }
} catch (\Exception $e) {
    echo "Error querying dmoneda: " . $e->getMessage() . "\n";
}

try {
    $productos = DB::table('dproducto')->get();
    echo "\n=== Productos (dproducto) ===\n";
    foreach ($productos as $p) {
        echo "  - PK: " . $p->pkproducto . " | Cod: " . $p->codproducto . " | Des: " . $p->desproducto . "\n";
    }
} catch (\Exception $e) {
    echo "Error querying dproducto: " . $e->getMessage() . "\n";
}
