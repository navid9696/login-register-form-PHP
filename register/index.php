<?php
include '../controllers/validationForm.php';

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validation_results = validate_form("register");

    if ($validation_results) {
        $username = $validation_results['username'];
        $password = $validation_results['password'];
        $confirm_password = $validation_results['confirm_password'];
        $username_err = $validation_results['username_err'];
        $password_err = $validation_results['password_err'];
        $confirm_password_err = $validation_results['confirm_password_err'];

        if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
            $servername = "localhost";
            $db_username = "root";
            $db_password = "";
            $dbname = "user_registration";

            $conn = new mysqli($servername, $db_username, $db_password, $dbname);


            ($conn->connect_error) && die("Connection failed: " . $conn->connect_error);



            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {

                $username_err = "✨ Oops! The username already exists! ✨";
            } else {

                $hashed_password = password_hash($password, PASSWORD_DEFAULT);


                $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $stmt->bind_param("ss", $username, $hashed_password);

                if ($stmt->execute()) {
                    header("Location: /login");
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }
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
    <title>Register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gloria+Hallelujah&family=Henny+Penny&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/form.css">
</head>

<body>
    <div class="form-container">
        <div class="form-box" role="form" aria-labelledby="register-form-title">
            <h1 class="form-box__title">Join the Fun!</h1>
            <form class="form" action="" method="post" aria-describedby="register-description" novalidate>
                <div class="form-group">
                    <label class="form-group__label" for="username">Name</label>
                    <input placeholder="Cute username here!" class="form-group__input" type="text" id="username" name="username" required aria-required="true" aria-describedby="username-help" value="<?php echo htmlspecialchars($username); ?>">
                    <small id="username-help" class="form-group__error"><?php echo $username_err; ?></small>
                </div>
                <div class="form-group">
                    <label class="form-group__label" for="password">Magic Key</label>
                    <input placeholder="Shh... it's a secret!" class="form-group__input" type="password" id="password" name="password" required aria-required="true" aria-describedby="password-help">
                    <small id="password-help" class="form-group__error"><?php echo $password_err; ?></small>
                </div>
                <div class="form-group">
                    <label class="form-group__label" for="confirm_password">Magic Key... Again</label>
                    <input placeholder="Just to be extra sure!" class="form-group__input" type="password" id="confirm_password" name="confirm_password" required aria-required="true" aria-describedby="confirm-password-help">
                    <small id="confirm-password-help" class="form-group__error"><?php echo $confirm_password_err; ?></small>
                </div>
                <div class="form-group">
                    <a href="/login" class="form-group__link">If you&apos;re already a member, just log in!</a>
                    <button class="form-group__submit-btn" type="submit">Sign Me Up!</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>