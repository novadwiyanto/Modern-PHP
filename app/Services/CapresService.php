<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CapresDTO;
use App\DTO\KarirDTO;
use App\Enums\PosisiEnum;
use Carbon\Carbon;

class CapresService
{
    public static function index(string $url): array
    {
        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 2000);

            $response = curl_exec($ch);
            curl_close($ch);

            $data = json_decode($response, true);

            usort($data['calon_presiden'], function (array $a, array $b) {
                return $a['nomor_urut'] - $b['nomor_urut'];
            });

            usort($data['calon_wakil_presiden'], function (array $a, array $b) {
                return $a['nomor_urut'] - $b['nomor_urut'];
            });

            return $data;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function parseCalon(array $data, PosisiEnum $posisi): array
    {
        foreach ($data as $item) {
            $calon[] = self::calonDTO($item, $posisi);
        }

        return $calon;
    }

    public static function calonDTO(array $data, PosisiEnum $posisi): CapresDTO
    {
        $tempat_lahir = explode(', ', $data['tempat_tanggal_lahir'])[0];
        $tanggal_lahir = self::tanggalLahir($data['tempat_tanggal_lahir']);
        $umur = self::umur($tanggal_lahir);

        $karir = self::karir($data['karir']);

        return new CapresDTO(
            $data['nomor_urut'],
            $data['nama_lengkap'],
            $posisi,
            $tempat_lahir,
            $tanggal_lahir,
            $umur,
            $karir,
        );
    }

    public static function tanggalLahir(string $data): Carbon
    {
        return Carbon::parseFromLocale(explode(', ', $data)[1], 'id');
    }

    public static function umur(Carbon $data): int
    {
        return Carbon::parseFromLocale($data, 'id')->age;
    }

    public static function karir(array $data): array
    {
        foreach ($data as $item) {

            $pattern = '/^(.*?)\s*\((\d{4})-(\d{4}|\S+)\)$/';
            if (preg_match($pattern, $item, $matches)) {
                $karir[] = new KarirDTO(
                    $matches[1],
                    (int) $matches[2],
                    $matches[3] === null ? null : (int) $matches[3],
                );
            }

        }

        return $karir;
    }
}
