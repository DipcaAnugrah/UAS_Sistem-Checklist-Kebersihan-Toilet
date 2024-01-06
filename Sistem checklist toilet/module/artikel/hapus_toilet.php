<?php
include_once '../../class/database.php';

// Check if 'id' is set in the URL parameters
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Create a new Database object
    $db = new Database('host', 'username', 'password', 'db_name');

    // Before query
    echo 'ID toilet: ' . $id . PHP_EOL;

    // Check if there are related checklist records
    $checklistResult = $db->query("SELECT toilet_id FROM checklist");
    $checklistData = mysqli_fetch_assoc($checklistResult);
    // After query
    echo 'Jumlah checklist terkait: ' . $checklistData['count'] . PHP_EOL;

    // If there are related records, display an error message
    if (in_array($id, $checklistData)) {
        echo 'Data cannot be deleted. There are related records in the checklist table.';
    } else {
        // Begin a database transaction
        $db->beginTransaction();

        // Delete data from 'toilet' table
        $resultToilet = $db->query("DELETE FROM toilet WHERE id = '{$id}'");

        // Check if the query was successful
        if ($resultToilet) {
            // Commit the transaction if the query was successful
            $db->commit();
            echo 'Data deleted successfully.';
        } else {
            // Rollback the transaction if the query failed
            $db->rollBack();
            die('Error: ' . $db->getError());
        }
    }

    // Close the database connection
    $db->closeConnection();

    // Redirect to the appropriate page
    header('location: daftar-toilet.php');
} else {
    echo 'Invalid request. Please provide an ID.';
}
?>