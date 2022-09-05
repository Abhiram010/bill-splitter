<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.29/sweetalert2.css"
        integrity="sha512-e+TwvhjDvKqpzQLJ7zmtqqz+5jF9uIOa+5s1cishBRfmapg7mqcEzEl44ufb04BXOsEbccjHK9V0IVukORmO8w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <title>Login</title>




</head>

<body>
    <?php
    include "./includes/navbar.php";
    include "./includes/db.php";
    // include "../auth/logout.php";

    // include './includes/logout.php';
    ?>
    <main class="flex forms content">


        <h1 class="loginHead">Welcome the <span class="green">Bill</span> splitter Family!</h1>
        <div class="flex bothforms">


            <form action="./auth/processlogin.php" method="post" class="flex login signupform" id="signupform">
                <h2 class=" text-center formheading"><span style="color:#1ba94c ;">Welcome</span> Back!</h2>
                <label for="usermail">Username/Email:</label>
                <input type="text" name="loginusermail">
                <label for="password">Password</label>
                <input type="password" name="loginpassword" id="">
                <button type="submit" name="login">Submit</button>
                <small><a href="#">Forgot password</a></small>
            </form>


            <form action="./auth/newuser.php" method="post" class="flex login loginform" id="loginform">
                <h2 class=" text-center formheading"><span class="green">Join</span> us </h2>
                <label for="name">User name:</label>
                <input type="text" name="username" pattern="[a-zA-Z0-9-]+">
                <small style="opacity:0.5 ; font-size:12px;margin:0 0 5px 0;">Only alphabets and numbers.<span
                        style="color:red;"> No
                        Spaces, Symbols</span></small>
                <label for="usermail">Email:</label>
                <input type="email" name="usermail">
                <label for="password">Password</label>
                <input type="password" name="password" id="">
                <label for="hey">Password</label>
                <input type="password" name="hey" id=""> <button type="submit" name="signup">Submit</button>
            </form>
        </div>


    </main>



    <script>
    let signup = document.getElementById('signupform');
    let login = document.getElementById('loginform');
    signup.addEventListener('mouseover', function() {
        login.style.opacity = "0.5";
        signup.style.opacity = "1";
        signup.style.transform = "scale(1.1)";
        login.style.transform = "scale(1)";
    });
    login.addEventListener('mouseover', function() {
        signup.style.opacity = "0.5";
        login.style.opacity = "1";
        login.style.transform = "scale(1.1)";
        signup.style.transform = "scale(1)";
    });
    </script>
    <!-- jquery cdn js cdn -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <!-- sweetalert2 js cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.29/sweetalert2.all.js"
        integrity="sha512-W5SwJPyOiXXyfvtnUlX/T1s6PLgKSuUcSD++cdbY0zOPi4/Ymu4dCzBHnlH5OPxKPRp6XyBp+3jvmxuMyCsoaQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == 'emptyinput') {
            echo "<script>Swal.fire({
            title: 'Error',
            text: 'Please fill in all fields',
            icon: 'error',
            confirmButtonText: 'Ok'
        })</script>";
        }
        if ($_GET["error"] == 'loginemptyinput') {
            echo "<script>Swal.fire({
            title: 'Error',
            text: 'Please fill in all fields',
            icon: 'error',
            confirmButtonText: 'Ok'
        })</script>";
        }
        if ($_GET["error"] == 'invalidemail') {
            echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Please use proper Email ID!',
    })
    </script>";
        }
        if ($_GET["error"] == 'passwordmatch') {
            echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Passwords are not marching!',
    })
    </script>";
        }
        if ($_GET["error"] == 'none') {
            echo "<script>
    Swal.fire({
        title: 'User created!',
        text: 'Login to continue',
        icon: 'success',
        confirmButtonText: 'Ok'
    })
    </script>";
        }
        if ($_GET["error"] == 'uidexists') {
            echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Username or Email Already exsits!',
    })
    </script>";
        }

        if ($_GET["error"] == 'wronglogin') {
            echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Incorrect Login Credentials',
    })
    </script>";
        }
    }
    ?>
</body>

</html>