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

$search_term = "";
if (isset($_GET['query'])) {
    $search_term = $_GET['query'];
}

$sql = "SELECT * FROM movies";
if (!empty($search_term)) {
    $sql .= " WHERE Name LIKE :search_term";
}

$stmt = $pdo->prepare($sql);

if (!empty($search_term)) {
    $stmt->bindValue(':search_term', '%' . $search_term . '%');
}

$stmt->execute();
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movie List</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .movie { margin-bottom: 20px; }
        .movie img { max-width: 100px; }
    </style>
</head>
<body>
    <header>
        <h1>Movie List</h1>
        <nav>
            <a href="index.html">Home</a>
            <a href="moviespage.html">Movies</a>
            <a href="#">TV Series</a>
            <a href="#">Animated Movies</a>
            <a href="#">My List</a>
        </nav>
    </header>

    <main>
        <form action="index.php" method="get">
            <input type="text" name="query" placeholder="Search for a movie..." value="<?php echo htmlspecialchars($search_term); ?>">
            <button type="submit">Search</button>
        </form>
        <div id="results">
            <?php
            if (count($movies) > 0) {
                foreach ($movies as $movie) {
                    echo "<div class='movie'>";
                    echo "<a href='movie.php?id={$movie['idM']}'></a>";
                    echo "<h3><a href='movie.php?id={$movie['idM']}'>{$movie['Name']}</a></h3>";
                    echo "</div>";
                }
            } else {
                echo "<p>No movies found.</p>";
            }
            ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Movie Search. All rights reserved.</p>
    </footer>
</body>
</html>

