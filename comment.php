<?php
session_start();
include("database.php");

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: home.php');
    exit;
}

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = intval($_POST['post_id']);
    $comment = trim($_POST['comment']);
    $email = $_SESSION['email'];

    // Get the logged-in user
    $userQuery = "SELECT UserID FROM users WHERE Email = ?";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && !empty($comment)) {
        $userId = $user['UserID'];
        $insertComment = "INSERT INTO comments (PostID, UserID, Content) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertComment);
        $stmt->bind_param('iis', $postId, $userId, $comment);
        $stmt->execute();
    }
}

header('Location: timeline.php');
exit;
