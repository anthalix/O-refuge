@extends('layouts.app')

@section('content')

<h1 class="site">Connection</h1>

<form action="{{ route('Send-login') }}" method="POST" class="mt-5">
    @csrf
    <div class="mb-3">
        <label for="email" :value="__('Email')" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Veuillez saisir votre adresse mail" :value="old('email')" required>
    </div><br>
    <div class="mb-3">
        <label for="password" :value="__('Password')" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Veuillez saisir votre mot de passe" value="" autocomplete="current-password">
    </div>

    <button type="submit" class="btn btn-primary">Se connecter</button>

</form>



<style>
    .btn {
        font-size: 1.5rem;
        margin-top: 20px;


    }
</style>
@endsection