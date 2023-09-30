<?php
include "connection.php";
$currentDate = date("Y-m-d");

$sql = "SELECT * FROM borrows WHERE status = 1 AND email_send=0 AND db_borrowto <= DATE_ADD('$currentDate', INTERVAL 3 DAY)";
$result = mysqli_query($connection, $sql);
if (isset($result)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $borrowerEmail = $row['db_email'];
        $emailMessage = "This is a reminder that your borrowing period is ending soon. Please return the book to the library.\n\nThank you.";
        $smtpApiKey = '';
  
          $url = '';
          $data = array(
              'sender' => array(
                  'name' => 'book',
                  'email' => ''
            ),
            'to' => array(
                array('email' => $borrowerEmail)
            ),    
            'subject' => 'Reminder!!!',
            'htmlContent' => $emailMessage
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

        $sq="UPDATE borrows SET email_send=1 WHERE db_email='$borrowerEmail' AND status=1 AND email_send=0 AND db_borrowto <= DATE_ADD('$currentDate', INTERVAL 3 DAY)";

        mysqli_query($connection,$sq);
    }
}

?>