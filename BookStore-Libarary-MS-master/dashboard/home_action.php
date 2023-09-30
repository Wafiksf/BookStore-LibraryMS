<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require("connection.php");
    
        if (isset($_POST['category'], $_POST['desc1'], $_FILES['image1'], $_POST['desc2'], $_FILES['image2'])) {
            $category = $_POST['category'];
            $desc1 = $_POST['desc1'];
            $imageName1 = $_FILES['image1']['name'];
            $image_tmp1 = $_FILES['image1']['tmp_name'];
    
            $desc2 = $_POST['desc2'];
            $image2 = $_FILES['image2'];
    
            $imageName2 = $_FILES['image2']['name'];
            $image_tmp2 = $_FILES['image2']['tmp_name'];
    
            
    
            $sql = "UPDATE home SET db_image1='$imageName1', db_text1='$desc1', db_image2='$imageName2', db_text2='$desc2', category_name='$category'";
            mysqli_query($connection, $sql);
    
            move_uploaded_file($image_tmp1, "lms/uploads/" . $imageName1);
            move_uploaded_file($image_tmp2, "lms/uploads/" . $imageName2);
    
    
            header("Location: home.php?done");
            
        } else {
            header("Location: home.php?error");
        }
    } else {
        header("Location: home.php");
    }
}
?>
