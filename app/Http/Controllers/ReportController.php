<?php

// 1. CONTROLADOR ACTUALIZADO (app/Http/Controllers/ReportController.php)
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PatientReport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    public function index()
    {
        $patients = User::where('role', 'paciente')
                       ->select('id', 'name', 'email', 'created_at', 'updated_at')
                       ->withCount('reports')
                       ->orderBy('name')
                       ->get();
        
        return view('reports.index', compact('patients'));
    }

    public function downloadPatientReports($patientId)
    {
        $patient = User::where('id', $patientId)
                      ->where('role', 'paciente')
                      ->with(['reports.creator'])
                      ->first();

        if (!$patient) {
            return back()->with('error', 'Paciente no encontrado.');
        }
        
        if ($patient->reports->isEmpty()) {
            return back()->with('error', 'Este paciente no tiene reportes disponibles.');
        }

        $pdf = Pdf::loadView('reports.patient-pdf', compact('patient'));
        
        $filename = 'reporte_' . str_replace(' ', '_', strtolower($patient->name)) . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    public function viewPatientReports($patientId)
    {
        $patient = User::where('id', $patientId)
                      ->where('role', 'paciente')
                      ->with(['reports.creator'])
                      ->first();

        if (!$patient) {
            return back()->with('error', 'Paciente no encontrado.');
        }
        
        return view('reports.patient-details', compact('patient'));
    }
}