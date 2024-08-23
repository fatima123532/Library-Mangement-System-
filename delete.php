<?php  require_once("cofig/init.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   
<?php


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM data WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    
     header("Location: index.php");
    exit;
}?>
<script>
    
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!"
  }).then((result) => {
    if (result.isConfirmed) {
      // Make an AJAX request to delete the record
      $.ajax({
        type: "GET",
        url: "delete.php",
        data: { id: <?= $row['id'] ?> },
        success: function() {
          Swal.fire({
            title: "Deleted!",
            text: "Your record has been deleted.",
            icon: "success"
          });
          // Reload the page to reflect the changes
          location.reload();
        }
      });
    }
  });

    </script>
</body>
</html>