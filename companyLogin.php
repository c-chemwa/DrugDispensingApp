<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require("EasyDawa.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["COMPANY_ID"]) && isset($_POST["PASSWORDS"])) {
        $COMPANY_ID = $_POST["COMPANY_ID"];
        $PASSWORDS = $_POST["PASSWORDS"];

        // Prepare and execute the SQL query
        $stmt = $conn->prepare("SELECT COMPANY_ID, Company_Name FROM company_info WHERE COMPANY_ID = ? AND PASSWORDS = ?");
        $stmt->bind_param("is", $COMPANY_ID, $PASSWORDS);

        $stmt->execute();

        // Bind the result
        $stmt->bind_result($dbCompanyId, $Company_Name);

        // Check if a matching record is found
        if ($stmt->fetch()) {
            // Successful login, set session variables
            $_SESSION["COMPANY_ID"] = $dbCompanyId;
            $_SESSION["Company_Name"] = $Company_Name;

            // Redirect to the company dashboard page
            header("Location: companyDash.php");
            exit;
        } else {
            // Invalid credentials, deny access
            echo "Invalid credentials. Please try again.";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Invalid request. Please provide both COMPANY_ID and PASSWORDS.";
    }
} else {
    echo "Invalid request method. Only POST requests are allowed.";
}

$conn->close();
?>

