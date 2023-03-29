<?php
   if (isset($_SESSION['error']) && $_SESSION['error'])
   {
      echo '<div class="alert alert-danger">'.$_SESSION['error'].'</div>';
      unset($_SESSION['error']);
   }
   
   if (isset($_SESSION['success']) && $_SESSION['success'])
   {
      echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>';
      unset($_SESSION['success']);
   }
?>