<?php

class DeleteAccount {
    private $con;

    public function __construct(mysqli $con) {
        $this->con = $con;
    }

    public function deleteAccount($username, $password) {
        $existingInfo = $this->getUserInfo($username);

        if (!$existingInfo) {
            return "5";  // User not found
        }

        if (!$this->validatePassword($password, $existingInfo['salt'], $existingInfo['hash'])) {
            return "1"; // Incorrect password
        }

        $deleteQuery = "DELETE FROM user WHERE username='" . $username . "';";
        $delete = mysqli_query($this->con, $deleteQuery) or die("delete query failed");

        return "0";
    }

    protected function getUserInfo($username) {
        $nameCheckQuery = "SELECT username, salt, hash, score FROM user WHERE username='" . $username . "';";
        $nameCheck = mysqli_query($this->con, $nameCheckQuery) or die("2");

        if (mysqli_num_rows($nameCheck) != 1) {
            return null;
        }

        return mysqli_fetch_assoc($nameCheck);
    }

    protected function validatePassword($password, $salt, $hash) {
        $loginHash = crypt($password, $salt);
        return $hash == $loginHash;
    }
}

// Connection details
$con = mysqli_connect('localhost', 'root', 'root', 'unityaccess');

// Usage
$accountDeletion = new DeleteAccount($con);
$result = $accountDeletion->deleteAccount($_POST["username"], $_POST["password"]);
echo $result;
?>