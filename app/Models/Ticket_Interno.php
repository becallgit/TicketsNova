<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket_Interno extends Model
{
    use HasFactory;

    protected $fillable = [
        'solicitante',
        'para',
        'tipo_solicitud',
        'cliente',
        'marca',
        'sede',
        'observaciones',
        'estado',
        'creado',
        'asignado',
        'cerrado'
    ];
   protected $table = "tickets_internos";

   public function usuarioAsignado()
   {
       return $this->hasOneThrough(User::class, Ticket_Asignado::class, 'id_ticket', 'id', 'id', 'id_user');
   }
}
