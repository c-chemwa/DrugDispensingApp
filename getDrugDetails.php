<?php
// Include the database connection code (EasyDawa.php)
require("EasyDawa.php");

if (isset($_GET["drug_id"])) {
    $drugId = $_GET["drug_id"];

    // Query to retrieve drug details by drug_id
    $query = "SELECT * FROM drug_info WHERE drug_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $drugId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Return drug details as JSON
        echo json_encode($row);
    } else {
        // Drug not found
        echo json_encode(array("error" => "Drug not found"));
    }
} else {
    // Invalid request
    echo json_encode(array("error" => "Invalid request"));
}
?>
