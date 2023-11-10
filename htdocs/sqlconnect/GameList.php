<?php

    $con = mysqli_connect('localhost','root','root','unityaccess');

    // Check if the connection occurred successfully
    if (mysqli_connect_errno()){
        echo "1: Connection Failed";  // Error code 1 = connection failed
        exit();
    }
    
    $username = $_POST["username"];

    $offset = $_POST["current_index"]; // Set your current index as the offset
    $limit = 16; // Set the number of rows you want to retrieve

    // Check if the username exists
    $namecheckquery = "SELECT userID FROM user WHERE username='" . $username . "';";
    $namecheck = mysqli_query($con,$namecheckquery) or die(mysqli_error($con)); // Error code 2 = name check query failed

    if (mysqli_num_rows($namecheck) == 1){
        $infonamecheck = mysqli_fetch_assoc($namecheck);

        $idcheckquery = "SELECT savedGameID, FEN, gameMode, vsAI, difficultyAI, isWhite, lastModified FROM savedgames WHERE userID='" . $infonamecheck['userID'] . "' LIMIT " . $offset . ", " . $limit . ";";
        $idcheck = mysqli_query($con,$idcheckquery) or die(mysqli_error($con)); // Error code 2 = name check query failed

        if ($idcheck){
            $numRows = mysqli_num_rows($idcheck);
            while ($info = mysqli_fetch_assoc($idcheck)){
                echo("0\t" . $info["savedGameID"] . "\t" . $info["FEN"] . "\t" . $info["gameMode"] . "\t" . $info["vsAI"] . "\t" . $info["difficultyAI"] . "\t" . $info["isWhite"] . "\t" . $info["lastModified"] . "\t" . $numRows . "\n");
            }
        }
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
?>