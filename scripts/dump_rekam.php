<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\RekamMedis;

$id = $argv[1] ?? 11;
$rekam = RekamMedis::with([
    'pet.rasHewan.jenisHewan',
    'pet.pemilik.user',
    'dokterPemeriksa.user',
    'detailRekamMedis.tindakanTerapi',
    'temuDokter.pet.rasHewan.jenisHewan',
    'temuDokter.pet.pemilik.user'
])->find($id);
if (!$rekam) {
    echo "No RekamMedis found with id={$id}\n";
    exit(0);
}

echo json_encode($rekam->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
