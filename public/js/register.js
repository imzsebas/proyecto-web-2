document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Resetear mensajes de error previos
            document.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
            
            // Obtener el token CSRF
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Crear objeto FormData
            const formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('email', document.getElementById('email').value);
            formData.append('phone', document.getElementById('phone').value);
            formData.append('occupation', document.getElementById('occupation').value);
            formData.append('age', document.getElementById('age').value);
            formData.append('password', document.getElementById('password').value);
            formData.append('password_confirmation', document.getElementById('confirmPassword').value);
            
            // Verificar términos y condiciones
            if (!document.getElementById('terms').checked) {
                document.getElementById('terms').classList.add('is-invalid');
                return;
            }
            
            // Verificar si las contraseñas coinciden
            if (document.getElementById('password').value !== document.getElementById('confirmPassword').value) {
                document.getElementById('confirmPassword').classList.add('is-invalid');
                return;
            }
            
            // Mostrar spinner o deshabilitar botón
            const registerButton = document.getElementById('registerButton');
            const originalButtonText = registerButton.innerHTML;
            registerButton.disabled = true;
            registerButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...';
            
            // Realizar la petición AJAX
            fetch('/register', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Mostrar mensaje de éxito
                    document.getElementById('registerSuccessMessage').classList.remove('d-none');
                    document.getElementById('registerErrorMessage').classList.add('d-none');
                    
                    // Redireccionar después de 2 segundos
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 2000);
                } else {
                    // Mostrar mensaje de error
                    document.getElementById('registerErrorMessage').classList.remove('d-none');
                    document.getElementById('registerSuccessMessage').classList.add('d-none');
                    
                    // Marcar campos con error
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            const inputField = document.getElementById(field);
                            if (inputField) {
                                inputField.classList.add('is-invalid');
                            }
                        });
                    }
                    
                    // Restaurar botón
                    registerButton.disabled = false;
                    registerButton.innerHTML = originalButtonText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('registerErrorMessage').classList.remove('d-none');
                document.getElementById('registerSuccessMessage').classList.add('d-none');
                
                // Restaurar botón
                registerButton.disabled = false;
                registerButton.innerHTML = originalButtonText;
            });
        });
    }
});