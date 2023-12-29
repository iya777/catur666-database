<?php

class PasswordUpdater {
    private $con;

    public function __construct(mysqli $con) {
        $this->con = $con;
    }

    public function updatePassword($username, $oldPassword, $newPassword) {
        $userInfo = $this->getUserInfo($username);

        if (!$userInfo) {
            return "5";  // error code 5 - num of names matching != 1 : Either no user with name, or more than one
        }

        $salt = $userInfo["salt"];
        $hash = $userInfo["hash"];

        $oldPasswordHash = crypt($oldPassword, $salt);
        $newPasswordHash = crypt($newPassword, $salt);

        if ($hash != $oldPasswordHash) {
            return "1"; // error code #6 password does not hash to match table
        }

        $this->updatePasswordInDatabase($username, $newPasswordHash);

        return "0";
    }

    protected function getUserInfo($username) {
        $nameCheckQuery = "SELECT username, salt, hash, score FROM user WHERE username='" . $username . "';";
        $nameCheck = mysqli_query($this->con, $nameCheckQuery) or die("2"); // Error code 2 = name check query failed

        if (mysqli_num_rows($nameCheck) == 1) {
            return mysqli_fetch_assoc($nameCheck);
        }

        return null;
    }

    protected function updatePasswordInDatabase($username, $newPasswordHash) {
        $updateQuery = "UPDATE user SET hash='" . $newPasswordHash . "' WHERE username='" . $username . "';";
        mysqli_query($this->con, $updateQuery) or die("Update query failed");
    }
}

// Connection details
$con = mysqli_connect('localhost', 'root', 'root', 'unityaccess');

// Usage
$passwordUpdater = new PasswordUpdater($con);

if (isset($_POST["username"]) && isset($_POST["oldpassword"]) && isset($_POST["newpassword"])) {
    $result = $passwordUpdater->updatePassword($_POST["username"], $_POST["oldpassword"], $_POST["newpassword"]);
    echo $result;
} else {
    echo "Invalid parameters";
}
?>