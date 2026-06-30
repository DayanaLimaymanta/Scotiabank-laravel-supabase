<?php

$filePath = "c:\\Users\\USER\\Downloads\\Scotiabank-laravel-supabase-main\\Base de Datos\\01_DDL_create_tables_banco_andino.sql";

$content = file_get_contents($filePath);
if (substr($content, 0, 2) === "\xff\xfe" || substr($content, 0, 2) === "\xfe\xff") {
    $content = mb_convert_encoding($content, 'UTF-8', 'UTF-16');
}

$lines = explode("\n", $content);
$found = false;
$count = 0;

foreach ($lines as $i => $line) {
    if (preg_match('/CREATE\s+TABLE\s+DCLIENTE/i', $line)) {
        echo "Found DCLIENTE on line " . ($i + 1) . ":\n";
        $found = true;
    }
    if ($found) {
        echo ($i + 1) . ": " . $line . "\n";
        $count++;
        if ($count > 45) {
            break;
        }
    }
}
