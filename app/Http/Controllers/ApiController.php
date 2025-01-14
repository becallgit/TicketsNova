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
            $idlogcall = $request->input('idlogcall');
            $team_id = $request->input('team_id');
            $nombre_cliente = $request->input('nombre_cliente');
            $matricula = $request->input('matricula');
            $bastidor = $request->input('bastidor');
            $telefono = $request->input('telefono');
            $observaciones = $request->input('observaciones');
            $estado = "Abierto";
            $creado = Carbon::now()->format('Y-m-d H:i:s');
            $incidencia = $request->input('tipo_incidencia');

    
            $ticket = Ticket::create([
                'idlogcall' => $idlogcall,
                'team_id' => $team_id,
                'nombre_cliente' => $nombre_cliente,
                'matricula' => $matricula,
                'bastidor' => $bastidor,
                'telefono' => $telefono,
                'observaciones_ticket' => $observaciones,
                'creado' => $creado,
                'estado' => $estado,
                'tipo_incidencia'=>$incidencia
            ]);
            $ticketId = $ticket->id;
            $enlace = "https://asicticket.nova-iberia.es/ticket/$ticketId";
        
            $team = $ticket->team_id;
            if($team == 1){
             
                Mail::to("recepcion3@dismoauto.skoda.es")->send(new NotifyAbierto($enlace));
                Log::info("correo enviado a dismoauto");
            }else if($team == 2){
                try{
                    $recipients = ["mjfbelmonte@veraimport.es", "pgarcia@veraimport.es"];
                    Mail::to($recipients)->send(new NotifyAbierto($enlace));
                    Log::info("correo enviado a vera import");
                }catch (Exception $e) {
                    Log::error("Error al enviar el email a vera " . $e->getMessage());
                }

              
            }else if($team == 3){
                Mail::to("postventa@riscal.audi.es")->send(new NotifyAbierto($enlace));
                Log::info("correo enviado a talleres riscal");
            }
          
           
            Log::info("Ticket creado con ID: " . $ticketId);

            return response()->json([
                'message' => 'Ticket creado correctamente',
                'ticket_id' => $ticketId 
            ]);
        } catch (Exception $e) {
            Log::error("Error al crear ticket con la API: "  . $ticketId ." ". $e->getMessage());
            return response()->json([
                'message' => 'Error al crear el ticket'
            ], 500);
        }
    }

}

