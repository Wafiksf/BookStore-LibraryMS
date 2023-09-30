function showEditNameDiv() {
  document.getElementById("editDiv").style.display = "block";
  document.getElementById("editContent").innerHTML = `
    <form id="editNameForm" action="updatename_action.php" method="POST">
      <div class="form-group">
        <label for="firstName" style="font-weight: bold; float: left;">New first name:</label>
        <input type="text" class="form-control" id="firstName" name="newfname" placeholder="New first name">
      </div>
      
      <div class="form-group">
        <label for="lastName" style="font-weight: bold; float: left;">New last name:</label>
        <input type="text" class="form-control" id="lastName" name="newlname" placeholder="New last name">
      </div>
      <button type="submit" class="btn btn-primary" id="btn-primary1">Save Name</button>
    </form>`;
}

function hideEditDiv() {
  document.getElementById("editDiv").style.display = "none";
  document.getElementById("editContent").innerHTML = "";
}

function showResetPasswordDiv() {
  document.getElementById("editDiv").style.display = "block";
  document.getElementById("editContent").innerHTML = `
    <form id="resetpassword" action="resetpassword_action.php" method="POST">
      <div class="form-group">
        <label for="currentPassword" style="font-weight: bold; float: left;">Current password:</label>
        <input type="password" class="form-control" name="curpass" id="currentPassword" placeholder="Current password">
      </div>
      
      <div class="form-group">
        <label for="newPassword" style="font-weight: bold; float: left;">New password:</label>
        <input type="password" class="form-control" name="newpass" id="newPassword" placeholder="New password">
      </div>

      <div class="form-group">
        <label for="confirmPassword" style="font-weight: bold; float: left;">Confirm password:</label>
        <input type="password" class="form-control" name="conpass" id="confirmPassword" placeholder="Confirm password">
      </div>
      <button type="submit" class="btn btn-primary" id="btn-primary2">Save Password</button>
    </form>`;
}

