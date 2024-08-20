<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Matches;
class DisplayMatch extends Component
{
    public $match;

    protected $listeners = ['refreshMatch' => '$refresh'];

    public function mount()
    {
        // On suppose que l'ID du match est stocké dans la session
        $matchId = session('currentMatchId');
        if ($matchId) {
            $this->match = Matches::with('team1', 'team2')->find($matchId);
        }
    }

    public function render()
    {
        return view('livewire.display-match', [
            'match' => $this->match,
        ]);
    }
}
