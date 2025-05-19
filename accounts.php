
<!DOCTYPE html>
<html>
<head>

    <title> HOME SWEEP HOME </title>

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
                                  

    

    <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.jpg"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

     <!-- Connected sa Booknow.php-->
    <style>
       
        body {
            background-color: #F1F1F1;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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
            color: gray;
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
            color: gray;
            font-size: 24px; 
            padding: 10px;
       }



       .edit-btn {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        .edit-btn:hover {
            background-color: #138496;
            border-color: #138496;
        }
        .delete-btn {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .delete-btn:hover {
            background-color: #bd2130;
            border-color: #bd2130;
        }
        .btn-icon {
            font-size: 16px;
        }
        .centered {
            text-align: center;
            margin-bottom: 50px;
        }
        .container{
            margin-bottom: 250px;
        }

        .search-container {
            margin-bottom: 20px;
        }

        .search-container input[type=text] {
            padding: 10px;
            background-color: #f1f1f1;
            border: none;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
            width: 250px;
            font-size: 16px;
        }

        .search-container button {
            background: #007bff;
            color: white;
            border: none;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .search-container button:hover {
            background: #0056b3;
        }

        h2{
            padding-top: 130px;
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

<div class="container">
<h2 class="centered"> ACCOUNTS REGISTERED </h2>

<br><br>

  <!-- Search input -->
  <form method="GET">
        <div class="input-group mb-3">
            <input type="text" name="search" class="form-control" placeholder="Search...">
            <div class="input-group-append"> 
              <button class="btn btn-outline-secondary" type="submit">Search</button> 
            </div>
        </div>
    </form>

        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Email</th>
                    <th scope="col">Password</th>
                    <th scope="col">Username</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>

            <?php
include 'db_connect.php';

// Check if search parameter is set
if(isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    // Construct SQL query with search condition
    $sql = "SELECT * FROM `account` WHERE `email` LIKE ? OR `password` LIKE ? OR `username` LIKE ?";
    $stmt = $con->prepare($sql);
    $likeSearch = "%$search%";
    $stmt->bind_param("sss", $likeSearch, $likeSearch, $likeSearch);
} else {
    // If search parameter is not set, fetch all records
    $sql = "SELECT * FROM `account`";
    $stmt = $con->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $id = $row['accountid'];
        $email = $row['email'];
        $password = $row['password'];
        $username = $row['username'];
        echo '<tr>
            <th scope="row">'.$id.'</th>
            <td>'.$email.'</td>
            <td>'.$password.'</td>
            <td>'.$username.'</td>
            <td>
                <button class="btn edit-btn" name="upd_btn"><a href="update2.php?updateid='.$id.'" class="text-light"><i class="fas fa-pen btn-icon"></i> Update</a></button>
                <button class="btn delete-btn"><a href="delete2.php?deleteid='.$id.'" class="text-light"><i class="fas fa-trash btn-icon"></i> Delete</a></button>
            </td>
        </tr>';
    }
} else {
    echo '<tr><td colspan="9">No records found</td></tr>';
}

$stmt->close();
$con->close();
?>

            </tbody>
        </table>
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

<script>


    // Function to toggle sidebar
    function toggleMenu() {
        var sidebar = document.getElementById('sidebar');
        if (sidebar.style.left === '0px') {
            sidebar.style.left = '-250px';
        } else {
            sidebar.style.left = '0px';
        }
    }
</script>

     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js"></script>

</body>
</html>