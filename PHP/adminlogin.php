<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Portal - Secure Login</title>
    <link rel="stylesheet" href="../CSS/adminlogin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="https://i.imgur.com/nMdo4LG.jpg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php
    session_start();
    
    // Handle logout
    if (isset($_POST['logout'])) {
        session_destroy();
        header('Location: adminlogin.php');
        exit;
    }
    
    // Handle login
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Generic admin credentials - change these in production
        if ($username === 'admin@example.com' && $password === 'admin123') {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_email'] = $username;
            header('Location: adminpage.php');
            exit;
        } else {
            $error = 'Invalid email or password';
        }
    }
    ?>
    
    <div class="login-background"></div>
    
    <div class="wrapper">
        <div class="login-header">
            <i class="fas fa-shield-alt"></i>
            <h1>Admin Portal</h1>
            <p>Secure Access</p>
        </div>
        
        <?php if (isset($error)): ?>
        <div style="background: #e74c3c; color: white; padding: 15px; border-radius: 10px; margin-bottom: 20px; text-align: center;">
            <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="adminlogin.php">
            <div class="input-box">
                <i class='bx bxs-user'></i>
                <input name="username" type="email" placeholder="Email Address" required autocomplete="off">
            </div>
            
            <div class="input-box">
                <i class='bx bxs-lock-alt'></i>
                <input name="password" type="password" placeholder="Password" required autocomplete="off">
            </div>

            <button type="submit" class="btn">
                <span>Sign In</span>
                <i class="fas fa-arrow-right"></i>
            </button>
            
            <div class="login-footer">
                <i class="fas fa-lock"></i>
                <span>Secure Connection</span>
            </div>
        </form>
    </div>
</body>

</html>
