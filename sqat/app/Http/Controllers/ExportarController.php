<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use App\Exports\ActivosExports;
use App\Exports\PersonasExports;
use App\Exports\ActivosPersonasExports;

class ExportarController extends Controller
{
    public function index()
    {
        return view('exportar');
    }

    public function exportar(Request $request, $tabla, $formato)
    {
        switch ($tabla) {
            case 'activos':
                $export = new ActivosExports();
                break;
            case 'personas':
                $export = new PersonasExports();
                break;
            case 'activos_personas':
                $export = new ActivosPersonasExports();
                break;
            default:
                abort(404);
        }

        $file = $export->export($formato);
        return response()->download($file)->deleteFileAfterSend(true);
    }
}