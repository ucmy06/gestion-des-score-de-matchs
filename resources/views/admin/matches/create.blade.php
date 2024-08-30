@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold mb-6 text-black">Ajouter un Match</h1>

    <form action="{{ route('admin.matches.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf

        <div class="mb-4">
            <label for="team_1_id" class="block text-lg font-medium text-black mb-2">Équipe 1</label>
            <select name="team_1_id" id="team_1_id" class="form-select block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-black">
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="team_2_id" class="block text-lg font-medium text-black mb-2">Équipe 2</label>
            <select name="team_2_id" id="team_2_id" class="form-select block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-black">
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="score_team_1" class="block text-lg font-medium text-black mb-2">Score Équipe 1</label>
            <input type="number" name="score_team_1" id="score_team_1" class="form-input block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-black" value="0" readonly>
        </div>

        <div class="mb-4">
            <label for="score_team_2" class="block text-lg font-medium text-black mb-2">Score Équipe 2</label>
            <input type="number" name="score_team_2" id="score_team_2" class="form-input block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-black" value="0" readonly>
        </div>

        <div class="mb-4">
            <label for="match_duration" class="block text-lg font-medium text-black mb-2">Durée du match</label>
            <input type="number" name="match_duration" id="match_duration" class="form-input block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-black" min="0">
        </div>

        <div class="mb-4">
            <label for="wait_time" class="block text-lg font-medium text-black mb-2">Temps d'attente (optionnel)</label>
            <input type="number" name="wait_time" id="wait_time" class="form-input block w-full border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-black" min="0">
        </div>

        <button type="submit" class="btn btn-blue">Créer</button>
    </form>
</div>
@endsection
