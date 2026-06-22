<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'celesthica';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS journals (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL,
    excerpt TEXT,
    content LONGTEXT,
    cover_image VARCHAR(255),
    author VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'journals' created successfully.\n";
    
    // Insert some dummy data matching the previous static ones
    $dummy = "INSERT INTO journals (title, type, excerpt, content, cover_image, author) VALUES 
    ('Celestial Tides.', 'Curator\'s Note', 'As the newest volumes make landfall in the grand archive, the Grand Librarian reveals the uncanny secrets of the stellar catalog.', '<p>Full content of Celestial Tides goes here. This is a longer text detailing the arrival of new volumes and secrets of the grand archive.</p>', 'vol-odoc.png', 'SAFILA MUTIARA'),
    ('The Myth of Sisyphus: A Modern Read', 'Review', 'A modern look at the classic philosophical essay.', '<p>Full text for The Myth of Sisyphus review...</p>', 'vol-fantasy.png', 'ARCHIVIST LUNA'),
    ('10 Must-Read Fantasy Classics for Beginners', 'List', 'A list for those starting their fantasy journey.', '<p>Full text for the list...</p>', 'vol-new-arrival.png', 'GUEST SCHOLAR'),
    ('Conversations with the Constellations', 'Interview', 'An interview with the stars.', '<p>Full text for the interview...</p>', 'vol-journalism.png', 'SAFILA MUTIARA')";
    
    $conn->query($dummy);
    echo "Dummy data inserted.\n";

} else {
    echo "Error creating table: " . $conn->error . "\n";
}

$conn->close();
