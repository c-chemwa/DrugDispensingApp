<?php
// Check if session is active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is not logged in
if (!isset($_SESSION["patient_id"])) {
    header('Location: login.html');
    exit();
}

require("EasyDawa.php");

$patient_id = $_SESSION["patient_id"];

$sql = "SELECT FIRST_NAME FROM patients_info WHERE PATIENT_ID = $patient_id";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $first_name = $row['FIRST_NAME'];
    $patientUserName = htmlspecialchars($first_name);
} else {
    $patientUserName = 'Patient not found.';
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Patient Dashboard</title>
    <link rel="icon" type="image/x-icon" href="LandingAssets/White Icon.png">
    <style>
        /* Your CSS styles here */

        * {
            font-family: "Roboto", "Arial", "Helvetica", sans-serif;
            color: black;
        }

        .container {
            text-align: center;
            margin-top: 30pxpx;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            text-decoration: rgb(240, 240, 240);
            background-color: rgb(82, 220, 199);
            color: black;
            border-radius: 4px;
            border: 2px solid black;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: white;
            transition: 10ms;
        }

        img {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 40%;
        }

        .img {
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .content {
            width: 60%;
            align-items: 0.1px;
            margin: 0.1px;
            background-color: rgb(91, 150, 136);
            padding: 5px;
            margin-top: 10px;
            border-radius: 20px;

        }

        .body {
            background: linear-gradient( rgb(82, 220, 199)), url("LandingAssets/Background.jpeg") no-repeat;
        }

        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: rgb(151, 188, 185);
            padding-top: 20px;
        }

        .sidebar a {
            display: block;
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            background-color: rgb(124, 214, 206);
            color: black;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: white;
            transition: 10ms;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: rgb(151, 188, 185);
            padding-top: 20px;
        }

        .sidebar a {
            display: block;
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            background-color: rgb(124, 214, 206);
            color: black;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: white;
            transition: 10ms;
        }

        .content {
            margin-left: 250px;
            margin-right: 250px;
            padding: 0.1px;
        }

        .body {
            background: url("LandingAssets/Background.jpeg") no-repeat;
            background-size: 100%;
        }
    </style>
</head>

<body class="body">
    <div class="sidebar">
        <img src="LandingAssets/Black Logo.png" alt="">
        <h1>Patient Dashboard</h1>
        <a href="#" class="btn" onclick="loadTable('pickDoctors')">View Doctors</a>
        <a href="#" class="btn" onclick="loadTable('viewSelectedDocs')">View Selected Doctors</a>
        <a href="#" class="btn" onclick="loadTable('patientsPrescription')">View Your Prescriptions</a>
        <a href="#" class="btn" onclick="loadTable('viewDispensedDrugs')">View Your Dispensed Drugs</a>
        <hr>
        <form id="logoutForm" method="post">
            <button class="btn btn-logout" type="submit"onclick="logout()">Log Out</button>
        </form>
        <div class="footer">
            &copy; 2023 EasyDawa. All rights reserved.
        </div>
    </div>

    <div class="content">
    <p style="font-size: 24px; font-weight: bold; text-align: center; margin-top: 20px;">Welcome, <?php echo $patientUserName; ?>!</p>


        <div id="tableContainer"></div>
    </div>

    <script>
     
        function loadTable(tableType) {
            const tableContainer = document.getElementById('tableContainer');
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    tableContainer.innerHTML = xhr.responseText;
                }
            };
        
            xhr.open('GET', tableType + '.php', true);
            xhr.send();
        }

        function logout() {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Redirect to the login page after unsetting the session
                window.location.href = "login.html";
            }
        };

        xhr.open('GET', 'logout.php', true);
        xhr.send();
    }
    </script>
</body>

</html>

