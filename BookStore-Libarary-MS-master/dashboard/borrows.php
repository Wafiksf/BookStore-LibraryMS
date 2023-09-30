<?php
include 'connection.php';
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

$stmt = $connection->prepare("SELECT b.db_borrowfrom, b.db_borrowto, b.db_bookname, b.db_email, r.db_fname, r.db_lname FROM borrows b INNER JOIN register r ON b.db_email = r.db_email WHERE b.status = ?");
$status = 1;
$stmt->bind_param("i", $status);
$stmt->execute();

$stmt->bind_result($from, $to, $book, $email, $fname, $lname);

$borrows = [];

while ($stmt->fetch()) {
    $borrows[] = [
        'db_borrowfrom' => $from,
        'db_borrowto' => $to,
        'db_bookname' => $book,
        'db_fname' => $fname,
        'db_email' => $email,
        'db_lname' => $lname
    ];
}

$stmt->close();
$connection->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="../images/Logo1.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/plugins/flag-icon/flag-icon.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/plugins/simple-line-icons/css/simple-line-icons.css">
    <link type="text/css" rel="stylesheet" href="assets/plugins/ionicons/css/ionicons.css">
    <link type="text/css" rel="stylesheet" href="assets/plugins/chartist/chartist.css">
    <link type="text/css" rel="stylesheet" href="assets/plugins/apex-chart/apexcharts.css">
    <link type="text/css" rel="stylesheet" href="assets/css/app.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/css/style.min.css"/>
    <link rel="icon" href="../images/Logo1.png" type="image/x-icon">
    <!-- Favicon -->	
    <link rel="icon" href="https://static.vecteezy.com/system/resources/previews/002/219/582/original/illustration-of-book-icon-free-vector.jpg" type="">
    <title>Borrows</title>
    
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

                <div class="p-3 mx-auto ">
                <h1>Borrows</h1>
                <br>

<?php if (!empty($borrows)) : ?>
    <table class="table table-striped">
        <thead class="red">
            <tr>
                <th style="color: #fff;">First Name</th>
                <th style="color: #fff;">Last Name</th>
                <th style="color: #fff;">Email</th>
                <th style="color: #fff;">Book Name</th>
                <th style="color: #fff;">From</th>
                <th style="color: #fff;">To</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($borrows as $borrow) : ?>
                <tr>
                    <td><?php echo $borrow['db_fname']; ?></td>
                    <td><?php echo $borrow['db_lname']; ?></td>
                    <td><?php echo $borrow['db_email']; ?></td>
                    <td><?php echo $borrow['db_bookname']; ?></td>
                    <td><?php echo $borrow['db_borrowfrom']; ?></td>
                    <td><?php echo $borrow['db_borrowto']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>No contact form submissions found.</p>
<?php endif; ?>
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
