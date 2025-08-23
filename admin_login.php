<?php
session_start();

// Check if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: view_submissions.php');
    exit;
}

// Process login if form submitted
$login_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Validate credentials
    if ($username === 'Admin' && $password === 'Agabus060684') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        
        // Redirect to submissions page
        header('Location: view_submissions.php');
        exit;
    } else {
        $login_error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Anthony Darko Ministries</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            overflow: hidden;
        }
        
        .login-header {
            background: #0d9488;
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }
        
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }
        
        .logo img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid white;
            margin-right: 15px;
            object-fit: cover;
        }
        
        .logo-text h1 {
            font-size: 24px;
            margin-bottom: 5px;
            font-weight: 700;
        }
        
        .logo-text p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .login-form {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #374151;
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #0d9488;
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1);
        }
        
        .btn {
            width: 100%;
            padding: 14px;
            background: #0d9488;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        
        .btn:hover {
            background: #0c7c71;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 148, 136, 0.3);
        }
        
        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert-error {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            cursor: pointer;
        }

        /* Shake animation for login error */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
            20%, 40%, 60%, 80% { transform: translateX(10px); }
        }
        
        .animate-shake {
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }

        .login-footer {
            text-align: center;
            padding: 20px;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            font-size: 14px;
            color: #6b7280;
        }
        
        .login-footer a {
            color: #0d9488;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .login-footer a:hover {
            color: #0c7c71;
            text-decoration: underline;
        }
        
        .decoration {
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        
        .decoration-1 {
            top: -50px;
            right: -50px;
        }
        
        .decoration-2 {
            bottom: -50px;
            left: -50px;
        }
        
        @media (max-width: 500px) {
            .login-container {
                border-radius: 10px;
            }
            
            .login-header {
                padding: 20px;
            }
            
            .login-form {
                padding: 20px;
            }
            
            .logo {
                flex-direction: column;
                text-align: center;
            }
            
            .logo img {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="decoration decoration-1"></div>
            <div class="decoration decoration-2"></div>
            <div class="logo">
                <img src="C:\xampp\htdocs\anthony-darko-ministries\Logo.jpeg" alt="Logo">
                <div class="logo-text">
                    <h1>ANTHONY DARKO MINISTRIES</h1>
                    <p>Spirit Generation Church (Beth Elohim)</p>
                </div>
            </div>
        </div>
        
        <div class="login-form">
            <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Admin Login</h2>
            
            <?php if (!empty($login_error)): ?>
            <div id="error-message" class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span id="error-text"><?php echo htmlspecialchars($login_error); ?></span>
            </div>
            <?php endif; ?>
            
            <form id="login-form" method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" id="username" name="username" required placeholder="Enter your username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" required placeholder="Enter your password">
                        <i class="fas fa-eye password-toggle" id="password-toggle"></i>
                    </div>
                </div>
                
                <button type="submit" class="btn">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>
        </div>
        
        <div class="login-footer">
            <p>&copy; 2025 Anthony Darko Ministries. All rights reserved.</p>
            <p>Having issues? <a href="mailto:anthonydarkoministries.com">Contact support</a></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordToggle = document.getElementById('password-toggle');
            const passwordInput = document.getElementById('password');
            
            // Toggle password visibility
            passwordToggle.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    passwordToggle.classList.remove('fa-eye');
                    passwordToggle.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    passwordToggle.classList.remove('fa-eye-slash');
                    passwordToggle.classList.add('fa-eye');
                }
            });
            
            // Add shake animation if there's an error
            <?php if (!empty($login_error)): ?>
            const loginForm = document.getElementById('login-form');
            loginForm.classList.add('animate-shake');
            setTimeout(() => {
                loginForm.classList.remove('animate-shake');
            }, 500);
            <?php endif; ?>
        });
    </script>
</body>
</html>