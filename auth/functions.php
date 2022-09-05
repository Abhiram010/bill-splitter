    <?php
    $result;
    function emptyInputSignup($name, $email, $password, $passwords)
    {
        if (empty($name) || empty($email) || empty($password) || empty($passwords)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
    function invalidUid($username)
    {
        if (preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $result = true;
            return true;
        } else {
            $result = false;
            return false;
        }
    }

    function invalidEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
    function pwdMatch($password, $passwords)
    {
        if ($password !== $passwords) {
            $result = true;
            return true;
        } else {
            $result = false;
            return false;
        }
    }
    function uidExists($conn, $username, $email)
    {
        $sql = "SELECT * FROM users WHERE userName = ? OR userEmail = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $theresult = [$row, true];

            return $theresult;
        } else {
            $row = [];
            $theresult = [$row, false];

            return $theresult;
        }
    }



    function createUser($conn, $name, $email, $password)
    {
        $hashPwd = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (userName, userEmail,coins, userPwd) VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $coins = 10000;
        $stmt->bind_param("ssss", $name, $email, $coins, $hashPwd);
        $stmt->execute();
        $stmt->close();
        header("Location: ../login.php?error=none");
    }
    function
    loginUser($conn, $username, $password)
    {
        // no problem as we have username or email so validating any one of them is fine
        $uidExists = uidExists($conn, $username, $username);
        if ($uidExists === false) {
            header("Location: ../login.php?error=wronglogin");
            exit();
        }
        $pwdHashed = $uidExists[0]["userPwd"];

        // unhashing the password
        $checkPwd = password_verify($password, $pwdHashed);
        if ($checkPwd === false) {
            header("Location: ../login.php?error=wronglogin");
            exit();
        } else if ($checkPwd == true) {
            session_start();
            $_SESSION["userId"] = $uidExists[0]["userId"];
            $_SESSION["userName"] = $uidExists[0]["userName"];
            $_SESSION["userEmail"] = $uidExists[0]["userEmail"];
            $a = $uidExists[0]["userName"];
            header("Location: ../dashboard.php?code=$a");
            exit();
        }
    }
