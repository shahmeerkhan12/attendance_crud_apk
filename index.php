<?php
require "./config/db.php";
     // read/fetch from database
    $query = "SELECT id, index_no, full_name, email, arrival_time FROM attendance ORDER BY arrival_time DESC;";

    if(!$fetched_result = mysqli_query(mysql: $conn,query: $query)){
        exit("an error occured while fetching the records");
    }
// END IF


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
    <script src="jQuery.js"></script>
</head>

<body>
    <h1>ATTENDANCE MANAGEMENT SYSTEM(sql crud application)</h1>
    <hr>
<?php if(isset($_GET['msg'])): ?>
    <p id="msg" class="msg msg-<?php echo $_GET['type'];?>"><?php echo $_GET['msg']; ?>!</p>
<?php endif; ?>
<!-- <p style="color:white">Paragraph</p>   -->
    <div class="content-div">
        <form id="attendance_form" action="#" method="post">
            <h2><a href="index.php">Attendance List</a></h2>
             <div class="form-floating">
                <input type="text" name="name" id="name" autocapitalize autocomplete class="form-control" placeholder="Enter Your Name"
                        value="<?php echo isset($_GET['full_name']) ? $_GET['full_name'] : "" ; ?>"
                                >
                <label for="name">enter your name</label>
            </div>
            <!-- for update purpose only, they are hidden in the form -->
             <div class="form-floating">
                <input type="hidden" name="time" id="time" class="form-control"
                        value="<?php echo isset($_GET['time']) ? $_GET['time'] : "" ; ?>"
                                >
            </div>
             <div class="form-floating">
                <input type="hidden" name="update_id" id="update_id" autocapitalize autocomplete class="form-control"
                        value="<?php echo isset($_GET['update_id']) ? $_GET['update_id'] : "" ; ?>"
                                >
            </div>
            <!-- end FOR UPDATE PURPOSE -->
            <div class="form-floating">
                <input
                type="number"  name="index_no" class="form-control" id="index_no" placeholder="Enter Your Index_No"
                value="<?php echo isset($_GET['index_no']) ? $_GET['index_no'] : "" ; ?>"
                >
                <label for="index_no">enter your index_no</label>
             </div>
        
            <div class="form-floating">
                <input type="email" name="email" class="form-control" id="email" autocomplete placeholder="Enter Your Email"
                value="<?php echo isset($_GET['email']) ? $_GET['email'] : "" ; ?>"
                >
                <label for="email">enter your email</label>
            </div>
            <!-- submit button -->
             <!-- checkout if the update_id has been set: if not set() show the subimit else show the update_record button
              submit button -->
              <?php if(!isset($_GET['update_id'])): ?>
                <button class="btn btn-lg mb-3 mt-3 btn-primary" type="submit" name="submit_attendance" id="submit_attendance" value="Submit">submit_attendance</button>
              <?php else: ?>
                <button class="btn btn-lg mb-3 mt-3 btn-primary" type="submit" name="update_attendance" id="update_attendance" value="Update">update_attendance</button>
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
                ?>" class="list-update update" >update</a>
                        <a href="<?php echo "index.php?delete_id=".$student['id'].'&time='.$student['arrival_time'];
                ?> " class="list-delete delete">delete</a>
                    </section>
                </li>
                  <?php endwhile; ?>
            </ul>
        </div>
    </div>
</body>
<!-- include the jQuery script -->
 <script src="jQuery.js"></script>
 <script>
    $(()=>{
        // handle the create action
    $('#submit_attendance').click((event)=>{
        event.preventDefault();
        $.post("./server/handle_create.php",$('#attendance_form').serializeArray(),(result)=>{
                $('body').html(result);
        })
    });
    //handle update_attendance
    // part 1
    $("a.update").click((event)=>{
        event.preventDefault();
        $.get(event.target.href,(result)=>{
            $('body').html(result);
            
            // part 2
            $('#update_attendance').click((event)=>{ 
                event.preventDefault();
                $.post('./server/handle_update.php',$('#attendance_form').serializeArray(),(result)=>{
                    $('body').html(result);
                })
             })
        })
    })
})    

 </script>
</html>