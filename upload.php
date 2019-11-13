<?php

function ft_error()
{
	echo "<div id='error'>Sorry :(<br /><img src ='https://www.elegantthemes.com/blog/wp-content/uploads/2016/03/500-internal-server-error-featured-image-1.png'></div>";
}

function sanitizeString($var)
{
    $var = stripslashes($var);
    $var = strip_tags($var);
    $var = htmlentities($var);
    return $var;
}

function sanitizeMySQL($connection, $var){
    $var = $connection->real_escape_string($var);
    $var = sanitizeString($var);
    return $var;
}

function add_user($connection, $un, $pw, $em)
{
    $salt1 = "qm&h*";
    $salt2 = "pg!@";
    $token = hash('ripemd128', "$salt1$pw$salt2");
    $query = "INSERT INTO users VALUES('$un', '$token', '$em')";
    $result = $connection->query($query);
    if (!$result)
        ft_error();
}

function createToken($fileLoc, $salt1, $salt2)
{
    $myfile = fopen($fileLoc, "r") or ft_error();
    $virus = "";
    while (!feof($myfile))
    {
        $oneByte = fgetc($myfile);
        $token = hash('ripemd128', "$salt1$oneByte$salt2");
        $virus .= $token;
    }
    return $virus;
}

function addVirus($conn, $fileLoc, $filename, $salt1, $salt2)
{
    $virus = createToken($fileLoc, $salt1, $salt2);
    $query = "INSERT INTO viruses VALUES('$filename', '$virus')";
    $result = $connection->query($query);
    if (!$result)
        ft_error();
}
