<?php

class AccountDeletion {
    private $con;

    public function __construct(mysqli $con) {
        $this->con = $con;
    }

    public function deleteAccount($username, $password) {
        // Check if the username exists
        $namecheckquery = "SELECT username, salt, hash, score FROM user WHERE username='" . $username . "';";
        $namecheck = mysqli_query($this->con, $namecheckquery) or die("2");

        if (mysqli_num_rows($namecheck) != 1) {
            return "5";  // error code 5 - num of names matching != 1 : Either no user with name, or more than one
        }

        // get login info from query
        $existinginfo = mysqli_fetch_assoc($namecheck);
        $salt = $existinginfo["salt"];
        $hash = $existinginfo["hash"];

        $loginhash = crypt($password, $salt);
        if ($hash != $loginhash) {
            return "1"; // error code #6 password does not hash to match table
        } else {
            $deletequery = "DELETE FROM user WHERE username='" . $username . "';";
            $delete = mysqli_query($this->con, $deletequery) or die("delete query failed");
            return "0";
        }
    }
}

$con = mysqli_connect('localhost', 'root', 'root', 'unityaccess');
$accountDeletion = new AccountDeletion($con);
$result = $accountDeletion->deleteAccount($_POST["username"], $_POST["password"]);
echo $result;

?>