<?php  require_once("cofig/init.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- for alerts-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>
<body>
    
 <style>
        body {
            background-color: #f5f5f5;
            background-image: url(https://www.academiaerp.com/wp-content/uploads/2019/06/library-management-system-LMS-educational-ERP-software.jpg);
            opacity: 0.8;
           
            width: 100%;
            height: 100vh;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: scroll;
            -webkit-background-size: cover;
   
  }
  .background-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        z-index: -1;
    }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            
        }
        .btn-filter, .btn-add {
            margin-top: 20px;
        }
        
    </style>
    <div class="background-overlay"></div>
    <div class="container">
        <h1 align="center" style="color: blue;"> Welcome To Library Management System</h1>
        <div class="row">
            <div class="col-md-6">
                <h2>Filter Students</h2>
                <form>
                    <label for="name">Enter Name:</label>
                    <input type="text" name="name" value="<?= isset($_GET['name']) && isset($_GET['gender']) ? $_GET['name'] : '' ?>">
                    <br>
                    <label for="gender">Select Gender:</label>
                    <select name="gender" id="gender">
                        <option value="*">All</option>
                        <option value="Male" <?=isset($_GET["gender"])&& $_GET["gender"]=='Male' ?'selected': ''?>>Male</option>
                        <option value="Female" <?=isset($_GET['gender'])&& $_GET['gender']=='Female' ?'selected':''?>>Female</option>
                    </select>
                    <br>
                    <button type="submit" class="btn btn-primary btn-filter">Filter Students</button>
                </form>
            </div>
            <div class="col-md-6">
                <h2>Add New Student</h2>
                <form action="" method="post">
                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name" required>
                    <br>
                    <label for="dob">Date of Birth:</label>
                    <input type="date" name="dob" required>
                    <br>
                    <label for="gender">Gender:</label>
                    <select name="gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <br>
                    <button type="submit" name="add_student" class="btn btn-success btn-add " >Add Student</button>
                </form>
            </div>
        </div>
        <hr>
<table class='table-bordered table-hover' align='center' cellpadding='18' style=' border-collapse:collapse' border='1'>
    <thead>
        <tr>
            <th>ID</th>
            <th>Full name</th>
            <th> Date of Birth</th>
            <th> Gender</th>
            <th>Created at</th>
            <th>Updated options</th> 
           
        </tr>
       
    </thead>
    <tbody>
    <?php
            // Add new student logic
            if (isset($_POST['add_student'])) {
                $first_name = $_POST['first_name'];
                $dob = $_POST['dob'];
                $gender = $_POST['gender'];
                $query = "INSERT INTO data (first_name, dob, gender) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($stmt, "sss", $first_name, $dob, $gender);
                mysqli_stmt_execute($stmt);
                header("Location: index.php");
                exit;
            }
    // Filter logic
            $where = "";
            $params = array();
            if (isset($_GET['name']) && $_GET['name'] != "") {
                $where .= " AND first_name LIKE ?";
                $params[] = "%" . $_GET['name'] . "%";
            }
            if (isset($_GET['gender']) && $_GET['gender'] != "*") {
                $where .= " AND gender = ?";
                $params[] = $_GET['gender'];
            }
            if ($where != "") {
                $where = "WHERE " . ltrim($where, " AND");
            }
            $query = "SELECT * FROM data $where";
            $stmt = mysqli_prepare($connection, $query);
         if ($params) {
             $types = str_repeat("s", count($params));
             mysqli_stmt_bind_param($stmt, $types, ...$params);
         }
         mysqli_stmt_execute($stmt);
         $result = mysqli_stmt_get_result($stmt);
         while ($row = mysqli_fetch_assoc($result)) {
             ?>

<tr>
    <td><?= $row["id"]?></td>
    <td><?= $row["first_name"]?></td>
    <td><?= $row["dob"]?></td>
    <td><?= $row["gender"]=='Male'? 'Male':'Female'?></td>
    <td><?= $row["created_at"]?></td>
    <td><a href="edit.php?id=<?= $row['id'] ?>">Edit</a> <a href="delete.php?id=<?= $row['id'] ?>">Deleted</a></td>
</tr>
<?php
}?>
    </tbody>
</table>

</body>
</html>