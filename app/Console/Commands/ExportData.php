<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Cita;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Patient;
use App\Models\PatientNote;
use App\Models\PatientReport;
use App\Models\EnlaceSesion;

class ExportData extends Command
{
    protected $signature = 'data:export';
    protected $description = 'Export data from SQLite';

    public function handle()
    {
        // Configurar SQLite con la ruta correcta
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => database_path('<database>database.sqlite')
        ]);
        
        $data = [
            'users' => User::all()->toArray(),
            'citas' => Cita::all()->toArray(),
            'conversations' => Conversation::all()->toArray(),
            'messages' => Message::all()->toArray(),
            'patients' => Patient::all()->toArray(),
            'patient_notes' => PatientNote::all()->toArray(),
            'patient_reports' => PatientReport::all()->toArray(),
            'enlaces_sesion' => EnlaceSesion::all()->toArray(),
        ];

        file_put_contents(storage_path('app/data_export.json'), json_encode($data, JSON_PRETTY_PRINT));
        $this->info('Data exported successfully!');
    }
}