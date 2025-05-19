<?php
include ("db_connect.php");
include ("function.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title> HOME SWEEP HOME </title>

    <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.jpg"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <head>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>


                                       <!-- Connected sa Booknow.php-->
    <style>
       
        body {
            background-image: url('Login.jpg');
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
	        background-size: cover;
	        background-position: center;
	        background-repeat: no-repeat;
	        overflow-x:hidden;
            margin: 0;
        }

        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px; /* Hide sidebar by default */
            background-color: transparent;
            box-shadow: 2px 2px  4px;
            backdrop-filter: blur(11px);
            padding-top: 60px;
            transition: left 0.3s;
        }
        .sidebar a {
            padding: 20px 15px;
            display: block;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: aqua;
        }

        @keyframes fadeAnimation {
           0% { opacity: 0; }
           50% { opacity: 1; }
           100% { opacity: 0; }
         }
         .content {
          color: white;
          font-size: 30px;
          animation: fadeAnimation 4s infinite; /* Apply the animation */
          display: flex;
          justify-content: center; /* Center content horizontally */
          align-items: center; /* Center content vertically */
         }
        .menu-toggle {
            position: fixed;
            left: 10px;
            top: 10px;
            cursor: pointer;
            color: white;
            font-size: 24px; 
            padding: 10px;
       }
       .stat-panel-icon {
    margin-bottom: 15px;
}


       .post-div {
    text-align: center; /* Center-align the content */
}

.row {
    display: flex; /* Use flexbox for centering */
    justify-content: center; /* Center the row horizontally */
}

.panel {
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    overflow: hidden;
    width: 280px; /* Set the width */
    margin: 50px; /* Add margin around the panels */
}

.panel .panel-body {
    padding: 20px;
    color: #fff;
    border-radius: 8px 8px 0 0;
}

.bk-primary {
    background: #007bff;
}

.bk-success {
    background: #28a745;
}

.stat-panel-number {
    font-size: 36px;
    font-weight: bold;
}

.stat-panel-title {
    font-size: 14px;
    font-weight: 600;
    margin-top: 10px;
    text-transform: uppercase;
}

.block-anchor {
    display: block;
    padding: 10px 15px;
    background-color: #f7f7f7;
    text-decoration: none;
    color: #333;
    text-align: center;
    border-top: 1px solid #e7e7e7;
    border-radius: 0 0 8px 8px;
}

.block-anchor:hover {
    background-color: #e7e7e7;
    text-decoration: none;
    color: #333;
}

@media (max-width: 767px) {
    .col-md-3 {
        margin-bottom: 20px;
    }
}


        .sidebar-logo {
    margin-left: 30px;
    width: 180px; /* Adjust the width as needed */
    height: auto; /* Maintain aspect ratio */
    margin-bottom: 20px; /* Add some space below the logo */
    }
       
    </style>

</head>

<body>

<div class="sidebar" id="sidebar">
   <img src="Logo2.png" alt="Logo" class="sidebar-logo">
    <a href="Admin.php"> <i class = "glyphicon glyphicon-home"> </i> Dashboard </a>
    <a href="clients.php"> <i class = "glyphicon glyphicon-th-list"> </i> Manage Clients</a>
    <a href="accounts.php"> <i class = "glyphicon glyphicon-user"> </i> Manage Accounts</a>
    <a href="Login.php"> <i class = "glyphicon glyphicon-off"> </i> Logout</a>
</div>

<div class="col-md-12 post-div mx-auto">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body bk-primary text-light">
                            <div class="stat-panel text-center">
                                <?php 
                                    $conn = new mysqli("localhost","root","","hshdb") or die(mysqli_error());
                                    $qusers = $conn->query("SELECT COUNT(accountid) AS total FROM `account`") or die(mysqli_error());
                                    $fusers = $qusers->fetch_array();
                                ?>
                                <div class="stat-panel-icon">
                                    <i class="fas fa-users fa-3x"></i>
                                </div>
                                <div class="stat-panel-number h1"><?php echo $fusers['total']; ?></div>
                                <div class="stat-panel-title text-uppercase">Total Accounts</div>
                            </div>
                        </div>
                        <a href="accounts.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body bk-success text-light">
                            <div class="stat-panel text-center">
                                <?php 
                                    $qusers = $conn->query("SELECT COUNT(serviceid) AS total FROM `services`") or die(mysqli_error());
                                    $fhouse = $qusers->fetch_array();
                                ?>
                                <div class="stat-panel-icon">
                                    <i class="fas fa-user-friends fa-3x"></i>
                                </div>
                                <div class="stat-panel-number h1"><?php echo $fhouse['total']; ?></div>
                                <div class="stat-panel-title text-uppercase">Total Clients</div>
                            </div>
                        </div>
                        <a href="clients.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    

<div class="menu-toggle" onclick="toggleMenu()">☰</div>

<script>
    function toggleMenu() {
        var sidebar = document.getElementById('sidebar');
        if (sidebar.style.left === '0px') {
            sidebar.style.left = '-250px';
        } else {
            sidebar.style.left = '0px';
        }
    }

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>





    

  </html>
  

</body>
</html>
