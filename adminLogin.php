<?php
session_start(); // Start a new session

require("EasyDawa.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["ADMIN_ID"]) && isset($_POST["PASSWORDS"])) {
        $ADMIN_ID = $_POST["ADMIN_ID"];
        $PASSWORDS = $_POST["PASSWORDS"];

        $stmt = $conn->prepare("SELECT Admin_Name FROM admin_details WHERE ADMIN_ID = ? AND PASSWORDS = ?");
        $stmt->bind_param("is", $ADMIN_ID, $PASSWORDS);

        $stmt->execute();

        // Bind the result
        $stmt->bind_result($Admin_Name);

        // Check if a matching record is found
        if ($stmt->fetch()) {
            // Successful login, grant access
            // Redirect to the dashboard
            $_SESSION["ADMIN_ID"] = $ADMIN_ID; // Set the ADMIN_ID session variable
            header("Location: adminDash.php");
            exit;
        } else {
            // Handle failed login
            // You can display an error message here
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Invalid request. Please provide both ADMIN_ID and PASSWORDS.";
    }
} else {
    echo "Invalid request method. Only POST requests are allowed.";
}

$conn->close();
?>
