<?php

namespace App\Exports;

use App\Models\Ticket_Interno;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketsInternosSheetExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return Ticket_Interno::select([
            'solicitante',
            'para',
            'tipo_solicitud',
            'cliente',
            'marca',
            'sede',
            'observaciones',
            'estado',
            'creado',
            'asignado',
            'cerrado',
            'adjuntos',
            'answer_client',
            'ask_nova',
        ])->get();
    }

    public function headings(): array
    {
        return [
            'Solicitante',
            'Para',
            'Tipo Solicitud',
            'Cliente',
            'Marca',
            'Sede',
            'Observaciones',
            'Estado',
            'Creado',
            'Asignado',
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
            'A' => 20, 'B' => 20, 'C' => 20, 'D' => 20,
            'E' => 20, 'F' => 20, 'G' => 30, 'H' => 15,
            'I' => 20, 'J' => 20, 'K' => 20, 'L' => 20,
            'M' => 25, 'N' => 25,
        ];
    }
}
