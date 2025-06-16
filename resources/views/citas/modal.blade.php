<!-- Modal Nueva Cita -->
<div class="modal fade" id="nuevaCitaModal" tabindex="-1" aria-labelledby="nuevaCitaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevaCitaModalLabel">Nueva Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formCita" action="{{ route('citas.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="paciente" class="form-label">Nombre del Paciente *</label>
                                <input type="text" class="form-control" id="paciente" name="paciente" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="psicologo" class="form-label">Psicólogo *</label>
                                <input type="text" class="form-control" id="psicologo" name="psicologo" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha *</label>
                                <input type="date" class="form-control" id="fecha" name="fecha"
                                    min="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="hora" class="form-label">Hora *</label>
                                <input type="time" class="form-control" id="hora" name="hora" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="duracion" class="form-label">Duración (min) *</label>
                                <select class="form-select" id="duracion" name="duracion" required>
                                    <option value="30">30 minutos</option>
                                    <option value="45" selected>45 minutos</option>
                                    <option value="60">60 minutos</option>
                                    <option value="90">90 minutos</option>
                                    <option value="120">120 minutos</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado">
                            <option value="programada" selected>Programada</option>
                            <option value="confirmada">Confirmada</option>
                            <option value="completada">Completada</option>
                            <option value="cancelada">Cancelada</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="notas" class="form-label">Notas (opcional)</label>
                        <textarea class="form-control" id="notas" name="notas" rows="3"
                            placeholder="Observaciones adicionales sobre la cita..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Guardar Cita
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Cita -->
<div class="modal fade" id="editarCitaModal" tabindex="-1" aria-labelledby="editarCitaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarCitaModalLabel">Editar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarCita" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_paciente" class="form-label">Nombre del Paciente *</label>
                                <input type="text" class="form-control" id="edit_paciente" name="paciente" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_psicologo" class="form-label">Psicólogo *</label>
                                <input type="text" class="form-control" id="edit_psicologo" name="psicologo" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_fecha" class="form-label">Fecha *</label>
                                <input type="date" class="form-control" id="edit_fecha" name="fecha" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_hora" class="form-label">Hora *</label>
                                <input type="time" class="form-control" id="edit_hora" name="hora" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_duracion" class="form-label">Duración (min) *</label>
                                <select class="form-select" id="edit_duracion" name="duracion" required>
                                    <option value="30">30 minutos</option>
                                    <option value="45">45 minutos</option>
                                    <option value="60">60 minutos</option>
                                    <option value="90">90 minutos</option>
                                    <option value="120">120 minutos</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_estado" class="form-label">Estado</label>
                        <select class="form-select" id="edit_estado" name="estado">
                            <option value="programada">Programada</option>
                            <option value="confirmada">Confirmada</option>
                            <option value="completada">Completada</option>
                            <option value="cancelada">Cancelada</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_notas" class="form-label">Notas (opcional)</label>
                        <textarea class="form-control" id="edit_notas" name="notas" rows="3"
                            placeholder="Observaciones adicionales sobre la cita..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Actualizar
                        Cita</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Manejar edición de citas
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-editar').forEach(btn => {
            btn.addEventListener('click', function () {
                const citaId = this.dataset.id;

                fetch(`/citas/${citaId}/edit-data`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al obtener los datos de la cita');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Llenar el formulario de edición
                        document.getElementById('edit_paciente').value = data.paciente;
                        document.getElementById('edit_psicologo').value = data.psicologo;
                        document.getElementById('edit_fecha').value = data.fecha;
                        document.getElementById('edit_hora').value = data.hora;
                        document.getElementById('edit_duracion').value = data.duracion;
                        document.getElementById('edit_estado').value = data.estado;
                        document.getElementById('edit_notas').value = data.notas || '';

                        // Actualizar la acción del formulario
                        document.getElementById('formEditarCita').action = `/citas/${citaId}`;

                        // Mostrar el modal
                        const modal = new bootstrap.Modal(document.getElementById('editarCitaModal'));
                        modal.show();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al cargar los datos de la cita');
                    });
            });
        });
    });
</script>