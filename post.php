<?php
session_start();
include("database.php"); // Include database connection

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: home.php');
    exit;
}

// Fetch the logged-in user data
$email = $_SESSION['email'];
$userQuery = "SELECT * FROM users WHERE Email = ?";
$stmt = $conn->prepare($userQuery);
$stmt->bind_param('s', $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    die("Error: User not found.");
}

$userId = $user['UserID'];
$username = $user['Username'];
$profile_pic = $user['profile_pic'];
$userEmail = $user['Email'];

// Handle post submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = trim($_POST['content']);
    $imagePath = null;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($_FILES['image']['name']);
        $targetPath = $uploadDir . uniqid() . "_" . $fileName;
        $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imagePath = $targetPath;
            } else {
                echo "Error: Failed to upload the image.";
            }
        } else {
            echo "Error: Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    }

    // Insert post into the database
    if (!empty($content) || $imagePath) {
        $insertPost = "INSERT INTO posts (UserID, Content, ImagePath) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertPost);
        $stmt->bind_param('iss', $userId, $content, $imagePath);
        $stmt->execute();
        header('Location: timeline.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Post</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-top: 35px;
        }
        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .user-info img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .user-info div {
            font-size: 25px;
        }
        form textarea {
            width: 95%;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 50px;
            font-size: 20px;
        }
        form button {
            padding: 10px 15px;
            background: #197676;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 50px;
            font-size: 20px
        }
        form button:hover {
            background: #0056b3;
        }
        body {
            background: #84A7B6;
        }  

        input[type="file"] {
        font-size: 15px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="user-info">
            <?php if ($profile_pic): ?>
                <img src="<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture">
            <?php else: ?>
                <img src="default-profile.png" alt="Default Profile Picture">
            <?php endif; ?>
            <div>
                <strong><?php echo htmlspecialchars($username); ?></strong><br>
                <small><?php echo htmlspecialchars($userEmail); ?></small>
            </div>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <textarea name="content" placeholder="What's on your mind?"></textarea>
            <input type="file" name="image" accept="image/*">
            <button type="submit">Post</button>
        </form>
    </div>

    <div> <hr>
    <nav class="navbar navbar-expand-lg">
  
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="home.php"><i class="fa-solid fa-house"></i> <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
      <a class="nav-item nav-link" href="post.php"><i class="fa-solid fa-plus"></i></a>
      <a class="nav-item nav-link disabled" href="timeline.php"><i class="fa-solid fa-clapperboard"></i></a>
      <a class="nav-item nav-link disabled" href="profile.php"><i class="fa-solid fa-circle-user"></i></a>

    </div>
  </div>
</nav>
</div>
<style>

i.fa-solid.fa-house {
    margin: 10px;
}
a.nav-item.nav-link {
    margin: 22px;
    color: black;
}

.navbar-nav {
    margin-top: 95%;
    border-top: solid 1px black;
    font-size: 25px;
}



nav.navbar.bg-body-tertiary {
    font-size: 20px;
    color: black;}




</style>

</body>
</html>
