<?php

require("EasyDawa.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["PHAR_ID"])) {
    header("Location: pharmacyLogin.html");
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $drug_id = $_POST["drug_id"];
    $price = $_POST["price"];
    $PHAR_ID = $_SESSION["PHAR_ID"];

    // Prepare and execute the SQL query
    $sql = "INSERT INTO drug_prices (drug_id, drug_price, PHAR_ID)
            VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idi", $drug_id, $price, $PHAR_ID);
    $stmt->execute();

    // Check if the query was successful
    if ($stmt->affected_rows > 0) {
        echo "Price set successfully!";
    } else {
        echo "Error setting price. Please try again.";
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Set Drug Prices</title>
</head>
<body>
    <h1>Set Drug Prices</h1>
    <form method="post" action="">
        <label for="drug_id">Drug ID:</label>
        <input type="number" name="drug_id" required><br>

        <label for="price">Price:</label>
        <input type="number" name="price" required><br>

        <input type="submit" value="Set Price">
    </form>
</body>
</html>
