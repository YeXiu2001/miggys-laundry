 <?php
	include('connections.php');


	if(ISSET($_POST['search'])){
		$date1 = date("Y-m-d", strtotime($_POST['date1']));
		$date2 = date("Y-m-d", strtotime($_POST['date2']));
		
		$summexp_que = "SELECT * FROM expenses WHERE ex_date BETWEEN $date1 AND $date2";
		$ex_result = mysqli_query($con, $summexp_que);
	}
?>