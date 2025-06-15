 <?php
 require "./../config/db.php";
 $delete_id = $_GET['delete_id'];
$arrival_time = $_GET['time'];

$query = "DELETE FROM attendance where id='$delete_id' and arrival_time='$arrival_time';";

// execute the query ////////////
  if(!$result = mysqli_query(mysql: $conn,query: $query)){
        mysqli_error($conn);
            header("Location: ./../index.php?msg=An error occured while deleting&type=error");
    exit();
        }else {
        header("Location:./../index.php?msg=Record deleted successfully&type=success");
        exit();
    }
?>