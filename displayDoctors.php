<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="display.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Helvetica">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arial">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Data</title>
</head>
</html>
<?php
require("EasyDawa.php");

$sql = "SELECT DOCTORS_ID, FIRST_NAME, LAST_NAME, SPECIALITY, YRS_OF_EXPERIENCE, EMAIL_ADDRESS FROM doctors_info"; 
$result = $conn->query($sql);
?>

<?php if ($result->num_rows > 0) : ?>
    <table border="1">
        <tr>
            <th>DOCTORS_ID_ID</th>
            <th>FIRST_NAME</th>
            <th>LAST_NAME</th>
            <th>GENDER</th>
            <th>YRS_OF_EXPERIENCE</th>
            <th>EMAIL_ADDRESS</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row["DOCTORS_ID"]; ?></td>
                <td><?php echo $row["FIRST_NAME"]; ?></td>
                <td><?php echo $row["LAST_NAME"]; ?></td>
                <td><?php echo $row["SPECIALITY"]; ?></td>
                <td><?php echo $row["YRS_OF_EXPERIENCE"]; ?></td>
                <td><?php echo $row["EMAIL_ADDRESS"]; ?></td>
                <td>
                    <form method="post" action="editDoctors.php">
                        <input type="hidden" name="DOCTORS_ID" value="<?php echo $row["DOCTORS_ID"]; ?>">
                        <input type="submit" value="Edit">
                    </form>
                    <form method="post" action="deleteDoctors.php">
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
<?php
$conn->close();
?>
