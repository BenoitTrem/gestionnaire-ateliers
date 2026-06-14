<?php


/**
 * @author John Sebastian Zuleta Franco
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;




class Animateur extends Model
{
    use HasFactory;

    protected $fillable = [
        'prenom',
        'nom',
        'biographie',
        'expertise',
        'email',
    ];

    /**
     * Relation avec les ateliers via la table pivot "ateliers_animateurs".
     */
    public function ateliers()
    {
        return $this->belongsToMany(Atelier::class, 'animateur_atelier');
    }

    /**
     * Modifier les informations de l'animateur.
     */
    public function modifier(array $data): bool
    {
        return $this->update($data);
    }

    /**
     * Supprimer l'animateur.
     */
    public function supprimer(): bool
    {
        return $this->delete();
    }
}
