<?php
require_once 'config.php';
require_once 'session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    if ($query = $db->prepare("SELECT * FROM users WHERE email = ?")) {
        $error = '';
        // Bind paramters (s = string, i = int, b = blob, etc), in this case username is a string so we use "s"
        $query->bind_param('s', $email);
        $query->execute();
        // Store the result so we can check if the account exists in the database.
        $query->store_result();

        if ($query->num_rows > 0) {
            $error = 'Email already exists';
        } else {

            // Validate password length
            if (strlen($password) < 6) {
                $error = '<p>Password must be at least 6 characters long.</p>';
            }

            // validate confirm password
            if (empty($confirm_password)) {
                $error .= '<p>Please confirm your password.</p>';
            } else {
                if (empty($error) && ($password != $confirm_password)) {
                    $error = '<p>Passwords do not match.</p>';
                }
            }

            if (empty($error)) {
                $insertQuery = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                $insertQuery->bind_param('sss', $username, $email, $password_hash);
                $result = $insertQuery->execute();

                if ($result) {
                    $error = '<p class="success">You have successfully registered!</p>';
                } else {
                    $error = '<p class="error">Something went wrong, please try again.</p>';
                }
            }
        }
    }
    $query->close();
    $insertQuery->close();
    //close DB connection
    mysqli_close($db);
}
?>

<html lang="en">

<head>
    <title>Folio </title>
    <meta name="keywords" content="Folio, Portfolio, Portfolio Generator">
    <meta name="description" content="An amazing portfolio generator">
    <meta name="author" content="Abhishek Maurya, Shashank Patil">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/0fe3b336ed.js" crossorigin="anonymous"></script>
    <link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>
    <link rel="stylesheet" href="css/login-register.css">
</head>

<body>
    <div class="container col-9">
        <div class="navbar">
            <div class="nav">
                <div class="nav-header">
                    <div class="nav-title"><a href="home.html">Folio </a></div>
                </div>
            </div>
        </div>
        <div class="login-page">
            <div class="title">
                <h1>Sign up to <span style="font-family: 'Sofia';">Folio</span></h1>
            </div>
            <div class="login-form-field">
                <form action="" method="post" autocomplete="on" name="login-form" class="login-form">
                    <div class="field-part"><label for="username">Username </label></br>
                        <input type="text" id="username" name="username" class="login-form-items" required /></br><label for="username">Email</label></br><input type="email" id="email" name="email" class="login-form-items" required /></br><label for="password">Password</label></br><input type="password" id="password" name="password" class="login-form-items" required /></br><label for="password">Re-Enter Password</label></br><input type="password" id="password" name="confirm-password" class="login-form-items" required /></br>
                    </div><input type="submit" name="submit" value="Sign Up" class="login-form-items">
                </form>
            </div><br>
            <div class="account-status">
                <p>Don't have an account? <a href="login.html" target="_self" class="account">Login</a></p>
            </div>
        </div>
    </div>
</body>

</html>