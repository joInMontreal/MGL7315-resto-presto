@extends('layouts.master')

@section('title', 'Poster une réservation')
@section('menu_reserve', 'class="active"')

@section('css')
    <link rel="stylesheet" href="/assets/css/vendor/bootstrap-datetimepicker.min.css" />
@endsection

@section('content')
    <div class="jumbotron">
        <h2>Réservez dans votre restaurant favori</h2>
    </div>

    <div class="row marketing">
        <div id="messageBox" class="alert alert-danger hide" role="alert"></div>
        <form class="form-horizontal" id="reserveForm">
            <div class="form-group">
                <label for="input1" class="col-sm-4 control-label">Prénom</label>
                <div class="col-sm-8">
                    <input required name="first_name" type="text" class="form-control" id="input1" placeholder="Prénom">
                </div>
            </div>
            <div class="form-group">
                <label for="input2" class="col-sm-4 control-label">Nom</label>
                <div class="col-sm-8">
                    <input required name="last_name" type="text" class="form-control" id="input2" placeholder="Nom">
                </div>
            </div>
            <div class="form-group">
                <label for="input5" class="col-sm-4 control-label">Téléphone</label>
                <div class="col-sm-8">
                    <input required name="phone" type="text" class="form-control" id="input5" placeholder="Téléphone (ex: 123-123-1234)">
                </div>
            </div>
            <div class="form-group">
                <label for="input6" class="col-sm-4 control-label">Courriel</label>
                <div class="col-sm-8">
                    <input required name="email" type="email" class="form-control" id="input6" placeholder="Courriel">
                </div>
            </div>
            <div class="form-group">
                <label for="input7" class="col-sm-4 control-label">Nombre d'invités</label>
                <div class="col-sm-8">
                    <input required name="nb_invites" type="text" class="form-control" id="input7" placeholder="Nombre d'invités">
                </div>
            </div>
            <div class="form-group">
                <label for="resrvedAt" class="col-sm-4 control-label">Date de réservation</label>
                <div class="col-sm-8">
                    <input required name="reserved_at" type="text" class="form-control" id="resrvedAt" placeholder="Date de réservation">
                </div>
            </div>
            <div class="form-group">
                <label for="input7" class="col-sm-4 control-label">Ocassion</label>
                <div class="col-sm-8">
                    <select name="occasion" class="form-control" id="input7">
                        <option value="">Choisir une option</option>
                        <option value="Diner d'affaire">Diner d'affaire</option>
                        <option value="Anniversaire">Anniversaire</option>
                        <option value="Repas en amoureux">Repas en amoureux</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-8">
                    <button id="reserveBtn" type="submit" class="btn btn-primary">Réserver</button>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('js')
    <script src="/assets/js/vendor/moment.js"></script>
    <script src="/assets/js/vendor/bootstrap-datetimepicker.min.js"></script>
    <script src="/assets/js/reserve.js?v2"></script>
@endsection
