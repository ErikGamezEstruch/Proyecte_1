<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Projectes;
use App\Models\User;
use App\Models\Comentari;
class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
        'projecte_id',
        'creador_id',
        'codi_ticket',
        'titol',
        'descripcio',
        'estat'
    ];

    public function projecte()
    {
        return $this->belongsTo(Projectes::class);
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'creador_id');
    }

    public function comentaris()
    {
        return $this->hasMany(Comentari::class);
    }

    public function registresTemps()
    {
        return $this->hasMany(RegistreTemps::class);
    }
}
