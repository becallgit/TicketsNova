<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'idlogcall',
        'solicitante',
        'nombre_cliente',
        'team_id',
        'matricula',
        'bastidor',
        'telefono',
        'observaciones_ticket',
        'estado',
        'creado',
        'asignado',
        'cerrado',
        'actualizado',
        'id_motivo_pausa',
        'pausado'
    ];
   protected $table = "tickets";
   public function team()
   {
       return $this->belongsTo(Team::class, 'team_id');
   }
  
   public function ticketAsignado()
   {
       return $this->hasOne(Ticket_Asignado::class, 'id_ticket', 'id');
   }

    public function asignaciones()
    {
        return $this->hasMany(Ticket_Asignado::class, 'id_ticket');
    }

    public function usuarioAsignado()
    {
        return $this->hasOneThrough(User::class, Ticket_Asignado::class, 'id_ticket', 'id', 'id', 'id_user');
    }
}


