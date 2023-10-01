<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION["COMPANY_ID"]) || !isset($_SESSION["Company_Name"])) {
    header("Location: login.html");
    exit;
}

require("EasyDawa.php");

// Handle logout
if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("Location: login.html");
    exit;
}

// Handle adding drugs
if (isset($_POST["add_drug"])) {
    // Process the form data and insert the drug into the database
    // Make sure to validate and sanitize user inputs before inserting into the database
    $drug_id = $_POST["drug_id"];
    $drug_name = $_POST["drug_name"];
    $drug_type = $_POST["drug_type"];
    $drug_form = $_POST["drug_form"];
    $drug_picture = $targetFile;

    // Upload drug picture to the "LandingAssets" directory
    $targetDirectory = "LandingAssets" . DIRECTORY_SEPARATOR; // Create a directory for storing images
    $targetFile = $targetDirectory . basename($_FILES["drug_picture"]["name"]);

    // Check if the file was uploaded successfully
    if (move_uploaded_file($_FILES["drug_picture"]["tmp_name"], $targetFile)) {
        // File was uploaded successfully, insert drug data into the database
        $insertSql = "INSERT INTO drug_info (drug_id, drug_name, drug_type, drug_form, drug_picture) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("issss", $drug_id, $drug_name, $drug_type, $drug_form, $targetFile);

        if ($stmt->execute()) {
            // Redirect back to the company dashboard after adding the drug
            header("Location: companyDash.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Company Dashboard</title>
    <style>
        body {
            background: url("LandingAssets/Background.jpeg") no-repeat;
            background-size: cover;
            background-color: #f0f0f0;
        }

        * {
            font-family: "Roboto", "Arial", "Helvetica", sans-serif;
            color: black;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Common styles for buttons */
        .btn {
            display: block;
            padding: 10px 20px;
            font-size: 16px;
            background-color: rgb(82, 220, 199);
            color: black;
            border-radius: 4px;
            border: 2px solid black;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 10ms;
        }

        .btn:hover {
            background-color: white;
        }

        /* Styles for centering elements */
        .container {
            text-align: center;
            margin-top: 30px;
        }

        img {
            display: block;
            margin: 0 auto;
            width: 40%;
        }

        /* Styles for content area */
        .content {
            width: calc(100% - 250px);
            margin-left: 250px;
            background-color: rgb(139, 139, 139);
            padding: 20px;
            margin-top: 100px;
            border-radius: 20px;
            position: relative;
            z-index: 1;
        }

        /* Sidebar styles */
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: rgb(151, 188, 185);
            padding-top: 20px;
            z-index: 2;
            overflow-y: auto; /* Add scroll for sidebar */
        }

        .sidebar h1 {
            color: white;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .sidebar a {
            display: block;
            padding: 10px 20px;
            margin: 10px;
            font-size: 18px;
            background-color: rgb(124, 214, 206);
            color: black;
            text-decoration: none;
            transition: background-color 10ms;
        }

        .sidebar a:hover {
            background-color: white;
        }

        /* Footer styles */
        .footer {
            position: fixed;
            bottom: 0;
            left: 250px;
            width: calc(100% - 250px);
            background-color: rgb(151, 188, 185);
            padding: 10px 0;
            text-align: center;
            font-size: 14px;
        }

        /* Welcome message style */
        .welcome-message {
            font-size: 24px;
            margin: 20px 0;
        }

        /* Centered add drugs form */
        .add-drugs-form {
            text-align: center;
            margin-top: 20px;
        }

        /* Style for form inputs and labels */
        .add-drugs-form label {
            display: block;
            margin: 10px 0;
            font-size: 18px;
        }

        .add-drugs-form input[type="text"],
        .add-drugs-form input[type="number"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .add-drugs-form button[type="submit"] {
            background-color: rgb(82, 220, 199);
            color: black;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 10ms;
        }

        .add-drugs-form button[type="submit"]:hover {
            background-color: white;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="tables.css">
    <link rel="icon" type="image/x-icon" href="LandingAssets/White Icon.png">
</head>

<body>
    <div class="sidebar">
        <img src="LandingAssets/Black Logo.png" alt="">
        <h1>Company Dashboard</h1>
        <!-- Add Drugs button with onclick event to toggle the add drugs form -->
        <button id="addDrugsBtn" class="btn">Add Drugs</button>
        <!-- View Drugs button, change form action to drugImages.php -->
        <form action="drugImages.php" method="post">
            <button id="viewDrugsBtn" class="btn" name="viewDrugs">View Drugs</button>
        </form>
        <!-- Log Out button with form submit -->
       <!-- Log Out button with form submit -->
<form action="logout.php" method="post">
    <button class="btn" type="submit" name="logout">Log Out</button>
</form>

        </form>
        <div class="footer">
            &copy; 2023 EasyDawa. All rights reserved.
        </div>
    </div>

    <div class="content">
        <!-- Welcome message with dynamic Company Name -->
        <div class="welcome-message">Welcome, <?php echo isset($_SESSION["Company_Name"]) ? htmlspecialchars($_SESSION["Company_Name"]) : ''; ?>!</div>
        <!-- Add Drugs form initially hidden -->
        <div class="add-drugs-form" id="addDrugsForm">
            <h2>Add Drugs</h2>
            <form method="post" action="companyDash.php" enctype="multipart/form-data">
                <label for="drug_id">Drug ID:</label>
                <input type="number" id="drug_id" name="drug_id" required>
                <label for="drug_name">Drug Name:</label>
                <input type="text" id="drug_name" name="drug_name" required>
                <label for="drug_type">Drug Type:</label>
                <input type="text" id="drug_type" name="drug_type" required>
                <label for="drug_form">Drug Form:</label>
                <input type="text" id="drug_form" name="drug_form" required>
                <!-- Add file input for drug picture here -->
                <label for="drug_picture">Drug Picture:</label>
                <input type="file" id="drug_picture" name="drug_picture" accept="image/*">
                <button type="submit" name="add_drug">Add Drug</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addDrugsBtn = document.getElementById('addDrugsBtn');
            const viewDrugsBtn = document.getElementById('viewDrugsBtn');
            const addDrugsForm = document.getElementById('addDrugsForm');
            const tableContainer = document.getElementById('tableContainer');

            function loadTable(tableType, container) {
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        container.innerHTML = xhr.responseText;
                    }
                };

                xhr.open('GET', tableType, true);
                xhr.send();
            }

            addDrugsBtn.addEventListener('click', function () {
                // Toggle the visibility of the add drugs form
                if (addDrugsForm.style.display === 'none' || addDrugsForm.style.display === '') {
                    addDrugsForm.style.display = 'block';
                } else {
                    addDrugsForm.style.display = 'none';
                }
                // Hide the "View Drugs" table when adding drugs
                tableContainer.innerHTML = '';
            });

            viewDrugsBtn.addEventListener('click', function () {
                // Redirect to drugImages.php when the "View Drugs" button is clicked
                window.location.href = 'drugImages.php';
            });
        });
    </script>
</body>

</html>

