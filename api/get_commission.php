<?php
require_once "/config/dbconfig.php";

$artist_id = $_GET['artist_id'] ?? null;
if (!$artist_id) {
  echo json_encode(["error" => "Artist ID required"]);
  exit;
}

$sql = "SELECT 
          c.commission_id,
          c.title,
          c.price,
          c.progress,
          c.progress_percent,
          c.due_date,
          u.first_name AS client_name
        FROM commissions c
        JOIN users u ON c.buyer_id = u.users_id
        WHERE c.artist_id = ?
        ORDER BY c.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $artist_id);
$stmt->execute();
$result = $stmt->get_result();

$commissions = [];
while ($row = $result->fetch_assoc()) {
  $commissions[] = $row;
}

echo json_encode($commissions);
?>
