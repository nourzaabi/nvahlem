<?php
// Connexion à la base de données avec PDO
$dsn = 'mysql:host=localhost;dbname=movie';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$movie_id = isset($_GET['idM']) ? intval($_GET['idM']) : 0;
$sql = "SELECT * FROM movies WHERE idM = :idM";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $movie_id, PDO::PARAM_INT);
$stmt->execute();
$movie = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$movie) {
    die("Movie not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($movie['Name']); ?></title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .movie { margin-bottom: 20px; }
        .movie img { max-width: 200px; }
    </style>
</head>
<body>
    <header>
        <h1>Movie Details</h1>
        <nav>
            <a href="index.html">Home</a>
            <a href="moviespage.html">Movies</a>
            <a href="#">TV Series</a>
            <a href="#">Animated Movies</a>
            <a href="#">My List</a>
        </nav>
    </header>

    <main>
        <div class="movie">
            
            <h1><?php echo htmlspecialchars($movie['Name']); ?></h1>
            <p><strong>Type:</strong> <?php echo htmlspecialchars($movie['Type']); ?></p>
            <p><?php echo htmlspecialchars($movie['Desc']); ?></p>
            <a href="index.php">Back to list</a>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Movie Search. All rights reserved.</p>
    </footer>
</body>
</html>
