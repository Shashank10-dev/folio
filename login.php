<?php
$login = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '_dbconnect.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $sql = "SELECT username, email, password FROM users WHERE username = ? AND email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "Login successful";
    } else {
        echo "Login failed";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title> Folio </title>
    <meta name="keywords" content="Folio, Portfolio, Portfolio Generator" />
    <meta name="description" content="An amazing portfolio generator" />
    <meta name="author" content="Abhishek Maurya, Shashank Patil">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" as="font">
    <script src="https://kit.fontawesome.com/0fe3b336ed.js" integrity="sha384-4COO9rz8I0+qYYdRdIIoVHqpA+m9v9vPG1zpGeyVCs2MGAE7y1pflv6aTZ1o6u2C" crossorigin="anonymous"></script>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Sofia&display=swap'>
    <link rel="stylesheet" href='css/base.css'>
    <link rel="stylesheet" href="css/login-register.css">
</head>

<body>
    <div class="container col-9">
        <div class="navbar">
            <div class="nav">
                <div class="nav-header">
                    <div class="nav-title">
                        <a href="home.html">
                            Folio
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="login-page">
            <div class="title">
                <h1>Sign in to <span style="font-family: 'Sofia', sans-serif;">Folio</span></h1>
            </div>
            <div class="form-field">
                <form action="login.php" method="post" name="login-form" class="login-form" autocomplete="on">
                    <div class="field-part">
                        <label for="username">Username</label></br>
                        <input type="text" id="username" name="username" class="form-control"></br>
                        <label for="email">Email</label></br>
                        <input type="email" id="email" name="email" class="form-control"></br>
                        <label for="password">Password</label></br>
                        <input type="password" id="password" name="password" class="form-control"></br></br>
                    </div>
                    <div class="login">
                        <input type="submit" name="login" value="Login" class="login-signup-button">
                    </div>
                </form>
            </div>
            <br>
            <div class="account-status">
                <p>Don't have an account? <a href="signup.php" target="_self" class="account">Register</a></p>
            </div>
        </div>
    </div>
</body>

</html>