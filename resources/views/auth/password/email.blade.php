@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Réinitialiser le mot de passe</h2>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer le lien de réinitialisation</button>
    </form>
</div>
@endsection
