<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        p {
            text-align: center;
        }
    </style>
    <title>Document</title>
</head>

<body class="mt-5">
    @foreach ($capres as $itemP)
        @foreach ($cawapres as $itemW)
            @if ($itemP[0]->nomor_urut === $itemW[0]->nomor_urut)
                <h4 style="text-align: center">{{ $itemP[0]->nomor_urut }}</h4>
                <div class="row m-5 mt-0">
                    <div class="col" style="border: 1px solid">
                        <p> {{ $itemP[0]->nama }} </p>
                        <p> {{ $itemP[0]->tempat_lahir . ', ' . $itemP[0]->tanggal_lahir }} </p>
                        <p> {{ $itemP[0]->usia . ' Tahun' }} </p>
                        <h6>Karir :</h6>
                        @foreach ($itemP[0]->karir as $itemKarir)
                            @if (!empty($itemKarir))
                                @if ($itemKarir->tahun_selesai === 0)
                                    <p style="text-align: left">
                                        {{ $itemKarir->jabatan . ' ' . $itemKarir->tahun_mulai . '-' . 'Sekarang' }}
                                    </p>
                                @else
                                    <p style="text-align: left">
                                        {{ $itemKarir->jabatan . ' ' . $itemKarir->tahun_mulai . '-' . $itemKarir->tahun_selesai }}
                                    </p>
                                @endif
                            @endif
                        @endforeach
                    </div>
                    <div class="col" style="border: 1px solid">
                        <p> {{ $itemW[0]->nama }} </p>
                        <p> {{ $itemW[0]->tempat_lahir . ', ' . $itemW[0]->tanggal_lahir }} </p>
                        <p> {{ $itemW[0]->usia . ' Tahun' }} </p>
                        <h6>Karir :</h6>
                        @foreach ($itemW[0]->karir as $itemKarir)
                            @if (!empty($itemKarir))
                                <p style="text-align: left">
                                    {{ $itemKarir->jabatan . ' ' . $itemKarir->tahun_mulai . '-' . $itemKarir->tahun_selesai }}
                                </p>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach


</body>

</html>
