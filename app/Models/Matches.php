<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Matches extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_1_id',
        'team_2_id',
        'score_team_1',
        'score_team_2',
        'match_date',
        'created_by',
        // 'status', // Assurez-vous que 'status' est bien inclus ici
        'duration', // Ajoutez ce champ ici

    ];

    // Définir les relations
    public function team1()
    {
        return $this->belongsTo(Team::class, 'team_1_id');
    }

    public function team2()
    {
        return $this->belongsTo(Team::class, 'team_2_id');
    }

    // Indiquer les attributs qui doivent être traités comme des dates
    protected $dates = ['match_date'];

    // Accesseur pour le formatage de la date
    public function getMatchDateFormattedAttribute()
    {
        return $this->match_date instanceof Carbon ? $this->match_date->format('d/m/Y H:i') : 'Non spécifiée';
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

// Dans le modèle Match
public function logs()
{
    return $this->hasMany(Log::class, 'match_id');
}
}
