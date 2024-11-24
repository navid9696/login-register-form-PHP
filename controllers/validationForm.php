<?php
function validate_form($context = "login")
{
    $username = $password = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        (empty(trim($_POST["username"])))
            ? $username_err = "✨ Oops! You gotta enter a username! ✨"
            : $username = trim($_POST["username"]);


        if (empty(trim($_POST["password"]))) {
            $password_err = "💖 Oh no! You forgot to set a magic key! 💖";
        } elseif (strlen(trim($_POST["password"])) < 6) {
            $password_err = "💔 This needs to be at least 6 char long! 💔";
        } else {
            $password = trim($_POST["password"]);
        }

        if ($context === "register") {
            if (empty(trim($_POST["confirm_password"]))) {
                $confirm_password_err = "🌸 Please confirm your magic key! 🌸";
            } else {
                $confirm_password = trim($_POST["confirm_password"]);
                ($password !== $confirm_password) &&
                    $confirm_password_err = "💔 Oh no! The magic keys don't match! 💔";
            }
        } else {

            if (isset($_POST["confirm_password"]) && !empty(trim($_POST["confirm_password"]))) {
                $confirm_password = trim($_POST["confirm_password"]);
                if ($password !== $confirm_password) {
                    $confirm_password_err = "💔 Oh no! The magic keys don't match! 💔";
                }
            }
        }

        return [
            'username' => $username,
            'password' => $password,
            'confirm_password' => $confirm_password,
            'username_err' => $username_err,
            'password_err' => $password_err,
            'confirm_password_err' => $confirm_password_err,
        ];
    }
    return null;
}
