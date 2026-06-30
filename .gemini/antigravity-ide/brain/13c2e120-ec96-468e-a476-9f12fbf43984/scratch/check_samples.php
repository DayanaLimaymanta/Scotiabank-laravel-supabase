<?php

$laravelRoot = "c:\\Users\\USER\\Downloads\\Scotiabank-laravel-supabase-main";

require $laravelRoot . '/vendor/autoload.php';
$app = require_once $laravelRoot . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $clientes = DB::table('dcliente')
        ->select('nomcliente', 'destipodocumentoidentidad', 'numerodocumentoidentidad')
        ->orderBy('pkcliente', 'asc')
        ->take(3)
        ->get();

    echo "=== Sample Clients for Testing ===\n";
    foreach ($clientes as $index => $c) {
        echo "Client #" . ($index + 1) . ":\n";
        echo "  - Nombre: " . $c->nomcliente . "\n";
        echo "  - Tipo Documento: " . $c->destipodocumentoidentidad . "\n";
        echo "  - Nro Documento: " . $c->numerodocumentoidentidad . "\n\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
