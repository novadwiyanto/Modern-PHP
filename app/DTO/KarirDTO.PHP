<?php
declare(strict_types=1);

namespace App\DTO;

class KarirDTO
{
    public function __construct(
        public string $jabatan,
        public int $tahun_mulai,
        public ?int $tahun_selesai,
    ) {}
}

