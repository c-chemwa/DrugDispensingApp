<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require("EasyDawa.php");


if (!isset($_SESSION["PHAR_ID"])) {
    header("Location: pharmacyLogin.html");
    exit;
}

// Retrieve PHAR_ID from the session
$PHAR_ID = $_SESSION["PHAR_ID"];

// Fetch drug prices set by the current pharmacy
$sql = "SELECT dp.drug_id, dp.drug_price, di.drug_name
        FROM drug_prices dp
        INNER JOIN drug_info di ON dp.drug_id = di.drug_id
        WHERE dp.PHAR_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $PHAR_ID);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Prices</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <link rel="stylesheet" href="viewPatients.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Helvetica">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arial">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="LandingAssets/White Icon.png">
</head>
<body>
    <h1>View Prices</h1>
    <?php if ($result->num_rows > 0) : ?>
        <table>
            <tr>
                <th>Drug ID</th>
                <th>Drug Name</th>
                <th>Price</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row["drug_id"]; ?></td>
                    <td><?php echo $row["drug_name"]; ?></td>
                    <td><?php echo $row["drug_price"]; ?></td>
                </tr>
            <?php endwhile; ?>

        </table>
    <?php else : ?>
        <p>No prices set by this pharmacy.</p>
    <?php endif; ?>
    <p>&copy; 2023 EasyDawa. All rights reserved.</p>
</body>
</html>
