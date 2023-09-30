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
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="x-ua-compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="keyword" content="">
      <meta name="author"  content=""/>
      <!-- Page Title -->
      <title>BookStore Admin Panel</title>
      <!-- Main CSS -->			
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
            
            <!--/ Page Header End -->
            <!--================================-->
            <!-- Page Inner Start -->
            <!--================================-->
            <div class="page-inner">
               <!-- Main Wrapper -->
               <div id="main-wrapper">
                  <!--================================-->
                  <!-- Breadcrumb Start -->
                  <!--================================-->
                  <div class="pageheader pd-t-25 pd-b-35">
                     <div class="pd-t-5 pd-b-5">
                        <h1 class="pd-0 mg-0 tx-20">Sales Monitoring</h1>
                     </div>
                   
                  </div>
                  <!--/ Breadcrumb End -->
                  <!--================================-->
                  <!-- Count Card Start -->
                  <!--================================-->
                  <?php
                  $sql="SELECT count(*) as orders FROM payment";
                  $result=mysqli_query($connection,$sql);
                  $row=mysqli_fetch_assoc($result);
                  $orders=$row['orders'];
                  $sqll="SELECT SUM(totalAmount) as rent FROM payment WHERE paymentType='borrow'";
                  $rslt=mysqli_query($connection,$sqll);
                  $roww=mysqli_fetch_assoc($rslt);
                  $rent=$roww['rent'];
                  $sqlll="SELECT SUM(totalAmount) as sold FROM payment WHERE paymentType='purchase'";
                  $rsslt=mysqli_query($connection,$sqlll);
                  $rowww=mysqli_fetch_assoc($rsslt);
                  $sold=$rowww['sold'];
                  $sqllll="SELECT COUNT(*) as fav FROM favorite";
                  $rssllt=mysqli_query($connection,$sqllll);
                  $rowe=mysqli_fetch_assoc($rssllt);
                  $fav=$rowe['fav'];
                  ?>
                  <div class="row row-xs clearfix">
                     <div class="col-sm-6 col-xl-3">
                        <div class="card mg-b-20">
                           <div class="card-body pd-y-0">
                              <div class="custom-fieldset mb-4">
                                 <div class="clearfix">
                                    <label>Orders</label>
                                 </div>
                                 <div class="d-flex align-items-center text-dark">
                                    <div class="wd-40 wd-md-50 ht-40 ht-md-50 mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded card-icon-warning">
                                       <i class="icon-screen-desktop tx-warning tx-20"></i>
                                    </div>
                                    <div>
                                       <h2 class="tx-20 tx-sm-18 tx-md-24 mb-0 mt-2 mt-sm-0 tx-normal tx-rubik tx-dark"><span class="counter"><?php echo $orders?></span></h2>
                                       <div class="d-flex align-items-center tx-gray-500"><span class="text-success mr-2 d-flex align-items-center">  </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-6 col-xl-3">
                        <div class="card mg-b-20">
                           <div class="card-body pd-y-0">
                              <div class="custom-fieldset mb-4">
                                 <div class="clearfix">
                                    <label>Rent</label>
                                 </div>
                                 <div class="d-flex align-items-center text-dark">
                                    <div class="wd-40 wd-md-50 ht-40 ht-md-50 mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded card-icon-success">
                                       <i class="icon-diamond tx-success tx-20"></i>
                                    </div>
                                    <div>
                                       <h2 class="tx-20 tx-sm-18 tx-md-24 mb-0 mt-2 mt-sm-0 tx-normal tx-rubik tx-dark">$<span class="counter"><?php echo $rent?></span></h2>
                                       <div class="d-flex align-items-center tx-gray-500"><span class="text-danger mr-2 d-flex align-items-center"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-6 col-xl-3">
                        <div class="card mg-b-20">
                           <div class="card-body pd-y-0">
                              <div class="custom-fieldset mb-4">
                                 <div class="clearfix">
                                    <label>Sold</label>
                                 </div>
                                 <div class="d-flex align-items-center text-dark">
                                    <div class="wd-40 wd-md-50 ht-40 ht-md-50 mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded card-icon-primary">
                                       <i class="icon-handbag tx-primary tx-20"></i>
                                    </div>
                                    <div>
                                       <h2 class="tx-20 tx-sm-18 tx-md-24 mb-0 mt-2 mt-sm-0 tx-normal tx-rubik tx-dark">$<span class="counter"><?php echo $sold?></span></h2>
                                       <div class="d-flex align-items-center tx-gray-500"><span class="text-success mr-2 d-flex align-items-center"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-6 col-xl-3">
                        <div class="card mg-b-20">
                           <div class="card-body pd-y-0">
                              <div class="custom-fieldset mb-4">
                                 <div class="clearfix">
                                    <label>Favorites</label>
                                 </div>
                                 <div class="d-flex align-items-center text-dark">
                                    <div class="wd-40 wd-md-50 ht-40 ht-md-50 mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded card-icon-danger">
                                       <i class="icon-heart tx-danger tx-20"></i>
                                    </div>
                                    <div>
                                       <h2 class="tx-20 tx-sm-18 tx-md-24 mb-0 mt-2 mt-sm-0 tx-normal tx-rubik tx-dark "><span class="counter"><?php echo $fav?></span></h2>
                                       <div class="d-flex align-items-center tx-gray-500"><span class="text-danger mr-2 d-flex align-items-center"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
            
                  <!-- / Sales+Order+Revenue  End -->
                  <!--================================-->
                  <!-- Transaction History Start -->
                  <!--================================--> 	
                 		  
                  <div class="row row-xs clearfix">
                     <div class="col-xl-12 ">
                        <div class="card mg-b-20">
                           <div class="card-header">
                              <h4 class="card-header-title">
                                 Transaction History
                              </h4>
                              
                           </div>
                           <div class="collapse show" id="transactionHistory">
                              <ul class="list-group list-group-flush tx-13">
                              <?php
                  $query = "SELECT * FROM payment ORDER BY date DESC";
                  $rst = mysqli_query($connection, $query);
                  while ($rw = mysqli_fetch_assoc($rst)) {
                  ?>	
                                 <li class="list-group-item d-flex pd-sm-x-20">
                                    <div class="d-none d-sm-block"><span class="wd-40 ht-40 mg-r-10 d-flex align-items-center justify-content-center rounded card-icon-success"><i class="icon ion-checkmark"></i></span></div>
                                    <div class="pd-sm-l-10">
                                       <p class="tx-dark mg-b-0">Payment from <a href="" class="tx-dark mg-b-0 tx-semibold"><?php echo $rw['db_email'] ?></a></p>
                                       <span class="tx-12 mg-b-0 tx-gray-500">Payment ID: <?php echo $rw['id'] ?></span>
                                    </div>
                                    <div class="mg-l-auto text-right">
                                       <p class="mg-b-0 tx-rubik tx-dark"><?php echo $rw["totalAmount"]?></p>
                                       <span class="tx-12 tx-success mg-b-0">Completed</span>
                                    </div>
                                 </li>
                                
                                
                                 
               		 <?php
                  }
                      ?>
                              </ul>
                           </div>
                        </div>
                     </div>
                     
                     </div>
                  
                  <!--================================-->
                  <!-- Acquisition/Sessions Start -->
                  <!--================================--> 				  
                  <div class="row row-xs">
                     <div class="col-xl-4">
                     </div>
                     <!-- Acquisition/Sessions End -->
                     <!--================================-->
                     <!-- Payment Details Start -->
                     <!--================================--> 		
                     <div class="col-md-12 col-xl-12">
                        <div class="card mg-b-20">
                           <div class="card-header">
                              <h4 class="card-header-title">
                                 Payment Details
                              </h4>
                              
                           </div>
                           <div class="card-body pd-0 collapse show" id="PaymentDetails">
                              <div class="table-responsive">
                                 <table class="table table-hover mg-0">
                                    <thead class="tx-dark tx-uppercase tx-10 tx-bold">
                                       <tr>
                                          <th>User</th>
                                          
                                          <th>Earning</th>
                                          <th class="tx-right">Action</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                      
                                    <?php
// Assuming you have already connected to the database

// Fetch payment records and calculate total amount for each user
$quey = "SELECT db_email, SUM(totalAmount) AS totalAmount FROM payment GROUP BY db_email ORDER BY totalAmount DESC ";
$result = mysqli_query($connection, $quey);

// Display total amount for each user
while ($row = mysqli_fetch_assoc($result)) {
    $db_email = $row['db_email'];
    $totalAmount = $row['totalAmount'];

    echo '<tr>';
    echo '<td class="d-flex align-items-center">';
    echo '<div class="d-block">';
    echo '<a href="" class="my-0 mt-1 tx-13">' . $db_email . '</a>';
    echo '</div>';
    echo '</td>';

    echo '<td>';
    echo '<a href="" class="my-0 mt-1 tx-13">$' . $totalAmount . '</a>';
    echo '<p class="tx-12 mb-0 tx-gray-500">Total Sales</p>';
    echo '</td>';

    echo '<td class="tx-right">';
    echo '<a href="mailto:' . $db_email . '" class="btn btn-sm btn-label-success">Contact</a>';
    echo '</td>';

    echo '</tr>';
    
    
}
?>


                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <footer class="page-footer">
               <div class="pd-t-4 pd-b-0 pd-x-20">
                  <div class="tx-10 tx-uppercase">
                     <p class="pd-y-10 mb-0"> All copyrights reservet @BOOKSTORE    </p>
                  </div>
               </div>
            </footer>
            <!--/ Page Footer End -->		
         </div>
         <!--/ Page Content End -->
      </div>

      

      <!-- Footer Script -->
      <!--================================-->
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