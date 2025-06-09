<?php 
   require './../config/db.php';
   // **************||HANDLE UPDATE||**************************************//
   //handle UPDATE
      $index_no = htmlspecialchars($_POST['index_no']);
      $name = htmlspecialchars($_POST['name']);
      $email = htmlspecialchars($_POST['email']);
   // remember we turned all the GET request also into POST,
   // as we cannot make two d/f kind of requests as the same time to the server
      $update_id =htmlspecialchars( $_POST['update_id']);
      $arrival_time =htmlspecialchars($_POST['time']);
   // checking for empty fields

   if(empty($index_no) || empty($name) || empty($email))
   {
      header("Location: ./../index.php?msg=All fields are required&type=error&index_no=".$index_no."&name=".$name."&email=".$email);
      exit();
   }
   else 
   {
      // complete the insertion into table
      $query = "UPDATE attendance SET index_no='$index_no',full_name='$name',email='$email' WHERE id='$update_id' and arrival_time='$arrival_time';";

      if(!$result = mysqli_query(mysql: $conn,query: $query)){
         mysqli_error($conn);
               header("Location: ./../index.php?msg=An error occured while updating&type=error&index_no=".$index_no."&name=".$name."&email=".$email."&time=".$arrival_time);
      exit();
         }else {
         header("Location:./../index.php?msg=Attendance updated successfully&type=success");
         exit();
      }
   }
?>