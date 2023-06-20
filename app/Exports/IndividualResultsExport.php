<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\IndividualResultsByCategoryAndEvent;
use App\CategoryCompletion;

class IndividualResultsExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [];

        $categoryEvents = CategoryCompletion::orderBy('category_id', 'event_id')->get();

        foreach($categoryEvents as $categoryEvent) {
            $sheets[] = new IndividualResultsByCategoryAndEvent($categoryEvent->category_id, $categoryEvent->category_name, $categoryEvent->event_id, $categoryEvent->event_name);
        }

        return $sheets;
    }
}
