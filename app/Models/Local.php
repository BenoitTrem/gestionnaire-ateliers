<?php
/**
 * @author Benoit Tremblay.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    /** @use HasFactory<\Database\Factories\LocalFactory> */
    use HasFactory;

    protected $fillable = [
        'numeroLocal',
        'campus_id',
        'capacite',
        'disponibilite',
    ];

    public function ateliers()
    {
        return $this->hasMany(Atelier::class, 'local_id');
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class, 'campus_id');
    }

    public function modifier(array $data): bool
    {
        return $this->update($data);
    }

    public function supprimer(): bool
    {
        return $this->delete();
    }
}
