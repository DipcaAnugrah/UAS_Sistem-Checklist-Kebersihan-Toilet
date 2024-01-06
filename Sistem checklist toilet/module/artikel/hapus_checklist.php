<?php
include_once '../../class/database.php'; // Include your database connection file
// Check if 'id' is set in the URL parameters
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Create a new Database object
    $db = new Database('host', 'username', 'password', 'db_name');

    // Use the database connection from the Database object
    $result = $db->query("DELETE FROM checklist WHERE id = '{$id}'");

    if (!$result) {
        // Handle errors if the query execution fails
        die('Error: ' . $db->getError());
    }

    // Close the database connection
    $db->closeConnection();

    // Redirect to index.php after successful deletion
    header('location: checklist-toilet.php');
} else {
    echo 'Invalid request. Please provide an ID.';
}
?>