<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    die("Error: Access denied. You need admin privileges.");
}

include 'config.php';

// Handle cancel booking
if (isset($_GET['cancel_id'])) {
    $cancel_id = intval($_GET['cancel_id']); // Ensure cancel_id is an integer
    $sql = "DELETE FROM bookings WHERE id = $cancel_id";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect with a cancellation flag
        header("Location: admin_dashboard.php?booking_canceled=true");
        exit;
    } else {
        echo "<script>alert('Error canceling booking: " . $conn->error . "');</script>";
    }
}

// Fetch upcoming appointments from the database
$sql = "SELECT bookings.*, users.username 
        FROM bookings 
        LEFT JOIN users ON bookings.user_id = users.id 
        WHERE bookings.date >= CURDATE() 
        ORDER BY bookings.date ASC, bookings.time ASC";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Posh Paws Grooming</title>
    <style>
        /* General styles */
        /* General styles */
body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #fff9f4;
    color: #333;
    line-height: 1.6;
}

header {
    background-color: #ffcad4;
    padding: 20px 40px;
    display: flex;
    justify-content: space-between;  /* Aligns h1 to the left and nav to the right */
    align-items: center;
    flex-wrap: wrap;
}

header h1 {
    margin: 0;
    font-size: 1.5rem;
}

nav {
    margin-left: auto;  /* Pushes the nav menu to the right */
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
nav {
    margin-left: left;  /* This will push the navigation to the right side */
}

/* Hero section with dark overlay */
.hero {
    position: relative;
    background-image: url('images/hero.jpg'); /* Replace with your image */
    background-size: cover;
    background-position: center;
    color: white;
    text-align: center;
    padding: 100px 20px;
    margin-bottom: 20px;
}

.hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Dark overlay */
}

.hero h2, .hero p {
    position: relative; /* Ensure the text stays above the overlay */
    z-index: 1;
}

.hero h2 {
    font-size: 2.5rem;
}

.hero p {
    font-size: 1.2rem;
}

.appointments {
    background-color: #fff;
    padding: 30px;
    margin-top: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

h2 {
    font-size: 1.8rem;
    margin-bottom: 20px;
}

.appointment-card {
    background-color: #f9f9f9;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    border: 1px solid #ddd;
}

.appointment-card p {
    font-size: 1.1rem;
    margin: 5px 0;
}

.cancel-btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #ff4757;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 1rem;
    margin-top: 15px;
}

.cancel-btn:hover {
    background-color: #ff6b81;
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
.appointment-card {
    background-color: #fff;
    border-left: 5px solid #d6336c;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    transition: box-shadow 0.3s;
}

.appointment-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.card-details {
    display: flex;
    flex-direction: column;
    flex: 1;
    min-width: 200px;
    gap: 6px;
}

.card-details p {
    margin: 0;
    font-size: 0.95rem;
    color: #333;
}

.card-details p strong {
    color: #555;
}

.card-meta {
    text-align: right;
    min-width: 160px;
}

.card-meta p {
    margin: 4px 0;
    font-size: 0.9rem;
    color: #666;
}

.cancel-btn {
    margin-top: 10px;
    display: inline-block;
    padding: 8px 16px;
    background-color: #ff4757;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 0.9rem;
    text-decoration: none;
    cursor: pointer;
    transition: background-color 0.3s;
}

.cancel-btn:hover {
    background-color: #e84158;
}

/* Display cancellation message for user */
.cancellation-message {
    color: red;
    font-weight: bold;
    font-size: 1.2rem;
    margin-bottom: 20px;
}

/* Responsive tweaks */
@media (max-width: 768px) {
    header h1 {
        font-size: 1.3rem;
    }

    nav ul {
        flex-direction: column;
        align-items: flex-start;
    }

    .appointment-card {
        width: 90%;
        margin: 10px auto;
    }
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
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li class="logout"><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
</header>


<div class="container">
    <section class="hero">
        <h2>Welcome, Admin</h2>
        <p>Manage all appointments from this dashboard.</p>
    </section>

    <section class="appointments">
        <h2>Upcoming Appointments</h2>

        <!-- Show cancellation message if the booking was canceled -->
        <?php
        if (isset($_GET['booking_canceled']) && $_GET['booking_canceled'] == 'true') {
            echo "<p class='cancellation-message'>Booking has been canceled successfully.</p>";
        }

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               echo "<div class='appointment-card'>";
echo "  <div class='card-details'>";
echo "    <p><strong>User:</strong> " . htmlspecialchars($row['username']) . "</p>";
echo "    <p><strong>Pet:</strong> " . htmlspecialchars($row['pet_type']) . "</p>";
echo "    <p><strong>Package:</strong> " . htmlspecialchars($row['package']) . "</p>";
echo "  </div>";
echo "  <div class='card-meta'>";
echo "    <p><strong>Date:</strong> " . htmlspecialchars($row['date']) . "</p>";
echo "    <p><strong>Time:</strong> " . htmlspecialchars($row['time']) . "</p>";
echo "    <a href='admin_dashboard.php?cancel_id=" . $row['id'] . "' class='cancel-btn' onclick=\"return confirm('Are you sure you want to cancel this booking?');\">Cancel</a>";
echo "  </div>";
echo "</div>";

            }
        } else {
            echo "<p>No upcoming appointments found.</p>";
        }
        ?>
    </section>

</div>

<footer>
    <div class="container">
        <p>© 2025 Posh Paws Grooming | Admin Dashboard</p>
    </div>
</footer>

</body>
</html>