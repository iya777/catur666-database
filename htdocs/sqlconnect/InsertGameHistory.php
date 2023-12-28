<?php

    $con = mysqli_connect('localhost','root','root','unityaccess');

    // Check if the connection occurred successfully
    if (mysqli_connect_errno()){
        echo "1: Connection Failed";  // Error code 1 = connection failed
        exit();
    }
    
    // Untuk save loaded game
    $overrideGame = $_POST["overridegame"];
    $savedgameid = $_POST["savedgameid"];

    $username = $_POST["username"];
    $gameresult = $_POST["gameresult"]; 
    $gamemode = $_POST["gamemode"];
    $vsai = $_POST["vsai"];
    $difficultyai = $_POST["difficultyai"];
    $scoregained = $_POST["scoregained"];
    $fen = $_POST["fen"]; // FEN terakhir yg didapatkan
    $iswhite = $_POST["iswhite"];
    $win = $_POST["win"];
    $lose = $_POST["lose"];
    $draw = $_POST["draw"];

    // Check if the username exists
    $namecheckquery = "SELECT userID FROM user WHERE username='" . $username . "';";
    $namecheck = mysqli_query($con,$namecheckquery) or die("2: Name check query failed"); // Error code 2 = name check query failed

    if (mysqli_num_rows($namecheck) == 1){
        $row = mysqli_fetch_assoc($namecheck);
        $userid = $row["userID"];
        if ($overrideGame == "TRUE"){
            $deletequery = "DELETE FROM savedgames WHERE userID = $userid AND savedGameID = $savedgameid;";
            mysqli_query($con,$deletequery) or die(mysqli_error($con));
        }
        $insertquery = "INSERT INTO gamehistory (userID, gameResult, gameMode, vsAI, difficultyAI, scoreGained, FEN, isWhite) VALUES ('" . $userid . "', '" . $gameresult . "', '" . $gamemode . "', '" . $vsai . "', '" . $difficultyai . "', '" . $scoregained . "', '" . $fen . "', '" . $iswhite . "');";
        mysqli_query($con,$insertquery) or die(mysqli_error($con));

        $_newcurrentscore = $_POST["_newcurrentscore"];
        $updatequery = "UPDATE user SET score = $_newcurrentscore, win = $win, lose = $lose, draw = $draw WHERE userID = $userid;";
        mysqli_query($con,$updatequery) or die(mysqli_error($con));
    }
    elseif (mysqli_num_rows($namecheck) > 1){
        echo "Error, duplicate userID!!!";
        exit();
    }
    else{
        echo "Error, userID doesn't exist with that username";
        exit();
    }
    echo("0");
?>