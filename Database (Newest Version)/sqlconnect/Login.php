<?php

class UserLogin {
    private $con;

    public function __construct(mysqli $con) {
        $this->con = $con;
    }

    public function loginUser($username, $password) {
        $userInfo = $this->getUserInfo($username);

        if (!$userInfo) {
            return "5: Either no user with name, or more than one";
        }

        $salt = $userInfo["salt"];
        $hash = $userInfo["hash"];

        $loginHash = crypt($password, $salt);

        if ($hash != $loginHash) {
            return "6: Incorrect password";
        }

        return "0\t" . $userInfo["score"];
    }

    protected function getUserInfo($username) {
        $nameCheckQuery = "SELECT username, salt, hash, score FROM user WHERE username='" . $username . "';";
        $nameCheck = mysqli_query($this->con, $nameCheckQuery) or die("2: Name check query failed");

        if (mysqli_num_rows($nameCheck) == 1) {
            return mysqli_fetch_assoc($nameCheck);
        }

        return null;
    }
}

// Connection details
$con = mysqli_connect('localhost', 'root', 'root', 'unityaccess');

// Usage
$userLogin = new UserLogin($con);

if (isset($_POST["name"]) && isset($_POST["password"])) {
    $result = $userLogin->loginUser($_POST["name"], $_POST["password"]);
    echo $result;
} else {
    echo "Invalid parameters";
}
?>