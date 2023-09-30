<?php
include 'connection.php';

session_start();

if (!isset($_SESSION['email'])) {
    header("location:login.php");
    exit();
}
$email=$_SESSION['email'];
date_default_timezone_set('Asia/Beirut');
$currentDateTime = date("Y-m-d H:i:s");

// Select reservations that have already ended
$reservationQuery = "SELECT * FROM reservation WHERE db_time2 < '$currentDateTime' AND status=1";
$reservationResult = mysqli_query($connection, $reservationQuery);

while ($row = mysqli_fetch_assoc($reservationResult)) {
    $room = $row['db_room'];
    $quantity = $row['db_capacity'];

    $updateCapacityQueryy = "UPDATE reservation SET status=0 WHERE db_time2 < '$currentDateTime' AND db_date<'$currentDateTime'";
    mysqli_query($connection, $updateCapacityQueryy);

    
}



// Function to validate the date format (YYYY-MM-DD)
function validateDate($date) {
    $datePattern = "/^\d{4}-\d{2}-\d{2}$/";
    return preg_match($datePattern, $date);
}

// Function to validate the time format (HH:MM) and duration
function validateTime($time, $time2) {
    $timePattern = "/^([01]\d|2[0-3]):[0-5]\d$/";
    if (!preg_match($timePattern, $time) || !preg_match($timePattern, $time2)) {
        return false;
    }

    $startTime = strtotime($time);
    $endTime = strtotime($time2);
    $durationMinutes = round(($endTime - $startTime) / 60); // Calculate duration in minutes

    // Check if the duration is within the allowed range
    if ($durationMinutes < 30 || $durationMinutes > 120 || $durationMinutes % 30 !== 0) {
        return false;
    }

    return true;
}

// Function to check if the date is in the past
function isPastDate($date) {
    $currentDate = date("Y-m-d");
    return ($date < $currentDate);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room = $_POST['room'];
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $time2 = $_POST['time2'];
    $email = $_SESSION['email'];
    $errors = [];

    if (!validateDate($date)) {
        $errors[] = "Invalid date format. Please enter a valid date.";
    } elseif (isPastDate($date)) {
        $errors[] = "You cannot reserve a room for a past date.";
    } elseif (!validateTime($time, $time2)) {
        $errors[] = "Invalid time format or duration. Please enter a valid time and make sure the duration is a multiple of 30 minutes within the range of 30 minutes to 2 hours.";
    } elseif (strtotime($time) >= strtotime($time2)) {
        $errors[] = "The start time must be earlier than the end time.";
    } else {
        // Check for overlapping reservations
        $query = "SELECT SUM(db_capacity) AS total_capacity 
        FROM reservation 
        WHERE db_date = '$date' 
        AND ((db_time <= '$time' AND db_time2 > '$time') OR (db_time < '$time2' AND db_time2 >= '$time2')) 
        AND status = 1";

              $roomcp = "SELECT * FROM room WHERE db_room = '$room'";
              $roomRslt = mysqli_query($connection, $roomcp);
              $roomDt = mysqli_fetch_assoc($roomRslt);
              $roomCapacity = $roomDt['db_capacity'];

    $result = $connection->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total_capacity = $row['total_capacity'];
        if ($total_capacity === null) {
            $total_capacity = 0;
        }
        $space=$roomCapacity-$total_capacity;

        if ($total_capacity + $quantity <= $roomCapacity) {

          $verificationCode = sha1(uniqid(rand(), true));
          $smtpApiKey = '';
  
          $url = '';
          $data = array(
              'sender' => array(
                  'name' => 'book',
                  'email' => ''
              ),
              'to' => array(
                  array('email' => $email)
              ),
              'subject' => 'Verify yor reservation',
              'htmlContent' => 'Click the link below to verify your reservation: <a href="http://localhost/lms/verifyreservation.php?code=' . $verificationCode . '">Verification Link</a>'
          );
          
          $headers = array(
              'Content-Type: application/json',
              'api-key: ' . $smtpApiKey
          );
  
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_exec($ch);
          curl_close($ch);

            $insertReservationQuery = "INSERT INTO reservation (db_room, db_email, db_capacity, db_date, db_time, db_time2,verification_code) VALUES ('$room','$email', '$quantity', '$date', '$time', '$time2','$verificationCode')";
            $result = mysqli_query($connection, $insertReservationQuery);


           $verifyy =  "Please verfiy your reservation";
            

            

            // if (!$result) {
            //     $errors[] = "Error inserting reservation into the database: " . mysqli_error($connection);
            // }
        
        } else {
          $errors[] =  "Sorry, no spaces available the available space at this date and time is $space.";
        }
        }
        
    }
}
if (isset($_GET['verified']) && isset($_GET['code'])) {
  $id=$_GET['verified'];
  $code=$_GET['code'];
  $fetchStatusQuery = "SELECT status,db_capacity FROM reservation WHERE id='$id' AND verification_code='$code'";
  $rslt = mysqli_query($connection, $fetchStatusQuery);
  $row = mysqli_fetch_assoc($rslt);
  if (!empty($row)) {
    $status = $row['status'];
    $quantity = $row['db_capacity'];
   
  if ($status==1) {
   
   
   $preventing="UPDATE reservation SET verification_code='-1' WHERE status=1";
   mysqli_query($connection, $preventing);

  }}
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/room.css">
  <title>Reservation</title>
  
</head>

<body>
<?php
include 'header.php';
?>
  <div class="description">
    <h1>Library Reservation Room</h1>
    <p>Welcome to the Bookstore's Room Reservation Section! We offer a variety of unique rooms for your specific needs. Whether you need a quiet study space or a vibrant room for discussions, we have you covered. Choose from our thoughtfully designed rooms, each with its own ambiance and features. Our reservation process is simple and convenient. Book your preferred room, date, and time slot. We offer flexible booking options, allowing reservations starting from half an hour up to a maximum of two hours. You can even choose to extend your reservation by adding additional half-hour increments. Join us at the Bookstore and experience our welcoming and inspiring spaces. Happy reading!</p>
  </div>

  <div class="res-container">
    <div class="res-container2">
      <h2 class="res-h2">Room Reservation</h2>
      <?php
      
      if (!empty($errors)) {
        echo '<div class="error-message">';
        foreach ($errors as $error) {
          echo $error . "<br>";
        }
        echo '</div>';
      }
      if (isset($_GET['verified'])&& isset($_GET['code'])) {
        echo '<div class="text-success">';
        
          echo "Thanks for verfying your Reservation ";
        
        echo '</div>';
      }
      if (!empty($verifyy)) {
        echo '<div class="text-success">';
        
          echo $verifyy;
        
        echo '</div>';
      }
      ?>
     
      <form method="POST" action="">
        <label for="rom">Room:</label><br>
        
        <select id="roo" name="room" class="form-group-ls">
        <?php 
        $sl="SELECT * FROM room";
        $s=mysqli_query($connection,$sl);
        while ($rew=mysqli_fetch_assoc($s)) {
          
        
        ?>
          <option value="<?php echo $rew['db_room']?>"><?php echo $rew['db_room']?></option>
        <?php
        }
        ?>
        </select>
        <div class="form-group">
          <label for="number">Room Capacity:</label>
          <input type="number" name="quantity" min="1" required>
          <label for="date">Date:</label>
          <input type="date" id="date" name="date" required>
          <label for="time">From:</label>
          <input type="time" id="time" name="time" required>
          <label for="time">To:</label>
          <input type="time" id="time" name="time2" required>
        </div>
        <div class="res-btn">
          <button type="submit">Reservation Room</button>
          <button type="reset">Reset</button>
        </div>
      </form>
    </div>
    <div class="image">
      <img src="images/Library (2).gif" alt="library">
    </div>
  </div>

  <?php
include 'footer.php';
?>
 
</body>

</html>