<?php
// Include the database connection file or define connection details here
$host = 'localhost';
$dbname = 'coursework';
$username = 'root';
$password = '';        

// Function to establish a PDO connection
function connectToDatabase($host, $dbname, $username, $password) {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return null;
    }
}

// Function to fetch questions
function getQuestion($pdo, $question_id) {
    $question_result = null;
    $question_query = "SELECT * FROM questionfield WHERE ID = :id";
    $question_statement = $pdo->prepare($question_query);
    $question_statement->bindParam(':id', $question_id);
    $question_statement->execute();
    $question_result = $question_statement->fetch(PDO::FETCH_ASSOC);
    return $question_result;
}

// Function to fetch comments for a question
function getCommentsForQuestion($pdo, $question_id) {
    $sql = "SELECT * FROM comment WHERE CommentID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$question_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Establish connection to the database
$pdo = connectToDatabase($host, $dbname, $username, $password);

// If connection is successful and question ID is provided, proceed to fetch and display question with comments
if ($pdo && isset($_GET['id'])) {
    $question_id = $_GET['id'];
    $question = getQuestion($pdo, $question_id);
    $comments = getCommentsForQuestion($pdo, $question_id);
    $pdo = null;
} else {
    echo "<p>Invalid request.</p>";
}
?>
