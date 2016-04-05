@extends('layouts.master')

@section('css')
	<link rel="stylesheet" type="text/css" href="/assets/css/tblsort.css">
@endsection

@section('title', 'Gestion des demandes de réservations')
@section('menu_requests', 'class="active"')

@section('content')
	<div class="jumbotron">
		<h2>Demandes de réservation</h2>
	</div>

    <div class="container">
	<div>
		<label for="input7" class="col-sm-4" style="text-align:right; margin-top:4px;">Status</label>
		<div class="col-sm-8">
			<select name="statusFilter" class="form-control" id="statusFilter">
				<option value="-1" @if($currStatus==-1) selected @endif>Tous</option>
				<option value="1" @if($currStatus==1) selected @endif>Acceptée</option>
				<option value="2" @if($currStatus==2) selected @endif>Refusée</option>
				<option value="0" @if($currStatus==0) selected @endif>En attente</option>
			</select>
		</div>
	</div>

	<table id="tbl" class="table table-condensed">
		<thead>
			<tr>
				<th class='sortable @if($orderCriteria == "Periode") @if($order == "asc") sortdown @else sortup @endif @else sortboth @endif'>Période</th>
				<th class='sortable @if($orderCriteria == "Time") @if($order == "asc") sortdown @else sortup @endif @else sortboth @endif'>Heure</th>
				<th>Nom</th>
				<th class='sortable @if($orderCriteria == "Nb places") @if($order == "asc") sortdown @else sortup @endif @else sortboth @endif'>Nb places</th>
				<th>Status</th>
				<th>Occasion</th>
				<th>Note</th>
			</tr>
		</thead>
		<tbody>
		@foreach($reservations as $reservation)
			<tr>
				<td><a href="/reservation/{{ $reservation->id }}/detail">{{ $reservation->getPeriod() }}</a></td>
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
    <script src="/assets/js/gestion.js"></script>
    <script src="/assets/js/jquery.tablesorter.min.js"></script>
@endsection
