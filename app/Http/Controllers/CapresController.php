<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\PosisiEnum;
use App\Services\CapresService;
use Illuminate\View\View;

class CapresController extends Controller
{
    public function show(): View
    {
        $url = 'https://mocki.io/v1/92a1f2ef-bef2-4f84-8f06-1965f0fca1a7';

        $calon = CapresService::index($url);

        $capres = CapresService::parseCalon($calon['calon_presiden'], PosisiEnum::PRESIDEN);
        $cawapres = CapresService::parseCalon($calon['calon_wakil_presiden'], PosisiEnum::WAKIL_PRESIDEN);

        return view('capres', ['capres' => $capres, 'cawapres' => $cawapres]);
    }
}
