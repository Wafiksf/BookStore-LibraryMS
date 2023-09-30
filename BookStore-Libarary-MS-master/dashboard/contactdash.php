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

$stmt = $connection->prepare("SELECT name, email, subject, message FROM contactus");
$stmt->execute();

$stmt->bind_result($name, $email, $subject, $message);

$contacts = [];

while ($stmt->fetch()) {
    $contacts[] = [
        'name' => $name,
        'email' => $email,
        'subject' => $subject,
        'message' => $message
    ];
}

$stmt->close();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['clear'])) {
        $clearStmt = $connection->prepare("TRUNCATE TABLE contactus");
        $clearStmt->execute();
        $clearStmt->close();
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="icon" href="../images/Logo1.png" type="image/x-icon">
    <!-- Favicon -->	
    <link rel="icon" href="https://static.vecteezy.com/system/resources/previews/002/219/582/original/illustration-of-book-icon-free-vector.jpg" type="">
    <title>Contact</title>
    
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
                <h1>Contact Form Submissions</h1>
                <br>

<?php if (!empty($contacts)) : ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact) : ?>
                <tr>
                    <td><?php echo $contact['name']; ?></td>
                    <td><?php echo $contact['email']; ?></td>
                    <td><?php echo $contact['subject']; ?></td>
                    <td><?php echo $contact['message']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <form method="post">
        <button type="submit" name="clear" class="btn btn-danger m-3">Clear All</button>
    </form>
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
