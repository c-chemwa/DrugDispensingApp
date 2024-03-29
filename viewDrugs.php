<?php
require("EasyDawa.php");

if (!isset($_SESSION["DOCTORS_ID"])) {
    header("Location: doctorLogin.html");
    exit;
}

// Fetch the drugs information from the database
$sql = "SELECT drug_id, drug_name, drug_type, drug_form FROM drug_info";
$result = $conn->query($sql);

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the drug_id is selected
    if (isset($_POST["drug_id"])) {
        // Get the selected drug_id
        $drug_id = $_POST["drug_id"];
        
        // Redirect to the insertPrescription.php with the selected drug_id
        header("Location: insertPrescription.php?drug_id=" . urlencode($drug_id));
        exit;
    } else {
        // If the drug_id is not selected, show an error message
        $error_message = "Incomplete form data. Please fill in all the required fields.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Select Drug</title>
    <link rel="stylesheet" href="viewdrugs.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Helvetica">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arial">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="LandingAssets/White Icon.png">
</head>

<body>
    <h1>Select Drug</h1>
    <hr>
    <form method="post" action="insertPrescription.php">
        <div class="table">
            <table border="2">
                <tr>
                    <th>Select</th>
                    <th>Drug ID</th>
                    <th>Drug Name</th>
                    <th>Drug Type</th>
                    <th>Drug Form</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td>
                            <input type="radio" name="drug_id" value="<?php echo $row["drug_id"]; ?>" required>
                        </td>
                        <td><?php echo $row["drug_id"]; ?></td>
                        <td><?php echo $row["drug_name"]; ?></td>
                        <td><?php echo $row["drug_type"]; ?></td>
                        <td><?php echo $row["drug_form"]; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
        <br>
        <center><input type="submit" value="Select Drug"></center>
    </form>
    <?php if (isset($error_message)) : ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>
    <p>&copy; 2023 EasyDawa. All rights reserved.</p>
</body>

</html>



