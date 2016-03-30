@extends('layouts.master')

@section('title', 'Réservation en cours')
@section('menu_reserve', 'class="active"')

@section('content')
    <div class="page-header">
        <h1>Merci de votre réservation</h1>
    </div>
    <p class="lead">Vous recevrez un message ou un courriel du restaurateur pour confirmer votre réservation.</p>
    <h4>Réservation #{{ $reservation->id }}</h4>
    <p><strong>Nom :</strong> {{ $reservation->customer->first_name }} {{ $reservation->customer->last_name }}</p>
    <p><strong>Date :</strong> {{ $reservation->getReservedAtObject()->format('d/m/Y H\hi') }}</p>
    <p><strong>Nombre d'invité :</strong> {{ $reservation->nb_invites }}</p>
    @if ($reservation->occasion)
        <p><strong>Occasion :</strong> {{ $reservation->occasion }}</p>
    @endif
@endsection
