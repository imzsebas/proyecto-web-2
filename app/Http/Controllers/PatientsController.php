<?php
// app/Http/Controllers/PatientsController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PatientNote;
use App\Models\PatientReport;
use Illuminate\Support\Facades\Auth;

class PatientsController extends Controller
{
    public function index()
    {
        $patients = User::where('role', 'paciente')
                       ->select('id', 'name', 'email', 'created_at')
                       ->withCount(['notes', 'reports'])
                       ->get();
        
        return response()->json($patients);
    }

    public function storeNote(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000'
        ]);

        $note = PatientNote::create([
            'patient_id' => $request->patient_id,
            'created_by' => Auth::id(),
            'content' => $request->content
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Nota agregada exitosamente',
            'note' => $note->load('creator')
        ]);
    }

    public function storeReport(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'string|in:general,diagnostico,seguimiento,tratamiento'
        ]);

        $report = PatientReport::create([
            'patient_id' => $request->patient_id,
            'created_by' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type ?? 'general'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reporte agregado exitosamente',
            'report' => $report->load('creator')
        ]);
    }

    public function getPatientDetails($id)
    {
        $patient = User::where('id', $id)
                      ->where('role', 'paciente')
                      ->with(['notes.creator', 'reports.creator'])
                      ->first();

        if (!$patient) {
            return response()->json(['error' => 'Paciente no encontrado'], 404);
        }

        return response()->json($patient);
    }

    public function getPatientNotes($patientId)
    {
        $patient = User::where('id', $patientId)
                      ->where('role', 'paciente')
                      ->first();

        if (!$patient) {
            return response()->json(['error' => 'Paciente no encontrado'], 404);
        }

        $notes = PatientNote::where('patient_id', $patientId)
                           ->with('creator:id,name')
                           ->orderBy('created_at', 'desc')
                           ->get();

        return response()->json([
            'patient' => $patient,
            'notes' => $notes
        ]);
    }

    public function getPatientReports($patientId)
    {
        $patient = User::where('id', $patientId)
                      ->where('role', 'paciente')
                      ->first();

        if (!$patient) {
            return response()->json(['error' => 'Paciente no encontrado'], 404);
        }

        $reports = PatientReport::where('patient_id', $patientId)
                               ->with('creator:id,name')
                               ->orderBy('created_at', 'desc')
                               ->get();

        return response()->json([
            'patient' => $patient,
            'reports' => $reports
        ]);
    }

    public function deleteNote($id)
    {
        $note = PatientNote::find($id);

        if (!$note) {
            return response()->json(['error' => 'Nota no encontrada'], 404);
        }

        // Verificar que el usuario actual sea el creador o tenga permisos
        if ($note->created_by !== Auth::id()) {
            return response()->json(['error' => 'No tienes permisos para eliminar esta nota'], 403);
        }

        $note->delete();

        return response()->json([
            'success' => true,
            'message' => 'Nota eliminada exitosamente'
        ]);
    }

    public function deleteReport($id)
    {
        $report = PatientReport::find($id);

        if (!$report) {
            return response()->json(['error' => 'Reporte no encontrado'], 404);
        }

        // Verificar que el usuario actual sea el creador o tenga permisos
        if ($report->created_by !== Auth::id()) {
            return response()->json(['error' => 'No tienes permisos para eliminar este reporte'], 403);
        }

        $report->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reporte eliminado exitosamente'
        ]);
    }
}