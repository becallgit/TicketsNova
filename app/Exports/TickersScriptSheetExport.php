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
        return Ticket::with('team')->get(); 
    }

    public function map($ticket): array
    {
        return [
            $ticket->nombre_cliente,
            optional($ticket->team)->nombre,
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
            'Nombre Cliente',
            'Cliente', 
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
            'A' => 20, 'B' => 25, 'C' => 20, 'D' => 20,
            'E' => 20, 'F' => 20, 'G' => 30, 'H' => 15,
            'I' => 20, 'J' => 20, 'K' => 20, 'L' => 20,
            'M' => 20, 'N' => 20, 'O' => 25, 'P' => 20,
        ];
    }
}
