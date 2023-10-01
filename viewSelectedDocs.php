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

$sql = "SELECT s.PATIENT_ID, s.DOCTORS_ID, d.* 
        FROM selected_doctor s
        INNER JOIN doctors_info d ON s.DOCTORS_ID = d.DOCTORS_ID
        WHERE s.PATIENT_ID = $loggedInPatientID";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Your Page Title</title>
    <!-- Include the tables.css file using PHP -->
    <?php echo '<link rel="stylesheet" type="text/css" href="tables.css">'; ?>
</head>

<body>
    <?php if ($result->num_rows > 0) : ?>
        <table border="1">
            <tr>
                <th>Doctor Name</th>
                <th>Doctor Specialization</th>
                <th>Doctor Address</th>
                <th>Actions</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row["FIRST_NAME"] . ' ' . $row["LAST_NAME"]; ?></td>
                    <td><?php echo $row["SPECIALITY"]; ?></td>
                    <td><?php echo $row["EMAIL_ADDRESS"]; ?></td>
                    <td>
                        <form method="post" action="deleteSelectedDoctor.php">
                            <input type="hidden" name="PATIENT_ID" value="<?php echo $loggedInPatientID; ?>">
                            <input type="hidden" name="DOCTORS_ID" value="<?php echo $row["DOCTORS_ID"]; ?>">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>

        </table>
    <?php else : ?>
        <p>No data found.</p>
    <?php endif; ?>
    <p>&copy; 2023 EasyDawa. All rights reserved.</p>
</body>

</html>

<?php
$conn->close();
?>


