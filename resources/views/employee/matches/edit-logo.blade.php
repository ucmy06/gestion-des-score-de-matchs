@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier les Logos et Noms des Équipes</h1>

    <form action="{{ route('employee.matches.updateLogo', $match->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Nom Équipe Gauche -->
        <div class="form-group">
            <label for="team1_name">Nom Équipe Gauche</label>
            <input type="text" id="team1_name" name="team1_name" class="form-control" value="{{ old('team1_name', $match->team1->name) }}">
        </div>

        <!-- Logo Équipe Gauche -->
        <div class="form-group">
            <label for="logo_equipe_gauche">Logo Équipe Gauche</label>
            <input type="file" id="logo_equipe_gauche" name="logo_equipe_gauche" class="form-control" accept="image/*" onchange="loadLogoGauche()">
            <img id="af_logo_gauche" src="{{ asset('storage/' . $match->team1->logo_path) }}" alt="Logo Gauche" style="max-height: 200px;">
        </div>

        <!-- Nom Équipe Droite -->
        <div class="form-group">
            <label for="team2_name">Nom Équipe Droite</label>
            <input type="text" id="team2_name" name="team2_name" class="form-control" value="{{ old('team2_name', $match->team2->name) }}">
        </div>

        <!-- Logo Équipe Droite -->
        <div class="form-group">
            <label for="logo_equipe_droite">Logo Équipe Droite</label>
            <input type="file" id="logo_equipe_droite" name="logo_equipe_droite" class="form-control" accept="image/*" onchange="loadLogoDroite()">
            <img id="af_logo_droite" src="{{ asset('storage/' . $match->team2->logo_path) }}" alt="Logo Droite" style="max-height: 200px;">
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer les Modifications</button>
    </form>
    <a href="{{ route('employee.matches.index') }}" class="btn btn-secondary">Retour à la liste des matchs</a>
</div>

<script>
function loadLogoGauche() {
    var logogauche = document.getElementById("logo_equipe_gauche").files;
    if (logogauche.length > 0) {
        var fileToLoad = logogauche[0];
        var fileReader = new FileReader();

        fileReader.onload = function(fileLoadedEvent) {
            var logoUrl = fileLoadedEvent.target.result;
            document.getElementById('af_logo_gauche').src = logoUrl;
        };

        fileReader.readAsDataURL(fileToLoad);
    }
}

function loadLogoDroite() {
    var logodroite = document.getElementById("logo_equipe_droite").files;
    if (logodroite.length > 0) {
        var fileToLoad = logodroite[0];
        var fileReader = new FileReader();

        fileReader.onload = function(fileLoadedEvent) {
            var logoUrl = fileLoadedEvent.target.result;
            document.getElementById('af_logo_droite').src = logoUrl;
        };

        fileReader.readAsDataURL(fileToLoad);
    }
}
</script>
@endsection
