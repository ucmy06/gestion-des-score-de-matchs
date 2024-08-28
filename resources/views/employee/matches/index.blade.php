@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-4 text-black">Matchs</h1>
    @if(auth()->check() && auth()->user()->role === 'employee')
        <a href="{{ route('employee.matches.create') }}" class="btn btn-blue mb-4 inline-block">Ajouter un Match</a>
    @endif

    <table class="min-w-full bg-gray-200 border border-gray-300 rounded-lg shadow-md">
        <thead class="bg-gray-200 text-black">
            <tr>
                <th class="px-4 py-2 text-left">ID</th>
                <th class="px-4 py-2 text-left">Équipe 1</th>
                <th class="px-4 py-2 text-left">Équipe 2</th>
                <th class="px-4 py-2 text-left">Score Équipe 1</th>
                <th class="px-4 py-2 text-left">Score Équipe 2</th>
                <th class="px-4 py-2 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($matches as $match)
            <tr class="bg-gray-100 hover:bg-gray-200">
                <td class="py-2 px-4 border-b text-black">{{ $match->id }}</td>
                <td class="py-2 px-4 border-b text-black">{{ $match->team1 ? $match->team1->name : 'Équipe supprimée' }}</td>
                <td class="py-2 px-4 border-b text-black">{{ $match->team2 ? $match->team2->name : 'Équipe supprimée' }}</td>
                <td class="py-2 px-4 border-b text-black">{{ $match->score_team_1 }}</td>
                <td class="py-2 px-4 border-b text-black">{{ $match->score_team_2 }}</td>
                <td class="py-2 px-4 border-b">
                    <a href="{{ route('employee.matches.show', $match->id) }}" class="btn btn-teal">Voir journal</a>
                    @if(auth()->user()->role === 'employee')
                        <a href="{{ route('employee.matches.edit', $match->id) }}" class="btn btn-yellow ml-2">Lancer le match</a>

                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="py-2 px-4 text-center text-black">Aucun match disponible.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
