<?php
session_start();
?>

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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<input type="hidden" id="stripe-public-key" value="pk_test_51NDMZAAPLZ19AnSneOeqMZEiTH0nr6J1pWg0C5V0oJFmM1buqqdu2Kzn3Da7HRhPXgkO74tRqvHYCkHvjlRp5pji00ExkANJXm" />
<input type="hidden" id="stripe-payment-intent" value="" />
 
<div id="stripe-card-element" style="margin-top: 20px; margin-bottom: 20px;"></div>
 
<button type="button" onclick="payViaStripe();">Pay via stripe</button>
 
<input type="hidden" id="user-email" value="support@adnan-tech.com" />
<input type="hidden" id="user-name" value="AdnanTech" />
<input type="hidden" id="user-mobile-number" value="123456789" />
 
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
                console.log(data.error);
            }
        })
        .catch(function(error) {
            console.log(error);
        });
    });

 // ...

 function payViaStripe() {
    const stripePaymentIntent = document.getElementById("stripe-payment-intent").value;

    // execute the payment
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
        // Handle result.error or result.paymentIntent
        if (result.error) {
            alert("Wrong input");
        } else {

            // Update the payment table and remove quantity from addcart table
            if (result.paymentIntent.status === 'succeeded') {
                // Pass the total amount to the updatePaymentTable function
                
                updatePaymentTable(result.paymentIntent.id, result.paymentIntent.amount);
              
                
            }
        }
    });
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
    xhr.send("totalAmount=" + totalAmount);
    window.location.href = 'index.php';

}


   
</script>
