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
    <title>Document</title>
</head>
<body>
    <h1 align="center">Updated Data</h1>
<?php

  
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM data WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if (isset($_POST['submit'])) {
        $first_name = $_POST['first_name'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];

        $query = "UPDATE data SET first_name = ?, dob = ?, gender = ? WHERE id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "sssi", $first_name, $dob, $gender, $id);
        mysqli_stmt_execute($stmt);

        header("Location: index.php");
        exit;
    }
}

?>
<div class="mb-3 mt-3">
<form method="post" >
    <label for="first_name" class="form-label">First Name:</label>
    <input type="text" name="first_name" class="form-control" value="<?= $row['first_name'] ?>"></div>
<div class="mb-3">
    <label for="dob" class="form-label">Date of Birth:</label>
    <input type="date" name="dob" value="<?= $row['dob'] ?>" class="form-control"></div>

    <label for="gender">Gender:</label>
    <select name="gender">
        <option value="Male" <?= $row['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
        <option value="Female" <?= $row['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
    </select>
</br>
</br>
    <input type="submit" name="submit" value="Update"  class="btn btn-primary">
</form>