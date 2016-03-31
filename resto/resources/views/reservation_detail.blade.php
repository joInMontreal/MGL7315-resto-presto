@extends('layouts.master')

@section('title', 'Réservation en cours')
@section('menu_reserve', 'class="active"')

@section('content')
    <div class="page-header">
        <h1>Réservation #{{ $reservation->id }}</h1>
    </div>
    <p class="col-sm-offset-2 lead">
        <strong>Nom :</strong> {{ $reservation->customer->first_name }} {{ $reservation->customer->last_name }}<br />
        <strong>Date :</strong> {{ $reservation->getReservedAtObject()->format('d/m/Y H\hi') }}<br />
        <strong>Nombre d'invité :</strong> {{ $reservation->nb_invites }}<br />
        <strong>Créée à :</strong> {{ $reservation->getCreatedAtObject()->format('d/m/Y H\hi') }}<br />
        @if ($reservation->occasion)
            <strong>Occasion :</strong> {{ $reservation->occasion }}<br />
        @endif
    </p>
    <div class="row marketing">
        <div id="messageBox" class="alert alert-danger hide" role="alert"></div>
        <form class="form-horizontal" id="confirmForm">
            <input id="reservationId" name="reservation_id" type="hidden" value="{{ $reservation->id }}">
            <div id="messageBox" class="alert alert-danger hide" role="alert"></div>
            <div class="form-group">
                <label for="input1" class="col-sm-2 control-label">Durée (H)</label>
                <div class="col-sm-10">
                    <input required name="nb_hours" type="text" class="form-control" id="input1" value="{{ $reservation->nb_hours }}">
                </div>
            </div>
            <div class="form-group" >
                <label for="input2" class="col-sm-2 control-label">Statut</label>
                <div class="col-sm-10 btn-group" data-toggle="buttons">
                    <label class="btn btn-default {{ ($statusAccepted == $reservation->status) ? 'active' : '' }}">
                        <input type="radio" name="status" id="optionsRadios2" value="{{ $statusAccepted }}" {{ ($statusAccepted == $reservation->status) ? 'checked' : '' }}> Accepté
                    </label>
                    <label class="btn btn-default {{ ($statusRefused == $reservation->status) ? 'active' : '' }}">
                        <input type="radio" name="status" id="optionsRadios3" value="{{ $statusRefused }}" {{ ($statusRefused == $reservation->status) ? 'checked' : '' }}> Refusé
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="input3" class="col-sm-2 control-label">Note</label>
                <div class="col-sm-10">
                    <textarea placeholder="Note..." class="form-control" rows="3" name="note">{{ $reservation->note }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button id="confirmBtn" type="submit" class="btn btn-default">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script src="/assets/js/confirm.js?v2"></script>
@endsection
