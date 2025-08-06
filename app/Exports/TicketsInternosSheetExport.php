<?php

namespace App\Exports;

use App\Models\Ticket_Interno;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketsInternosSheetExport implements FromCollection, WithMapping, WithHeadings, WithTitle, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return Ticket_Interno::with(['asignaciones.user'])->get();
    }

    public function map($ticket): array
    {
      $asignadoA = $ticket->asignaciones->pluck('user.username')->join(', ') ?: 'No asignado';


        return [
            $ticket->id,
            $ticket->solicitante,
            $ticket->para,
            $asignadoA,
            $ticket->tipo_solicitud,
            $ticket->cliente,
            $ticket->marca,
            $ticket->sede,
            $ticket->observaciones,
            $ticket->estado,
            $ticket->creado,  
            $ticket->cerrado,
            $ticket->adjuntos,
            $ticket->answer_client,
            $ticket->ask_nova,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Solicitante',
            'Para',
            'Asignado A',
            'Tipo Solicitud',
            'Cliente',
            'Marca',
            'Sede',
            'Observaciones',
            'Estado',
            'Creado',
            
            'Cerrado',
            'Adjuntos',
            'Respuesta Cliente',
            'Pregunta Nova',
        ];
    }

    public function title(): string
    {
        return 'Tickets Internos';
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
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 30,
            'I' => 15,
            'J' => 20,
            'K' => 25,
            'L' => 20,
            'M' => 25,
            'N' => 25,
            'O' => 25,
        ];
    }
}
