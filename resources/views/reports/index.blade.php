@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-graph-up text-primary me-2"></i>
                Estadísticas y Reportes
            </h1>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Lista de Pacientes</h6>
                    </div>
                    <div class="card-body">
                        @if($patients->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Reportes</th>
                                            <th>Registrado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($patients as $patient)
                                            <tr>
                                                <td>
                                                    <strong>{{ $patient->name }}</strong>
                                                </td>
                                                <td>{{ $patient->email }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $patient->reports_count > 0 ? 'success' : 'secondary' }}">
                                                        {{ $patient->reports_count }} reporte(s)
                                                    </span>
                                                </td>
                                                <td>{{ $patient->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('reports.patient', $patient->id) }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="bi bi-eye"></i> Ver Detalles
                                                        </a>
                                                        @if($patient->reports_count > 0)
                                                            <a href="{{ route('reports.download', $patient->id) }}"
                                                                class="btn btn-primary btn-sm">
                                                                <i class="bi bi-download"></i> Descargar PDF
                                                            </a>
                                                        @else
                                                            <button class="btn btn-secondary btn-sm" disabled>
                                                                <i class="bi bi-download"></i> Sin Reportes
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-inbox display-4 text-muted"></i>
                                <h4 class="mt-3">No hay pacientes registrados</h4>
                                <p class="text-muted">Agrega pacientes para poder generar reportes.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection