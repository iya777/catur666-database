<?php

class UserRegistrar {
    private $con;

    public function __construct(mysqli $con) {
        $this->con = $con;
    }

    public function registerUser($username, $password) {
        if ($this->usernameExists($username)) {
            return "3: Name already exists";  // Username is already taken
        }

        $salt = $this->generateSalt($username);
        $hash = $this->generateHash($password, $salt);

        $this->insertUser($username, $hash, $salt);

        return "0";
    }

    protected function usernameExists($username) {
        $nameCheckQuery = "SELECT username FROM user WHERE username='" . $username . "';";
        $nameCheck = mysqli_query($this->con, $nameCheckQuery) or die("2: Name check query failed");

        return mysqli_num_rows($nameCheck) > 0;
    }

    protected function generateSalt($username) {
        return "\$5\$rounds=5000\$" . "gabrielsukapokemon" . $username . "\$";
    }

    protected function generateHash($password, $salt) {
        return crypt($password, $salt);
    }

    protected function insertUser($username, $hash, $salt) {
        $insertUserQuery = "INSERT INTO user (username, hash, salt) VALUES ('" . $username . "', '" . $hash . "', '" . $salt . "');";
        mysqli_query($this->con, $insertUserQuery) or die("4: Insert user query failed");
    }
}

// Connection details
$con = mysqli_connect('localhost', 'root', 'root', 'unityaccess');

// Usage
$userRegistrar = new UserRegistrar($con);

if (isset($_POST["name"]) && isset($_POST["password"])) {
    $result = $userRegistrar->registerUser($_POST["name"], $_POST["password"]);
    echo $result;
} else {
    echo "Invalid parameters";
}
?>