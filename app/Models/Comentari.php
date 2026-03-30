<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentari extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_id',
        'autor_id',
        'text'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function autor()
    {
        return $this->belongsTo(User::class, 'autor_id');
    }
}
