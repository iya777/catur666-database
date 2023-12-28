<?php

    $con = mysqli_connect('localhost','root','root','unityaccess');

    // Check if the connection occurred successfully
    if (mysqli_connect_errno()){
        echo "1: Connection Failed";  // Error code 1 = connection failed
        exit();
    }
    
    $username = $_POST["username"];
    $oldpassword = $_POST["oldpassword"];
    $newpassword = $_POST["newpassword"];

    // Check if the username exists
    $namecheckquery = "SELECT username, salt, hash, score FROM user WHERE username='" . $username . "';";
    $namecheck = mysqli_query($con,$namecheckquery) or die("2"); // Error code 2 = name check query failed

    if (mysqli_num_rows($namecheck) != 1){
        echo "5";  // error coode 5 - num of names matching != 1 : Either no user with name, or more than one
        exit();
    }
    
    // get login info from query
    $existinginfo = mysqli_fetch_assoc($namecheck);
    $salt = $existinginfo["salt"];
    $hash = $existinginfo["hash"];

    $loginhash = crypt($oldpassword, $salt);
    $newhash = crypt($newpassword, $salt);
    if ($hash != $loginhash){
        echo "1"; // error code #6 password does not hash to match table
        exit();
    }
    else{
        $updatequery = "UPDATE user SET hash='" . $newhash . "' WHERE username='". $username ."';";
        $update = mysqli_query($con,$updatequery) or die("Update query failed");
        echo "0";
    }
?>