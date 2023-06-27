<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\IndividualResultsByCategoryAndEvent;
use App\CategoryCompletion;
use App\Exports\Sheets\OverallResultsByCategory;

class IndividualResultsExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $categories = [];
        $sheets = [];

        $categoryEvents = CategoryCompletion::orderBy('category_id', 'event_id')->get();

        foreach($categoryEvents as $categoryEvent) {
            // If the category isn't found in $categories, add it
            if (!array_key_exists($categoryEvent->category_id, $categories)) {
                $categories[$categoryEvent->category_id] = $categoryEvent->category_name;
            }

            $sheets[] = new IndividualResultsByCategoryAndEvent($categoryEvent->category_id, $categoryEvent->category_name, $categoryEvent->event_id, $categoryEvent->event_name);
        }

        $overallSheets = [];
        foreach($categories as $categoryId => $categoryName) {
            $overallSheets[] = new OverallResultsByCategory($categoryId, $categoryName);
        }

        // Add the overall results to the beginning of the sheets array
        array_unshift($sheets, ...$overallSheets);

        return $sheets;
    }
}
