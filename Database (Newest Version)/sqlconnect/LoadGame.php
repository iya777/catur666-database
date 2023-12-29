<?php

class GameLoader {
    private $con;

    public function __construct(mysqli $con) {
        $this->con = $con;
    }

    public function loadGame($postData) {
        $username = $postData["username"];

        $userInfo = $this->getUserInfo($username);

        if (!$userInfo) {
            return "Error, userID doesn't exist with that username";
        }

        $savedGameId = $this->getSavedGameId($userInfo["userID"]);

        return "0\t" . $savedGameId;
    }

    protected function getUserInfo($username) {
        $nameCheckQuery = "SELECT userID FROM user WHERE username='" . $username . "';";
        $nameCheck = mysqli_query($this->con, $nameCheckQuery) or die("2: Name check query failed");

        if (mysqli_num_rows($nameCheck) == 1) {
            return mysqli_fetch_assoc($nameCheck);
        }

        return null;
    }

    protected function getSavedGameId($userId) {
        $idCheckQuery = "SELECT savedGameID FROM savedgames WHERE userID='" . $userId . "';";
        $idCheck = mysqli_query($this->con, $idCheckQuery) or die("userID check query failed");

        $info = mysqli_fetch_assoc($idCheck);

        return $info ? $info["savedGameID"] : null;
    }
}

// Connection details
$con = mysqli_connect('localhost', 'root', 'root', 'unityaccess');

// Usage
$gameLoader = new GameLoader($con);
$result = $gameLoader->loadGame($_POST);
echo $result;
?>