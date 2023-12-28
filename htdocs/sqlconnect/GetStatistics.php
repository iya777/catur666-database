<?php

    $con = mysqli_connect('localhost','root','root','unityaccess');

    // Check if the connection occurred successfully
    if (mysqli_connect_errno()){
        echo "1: Connection Failed";  // Error code 1 = connection failed
        exit();
    }
    
    $username = $_POST["username"];

    // Check if the username exists
    $namecheckquery = "SELECT score, highestScore, win, lose, draw FROM user WHERE username='" . $username . "';";
    $namecheck = mysqli_query($con,$namecheckquery) or die("2: Name check query failed"); // Error code 2 = name check query failed

    if (mysqli_num_rows($namecheck) != 1){
        echo "5: Either no user with name, or more than one";  // error coode 5 - num of names matching != 1
        exit();
    }
    
    // get login info from query
    $existinginfo = mysqli_fetch_assoc($namecheck);
    $score = $existinginfo["score"];
    $highestScore = $existinginfo["highestScore"];
    $win = $existinginfo["win"];
    $lose = $existinginfo["lose"];
    $draw = $existinginfo["draw"];
    
    echo("" . $score . "\n" . $highestScore . "\n" . $win . "\n" . $lose . "\n" . $draw . ""); // . adalah join dua string --> "0  100" 100 adalah skor
?>