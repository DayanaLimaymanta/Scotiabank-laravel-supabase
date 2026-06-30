<?php

$laravelRoot = "c:\\Users\\USER\\Downloads\\Scotiabank-laravel-supabase-main";

require $laravelRoot . '/vendor/autoload.php';
$app = require_once $laravelRoot . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $count = DB::table('dsolicitud')->count();
    echo "Total solicitudes: $count\n";

    if ($count > 0) {
        $first = DB::table('dsolicitud')
            ->join('dcliente', 'dsolicitud.pkcliente', '=', 'dcliente.pkcliente')
            ->select('dsolicitud.*', 'dcliente.nomcliente', 'dcliente.numerodocumentoidentidad')
            ->first();
        echo "Sample solicitud:\n" . json_encode($first) . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
