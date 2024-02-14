<?php

use App\DTO\CapresDTO;
use App\Enums\PosisiEnum;

uses(Tests\TestCase::class);
use App\Services\CapresService;

const BIRTH_DATE_PLACE = 'Kuningan, 7 Mei 1969';

it('displays the correct view with capres and cawapres data', function () {
    $response = $this->get('/');

    $response->assertViewIs('capres');
    $response->assertViewHas('capres');
    $response->assertViewHas('cawapres');

    $capresData = $response->viewData('capres');
    expect($capresData)->toBeArray();
});

it('Fetch data', function () {
    $url = 'https://mocki.io/v1/92a1f2ef-bef2-4f84-8f06-1965f0fca1a7';
    $data = CapresService::index($url);

    expect($data)->toBeArray();
    test()->sharedVariable = $data;
});

it('Index', function () {
    $url = 'https://mocki.io/v1/92a1f2ef-bef2-4f84-8f06-1965f0fca1a7';
    $response = CapresService::index($url);

    expect($response)->toBeArray();
    expect($response['calon_presiden'])->toBeArray();
    expect($response['calon_wakil_presiden'])->toBeArray();
    $this->assertLessThan($response['calon_presiden'][1]['nomor_urut'], $response['calon_presiden'][0]['nomor_urut']);
    $this->assertLessThan($response['calon_wakil_presiden'][1]['nomor_urut'],
        $response['calon_wakil_presiden'][0]['nomor_urut']);
});

it('mengurai data calon dan mengembalikan array CapresDTO dengan benar', function () {
    $dataInput = [
        [
            'nomor_urut' => 1,
            'nama_lengkap' => 'Anies Rasyid Baswedan',
            'tempat_tanggal_lahir' => 'Kuningan, 7 Mei 1969',
            'karir' => [
                'Rektor Universitas Paramadina (2007-2013)',
                'Menteri Pendidikan dan Kebudayaan (2014-2016)',
                'Gubernur DKI Jakarta (2017-2022)',
            ],
        ],
        [
            'nomor_urut' => 3,
            'nama_lengkap' => 'Ganjar Pranowo',
            'tempat_tanggal_lahir' => 'Karang Anyar, 28 Oktober 1968',
            'karir' => [
                'Anggota DPR RI Fraksi PDI Perjuangan (2004-2009 dan 2009-2013)',
                'Gubernur Jawa Tengah(2013-2023)',
            ],
        ],
        [
            'nomor_urut' => 2,
            'nama_lengkap' => 'Prabowo Subianto Djojohadikusumo',
            'tempat_tanggal_lahir' => 'Jakarta, 17 Oktober 1951',
            'karir' => [
                'Panglima Komando Cadangan Strategi TNI Angkatan Darat (1998)',
                'Ketua Umum Partai Gerindra (2014-Sekarang)',
                'Menteri Pertahanan (2019-2024)',
            ],
        ],
    ];

    $hasil = CapresService::parseCalon($dataInput, PosisiEnum::PRESIDEN);

    expect($hasil)->toBeArray()->and($hasil)->toHaveCount(3);
    foreach ($hasil as $item) {
        expect($item)->toBeInstanceOf(CapresDTO::class);
        expect($item->posisi)->toEqual(PosisiEnum::PRESIDEN);
    }
});
it('Tanggal Lahir', function () {
    $birthDate = CapresService::tanggalLahir(BIRTH_DATE_PLACE);

    expect($birthDate)->toBeInstanceOf(\Carbon\Carbon::class);
    expect($birthDate->toDateString())->toBe('1969-05-07');
});

it('Umur', function () {
    $tanggalLahir = \Carbon\Carbon::parse('1969-05-07');
    $age = CapresService::umur($tanggalLahir);

    expect($age)->toBe(\Carbon\Carbon::parse(54)->age);
});

it('Karir', function () {
    $careers = [
        'Job A (2010-2015)',
        'Job B (2015-2020)',
        'Job C (2020-Sekarang)',
    ];

    $parsedCareers = CapresService::karir($careers);

    expect($parsedCareers)->toBeArray();
    expect(count($parsedCareers))->toBe(3);
});
