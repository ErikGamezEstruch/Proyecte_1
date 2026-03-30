<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracioProjecte extends Model
{

    protected $table = 'configuracio_projectes';

    protected $fillable = ['projecte_id'];

    public function projecte()
    {
        return $this->belongsTo(Projectes::class);
    }
}
