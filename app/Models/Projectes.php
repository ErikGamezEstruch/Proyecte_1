<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Projectes extends Model
{
    use HasFactory;

    protected $table = 'projectes';
    protected $fillable = ['id', 'client_id', 'gestor_id', 'nom', 'descripcio',
        'codi_projecte', 'estat', 'data_inici', 'data_fi_prevista', 'data_fi_real',
        'pressupost_hores_estimades', 'pressupost_hores_reals', 'timestamps'];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function gestor(){
        return $this->belongsTo(User::class, 'gestor_id');
    }

    public function devs()
    {
        return $this->belongsToMany(User::class, 'projectes_users', 'projecte_id', 'user_id');
    }
    public function configuracio()
    {
        return $this->hasOne(ConfiguracioProjecte::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

}
