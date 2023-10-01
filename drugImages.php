<?php
// Include the database connection code (EasyDawa.php)
require("EasyDawa.php");

// Query to retrieve drug images
$query = "SELECT drug_id, drug_picture FROM drug_info";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drug Images</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        .image-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .image-item {
            margin: 20px;
            text-align: center;
        }

        img.maximized-image {
            max-width: 200px;
            max-height: 200px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #4285f4;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #357ae8;
        }

        #details-container {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }

        /* CSS for drug details container */
        .details-container {
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
            border: 1px solid #000;
            border-radius: 10px;
            padding: 20px;
            display: none; /* Initially hidden */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 999; /* Ensure it's on top of other elements */
            max-width: 80%;
            max-height: 80%;
            overflow: auto;
            text-align: left;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .close-btn {
            background-color: rgb(82, 220, 199);
            color: black;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 10ms;
            float: right;
            margin-top: 10px;
        }

        .close-btn:hover {
            background-color: white;
        }

        /* Back button style */
        .back-button {
            display: block;
            background-color: rgb(82, 220, 199);
            color: black;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            margin: 20px auto;
            max-width: 200px;
            transition: background-color 10ms;
        }

        .back-button:hover {
            background-color: white;
        }
    </style>
</head>

<body>
    <h1>Drug Images</h1>

    <div class="image-container">
        <?php
        // Loop through the query result and display each drug image
        while ($row = $result->fetch_assoc()) {
            $drugId = $row["drug_id"];
            $drugPicture = $row["drug_picture"];
            ?>

            <div class="image-item">
                <a href="#" onclick="showDetails(<?php echo $drugId; ?>)">
                    <img src="<?php echo $drugPicture; ?>" alt="Drug Image" class="maximized-image">
                </a>
                <br>
                <button onclick="showDetails(<?php echo $drugId; ?>)">View Details</button>
            </div>

        <?php
        }
        ?>
    </div>

    <div id="details-container">
        <!-- Drug details will be displayed here -->
        <button class="close-btn" onclick="closeDetails()">Close</button>
    </div>

    <!-- Back button to return to companyDash.php -->
    <a href="companyDash.php" class="back-button">Back to Company Dashboard</a>

    <script>
        function closeDetails() {
            const detailsContainer = document.getElementById('details-container');
            detailsContainer.style.display = 'none';
        }
        
        function showDetails(drugId) {
            const detailsContainer = document.getElementById('details-container');

            // Make an AJAX request to get drug details
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);

                        if (!response.error) {
                            // Display drug details in the details container
                            const detailsHtml = `
                                <h2>Drug Details</h2>
                                <p><strong>Drug ID:</strong> ${response.drug_id}</p>
                                <p><strong>Drug Name:</strong> ${response.drug_name}</p>
                                <p><strong>Drug Type:</strong> ${response.drug_type}</p>
                                <p><strong>Drug Form:</strong> ${response.drug_form}</p>
                                <!-- Add more details fields as needed -->
                            `;
                            detailsContainer.innerHTML = detailsHtml;
                            detailsContainer.style.display = 'block';
                        } else {
                            // Display an error message if drug not found
                            detailsContainer.innerHTML = '<p>Error: Drug not found</p>';
                            detailsContainer.style.display = 'block';
                        }
                    } else {
                        // Display an error message for non-200 status
                        detailsContainer.innerHTML = '<p>Error: Unable to fetch drug details</p>';
                        detailsContainer.style.display = 'block';
                    }
                }
            };

            xhr.open('GET', `getDrugDetails.php?drug_id=${drugId}`, true);
            xhr.send();
        }
    </script>
</body>

</html>
