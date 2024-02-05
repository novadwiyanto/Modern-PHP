<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\PosisiEnum;
use App\Services\CapresService;
use Carbon\Carbon;

class CapresController extends Controller
{
    public $capresService;

    public function __construct(CapresService $capresService)
    {
        $this->capresService = $capresService;
    }

    public function show()
    {
        $url = 'https://mocki.io/v1/92a1f2ef-bef2-4f84-8f06-1965f0fca1a7';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 2000);

        $response = curl_exec($ch);

        curl_close($ch);

        $data = json_decode($response, true);

        foreach ($data['calon_presiden'] as $item) {
            $capresDTO[] = $this->parseCalonDTO($item, PosisiEnum::PRESIDEN);
        }

        foreach ($data['calon_wakil_presiden'] as $item) {
            $cawapresDTO[] = $this->parseCalonDTO($item, PosisiEnum::WAKIL_PRESIDEN);
        }

        return view('capres', ['capres' => $capresDTO, 'cawapres' => $cawapresDTO]);

    }

    public function parseTanggalLahir(string $data): Carbon
    {
        return Carbon::parseFromLocale(explode(', ', $data)[1], 'id');
    }

    public function parseKarir(string $data)
    {
        return $this->capresService->parseKarirService($data);
    }

    public function hitungUmur(carbon $data): int
    {
        return $this->capresService->hitungUmurService($data);
    }

    public function parseCalonDTO($item, PosisiEnum $posisi): array
    {
        $tanggal_lahir = $this->parseTanggalLahir($item['tempat_tanggal_lahir']);
        $usia = $this->hitungUmur($this->parseTanggalLahir($item['tempat_tanggal_lahir']));

        $karirArr = [];
        foreach ($item['karir'] as $itemKarir) {
            $karirArr[] = $this->parseKarir($itemKarir);
        }

        $calonDTO[] = $this->capresService->showService($item, $posisi, $tanggal_lahir, $usia, $karirArr);

        return $calonDTO;
    }
}
