<?php
session_start();
include("database.php");

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: home.php');
    exit;
}

// Fetch all posts along with user data
$postQuery = "SELECT posts.PostID, posts.Content, posts.ImagePath, posts.CreatedAt, 
                     users.Username, users.Email, users.profile_pic 
              FROM posts 
              JOIN users ON posts.UserID = users.UserID 
              ORDER BY posts.CreatedAt DESC";
$posts = $conn->query($postQuery);



$commentsQuery = "SELECT comments.Content, comments.CreatedAt, users.Username, users.profile_pic, comments.PostID 
                  FROM comments 
                  JOIN users ON comments.UserID = users.UserID 
                  ORDER BY comments.CreatedAt ASC";
$commentsResult = $conn->query($commentsQuery);
$comments = [];
while ($row = $commentsResult->fetch_assoc()) {
    $comments[$row['PostID']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timeline</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #84A7B6;
            padding: 20px;
        }
        .timeline-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .post {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #fafafa;
        }
        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .post-header img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .post-header div {
            font-size: 18   px;
        }
        .post-content img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }
        .reactions, .comments-section {
            margin-top: 10px;
        }
        .reaction-buttons button {
            margin-right: 5px;
            padding: 5px 10px;
            cursor: pointer;
            border: none;
            background: transparent;
            font-size: 18px;
        }
        .reaction-buttons button:hover {
            background-color: #f0f0f0;
        }
        .comment {
            margin-top: 10px;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 5px;
            display: flex;
            align-items: center;
        }
        .comment img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .comment small {
            color: #777;
        }
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        button[type="submit"] {
            padding: 8px 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="timeline-container">
        <h1>Timeline</h1>
        <?php if ($posts->num_rows > 0): ?>
            <?php while ($post = $posts->fetch_assoc()): ?>
                <div class="post">
                    <div class="post-header">
                        <img src="<?php echo htmlspecialchars($post['profile_pic'] ?? 'default-profile.png'); ?>" alt="Profile Picture">
                        <div>
                            <strong><?php echo htmlspecialchars($post['Username']); ?></strong><br>
                            <small><?php echo htmlspecialchars($post['Email']); ?></small><br>
                            <small><?php echo date('F j, Y, g:i a', strtotime($post['CreatedAt'])); ?></small>
                        </div>
                    </div>
                    <div class="post-content">
                        <?php if (!empty($post['Content'])): ?>
                            <p><?php echo htmlspecialchars($post['Content']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($post['ImagePath'])): ?>
                            <img src="<?php echo htmlspecialchars($post['ImagePath']); ?>" alt="Post Image">
                        <?php endif; ?>
                    </div>
                    <div class="reactions">
                        <?php
                        $postReactions = $reactions[$post['PostID']] ?? [];
                        ?>
                        <div class="reaction-buttons">
                            <button>👍 (<?php echo $postReactions['like'] ?? 0; ?>)</button>
                            <button>❤️ (<?php echo $postReactions['heart'] ?? 0; ?>)</button>
                            <button>😢 (<?php echo $postReactions['sad'] ?? 0; ?>)</button>
                            <button>😮 (<?php echo $postReactions['wow'] ?? 0; ?>)</button>
                        </div>
                    </div>
                    <div class="comments-section">
                        <h4>Comments:</h4>
                        <?php if (!empty($comments[$post['PostID']])): ?>
                            <?php foreach ($comments[$post['PostID']] as $comment): ?>
                                <div class="comment">
                                    <img src="<?php echo htmlspecialchars($comment['profile_pic'] ?? 'default-profile.png'); ?>" alt="User Profile">
                                    <div>
                                        <strong><?php echo htmlspecialchars($comment['Username']); ?>:</strong>
                                        <p><?php echo htmlspecialchars($comment['Content']); ?></p>
                                        <small><?php echo date('F j, Y, g:i a', strtotime($comment['CreatedAt'])); ?></small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No comments yet.</p>
                        <?php endif; ?>
                        <form action="comment.php" method="POST">
                            <input type="hidden" name="post_id" value="<?php echo $post['PostID']; ?>">
                            <textarea name="comment" placeholder="Write a comment..." required></textarea>
                            <button type="submit">Comment</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No posts yet. Start the conversation!</p>
        <?php endif; ?>
    </div>
</body>
</html>
