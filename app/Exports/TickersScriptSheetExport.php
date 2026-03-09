<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TickersScriptSheetExport implements FromCollection, WithMapping, WithHeadings, WithTitle, WithStyles, WithColumnWidths
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Ticket::with(['team', 'asignaciones.user']);

        if (!empty($this->filters['para'])) {
            $query->where('team_id', $this->filters['para']);
        }

        if (!empty($this->filters['matricula'])) {
            $query->where('matricula', 'like', '%' . $this->filters['matricula'] . '%');
        }

        if (!empty($this->filters['creado_desde'])) {
            $query->whereDate('creado', '>=', $this->filters['creado_desde']);
        }

        if (!empty($this->filters['creado_hasta'])) {
            $query->whereDate('creado', '<=', $this->filters['creado_hasta']);
        }

        return $query->get();
    }

    public function map($ticket): array
    {
        // Obtener todos los usernames de usuarios asignados
        $asignadoA = $ticket->asignaciones->pluck('user.username')->join(', ') ?: 'No asignado';

        return [
            $ticket->id,
            $ticket->nombre_cliente,
            optional($ticket->team)->nombre,
            $asignadoA,
            $ticket->matricula,
            $ticket->bastidor,
            $ticket->telefono,
            $ticket->observaciones_ticket,
            $ticket->estado,
            $ticket->creado,
            $ticket->asignado,
            $ticket->cerrado,
            $ticket->presupuesto,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre Cliente',
            'Cliente', 
              'Asignado A',
            'Matricula',
            'Bastidor',
            'Telefono',
            'Observaciones Ticket',
            'Estado',
            'Creado',
            'Asignado',
            'Cerrado',
            'Presupuesto',
        ];
    }

    public function title(): string
    {
        return 'Tickers Script';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 25,
            'C' => 25,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 35,
            'H' => 15,
            'I' => 20,
            'J' => 25,
            'K' => 20,
            'L' => 20,
        ];
    }
}
