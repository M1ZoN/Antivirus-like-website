<?php
require_once 'login.php';
require_once 'upload.php';

echo <<<_END
    <html>
        <head>
            <title>adding a Virus</title>
        </head>
        <body>
            <form action='admin.php' enctype='multipart/form-data'>
                <input type='submit' value='Review viruses' name='review'><br>
                Upload your file: <input type='file' name='file'><input type='submit' value='Upload New Virus' name='upload'><br>
                Filename: <input type='text' name='delete'><input type='submit' value='Delete Virus' name='deletebtn'>
            </form><br>
_END;

if (isset($_POST['upload']))
{
    $filename = sanitizeMySQL($conn, $_FILES['file']['name']);
    $fileLoc = $_FILES['file']['tmp_loc'];
    if(isset($_FILES['file']))
        addVirus($conn, $fileLoc, $filename, $salt1, $salt2);
    else
        ft_error();
}
elseif (isset($_POST['review']))
{
    $search = "SELECT * FROM viruses";
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
elseif (isset($_POST['deletebtn']))
{
    $filename = sanitizeMySQL($conn, $_POST['delete']);
    $search = "DELETE * FROM viruses WHERE filename='$filename'";
    $res = $conn->query($search);
    if (!$res)
        ft_error();
}
echo "</body></html>";