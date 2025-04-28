<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket_Interno;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Ticket_Asignado;
use Illuminate\Support\Facades\Log;
use Exception;
use Carbon\Carbon;
class TicketsInternosController extends Controller
{


    public function Globales(Request $request)
    {
        $username = Auth::user()->username;
    
      
        $query = Ticket_Interno::query();
        if ($request->filled('id')) {
            $query->where('id', $request->input('id')); // ID suele ser exacto
        }
        
        if ($request->filled('solicitante')) {
            $query->where('solicitante', 'like', '%' . $request->input('solicitante') . '%');
        }
        
        if ($request->filled('para')) {
            $query->where('para', 'like', '%' . $request->input('para') . '%');
        }
        
        if ($request->filled('tipo_solicitud')) {
            $query->where('tipo_solicitud', 'like', '%' . $request->input('tipo_solicitud') . '%');
        }
        
        if ($request->filled('cliente')) {
            $query->where('cliente', 'like', '%' . $request->input('cliente') . '%');
        }
        
        if ($request->filled('marca')) {
            $query->where('marca', 'like', '%' . $request->input('marca') . '%');
        }
        
        if ($request->filled('sede')) {
            $query->where('sede', 'like', '%' . $request->input('sede') . '%');
        }
        
        if ($request->filled('observaciones')) {
            $query->where('observaciones_ticket', 'like', '%' . $request->input('observaciones') . '%');
        }
        
        if ($request->filled('estado')) {
            $query->where('estado', 'like', '%' . $request->input('estado') . '%');
        }
        
        if ($request->filled('creado')) {
            $query->whereDate('creado', '>=', $request->input('creado')); 
        }
        
     
       
        $tickets = $query->paginate(10);
    
        return view('tickets_internos.globales', compact('username', 'tickets'));
    }
    
    public function Abiertos(Request $request)
    {
        $username = Auth::user()->username;
    
        
        $query = Ticket_Interno::where('estado', 'Abierto');
    
     
        if ($request->filled('id')) {
            $query->where('id', $request->input('id'));
        }
    
        if ($request->filled('solicitante')) {
            $query->where('solicitante', 'like', '%' . $request->input('solicitante') . '%');
        }
    
        if ($request->filled('para')) {
            $query->where('para', 'like', '%' . $request->input('para') . '%');
        }
    
        if ($request->filled('tipo_solicitud')) {
            $query->where('tipo_solicitud', 'like', '%' . $request->input('tipo_solicitud') . '%');
        }
    
        if ($request->filled('cliente')) {
            $query->where('cliente', 'like', '%' . $request->input('cliente') . '%');
        }
    
        if ($request->filled('marca')) {
            $query->where('marca', 'like', '%' . $request->input('marca') . '%');
        }
    
        if ($request->filled('sede')) {
            $query->where('sede', 'like', '%' . $request->input('sede') . '%');
        }
    
        if ($request->filled('observaciones')) {
            $query->where('observaciones_ticket', 'like', '%' . $request->input('observaciones') . '%');
        }
    
        if ($request->filled('creado')) {
            $query->whereDate('creado', '>=', $request->input('creado'));
        }
    
        
        $tickets = $query->paginate(10);
    
        return view('tickets_internos.abiertas', compact('username', 'tickets'));
    }
    
    public function Cerrados(Request $request)
    {
        $username = Auth::user()->username;
    
       
        $query = Ticket_Interno::where('estado', 'Cerrado');
    
      
        if ($request->filled('id')) {
            $query->where('id', $request->input('id'));
        }
    
        if ($request->filled('solicitante')) {
            $query->where('solicitante', 'like', '%' . $request->input('solicitante') . '%');
        }
    
        if ($request->filled('para')) {
            $query->where('para', 'like', '%' . $request->input('para') . '%');
        }
    
        if ($request->filled('tipo_solicitud')) {
            $query->where('tipo_solicitud', 'like', '%' . $request->input('tipo_solicitud') . '%');
        }
    
        if ($request->filled('cliente')) {
            $query->where('cliente', 'like', '%' . $request->input('cliente') . '%');
        }
    
        if ($request->filled('marca')) {
            $query->where('marca', 'like', '%' . $request->input('marca') . '%');
        }
    
        if ($request->filled('sede')) {
            $query->where('sede', 'like', '%' . $request->input('sede') . '%');
        }
    
        if ($request->filled('observaciones')) {
            $query->where('observaciones_ticket', 'like', '%' . $request->input('observaciones') . '%');
        }
    
        if ($request->filled('creado')) {
            $query->whereDate('creado', '>=', $request->input('creado'));
        }
    
    
        $tickets = $query->paginate(10);
    
        return view('tickets_internos.cerradas', compact('username', 'tickets'));
    }
    
    public function ParaMi(Request $request)
    {
        $username = Auth::user()->username;
        $userId = Auth::user()->id;
    
        // Obtengo los IDs de tickets asignados a este usuario
        $assignedTicketIds = Ticket_Asignado::where('id_user', $userId)->pluck('id_ticket')->toArray();
    
        // Empiezo el query
        $query = Ticket_Interno::whereIn('id', $assignedTicketIds);
    
        // Filtros
        if ($request->filled('id')) {
            $query->where('id', $request->input('id'));
        }
    
        if ($request->filled('solicitante')) {
            $query->where('solicitante', 'like', '%' . $request->input('solicitante') . '%');
        }
    
        if ($request->filled('para')) {
            $query->where('para', 'like', '%' . $request->input('para') . '%');
        }
    
        if ($request->filled('tipo_solicitud')) {
            $query->where('tipo_solicitud', 'like', '%' . $request->input('tipo_solicitud') . '%');
        }
    
        if ($request->filled('cliente')) {
            $query->where('cliente', 'like', '%' . $request->input('cliente') . '%');
        }
    
        if ($request->filled('marca')) {
            $query->where('marca', 'like', '%' . $request->input('marca') . '%');
        }
    
        if ($request->filled('sede')) {
            $query->where('sede', 'like', '%' . $request->input('sede') . '%');
        }
    
        if ($request->filled('observaciones')) {
            $query->where('observaciones_ticket', 'like', '%' . $request->input('observaciones') . '%');
        }
    
        if ($request->filled('estado')) {
            $query->where('estado', 'like', '%' . $request->input('estado') . '%');
        }
    
        if ($request->filled('creado')) {
            $query->whereDate('creado', '>=', $request->input('creado'));
        }
    
      
        $tickets = $query->paginate(10); 
    
        return view('tickets_internos.parami', compact('username', 'tickets'));
    }
    

    public function getUsersByTicket(Request $request)
    {
        try {
            $ticketId = $request->input('ticket_id');
    
            $ticket = Ticket_Interno::find($ticketId);
    
            if (!$ticket) {
                Log::info("Ticket no encontrado con ID: $ticketId");
                return response()->json(['error' => 'Ticket no encontrado'], 404);
            }
    
            $users = User::where('team_id', 4)->get();
    
            return response()->json($users);
        } catch (Exception $e) {
            Log::error('Error al obtener usuarios: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
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
            $username = $user ? $user->username : null;

            Ticket_Interno::where('id', $id_ticket)->update([
                'asignado' => Carbon::now()->format('Y-m-d H:i:s'),
                'para'=>$username
            ]);
    

     

            Log::info("El ticket con id: ". $id_ticket . "se ha asignado al usuario con id: " . $id_user);
            return redirect()->back()->with('success', 'El ticket ha sido asignado correctamente.');
        }catch(Exception $e){
            Log::error('Error al asignar el ticket con id : '. $id_ticket . ' mensaje de error ' . $e->getMessage());
        }

    }

    public function CerrarTicket($id){
        try{

        
            $ticket = Ticket_Interno::find($id);
            if ($ticket) {
                $ticket->estado = 'Cerrado';
                $ticket->cerrado = Carbon::now()->format('Y-m-d H:i:s');
                $ticket->save();
            }
            return redirect()->back()->with('success', 'ticket cerrado.');
        }catch(Exception $e){
            Log::error('Error al cerrar el ticket  con id: '.$id . "con mensaje" . $e->getMessage());
        }
    }
}
