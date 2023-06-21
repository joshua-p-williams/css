<?php

namespace App\Http\Controllers;

use App\Exports\IndividualResultsExport;
use App\Exports\TeamResultsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function individualResults()
    {
        return (new IndividualResultsExport())->download('individual_results.xlsx');
    }

    public function teamResults()
    {
        return (new TeamResultsExport())->download('team_results.xlsx');
    }
}
