<?php
// Add this at the very top of dashboard.php
ob_start();
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

$user_id = $_SESSION['userid'];

// Handle cancel booking
if (isset($_GET['cancel_id'])) {
    $cancel_id = intval($_GET['cancel_id']);
    $conn->query("DELETE FROM bookings WHERE id = $cancel_id AND user_id = $user_id");
    header("Location: dashboard.php");
    exit;
}

// Fetch bookings for the logged-in user
$result = $conn->query("SELECT * FROM bookings WHERE user_id = $user_id ORDER BY date ASC, time ASC");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Posh Paws Grooming</title>
    <link rel="stylesheet" href="style.css">
    <style>
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
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
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
            transition: color 0.3s;
        }

        nav li a:hover {
            color: #d6336c;
        }

        /* Success and error messages */
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            margin: 20px auto;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            width: 80%;
            text-align: center;
            font-size: 1.1rem;
        }

        .cancellation-message {
            background-color: #fff3cd;
            color: #856404;
            padding: 15px;
            margin: 20px auto;
            border: 1px solid #ffeeba;
            border-radius: 4px;
            width: 80%;
            text-align: center;
            font-size: 1.1rem;
        }

        /* Hero section */
        .hero {
            position: relative;
            background-image: url('images/hero.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            padding: 100px 20px;
        }

        .hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .hero h2 {
            font-size: 2.5rem;
            position: relative;
            z-index: 1;
        }

        .hero p {
            font-size: 1.2rem;
            position: relative;
            z-index: 1;
        }

.book-now-btn {
    display: inline-block;
    padding: 12px 30px;
    font-size: 1.2rem;
    background-color: #ff4757; /* Red background color */
    color: white; /* White text color */
    text-decoration: none; /* Remove underline from the link */
    border-radius: 8px;
    transition: background-color 0.3s ease;
    margin-top: 15px; /* Space between text and button */
    cursor: pointer; /* Make the cursor a pointer to indicate it's clickable */
}

.book-now-btn:hover {
    background-color: #ff6b81; /* Darker red shade on hover */
}

.book-now-btn {
    position: relative;
    z-index: 10; /* Bring button to the front */
}


        /* Bookings Section */
        .bookings {
            background-color: #fff;
            padding: 50px 20px;
            text-align: left; /* Align bookings to the left */
            margin-top: 40px;
        }

        .bookings h2 {
            font-size: 2rem;
            margin-bottom: 40px;
        }

        .booking-card {
    background-color: #f9f9f9;
    padding: 20px;
    margin: 20px 0;
    border-radius: 8px;
    border: 1px solid #ddd;
    width: 90%;  /* Set width to 90% of the container */
    max-width: 1200px;  /* Set a max width to avoid it becoming too large on wide screens */
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    margin-left: auto;  /* Center the card horizontally */
    margin-right: auto; /* Center the card horizontally */
}


        .booking-card p {
            font-size: 1.1rem;
            margin: 10px 0;
        }

        .booking-card strong {
            color: #d6336c;
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
            transition: background-color 0.3s;
        }

        .cancel-btn:hover {
            background-color: #ff6b81;
        }

        .book-more {
    margin-top: 30px;
    padding: 20px;
    text-align: center; /* Center-align the text and button */
    max-width: 900px; /* Limit the width of the section */
    margin-left: auto; /* Center the section horizontally */
    margin-right: auto; /* Center the section horizontally */
}

.book-more p {
    font-size: 1.2rem;
    margin-bottom: 15px;
}

.book-more .btn {
    display: inline-block;
    padding: 12px 25px;
    font-size: 1rem;
    background-color: #ff4757; /* Same color as cancel button */
    color: white; /* Text color white for contrast */
    text-decoration: none;
    border-radius: 8px;
    transition: background-color 0.3s;
    cursor: pointer;
    border: none; /* No border for consistency */
}

.book-more .btn:hover {
    background-color: #ff6b81; /* Slightly darker on hover */
}




        footer {
            background-color: #ffcad4;
            text-align: center;
            padding: 20px;
            font-size: 0.9rem;
            margin-top: 40px;
        }

        footer p {
            margin: 0;
        }
.booking-card {
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
    max-width: 1000px;
    margin-left: auto;
    margin-right: auto;
}

.booking-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.card-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 5px;
    font-size: 1rem;
}

.card-details p {
    margin: 4px 0;
}

.card-details strong {
    color: #444;
}

.card-meta {
    text-align: right;
    min-width: 180px;
    font-size: 0.95rem;
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

        /* Responsive tweaks */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            header h1 {
                font-size: 1.5rem;
            }

            nav ul {
                flex-direction: column;
                gap: 10px;
            }

            .hero h2 {
                font-size: 2rem;
            }

            .booking-card {
                width: 90%;
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
    <h1>Posh Paws Grooming - Dashboard</h1>
  </div>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="dashboard.php">My Bookings</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <section class="hero">
    <h2>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>Thanks for trusting us with your beloved pets 🐾</p>
    <!-- Book Now Button -->
    <a href="booking.php" class="book-now-btn" role="button">Book Now</a>
</section>


    <section class="bookings">
        <h2>Your Appointments</h2>

        <?php if (isset($_SESSION['booking_success'])): ?>
            <div class="success-message">
                <?php echo htmlspecialchars($_SESSION['booking_success']); ?>
                <?php unset($_SESSION['booking_success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['booking_canceled']) && $_GET['booking_canceled'] == 'true'): ?>
            <div class="cancellation-message">
                Your booking has been canceled by the shop.
            </div>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="booking-card">
    <div class="card-details">
        <p><strong>Pet Type:</strong> <?php echo htmlspecialchars($row['pet_type']); ?></p>
        <p><strong>Package:</strong> <?php echo htmlspecialchars($row['package']); ?></p>
    </div>
    <div class="card-meta">
        <p><strong>Date:</strong> <?php echo htmlspecialchars($row['date']); ?></p>
        <p><strong>Time:</strong> <?php echo htmlspecialchars($row['time']); ?></p>
        <a href="dashboard.php?cancel_id=<?php echo $row['id']; ?>" class="cancel-btn" onclick="return confirm('Are you sure you want to cancel this booking?');">Cancel</a>
    </div>
</div>

            <?php endwhile; ?>
        <?php else: ?>
            <p>You have no upcoming bookings at the moment.</p>
        <?php endif; ?>

        <div class="book-more">
            <p>Want to schedule another pampering session for your furry friend?</p>
            <a href="booking.php" class="btn">Book Another Appointment</a>
        </div>
    </section>
</div>

<footer>
    <p>© 2025 Posh Paws Grooming | Designed with ❤️ for Pet Lovers</p>
</footer>

</body>
</html>
