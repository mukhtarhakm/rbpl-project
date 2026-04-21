<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\RKAS;

$rkas = RKAS::where('status', 'disetujui')->latest()->first();

if ($rkas) {
    $list = $rkas->kegiatan_list;
    $updatedList = [];
    
    foreach ($list as $k) {
        $name = $k['name'];
        if (str_contains($name, 'Sarana')) {
            $updatedList[] = ['name' => 'Sarana Prasarana', 'amount' => $k['amount']];
        } elseif (str_contains($name, 'Pembelajaran') || str_contains($name, 'Kegiatan')) {
            $updatedList[] = ['name' => 'Kegiatan Siswa', 'amount' => $k['amount']];
        } elseif (str_contains($name, 'Gaji')) {
            $updatedList[] = ['name' => 'Gaji PTT/PTK (Rutin)', 'amount' => $k['amount']];
        } else {
            $updatedList[] = $k;
        }
    }

    // Pastikan Buku ATK ada
    $hasATK = false;
    foreach($updatedList as $k) { if($k['name'] == 'Buku ATK') $hasATK = true; }
    if (!$hasATK) {
        $updatedList[] = ['name' => 'Buku ATK', 'amount' => 5000000];
    }

    $rkas->kegiatan_list = $updatedList;
    $rkas->save();
    
    echo "SUCCESS: RKAS ID {$rkas->id} updated.\n";
} else {
    echo "ERROR: No approved RKAS found.\n";
}
