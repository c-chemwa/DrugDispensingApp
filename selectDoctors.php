<?php
require("EasyDawa.php");

if (!isset($_SESSION["patient_id"])) 
{
    header("Location: patientLogin.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["selectedDoctors"])) {
        $selectedDoctors = $_POST["selectedDoctors"];
        $loggedInPatientID = $_SESSION["patient_id"];

        // Store the selected doctors in the database
        foreach ($selectedDoctors as $doctorID) {
            $stmt = $conn->prepare("INSERT INTO selected_doctor (PATIENT_ID, DOCTORS_ID) VALUES (?, ?)");
            $stmt->bind_param("ii", $loggedInPatientID, $doctorID);
            if (!$stmt->execute()) {
                // Handle the error
                echo "Error selecting doctors. Please try again.";
                exit;
            }
            $stmt->close();
        }
        header("Location: patientDash.php");
        exit;
    } else {
        echo "Please select at least one doctor.";
    }
}

$conn->close();
?>
