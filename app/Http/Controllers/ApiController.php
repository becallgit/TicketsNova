<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use Carbon\Carbon;
use App\Models\Ticket;
use App\Mail\NotifyAbierto;
use Illuminate\Support\Facades\Mail;
class ApiController extends Controller
{
    public function CreateTicket(Request $request)
    {
        try {
            $team_id = $request->input('team_id');
            $nombre_cliente = $request->input('nombre_cliente');
            $matricula = $request->input('matricula');
            $bastidor = $request->input('bastidor');
            $telefono = $request->input('telefono');
            $observaciones = $request->input('observaciones');
            $estado = "Abierto";
            $creado = Carbon::now()->format('d-m-Y H:i:s');

    
            $ticket = Ticket::create([
                'team_id' => $team_id,
                'nombre_cliente' => $nombre_cliente,
                'matricula' => $matricula,
                'bastidor' => $bastidor,
                'telefono' => $telefono,
                'observaciones_ticket' => $observaciones,
                'creado' => $creado,
                'estado' => $estado
            ]);

        
            $ticketId = $ticket->id;

            $enlace = "http://127.0.0.1:8000/ticket/$ticketId";
            Mail::to("veronica.sanchez@becallgroup.com")->send(new NotifyAbierto($enlace));
            Log::info("Ticket creado con ID: " . $ticketId);

            return response()->json([
                'message' => 'Ticket creado correctamente',
                'ticket_id' => $ticketId 
            ]);
        } catch (Exception $e) {
            Log::error("Error al crear ticket con la API: " . $e->getMessage());
            return response()->json([
                'message' => 'Error al crear el ticket'
            ], 500);
        }
    }

}
