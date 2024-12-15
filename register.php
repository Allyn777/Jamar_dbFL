<?php 

include 'database.php';

if (isset($_POST['signUp'])) {
    $Username = $_POST['fName'];
    $email = $_POST['email'];
    $password_hash = md5($_POST['password']); // Using MD5 for demonstration, but consider stronger hashing like password_hash()

    // Check if the email already exists
    $checkEmail = "SELECT * FROM users WHERE Email='$email'";
    $result = $conn->query($checkEmail);
    if ($result->num_rows > 0) {
        echo "Email Address Already Exists!";
    } else {
        
        // Insert new user into the database
        $insertQuery = "INSERT INTO users (Username, Email, Password_hash) 
                        VALUES ('$Username', '$email', '$password_hash')";
        if ($conn->query($insertQuery) === TRUE) {
            header("Location: index.php");
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password_hash = md5($_POST['password']);

    
    // Verify login credentials
    $sql = "SELECT * FROM users WHERE Email='$email' AND Password_hash='$password_hash'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['Email'];
        header("Location: home.php");
        exit();
    } else {
        header("Location: index.php");
        exit();
    }
}
?>
