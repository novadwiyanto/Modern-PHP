<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <title>Document</title>
</head>

<body>
    <table>
        <tr>
            @foreach ($capres as $item)
                <th style="text-align: center">
                    <h3>Calon Presiden {{ $item->nomor_urut }}</h3>
                    <p>{{ $item->nama }}</p>
                    <p>{{ $item->tempat_lahir . ", " .  $item->tanggal_lahir }}</p>
                    <p>{{ $item->usia }} Tahun</p>
                    <p style="text-align: left">karir</p>
                    <ul style="text-align: left">
                        @foreach ($item->karir as $itemKarir)
                            <li>{{ $itemKarir->jabatan . ", "
                            . $itemKarir->tahun_mulai . "-" .
                            $itemKarir->tahun_selesai}}</li>
                        @endforeach
                    </ul>
                </th>
            @endforeach
        </tr>
        <tr>
            @foreach ($cawapres as $item)
                <th style="text-align: center">
                    <h3>Calon Wakil Presiden {{ $item->nomor_urut }}</h3>
                    <p>{{ $item->nama }}</p>
                    <p>{{ $item->tempat_lahir . ", " .  $item->tanggal_lahir }}</p>
                    <p>{{ $item->usia }} Tahun</p>
                    <p style="text-align: left">karir</p>
                    <ul style="text-align: left">
                        @foreach ($item->karir as $itemKarir)
                            <li>{{ $itemKarir->jabatan . ", " .
                            $itemKarir->tahun_mulai . "-" .
                            $itemKarir->tahun_selesai}}</li>
                        @endforeach
                    </ul>
                </th>
            @endforeach
        </tr>
    </table>

</body>

</html>
