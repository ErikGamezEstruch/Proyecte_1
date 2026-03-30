<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    use HasFactory;

    protected $table = 'clients';
    // especificar que es cada cosa en el migrate
    protected $fillable = ['id','nombre','cif ','email_contacte ','direccio',
        'telefon','actiu','timestamps'];

    public function projectes()
    {
        // Relacion 1:N (Un cliente puede tener varios proyectes y un proyecte solo puede tener un cliente)
        return $this->hasMany(Projectes::class);
    }

}
