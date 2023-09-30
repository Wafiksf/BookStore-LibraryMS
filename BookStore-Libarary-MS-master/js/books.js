    let cartPlusButtons = document.querySelectorAll('.cart-plus-btn');
    let modalBookIdInput = document.getElementById('modal-book-id');
    let cartOptionForm = document.getElementById('cart-option-form');

    cartPlusButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            let bookId = this.getAttribute('data-bookid');
            modalBookIdInput.value = bookId;
        });
    });

    cartOptionForm.addEventListener('submit', function() {
        let modal = document.getElementById('myModal');
        let modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();
    });