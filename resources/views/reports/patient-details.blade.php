@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-person-circle text-primary me-2"></i>
                Reportes de {{ $patient->name }}
            </h1>
            <div>
                <a href="{{ route('reports.index') }}" class="btn btn-secondary btn-sm me-2">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
                @if($patient->reports->count() > 0)
                    <a href="{{ route('reports.download', $patient->id) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-download"></i> Descargar PDF
                    </a>
                @endif
            </div>
        </div>

        <div class="row">
            <!-- Información del Paciente -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Información del Paciente</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Nombre:</strong> {{ $patient->name }}</p>
                        <p><strong>Email:</strong> {{ $patient->email }}</p>
                        <p><strong>Registrado:</strong> {{ $patient->created_at->format('d/m/Y') }}</p>
                        <p><strong>Total de Reportes:</strong> {{ $patient->reports->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Lista de Reportes -->
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Reportes Médicos ({{ $patient->reports->count() }})
                        </h6>
                    </div>
                    <div class="card-body">
                        @if($patient->reports->count() > 0)
                            @foreach($patient->reports->sortByDesc('created_at') as $report)
                                <div class="card mb-3 border-left-primary">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center mb-2">
                                                    <h6 class="card-title text-primary mb-0 me-3">{{ $report->title }}</h6>
                                                    <span class="badge bg-info">{{ ucfirst($report->type) }}</span>
                                                </div>
                                                <div class="card-text mb-2">
                                                    {!! nl2br(e($report->content)) !!}
                                                </div>
                                                @if($report->creator)
                                                    <small class="text-muted">
                                                        <i class="bi bi-person"></i> Creado por: {{ $report->creator->name }}
                                                    </small>
                                                @endif
                                            </div>
                                            <div class="text-end">
                                                <small class="text-muted d-block">
                                                    {{ $report->created_at->format('d/m/Y') }}
                                                </small>
                                                <small class="text-muted">
                                                    {{ $report->created_at->format('H:i') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-file-earmark-text display-4 text-muted"></i>
                                <h5 class="mt-3">No hay reportes disponibles</h5>
                                <p class="text-muted">Este paciente aún no tiene reportes médicos registrados.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection