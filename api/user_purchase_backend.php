<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../config/dbconfig.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

  // ✅ FETCH all orders for a specific buyer
  case 'GET':
    if (isset($_GET['buyer_id'])) {
      $buyer_id = intval($_GET['buyer_id']);

      $sql = "SELECT 
                o.order_id,
                a.title AS artwork_title,
                a.image AS artwork_image,
                CONCAT(u.first_name, ' ', u.last_name) AS artist_name,
                o.total_price,
                o.status,
                o.due_date,
                o.order_date,
                o.notes
              FROM orders o
              JOIN artworks a ON o.artwork_id = a.artwork_id
              JOIN users u ON o.artist_id = u.users_id
              WHERE o.buyer_id = ?
              ORDER BY o.order_date DESC";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $buyer_id);
      $stmt->execute();
      $result = $stmt->get_result();

      $orders = [];
      while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
      }

      echo json_encode(["success" => true, "orders" => $orders]);
    } else {
      echo json_encode(["success" => false, "error" => "Missing buyer_id"]);
    }
    break;

  // ✅ ADD new order
  case 'POST':
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['artwork_id'], $data['buyer_id'], $data['artist_id'], $data['total_price'], $data['due_date'])) {
      $sql = "INSERT INTO orders (artwork_id, buyer_id, artist_id, total_price, due_date, status, notes)
              VALUES (?, ?, ?, ?, ?, 'Pending', ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param(
        "iiidss",
        $data['artwork_id'],
        $data['buyer_id'],
        $data['artist_id'],
        $data['total_price'],
        $data['due_date'],
        $data['notes']
      );

      if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Order added successfully"]);
      } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
      }
    } else {
      echo json_encode(["success" => false, "error" => "Missing required fields"]);
    }
    break;

  // ✅ UPDATE order status (e.g. cancel, complete)
  case 'PUT':
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['order_id'], $data['status'])) {
      $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("si", $data['status'], $data['order_id']);

      if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Order updated"]);
      } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
      }
    } else {
      echo json_encode(["success" => false, "error" => "Missing order_id or status"]);
    }
    break;

  
  case 'DELETE':
    parse_str(file_get_contents("php://input"), $data);

    if (isset($data['order_id'])) {
      $order_id = intval($data['order_id']);
      $sql = "DELETE FROM orders WHERE order_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $order_id);

      if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Order deleted"]);
      } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
      }
    } else {
      echo json_encode(["success" => false, "error" => "Missing order_id"]);
    }
    break;

  default:
    echo json_encode(["success" => false, "error" => "Invalid request method"]);
}
?>
