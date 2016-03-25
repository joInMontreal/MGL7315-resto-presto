@extends('layouts.master')

@section('title', 'Poster une réservation')
@section('menu_reserve', 'class="active"')

@section('content')
    <div class="jumbotron">
        <h2>Réservez dans votre restaurant favoris</h2>
        <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
    </div>

    <div class="row marketing">
        <form class="form-horizontal" id="reserveForm">
            <div class="form-group">
                <label for="input1" class="col-sm-2 control-label">Prénom</label>
                <div class="col-sm-10">
                    <input name="first_name" type="text" class="form-control" id="input1" placeholder="Prénom">
                </div>
            </div>
            <div class="form-group">
                <label for="input2" class="col-sm-2 control-label">Nom</label>
                <div class="col-sm-10">
                    <input name="last_name" type="text" class="form-control" id="input2" placeholder="Nom">
                </div>
            </div>
            <div class="form-group">
                <label for="input3" class="col-sm-2 control-label">Adresse</label>
                <div class="col-sm-10">
                    <input name="address" type="text" class="form-control" id="input3" placeholder="Adresse">
                </div>
            </div>
            <div class="form-group">
                <label for="input4" class="col-sm-2 control-label">Ville</label>
                <div class="col-sm-10">
                    <input name="city" type="text" class="form-control" id="input4" placeholder="Ville">
                </div>
            </div>
            <div class="form-group">
                <label for="input5" class="col-sm-2 control-label">Téléphone</label>
                <div class="col-sm-10">
                    <input name="phone" type="text" class="form-control" id="input5" placeholder="Téléphone">
                </div>
            </div>
            <div class="form-group">
                <label for="input6" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input name="email" type="email" class="form-control" id="input6" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <label for="input7" class="col-sm-2 control-label">Nombre d'invités</label>
                <div class="col-sm-10">
                    <input name="nb_invites" type="text" class="form-control" id="input7" placeholder="Nombre d'invités">
                </div>
            </div>
            <div class="form-group">
                <label for="input8" class="col-sm-2 control-label">Date de réservation</label>
                <div class="col-sm-10">
                    <input name="reserved_at" type="text" class="form-control" id="input8" placeholder="Date de réservation">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button id="reserveBtn" type="submit" class="btn btn-default">Réserver</button>
                </div>
            </div>
        </form>
    </div>


@endsection

@section('js')
    <script src="/assets/js/reserve.js"></script>
@endsection
