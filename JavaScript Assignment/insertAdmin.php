<?php
require("EasyDawa.php");

if ($loginSuccessful || $signupSuccessful) {
    header("Location: adminDash.html");
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $admin_id = $_POST["ADMIN_ID"];
    $admin_name = $_POST["ADMIN_NAME"];
    $password = $_POST["PASSWORDS"];
    $sql = "INSERT INTO admin_details (ADMIN_ID, ADMIN_NAME, PASSWORDS)
    VALUES ('$admin_id','$admin_name','$password')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New admin added successfully!";
        // Redirect to the admin dashboard
        header("Location: adminDash.html");
        exit;
    } else {
        if ($conn->errno === 1062) {
            echo "Error: Admin with ID $admin_id already exists.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
}
?>

