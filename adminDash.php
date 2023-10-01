<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
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

        .btn:hover{
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
        .content{
            width: 60%;
            align-items: 0.1px;
            margin: 0.1px;
            background-color: rgb(91, 150, 136);
            padding: 5px;
            margin-top: 10px;
            border-radius:20px;

        }
       .body {
        background: linear-gradient(transparent, rgb(87, 187, 207)), url("LandingAssets/Background.jpeg") no-repeat;
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
    <link rel="icon" type="image/x-icon" href="LandingAssets/White Icon.png">
</head>
<body class="body">
    <div class="sidebar">
        <a href="displayPatients.php" class="btn">View Patients</a>
        <a href="displayDoctors.php" class="btn">View Doctors</a>
        <a href="displayPharmacies.php" class="btn">View Pharmacies</a>
        <a href="displayCompanies.php" class="btn">View Companies</a>
        <a href="displayDrugs.php" class="btn">View Drugs</a>
        <a href="displayContracts.php" class="btn">View Contracts</a>
        <a href="displaySupervisors.php" class="btn">View Supervisors</a>
        <button id="logoutButton" class="btn">Logout</button>
    </div>
    
    <div class="content">
    <?php
require("EasyDawa.php");
if (!isset($_SESSION["ADMIN_ID"])) {
    header('Location: login.html ');
    exit();
}

$ADMIN_ID = $_SESSION["ADMIN_ID"];

// Fetch the admin's name from the database
$sql = "SELECT ADMIN_NAME FROM admin_details WHERE ADMIN_ID = $ADMIN_ID";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $ADMIN_NAME = $row['ADMIN_NAME'];

    // Display the admin's name
    $adminUserName = htmlspecialchars($ADMIN_NAME);
} else {
    echo 'User not found.';
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
    </style>
    <link rel="icon" type="image/x-icon" href="LandingAssets/White Icon.png">
</head>
<body class="body">
    <div class="sidebar">
        <a href="displayPatients.php" class="btn">View Patients</a>
         <a href="displayDoctors.php" class="btn">View Doctors</a>
        <a href="displayPharmacies.php" class="btn">View Pharmacies</a>
        <a href="displayCompanies.php" class="btn">View Companies</a>
        <a href="displayDrugs.php" class="btn">View Drugs</a>
        <a href="displayContracts.php" class="btn">View Contracts</a>
        <a href="displaySupervisors.php" class="btn">View Supervisors</a>
        <a href="insertDrugs.php" class="btn"></a>
        <button id="logoutButton" class="btn">Logout</button>
    </div>
    
    <div class="content">
        <h2>Welcome, <?php echo $adminUserName; ?>!</h2>
    </div>
    <div class="table-container" id="dynamicTableContainer">
</div>



<div class="sidebar">
    <a href="#" class="btn" onclick="loadTable('displayPatients')">View Patients</a>
    <a href="#" class="btn" onclick="loadTable('displayDoctors')">View Doctors</a>
    <a href="#" class="btn" onclick="loadTable('displayPharmacies')">View Pharmacies</a>
    <a href="#" class="btn" onclick="loadTable('displayCompanies')">View Companies</a>
    <a href="#" class="btn" onclick="loadTable('displayDrugs')">View Drugs</a>
    <a href="#" class="btn" onclick="loadTable('displayContracts')">View Contracts</a>
    <a href="#" class="btn" onclick="loadTable('displaySupervisors')">View Supervisors</a>
    <button id="logoutButton" class="btn" onclick="logout()">Logout</button>
</div>

<script>
        function logout() {
            <?php unset($_SESSION["ADMIN_ID"]); ?>

            // Redirect to login.html or perform any other actions as needed
            window.location.href = "login.html";
        }

        // Function to load content based on the clicked link (you may already have this)
        function loadTable(tableType) {
            const container = document.getElementById('dynamicTableContainer');
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    container.innerHTML = xhr.responseText;
                }
            };
            xhr.open('GET', tableType + '.php', true);
            xhr.send();
        }
    </script>