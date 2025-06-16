<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Médico - {{ $patient->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            font-size: 12px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 24px;
        }
        .patient-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .patient-info h2 {
            color: #007bff;
            margin-top: 0;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
            font-size: 18px;
        }
        .info-row {
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
        .report-item {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            break-inside: avoid;
        }
        .report-title {
            color: #007bff;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
        }
        .report-type {
            font-size: 12px;
            color: #6c757d;
            font-weight: normal;
            float: right;
        }
        .report-section {
            margin-bottom: 12px;
        }
        .report-section h4 {
            color: #495057;
            margin-bottom: 5px;
            font-size: 14px;
        }
        .report-section p {
            margin: 0;
            line-height: 1.5;
        }
        .report-date {
            color: #6c757d;
            font-size: 11px;
            text-align: right;
            margin-top: 10px;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte Médico Completo</h1>
        <p>Sistema de Gestión Médica</p>
    </div>

    <div class="patient-info">
        <h2>Información del Paciente</h2>
        <div class="info-row">
            <span class="info-label">Nombre:</span>
            <span>{{ $patient->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email:</span>
            <span>{{ $patient->email }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Registrado:</span>
            <span>{{ $patient->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total Reportes:</span>
            <span>{{ $patient->reports->count() }}</span>
        </div>
    </div>

    <h2 style="color: #007bff; border-bottom: 2px solid #007bff; padding-bottom: 10px; font-size: 18px;">
        Historial de Reportes Médicos
    </h2>

    @foreach($patient->reports->sortByDesc('created_at') as $report)
        <div class="report-item">
            <div class="report-title">
                {{ $report->title }}
                <span class="report-type">Tipo: {{ ucfirst($report->type) }}</span>
            </div>
            
            <div class="report-section">
                <h4>Contenido del Reporte:</h4>
                <p>{!! nl2br(e($report->content)) !!}</p>
            </div>

            @if($report->creator)
                <div class="report-section">
                    <h4>Creado por:</h4>
                    <p>{{ $report->creator->name }}</p>
                </div>
            @endif

            <div class="report-date">
                Fecha de creación: {{ $report->created_at->format('d/m/Y H:i') }}
                @if($report->updated_at != $report->created_at)
                    <br>Última actualización: {{ $report->updated_at->format('d/m/Y H:i') }}
                @endif
            </div>
        </div>
    @endforeach

    <div class="footer">
        <p>Documento generado el {{ now()->format('d/m/Y H:i') }}</p>
        <p>Sistema de Gestión Médica - Reporte Confidencial</p>
    </div>
</body>
</html>