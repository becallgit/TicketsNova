<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignados_Internos extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'id_ticket'
    ];
   protected $table = "asignados_internos";
   public function ticket()
   {
       return $this->belongsTo(Ticket_Interno::class, 'id_ticket', 'id');
   }

   public function user()
   {
       return $this->belongsTo(User::class, 'id_user', 'id');
   }
}
