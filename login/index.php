<?php
session_start();
include '../controllers/validationForm.php';

$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validation_results = validate_form("login");

    if ($validation_results) {
        $username = $validation_results['username'];
        $password = $validation_results['password'];
        $username_err = $validation_results['username_err'];
        $password_err = $validation_results['password_err'];


        if (empty($username_err) && empty($password_err)) {
            $servername = "localhost";
            $db_username = "root";
            $db_password = "";
            $dbname = "user_registration";


            $conn = new mysqli($servername, $db_username, $db_password, $dbname);



            ($conn->connect_error) && die("Connection failed: " . $conn->connect_error);



            $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();


            if ($stmt->num_rows == 1) {
                $stmt->bind_result($id, $hashed_password);
                $stmt->fetch();


                if (password_verify($password, $hashed_password)) {

                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["username"] = $username;

                    header("Location: https://www.wst.com.pl");
                    exit();
                } else {
                    $password_err = "💔 Oh no! The magic key is incorrect! 💔";
                }
            } else {
                $username_err = "✨Oops! No user found with that username!✨";
            }

            $stmt->close();
            $conn->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gloria+Hallelujah&family=Henny+Penny&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/form.css">
</head>

<body>
    <div class="form-container">
        <div class="form-box" role="form" aria-labelledby="login-form-title">
            <h1 class="form-box__title">Enter!</h1>
            <form novalidate class="form" method="post" aria-describedby="login-description">
                <div class="form-group">
                    <label class="form-group__label" for="username">Name</label>
                    <input placeholder="Cute username here!" class="form-group__input" type="text" id="username" name="username" required aria-required="true" aria-describedby="username-help">
                    <small id="username-help" class="form-group__error">
                        <?php echo $username_err; ?>
                    </small>
                </div>
                <div class="form-group">
                    <label class="form-group__label" for="password">Magic Key</label>
                    <input placeholder="Shh... it's a secret!" class="form-group__input" type="password" id="password" name="password" required aria-required="true" aria-describedby="password-help">
                    <small id="password-help" class="form-group__error">
                        <?php echo $password_err; ?>
                    </small>
                </div>
                <div class="form-group">
                    <a href="/register" class="form-group__link">No account yet? Let&apos;s fix that!</a>
                    <button class="form-group__submit-btn" type="submit">Let&apos;s go!</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>