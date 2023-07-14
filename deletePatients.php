<?php
require("EasyDawa.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the unique identifier (PATIENT_ID) from the form submission
    $PATIENT_ID = $_POST["PATIENT_ID"];

    // Prepare and execute the SQL DELETE statement
    $sql = "DELETE FROM patients_info WHERE PATIENT_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $PATIENT_ID);

    if ($stmt->execute()) {
        echo "Patient record deleted successfully.";
    } else {
        echo "Error deleting patient record: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
