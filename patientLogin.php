<?php
require("EasyDawa.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION["patient_id"])) {
    header("Location: patientDash.php");
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["PATIENT_ID"]) && isset($_POST["PASSWORDS"])) {
        $PATIENT_ID = $_POST["PATIENT_ID"];
        $PASSWORDS = $_POST["PASSWORDS"];

        // Prepare and execute the SQL query
        $stmt = $conn->prepare("SELECT PATIENT_ID FROM patients_info WHERE PATIENT_ID = ? AND PASSWORDS = ?");
        $stmt->bind_param("is", $PATIENT_ID, $PASSWORDS);

        $stmt->execute();

        // Bind the result
        $stmt->bind_result($patient_id);

        // Check if a matching record is found
        if ($stmt->fetch()) {
            // Successful login, set the patient ID in session
            $_SESSION["patient_id"] = $patient_id;

            // Redirect to the patient dashboard
            header("Location: patientDash.php");
            exit;
        } else {
            // Invalid credentials, show error message
            $error_message = "Invalid credentials. Please try again.";
        }

        // Close the statement
        $stmt->close();
    } else {
        $error_message = "Invalid request. Please provide both PATIENT_ID and PASSWORDS.";
    }
}

$conn->close();
?>
