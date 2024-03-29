<?php
require("EasyDawa.php");

$sql = "SELECT prescription_id, drug_id, drug_dosage, PATIENT_ID, DOCTORS_ID FROM prescriptions";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Display Prescriptions</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .view-button {
            background-color: #4CAF50;
            color: white;
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php if ($result->num_rows > 0) : ?>
        <table>
            <tr>
                <th>Prescription ID</th>
                <th>Drug ID</th>
                <th>Drug Dosage</th>
                <th>Patient ID</th>
                <th>Doctor ID</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row["prescription_id"]; ?></td>
                    <td><?php echo $row["drug_id"]; ?></td>
                    <td><?php echo $row["drug_dosage"]; ?></td>
                    <td><?php echo $row["PATIENT_ID"]; ?></td>
                    <td><?php echo $row["DOCTORS_ID"]; ?></td>
                    <td>
                    </td>
                </tr>
            <?php endwhile; ?>

        </table>
    <?php else : ?>
        <p>No data found.</p>
    <?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
