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
    $namecheckquery = "SELECT username FROM user WHERE username='" . $username . "';";
    $namecheck = mysqli_query($con,$namecheckquery) or die("2: Name check query failed"); // Error code 2 = name check query failed

    if (mysqli_num_rows($namecheck) > 0){
        echo "3: Name already exists";  // Username is already taken
        exit();
    }
    
    // Add user to the table
    $salt = "\$5\$rounds=5000\$" . "gabrielsukapokemon" . $username . "\$";
    $hash = crypt($password, $salt);
    $insertuserquery = "INSERT INTO user (username, hash, salt) VALUES ('" . $username . "', '" . $hash . "', '" . $salt . "');";
    mysqli_query($con,$insertuserquery) or die("4: Insert user query failed"); // Error code 4 = insert query failed

    echo("0");

?>