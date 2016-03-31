@extends('layouts.master')

@section('css')
@endsection

@section('title', 'Gestion des réservations')
@section('menu_upcoming', 'class="active"')

@section('content')
	<div class="jumbotron">
		<h2>Liste des réservations</h2>
	</div>

    <div class="container">
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Periode</th>
				<th>Time</th>
				<th>Name</th>
				<th>Nb places</th>
				<th>Status</th>
				<th>Occasion</th>
				<th>Note</th>
			</tr>
		</thead>
		<tbody>
		@foreach($reservations as $reservation)
			<tr>
				<td>{{ $reservation->getPeriod() }}</td>
				<td>{{ $reservation->getTime() }}</td>
				<td>{{ $reservation->customer->first_name }} {{ $reservation->customer->last_name }}</td>
				<td>{{ $reservation->nb_invites }}</td>
				<td>{{ $reservation->getStatusText() }}</td>
				<td>{{ $reservation->occasion }}</td>
				<td>{{ $reservation->note }}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
    </div>

@endsection

@section('js')
@endsection
