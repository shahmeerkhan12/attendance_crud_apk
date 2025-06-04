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
// END IF   

    // read/fetch from database
    $query = "SELECT id, index_no, full_name, email, arrival_time FROM attendance ORDER BY arrival_time DESC;";

    if(!$fetched_result = mysqli_query(mysql: $conn,query: $query)){
        exit("an error occured while fetching the records");
    }
// END IF

// **************||HANDLE UPDATE||**************************************//
//handle UPDATE
if (isset($_POST['update_attendance'])) {
    $index_no = htmlspecialchars($_POST['index_no']);
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);

    $update_id = $_GET['update_id'];
    $arrival_time =$_GET['time'];
// checking for empty fields

if(empty($index_no) || empty($name) || empty($email))
{
    header("Location: index.php?msg=All fields are required&type=error&index_no=".$index_no."&name=".$name."&email=".$email);
    exit();
}
else 
{
    // complete the insertion into table
    $query = "UPDATE attendance SET index_no='$index_no',full_name='$name',email='$email' WHERE id='$update_id' and arrival_time='$arrival_time';";

    if(!$result = mysqli_query(mysql: $conn,query: $query)){
        mysqli_error($conn);
            header("Location: index.php?msg=An error occured while updating&type=error&index_no=".$index_no."&name=".$name."&email=".$email."&time=".$arrival_time);
    exit();
        }else {
        header("Location:index.php?msg=Attendance updated successfully&type=success");
        exit();
    }
 }
}
// ///////|||HANDLE DELETE|||////////////////////////////////////////////////////////////////////////////
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $arrival_time = $_GET['time'];

$query = "DELETE FROM attendance where id='$delete_id' and arrival_time='$arrival_time';";

// execute the query ////////////
  if(!$result = mysqli_query(mysql: $conn,query: $query)){
        mysqli_error($conn);
            header("Location: index.php?msg=An error occured while deleting&type=error");
    exit();
        }else {
        header("Location:index.php?msg=Record deleted successfully&type=success");
        exit();
    }

}
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
        <form action="#" method="post">
            <h2><a href="index.php">Attendance List</a></h2>
             <div class="form-floating">
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Your Name"
                        value="<?php echo isset($_GET['full_name']) ? $_GET['full_name'] : "" ; ?>"
                                >
                <label for="name">enter your name</label>
            </div>
            <div class="form-floating">
                <input
                type="number"  name="index_no" class="form-control" id="index_no" placeholder="Enter Your Index_No"
                value="<?php echo isset($_GET['index_no']) ? $_GET['index_no'] : "" ; ?>"
                >
                <label for="index_no">enter your index_no</label>
             </div>
        
            <div class="form-floating">
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter Your Email"
                value="<?php echo isset($_GET['email']) ? $_GET['email'] : "" ; ?>"
                >
                <label for="email">enter your email</label>
            </div>
            <!-- submit button -->
             <!-- checkout if the update_id has been set: if not set() show the subimit else show the update_record button
              submit button -->
              <?php if(!isset($_GET['update_id'])): ?>
                <button class="btn btn-lg mb-3 mt-3 btn-primary" type="submit" name="submit_attendance" value="Submit">submit_attendance</button>
              <?php else: ?>
                <button class="btn btn-lg mb-3 mt-3 btn-primary" type="submit" name="update_attendance" value="Update">update_attendance</button>
              <?php endif; ?>
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
                        <!-- send a fetch request to index.php, for the following variables through GET  -->
                        <a href="<?php echo "index.php?update_id=".$student['id']."&index_no=".$student['index_no']
                        .'&full_name='.$student['full_name'].'&email='.$student['email'].'&time='.$student['arrival_time'];
                ?>" class="list-update">update</a>
                        <a href="<?php echo "index.php?delete_id=".$student['id'].'&time='.$student['arrival_time'];
                ?> " class="list-delete">delete</a>
                    </section>
                </li>
                  <?php endwhile; ?>
            </ul>
        </div>
    </div>
</body>

</html>