<?php

    $con = mysqli_connect('localhost','root','root','unityaccess');

    // Check if the connection occurred successfully
    if (mysqli_connect_errno()){
        echo "1: Connection Failed";  // Error code 1 = connection failed
        exit();
    }
    
    $username = $_POST["username"];
    $fen = $_POST["fen"]; 
    $gamemode = $_POST["gamemode"];
    $vsai = $_POST["vsai"];
    $difficultyai = $_POST["difficultyai"];
    $iswhite = $_POST["iswhite"];

    // Check if the username exists
    $namecheckquery = "SELECT userID FROM user WHERE username='" . $username . "';";
    $namecheck = mysqli_query($con,$namecheckquery) or die(mysqli_error($con)); // Error code 2 = name check query failed

    if (mysqli_num_rows($namecheck) == 1){
        $row = mysqli_fetch_assoc($namecheck);
        $userid = $row["userID"];
        $insertsavedgamequery = "INSERT INTO savedgames (userID, FEN, gameMode, vsAI, difficultyAI, isWhite) VALUES ('" . $userid . "', '" . $fen . "', '" . $gamemode . "', '" . $vsai . "', '" . $difficultyai . "', '" . $iswhite . "');";
        mysqli_query($con,$insertsavedgamequery) or die(mysqli_error($con));
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