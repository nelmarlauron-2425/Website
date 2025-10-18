<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../config/dbconfig.php';

$conditions = [];
$params = [];
$types = ''; // For bind_param

// SEARCH
if (!empty($_GET['search'])) {
  $conditions[] = "(title LIKE ? OR artist_name LIKE ?)";
  $search = '%' . $_GET['search'] . '%';
  $params[] = $search;
  $params[] = $search;
  $types .= 'ss';
}

// FILTERS
$filters = ['category', 'medium', 'subject', 'size', 'material'];
foreach ($filters as $filter) {
  if (!empty($_GET[$filter])) {
    $values = explode(',', $_GET[$filter]);
    $placeholders = implode(',', array_fill(0, count($values), '?'));
    $conditions[] = "$filter IN ($placeholders)";
    foreach ($values as $v) {
      $params[] = $v;
      $types .= 's';
    }
  }
}

// PRICE RANGE
if (!empty($_GET['minPrice'])) {
  $conditions[] = "price >= ?";
  $params[] = $_GET['minPrice'];
  $types .= 'd';
}
if (!empty($_GET['maxPrice'])) {
  $conditions[] = "price <= ?";
  $params[] = $_GET['maxPrice'];
  $types .= 'd';
}

$whereSQL = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';
$query = "SELECT * FROM artworks $whereSQL ORDER BY artwork_id DESC";

$stmt = $conn->prepare($query);

if (!$stmt) {
  echo json_encode(['error' => 'Failed to prepare statement: ' . $conn->error]);
  exit;
}

if (!empty($params)) {
  $stmt->bind_param($types, ...$params);
}

if (!$stmt->execute()) {
  echo json_encode(['error' => 'Query execution failed: ' . $stmt->error]);
  exit;
}

$result = $stmt->get_result();
$artworks = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode([
  'count' => count($artworks),
  'query' => $query,
  'data' => $artworks
]);
?>
