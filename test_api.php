<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$r = Illuminate\Support\Facades\Http::withoutVerifying()->withHeaders(['User-Agent' => 'Mozilla/5.0'])->get('https://dev.disbun.jabarprov.go.id/api/kelompok-tani?start=0&limit=1&nama=darajat');
echo json_encode(['status' => $r->status(), 'json' => $r->json(), 'body' => substr($r->body(), 0, 100)]);
