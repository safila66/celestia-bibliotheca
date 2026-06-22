<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'celesthica';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 1. Find the book 'The Song of Achilles'
$bookResult = $conn->query("SELECT id FROM books WHERE title LIKE '%Song of Achilles%' LIMIT 1");
$bookId = null;
if ($bookResult && $bookResult->num_rows > 0) {
    $row = $bookResult->fetch_assoc();
    $bookId = $row['id'];
} else {
    // Fallback to book id 1 if not found
    $bookId = 1;
}

// 2. Insert a REAL ODOC journal entry
$title = "ODOC: Pride and Prejudice";
$type = "ODOC";
$excerpt = "Jane Austen's timeless classic that masterfully critiques the British landed gentry while delivering one of the most beloved romances in literature.";
$content = "<h2>A Timeless Classic of Romance and Social Critique</h2>
<p>In <em>Pride and Prejudice</em>, Jane Austen masterfully explores the themes of class, reputation, and love in 19th-century England.</p>
<p>The story follows Elizabeth Bennet, an intelligent and spirited young woman, as she navigates the complex social hierarchy and her own prejudices. Her initial disdain for the wealthy and aloof Mr. Darcy slowly unravels as both characters learn to see past their flaws.</p>
<blockquote>\"It is a truth universally acknowledged, that a single man in possession of a good fortune, must be in want of a wife.\"</blockquote>
<p>Austen's sharp wit and insightful commentary make this novel not only a beautiful romance but also a brilliant critique of the societal expectations of her time.</p>";
$coverImage = "vol-odoc.png"; // We can use the default ODOC cover
$author = "CURATOR SAFILA";

$stmt = $conn->prepare("INSERT INTO journals (book_id, title, type, excerpt, content, cover_image, author) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issssss", $bookId, $title, $type, $excerpt, $content, $coverImage, $author);

if ($stmt->execute()) {
    echo "Real ODOC inserted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Also revert the first journal 'Celestial Tides' back to 'Curator\'s Note' and remove book_id so it stays a normal journal
$conn->query("UPDATE journals SET type = 'Curator''s Note', book_id = NULL WHERE id = 1");

$conn->close();
