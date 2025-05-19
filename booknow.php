<?php
session_start();
include("db_connect.php");
include("function.php");
$user_data = check_login($con);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hshdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind parameters
    $stmt = $conn->prepare("INSERT INTO services (servicename, time, price, contact_details, calendar) VALUES (?, ?, ?, ?, ?)");
    
    // Check if the prepare was successful
    if ($stmt === false) {
        die("Error in prepare statement: " . $conn->error);
    }
    
    $stmt->bind_param("sssss", $service, $time, $price, $contact_details, $calendar);

    // Set parameters and execute
    $service = $_POST['service'];
    $time = $_POST['time'];
    $price = $_POST['price'];
    $contact_details = $_POST['contact_details'];
    $calendar = $_POST['calendar'];

    if ($stmt->execute()) {
        // Store the ID of the newly booked service in the session
        $new_serviceid = $stmt->insert_id;
        if (!isset($_SESSION['recently_booked'])) {
            $_SESSION['recently_booked'] = [];
        }
        $_SESSION['recently_booked'][] = $new_serviceid;

        echo "Booking successful.";
        // Redirect to Services.php
        header("Location: Services.php");
        exit(); // Make sure no more output is sent
    } else {
        echo "Error in execution: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>HOME SWEEP HOME</title>
    <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.jpg"/>

    <link href="https://fonts.googleapis.com/css?family=Rufina:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/animate.css" />
    <link rel="stylesheet" href="assets/css/hover-min.css">
    <link rel="stylesheet" href="assets/css/datepicker.css" >
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css"/>
    <link rel="stylesheet" href="assets/css/jquery-ui.min.css" />
		
			
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('assets/images/bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 900px;
        }

        .container-wrapper {
            display: flex;
            justify-content: center;
            margin-top:-10%;
            width: 100%;
            padding: 0 20px; /* Add some padding to separate containers */
        }

        .container {
            width: 700px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }



        h2 {
            text-align: center;
            margin-top: 0;
            color: #007bff;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="time"],
        input[type="date"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 2px;
            background-color: #f9f9f9;
        }

        input[type="text"][readonly] {
            background-color: #f9f9f9;
            cursor: not-allowed;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        input[type="text"]::placeholder,
        input[type="date"]::placeholder {
            color: #777;
        }

        button{
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover{
            background-color: #0056b3;
        }
        a{
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            text-decoration: none;
            font: arial, sans-serif;
            font-size: 14px;
        }
        a:hover{
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container-wrapper">
        <div class="container">
            <h2>Book Now</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="booking-form">
                <label for="service">Type of Service:</label>
                <select id="service" name="service" onchange="updatePrice()">
                    <option value="Regular Cleaning" data-price="25000">Regular Cleaning</option>
                    <option value="Deep Cleaning" data-price="4000">Deep Cleaning</option>
                    <option value="Move-In/Move-Out Cleaning" data-price="6000">Move-In/Move-Out Cleaning</option>
                    <option value="Post-Construction Cleaning" data-price="7500">Post-Construction Cleaning</option>
                    <option value="Specialized Cleaning" data-price="9500">Specialized Cleaning</option>
                    <option value="Office/Commercial Cleaning" data-price="15000">Office/Commercial Cleaning</option>
                </select>

                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required>

                <label for="price">Price:</label>
                <input type="text" id="price" name="price" placeholder="Enter price" required readonly>

                <label for="contact_details">Contact Details:</label>
                <input type="text" id="contact_details" name="contact_details" placeholder="Enter contact details" required>

                <label for="calendar">Date:</label>
                <input type="date" id="calendar" name="calendar" required>

                <input type="submit" name="submit" value="Book Now">
                <a href="index.php" target="_blank">Cancel</a>
               
            </form>
            <h2>Payment Details</h2>
            <form id="payment-form">
                <label for="payment-method">Select Payment Method:</label>
                <select id="payment-method" name="payment-method" onchange="togglePaymentDetails()">
                    <option value="gcash">GCash</option>
                    <option value="credit-card">Credit Card</option>
                    <option value="cash">Cash</option>
                </select>

                <div id="gcash-details" class="payment-details" style="display: none;">
                    <label for="gcash-number">GCash Number:</label>
                    <input type="text" id="gcash-number" name="gcash-number">
                </div>

                <div id="credit-card-details" class="payment-details" style="display: none;">
                    <label for="card-name">Card Holder Name:</label>
                    <input type="text" id="card-name" name="card-name">
                    <label for="card-number">Credit Card Number:</label>
                    <input type="text" id="card-number" name="card-number">
                    <label for="expiry-date">Expiry Date:</label>
                    <input type="text" id="expiry-date" name="expiry-date">
                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" name="cvv">
                </div>

                <div id="cash-details" class="payment-details" style="display: none;">
                    <label for="user-balance">Your Balance:</label>
                    <input type="text" id="user-balance" name="user-balance">
                </div>

                <label for="payment-price">Price:</label>
                <input type="text" id="payment-price" name="payment-price" readonly>

                <button type="button" onclick="processPayment()">Submit Payment</button>
            </form>
        </div>
    </div>

   

    <script>
        var paymentMade = false; // Flag to track payment status

        function updatePrice() {
            var service = document.getElementById('service');
            var price = service.options[service.selectedIndex].getAttribute('data-price');
            document.getElementById('price').value = price;
            document.getElementById('payment-price').value = price; // Update price in payment form
        }

        function togglePaymentDetails() {
            var paymentMethod = document.getElementById('payment-method').value;

            document.querySelectorAll('.payment-details').forEach(function(element) {
                element.style.display = 'none';
            });

            document.getElementById(paymentMethod + '-details').style.display = 'block';

            if (paymentMethod === 'gcash') {
                document.getElementById('gcash-number').style.display = 'block';
            } else {
                document.getElementById('gcash-number').style.display = 'none';
            }
        }

        function processPayment() {
            var paymentMethod = document.getElementById('payment-method').value;
            var price = parseFloat(document.getElementById('payment-price').value);

            if (isNaN(price)) {
                alert('Please enter a valid amount for the price.');
                return;
            }

            if (paymentMethod === 'cash') {
                var userBalance = parseFloat(document.getElementById('user-balance').value);

                if (isNaN(userBalance)) {
                    alert('Please enter a valid amount for your balance.');
                    return;
                }

                if (userBalance < price) {
                    alert('Insufficient balance. Please add more money.');
                    return;
                }

                var remainingBalance = userBalance - price;
                alert('Payment successful! Your remaining balance is: ' + remainingBalance.toFixed(2));
            } else {
                alert('Payment successful!');
            }

            paymentMade = true; // Set payment flag to true
        }

        document.getElementById('booking-form').onsubmit = function(event) {
            if (!paymentMade) {
                alert('Please make the payment first.');
                event.preventDefault(); // Prevent form submission
            }
        };

        window.onload = function() {
            updatePrice();
        };
    </script>

</body>
</html>