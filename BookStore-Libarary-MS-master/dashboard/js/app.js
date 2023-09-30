let bookName = document.getElementById('bookName');
let authorName = document.getElementById('authorName');
let price = document.getElementById('price');
let category = document.getElementById('category');
let description = document.getElementById('description');
let qty = document.getElementById('qty');
let image = document.getElementById('image');
let add = document.getElementById('add');

showData();

add.onclick = function addBook() {
    let formData = new FormData();
    formData.append('bookName', bookName.value);
    formData.append('authorName', authorName.value);
    formData.append('price', price.value);
    formData.append('category', category.value);
    formData.append('description', description.value);
    formData.append('qty', qty.value);
    formData.append('image', image.files[0]);

    if (bookName.value && authorName.value && price.value && category.value && description.value && qty.value && image.files[0]) {
        $.ajax({
            url: 'add_book.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (data, status) {
                console.log(status);
                showData();
                clearData();
                document.getElementById('alert').innerHTML = '<div class="remove alert alert-success">Book successfully added!</div>';
                removeAlert();
            },
            error: function (error) {
                console.error('Error sending data:', error);
                document.getElementById('alert').innerHTML = '<div class="remove alert alert-danger">Error sending data</div>';
                removeAlert();
            }
        });
    } else {
        document.getElementById('alert').innerHTML = '<div class="remove alert alert-danger">Please fill out all fields</div>';
        removeAlert();
    }
};
function removeAlert(){
    setTimeout(function() {
      let alertElement = document.querySelector('.remove');
      console.log(alertElement)
      alertElement.classList.add('fade-out');
      setTimeout(function() {
        alertElement.style.display = 'none';
      }, 500);
    }, 3000);
  }

function showData() {
    $.ajax({
        url: 'get_books.php',
        method: 'GET',
        success: function (data) {
            let tableRows = '';
            let counter = 0;
            let count;

            data.forEach(function (book) {
                count = data.length;
                counter++;
                tableRows += `
                <input type="hidden" id="bookDesc${book.bookId}" value="${book.bookDesc}">
                <input type="hidden" id="catId${book.bookId}" value="${book.categoryId}">
                    <tr>
                        <td>${counter}</td>
                        <td id="bookImg${book.bookId}"><img src="../uploads/${book.bookImg}" alt="Book Image" class="book-image" width="100px"></td>
                        <td id="bookName${book.bookId}">${book.bookName}</td>
                        <td id="authorName${book.bookId}">${book.authorName}</td>
                        <td id="bookPrice${book.bookId}">${book.bookPrice}</td>
                        <td id="borrowPrice${book.bookId}">${book.borrowPrice}</td>
                        <td id="categoryName${book.bookId}">${book.categoryName}</td>
                        <td id="quantity${book.bookId}">${book.quantity}</td>
                        <td>
                            <div class="center d-flex ">
                                <button id="updateBook${book.bookId}" onclick="updateBook(${book.bookId})" class="update btn btn-warning m-1" style="background-color: #FCB940; border: none;"><i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i></button>
                                <button id="saveBook${book.bookId}" onclick="saveBook(${book.bookId})" class="save btn btn-secondary mb-1 d-none fixed-top" style="background-color: #FCB940; border: none;">Save</button>
                                <button data-toggle="modal" data-target="#confirmationModal" onclick="deleteBook(${book.bookId})" class="delete btn btn-danger m-1" style="background-color: #C12E2A; border: none;"><i class="fa-regular fa-trash-can" style="color: #ffffff;"></i></button>
                            </div>
                        </td>
                    </tr>`;

            });
            document.getElementById('info').innerHTML = tableRows;
            document.getElementById('count').innerHTML = `There are <b> ${count} </b> different books.`;
        },
        error: function (error) {
            console.error('Error retrieving book data:', error);
        }
    });
}

function clearData() {
    bookName.value = '';
    authorName.value = '';
    price.value = '';
    category.value = '';
    description.value = '';
    qty.value = '';
    image.value = '';
}

function deleteBook(bookId) {
    document.getElementById('confirmDelete').addEventListener('click', function() {
        $.ajax({
          url: 'delete_book.php',
          method: 'POST',
          data: {
            id: bookId
          },
          success: function(response) {
            console.log(response);
            showData();
          },
          error: function(status, error) {
            console.error('Error deleting data:', error);
          }
        });
              $('#confirmationModal').modal('hide');
      });
      $('#confirmationModal').on('hidden.bs.modal', function() {
        console.log('Deletion cancelled.');
      });
    }
  
function updateBook(bookId) {
    bookName.value = document.getElementById(`bookName${bookId}`).innerHTML;
    authorName.value = document.getElementById(`authorName${bookId}`).innerHTML;
    price.value = document.getElementById(`bookPrice${bookId}`).innerHTML;
    category.value = document.getElementById(`catId${bookId}`).value;
    description.value = document.getElementById(`bookDesc${bookId}`).value;
    qty.value = document.getElementById(`quantity${bookId}`).innerHTML;

    document.getElementById(`updateBook${bookId}`).classList.add('d-none');
    document.getElementById(`saveBook${bookId}`).classList.remove('d-none');
    document.getElementById("add").classList.add('d-none');
    document.getElementById("add_update").innerHTML="Update Book";

    scroll({
    top:0,
    behavior:'smooth',
    })
}

function saveBook(bookId) {
    let formData = new FormData();
    formData.append('bookId', bookId);
    formData.append('bookName', bookName.value);
    formData.append('authorName', authorName.value);
    formData.append('price', price.value);
    formData.append('category', category.value);
    formData.append('description', description.value);
    formData.append('qty', qty.value);
    formData.append('image', image.files[0]);

    if (bookName.value && authorName.value && price.value && category.value && description.value && qty.value && image.files[0]) {
        $.ajax({
            url: 'update_book.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                document.getElementById("add").classList.remove('d-none');
                showData();
                clearData();
                document.getElementById("add_update").innerHTML="Add Book";
                document.getElementById('alert').innerHTML = '<div class="remove alert alert-success">Book successfully updated.</div>';
                removeAlert();
            },
            error: function (status, error) {
                console.error('Error updating data:', error);
                document.getElementById('alert').innerHTML = '<div class="remove alert alert-danger">Error updating data.</div>';
                removeAlert();
            }
        });
    } else {
        console.error('Please fill out all required fields.');
        document.getElementById('alert').innerHTML = '<div class="remove alert alert-danger">Please fill out all required fields.</div>';
        removeAlert();
    }
}

//Search
let searchMood = 'name';

function getSearchMood(id){

    let search = document.getElementById('search');
    if(id == 'searchName'){
        searchMood = 'name';
        search.placeholder = 'Search By Name';
    }else if(id == 'searchCategory'){
        searchMood = 'category'
        search.placeholder = 'Search By Category';
    }else{
        searchMood = 'author'
        search.placeholder = 'Search By Author'; 
    }
    search.focus();
    search.value = '';
    showData();
}

function searchBook(value) {
    $.ajax({
        url: 'get_books.php',
        method: 'GET',
        success: function (data) {
            let tableRows = '';
            for (let i = 0; i < data.length; i++) {
            let book = data[i];

            if (searchMood === 'name') {
                    if (book.bookName.toLowerCase().includes(value)) {
                        tableRows += `
                        <input type="hidden" id="bookDesc${book.bookId}" value="${book.bookDesc}">
                        <input type="hidden" id="catId${book.bookId}" value="${book.categoryId}">
                        <tr>
                            <td>${i + 1}</td>
                            <td id="bookImg${book.bookId}"><img src="../uploads/${book.bookImg}" alt="Book Image" class="book-image" width="100px"></td>
                            <td id="bookName${book.bookId}">${book.bookName}</td>
                            <td id="authorName${book.bookId}">${book.authorName}</td>
                            <td id="bookPrice${book.bookId}">${book.bookPrice}</td>
                            <td id="borrowPrice${book.bookId}">${book.borrowPrice}</td>
                            <td id="categoryName${book.bookId}">${book.categoryName}</td>
                            <td id="quantity${book.bookId}">${book.quantity}</td>
                            <td>
                                <div class="center d-flex">
                                    <button id="updateBook${book.bookId}" onclick="updateBook(${book.bookId})" class="update btn btn-warning m-1" style="background-color: #FCB940; border: none;"><i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i></button>
                                    <button id="saveBook${book.bookId}" onclick="saveBook(${book.bookId})" class="save btn btn-secondary mb-1 d-none fixed-top" style="background-color: #FCB940; border: none;">Save</button>
                                    <button data-toggle="modal" data-target="#confirmationModal" onclick="deleteBook(${book.bookId})" class="delete btn btn-danger m-1" style="background-color: #C12E2A; border: none;"><i class="fa-regular fa-trash-can" style="color: #ffffff;"></i></button>
                                </div>
                            </td>
                        </tr>`;
                    }
            }else if (searchMood === 'category'){
                if (book.categoryName.toLowerCase().includes(value)) {
                    tableRows += `
                    <input type="hidden" id="bookDesc${book.bookId}" value="${book.bookDesc}">
                    <input type="hidden" id="catId${book.bookId}" value="${book.categoryId}">
                    <tr>
                        <td>${i + 1}</td>
                        <td id="bookImg${book.bookId}"><img src="../uploads/${book.bookImg}" alt="Book Image" class="book-image" width="100px"></td>
                        <td id="bookName${book.bookId}">${book.bookName}</td>
                        <td id="authorName${book.bookId}">${book.authorName}</td>
                        <td id="bookPrice${book.bookId}">${book.bookPrice}</td>
                        <td id="borrowPrice${book.bookId}">${book.borrowPrice}</td>
                        <td id="categoryName${book.bookId}">${book.categoryName}</td>
                        <td id="quantity${book.bookId}">${book.quantity}</td>
                        <td>
                            <div class="center d-flex">
                                <button id="updateBook${book.bookId}" onclick="updateBook(${book.bookId})" class="update btn btn-warning m-1" style="background-color: #FCB940; border: none;"><i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i></button>
                                <button id="saveBook${book.bookId}" onclick="saveBook(${book.bookId})" class="save btn btn-secondary mb-1 d-none fixed-top" style="background-color: #FCB940; border: none;">Save</button>
                                <button data-toggle="modal" data-target="#confirmationModal" onclick="deleteBook(${book.bookId})" class="delete btn btn-danger m-1" style="background-color: #C12E2A; border: none;"><i class="fa-regular fa-trash-can" style="color: #ffffff;"></i></button>
                            </div>
                        </td>
                    </tr>`;
                        }
            }else{
                if (book.authorName.toLowerCase().includes(value)) {
                    tableRows += `
                    <input type="hidden" id="bookDesc${book.bookId}" value="${book.bookDesc}">
                    <input type="hidden" id="catId${book.bookId}" value="${book.categoryId}">
                    <tr>
                        <td>${i + 1}</td>
                        <td id="bookImg${book.bookId}"><img src="../uploads/${book.bookImg}" alt="Book Image" class="book-image" width="100px"></td>
                        <td id="bookName${book.bookId}">${book.bookName}</td>
                        <td id="authorName${book.bookId}">${book.authorName}</td>
                        <td id="bookPrice${book.bookId}">${book.bookPrice}</td>
                        <td id="borrowPrice${book.bookId}">${book.borrowPrice}</td>
                        <td id="categoryName${book.bookId}">${book.categoryName}</td>
                        <td id="quantity${book.bookId}">${book.quantity}</td>
                        <td>
                            <div class="center d-flex">
                                <button id="updateBook${book.bookId}" onclick="updateBook(${book.bookId})" class="update btn btn-warning m-1" style="background-color: #FCB940; border: none;"><i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i></button>
                                <button id="saveBook${book.bookId}" onclick="saveBook(${book.bookId})" class="save btn btn-secondary mb-1 d-none fixed-top" style="background-color: #FCB940; border: none;">Save</button>
                                <button data-toggle="modal" data-target="#confirmationModal" onclick="deleteBook(${book.bookId})" class="delete btn btn-danger m-1" style="background-color: #C12E2A; border: none;"><i class="fa-regular fa-trash-can" style="color: #ffffff;"></i></button>
                            </div>
                        </td>
                    </tr>`;
                        }
            }
            }
            if (tableRows === '') {
                tableRows = '<tr><td colspan="9">No results found.</td></tr>';
            }
            document.getElementById('info').innerHTML = tableRows;
        },
        error: function (status, error) {
            console.log(error);
        }
    });
}

