<?php
require("EasyDawa.php");

// Check if the session is not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["patient_id"])) {
    header("Location: patientLogin.html");
    exit;
}

$loggedInPatientID = $_SESSION["patient_id"];

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["selectedDoctors"])) {
    // Process the form data here (save selected doctors, etc.)

    // JavaScript code to display an alert after 1.5 seconds
    echo '<script>';
    echo 'setTimeout(function(){ alert("You have selected your doctor(s) successfully."); }, 1500);';
    echo '</script>';
}

$sql = "SELECT DOCTORS_ID, FIRST_NAME, LAST_NAME, SPECIALITY, YRS_OF_EXPERIENCE, EMAIL_ADDRESS FROM doctors_info";
$result = $conn->query($sql);

$doctorTable = "";
if ($result->num_rows > 0) {
    $doctorTable .= "<form method='post' action='selectDoctors.php'>";
    $doctorTable .= "<table border='1'>";
    $doctorTable .= "<tr>
                        <th>Select</th>
                        <th>DOCTORS_ID</th>
                        <th>FIRST_NAME</th>
                        <th>LAST_NAME</th>
                        <th>SPECIALITY</th>
                        <th>YRS_OF_EXPERIENCE</th>
                        <th>EMAIL_ADDRESS</th>
                    </tr>";

    while ($row = $result->fetch_assoc()) {
        $doctorTable .= "<tr>
                            <td>
                                <input type='checkbox' name='selectedDoctors[]' value='" . $row["DOCTORS_ID"] . "'>
                            </td>
                            <td>" . $row["DOCTORS_ID"] . "</td>
                            <td>" . $row["FIRST_NAME"] . "</td>
                            <td>" . $row["LAST_NAME"] . "</td>
                            <td>" . $row["SPECIALITY"] . "</td>
                            <td>" . $row["YRS_OF_EXPERIENCE"] . "</td>
                            <td>" . $row["EMAIL_ADDRESS"] . "</td>
                        </tr>";
    }

    $doctorTable .= "</table>";
    $doctorTable .= "<input type='submit' value='Select'>";
    $doctorTable .= "</form>";
} else {
    $doctorTable = "No doctors found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Pick Doctor</title>
    <!-- Include the tables.css file using PHP -->
    <?php echo '<link rel="stylesheet" type="text/css" href="tables.css">'; ?>
</head>

<body>
    <div class="container">
        <h1>Select Doctors</h1>

        <div class="doctors-table">
            <?php echo $doctorTable; ?>
        </div>

    </div>
</body>

</html>
