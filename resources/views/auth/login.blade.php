<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Arsip Bahtsul Masail Al-Mahrusiyah</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
   
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            height: 100vh;
        }
        .login-banner {
            background: linear-gradient(135deg, #064e3b 0%, #022c22 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }
        .login-banner::before {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            top: -50px;
            left: -50px;
        }
        
        .right-form-container {
            position: relative;
            overflow: hidden;
        }
        .watermark-brand {
            position: absolute;
            right: -20px;
            bottom: -20px;
            font-size: 10rem;
            font-weight: 800;
            color: #064e3b;
            opacity: 0.03; 
            user-select: none;
            pointer-events: none;
            line-height: 1;
        }
        .btn-custom-success {
            background-color: #064e3b;
            border-color: #064e3b;
            transition: all 0.3s ease;
        }
        .btn-custom-success:hover {
            background-color: #022c22;
            border-color: #022c22;
            transform: translateY(-1px);
        }
        .form-control:focus {
            border-color: #064e3b;
            box-shadow: 0 0 0 0.25rem rgba(6, 78, 59, 0.15);
        }
    </style>
</head>
<body class="d-flex align-items-center">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="row g-0">
                        
                      
                        <div class="col-lg-6 login-banner d-flex flex-column justify-content-between p-5">
                            <div>
                                <div class="d-inline-flex align-items-center bg-white bg-opacity-10 px-3 py-1 rounded-pill mb-4">
                                    <span class="badge bg-warning text-dark me-2">Akun Resmi</span>
                                    <small class="text-light">LBM Al-Misky</small>
                                </div>
                                <h2 class="fw-bold mb-3">E-Arsip Bahtsul Masail</h2>
                                <p class="text-light opacity-75 mb-0">Pusat digitalisasi keputusan hukum dan perumusan masalah keagamaan yang dikelola oleh LBM Al-Misky.</p>
                            </div>
                            <div class="mt-5 pt-4 border-top border-light border-opacity-10">
                                <small class="text-white-50">© 2026 Pondok Pesantren Al-Mahrusiyah 3 Ngampel</small>
                            </div>
                        </div>

                     
                        <div class="col-lg-6 bg-white p-5 d-flex flex-column justify-content-center right-form-container">
                            
                           
                            <div class="watermark-brand">BM</div>

                            <div class="mb-4 position-relative">
                                <h3 class="fw-bold text-dark">Selamat Datang</h3>
                                <p class="text-muted small">Silakan masuk menggunakan akun administrator Anda.</p>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-3 py-2 small position-relative">
                                    @foreach ($errors->all() as $error)
                                        <div><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif

                            <form action="{{ route('login.process') }}" method="POST" class="position-relative">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-medium text-secondary small">Email Administrator</label>
                                    <input type="email" name="email" class="form-control form-control-lg fs-6" placeholder="admin@mail.com" value="{{ old('email') }}" required autofocus>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label fw-medium text-secondary small">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control form-control-lg fs-6 border-end-0" placeholder="••••••••" required>
                                        <button class="btn btn-outline-secondary border-start-0 bg-white text-muted" type="button" id="togglePassword">
                                            <i class="bi bi-eye" id="iconEye"></i>
                                        </button>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-custom-success btn-lg w-100 text-white fw-medium shadow-sm py-2">Masuk ke Sistem</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const iconEye = document.getElementById('iconEye');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            if (type === 'password') {
                iconEye.classList.remove('bi-eye-slash');
                iconEye.classList.add('bi-eye');
            } else {
                iconEye.classList.remove('bi-eye');
                iconEye.classList.add('bi-eye-slash');
            }
        });
    </script>
</body>
</html>