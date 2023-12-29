<?php

class GameSaver {
    private $con;

    public function __construct(mysqli $con) {
        $this->con = $con;
    }

    public function saveGame($postData) {
        $username = $postData["username"];
        $overrideGame = $postData["overridegame"];
        $savedGameId = $postData["savedgameid"];

        $userInfo = $this->getUserInfo($username);

        if (!$userInfo) {
            return "Error, userID doesn't exist with that username";
        }

        $userId = $userInfo["userID"];
        $fen = $postData["fen"];
        $gameMode = $postData["gamemode"];
        $vsAi = $postData["vsai"];
        $difficultyAi = $postData["difficultyai"];
        $isWhite = $postData["iswhite"];
        $whiteTime = $postData["white_time"];
        $blackTime = $postData["black_time"];

        if ($overrideGame == "TRUE") {
            $this->overrideSavedGame($userId, $savedGameId, $fen, $gameMode, $vsAi, $difficultyAi, $isWhite, $whiteTime, $blackTime);
        } else {
            $this->insertSavedGame($userId, $fen, $gameMode, $vsAi, $difficultyAi, $isWhite, $whiteTime, $blackTime);
        }

        return "0";
    }

    protected function getUserInfo($username) {
        $nameCheckQuery = "SELECT userID FROM user WHERE username='" . $username . "';";
        $nameCheck = mysqli_query($this->con, $nameCheckQuery) or die(mysqli_error($this->con));

        if (mysqli_num_rows($nameCheck) == 1) {
            return mysqli_fetch_assoc($nameCheck);
        }

        return null;
    }

    protected function overrideSavedGame($userId, $savedGameId, $fen, $gameMode, $vsAi, $difficultyAi, $isWhite, $whiteTime, $blackTime) {
        $overrideSavedGameQuery = "UPDATE savedgames SET FEN = '$fen', gameMode = '$gameMode', vsAI = '$vsAi', difficultyAI = '$difficultyAi', isWhite = '$isWhite', white_time = '$whiteTime', black_time = '$blackTime' WHERE userID = $userId AND savedGameID = $savedGameId;";
        mysqli_query($this->con, $overrideSavedGameQuery) or die(mysqli_error($this->con));
    }

    protected function insertSavedGame($userId, $fen, $gameMode, $vsAi, $difficultyAi, $isWhite, $whiteTime, $blackTime) {
        $insertSavedGameQuery = "INSERT INTO savedgames (userID, FEN, gameMode, vsAI, difficultyAI, isWhite, white_time, black_time) VALUES ('$userId', '$fen', '$gameMode', '$vsAi', '$difficultyAi', '$isWhite', '$whiteTime', '$blackTime');";
        mysqli_query($this->con, $insertSavedGameQuery) or die(mysqli_error($this->con));
    }
}

// Connection details
$con = mysqli_connect('localhost', 'root', 'root', 'unityaccess');

// Usage
$gameSaver = new GameSaver($con);

if (isset($_POST["username"]) && isset($_POST["overridegame"]) && isset($_POST["savedgameid"])) {
    $result = $gameSaver->saveGame($_POST);
    echo $result;
} else {
    echo "Invalid parameters";
}
?>