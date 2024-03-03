<?php
if (!isset($_COOKIE['usertoken'])) {
    echo '
            <main class="d-flex justify-content-center align-items-center">
            <div class="d-flex flex-column justify-content-center align-items-center gap-2">
            <h3>Please Login to Read our Contents</h3>
            <a class="btn btn-primary" href="/">Login</a>
            </div>
            </main>
        ';
    exit;
} else {
    include "partials/classes.php";

    $token = $_COOKIE['usertoken'];
    $updateToken = new Token();
    $updateToken->updteToken($token);

    setcookie('usertoken', $_COOKIE['usertoken'], time() + (60 * 15), "/");
    setcookie('username', $_COOKIE['username'], time() + (60 * 15), "/");
}
