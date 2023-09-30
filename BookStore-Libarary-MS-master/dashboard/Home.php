<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Section</title>
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
       include 'sidebar.php';
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
                    <h1 class="text-secondary mx-auto ">Home Section</h1>
                    <?php
                    if (isset($_GET['done'])) {
                      echo "Submitted successfuly";
                    }
                    if (isset($_GET['error'])) {
                      echo "Please Make Sure To Fill Everything";
                    }
                    ?>
                    <form method='POST' action='home_action.php' enctype="multipart/form-data" onsubmit="return validateDescription();">
                      
                      
                      <div class="row d-flex justify-content-center">
                      <div class="col-md-6 col-xl-6">
                        <div class="form-group">
                        <label for="image" class="text-secondary">Book Image: (Note:image 1 behind the text)</label>

                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="exampleInputFile" name="image1">
                            <label class="custom-file-label" for="exampleInputFile">Image </label>
                          
                          </div> 
                        </div>
                          
                        
                          <div class="form-group col-md-12 col-xl-12">
                            <label for="description" class="text-secondary"> Description:</label>
                            <textarea class="form-control" id="description" name="desc1" placeholder="Enter Description"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-md-6 col-xl-6">
                    <select class="form-control" id="category" name="category1" style="display:none;">
                      <?php 
                      require("connection.php");

                      $sql="SELECT * FROM categories";
                            $result=mysqli_query($connection,$sql);
                           while ($row=mysqli_fetch_assoc($result)) {
                          
                            } ?>
                      
                    </select>
                    
                  </div>     
                  <hr>
                  <div class="row d-flex justify-content-center">
                    <div class="col-md-6 col-xl-6">
                      <div class="form-group">
                      <label for="image" class="text-secondary">Book Image: (Note:image 2)</label>

                      <div class="custom-file">
                          <input type="file" class="custom-file-input" id="exampleInputFile" name="image2">
                          <label class="custom-file-label" for="exampleInputFile">Image </label>
                        
                        </div> 
                      </div>
                        
                      
                        <div class="form-group col-md-12 col-xl-12">
                          <label for="description" class="text-secondary"> Description:</label>
                          <textarea class="form-control" id="description" name="desc2"  placeholder="Enter Description"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-6 col-xl-6 ">
                  <label for="category" class="text-secondary">Category 2:</label>
                  <select class="form-control " id="category" name="category">
                 <?php  
                  $sql="SELECT * FROM categories";
                            $result=mysqli_query($connection,$sql);
                           while ($row=mysqli_fetch_assoc($result)) {
                          
                      ?>
                      <option value="<?php echo $row['category_name']   ?>"><?php echo $row['category_name']   ?></option>
                      <?php
                           }
                      ?>
                  </select>
                  
                </div>       
                <div id="alertContainer"></div>
   
                               <button type="submit" class="btn btn-success mt-2">Submit</button>
                          </div>
                      </div>
                      
                      
                      
                    </form>
                  </div>
                </div>








                <script>
  function validateDescription() {
    var textarea = document.getElementById('description');
    var words = textarea.value.trim().split(/\s+/);
    
    if (words.length < 65 && words.length > 100) {
      $(document).ready(function() {
      var errorMessage = "Please enter between 65 words and 100 in the description.";
      var alertBox = $('<div class="alert alert-danger" role="alert">' + errorMessage + '</div>');
      $("#alertContainer").append(alertBox);
    });
     return false;
    }
    
    return true;
  }
</script>

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