<?php

echo<<<_END
    <html>
        <head>
            <link href="https://fonts.googleapis.com/css?family=Yeon+Sung&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <title>Form Upload</title>
            <style>
                table, th, td {
                    border: 1px solid black;
                }
                body {
                    font-size: 130%;
                    font-family: 'Yeon Sung', cursive;
                    text-align: center;
                }
                form {
                    display: inline-block;
                }
            </style>    
        </head>
        <body>
            <form action='index.php' method='post'> 
                <input type='submit' value='Log in or Sign Up' name='loginOrSignup' class='btn btn-primary'>
            </form>
            <form action='index.php' method='post' enctype='multipart/form-data'> 
                Input File To Scan:<input type='file' name='virusToScan'><input type='submit' value='Scan File' name='scan' class='btn btn-danger'>
            </form>

_END;

function loginOrSignup()
{
    echo<<<_LOGIN
    <form action='addSearch.php' method='post'>
                Username: <input type='text' name='username'><br>
                Email: <input type='text' name='email'><br>
                Password: <input type='text' name='password'><br>
                <input type='submit' value='Log in' name='login' class='btn btn-success'>
                <input type='submit' value='Sign Up' name='signup' class='btn btn-success'>
            </form><br>
_LOGIN;
}

if (isset($_POST['loginOrSignup']))
    loginOrSignup();
elseif(isset($_POST['scan']))
{
    $virus = createToken($conn, $FILES['virusToScan']['tmp_loc'], $salt1, $salt2);
    $search = "SELECT * FROM viruses WHERE content='$virus'";
    $res = $conn->query($search);
    if ($res->num_rows > 0)
    {
        echo "<table><tr><th>Filenames of viruses</th><th>Encrypted virus</th></tr>";

        while ($row = $res->fetch_assoc())
        {
            echo "<tr><td>" .$row["filename"] . "</td><td>" .$row["content"] . "</td></tr>";
        }
        echo "</table>";
    }
    else
        ft_error();
}