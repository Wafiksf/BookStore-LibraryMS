let cartPlusButtons = document.querySelectorAll('.add-cart');
let modalBookIdInput = document.getElementById('modal-book-id');
let modalQtyInput = document.getElementById('modal-qty'); 

cartPlusButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        let bookId = this.getAttribute('data-bookid');
        let qty = document.getElementById('qty').value; 
        modalBookIdInput.value = bookId;
        modalQtyInput.value = qty; 
    });
});

