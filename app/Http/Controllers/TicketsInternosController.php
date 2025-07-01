<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket_Interno;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Ticket_Asignado;
use App\Models\Asignados_Internos;
use Illuminate\Support\Facades\Log;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class TicketsInternosController extends Controller
{

public function saveAtach(Request $request, $id)
{
    $ticket = Ticket_Interno::findOrFail($id);
    $ticket->update([
        'ask_nova' => $request->ask_nova,
        'answer_client' => $request->answer_client
    ]);

    $archivosExistentes = json_decode($ticket->adjuntos, true) ?? [];

    if ($request->hasFile('adjuntos')) {
        foreach ($request->file('adjuntos') as $archivo) {
            $nombreArchivo = $archivo->getClientOriginalName();
            $archivo->storeAs('archivos', $nombreArchivo, 'public');

            $archivosExistentes[] = [
                'nombre' => $nombreArchivo,
                'fecha_subida' => now()->toDateTimeString(),
            ];
        }
    }

    $ticket->adjuntos = json_encode($archivosExistentes);
    $ticket->save();

    return redirect()->back()->with('success', 'Archivos guardados correctamente.');
}

     public function descargar($nombre)
    {
       $ruta = Storage::disk('public')->path('archivos/' . $nombre);


        if (!file_exists($ruta)) {
            abort(404, 'Archivo no encontrado');
        }

        return response()->download($ruta);
    }
  public function eliminarArchivo($ticketId, $archivo)
{
    $ticket = Ticket_Interno::findOrFail($ticketId);
    $adjuntos = json_decode($ticket->adjuntos, true) ?? [];

  $rutaArchivo = Storage::disk('public')->path('archivos/' . $archivo);
    if (Storage::disk('public')->exists('archivos/' . $archivo)) {
        Storage::disk('public')->delete('archivos/' . $archivo);
    }


  
    $adjuntos = array_filter($adjuntos, function ($item) use ($archivo) {
        return $item['nombre'] !== $archivo;
    });

    $ticket->adjuntos = json_encode(array_values($adjuntos));
    $ticket->save();

    return redirect()->back()->with('success', 'Archivo eliminado correctamente.');
}
    public function Globales(Request $request)
    {
        $username = Auth::user()->username;
    
      
        $query = Ticket_Interno::query();
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
        
     
       
        $query->orderBy('creado', 'desc');

        $tickets = $query->paginate(10)->appends($request->all());
    
        return view('tickets_internos.globales', compact('username', 'tickets'));
    }
    
    public function Abiertos(Request $request)
    {
        $username = Auth::user()->username;
    
        
         $query = Ticket_Interno::whereIn('estado', ['Abierto', 'En Curso']);

    
     
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
     if ($request->filled('estado')) {
            $query->where('estado', 'like', '%' . $request->input('estado') . '%');
        }
        
        $tickets = $query->paginate(10)->appends($request->all());
    
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
    
    
        $tickets = $query->paginate(10)->appends($request->all());
    
        return view('tickets_internos.cerradas', compact('username', 'tickets'));
    }
    
    public function ParaMi(Request $request)
    {
        $username = Auth::user()->username;
        $userId = Auth::user()->id;
    
        // Obtengo los IDs de tickets asignados a este usuario
        $assignedTicketIds = Asignados_Internos::where('id_user', $userId)->pluck('id_ticket')->toArray();
    
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
    
      
        $tickets = $query->paginate(10)->appends($request->all());
    
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
    
            Asignados_Internos::updateOrCreate(
                ['id_ticket' => $id_ticket],
                ['id_user' => $id_user]
            );
        
            $user = User::find($id_user);
            $username = $user ? $user->username : null;

            Ticket_Interno::where('id', $id_ticket)->update([
                'asignado' => Carbon::now()->format('Y-m-d H:i:s'),
                'estado'=>"En Curso",
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

     public function MisPeticiones(Request $request)
    {
           $username = Auth::user()->username;
    
         $query= Ticket_Interno::where('solicitante', $username);
    
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
    
      
        $tickets = $query->paginate(10)->appends($request->all());

    
        return view('tickets_internos.mis-peticiones', compact('username', 'tickets'));

         
    }
    
}
