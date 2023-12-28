<?php

    $con = mysqli_connect('localhost','root','root','unityaccess');

    // Check if the connection occurred successfully
    if (mysqli_connect_errno()){
        echo "1: Connection Failed";  // Error code 1 = connection failed
        exit();
    }

    // Check if the username exists
    $leaderboardquery = "SELECT username, score, highestscore, win, lose, draw FROM user ORDER BY score DESC LIMIT 15;";
    $checkquery = mysqli_query($con,$leaderboardquery) or die(mysqli_error($con)); // Error code 2 = name check query failed

    if ($checkquery){
        while ($info = mysqli_fetch_assoc($checkquery)){
            echo("\t" . $info["username"] . "\t" . $info["score"] . "\t" . $info["highestscore"] . "\t" . $info["win"] . "\t" . $info["lose"] . "\t" . $info["draw"] . "\t\n");
        }
    }
?>