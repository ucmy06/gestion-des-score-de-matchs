@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Connexion</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <a class="forgot-password-link" href="{{ route('password.request') }}">
            Mot de passe oublié ?
        </a>
        
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </div>
    </form>
</div>
@endsection
