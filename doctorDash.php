<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["DOCTORS_ID"])) {
    header('Location: login.html');
    exit();
}

require("EasyDawa.php");

$DOCTORS_ID = $_SESSION["DOCTORS_ID"];

$sql = "SELECT FIRST_NAME FROM doctors_info WHERE DOCTORS_ID = $DOCTORS_ID";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $first_name = $row['FIRST_NAME'];
    $doctorUserName = htmlspecialchars($first_name);
} else {
    $doctorUserName = 'Doctor not found.';
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Doctor Dashboard</title>
    <link rel="icon" type="image/x-icon" href="LandingAssets/White Icon.png">
    <!-- Include the external CSS file for tables -->
    <link rel="stylesheet" type="text/css" href="tables.css">
    <style>
        /* Reset default styles for all elements */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Roboto", "Arial", "Helvetica", sans-serif;
        }

        /* Common styles for buttons */
        .btn {
            display: block;
            margin: 10px auto;
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
            padding: 20px;
            background-color: rgb(91, 150, 136);
            border-radius: 20px;
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

        /* Table content style */
        .table-content {
            margin-top: 20px;
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
    </style>
</head>

<body>
    <div class="sidebar">
        <img src="LandingAssets/Black Logo.png" alt="">
        <h1>Doctor Dashboard</h1>
        <a href="javascript:void(0);" class="btn" id="viewPatients">View Your Patients</a>
        <a href="javascript:void(0);" class="btn" id="viewDrugs">View The Drugs Available</a>
        <hr>
        <form id="logoutForm" method="post">
            <button class="btn btn-logout" type="submit">Log Out</button>
        </form>
        <div class="footer">
            &copy; 2023 EasyDawa. All rights reserved.
        </div>
    </div>

    <div class="content">
        <div class="welcome-message">Welcome, <?php echo $doctorUserName; ?>!</div>

        <!-- Place your tables below the welcome message -->
        <div class="table-content" id="tableContainer">
            <!-- Content for the tables will be loaded here -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const viewPatientsBtn = document.getElementById('viewPatients');
            const viewDrugsBtn = document.getElementById('viewDrugs');
            const tableContainer = document.getElementById('tableContainer');

            function loadTable(tableType) {
                const xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        tableContainer.innerHTML = xhr.responseText;
                    }
                };

                xhr.open('GET', tableType, true);
                xhr.send();
            }

            viewPatientsBtn.addEventListener('click', function () {
                loadTable('viewPatient.php');
            });

            viewDrugsBtn.addEventListener('click', function () {
                loadTable('viewDrugs.php');
            });

            document.getElementById('logoutForm').addEventListener('submit', function (e) {
                e.preventDefault();
                // Perform session end here (no actual 'logout.php')
                // Redirect to login.html after session end
                window.location.href = "login.html";
            });
        });
    </script>
</body>

</html>


