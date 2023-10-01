<?php
require("EasyDawa.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $doctors_id = $_POST["DOCTORS_ID"];
    $first_name = $_POST["FIRST_NAME"];
    $last_name = $_POST["LAST_NAME"];
    $speciality = $_POST["SPECIALITY"];
    $yrs_of_experience = $_POST["YRS_OF_EXPERIENCE"];
    $email = $_POST["EMAIL_ADDRESS"];
    $password = $_POST["PASSWORDS"];

    // Prepare and execute the SQL query
    $sql = "INSERT INTO doctors_info (DOCTORS_ID, FIRST_NAME, LAST_NAME, SPECIALITY, YRS_OF_EXPERIENCE, EMAIL_ADDRESS, PASSWORDS)
            VALUES ('$doctors_id', '$first_name', '$last_name', '$speciality', '$yrs_of_experience', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "New doctor added successfully!";
    } else {
        if ($conn->errno === 1062) {
            echo "Error: Doctor with ID $doctors_id already exists.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Doctor</title>
    <style>
        * {
            font-family: "Roboto", "Arial", "Helvetica", sans-serif;
            color: black;
        }

        .form {
            text-align: center;
            margin-top: 30px;
        }

        .form hr {
            background-color: rgb(82, 220, 199);
            height: 3px;
            border: none;
            margin: 10px auto;
        }

        .home a {
            text-decoration: none;
            color: black;
        }

        .home img {
            display: block;
            margin: 0 auto;
            width: 40%;
        }

        .form h1 {
            font-size: 24px;
            font-weight: bold;
        }

        .form form {
            margin: 0 auto;
            width: 60%;
        }

        .form .content {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .form .labels,
        .form .inputs {
            flex: 1;
        }

        .form .labels label,
        .form .inputs input {
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .form .inputs input {
            width: 100%;
            padding: 10px;
            border: 2px solid rgb(82, 220, 199);
            border-radius: 4px;
        }

        .form input[type="submit"] {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            background-color: rgb(82, 220, 199);
            color: black;
            border-radius: 4px;
            border: 2px solid black;
            cursor: pointer;
            text-decoration: none;
        }

        .form input[type="submit"]:hover {
            background-color: white;
            transition: 10ms;
        }

        .form p {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Embed the HTML form within the PHP script -->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <!-- Add your form fields here -->
        <label for="DOCTORS_ID">Doctor ID:</label>
        <input type="text" name="DOCTORS_ID" required><br>

        <label for="FIRST_NAME">First Name:</label>
        <input type="text" name="FIRST_NAME" required><br>

        <label for="LAST_NAME">Last Name:</label>
        <input type="text" name="LAST_NAME" required><br>

        <label for="SPECIALITY">Speciality:</label>
        <input type="text" name="SPECIALITY" required><br>

        <label for="YRS_OF_EXPERIENCE">Years of Experience:</label>
        <input type="text" name="YRS_OF_EXPERIENCE" required><br>

        <label for="EMAIL_ADDRESS">Email Address:</label>
        <input type="email" name="EMAIL_ADDRESS" required><br>

        <label for="PASSWORDS">Password:</label>
        <input type="password" name="PASSWORDS" required><br>

        <input type="submit" value="Add Doctor">
    </form>
</body>
</html>

