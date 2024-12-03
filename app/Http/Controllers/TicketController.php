<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Ticket;
use App\Models\Team;
use App\Models\Log_Asignado;
use App\Models\User;
use App\Models\Ticket_Asignado;
use Illuminate\Support\Facades\Log;
use Exception;
use Carbon\Carbon;

use App\Mail\asignadoMail;
use Illuminate\Support\Facades\Mail;

use App\Notifications\TicketCreado;

class TicketController extends Controller
{
    public function VerCrearTicket(){
        $username = Auth::user()->username;
        $teams = Team::all();
        return view('ticket.crear_ticket',compact('username','teams'));
    }


    public function GuardarTicket(Request $request) {
        try{
      
           
            $ticket = new Ticket();
            $ticket->solicitante = $request->input('solicitante');;
            $ticket->team_id = $request->input('team_id');
            $ticket->nombre_cliente = $request->input('nombre_cliente');
            $ticket->matricula = $request->input('matricula');
            $ticket->bastidor = $request->input('bastidor');
            $ticket->telefono = $request->input('telefono');
            $ticket->observaciones_ticket = $request->input('observaciones_ticket');
            $ticket->estado = "Abierto";
            $ticket->creado = Carbon::now()->format('d-m-Y H:i:s');
         
            $ticket->save();

           
             return redirect()->route('ticket.mostrado', ['ticket' => $ticket->id])->with('success', 'Ticket creado con éxito.');
        }catch(Exception $e){
            Log::error('Error al crear el ticket: ' . $e->getMessage());
        }
        
    }
    

    public function mostrarTicket($id){
        $username = Auth::user()->username;
        $ticket = Ticket::findOrFail($id);
        return view('ticket.ticket', compact('ticket','username'));
    }
    public function verSolicitudesGlobales(Request $request)
    {
        $username = Auth::user()->username;
        $teamId = Auth::user()->team_id;
    
        $tickets = Ticket::query();
    
        // Aplicar filtros
        $tickets->when($request->id, function ($query, $id) {
            return $query->where('id', $id);
        })->when($request->para, function ($query, $para) {
            return $query->whereHas('team', function ($q) use ($para) {
                $q->where('nombre', 'like', "%{$para}%");
            });
        })->when($request->asignado_a, function ($query, $asignado_a) {
            return $query->whereHas('usuarioAsignado', function ($q) use ($asignado_a) {
                $q->where('username', 'like', "%{$asignado_a}%");
            });
        })->when($request->nombre_cliente, function ($query, $nombre_cliente) {
            return $query->where('nombre_cliente', 'like', "%{$nombre_cliente}%");
        })->when($request->telefono, function ($query, $telefono) {
            return $query->where('telefono', 'like', "%{$telefono}%");
        })->when($request->matricula, function ($query, $matricula) {
            return $query->where('matricula', 'like', "%{$matricula}%");
        })->when($request->bastidor, function ($query, $bastidor) {
            return $query->where('bastidor', 'like', "%{$bastidor}%");
        })->when($request->observaciones_ticket, function ($query, $observaciones_ticket) {
            return $query->where('observaciones_ticket', 'like', "%{$observaciones_ticket}%");
        })->when($request->creado, function ($query, $creado) {
            return $query->where('creado', 'like', "%{$creado}%");
        });

        if (Auth::user()->rol == "admin") {
          
            $tickets = $tickets->simplePaginate(10);
        } else {
          
            $tickets = $tickets->where('team_id', $teamId)->simplePaginate(10);
        }
    
        return view("ticket.solicitudes-globales", compact('username', 'tickets'));
    }
    public function verTicketsAbiertos(Request $request)
    {
        $username = Auth::user()->username;
        $teamId = Auth::user()->team_id;
    
        $tickets = Ticket::query();
    
       
        $tickets->where('estado', 'Abierto');
    
        $tickets->when($request->id, function ($query, $id) {
            return $query->where('id', $id);
        })->when($request->para, function ($query, $para) {
            return $query->whereHas('team', function ($q) use ($para) {
                $q->where('nombre', 'like', "%{$para}%");
            });
        })->when($request->asignado_a, function ($query, $asignado_a) {
            return $query->whereHas('usuarioAsignado', function ($q) use ($asignado_a) {
                $q->where('username', 'like', "%{$asignado_a}%");
            });
        })->when($request->nombre_cliente, function ($query, $nombre_cliente) {
            return $query->where('nombre_cliente', 'like', "%{$nombre_cliente}%");
        })->when($request->telefono, function ($query, $telefono) {
            return $query->where('telefono', 'like', "%{$telefono}%");
        })->when($request->matricula, function ($query, $matricula) {
            return $query->where('matricula', 'like', "%{$matricula}%");
        })->when($request->bastidor, function ($query, $bastidor) {
            return $query->where('bastidor', 'like', "%{$bastidor}%");
        })->when($request->observaciones_ticket, function ($query, $observaciones_ticket) {
            return $query->where('observaciones_ticket', 'like', "%{$observaciones_ticket}%");
        })->when($request->creado, function ($query, $creado) {
            return $query->where('creado', 'like', "%{$creado}%");
        });
    
    
        if (Auth::user()->rol == "admin") {
            // Administrador ve todos los tickets abiertos
        } else {
            // Usuario ve solo los tickets abiertos de su equipo
            $tickets->where('team_id', $teamId)->simplePaginate(10);
        }
    
     
        $tickets = $tickets->simplePaginate(10);
    
        return view('ticket.abiertas', compact('username', 'tickets'));
    }
    
    public function VerSolicitudesSinAsignar(Request $request)
    {
        $username = Auth::user()->username;
        $assignedTicketIds = Ticket_Asignado::pluck('id_ticket')->toArray();
        
        $tickets = Ticket::query(); 
        $tickets->when($request->id, function ($query, $id) {
            return $query->where('id', $id);
        })->when($request->para, function ($query, $para) {
            return $query->whereHas('team', function ($q) use ($para) {
                $q->where('nombre', 'like', "%{$para}%");
            });
        })
        ->when($request->asignado_a, function ($query, $asignado_a) {
            return $query->whereHas('usuarioAsignado', function ($q) use ($asignado_a) {
                $q->where('username', 'like', "%{$asignado_a}%");
            });
            
        })->when($request->nombre_cliente, function ($query, $nombre_cliente) {
            return $query->where('nombre_cliente', 'like', "%{$nombre_cliente}%");
        })->when($request->telefono, function ($query, $telefono) {
            return $query->where('telefono', 'like', "%{$telefono}%");
        })->when($request->matricula, function ($query, $matricula) {
            return $query->where('matricula', 'like', "%{$matricula}%");
        })->when($request->bastidor, function ($query, $bastidor) {
            return $query->where('bastidor', 'like', "%{$bastidor}%");
        })->when($request->observaciones_ticket, function ($query, $observaciones_ticket) {
            return $query->where('observaciones_ticket', 'like', "%{$observaciones_ticket}%");
        })->when($request->creado, function ($query, $creado) {
            return $query->where('creado', 'like', "%{$creado}%");
        });
        
    
        if (Auth::user()->rol == "admin") {
            $tickets = $tickets->whereNotIn('id', $assignedTicketIds);
        } else if (Auth::user()->rol == "usuario") {
            $teamId = Auth::user()->team_id;
            $tickets = $tickets->where('team_id', $teamId)
                               ->whereNotIn('id', $assignedTicketIds);
        }
        
        $tickets = $tickets->simplePaginate(10);
    
        return view('ticket.solicitudes_sinAsig', compact('username', 'tickets'));
    }
    
    


    public function asignarTicket(Request $request)
    {
        try{
            $id_ticket = $request->input('ticket_id');
            $id_user = $request->input('id_user');
        
            if (empty($id_ticket) || empty($id_user)) {
                Log::error('Ticket ID o User ID vacío', ['ticket_id' => $id_ticket, 'user_id' => $id_user]);
                return redirect()->back()->withErrors('No se pudo asignar el ticket. Por favor, verifica que has seleccionado un usuario.');
            }
    
            Ticket_Asignado::updateOrCreate(
                ['id_ticket' => $id_ticket],
                ['id_user' => $id_user]
            );
        
    
       

            $user = User::find($id_user);
            $email = $user->email;

            $enlace = "https://asicticket.nova-iberia.es/ticket/$id_ticket";
            Mail::to($email)->send(new asignadoMail($enlace));


            Log::info("El ticket con id: ". $id_ticket . "se ha asignado al usuario con id: " . $id_user);
            return redirect()->back()->with('success', 'El ticket ha sido asignado correctamente.');
        }catch(Exception $e){
            Log::error('Error al asignar el ticket con id : '. $id_ticket . ' mensaje de error ' . $e->getMessage());
        }

    }
    

    public function getUsersByTicket(Request $request)
    {
        try{
            $ticketId = $request->input('ticket_id');
    
            $ticket = Ticket::find($ticketId);
    
            if (!$ticket) {
                Log::info("no ticket");
            }
    
            $teamId = $ticket->team_id;
    
            $users = User::where('team_id', $teamId)->get();
    
            return response()->json($users);
        }catch(Exception $e){
            Log::error('Error al obtener el listado de usuarios para la asignacion de ticket: ' . $e->getMessage());
        }
       
    
    }

    public function verMisSolicitudes(Request $request)
    {
        $username = Auth::user()->username;
        $userId = Auth::id();
       
        $assignedTicketIds = Ticket_Asignado::where('id_user', $userId)->pluck('id_ticket')->toArray();
    
        $tickets = Ticket::whereIn('id', $assignedTicketIds)
       ->when($request->id, function ($query, $id) {
            return $query->where('id', $id);
        })->when($request->para, function ($query, $para) {
            return $query->whereHas('team', function ($q) use ($para) {
                $q->where('nombre', 'like', "%{$para}%");
            });
        })
        ->when($request->asignado_a, function ($query, $asignado_a) {
            return $query->whereHas('usuarioAsignado', function ($q) use ($asignado_a) {
                $q->where('username', 'like', "%{$asignado_a}%");
            });
            
        })->when($request->nombre_cliente, function ($query, $nombre_cliente) {
            return $query->where('nombre_cliente', 'like', "%{$nombre_cliente}%");
        })->when($request->telefono, function ($query, $telefono) {
            return $query->where('telefono', 'like', "%{$telefono}%");
        })->when($request->matricula, function ($query, $matricula) {
            return $query->where('matricula', 'like', "%{$matricula}%");
        })->when($request->bastidor, function ($query, $bastidor) {
            return $query->where('bastidor', 'like', "%{$bastidor}%");
        })->when($request->observaciones_ticket, function ($query, $observaciones_ticket) {
            return $query->where('observaciones_ticket', 'like', "%{$observaciones_ticket}%");
        })->when($request->creado, function ($query, $creado) {
            return $query->where('creado', 'like', "%{$creado}%");
        })
            ->simplePaginate(10);
    
        return view('ticket.mis_solicitudes', compact('username', 'tickets'));
    }
    

    public function VerEditarTicket($id){
        $username = Auth::user()->username;
        $ticket =  Ticket::findOrFail($id);
        $teams = Team::all();
       
        return view('ticket.editar-ticket',compact('username','ticket','teams'));
    }

    public function GuardarEditar(Request $request, $id){
        try{


        $ticket = Ticket::findOrFail($id);
        $ticket->team_id = $request->team_id;
        $ticket->nombre_cliente = $request->nombre_cliente;
        $ticket->matricula = $request->matricula;
        $ticket->bastidor = $request->bastidor;
        $ticket->telefono = $request->telefono;
        $ticket->observaciones_ticket = $request->observaciones_ticket;
        $ticket->actualizado = Carbon::now()->format('d-m-Y H:i:s');
   
        $ticket->save();
 
        return redirect()->route('ver.peticiones');

    }catch(Exception $e){
        Log::error('Error al editar el ticket  con id: '.$id . "con mensaje" . $e->getMessage());
    }
    }

    public function EliminarTicket($id){
        try{
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
    
        return redirect()->route('ver.solicitudes.totales');
        }catch(Exception $e){
            Log::error('Error al eliminar el ticket  con id: '.$id . "con mensaje" . $e->getMessage());
        }
    }

    
    public function CerrarTicket($id){
        try{

        
            $ticket = Ticket::find($id);
            if ($ticket) {
                $ticket->estado = 'Cerrado';
                $ticket->cerrado = Carbon::now()->format('d-m-Y H:i:s');
                $ticket->save();
            }
            return redirect()->back()->with('success', 'ticket cerrado.');
        }catch(Exception $e){
            Log::error('Error al cerrar el ticket  con id: '.$id . "con mensaje" . $e->getMessage());
        }
    }
public function VerCerrados(Request $request)
{
    $username = Auth::user()->username;
    $user = Auth::user();

    // Verifica si el usuario es admin. Si no es admin, solo podrá ver los tickets de su propio team_id
    $ticketsQuery = Ticket::where('estado', 'Cerrado')
    ->when($request->id, function ($query, $id) {
        return $query->where('id', $id);
    })->when($request->para, function ($query, $para) {
        return $query->whereHas('team', function ($q) use ($para) {
            $q->where('nombre', 'like', "%{$para}%");
        });
    })
    ->when($request->asignado_a, function ($query, $asignado_a) {
        return $query->whereHas('usuarioAsignado', function ($q) use ($asignado_a) {
            $q->where('username', 'like', "%{$asignado_a}%");
        });
        
    })->when($request->nombre_cliente, function ($query, $nombre_cliente) {
        return $query->where('nombre_cliente', 'like', "%{$nombre_cliente}%");
    })->when($request->telefono, function ($query, $telefono) {
        return $query->where('telefono', 'like', "%{$telefono}%");
    })->when($request->matricula, function ($query, $matricula) {
        return $query->where('matricula', 'like', "%{$matricula}%");
    })->when($request->bastidor, function ($query, $bastidor) {
        return $query->where('bastidor', 'like', "%{$bastidor}%");
    })->when($request->observaciones_ticket, function ($query, $observaciones_ticket) {
        return $query->where('observaciones_ticket', 'like', "%{$observaciones_ticket}%");
    })->when($request->creado, function ($query, $creado) {
        return $query->where('creado', 'like', "%{$creado}%");
    });


    if ($user->rol != 'admin') {
        $ticketsQuery->where('team_id', $user->team_id);
    }

    $tickets = $ticketsQuery->simplePaginate(10);

    return view("ticket.cerrado", compact('username', 'tickets'));
}




}