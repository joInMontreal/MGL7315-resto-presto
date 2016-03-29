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
        <div class="title">Votre réservation est {{ $reservation->getStatusText() }}</div>
        <p><strong>Date :</strong> {{ $reservedAt }}</p>
        <p><strong>Nombre d'invité :</strong> {{ $reservation->nb_invites }}</p>
        <p><strong>Durée :</strong> {{ $reservation->nb_hours }} h</p>
        @if ($reservation->note)
            <p><strong>Note du restaurateur :</strong> {{ $reservation->note }}</p>
        @endif
    </div>
</div>
</body>
</html>
