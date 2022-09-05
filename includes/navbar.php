<nav class="flex">
    <span class="flex branding">
        <img src="./images/logo.png" alt="">
        <h2><a href="index.php"><span style="color:#1ba94c ;">Bill</span>Spillter</a></h2>
    </span>
    <ul class="flex">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="spilt.php">Create bill</a></li>
        <?php
        if (!isset($_SESSION['userId'])) {
            echo " <li><a href='login.php'>Login</a></li>";
        } else {
            echo " <li><a href='account.php'>Account</a></li>";
        }
        ?>
    </ul>

</nav>
<script src="https://kit.fontawesome.com/e8988c25e2.js" crossorigin="anonymous"></script>