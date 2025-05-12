<?php
session_start();

$mysqli = new mysqli('localhost', 'root', '', 'posh_paws');

if ($mysqli->connect_error) {
    die('Database connection error: ' . $mysqli->connect_error);
}

if (isset($_GET['id'])) {
    $booking_id = intval($_GET['id']);

    // Update booking status to 'cancelled'
    $stmt = $mysqli->prepare("UPDATE bookings SET status = 'cancelled' WHERE id = ?");
    $stmt->bind_param('i', $booking_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Booking cancelled successfully.";
    } else {
        $_SESSION['message'] = "Failed to cancel booking.";
    }

    $stmt->close();
}

$mysqli->close();

header('Location: admin_dashboard.php'); // Go back to admin dashboard
exit();
?>
