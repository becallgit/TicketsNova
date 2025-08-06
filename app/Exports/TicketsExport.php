<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TicketsExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new TickersScriptSheetExport(),
            new TicketsInternosSheetExport(),
        ];
    }
}
