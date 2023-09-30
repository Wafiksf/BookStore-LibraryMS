<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];
$sql = "SELECT b.book_name, b.book_price, b.borrow_price, c.cart_qty, c.total, c.status_book
        FROM addcart c
        JOIN books b ON c.cart_book_id = b.book_id WHERE cart_user_email='$email'";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result);

$purchaseTotal = 0;
$borrowTotal = 0;
$overallTotal = 0;

$invoiceRows = '';
$index = 1;




mysqli_close($connection);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link type="text/css" rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="assets/plugins/flag-icon/flag-icon.min.css" />
    <link type="text/css" rel="stylesheet" href="assets/plugins/simple-line-icons/css/simple-line-icons.css">
    <link type="text/css" rel="stylesheet" href="assets/plugins/ionicons/css/ionicons.css">

    <link type="text/css" rel="stylesheet" href="assets/plugins/chartist/chartist.css">
    <link type="text/css" rel="stylesheet" href="assets/plugins/apex-chart/apexcharts.css">
    <link type="text/css" rel="stylesheet" href="assets/css/app.min.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/style.min.css" />
</head>
<?php
include 'header.php';
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
  #stripe-card-element {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #fff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  font-family: Arial, sans-serif;
  width: 300px;
  height: 40px;
}

</style>
<body>

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                        <div class="invoice col-md-12">
                         
                        <h5 class="card-title bd-b pd-y-20 text-center">Invoice</h5>
                            <div class="invoice-company text-inverse f-w-600">
                                Library Book Store
                            </div>
                            <div class="invoice-header ">
                                <div class=" invoice-from ">
                                    <large><b>#From :</b></large>
                                    <address class="m-t-5 m-b-5">
                                        Book Store<br>
                                        123 Street, City<br>
                                        State, Country<br>
                                        Phone: (123) 456-7890
                                    </address>
                                </div>
                                <div class="invoice-to">
                                <large><b>#To :</b></large>
                               <address class="m-t-5 m-b-5">
                                        <?php echo $email; ?>
                                    </address>
                                </div>
                                <div class="invoice-date">
                                <large><b>Invoice Date :</b></large>
                                    <div class="date text-inverse m-t-5">
                                        <?php echo date('Y-m-d'); ?>
                                    </div>
                                    <div class="invoice-detail">
                                    <large><b>Invoice #ID :</b></large>
                                        <div class="date text-inverse m-t-5">
                                            <?php echo uniqid(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-content">
                                <div class="table-responsive">
                                    <table class="table table-invoice">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Status</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                                <th>Due Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT b.book_name, b.book_price, b.borrow_price, c.cart_qty, c.total, c.status_book
                                            FROM addcart c
                                            JOIN books b ON c.cart_book_id = b.book_id WHERE cart_user_email='$email'";
                                    $result = mysqli_query($connection, $sql);
                                            while ($row = mysqli_fetch_array($result)) {
    $title = $row['book_name'];
    $quantity = $row['cart_qty'];
    $status = $row['status_book'];
    $price = ($status == 'purchase') ? $row['book_price'] : $row['borrow_price'];
    $total = $row['total'];

    if ($status == 'purchase') {
        $purchaseTotal += $total;
    } else {
        $borrowTotal += $total;
    }

    $overallTotal += $total;

    $currentDate = date('Y-m-d');
    $maxDueDate = date('Y-m-d', strtotime('+1 month', strtotime($currentDate)));

    echo '<tr>';
    echo '<td>' . $index . '</td>';
    echo '<td>' . $title . '</td>';
    echo '<td>' . $status . '</td>';
    echo '<td>' . $price . ' $</td>';
    echo '<td>' . $quantity . '</td>';
    echo '<td>$' . $total . '</td>';

    if ($status == 'borrow') {
        echo '<td>From <input type="date" class="form-control f" id="from_' . $title . '" name="from_' . $title . '" min="' . $currentDate . '" value="none" required> To <input type="date" class="form-control t" id="to_' . $title . '" name="to_' . $title . '" min="' . $currentDate . '" max="' . $maxDueDate . '" value="none" required></td>';
        echo '<td><button class="btn btn-danger" id="clickupdateButton" onclick="updateTable(\'' . $title . '\')">Update</button></td>';
    } else {
        echo '<td>///</td>';
    }

    echo '</tr>';

    $index++;
} ?>
                                        </tbody>
                                    </table>
                                </div><br>
                                <div class="invoice-price">
                                    <div class="invoice-price-left">
                                        <div class="invoice-price-row">
                                            <div class="sub-price">
                                            <large><b>--Purchase Total :</b></large>
                                                <span class="text-inverse">$<?php echo $purchaseTotal; ?></span>
                                            </div>
                                            <div class="sub-price">
                                            <large><b>--Borrow Total :</b></large>
                                                <span class="text-inverse">$<?php echo $borrowTotal; ?></span>
                                            </div>
                                            <div class="sub-price">
                                            <large><b>--Overall Total :</b></large>
                                                <span class="text-inverse">$<?php echo $overallTotal; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><br>
                            <div class="invoice-note">
                                * Make all cheques payable to Book Store.<br>
                                * Payment is due within 30 days.<br>
                                * If you have any questions concerning this invoice, contact Book Store.<br>
                            </div>
                           </div>
                           <hr>
                         <div class="text-right mg-y-20">
                         <input type="hidden" id="stripe-public-key" value="" />
<input type="hidden" id="stripe-payment-intent" value="" />
 
<div id="stripe-card-element" style="margin-top: 20px; margin-bottom: 20px;"></div>
 
 
<input type="hidden" id="user-email" value="support@adnan-tech.com" />
<input type="hidden" id="user-name" value="AdnanTech" />
<input type="hidden" id="user-mobile-number" value="123456789" />

<div id="alertContainer"></div>
  
                            <button type="submit"  onclick="both()" class="btn btn-primary mg-t-5"><i class="fa fa-dollar"></i> Proceed to payment</button>
                         
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
include 'footer.php';
?>
        
   

    <script src="assets/js/vendor.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/plugins/chartist/chartist.js"></script>
    <script src="assets/plugins/apex-chart/apexcharts.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
 
<script>
    var stripe = null;
    var cardElement = null;
 
    const stripePublicKey = document.getElementById("stripe-public-key").value;
 
    window.addEventListener("load", function () {
        stripe = Stripe(stripePublicKey);
        var elements = stripe.elements();
        cardElement = elements.create('card');
        cardElement.mount('#stripe-card-element');
        
        fetch('create_payment_intent.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (data.clientSecret) {
                document.getElementById("stripe-payment-intent").value = data.clientSecret;
            } else {
                var errorMessage = data.error;
      var alertBox = $('<div class="alert alert-danger" role="alert">' + errorMessage + '</div>');
      $("#alertContainer").append(alertBox);
            
            }
        })
        .catch(function(error) {
            var errorMessage = error;
      var alertBox = $('<div class="alert alert-danger" role="alert">' + errorMessage + '</div>');
      $("#alertContainer").append(alertBox);
            
            
        });
    });

 // ...

 function payViaStripe() {
    const stripePaymentIntent = document.getElementById("stripe-payment-intent").value;
   
    stripe.confirmCardPayment(stripePaymentIntent, {
        payment_method: {
            card: cardElement,
            billing_details: {
                email: document.getElementById("user-email").value,
                name: document.getElementById("user-name").value,
                phone: document.getElementById("user-mobile-number").value,
            },
        },
    }).then(function (result) {
        if (result.error) {
            $(document).ready(function() {
      var errorMessage = "Wrong input";
      var alertBox = $('<div class="alert alert-danger" role="alert">' + errorMessage + '</div>');
      $("#alertContainer").append(alertBox);
    });
        } else {

            if (result.paymentIntent.status === 'succeeded') {
                
                updatePaymentTable(result.paymentIntent.id, result.paymentIntent.amount);
                window.location.href = 'index.php';
                
            }
        }
    });
}


function updateTable(title) {
    // Get the input values
    const fromDate = document.getElementById("from_" + title).value;
    const toDate = document.getElementById("to_" + title).value;

    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
            } else {
                console.log("Failed to update the payment table.");
            }
        }
    };

    xhr.open("POST", "update_payment_table.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("functionName=specificFunction&fromDate=" + fromDate + "&toDate=" + toDate + "&title=" + title);
}


function updatePaymentTable(paymentIntentId, totalAmount) {
    // Send an AJAX request to update the payment table
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
            } else {
                console.log("Failed to update the payment table.");
            }
        }
    };

    xhr.open("POST", "update_payment_table.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("functionName=updatePaymentTable&totalAmount=" + totalAmount);
    
    

 }
 let updateButton = document.getElementById("clickupdateButton");


 function validationborrow() {
    if (updateButton) {
  
updateButton.addEventListener("click", function() {
    updateButton.clicked = true;
  });
  const fromDateInput = document.getElementsByClassName("f");
  const toDateInput = document.getElementsByClassName("t");
  

  if (!fromDateInput && !toDateInput) {
    return true;
  }

  const fromDate = fromDateInput.value;
  const toDate = toDateInput.value;
  
  if (!updateButton.clicked) {
    var errorMessage = "Please enter the inputs and click on the Update button.";
      var alertBox = $('<div class="alert alert-danger" role="alert">' + errorMessage + '</div>');
      $("#alertContainer").append(alertBox);
      
    return false;
  } else if (fromDate === "none" || toDate === "none" || fromDate === "0000-00-00" || toDate === "0000-00-00") {
    var errorMessage = "Please enter both From and To dates.";
      var alertBox = $('<div class="alert alert-danger" role="alert">' + errorMessage + '</div>');
      $("#alertContainer").append(alertBox);
    return false;
  }

  return true;
}else {
    return true;
}
 }



 



function both() {
    validationborrow();
    if (validationborrow()) {
        payViaStripe();
        
        
    }
}
   
</script>
</body>

</html>