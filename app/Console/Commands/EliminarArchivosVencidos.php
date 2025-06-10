<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket_Interno;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EliminarArchivosVencidos extends Command
{
    protected $signature = 'archivos:limpiar';
    protected $description = 'Eliminar archivos adjuntos que tengan más de 1 minuto';

   public function handle()
{
    $tickets = \App\Models\Ticket_Interno::all();

    foreach ($tickets as $ticket) {
        $adjuntos = json_decode($ticket->adjuntos, true);
        $adjuntosFiltrados = [];

        foreach ($adjuntos as $archivo) {
            $fechaSubida = \Carbon\Carbon::parse($archivo['fecha_subida']);

            if (now()->diffInDays($fechaSubida) < 20) {
                $adjuntosFiltrados[] = $archivo;
            } else {
          
                \Storage::disk('public')->delete('archivos/' . $archivo['nombre']);
            }
        }

        $ticket->adjuntos = json_encode($adjuntosFiltrados);
        $ticket->save();
    }

    $this->info('Archivos vencidos eliminados correctamente.');
}

}
