@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Vérification de l'email</h2>

    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            Un nouveau lien de vérification a été envoyé à votre adresse email.
        </div>
    @endif

    <p>Avant de continuer, veuillez vérifier votre email pour un lien de vérification.</p>
    <p>Si vous n'avez pas reçu l'email</p>
    <form method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Renvoyer le lien de vérification</button>
    </form>
</div>
@endsection
