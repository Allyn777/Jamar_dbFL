<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="title"><h1>
  JAMAR
</h1><br><br>

<img src="logo.jpg" alt="logo"></div>

<style>
  .title h1 {
    color: white;
    text-align: center;
    margin-top: 150px;
}

h1 {
  color: white;
  text-align: center;
}

button#signInButton {
    color: #197676;
}
input.btn {
    background: #197676;
}

input#email {
    border-bottom: 1px solid #026CA1;
}
input#password {
  border-bottom: 1px solid #026CA1;
}

body {
  background: #84A7B6;
}

div#signIn {
    background: #84A7B6;
    margin-top:   190px;

}
p {
    color: white;
}

button#signUpButton {
    color: #197676;
}
i.fab.fa-google {
    background: white;
    color: blue;}

i.fab.fa-facebook {
  background: white;
  color: blue;}

  label {
    color: white;
}
img {
    width: 120px;
    margin-left: 150px;
    border-radius: 50px;
    height: auto;
}

div#signup {
    background: #84A7B6;
    margin-top: 150px;
}

input#fName {
    border-bottom: 1px solid #026CA1;
}
  

</style>

<div class="container" id="signup" style="display:none;">
      <h1 class="form-title">Register</h1>
      <form method="post" action="register.php">
        <div class="input-group">
           <i class="fas fa-user"></i>
           <input type="text" name="fName" id="fName" placeholder="First Name" required>
           <label for="fname">Full name</label>
        </div>
        
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <label for="email">Email</label>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <label for="password">Password</label>
        </div>
       <input type="submit" class="btn" value="Sign Up" name="signUp"> <br> <br>
      </form>
      
      <div class="icons">
        <i class="fab fa-google"></i>
        <i class="fab fa-facebook"></i>
      </div>
      <div class="links">
        <p>Already Have Account ?</p>
        <button id="signInButton">Sign In</button>
      </div>
    </div>

    <div class="container" id="signIn">
   
    <h1 class="form-title">Sign In</h1>
        <form method="post" action="register.php">
          <div class="input-group">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" id="email" placeholder="Email" required>
              <label for="email">Username or Email</label>
          </div>
          <div class="input-group">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" id="password" placeholder="Password" required>
              <label for="password">Password</label>
          </div>
          
         <input type="submit" class="btn" value="Log in" name="signIn"><br><br>
         <div class="icons">
          <i class="fab fa-google"></i>
          <i class="fab fa-facebook"></i>
        </div>
        
        </form>
        <p class="or">
        </p>
       
        <div class="links">
          <p>Don't have account?</p>
          <button id="signUpButton">Sign Up </button>
        </div>
      </div>
      <script src="script.js"></script>
</body>
</html>