@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Gestion des Matchs</h1>
    
    <!-- Bouton pour ajouter un match -->
    <div class="mb-6 text-left">
        <a href="{{ route('admin.matches.create') }}" class="btn btn-blue">Ajouter un Match</a>
    </div>
    
    <div class="overflow-x-auto bg-gray-100 p-4 rounded-lg shadow-md">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg">
            <thead class="bg-gray-200 text-black">
                <tr>
                    {{-- <th class="px-4 py-2 text-left">ID</th> --}}
                    <th class="px-4 py-2 text-left">Numéro</th>

                    <th class="px-4 py-2 text-left">Équipe 1</th>
                    <th class="px-4 py-2 text-left">Équipe 2</th>
                    <th class="px-4 py-2 text-left">Score Équipe 1</th>
                    <th class="px-4 py-2 text-left">Score Équipe 2</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300">
                @foreach($matches as  $index => $match)
                <tr class="hover:bg-gray-200">
                    {{-- <td class="px-4 py-2">{{ $match->id }}</td> --}}
                    <td class="py-2 px-4 border-b text-black">{{ $index + 1 }}</td>

                    <td class="px-4 py-2">{{ $match->team1 ? $match->team1->name : 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $match->team2 ? $match->team2->name : 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $match->score_team_1 }}</td>
                    <td class="px-4 py-2">{{ $match->score_team_2 }}</td>
                    <td class="px-4 py-2">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.matches.show', $match->id) }}" class="btn btn-teal">Voir journal</a>
                            <a href="{{ route('admin.matches.edit', $match->id) }}" class="btn btn-yellow">Lancer</a>
                            <form action="{{ route('admin.matches.destroy', $match->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce match ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-red">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
