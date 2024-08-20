<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Matches;

class Team extends Model
{
    use HasFactory;

    // Si vous avez des colonnes spécifiques dans votre table que vous souhaitez remplir
    protected $fillable = ['name', 'logo']; // Exemple de colonnes

    // Importer le modèle Matches

    // Définir les relations avec d'autres modèles si nécessaire
    public function matchesAsTeam1()
    {
        return $this->hasMany(Matches::class, 'team_1_id');
    }

    public function matchesAsTeam2()
    {
        return $this->hasMany(Matches::class, 'team_2_id');
    }
}
