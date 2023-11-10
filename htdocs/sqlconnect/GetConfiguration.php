<?php

    $con = mysqli_connect('localhost','root','root','unityaccess');

    // Check if the connection occurred successfully
    if (mysqli_connect_errno()){
        echo "1: Connection Failed";  // Error code 1 = connection failed
        exit();
    }
    
    $username = $_POST["username"];

    // Check if the username exists
    $namecheckquery = "SELECT userID FROM user WHERE username='" . $username . "';";
    $namecheck = mysqli_query($con,$namecheckquery) or die(mysqli_error($con)); // Error code 2 = name check query failed

    if (mysqli_num_rows($namecheck) == 1){
        $row = mysqli_fetch_assoc($namecheck);
        $userid = $row["userID"];
        $selectquery = "SELECT fullscreen, masterVolume, musicVolume, sfxVolume FROM preference WHERE userID = '" . $userid . "';";
        $info = mysqli_query($con,$selectquery) or die(mysqli_error($con));
        echo("0\t" . $info["fullscreen"] . "\t" . $info["masterVolume"] . "\t" . $info["musicVolume"] . "\t" . $info["sfxVolume"] . "\n");
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