<?php
include 'connection.php';

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
    <title>Feedbacks</title>
    
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
                <h1> All Feedbacks </h1>
                <br>

<table class="table table-striped">
<thead class="yellow">
<tr>
        <th style="color: #fff;">Book Name</th>
        <th style="color: #fff;">Book ID</th>
        <th style="color: #fff;">Title</th>
        <th style="color: #fff;">Description</th>
        <th style="color: #fff;">User Email</th>
        <th style="color: #fff;">Action</th>
    </tr>
    </thead>    
    <?php
    include 'connection.php';

    if (isset($_POST['deleteFeedbackId'])) {
        $deleteFeedbackId = $_POST['deleteFeedbackId'];

        // Prepare the delete query
        $deleteQuery = "DELETE FROM feedback WHERE id = $deleteFeedbackId";

        // Execute the delete query
        if (mysqli_query($connection, $deleteQuery)) {
            echo 'Feedback deleted successfully.';
        } else {
            echo 'Error deleting feedback: ' . mysqli_error($connection);
        }
    }

    // Récupérer tous les commentaires
    $requete = "SELECT b.book_name, b.book_id, f.id, f.feedback_title, f.feedback_desc, f.user_email, f.book_id, CONCAT(r.db_fname, ' ', r.db_lname) AS user_name
        FROM feedback f
        INNER JOIN register r ON f.user_email = r.db_email
        INNER JOIN books b ON f.book_id = b.book_id
        ORDER BY f.id DESC";

    $resultat = mysqli_query($connection, $requete);

    while ($ligne = mysqli_fetch_assoc($resultat)) :
    ?>
        <tr>
            <td><?php echo $ligne['book_name']; ?></td>
            <td><?php echo $ligne['book_id']; ?></td>
            <td><?php echo $ligne['feedback_title']; ?></td>
            <td><?php echo $ligne['feedback_desc']; ?></td>
            <td><?php echo $ligne['user_email']; ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="deleteFeedbackId" value="<?php echo $ligne['id']; ?>">
                    <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>

    <?php
    mysqli_close($connection);
    ?>
</table>
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
