 <?php
   require './../config/db.php';
   // handle new user attendance
   $index_no = htmlspecialchars($_POST['index_no']);
   $name = htmlspecialchars($_POST['name']);
   $email = htmlspecialchars($_POST['email']);
   // checking for empty fields
   if(empty($index_no) || empty($name) || empty($email)){
   header("Location: ./../index.php?msg=All fields are required&type=error&index_no=".$index_no."&name=".$name."&email=".$email);
   exit();
   } else {
   // complete the insertion into table
   $query = "INSERT INTO attendance(index_no,full_name,email,arrival_time) VALUES ('$index_no','$name','$email',now());";
   if(!$result = mysqli_query(mysql: $conn,query: $query)){
   mysqli_error($conn);
   header("Location: ./../index.php?msg=An error occured while adding&type=error&index_no=".$index_no."&name=".$name."&email=".$email);
   exit();
   }else {
   header("Location: ./../index.php?msg=Attendance recorded successfully&type=success");
   }
   }
?>
