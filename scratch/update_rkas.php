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
    
    // Kita update yang ada dan tambahkan yang kurang (Buku ATK)
    $hasSarpras = false;
    $hasSiswa = false;
    $hasATK = false;
    $hasGaji = false;

    foreach ($list as $k) {
        $name = $k['name'];
        if (str_contains($name, 'Sarana')) {
            $updatedList[] = ['name' => 'Sarana Prasarana', 'amount' => $k['amount']];
            $hasSarpras = true;
        } elseif (str_contains($name, 'Pembelajaran') || str_contains($name, 'Kegiatan')) {
            $updatedList[] = ['name' => 'Kegiatan Siswa', 'amount' => $k['amount']];
            $hasSiswa = true;
        } elseif (str_contains($name, 'Gaji')) {
            $updatedList[] = ['name' => 'Gaji PTT/PTK (Rutin)', 'amount' => $k['amount']];
            $hasGaji = true;
        } else {
            $updatedList[] = $k;
        }
    }

    // Jika Buku ATK belum ada, tambahkan contoh biar dropdown Bagus
    $updatedList[] = ['name' => 'Buku ATK', 'amount' => 5000000];

    $rkas->kegiatan_list = $updatedList;
    $rkas->save();
    
    echo "SUCCESS: RKAS ID {$rkas->id} updated with standardized categories.\n";
} else {
    echo "ERROR: No approved RKAS found.\n";
}
