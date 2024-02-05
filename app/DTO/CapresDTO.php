<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\PosisiEnum;
use Carbon\Carbon;

class CapresDTO
{
    public function __construct(
        public int $nomor_urut,
        public string $nama,
        public PosisiEnum $posisi,
        public string $tempat_lahir,
        public Carbon $tanggal_lahir,
        public int $usia,
        public array $karir,
    ) {
    }
}
