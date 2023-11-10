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

    // Check if the username exists
    $namecheckquery = "SELECT userID FROM user WHERE username='" . $username . "';";
    $namecheck = mysqli_query($con,$namecheckquery) or die("2: Name check query failed"); // Error code 2 = name check query failed

    if (mysqli_num_rows($namecheck) == 1){
        $idcheckquery = "SELECT savedGameID FROM savedgames WHERE userID='" . $namecheck . "';";
        $idcheck = mysqli_query($con,$idcheckquery) or die("userID check query failed"); // Error code 2 = name check query failed

        $info = mysqli_fetch_assoc($idcheck);
        echo("0\t" . $info["savedGameID"]);
        //$updateuserquery = "INSERT INTO savedgames (FEN, gameMode, vsAI, difficultyAI) VALUES ('" . $fen . "', '" . $gamemode . "', '" . $vsai . "', '" . $difficultyai . "');";
        //mysqli_query($con,$updateuserquery) or die("Alter user query failed");
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