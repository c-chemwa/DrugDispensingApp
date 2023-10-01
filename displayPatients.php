<?php
require("EasyDawa.php");

// Fetch data from the database and format as HTML table
$sql = "SELECT * FROM patients_info"; // Replace with your query
$result = mysqli_query($conn, $sql);

echo '<table>';
echo '<thead><tr><th>PATIENT_ID</th><th>FIRST_NAME</th><th>LAST_NAME</th><th>GENDER</th><th>AGE</th><th>EMAIL_ADDRESS</th></tr></thead>';
echo '<tbody>';
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $row['PATIENT_ID'] . '</td>';
    echo '<td>' . $row['FIRST_NAME'] . '</td>';
    echo '<td>' . $row['LAST_NAME'] . '</td>';
    echo '<td>' . $row['GENDER'] . '</td>';
    echo '<td>' . $row['AGE'] . '</td>';
    echo '<td>' . $row['EMAIL_ADDRESS'] . '</td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';

mysqli_close($conn);
?>

