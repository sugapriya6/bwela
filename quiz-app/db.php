<?php
   $conn = new mysqli("localhost","root","Hema@5541","quizdb");
   if($conn->connect_error){
    die ("connection failed" .$conn->connect_error);
   }
   ?>
