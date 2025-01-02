<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: montserrat, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px transparent;
        }

        h1 {
            font-size: 24px; /* Adjusted font size */
            margin-bottom: 10px;
        }
        .normal-text {
            font-size: 12px; /* Adjusted font size */
            color: #95a5a6
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px;
        }

        .invoice-table, .invoice-table th, .invoice-table td {
            border: 1px solid #eeeeee;
        }

        .invoice-table th, .invoice-table td {
            padding: 10px;
            text-align: left;
        }

        .invoice-table th {
            background-color: #e0e0e0; /* Header background color */
        }

        .invoice-table tbody tr:nth-child(odd) {
            background-color: #f9f9f9; /* Odd row background color */
        }
    </style>
</head>
<body>

<table style="margin-bottom: 30px">
    <tr>
        <td style="text-align: center; width: 11%">
            @if($company->logo)
                <img src="{{$company->logo}}" alt="Company Logo" style="width: 45px; height: 45px;">
            @endif
            <h6 style="font-size: 12px; color: #95a5a6">{{$company->name}}</h6>
        </td>
        <td style="float: right; text-align: right; width: 80%">
            <h1 style="float: right; text-align: right; color: #747e7f; padding-right: 20px">Liste des employées</h1>
        </td>
    </tr>
</table>
<table style="margin-bottom: 30px">
    <tr>
        <td style="text-align: left;">
            <p class="normal-text"><b>Entreprise: </b> {{$company->name ?? '-'}}</p>
            <p class="normal-text"><b>Phone Number: </b> {{$company->phone ?? '-'}}</p>
            <p class="normal-text"><b>Email: </b> {{$company->email ?? '-'}}</p>
            <p class="normal-text"><b>Address: </b> {{$company->address ?? '-'}}</p>
            @php
                $currentDateTime = now('UTC'); // Get current date and time
                $date = $currentDateTime->toDateString(); // Extract date
                $time = $currentDateTime->toTimeString(); // Extract time
                $previousDate = date('Y-m-d', strtotime('-1 day'));
                $formattedDate = date('d-m-Y')
            @endphp
            <p class="normal-text"><b>Generated In: </b>{{ $formattedDate }} | {{ $time }}</p>
        </td>
        <td style="float: right; text-align: right;">
            <img src="{{'data:image/png;base64,' . DNS2D::getBarcodePNG($company->name, 'QRCODE')}}" alt="QR Code" style="width: 55px; height: 55px; margin-bottom: 5px">
        </td>
    </tr>
</table>

<table class="invoice-table" style="margin-bottom: 30px">
    <thead>
    <tr>
        <th>Nom et prénom</th>
        <th>Téléphone</th>
        <th>Date de recrutement</th>
        <th>Role</th>
        <th>Spécialité</th>
    </tr>
    </thead>
    <tbody>
        @for($i=0; $i<count($employees); $i++)
            <tr>
                <td>{{$employees[$i]->name}}</td>
                <td>{{$employees[$i]->phone_number}}</td>
                <td>{{$employees[$i]->recruitment_date}}</td>
                <td>{{$employees[$i]->role}}</td>
                @if($employees[$i]->specialty)
                    <td>{{$employees[$i]->specialty->name}}</td>
                @else
                    <td>-</td>
                @endif

            </tr>
        @endfor
    </tbody>
</table>

<table>
    <tr>
        <td style="width: 64%;">

        </td>
        <td>
            <p class="normal-text"><b>{{$formattedDate}}</b></p>
            <p class="normal-text"><b>Responsible signature</b></p>
        </td>
    </tr>
</table>

</body>
</html>
