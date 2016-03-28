<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }
        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }
        .content {
            text-align: center;
            display: inline-block;
        }
        .title {
            font-size: 34px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">Nouvelle réservation #{{ $reservation->id }}</div>
        <p><strong>Nom :</strong> {{ $reservation->customer->first_name }} {{ $reservation->customer->last_name }}</p>
        <p><strong>Date :</strong> {{ $reservedAt }}</p>
        <p><strong>Nombre d'invité :</strong> {{ $reservation->nb_invites }}</p>
        @if ($reservation->occasion)
            <p><strong>Occasion :</strong> {{ $reservation->occasion }}</p>
        @endif
        <p>
            <strong>
                <a href="http://{{ $baseUrl }}/reservation/{{ $reservation->id }}/detail">
                    Voir les détails pour confrimer
                </a>
            </strong>
        </p>
    </div>
</div>
</body>
</html>
