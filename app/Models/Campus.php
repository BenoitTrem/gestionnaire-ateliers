<?php
/**
 * @author Benoit Tremblay.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;

    protected $table = 'campuses';

    protected $fillable = [
        'id',
        'nom',
    ];

    public function ateliers()
    {
        return $this->hasMany(Atelier::class);
    }

    public function locaux()
    {
        return $this->hasMany(Local::class);
    }
}
