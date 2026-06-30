<?php

$laravelRoot = "c:\\Users\\USER\\Downloads\\Scotiabank-laravel-supabase-main";

// Bootstrap Laravel
require $laravelRoot . '/vendor/autoload.php';
$app = require_once $laravelRoot . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $user = DB::table('usuarios_homebanking')
        ->join('dcliente', 'usuarios_homebanking.pkcliente', '=', 'dcliente.pkcliente')
        ->select('usuarios_homebanking.username', 'usuarios_homebanking.password_hash', 'dcliente.destipodocumentoidentidad', 'dcliente.numerodocumentoidentidad')
        ->first();

    if ($user) {
        echo "Found sample user:\n";
        echo "  - Username (Doc Number): " . $user->username . "\n";
        echo "  - Password Hash/Plain: " . $user->password_hash . "\n";
        echo "  - Doc Type: " . $user->destipodocumentoidentidad . "\n";
        echo "  - Doc Number: " . $user->numerodocumentoidentidad . "\n";
    } else {
        echo "No users found in usuarios_homebanking.\n";
        
        $totalUsers = DB::table('usuarios_homebanking')->count();
        echo "Total in usuarios_homebanking: $totalUsers\n";
        $totalClientes = DB::table('dcliente')->count();
        echo "Total in dcliente: $totalClientes\n";
    }
} catch (\Exception $e) {
    echo "Error querying DB: " . $e->getMessage() . "\n";
}
