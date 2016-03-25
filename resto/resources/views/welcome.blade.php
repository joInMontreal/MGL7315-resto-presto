@extends('layouts.master')

@section('title', 'Acceuil')

@section('menu_home', 'class="active"')

@section('content')
    <h3>Les utilisateurs :</h3>
    @foreach ($users as $user)
        <p>{{ $user->name }}</p>
    @endforeach
@endsection
