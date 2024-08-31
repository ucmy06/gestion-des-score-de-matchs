@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold mb-4 text-black">Détails du Match</h1>
    
    <!-- Bouton d'impression -->
    <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
        Imprimer
    </button>
    
    <div class="bg-gray-50 border border-gray-300 shadow-lg rounded-lg p-6 mb-6">
                <p class="text-lg"><span class="font-semibold">Équipe 1:</span> {{ $match->team1 ? $match->team1->name : 'Non spécifiée' }}</p>
                <p class="text-lg"><span class="font-semibold">Équipe 2:</span> {{ $match->team2 ? $match->team2->name : 'Non spécifiée' }}</p>
        <p class="text-lg font-medium mb-2 text-black"><strong>Score Équipe 1:</strong> {{ $match->score_team_1 }}</p>
        <p class="text-lg font-medium mb-2 text-black"><strong>Score Équipe 2:</strong> {{ $match->score_team_2 }}</p>
    </div>
    
    <h3 class="text-2xl font-semibold mb-4 text-black">Journal des Actions</h3>
    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full bg-gray-200 border border-gray-300 rounded-lg">
            <thead class="bg-gray-800 text-white">
                <tr>
                    {{-- <th class="py-2 px-4 border-b">ID</th> --}}
                    <th class="px-4 py-2 text-left">Numéro</th>

                    <th class="py-2 px-4 border-b">Utilisateur</th>
                    <th class="py-2 px-4 border-b">Variation des points</th>
                    <th class="py-2 px-4 border-b">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $index => $log)
                <tr class="bg-gray-100 hover:bg-gray-200">
                    <td class="py-2 px-4 border-b text-black">{{ $index + 1 }}</td>

                    {{-- <td class="py-2 px-4 border-b text-black">{{ $log->id }}</td> --}}
                    <td class="py-2 px-4 border-b text-black">{{ $log->user->name }}</td>
                    <td class="py-2 px-4 border-b text-black">
                        @if($log->change_type === 'increment')
                            L'équipe {{ $log->match->team1->name }} a marqué {{ $log->points_changed }} point(s) 
                            @if($log->changed_at instanceof \Carbon\Carbon)
                                {{-- {{ $log->changed_at->format('d/m/Y H:i') }} --}}
                            @else
                                {{-- {{ $log->changed_at }} --}}
                            @endif
                        @elseif($log->change_type === 'decrement')
                            L'équipe {{ $log->match->team2->name }} a reçu une pénalité de {{ $log->points_changed }} point(s)
                            @if($log->changed_at instanceof \Carbon\Carbon)
                                {{-- {{ $log->changed_at->format('d/m/Y H:i') }} --}}
                            @else
                                {{-- {{ $log->changed_at }} --}}
                            @endif
                        @else
                            {{ $log->action }}
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b text-black">
                        @if($log->changed_at instanceof \Carbon\Carbon)
                            {{ $log->changed_at->format('d/m/Y H:i') }}
                        @else
                            {{ $log->created_at }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

<!-- Styles spécifiques pour l'impression -->
@section('styles')
<style>
    @media print {
        /* Masquer le bouton d'impression lors de l'impression */
        button {
            display: none;
        }
        /* Ajouter d'autres styles d'impression si nécessaire */
    }
</style>
@endsection
