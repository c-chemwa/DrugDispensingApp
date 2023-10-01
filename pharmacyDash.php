<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST["logout"])) {
    session_destroy();
    header('Location: login.html');
    exit();
}

if (!isset($_SESSION["PHAR_ID"])) {
    header('Location: login.html');
    exit();
}

require("EasyDawa.php");

$PHAR_ID = $_SESSION["PHAR_ID"];

$sql = "SELECT pharname FROM pharmacyinfo WHERE PHAR_ID = $PHAR_ID";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $pharmacist_name = $row['pharname'];
    $pharmacistUserName = htmlspecialchars($pharmacist_name);
} else {
    $pharmacistUserName = 'Pharmacy not found.';
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Pharmacy Dashboard</title>
    <style>
        /* Reset default styles for all elements */
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
            width: 80%;
            margin: 0 auto;
            margin-left: 250px; /* Adjusted to push content to the right */
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

        /* Background image */
        body {
            background: url("LandingAssets/Background.jpeg") no-repeat;
            background-size: cover;
        }

        /* Table styles */
        .table-container {
            margin-top: 20px;
        }

        /* Define the CSS classes from tables.css for your tables */
        .table-container .table {
            /* Add the styles from tables.css as needed */
            border-collapse: collapse;
            width: 100%;
        }

        .table-container .table th,
        .table-container .table td {
            padding: 8px;
            text-align: left;
            background-color: aquamarine; /* Add background color to table headers */
        }
    </style>
    <link rel="stylesheet" type="text/css" href="tables.css">
    <link rel="icon" type="image/x-icon" href="LandingAssets/White Icon.png">
</head>

<body>
    <div class="sidebar">
        <img src="LandingAssets/Black Logo.png" alt="">
        <h1>Pharmacy Dashboard</h1>
        <button id="viewPrescriptions" class="btn">View All Prescriptions</button>
        <button id="viewPatients" class="btn">View Patients</button>
        <button id="viewHistory" class="btn">View History</button>
        <button id="insertPrices" class="btn">Set Prices</button>
        <button id="viewPrices" class="btn">View Your Prices</button>
        <form action="" method="post">
            <button class="btn" type="submit" name="logout">Log Out</button>
        </form>
        <div class="footer">
            &copy; 2023 EasyDawa. All rights reserved.
        </div>
    </div>

    <div class="content">
        <div class="welcome-message">Welcome, <?php echo isset($pharmacistUserName) ? $pharmacistUserName : ''; ?>!</div>
        <div class="table-container" id="tableContainer"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const viewPrescriptionsBtn = document.getElementById('viewPrescriptions');
            const viewPatientsBtn = document.getElementById('viewPatients');
            const viewHistoryBtn = document.getElementById('viewHistory');
            const setPricesBtn = document.getElementById('insertPrices');
            const viewPricesBtn = document.getElementById('viewPrices');

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

            viewPrescriptionsBtn.addEventListener('click', function () {
                loadTable('displayPrescriptions.php', tableContainer);
            });

            viewPatientsBtn.addEventListener('click', function () {
                loadTable('viewPatPhar.php', tableContainer);
            });

            viewHistoryBtn.addEventListener('click', function () {
                loadTable('dispensedDrugsHistory.php', tableContainer);
            });

            setPricesBtn.addEventListener('click', function () {
                loadTable('insertPrices.php', tableContainer);
            });

            viewPricesBtn.addEventListener('click', function () {
                loadTable('viewPrices.php', tableContainer);
            });
        });
    </script>
</body>

</html>

