<?php
require 'config/db.php';

// handle new user attendance

if (isset($_POST['submit_attendance'])) {
    $index_no = htmlspecialchars($_POST['index_no']);
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);

// checking for empty fields

if(empty($index_no) || empty($name) || empty($email))
{
    header("Location: index.php?msg=All fields are required&type=error&index_no=".$index_no."&name=".$name."&email=".$email);
    exit();
}
else 
{
    // complete the insertion into table
    $query = "INSERT INTO attendance(index_no,full_name,email,arrival_time) VALUES ('$index_no','$name','$email',now());";

    if(!$result = mysqli_query(mysql: $conn,query: $query)){
        mysqli_error($conn);
            header("Location: index.php?msg=An error occured while adding&type=error&index_no=".$index_no."&name=".$name."&email=".$email);
    exit();
        }else {
        header("Location:index.php?msg=Attendance recorded successfully&type=success");
        exit();
    }
 }
}

    // read/fetch from database
    $query = "SELECT id, index_no, full_name, email, arrival_time FROM attendance ORDER BY arrival_time DESC;";

    if(!$fetched_result = mysqli_query(mysql: $conn,query: $query)){
        exit("an error occured while fetching the records");
    }
// delete from database

// update the record
?>

<!-- my html code -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance List</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <link href="styles/style.css" rel="stylesheet">
    
</head>

<body>
    <h1>ATTENDANCE MANAGEMENT SYSTEM(sql crud application)</h1>
    <hr>
<?php if(isset($_GET['msg'])): ?>
    <p id="msg" class="msg msg-<?php echo $_GET['type'];?>"><?php echo $_GET['msg']; ?>!</p>
<?php endif; ?>
<!-- <p style="color:white">Paragraph</p>   -->
    <div class="content-div">
        <form action="index.php" method="post">
            <h2><a href="index.php">Attendance List</a></h2>
             <div class="form-floating">
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Your Name">
                <label for="name">enter your name</label>
            </div>
            <div class="form-floating">
                <input
                type="number"  name="index_no" class="form-control" id="index_no" placeholder="Enter Your Index_No">
                <label for="index_no">enter your index_no</label>
             </div>
        
            <div class="form-floating">
                <input
                type="email" name="email" class="form-control" id="email" placeholder="Enter Your Email">
                <label for="email">enter your email</label>
            </div>
            <button class="btn btn-lg mb-3 mt-3 btn-primary" type="submit" name="submit_attendance" value="Submit">Submit</button>
        </form>
        <!-- display section -->
        <div class="attendance-list">
            <h2>Attendance List (<?php echo mysqli_num_rows($fetched_result);?>) </h2>
            <ul>
                <?php while($student = mysqli_fetch_assoc($fetched_result)): ?>
                <li>
                    <section class="list-content">
                        <p class="name"><?php echo $student['full_name']. "-". $student['index_no'];?></p>
                        <p class="email"><?php echo $student['email'] ;?> </p>
                        <p class="time"><?php echo $student['arrival_time'];?></p>
                    </section>
                    <section class="list-buttons">
                        <a href="#" class="list-update">update</a>
                        <a href="#" class="list-delete">delete</a>
                    </section>
                </li>
                  <?php endwhile; ?>
            </ul>
        </div>
    </div>
</body>

</html>