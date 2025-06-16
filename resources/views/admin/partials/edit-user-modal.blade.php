<!-- Modal Editar Usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">
                    <i class="fas fa-user-edit me-2"></i>Editar Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editUserForm">
                <input type="hidden" id="editUserId" name="user_id">
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editName" class="form-label">
                                    <i class="fas fa-user me-2"></i>Nombre completo *
                                </label>
                                <input type="text" class="form-control" id="editName" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editEmail" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Correo electrónico *
                                </label>
                                <input type="email" class="form-control" id="editEmail" name="email" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editPhone" class="form-label">
                                    <i class="fas fa-phone me-2"></i>Teléfono *
                                </label>
                                <input type="tel" class="form-control" id="editPhone" name="phone" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editAge" class="form-label">
                                    <i class="fas fa-birthday-cake me-2"></i>Edad *
                                </label>
                                <input type="number" class="form-control" id="editAge" name="age" min="18" max="99" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editOccupation" class="form-label">
                                    <i class="fas fa-briefcase me-2"></i>Ocupación
                                </label>
                                <input type="text" class="form-control" id="editOccupation" name="occupation">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editRole" class="form-label">
                                    <i class="fas fa-user-tag me-2"></i>Rol *
                                </label>
                                <select class="form-control" id="editRole" name="role" required>
                                    <option value="paciente">Paciente</option>
                                    <option value="psicologo">Psicólogo</option>
                                    <option value="admin">Administrador</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editPassword" class="form-label">
                            <i class="fas fa-lock me-2"></i>Nueva contraseña
                        </label>
                        <input type="password" class="form-control" id="editPassword" name="password" minlength="8">
                        <div class="form-text">Dejar en blanco para mantener la contraseña actual</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning" id="editUserSubmit">
                        <i class="fas fa-save me-2"></i>Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>