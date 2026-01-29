<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - Sistema Médico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .register-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 500px;
            width: 100%;
        }

        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .register-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 32px;
        }

        .register-header h1 {
            color: #333;
            font-size: 28px;
            font-weight: 700;
            margin: 0;
        }

        .register-header p {
            color: #666;
            margin-top: 8px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background-color: #fff;
        }

        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 16px;
            margin-top: 10px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .error-alert {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
            color: #856404;
            font-size: 14px;
        }

        .error-list {
            margin: 0;
            padding-left: 20px;
        }

        .error-list li {
            margin-bottom: 5px;
        }

        .password-requirements {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px;
            margin-top: 10px;
            font-size: 12px;
            color: #666;
        }

        .requirement {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
        }

        .requirement i {
            font-size: 12px;
        }

        .requirement.met {
            color: #28a745;
        }

        .requirement.unmet {
            color: #dc3545;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 12px;
            position: absolute;
            bottom: 20px;
            width: 100%;
        }

        .form-text {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <div class="register-icon">
                <i class="bi bi-person-plus"></i>
            </div>
            <h1>Crear Cuenta</h1>
            <p>Únete a nuestro sistema médico</p>
        </div>

        {{-- Mensajes de error --}}
        @if ($errors->any())
            <div class="error-alert">
                <i class="bi bi-exclamation-circle"></i> Por favor, revisa los siguientes errores:
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Nombre --}}
            <div class="form-group">
                <label for="name" class="form-label">
                    <i class="bi bi-person"></i> Nombre Completo
                </label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name') }}" 
                       placeholder="Juan Pérez" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label for="email" class="form-label">
                    <i class="bi bi-envelope"></i> Correo Electrónico
                </label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email') }}" 
                       placeholder="usuario@ejemplo.com" required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <div class="form-text">
                    <i class="bi bi-info-circle"></i> Usarás este correo para iniciar sesión
                </div>
            </div>

            {{-- Contraseña --}}
            <div class="form-group">
                <label for="password" class="form-label">
                    <i class="bi bi-lock"></i> Contraseña
                </label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" 
                       placeholder="Ingresa tu contraseña" required onkeyup="checkPassword()">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <div class="password-requirements" id="passwordReqs">
                    <div class="requirement unmet" id="req-length">
                        <i class="bi bi-x-circle"></i> Mínimo 6 caracteres
                    </div>
                    <div class="requirement unmet" id="req-upper">
                        <i class="bi bi-x-circle"></i> Al menos una mayúscula
                    </div>
                    <div class="requirement unmet" id="req-number">
                        <i class="bi bi-x-circle"></i> Al menos un número
                    </div>
                </div>
            </div>

            {{-- Confirmar Contraseña --}}
            <div class="form-group">
                <label for="password_confirmation" class="form-label">
                    <i class="bi bi-lock-check"></i> Confirmar Contraseña
                </label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                       id="password_confirmation" name="password_confirmation" 
                       placeholder="Repite tu contraseña" required>
                @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Botón de Registro --}}
            <button type="submit" class="btn-register">
                <i class="bi bi-person-check"></i> Crear Cuenta
            </button>

            {{-- Enlace al Login --}}
            <div class="login-link">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a>
            </div>
        </form>
    </div>

    <footer>
        <p>© 2026 Sistema Médico. Todos los derechos reservados.</p>
    </footer>

    <script>
        function checkPassword() {
            const password = document.getElementById('password').value;
            const reqLength = document.getElementById('req-length');
            const reqUpper = document.getElementById('req-upper');
            const reqNumber = document.getElementById('req-number');

            // Verificar longitud
            if (password.length >= 6) {
                reqLength.classList.remove('unmet');
                reqLength.classList.add('met');
                reqLength.innerHTML = '<i class="bi bi-check-circle"></i> Mínimo 6 caracteres';
            } else {
                reqLength.classList.remove('met');
                reqLength.classList.add('unmet');
                reqLength.innerHTML = '<i class="bi bi-x-circle"></i> Mínimo 6 caracteres';
            }

            // Verificar mayúscula
            if (/[A-Z]/.test(password)) {
                reqUpper.classList.remove('unmet');
                reqUpper.classList.add('met');
                reqUpper.innerHTML = '<i class="bi bi-check-circle"></i> Al menos una mayúscula';
            } else {
                reqUpper.classList.remove('met');
                reqUpper.classList.add('unmet');
                reqUpper.innerHTML = '<i class="bi bi-x-circle"></i> Al menos una mayúscula';
            }

            // Verificar número
            if (/[0-9]/.test(password)) {
                reqNumber.classList.remove('unmet');
                reqNumber.classList.add('met');
                reqNumber.innerHTML = '<i class="bi bi-check-circle"></i> Al menos un número';
            } else {
                reqNumber.classList.remove('met');
                reqNumber.classList.add('unmet');
                reqNumber.innerHTML = '<i class="bi bi-x-circle"></i> Al menos un número';
            }
        }
    </script>
</body>
</html>