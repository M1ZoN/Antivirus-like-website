<?php

require_once 'upload.php';

$hn = 'localhost';
$un = 'root';
$pw = 'toor';
$db = 'malware';

$conn = new mysqli($hn, $un,$pw, $db);
if ($conn->connection_error)
    ft_error();
$usersTable = "CREATE TABLE users (username VARCHAR(32) NOT NULL UNIQUE, password VARCHAR(32) NOT NULL, email VARCHAR(32) NOT NULL UNIQUE)";
$resultUsers = $connection->query($usersTable);
if (!$resultUsers) 
    ft_error();

add_user($conn, $un, $pw, "admin@localhost.com");
$virusesTable = "CREATE TABLE viruses (filename VARCHAR(32) NOT NULL, content VARCHAR(32) NOT NULL UNIQUE)";
$resultViruses = $connection->query($virusesTable);
if (!$resultViruses) 
    ft_error(); 