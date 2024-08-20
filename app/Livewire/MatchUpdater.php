<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Matches;
use App\Models\Log;

class MatchUpdater extends Component
{
    public $match;
    public $score_team_1;
    public $score_team_2;
    // public $status;

    public function mount(Matches $match)
    {
        $this->match = $match;
        $this->score_team_1 = $match->score_team_1;
        $this->score_team_2 = $match->score_team_2;
        // $this->status = $match->status;
    }

    public function updateMatch()
    {
        $this->validate([
            'score_team_1' => 'required|integer',
            'score_team_2' => 'required|integer',
            // 'status' => 'required|string',
        ]);

        $this->match->update([
            'score_team_1' => $this->score_team_1,
            'score_team_2' => $this->score_team_2,
            // 'status' => $this->status,
        ]);

        // Log the changes
        Log::create([
            'user_id' => auth()->id(),
            'match_id' => $this->match->id,
            'action' => 'Mise à jour des scores',
            'details' => 'Score Équipe 1: ' . $this->score_team_1 . ', Score Équipe 2: ' . $this->score_team_2,
        ]);

        $this->emit('refreshMatch');
    }

    public function render()
    {
        return view('livewire.match-updater');
    }
}