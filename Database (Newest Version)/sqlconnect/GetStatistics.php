<?php

class UserStatistics {
    private $con;

    public function __construct(mysqli $con) {
        $this->con = $con;
    }

    public function getStatistics($username) {
        $userInfo = $this->getUserInfo($username);

        if (!$userInfo) {
            return "5: Either no user with name, or more than one";
        }

        return $this->formatStatistics($userInfo);
    }

    protected function getUserInfo($username) {
        $nameCheckQuery = "SELECT score, highestScore, win, lose, draw FROM user WHERE username='" . $username . "';";
        $nameCheck = mysqli_query($this->con, $nameCheckQuery) or die("2: Name check query failed");

        if (mysqli_num_rows($nameCheck) == 1) {
            return mysqli_fetch_assoc($nameCheck);
        }

        return null;
    }

    protected function formatStatistics($userInfo) {
        $score = $userInfo["score"];
        $highestScore = $userInfo["highestScore"];
        $win = $userInfo["win"];
        $lose = $userInfo["lose"];
        $draw = $userInfo["draw"];

        return "$score\n$highestScore\n$win\n$lose\n$draw";
    }
}

// Connection details
$con = mysqli_connect('localhost', 'root', 'root', 'unityaccess');

// Usage
$userStatistics = new UserStatistics($con);
$statistics = $userStatistics->getStatistics($_POST["username"]);
echo $statistics;
?>