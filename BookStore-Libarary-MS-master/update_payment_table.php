<?php
require_once('payment/vendor/autoload.php');
require("connection.php");

session_start();

$email = $_SESSION['email'];
$query = "SELECT * FROM addcart a
JOIN books b ON a.cart_book_id = b.book_id
WHERE cart_user_email = ?";

$stmt = mysqli_prepare($connection, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 's', $email);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $purchaseAmount = 0;
        $borrowAmount = 0;

        while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['cart_book_id'];
                $qw="SELECT SUM(cart_qty) AS cartfull FROM addcart WHERE cart_user_email='$email' AND cart_book_id='$id'";
                $qr=mysqli_query($connection,$qw);
                $q=mysqli_fetch_assoc($qr);
                $product_name = $row['book_name'];
                $quantity = $row['cart_qty'];
                $fullquantity=$q['cartfull'];
                $price = $row['total'];
                $borrow = $row['status_book'];
                $checkQuery = "SELECT quantity FROM books WHERE book_id = ?";
                $checkStmt = mysqli_prepare($connection, $checkQuery);
                mysqli_stmt_bind_param($checkStmt, 's', $id);
                mysqli_stmt_execute($checkStmt);
                $checkResult = mysqli_stmt_get_result($checkStmt);
                $row = mysqli_fetch_assoc($checkResult);
                $bookQuantity = $row['quantity'];
                
                if ($bookQuantity >= $fullquantity) {
                    
                        
                    
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['functionName']) && $_POST['functionName'] === 'specificFunction') {
                            // The request is coming from the specific function, proceed with the code execution
                        
                            if (isset($_POST['fromDate']) && isset($_POST['toDate']) && isset($_POST['title'])) {
                                // Get the input values from the AJAX request
                                $fromDate = $_POST['fromDate'];
                                $toDate = $_POST['toDate'];
                                $title = $_POST['title'];
                                $select="SELECT * FROM borrows WHERE db_email='$email' AND db_bookname='$title' AND status=0";
                               $se= mysqli_query($connection,$select);
                        if (mysqli_num_rows($se)>0) {
                            $sqlInsertBorrow = "UPDATE borrows SET db_borrowfrom='$fromDate',db_borrowto='$toDate' WHERE db_email='$email' AND db_bookname='$title'";
                                    mysqli_query($connection,$sqlInsertBorrow);
                                    echo "done";
                                exit();
                        }else {
                            $sqlInsertBorrow = "INSERT INTO borrows (db_email, db_bookname, db_borrowfrom, db_borrowto) 
                                VALUES ('$email', '$title', '$fromDate', '$toDate')";
                                    mysqli_query($connection,$sqlInsertBorrow);
                                    echo "done";
                                exit();
                        }
                                
                            } 
                            echo "exit";
                            exit();
                        }
                        
                     
                        if ($_POST['functionName'] === 'updatePaymentTable') {
                            $sql="UPDATE borrows SET status=1 WHERE db_email='$email' AND db_bookname='$product_name'";
                            $ryo=mysqli_query($connection,$sql);
                            if (!isset($ryo)) {
                                exit();
                            }
                $insertQuery = "INSERT INTO payment (totalAmount, productId, productName, quantity, paymentType, db_email) VALUES (?, ?, ?, ?, ?, ?)";
                $insertStmt = mysqli_prepare($connection, $insertQuery);
                mysqli_stmt_bind_param($insertStmt, 'dssdss', $price, $id, $product_name, $quantity, $borrow, $email);
                mysqli_stmt_execute($insertStmt);

                    $updateQuery = "UPDATE books SET quantity = quantity - ? WHERE book_id = ?";
                    $updateStmt = mysqli_prepare($connection, $updateQuery);
                    mysqli_stmt_bind_param($updateStmt, 'ds', $quantity, $id);
                    mysqli_stmt_execute($updateStmt);

                    $drop="DELETE FROM addcart WHERE cart_user_email = '$email' AND cart_book_id='$id'";
                    mysqli_query($connection,$drop);

          $smtpApiKey = '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';
  
          $url = 'https://api.sendinblue.com/v3/smtp/email';
          $data = array(
              'sender' => array(
                  'name' => 'book',
                  'email' => 'bookstore979@gmail.com'
              ),
              'to' => array(
                  array('email' => $email)
              ),    
              'subject' => 'Thanks for '.$borrow.' '.$product_name.'',
              'htmlContent' => 'Hope your good with our Services'
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

          echo "paied";
        }
        }} 
            
        }
    } else {
        header("location:invoice.php?er"); 

    }



mysqli_stmt_close($stmt);
mysqli_close($connection);
?>
