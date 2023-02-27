<?php
    echo '<script>console.log("Logout Successful")</script>';
    setcookie('PrivatePageLogin', '', time()-3600);
  
    // Redirect the user to the index page
    header("Location: index.php");
    exit();
?>
