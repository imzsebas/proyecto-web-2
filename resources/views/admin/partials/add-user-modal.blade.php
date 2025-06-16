<!-- Modal Agregar Usuario -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2"></i>Agregar Nuevo Usuario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="addUserForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="addName" class="form-label">
                                    <i class="fas fa-user me-2"></i>Nombre completo *
                                </label>
                                <input type="text" class="form-control" id="addName" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="addEmail" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Correo electrónico *
                                </label>
                                <input type="email" class="form-control" id="addEmail" name="email" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="addPhone" class="form-label">
                                    <i class="fas fa-phone me-2"></i>Teléfono *
                                </label>
                                <input type="tel" class="form-control" id="addPhone" name="phone" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="addAge" class="form-label">
                                    <i class="fas fa-birthday-cake me-2"></i>Edad *
                                </label>
                                <input type="number" class="form-control" id="addAge" name="age" min="18" max="99" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="addOccupation" class="form-label">
                                    <i class="fas fa-briefcase me-2"></i>Ocupación
                                </label>
                                <input type="text" class="form-control" id="addOccupation" name="occupation">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="addRole" class="form-label">
                                    <i class="fas fa-user-tag me-2"></i>Rol *
                                </label>
                                <select class="form-control" id="addRole" name="role" required>
                                    <option value="">Seleccionar rol</option>
                                    <option value="paciente">Paciente</option>
                                    <option value="psicologo">Psicólogo</option>
                                    <option value="admin">Administrador</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="addPassword" class="form-label">
                            <i class="fas fa-lock me-2"></i>Contraseña *
                        </label>
                        <input type="password" class="form-control" id="addPassword" name="password" minlength="8" required>
                        <div class="form-text">Mínimo 8 caracteres</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" id="addUserSubmit">
                        <i class="fas fa-plus me-2"></i>Crear Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>