<?php

require_once 'login.php';
require_once 'upload.php';

echo "<html><head><title>Authorization page</title></head><body>";

function auth($connection, $sal1, $salt2)
{
    if (isset($_POST['login']))
    {
        if (isset($_POST['username']) && isset($_POST['password']))
        {
            $un_temp = sanitizeMySQL($connection, $_POST['username']);
            $pw_temp = sanitizeMySQL($connection, $_POST['password']);
            $query = "SELECT * FROM users WHERE username='$un_temp'";
            $result = $connection->query($query);
            if (!$result)
                ft_error();
            elseif ($result->num_rows)
            {
                $row = $result->fetch_array(MYSQLI_NUM);
                $result->close();
                $token = hash('ripemd128', "$salt1$pw_temp$salt2");
                if ($token == $row[1] && $un_temp == 'admin')
                {
                    echo "Hi, Admin!<br>";
                    echo "<form action='admin.php'><input type='submit' value='Admin Page' name='upload' class='btn btn-warning'></form>";
                }
                elseif ($token == $row[1])
                {
                    echo "Hi, contributor $row[0]";
                    echo "<form action='addSearch.php' enctype='multipart/form-data'>Upload your file: <input type='file' name='file'><input type='submit' value='Upload New Virus' name='upload'><br></form>";
                }
                else die("Invalid username/password combination");
            }
            else die("Invalid username/password combination");
        }
        else
            ft_error();
    }
    else 
    {
        setheader('WWW-Authenticate: Basic realm="Restricted Section"');
        header('HTTP/1.0 401 Unauthorized');
        die ("Please enter your username and password");
    }
}

if (isset($_POST['login']))
    auth($conn, $sal1, $salt2);
elseif (isset($_POST['signup']))
{
    $un = sanitizeMySQL($con, $_POST['username']);
    $pw = sanitizeMySQL($con, $_POST['password']);
    $em = sanitizeMySQL($con, $_POST['email']);
    add_user($connection, $un, $pw, $em);
    auth($conn, $sal1, $salt2);
}
elseif (isset($_POST['upload']))
{
    $filename = sanitizeMySQL($conn, $_FILES['file']['name']);
    $fileLoc = $_FILES['file']['tmp_loc'];
    if(isset($_FILES['file']))
        addVirus($conn, $fileLoc, $filename, $salt1, $salt2);
    else
        ft_error();
}
echo "</body></html>";
