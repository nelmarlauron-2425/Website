<?php
require_once "/config/dbconfig.php";

$artist_id = $_GET['artist_id'] ?? null;
if (!$artist_id) {
  echo json_encode(["error" => "Artist ID required"]);
  exit;
}

$active = $conn->query("
  SELECT COUNT(*) AS total FROM commissions 
  WHERE artist_id = $artist_id AND progress != 'Done'
")->fetch_assoc()['total'] ?? 0;

// Count completed
$completed = $conn->query("
  SELECT COUNT(*) AS total FROM commissions 
  WHERE artist_id = $artist_id AND progress = 'Done'
")->fetch_assoc()['total'] ?? 0;

// Calculate total earnings
$earnings = $conn->query("
  SELECT SUM(price) AS total FROM commissions 
  WHERE artist_id = $artist_id
")->fetch_assoc()['total'] ?? 0;

// Example static rating
$rating = 4.9;

echo json_encode([
  "active_commissions" => $active,
  "completed" => $completed,
  "total_earnings" => $earnings,
  "average_rating" => $rating
]);
?>
