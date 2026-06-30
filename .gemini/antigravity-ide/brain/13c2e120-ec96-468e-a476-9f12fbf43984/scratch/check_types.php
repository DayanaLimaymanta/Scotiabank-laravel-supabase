<?php

$laravelRoot = "c:\\Users\\USER\\Downloads\\Scotiabank-laravel-supabase-main";

require $laravelRoot . '/vendor/autoload.php';
$app = require_once $laravelRoot . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $count = DB::table('dtipocuentaahorro')->count();
    echo "Total dtipocuentaahorro: $count\n";
    if ($count > 0) {
        $types = DB::table('dtipocuentaahorro')->get();
        foreach ($types as $t) {
            echo "  - PK: " . $t->pktipocuentaahorro . " | Cod: " . $t->codtipocuentaahorro . " | Des: " . $t->destipocuentaahorro . "\n";
        }
    }
} catch (\Exception $e) {
    echo "Error querying dtipocuentaahorro: " . $e->getMessage() . "\n";
}
