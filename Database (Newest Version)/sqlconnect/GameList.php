<?php
class SavedGamesRetriever {
    private $con;

    public function __construct(mysqli $con) {
        $this->con = $con;
    }

    public function getSavedGames($username, $offset, $limit) {
        $userID = $this->getUserID($username);

        if (!$userID) {
            return "Error, userID doesn't exist with that username";
        }

        $savedGames = $this->fetchSavedGames($userID, $offset, $limit);

        return $savedGames;
    }

    protected function getUserID($username) {
        $nameCheckQuery = "SELECT userID FROM user WHERE username='" . $username . "';";
        $nameCheck = mysqli_query($this->con, $nameCheckQuery) or die(mysqli_error($this->con));

        if (mysqli_num_rows($nameCheck) == 1) {
            $infoNameCheck = mysqli_fetch_assoc($nameCheck);
            return $infoNameCheck['userID'];
        }

        return null;
    }

    protected function fetchSavedGames($userID, $offset, $limit) {
        $idCheckQuery = "SELECT savedGameID, FEN, gameMode, vsAI, difficultyAI, isWhite, lastModified, white_time, black_time FROM savedgames WHERE userID='" . $userID . "' LIMIT " . $offset . ", " . $limit . ";";
        $idCheck = mysqli_query($this->con, $idCheckQuery) or die(mysqli_error($this->con));

        $savedGamesData = array();

        if ($idCheck) {
            while ($info = mysqli_fetch_assoc($idCheck)) {
                $savedGamesData[] = array(
                    'savedGameID' => $info["savedGameID"],
                    'FEN' => $info["FEN"],
                    'gameMode' => $info["gameMode"],
                    'vsAI' => $info["vsAI"],
                    'difficultyAI' => $info["difficultyAI"],
                    'isWhite' => $info["isWhite"],
                    'lastModified' => $info["lastModified"],
                    'white_time' => $info["white_time"],
                    'black_time' => $info["black_time"]
                );
            }
        }

        return $savedGamesData;
    }
}

// Connection details
$con = mysqli_connect('localhost', 'root', 'root', 'unityaccess');

// Usage
$savedGamesRetriever = new SavedGamesRetriever($con);
$savedGames = $savedGamesRetriever->getSavedGames($_POST["username"], $_POST["current_index"], 16);

if (is_array($savedGames) && count($savedGames) > 0) {
    foreach ($savedGames as $game) {
        echo "0\t{$game['savedGameID']}\t{$game['FEN']}\t{$game['gameMode']}\t{$game['vsAI']}\t{$game['difficultyAI']}\t{$game['isWhite']}\t{$game['lastModified']}\t{$game['white_time']}\t{$game['black_time']}\n";
    }
} else {
    echo $savedGames; // Error message
}
?>