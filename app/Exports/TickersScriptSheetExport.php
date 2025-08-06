<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TickersScriptSheetExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return Ticket::select([
            'solicitante',
            'nombre_cliente',
            'team_id',
            'matricula',
            'bastidor',
            'telefono',
            'observaciones_ticket',
            'estado',
            'creado',
            'asignado',
            'cerrado',
            'tipo_incidencia',
            'presupuesto',
        ])->get();
    }

    public function headings(): array
    {
        return [
            'Solicitante',
            'Nombre Cliente',
            'Team ID',
            'Matricula',
            'Bastidor',
            'Telefono',
            'Observaciones Ticket',
            'Estado',
            'Creado',
            'Asignado',
            'Cerrado',
            'Tipo Incidencia',
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
            'A' => 20, 'B' => 25, 'C' => 15, 'D' => 20,
            'E' => 20, 'F' => 20, 'G' => 30, 'H' => 15,
            'I' => 20, 'J' => 20, 'K' => 20, 'L' => 20,
            'M' => 20, 'N' => 20, 'O' => 25, 'P' => 20,
        ];
    }
}
