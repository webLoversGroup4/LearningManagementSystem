<?php

// Declaring 4 constant variables to store the database connection parameters
$SERVER = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DB_NAME = 'learnfy_database';

// Establishing connection to the database
$conn = new mysqli($SERVER, $USERNAME, $PASSWORD, $DB_NAME) or die("Could not establish connection to database");

// Checking if connection worked
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

