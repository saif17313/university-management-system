<?php
// src/db.php
// Update these values if your XAMPP uses different credentials
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';        // default XAMPP root has no password
$DB_NAME = 'university_db';

// Create connection
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
// Check connection
if ($mysqli->connect_errno) {
    // In production hide details; for dev this helps debugging
    die("Database connection failed: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}
// set charset
$mysqli->set_charset("utf8mb4");
