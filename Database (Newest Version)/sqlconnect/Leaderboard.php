<?php

class LeaderboardRetriever {
    private $con;

    public function __construct(mysqli $con) {
        $this->con = $con;
    }

    public function getLeaderboard() {
        $leaderboardQuery = "SELECT username, score, highestscore, win, lose, draw FROM user ORDER BY score DESC LIMIT 15;";
        $leaderboardResult = mysqli_query($this->con, $leaderboardQuery) or die(mysqli_error($this->con));

        $leaderboardData = array();

        if ($leaderboardResult) {
            while ($info = mysqli_fetch_assoc($leaderboardResult)) {
                $leaderboardData[] = array(
                    'username' => $info["username"],
                    'score' => $info["score"],
                    'highestscore' => $info["highestscore"],
                    'win' => $info["win"],
                    'lose' => $info["lose"],
                    'draw' => $info["draw"]
                );
            }
        }

        return $leaderboardData;
    }
}

// Connection details
$con = mysqli_connect('localhost', 'root', 'root', 'unityaccess');

// Usage
$leaderboardRetriever = new LeaderboardRetriever($con);
$leaderboard = $leaderboardRetriever->getLeaderboard();

if (is_array($leaderboard) && count($leaderboard) > 0) {
    foreach ($leaderboard as $entry) {
        echo "\t{$entry['username']}\t{$entry['score']}\t{$entry['highestscore']}\t{$entry['win']}\t{$entry['lose']}\t{$entry['draw']}\t\n";
    }
}
?>