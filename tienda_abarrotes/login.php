<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Tienda de Abarrotes</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- zxcvbn for password strength -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
    <!-- Particles.js -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            overflow: hidden;
            background-color: #1a1a1a;
        }

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -2;
            background-image: url('https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=1950&q=80'); /* Imagen de ejemplo */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .glass-card {
            backdrop-filter: blur(12px);
            background: rgba(0, 0, 0, 0.4);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            padding: 2rem;
            max-width: 360px;
            width: 90%;
            color: #fff;
        }

        .logo {
            font-size: 3rem;
            text-align: center;
            margin-bottom: 1rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .form-control {
            border-radius: 50px;
            padding-left: 2.5rem;
            background-color: rgba(255,255,255,0.1);
            color: #fff;
            border: none;
        }

        .form-control::placeholder {
            color: #ccc;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.4);
            background-color: rgba(255,255,255,0.15);
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #fff;
        }

        .btn-login {
            border-radius: 50px;
            padding: 0.75rem;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 20px rgba(0,0,0,0.4);
        }

        .show-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #fff;
        }

        .strength-meter {
            height: 5px;
            border-radius: 4px;
            background: rgba(255,255,255,0.3);
            overflow: hidden;
            margin-top: -10px;
            margin-bottom: 10px;
        }

        .strength-meter > div {
            height: 100%;
            width: 0;
            transition: width 0.3s;
        }

        a {
            color: #fff;
            text-decoration: underline;
        }

        a:hover {
            color: #f0c040;
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="glass-card text-center">
            <div class="logo"><i class="bi bi-basket-fill"></i></div>
            <h3 class="mb-2">Bienvenido a Tu Abarrotera</h3>
            <p class="mb-4">Accede a tu cuenta y disfruta de lo mejor en abarrotes</p>

            <?php if(isset($_GET['error'])): ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '<?= htmlspecialchars($_GET['error']) ?>'
                    });
                </script>
            <?php endif; ?>

            <form id="loginForm" method="POST" action="procesar_login.php" novalidate>
                <div class="mb-3 position-relative">
                    <i class="bi bi-envelope-fill input-icon"></i>
                    <input type="email" name="correo" id="correo" class="form-control" placeholder="Correo electrónico" required>
                    <div class="invalid-feedback text-start">Ingresa un correo válido.</div>
                </div>
                <div class="mb-1 position-relative">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required minlength="8">
                    <i class="bi bi-eye show-password" id="togglePassword"></i>
                    <div class="invalid-feedback text-start">La contraseña debe tener al menos 8 caracteres.</div>
                </div>
                <div class="strength-meter"><div id="strengthBar"></div></div>
                <div class="form-check text-start mb-4 ms-2">
                    <input class="form-check-input" type="checkbox" name="rememberMe" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Recuérdame</label>
                </div>
                <button type="submit" class="btn btn-light btn-login w-100">Ingresar</button>
            </form>
            <p class="mt-3"><a href="#">¿Olvidaste tu contraseña?</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Particles.js configuración
        particlesJS("particles-js", {
            particles: {
                number: { value: 60 },
                shape: {
                    type: ['image'],
                    image: [
                        { src: 'https://i.imgur.com/4G0deIy.png', width: 32, height: 32 },
                        { src: 'https://i.imgur.com/CzXTtJV.png', width: 32, height: 32 }
                    ]
                },
                opacity: { value: 0.8 },
                size: { value: 10, random: true },
                move: { speed: 1.5 }
            },
            interactivity: {
                events: {
                    onhover: { enable: true, mode: 'grab' }
                }
            }
        });

        // Mostrar/ocultar contraseña
        const toggle = document.querySelector('#togglePassword');
        const pwd = document.querySelector('#password');
        toggle.addEventListener('click', () => {
            const type = pwd.getAttribute('type') === 'password' ? 'text' : 'password';
            pwd.setAttribute('type', type);
            toggle.classList.toggle('bi-eye-slash');
        });

        // Medidor de fuerza de contraseña
        const strengthBar = document.getElementById('strengthBar');
        pwd.addEventListener('input', () => {
            const val = pwd.value;
            const score = zxcvbn(val).score;
            const widths = ['0%', '25%', '50%', '75%', '100%'];
            const colors = ['transparent', 'red', 'orange', 'yellow', 'lightgreen'];
            strengthBar.style.width = widths[score];
            strengthBar.style.background = colors[score];
        });

        // Validación de formulario
        (function() {
            const form = document.getElementById('loginForm');
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        })();
    </script>
</body>
</html>
