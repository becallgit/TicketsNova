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
        'cerrado',
        'adjuntos',
        'answer_client',
        'ask_nova',
        'matricula'
    ];
   protected $table = "tickets_internos";

   public function usuarioAsignado()
   {
       return $this->hasOneThrough(User::class, Asignados_Internos::class, 'id_ticket', 'id', 'id', 'id_user');
   }
   public function asignaciones()
{
    return $this->hasMany(\App\Models\Asignados_Internos::class, 'id_ticket');
}

}
