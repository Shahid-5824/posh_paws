<?php
session_start();
include 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            $error = "Database error. Please try again later.";
        } else {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();

                if (password_verify($password, $user['password'])) {
                    $_SESSION['userid'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];

                    session_regenerate_id(true);

                    if ($user['role'] === 'admin') {
                        header("Location: admin_dashboard.php");
                    } else {
                        header("Location: dashboard.php");
                    }
                    exit();
                } else {
                    $error = "Invalid username or password.";
                }
            } else {
                $error = "Invalid username or password.";
            }
            $stmt->close();
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Posh Paws Grooming</title>
  <style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #fff9f4;
        color: #333;
    }

    header {
        background-color: #ffcad4;
        padding: 20px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    header h1 {
        margin: 0;
        font-size: 1.5rem;
    }

    nav ul {
        list-style: none;
        display: flex;
        gap: 20px;
        margin: 0;
        padding: 0;
    }

    nav li a {
        text-decoration: none;
        color: #333;
        font-weight: bold;
    }

    nav li a:hover {
        color: #d6336c;
    }

    .hero {
        position: relative;
        background: url('images/hero.jpg') no-repeat center center/cover;
        padding: 100px 20px;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        color: white;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 0;
    }

    .hero-heading {
        position: relative;
        z-index: 1;
        text-align: center;
        margin-bottom: 40px;
    }

    .hero-heading h2 {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .hero-heading p {
        font-size: 1.2rem;
        margin-bottom: 5px;
        color: white;
    }

    .form-container {
        position: relative;
        z-index: 1;
        background-color: #fff;
        padding: 30px 40px;
        border-radius: 10px;
        max-width: 400px;
        width: 100%;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .form-container input,
    .form-container button {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    .form-container button {
        background-color: #e75480;
        border: none;
        font-weight: bold;
        color: white;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .form-container button:hover {
        background-color: #ff9bb0;
    }

    .form-container .error {
        color: red;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .form-container p {
        margin-top: 15px;
    }

    .form-container a {
        color: #d6336c;
        text-decoration: none;
    }

    footer {
        background-color: #ffcad4;
        text-align: center;
        padding: 20px;
        font-size: 0.9rem;
    }

    footer p {
        margin: 0;
    }
.logo-title {
  display: flex;
  align-items: center;
  gap: 0px;
}

.site-logo {
  height: 60px; /* Adjust as needed */
  width: 80px;
}
  </style>
</head>
<body>

<header>
  <div class="logo-title">
    <img src="images/logo.png" alt="Posh Paws Logo" class="site-logo" />
    <h1>Posh Paws Grooming</h1>
  </div>
  <nav>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="register.php">Register</a></li>
    </ul>
  </nav>
</header>

<section class="hero">
  <div class="hero-overlay"></div>
  <div class="hero-heading">
    <h2>Login to Your Account</h2>
    <p>Welcome back to Posh Paws Grooming!</p>
  </div>

  <div class="form-container">
    <?php if (isset($error)): ?>
      <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
  </div>
</section>

<footer>
  <p>© 2025 Posh Paws Grooming | All rights reserved.</p>
</footer>

</body>
</html>
