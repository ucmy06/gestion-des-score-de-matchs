@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold mb-4 text-black">Détails du Match</h1>
    <div class="bg-gray-50 border border-gray-300 shadow-lg rounded-lg p-6 mb-6">
        <p class="text-lg font-medium mb-2 text-black"><strong>Équipe 1:</strong> {{ $match->team1 ? $match->team1->name : 'Non spécifiée' }}</p>
        <p class="text-lg font-medium mb-2 text-black"><strong>Équipe 2:</strong> {{ $match->team2 ? $match->team2->name : 'Non spécifiée' }}</p>
        <p class="text-lg font-medium mb-2 text-black"><strong>Score Équipe 1:</strong> {{ $match->score_team_1 }}</p>
        <p class="text-lg font-medium mb-2 text-black"><strong>Score Équipe 2:</strong> {{ $match->score_team_2 }}</p>
    </div>
    
    <h3 class="text-2xl font-semibold mb-4 text-black">Journal des Actions</h3>
    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full bg-gray-200 border border-gray-300 rounded-lg">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Utilisateur</th>
                    <th class="py-2 px-4 border-b">Action</th>
                    <th class="py-2 px-4 border-b">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr class="bg-gray-100 hover:bg-gray-200">
                    <td class="py-2 px-4 border-b text-black">{{ $log->id }}</td>
                    <td class="py-2 px-4 border-b text-black">{{ $log->user->name }}</td>
                    <td class="py-2 px-4 border-b text-black">
                        @if($log->change_type === 'increment')
                            L'équipe {{ $log->match->team1->name }} a marqué {{ $log->points_changed }} point(s) à {{ $log->changed_at->format('d/m/Y H:i') }}
                        @elseif($log->change_type === 'decrement')
                            L'équipe {{ $log->match->team2->name }} a reçu une pénalité de {{ $log->points_changed }} point(s) à {{ $log->changed_at->format('d/m/Y H:i') }}
                        @else
                            {{ $log->action }}
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b text-black">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
