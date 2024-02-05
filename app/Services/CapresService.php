<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CapresDTO;
use App\DTO\KarirDTO;
use Carbon\Carbon;

class CapresService
{
    public function showService($item, $posisi, $tanggal_lahir, $usia, $karirArr)
    {
        $tempat_lahir = (explode(',', $item['tempat_tanggal_lahir']))[0];

        return new CapresDTO(
            $item['nomor_urut'],
            $item['nama_lengkap'],
            $posisi,
            $tempat_lahir,
            $tanggal_lahir,
            $usia,
            $karirArr,
        );
    }

    public function hitungUmurService(Carbon $data): int
    {
        return Carbon::parseFromLocale($data, 'id')->age;
    }

    public function parseKarirService(string $data)
    {
        $pattern = '/^(.*?)\s*\((\d{4})-(\d{4}|\S+)\)$/';
        $matches = [];

        if (preg_match($pattern, $data, $matches)) {
            return new KarirDTO(
                $matches[1],
                (int) $matches[2],
                $matches[3] === 'Sekarang' ? null : (int) $matches[3],
            );
        }

        return null;
    }
}
