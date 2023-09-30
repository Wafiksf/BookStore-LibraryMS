<!DOCTYPE html>
<html lang="en">
  <?php
     require("connection.php");
     session_start();
     
     $email = $_SESSION['email'];
     if (!isset($email)){
        header ('location:login.php');
     }
     $sql = "SELECT role , administrator from register where db_email = '$email'";
     $rsl = mysqli_query($connection,$sql);
     $row = mysqli_fetch_assoc($rsl);
     $admin = $row['administrator'];
     $role = $row['role'];
     if (isset ($_SESSION['email']) && $role==1){
     
     }else{
        header("location:../index.php");
        exit();
     }
  ?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../images/Logo1.png" type="image/x-icon">
  <title>Rooms</title>
  <link type="text/css" rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css" />
  <link type="text/css" rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css" />
  <link type="text/css" rel="stylesheet" href="assets/plugins/flag-icon/flag-icon.min.css" />
  <link type="text/css" rel="stylesheet" href="assets/plugins/simple-line-icons/css/simple-line-icons.css">
  <link type="text/css" rel="stylesheet" href="assets/plugins/ionicons/css/ionicons.css">

  <link type="text/css" rel="stylesheet" href="assets/plugins/chartist/chartist.css">
  <link type="text/css" rel="stylesheet" href="assets/plugins/apex-chart/apexcharts.css">
  <link type="text/css" rel="stylesheet" href="assets/css/app.min.css" />
  <link type="text/css" rel="stylesheet" href="assets/css/style.min.css" />
  <link rel="icon" href="../images/Logo1.png" type="image/x-icon">
  <!-- Favicon -->
  <link rel="icon"
    href="https://static.vecteezy.com/system/resources/previews/002/219/582/original/illustration-of-book-icon-free-vector.jpg"
    type="">

</head>

<body>

  <div class="page-container">
    <?php
       include 'sidebar.php'
       ?>
    <div class="page-content">

      <div class="page-header">

        <nav class="navbar navbar-expand-lg">
          <ul class="list-inline list-unstyled mg-r-20">
            <li class="list-inline-item align-text-top"><a class="hidden-md hidden-lg" href="#"
                id="sidebar-toggle-button"><i class="ion-navicon tx-20"></i></a></li>

            <li class="list-inline-item align-text-top"><a class="hidden-xs hidden-sm" href="#"
                id="collapsed-sidebar-toggle-button"><i class="ion-navicon tx-20"></i></a></li>
          </ul>
        </nav>

        <div class="p-3 mx-auto ">
          <h1 class="text-secondary mx-auto ">Room Section</h1>
          <div class="d-flex m-auto">
          <?php
            if (isset($_SESSION["msg"])) {
              $msg = $_SESSION["msg"];
              unset($_SESSION["msg"]);
                echo '<p class="msgcolor">' . $msg . '</p>';
                } else {
                    $msg = "";
                  }
                ?>
            </div>
          <br>
          <form method='POST' action='room_action.php'>
            <div class="row d-flex justify-content-center">
              <div class="form-group col-md-10 col-xl-10">
                <label for="description" class="text-secondary">Enter Room name</label>
                <input type='text' class="form-control" id="description" name="roomname" placeholder="Enter room name">
                </div>
                <div class="form-group col-md-10 col-xl-10">
                <label for="description" class="text-secondary">Capacity</label>
                <input type='text' class="form-control" id="description" name="roomcap" placeholder="Enter room capacity">
                </div>
                <div class="form-group col-md-10 col-xl-10">
                <input type="submit" class="btn btn-primary">
                  </div>
            </div>
        </div>
        
        </form>
        <hr>
        <div class="m-5">
        <?php

$query = "SELECT id, db_room, db_capacity FROM room";

$result = mysqli_query($connection, $query);

?>

<table class="table table-striped align-middle text-center">
    <thead>
        <tr>
            <th style="color: #fff;">Room</th>
            <th style="color: #fff;">Capacity</th>
            <th style="color: #fff;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $db_room = $row['db_room'];
            $db_capacity = $row['db_capacity'];
        ?>
            <tr>
                <td><?php echo $db_room; ?></td>
                <td><?php echo $db_capacity; ?></td>
                <td>
                    <a class="btn btn-warning" href="updateroom.php?id=<?php echo $id; ?>">Update</a>

                    <a class="btn btn-danger" href="deleteroom.php?id=<?php echo $id; ?>">Delete</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
</div>
<hr>

<div class="m-5">
  <h1>Reservations</h1><br>
  <?php
include 'connection.php';

$query = "SELECT db_email, db_room, db_c, db_date, db_time, db_time2 , db_capacity FROM reservation WHERE status = 1";

$result = mysqli_query($connection, $query);
?>

<table class="table table-striped align-middle text-center">
    <thead>
        <tr>
            <th style="color: #fff;">Email</th>
            <th style="color: #fff;">Room</th>
            <th style="color: #fff;">In</th>
            <th style="color: #fff;">Reservation Date</th>
            <th style="color: #fff;">Start Time</th>
            <th style="color: #fff;">End Time</th>
            <th style="color: #fff;">Capacity</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $db_email = $row['db_email'];
            $db_room = $row['db_room'];
            $db_capacity = $row['db_c'];
            $db_date = $row['db_date'];
            $db_time = $row['db_time'];
            $db_time2 = $row['db_time2'];
            $capacity = $row['db_capacity'];
        ?>
            <tr>
                <td><?php echo $db_email; ?></td>
                <td><?php echo $db_room; ?></td>
                <td><?php echo $db_capacity; ?></td>
                <td><?php echo $db_date; ?></td>
                <td><?php echo $db_time; ?></td>
                <td><?php echo $db_time2; ?></td>
                <td><?php echo $capacity; ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<hr>
</div>

        <script src="assets/plugins/jquery/jquery.min.js"></script>
        <script src="assets/plugins/jquery-ui/jquery-ui.js"></script>
        <script src="assets/plugins/popper/popper.js"></script>
        <script src="assets/plugins/feather-icon/feather.min.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/plugins/pace/pace.min.js"></script>
        <script src="assets/plugins/countup/counterup.min.js"></script>
        <script src="assets/plugins/waypoints/waypoints.min.js"></script>
        <script src="assets/plugins/chartjs/chartjs.js"></script>
        <script src="assets/plugins/apex-chart/apexcharts.min.js"></script>
        <script src="assets/plugins/apex-chart/irregular-data-series.js"></script>
        <script src="assets/plugins/simpler-sidebar/jquery.simpler-sidebar.min.js"></script>
        <script src="assets/js/dashboard/sales-dashboard-init.js"></script>
        <script src="assets/js/jquery.slimscroll.min.js"></script>
        <script src="assets/js/highlight.min.js"></script>
        <script src="assets/js/app.js"></script>
        <script src="assets/js/custom.js"></script>
</body>

</html>