<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "fashionhub_auth");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // For showing errors

// ─────────────────────────────────────────────
//  SIGNUP PROCESS
// ─────────────────────────────────────────────
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['formType'] == "signup") {

    $name  = $_POST['signupName'];
    $email = $_POST['signupEmail'];
    $pass  = $_POST['signupPassword'];
    $cpass = $_POST['confirmPassword'];

    // Password match check
    if ($pass !== $cpass) {
        $message = "Passwords do not match!";
    } else {
        // Check if email already exists
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            // $message = "Email already exists!";
        } else {
            // Insert user
            $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashedPassword);
            
            if ($stmt->execute()) {
                $message = "Account created successfully! Please login.";
            } else {
                $message = "Signup failed!";
            }
        }

        $check->close();
    }
}

// ─────────────────────────────────────────────
//  LOGIN PROCESS
// ─────────────────────────────────────────────
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['formType'] == "login") {

    $email = $_POST['loginEmail'];
    $pass  = $_POST['loginPassword'];

    $stmt = $conn->prepare("SELECT id, full_name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $full_name, $hashedPassword);
        $stmt->fetch();

        if (password_verify($pass, $hashedPassword)) {

            $_SESSION['user_id']   = $id;
            $_SESSION['user_name'] = $full_name;

            header("Location: index.php");
            exit;

        } else {
            $message = "Invalid password!";
        }
    } else {
        $message = "Email not found!";
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionHub | Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #0a0a0a;
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Background image with dark overlay */
            background-image: 
                linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.5)),
                url('./login.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            /* Keep the existing gradient effects */
            background-image: 
                linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.75)),
                url('./login.png'),
                radial-gradient(circle at 20% 30%, rgba(123, 97, 255, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(255, 97, 189, 0.15) 0%, transparent 40%);
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 420px;
            background-color: rgba(15, 15, 20, 0.85);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.8),
                0 0 0 1px rgba(123, 97, 255, 0.15);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Brand Header */
        .brand-header {
            padding: 28px 30px 20px;
            text-align: center;
            background: linear-gradient(135deg, rgba(123, 97, 255, 0.15), rgba(255, 97, 189, 0.08));
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }

        .logo i {
            color: #7b61ff;
            font-size: 28px;
            margin-right: 10px;
            filter: drop-shadow(0 0 8px rgba(123, 97, 255, 0.6));
        }

        .logo h1 {
            font-size: 26px;
            font-weight: 800;
            background: linear-gradient(45deg, #7b61ff, #ff61bd);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .brand-tagline {
            font-size: 14px;
            color: #ccc;
            margin-bottom: 8px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }

        /* Form Section */
        .form-section {
            padding: 30px;
        }

        .form-header {
            margin-bottom: 24px;
            text-align: center;
        }

        .form-header h2 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #fff;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
        }

        .form-header p {
            color: #ccc;
            font-size: 14px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #eee;
            font-size: 14px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #7b61ff;
            font-size: 16px;
            filter: drop-shadow(0 1px 1px rgba(0, 0, 0, 0.5));
        }

        .form-control {
            width: 100%;
            padding: 14px 14px 14px 42px;
            background-color: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            color: #fff;
            font-size: 15px;
            transition: all 0.3s;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }

        .form-control:focus {
            outline: none;
            border-color: #7b61ff;
            box-shadow: 0 0 0 3px rgba(123, 97, 255, 0.25);
            background-color: rgba(0, 0, 0, 0.6);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 13px;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .remember-me input {
            margin-right: 8px;
            accent-color: #7b61ff;
        }

        .remember-me label {
            color: #ccc;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }

        .forgot-password {
            color: #ff61bd;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 13px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }

        .forgot-password:hover {
            color: #7b61ff;
            text-decoration: underline;
            text-shadow: 0 0 8px rgba(123, 97, 255, 0.5);
        }

        /* Buttons */
        .login-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(45deg, #7b61ff, #ff61bd);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 20px;
            letter-spacing: 0.5px;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
            box-shadow: 0 4px 15px rgba(123, 97, 255, 0.3);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(123, 97, 255, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        /* Divider */
        .divider {
            text-align: center;
            position: relative;
            margin: 24px 0;
            color: #aaa;
            font-size: 13px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 40%;
            height: 1px;
            background-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
        }

        .divider::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            width: 40%;
            height: 1px;
            background-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
        }

        /* Social Login */
        .social-login {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .social-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(0, 0, 0, 0.4);
            color: #fff;
            font-size: 18px;
            text-decoration: none;
            transition: all 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
        }

        .social-btn:hover {
            transform: translateY(-3px);
            background-color: rgba(123, 97, 255, 0.25);
            border-color: rgba(123, 97, 255, 0.4);
            box-shadow: 0 5px 15px rgba(123, 97, 255, 0.3);
        }

        /* Signup Link */
        .signup-link {
            text-align: center;
            color: #ccc;
            font-size: 14px;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }

        .signup-link a {
            color: #ff61bd;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }

        .signup-link a:hover {
            color: #7b61ff;
            text-decoration: underline;
            text-shadow: 0 0 8px rgba(123, 97, 255, 0.5);
        }

        /* Toggle between Login/Signup */
        .auth-toggle {
            display: flex;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 24px;
            background-color: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        .toggle-btn {
            flex: 1;
            padding: 12px;
            text-align: center;
            background: transparent;
            border: none;
            color: #aaa;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 15px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }

        .toggle-btn.active {
            background: linear-gradient(45deg, rgba(123, 97, 255, 0.3), rgba(255, 97, 189, 0.15));
            color: #fff;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
        }

        /* Additional fields for signup */
        .additional-field {
            display: none;
        }

        .show-signup .additional-field {
            display: block;
        }

        /* Success/Error Messages */
        .message {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
        }

        .success-message {
            background-color: rgba(46, 204, 113, 0.2);
            border: 1px solid rgba(46, 204, 113, 0.4);
            color: #2ecc71;
        }

        .error-message {
            background-color: rgba(231, 76, 60, 0.2);
            border: 1px solid rgba(231, 76, 60, 0.4);
            color: #e74c3c;
        }

        /* Responsive */
        @media (max-width: 480px) {
            body {
                background-image: 
                    linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.95)),
                    url('https://images.unsplash.com/photo-1558769132-cb1c458e4222?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');
                padding: 15px;
            }
            
            .container {
                max-width: 100%;
                border-radius: 12px;
            }
            
            .brand-header {
                padding: 24px 20px 16px;
            }
            
            .form-section {
                padding: 24px;
            }
            
            .social-login {
                gap: 12px;
            }
            
            .social-btn {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        
        .switch-link {
            margin-top: 15px;
            text-align: center;
            color: #ccc;
        }
        
        .switch-link span {
            color: #7b61ff;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .switch-link span:hover {
            color: #ff61bd;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container fade-in">
        <!-- Brand Header -->
        <div class="brand-header">
            <div class="logo">
                <i class="fas fa-tshirt"></i>
                <h1>FashionHub</h1>
            </div>
            <p class="brand-tagline">Style Elevated, Authentically You</p>
        </div>
        
        <!-- Form Section -->
        <div class="form-section">
            <!-- Toggle between Login and Signup -->
            <div class="auth-toggle">
                <button class="toggle-btn active" id="loginToggle" type="button">Login</button>
                <button class="toggle-btn" id="signupToggle" type="button">Sign Up</button>
            </div>
            
            <!-- PHP Messages -->
            <?php if($message): ?>
                <div class="message error-message"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <?php if($success): ?>
                <div class="message success-message"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <!-- Messages for JavaScript -->
            <div class="message success-message" id="successMessage" style="display: none;"></div>
            <div class="message error-message" id="errorMessage" style="display: none;"></div>
            
            <!-- Login Form (default) -->
            <form id="loginForm" method="POST" action="">
                <input type="hidden" name="formType" value="login">

                <div class="form-header">
                    <h2>Welcome Back</h2>
                    <p>Sign in to your FashionHub account</p>
                </div>
                
                <div class="form-group">
                    <label for="loginEmail">Email Address</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="loginEmail" name="loginEmail" class="form-control" placeholder="you@example.com" required value="<?php echo isset($_POST['loginEmail']) ? htmlspecialchars($_POST['loginEmail']) : ''; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="loginPassword" name="loginPassword" class="form-control" placeholder="Enter your password" required>
                    </div>
                </div>
                
                <div class="remember-forgot">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    <a href="#" class="forgot-password" id="forgotPassword">Forgot Password?</a>
                </div>
                
                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>

            <!-- Signup Form (hidden by default) -->
            <form id="signupForm" method="POST" action="" style="display: none;">
                <input type="hidden" name="formType" value="signup">

                <div class="form-header">
                    <h2>Create Account</h2>
                    <p>Join FashionHub's style community</p>
                </div>
                
                <div class="form-group">
                    <label for="signupName">Full Name</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="signupName" name="signupName" class="form-control" placeholder="Your full name" required value="<?php echo isset($_POST['signupName']) ? htmlspecialchars($_POST['signupName']) : ''; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="signupEmail">Email Address</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="signupEmail" name="signupEmail" class="form-control" placeholder="you@example.com" required value="<?php echo isset($_POST['signupEmail']) ? htmlspecialchars($_POST['signupEmail']) : ''; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="signupPassword">Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="signupPassword" name="signupPassword" class="form-control" placeholder="Create a password" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Confirm your password" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="remember-me">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">I agree to the 
                            <a href="#" style="color: #7b61ff; text-shadow: 0 1px 2px rgba(0,0,0,0.5);">Terms & Conditions</a>
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="login-btn">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
            </form>
            
            <!-- Switch Links -->
            <div class="switch-link" id="loginSwitch">
                Don't have an account? <span onclick="showSignupForm()">Create Account</span>
            </div>
            
            <div class="switch-link" id="signupSwitch" style="display: none;">
                Already have an account? <span onclick="showLoginForm()">Login</span>
            </div>
            
            <!-- Divider and Social Login -->
            <div class="divider">or continue with</div>
            
            <div class="social-login">
                <a href="#" class="social-btn" title="Sign in with Google">
                    <i class="fab fa-google"></i>
                </a>
                <a href="#" class="social-btn" title="Sign in with Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="social-btn" title="Sign in with Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="social-btn" title="Sign in with Apple">
                    <i class="fab fa-apple"></i>
                </a>
            </div>
        </div>
    </div>

    <script>
        // DOM Elements
        const loginToggle = document.getElementById('loginToggle');
        const signupToggle = document.getElementById('signupToggle');
        const loginForm = document.getElementById('loginForm');
        const signupForm = document.getElementById('signupForm');
        const loginSwitch = document.getElementById('loginSwitch');
        const signupSwitch = document.getElementById('signupSwitch');
        const successMessage = document.getElementById('successMessage');
        const errorMessage = document.getElementById('errorMessage');
        
        // Show login form
        function showLoginForm() {
            loginToggle.classList.add('active');
            signupToggle.classList.remove('active');
            loginForm.style.display = 'block';
            signupForm.style.display = 'none';
            loginSwitch.style.display = 'block';
            signupSwitch.style.display = 'none';
            clearMessages();
        }
        
        // Show signup form
        function showSignupForm() {
            loginToggle.classList.remove('active');
            signupToggle.classList.add('active');
            loginForm.style.display = 'none';
            signupForm.style.display = 'block';
            loginSwitch.style.display = 'none';
            signupSwitch.style.display = 'block';
            clearMessages();
        }
        
        // Event Listeners for toggles
        loginToggle.addEventListener('click', showLoginForm);
        signupToggle.addEventListener('click', showSignupForm);
        
        // Check if we should show signup form based on PHP validation
        <?php if($success && !$message): ?>
            // If signup was successful, show login form
            showLoginForm();
        <?php elseif(isset($_POST['formType']) && $_POST['formType'] == 'signup'): ?>
            // If signup form was submitted but had errors, show signup form
            showSignupForm();
        <?php endif; ?>
        
        // Show message function (for client-side validation)
        function showMessage(type, text) {
            clearMessages();
            
            if (type === 'success') {
                successMessage.textContent = text;
                successMessage.style.display = 'block';
            } else {
                errorMessage.textContent = text;
                errorMessage.style.display = 'block';
            }
            
            // Auto-hide after 5 seconds
            setTimeout(clearMessages, 5000);
        }
        
        function clearMessages() {
            successMessage.style.display = 'none';
            errorMessage.style.display = 'none';
        }
        
        // Login Form Client-side Validation
        loginForm.addEventListener('submit', function(e) {
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            
            // Basic validation
            if (!email || !password) {
                e.preventDefault();
                showMessage('error', 'Please fill in both email and password fields.');
                return;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                showMessage('error', 'Please enter a valid email address.');
                return;
            }
            
            // Password length check
            if (password.length < 6) {
                e.preventDefault();
                showMessage('error', 'Password must be at least 6 characters long.');
                return;
            }
        });
        
        // Signup Form Client-side Validation
        signupForm.addEventListener('submit', function(e) {
            const name = document.getElementById('signupName').value;
            const email = document.getElementById('signupEmail').value;
            const password = document.getElementById('signupPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const terms = document.getElementById('terms').checked;
            
            // Validation
            if (!name || !email || !password || !confirmPassword) {
                e.preventDefault();
                showMessage('error', 'Please fill in all required fields.');
                return;
            }
            
            if (!terms) {
                e.preventDefault();
                showMessage('error', 'You must agree to the Terms & Conditions.');
                return;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                showMessage('error', 'Please enter a valid email address.');
                return;
            }
            
            // Password validation
            if (password.length < 8) {
                e.preventDefault();
                showMessage('error', 'Password must be at least 8 characters long.');
                return;
            }
            
            if (password !== confirmPassword) {
                e.preventDefault();
                showMessage('error', 'Passwords do not match.');
                return;
            }
        });
        
        // Forgot Password
        document.getElementById('forgotPassword').addEventListener('click', function(e) {
            e.preventDefault();
            const email = prompt('Please enter your email to reset your password:');
            if (email) {
                // In a real app, this would send a reset link
                showMessage('success', `Password reset instructions have been sent to ${email}.`);
            }
        });
        
        // Social login buttons
        document.querySelectorAll('.social-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const platform = this.title.replace('Sign in with ', '');
                showMessage('info', `${platform} login would be implemented in a real application.`);
            });
        });
    </script>
</body>
</html>