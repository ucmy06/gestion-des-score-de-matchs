@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold mb-4">Détails du Match</h1>

    <div class="mb-6">
        <p class="text-lg"><span class="font-semibold">ID:</span> {{ $match->id }}</p>
        <p class="text-lg"><span class="font-semibold">Équipe 1:</span> {{ $match->team1 ? $match->team1->name : 'Non spécifiée' }}</p>
        <p class="text-lg"><span class="font-semibold">Équipe 2:</span> {{ $match->team2 ? $match->team2->name : 'Non spécifiée' }}</p>
        <p class="text-lg"><span class="font-semibold">Score Équipe 1:</span> {{ $match->score_team_1 }}</p>
        <p class="text-lg"><span class="font-semibold">Score Équipe 2:</span> {{ $match->score_team_2 }}</p>
        <p class="text-lg"><span class="font-semibold">Date du Match:</span> {{ $match->match_date ? \Carbon\Carbon::parse($match->match_date)->format('d/m/Y H:i') : 'Non spécifiée' }}</p>
        <p class="text-lg"><span class="font-semibold">Date de Création:</span> {{ $match->created_at ? $match->created_at->format('d/m/Y H:i') : 'Non spécifiée' }}</p>
        <p class="text-lg"><span class="font-semibold">Date de Mise à Jour:</span> {{ $match->updated_at ? $match->updated_at->format('d/m/Y H:i') : 'Non spécifiée' }}</p>
        <p class="text-lg"><span class="font-semibold">Créé par:</span> {{ $match->creator ? $match->creator->name : 'Non spécifié' }}</p>
    </div>

    <h3 class="text-xl font-semibold mb-4">Journal des Actions</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-gray-100 border border-gray-300 rounded-lg">
            <thead class="bg-gray-200 text-black">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Utilisateur</th>
                    <th class="px-4 py-2 text-left">Action</th>
                    <th class="px-4 py-2 text-left">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300">
                @forelse($logs as $log)
                <tr class="hover:bg-gray-200 transition-colors duration-200 ease-in-out">
                    <td class="px-4 py-2">{{ $log->id }}</td>
                    <td class="px-4 py-2">{{ $log->user ? $log->user->name : 'Non spécifié' }}</td>
                    <td class="px-4 py-2">{{ $log->action }}</td>
                    <td class="px-4 py-2">{{ $log->created_at ? $log->created_at->format('d/m/Y H:i') : 'Non spécifiée' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center px-4 py-2">Aucune action enregistrée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
