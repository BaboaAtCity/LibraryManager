<?php
session_start();
$conn = require_once('dbconnection.php');

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

$error = null;
if ($username && $password) {
    $statement = 'SELECT * FROM Logins WHERE username=\''.$username.'\' AND password=\''.sha1($password).'\' LIMIT 1';
    $userStatement = $conn->prepare($statement);
    $userStatement->execute();
    $user = $userStatement->fetch();
    if ($user) {
        $_SESSION['user'] = $user['username'];
        header('Location: admin.php');
        exit();
    } else {
        $error = 'The combination of username and password provided doesn\'t exist';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="login.css"/>
</head>
<body>

<nav class="navbar">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 .d-sm-none .d-md-block" style="background-color: #eedec5; height: 50px;">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <i class="fa fa-bars fa-2x" style="color: black"></i>
                    </button>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <nav class="navbar navbar-toggleable-md navbar-light bg-faded navbar-right">
                    <div class="collapse navbar-collapse main" id="navbarNav">
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="login.php">Staff Login</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</nav>

<div class="container-fluid container-1">
    <div class="row" style="margin-top: -21px;">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 login" style="float: right; top: 50%;">
            <div class="login__details-page" style="height: 100vh;">
                <p class="login__details-text">Staff Login</p>

                <form action="login.php" method="post">
                    <?php if($error): ?>
                    <div class="alert alert-danger" role="alert"><?php echo $error ?></div>
                    <?php endif; ?>
                    <input class="login-info-page--input sm-b" type='text' placeholder="Username" id="username"
                           name="username" required
                           style="padding: 15px; border-radius: 20px; background-color: #D7D9DB;">
                    <span id="username-error" style="color:red"></span>

                    <input class="login-info-page--input " type='password' placeholder="Password" id="password"
                           name="password" required
                           style="padding: 15px; border-radius: 20px; background-color: #D7D9DB;">
                    <span id="password-error" style="color:red"></span>

                    <button type="submit" id="" class="btn-big">Login</button>
                </form>

            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 login" style="background-color: #EEDEC5; float: left;">
            <div class="login__details-page" style="height: 100vh;">
                <div class="login__details-image--box">
                    <img class="login__details-image" src="assets/img/book2.png" alt="book2 image"/>
                </div>

                <p class="login__details-text">Find your book at any time</p>
                <div class="dots">
                    <svg class="dot dot--fill" width="19" height="19"></svg>

                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
