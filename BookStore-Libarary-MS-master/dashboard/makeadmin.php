<!DOCTYPE html>
<html lang="en">
<?php
include 'connection.php';
session_start();

$email = $_SESSION['email'];
if (!isset($email)){
   header ('location:login.php');
}
$sqladm = "SELECT role , administrator from register where db_email = '$email'";
$rslt = mysqli_query($connection,$sqladm);
$roww = mysqli_fetch_assoc($rslt);
$admin = $roww['administrator'];
$role = $roww['role'];
if (isset ($_SESSION['email'])&& $admin!=1 && $role==1){
   header ('location:index.php?error');
}
if (isset ($_SESSION['email'])&& $admin!=1 && $role==0){
   header ('location: /lms/books.php');
}
function get_safe_value($connection, $value) {
   if ($value != '') {
       $value = mysqli_real_escape_string($connection, $value);
       return $value;
   }
   return '';
}

if (isset($_GET['type'])) {
   $type = get_safe_value($connection, $_GET['type']);

   if ($type == 'delete') {
   $id = get_safe_value($connection, $_GET['id']);
   $delete_sql = "DELETE FROM register WHERE user_id='$id'";
   mysqli_query($connection, $delete_sql);
}

if ($type == 'status') {
   $operation = get_safe_value($connection, $_GET['operation']);
   $id = get_safe_value($connection, $_GET['id']);
   if ($operation == 'makeadmin') {
      $status = '1';
   } else {
      $status = '0';
   }
   $update_status_sql = "UPDATE register SET role='$status' WHERE user_id='$id'";
   mysqli_query($connection, $update_status_sql);
}

}


?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="icon" href="../images/Logo1.png" type="image/x-icon">
    <link type="text/css" rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/plugins/flag-icon/flag-icon.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/plugins/simple-line-icons/css/simple-line-icons.css">
    <link type="text/css" rel="stylesheet" href="assets/plugins/ionicons/css/ionicons.css">
    <link type="text/css" rel="stylesheet" href="assets/plugins/chartist/chartist.css">
    <link type="text/css" rel="stylesheet" href="assets/plugins/apex-chart/apexcharts.css">
    <link type="text/css" rel="stylesheet" href="assets/css/app.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/css/style.min.css"/>
    <!-- Favicon -->	
    <link rel="icon" href="https://static.vecteezy.com/system/resources/previews/002/219/582/original/illustration-of-book-icon-free-vector.jpg" type="">
 
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
                    <li class="list-inline-item align-text-top"><a class="hidden-md hidden-lg" href="#" id="sidebar-toggle-button"><i class="ion-navicon tx-20"></i></a></li>
                    <li class="list-inline-item align-text-top"><a class="hidden-xs hidden-sm" href="#" id="collapsed-sidebar-toggle-button"><i class="ion-navicon tx-20"></i></a></li>
                 </ul>
              </nav>
           
           </div>
           <div class="content pb-0">
   <div class="orders">
      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <div class="card-body">
                  <h4 class="box-title">Make Admin </h4>
               </div>
               <div class="card-body--">
                  <div class="table-stats order-table ov-h">
                     <table class="table">
                        <thead>
                           <tr>
                              <th class="serial">#</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $sql = "SELECT *, CONCAT(db_fname, ' ', db_lname) AS fullname FROM register WHERE administrator<>1"; 
                           $res = mysqli_query($connection, $sql);
                           $i = 1;
                           while ($row = mysqli_fetch_assoc($res)) { ?>
                              <tr>
                                 <td class="serial"><?php echo $i ?></td>
                                 <td><?php echo $row['fullname'] ?></td>
                                 <td><?php echo $row['db_email'] ?></td>
                              
                                 <td>
                                    <?php
                                    if ($row['role'] == 0) {
                                       echo "<span class='btn btn-warning'><a href='makeadmin.php?type=status&operation=makeadmin&id=" . $row['user_id'] . "'>Admin</a></span>&nbsp";
                                    } else {
                                       echo "<span class='btn btn-success'><a href='makeadmin.php?type=status&operation=remove&id=" . $row['user_id'] . "'>Remove Admin</a></span>&nbsp";
                                    }
                                    echo "<span class='btn btn-danger'><a href='?type=delete&id=" . $row['user_id'] . "'>Delete</a></span>";
                                    ?>
                                 </td>
                              </tr>
                           <?php $i = $i + 1;
                           } ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
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
