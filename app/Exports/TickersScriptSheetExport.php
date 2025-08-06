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
    public function collection()
    {
        return Ticket::with(['team', 'asignaciones.user'])->get();
    }

    public function map($ticket): array
    {
        // Obtener todos los usernames de usuarios asignados
        $asignadoA = $ticket->asignaciones->pluck('user.username')->join(', ') ?: 'No asignado';

        return [
            $ticket->id,
            $ticket->nombre_cliente,
            optional($ticket->team)->nombre,
            $ticket->matricula,
            $ticket->bastidor,
            $ticket->telefono,
            $ticket->observaciones_ticket,
            $ticket->estado,
            $ticket->creado,
            $asignadoA,
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
            'Matricula',
            'Bastidor',
            'Telefono',
            'Observaciones Ticket',
            'Estado',
            'Creado',
            'Asignado A',
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
