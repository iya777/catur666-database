<?php

    $con = mysqli_connect('localhost','root','root','unityaccess');

    // Check if the connection occurred successfully
    if (mysqli_connect_errno()){
        echo "1: Connection Failed";  // Error code 1 = connection failed
        exit();
    }
    
    $username = $_POST["name"];
    $password = $_POST["password"];

    // Check if the username exists
    $namecheckquery = "SELECT username, salt, hash, score FROM user WHERE username='" . $username . "';";
    $namecheck = mysqli_query($con,$namecheckquery) or die("2: Name check query failed"); // Error code 2 = name check query failed

    if (mysqli_num_rows($namecheck) != 1){
        echo "5: Either no user with name, or more than one";  // error coode 5 - num of names matching != 1
        exit();
    }
    
    // get login info from query
    $existinginfo = mysqli_fetch_assoc($namecheck);
    $salt = $existinginfo["salt"];
    $hash = $existinginfo["hash"];

    $loginhash = crypt($password, $salt);
    if ($hash != $loginhash){
        echo "6: Incorrect password"; // error code #6 password does not hash to match table
        exit();
    }
    
    echo "0\t" . $existinginfo["score"]; // . adalah join dua string --> "0  100" 100 adalah skor
?>