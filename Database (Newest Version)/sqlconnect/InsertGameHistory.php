<?php

class GameHistoryInserter {
    private $con;

    public function __construct(mysqli $con) {
        $this->con = $con;
    }

    public function insertGameHistory($postData) {
        $username = $postData["username"];

        $userInfo = $this->getUserInfo($username);

        if (!$userInfo) {
            return "Error, userID doesn't exist with that username";
        }

        $userid = $userInfo["userID"];
        $overrideGame = $postData["overridegame"];
        $savedGameId = $postData["savedgameid"];

        if ($overrideGame == "TRUE") {
            $this->deleteSavedGame($userid, $savedGameId);
        }

        $this->insertGame($postData, $userid);

        $newCurrentScore = $postData["_newcurrentscore"];
        $win = $postData["win"];
        $lose = $postData["lose"];
        $draw = $postData["draw"];

        $this->updateUserScore($userid, $newCurrentScore, $win, $lose, $draw);

        return "0";
    }

    protected function getUserInfo($username) {
        $nameCheckQuery = "SELECT userID FROM user WHERE username='" . $username . "';";
        $nameCheck = mysqli_query($this->con, $nameCheckQuery) or die("2: Name check query failed");

        if (mysqli_num_rows($nameCheck) == 1) {
            return mysqli_fetch_assoc($nameCheck);
        }

        return null;
    }

    protected function deleteSavedGame($userid, $savedGameId) {
        $deleteQuery = "DELETE FROM savedgames WHERE userID = $userid AND savedGameID = $savedGameId;";
        mysqli_query($this->con, $deleteQuery) or die(mysqli_error($this->con));
    }

    protected function insertGame($postData, $userid) {
        $insertQuery = "INSERT INTO gamehistory (userID, gameResult, gameMode, vsAI, difficultyAI, scoreGained, FEN, isWhite) VALUES ('" . $userid . "', '" . $postData["gameresult"] . "', '" . $postData["gamemode"] . "', '" . $postData["vsai"] . "', '" . $postData["difficultyai"] . "', '" . $postData["scoregained"] . "', '" . $postData["fen"] . "', '" . $postData["iswhite"] . "');";
        mysqli_query($this->con, $insertQuery) or die(mysqli_error($this->con));
    }

    protected function updateUserScore($userid, $newCurrentScore, $win, $lose, $draw) {
        $updateQuery = "UPDATE user SET score = $newCurrentScore, win = $win, lose = $lose, draw = $draw WHERE userID = $userid;";
        mysqli_query($this->con, $updateQuery) or die(mysqli_error($this->con));
    }
}

// Connection details
$con = mysqli_connect('localhost', 'root', 'root', 'unityaccess');

// Usage
$gameHistoryInserter = new GameHistoryInserter($con);
$result = $gameHistoryInserter->insertGameHistory($_POST);
echo $result;
?>