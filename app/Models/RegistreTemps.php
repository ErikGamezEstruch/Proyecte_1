<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistreTemps extends Model
{
    protected $table = 'registre_temps';

    protected $fillable = [
        'ticket_id',
        'user_id',
        'hores',
        'data',
        'descripcio'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
