<?php

namespace App\Console\Commands;

use App\Enums\PosisiEnum;
use App\Services\CapresService;
use Illuminate\Console\Command;

class DataCalon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'capresku';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menampilkan Calon presiden dan wakil presinden 2024';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = 'https://mocki.io/v1/92a1f2ef-bef2-4f84-8f06-1965f0fca1a7';

        $this->info('Calon presiden dan wakil presinden 2024:');

        $calon = CapresService::index($url);

        $capres = CapresService::parseCalon($calon['calon_presiden'], PosisiEnum::PRESIDEN);
        $cawapres = CapresService::parseCalon($calon['calon_wakil_presiden'], PosisiEnum::WAKIL_PRESIDEN);

        $this->info('Calon Presiden:');
        $this->info('--------------------------');
        foreach ($capres as $item) {
            $this->info('Nomor Urut: '.$item->nomor_urut);
            $this->info('Nama Lengkap: '.$item->nama);
            $this->info('Tempat Lahir: '.$item->tempat_lahir);
            $this->info('Tanggal Lahir: '.$item->tanggal_lahir);
            $this->info('Usia: '.$item->usia.' Tahun');
        }

        $this->info('Calon Wakil Presiden:');
        $this->info('----------------------------');
        foreach ($cawapres as $item) {
            $this->info('Nomor Urut: '.$item->nomor_urut);
            $this->info('Nama Lengkap: '.$item->nama);
            $this->info('Tempat Lahir: '.$item->tempat_lahir);
            $this->info('Tanggal Lahir: '.$item->tanggal_lahir);
            $this->info('Usia: '.$item->usia.' Tahun');
            $this->info('----------------------------');
        }
    }
}
