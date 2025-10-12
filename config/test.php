<?php
require_once 'artwork_dbcon.php';

$sql = "INSERT INTO artworks (title, price, days, artist_name, image_path)
VALUES
('Fantasy Portrait', 1200.00, 5, 'Luna Rivera', 'uploads/artworks/fantasy.jpg'),
('Sci-Fi Warrior', 1500.00, 7, 'Kai Santos', 'uploads/artworks/scifi.jpg'),
('Pet Portrait', 800.00, 3, 'Mira Chen', 'uploads/artworks/pet.jpg')";

if ($conn->query($sql) === TRUE) {
  echo "Sample data inserted successfully!";
} else {
  echo "Error inserting data: " . $conn->error;
}

$conn->close();
?>
