<?php
session_start();
include("database.php"); // Include database connection

if (!isset($_SESSION['email'])) {
    header('Location: register.php');
    exit;
}

$email = $_SESSION['email'];
$error = "";
$success = "";

// Handle profile picture upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_pic'])) {
    $uploadDir = 'uploads/'; // Directory to save the uploaded files

// Ensure the upload directory exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true); // Create the directory with write permissions
}

$file = $_FILES['profile_pic'];
$fileName = basename($file['name']);
$targetFilePath = $uploadDir . $fileName;

// Check file type
$fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
$allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

if (in_array($fileType, $allowedTypes)) {
    if ($file['error'] == 0) {
        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            // Update profile picture in the database
            $query = "UPDATE users SET profile_pic = ? WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ss', $targetFilePath, $email);

            if ($stmt->execute()) {
                $success = "Profile picture updated successfully!";
            } else {
                $error = "Database error: Unable to update profile picture.";
            }
        } else {
            $error = "File upload failed. Check directory permissions or file path.";
        }
    } else {
        $error = "Error uploading file.";
    }
} else {
    $error = "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
}
}

// Fetch user's current profile picture
$query = "SELECT profile_pic, username, email FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <title> Profile Picture</title>
</head>
<body>
    
    <a class="dropdown-item" href="logout.php">Sign out</a>
    
  </div>
</div>

    <div>
<div class="prof">
    <?php if (!empty($user['profile_pic'])): ?>
            <img src="<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Profile Picture" style="width:135px; height:135px; border-radius:50%;"> 
            <div class="pf"><h1>Post</h1></div> <div class="pt"><h1>Friends</h1></div>
           <div class="name"> <h1> <?php echo htmlspecialchars($user['username']); ?> 
        <?php else: ?>
           <p>No profile picture set.</p>
        <?php endif; ?>
    </div>
    </div>
    </div>

    <div>
        <?php if (!empty($error)): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <p style="color:green;"><?php echo $success; ?></p>
        <?php endif; ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="profile_pic" accept="image/*" required>
            <button type="submit"><i class="fa-solid fa-user-plus"></i></button>
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
    margin-top: 135%;
    border-top: solid 1px black;
    font-size: 25px;
}

body {
  background: #84A7B6;
}


h1 {
  color: whitesmoke;
  font-family: Arial, Helvetica, sans-serif;
}

nav.navbar.bg-body-tertiary {
    font-size: 50px;
    color: black;}

.pf {
    display: flex;
    flex-direction: row-reverse;
    margin-top: -120px;
    margin-bottom: 50px;
    margin-right: 150px;
}

.pt {
    display: flex;
    flex-direction: row-reverse;
    margin-top: -130px;
    margin-bottom: 50px;
    margin-right: 10px;
}

.prof {
    margin-top: 50px;
}

.name {
    font-size: 13px;
    margin-left: 15px;
}

form {
    margin-right: 50px;
}

button {
    font-size: 20px;
}

input[type="file"] {
    font-size: 15px;
}

a.dropdown-item {
    color: #2968cc;
    font-size: 20px;
    margin-left: 330px;
}
</style>


</body>
</html>
