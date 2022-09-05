<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <?php
    include "includes/navbar.php";
    echo http_response_code(404);
    ?>
    <main class="flex forms content">
        <h1 class="Font404">404 Error</h1>
        <img src="./images/404.svg" alt="" class="img404">
    </main>
    <style>
    .Font404 {
        font-size: 3rem;
        font-weight: bold;
        /* color: #1ba94c; */
        margin: 2rem;

    }

    .img404 {
        height: 25rem;
        width: 100%;
    }
    </style>
</body>

</html>