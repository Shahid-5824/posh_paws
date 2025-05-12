<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 'normal';

    $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $email, $password, $role);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Please login.'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Posh Paws Grooming</title>
  <link rel="stylesheet" href="style.css"> <!-- optional -->
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
body {
  margin: 0;
  font-family: Arial, sans-serif;
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
  cursor: pointer;
  transition: background 0.3s ease;
}

.form-container button:hover {
  background-color: #ff9bb0;
}

.form-container p {
  margin-top: 15px;
}

.form-container a {
  color: #d6336c;
  text-decoration: none;
}



    form input,
    form button {
        display: block;
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    form button {
        background-color: #ffcad4;
        color: white;
        font-weight: bold;
        border: none;
    }

    form button:hover {
        background-color: #c2185b;
    }

    p {
        margin-top: 15px;
        color: #444;
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
      <li><a href="login.php">Login</a></li>
    </ul>
  </nav>
</header>
<body>
  <section class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-heading">
      <h2>Create Your Account</h2>
      <p>Join Posh Paws and pamper your pet!</p>
    </div>

    <div class="form-container">
      <form action="register.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
      </form>
      <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
  </section>
</body>


<footer>
  <p>© 2025 Posh Paws Grooming | All rights reserved.</p>
</footer>

</body>
</html>
