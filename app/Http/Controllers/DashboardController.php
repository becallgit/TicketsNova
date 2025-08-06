<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Team;
use App\Models\Ticket_Interno;
use App\Models\Ticket_Asignado;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Exports\TicketsExport;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index()
    {
        $username = Auth::user()->username;
        $userRole = Auth::user()->rol;
        $userTeamId = Auth::user()->team_id;
    
        $assignedTicketIds = Ticket_Asignado::pluck('id_ticket')->toArray();
        $ticketsAbiertos = "";
        $ticketsSinAsignar = "";
        $ticketsPorEquipo = "";
        $teamName = "";
    
        if ($userRole == 'admin') {
            $ticketsPorEquipo = Team::withCount([
                'tickets as tickets_abiertos' => function ($query) {
                    $query->whereIn('estado', ['Abierto', 'En Curso']);

                },
                'tickets as tickets_sin_asignar' => function ($query) use ($assignedTicketIds) {
                    $query->whereNotIn('id', $assignedTicketIds);
                }
            ])->get();
        } else {
            $ticketsAbiertos = Ticket::whereIn('estado', ['Abierto', 'En Curso'])
                        ->where('team_id', $userTeamId)
                        ->count();

            $ticketsSinAsignar = Ticket::whereNotIn('id', $assignedTicketIds)
                                        ->where('team_id', $userTeamId)
                                        ->count();
            $teamName = Team::where('id', $userTeamId)->value('nombre'); 
        }
        $paraTatiana = Ticket_Interno::where('estado', 'En Curso')
        ->where('para', 'tatiana.pizarro')
        ->count();
        $paraIgnacio = Ticket_Interno::where('estado', 'En Curso')
        ->where('para', 'ignaciof.caravia')
        ->count();
          $paraInma = Ticket_Interno::where('estado', 'En Curso')
        ->where('para', 'inma.salguero')
        ->count();
         $abiertos = Ticket_Interno::where('estado', 'Abierto')
        
        ->count();
        return view('dashboard', compact('abiertos','paraTatiana','paraIgnacio','paraInma','username', 'userRole', 'ticketsPorEquipo', 'ticketsAbiertos', 'ticketsSinAsignar', 'teamName'));
    }
    

    
        public function export()
        {
               $actual = Carbon::now()->format('d-m-Y');
            return Excel::download(new TicketsExport, "TICKETS-NOVA-$actual.xlsx");
        }
            
}
