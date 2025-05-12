<?php
ob_start();
session_start();
include 'config.php';

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id  = $_SESSION['userid'];
    $pet_type = trim($_POST['pet_type']);
    $package  = trim($_POST['package']);
    $date     = trim($_POST['date']);
    $time     = trim($_POST['time']);

    if (empty($pet_type) || empty($package) || empty($date) || empty($time)) {
        $_SESSION['booking_error'] = "All fields are required";
        header("Location: booking.php");
        exit();
    }

    $sql = "INSERT INTO bookings (user_id, pet_type, package, date, time) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("issss", $user_id, $pet_type, $package, $date, $time);

        if ($stmt->execute()) {
            $_SESSION['booking_success'] = "Your appointment has been booked successfully!";
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['booking_error'] = "Error: " . $conn->error;
            header("Location: booking.php");
            exit();
        }
    } else {
        $_SESSION['booking_error'] = "Database error: " . $conn->error;
        header("Location: booking.php");
        exit();
    }
}
ob_end_clean();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - Posh Paws Grooming</title>
    <link rel="stylesheet" href="style.css">
    <style>
       body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-image: url('images/hero.jpg'); 
    background-size: cover;
    background-position: center;
    color: #333;
    position: relative;
}

body::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5); /* Dark overlay */
    z-index: -1; /* Ensures the overlay stays behind the content */
}

        header {
            background-color: rgba(255, 202, 212, 0.8); /* Semi-transparent header */
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        header h1 {
            margin: 0;
            font-size: 2rem;
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
            transition: color 0.3s;
        }

        nav li a:hover {
            color: #d6336c;
        }

        .booking-container {
            max-width: 600px;
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .booking-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #d6336c;
            font-size: 2rem;
        }

        form {
    display: grid; /* Use grid layout */
    grid-template-columns: 1fr; /* Single column layout */
    gap: 20px; /* Spacing between each element */
    margin-top: 20px;
}

label {
    font-weight: bold;
    font-size: 14px;
    margin-bottom: 5px; /* Slight margin below labels */
}

input[type="text"],
input[type="date"],
input[type="time"] {
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    width: 95%; /* Adjust width to 95% */
    outline: none;
}

select {
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    width: 100%; /* Keep the select field at 100% */
    outline: none;
}

button {
    background-color: #ff9aa2;
    color: white;
    padding: 14px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #ff6f80;
}


        .error-message {
            background-color: #ffe0e6;
            color: #b3002d;
            padding: 12px;
            border: 1px solid #ffc2cc;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #ff6f80;
            font-weight: bold;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        footer {
            background-color: #ffcad4;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
            font-size: 0.9rem;
        }

        footer p {
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            nav ul {
                flex-direction: column;
                gap: 10px;
            }
        }
.logo-title {
  display: flex;
  align-items: center;
  gap: 15px;
}

.site-logo {
  height: 60px; /* Adjust as needed */
  width: 90px;
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
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li class="logout"><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
   
</header>

<div class="booking-container">
    <h2>Book an Appointment</h2>

    <?php if (isset($_SESSION['booking_error'])): ?>
        <div class="error-message"><?php echo htmlspecialchars($_SESSION['booking_error']); unset($_SESSION['booking_error']); ?></div>
    <?php endif; ?>

    <form method="POST" action="booking.php">
        <label for="pet_type">Pet Type:</label>
        <input type="text" id="pet_type" name="pet_type" required>

        <label for="package">Package:</label>
        <select id="package" name="package" required>
            <option value="">Select a Package</option>
            <option>Basic Bath - $30</option>
            <option>Full Groom - $55</option>
            <option>Spa Day - $80</option>
        </select>

        <label for="date">Preferred Date:</label>
        <input type="date" id="date" name="date" required>

        <label for="time">Preferred Time:</label>
        <input type="time" id="time" name="time" required>

        <button type="submit">Confirm Booking</button>
    </form>

    <div class="back-link">
        <a href="dashboard.php">← Back to Dashboard</a>
    </div>
</div>

<footer>
    <p>© 2025 Posh Paws Grooming | Designed with ❤️ for Pet Lovers</p>
</footer>

</body>
</html>
