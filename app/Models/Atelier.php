<?php
/**
 * @author Benoit Tremblay.
 */

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\InscriptionsMail;


class Atelier extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'animateur_id',
        'description',
        'local_id',
        'campus_id',
        'url_inscription',
        'date',
        'heure_debut',
        'duree_minutes',
    ];

    public static array $campus_options = ["Félix-Leclerc", "Gabrielle-Roy"];

    public function setCampusAttribute($value)
    {
        if (in_array($value, self::$campus_options)) {
            $this->attributes['campus'] = $value;
        } else {
            $this->attributes['campus'] = 'Félix-Leclerc';
        }
    }

    public static function creer(array $data): self
    {
        return self::create($data);
    }

    public function modifier(array $data): bool
    {
        return $this->update($data);
    }

    public function supprimer(): bool
    {
        return $this->delete();
    }



    public function inscription(): bool
    {
        $user = Auth::user();

        if ($this->participantsInscrits()->where('user_id', $user->id)->exists() ||
            $this->participantsAttente()->where('user_id', $user->id)->exists()) {
            throw new \Exception("Vous êtes déjà inscrit à cet atelier.");
        }

        if ($this->participantsInscrits()->count() < $this->duree_minutes) {
            $this->participantsInscrits()->attach($user->id, ['statut' => 'inscrit']);
        } else {
            $this->participantsAttente()->attach($user->id, ['statut' => 'attente']);
        }
        return true;
    }


    public function desinscription(User $user)
    {
        $this->participantsInscrits()->detach($user->id);
        $this->participantsAttente()->detach($user->id);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class)->withPivot('statut')->withTimestamps();
    }
    public function participantsInscrits()
    {
        return $this->belongsToMany(User::class, 'atelier_user')
            ->withPivot('statut')
            ->wherePivot('statut', 'inscrit');
    }

    public function participantsAttente()
    {
        return $this->belongsToMany(User::class, 'atelier_user')
            ->withPivot('statut')
            ->wherePivot('statut', 'attente');
    }


    public function courriel()
    {
        Mail::to(Auth::user())->send(new InscriptionsMail([$this]));
    }

    public static function courrielInscriptions()
    {
        $user = Auth::user();
        Mail::to($user)->send(new InscriptionsMail($user->ateliers));
    }

    public function courrielRappel()
    {
        foreach ($this->participantsInscrits as $participant) {
            Mail::to($participant)->send(new InscriptionsMail([$this]));
        }
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_atelier');
    }
    public function local()
    {
        return $this->belongsTo(Local::class, 'local_id');
    }

    public function animateurs()
    {
        return $this->belongsToMany(Animateur::class, 'animateur_atelier', 'atelier_id', 'animateur_id');
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
}
