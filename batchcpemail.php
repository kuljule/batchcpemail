#!/usr/bin/php
<?php

/* Input values for mysql server, username, password, and database. */
$server = "";
$username = "";
$password = "";
$database = "";

/* Connect to mysql server */
$mysqli = new mysqli("$server", "$username", "$password", "$database");

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

/* Qury the variables from the table user_email */
$query = "SELECT UserName, Value, email FROM user_email";


/* Headers */
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Julian <julianrseidel@gmail.com>' . "\r\n".
'Reply-To: julianrseidel@trinityclassicalacademy.com' . "\r\n".
'X-Mailer: PHP/' . phpversion();

/* Subject */
$subject = 'Captive Portal Login Directions';

/* Beginning of Message before username and password */
$message = 'The following does not affect the South Campus wifi. This is only for the wifi in the main building and north building. It also will not affect the Trinity student computers.<br><br>In order to make our network more secure, we are implementing a captive portal so that anyone who wants to be on our network needs to have a username and password in order to get online. It is similar to what happens when you try to connect to the wifi at a hotel.<br><br><b>On Monday, you will have to follow these instructions in order to get online.</b><br><br><b>You only need to enter this password once per device, and your device will remember the password for future sessions.</b><br><br>When you connect to the wifi you will most probably get a pop up asking for your username and password. If that is the case you can skip step 1.<br><br>

These are the steps to get past the captive portal page:<br>
1. Go to http://www.trinityclassicalacademy.com. You will see a page asking for your username and password.
<br>Below you will find your username and password:<br>';

/* Get result of query and if there is a result then while there is a result print the username and password. Email the message + the username and passwords */
$result = $mysqli->query($query);
if($result && $result->num_rows>=1) {
$count = 0; 
	while ($row = $result->fetch_assoc()) {
		$add = sprintf("<b>Username: %s<br>Password: %s</b><br><br><b>MAKE SURE TO SAVE THIS SOMEWHERE. YOU WILL NOT BE ABLE TO GET TO THIS EMAIL ON MONDAY.</b><br><br>2. Input the username and password above, and then push continue.<br>3. Enjoy.<br><br>If you have any problems, feel free to contact the IT Deparment or if you are able to on your phone, email julianrseidel@gmail.com.<br><br>Grace, <br>Julian<br><br><b>***Please keep your username and password private. If you don't, we will find out.***</b>", $row["UserName"], $row["Value"]);
		$email = $row["email"];
		$msg = $message .$add;
		mail($email, $subject, $msg, $headers);
		$count++;
	}
	/* echo how many emails have been sent */
echo "myResult=$count Emails Sent. Done";
    /* free result set */
    $result->free();
}
/* If no result, then echo email submissions failed */
else {
echo "myResult=Email Submissions Failed";
}
/* close connection */
$mysqli->close();
?>
