<?php

    $con = mysqli_connect('localhost','root','root','unityaccess');

    // Check if the connection occurred successfully
    if (mysqli_connect_errno()){
        echo "1: Connection Failed";  // Error code 1 = connection failed
        exit();
    }
    
    $username = $_POST["username"];
    $fullscreen = $_POST["fullscreen"]; 
    $mastervolume = $_POST["mastervolume"];
    $musicvolume = $_POST["musicvolume"];
    $sfxvolume = $_POST["sfxvolume"];

    // Check if the username exists
    $namecheckquery = "SELECT userID FROM user WHERE username='" . $username . "';";
    $namecheck = mysqli_query($con,$namecheckquery) or die(mysqli_error($con)); // Error code 2 = name check query failed

    if (mysqli_num_rows($namecheck) == 1){
        $row = mysqli_fetch_assoc($namecheck);
        $userid = $row["userID"];
        $updatequery = "UPDATE preference SET fullscreen = '" . $fullscreen . "', masterVolume = '" . $mastervolume . "',musicVolume = '" . $musicvolume . "',sfxVolume = '" . $sfxvolume . "'WHERE userID = '" . $userid . "';";
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