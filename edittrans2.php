<?php
session_start();

	include('connections.php');
	include('functions.php');
    include('bootstrap.php');
    
    if(isset($_POST['update'])){

        $trans_upid = $_GET['editid'];
    
            //something was posted
    
    
            $pay_stat = $_POST['payment_status'];
            $claim_stat = $_POST['claim_status'];
            $trans_lstat = $_POST['l_status'];
    
        $transup_sql = pg_query($con, "UPDATE transactions SET payment_status='$pay_stat', claim_status='$claim_stat',laundry_status='$trans_lstat' WHERE transaction_id = $trans_upid");
    
        if ($transup_sql){
            header("Location: transaction2.php?updatestrans=1");
            $_SESSION['update'] = "Data Update?!";
            die;
        }else{
            echo "<script>alert('Error');</script>";
        }
    }
    
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Staff Dashboard</title>
        <meta name="robots" content="noindex, nofollow">
      <meta content="" name="description">
      <meta content="" name="keywords">
      <link href="assets/img/favicon.png" rel="icon">
      <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
      <link href="https://fonts.gstatic.com" rel="preconnect">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
      <link href="assets/css/bootstrap.min.css" rel="stylesheet">
      <link href="assets/css/bootstrap-icons.css" rel="stylesheet">
      <link href="assets/css/boxicons.min.css" rel="stylesheet">
      <link href="assets/css/quill.snow.css" rel="stylesheet">
      <link href="assets/css/quill.bubble.css" rel="stylesheet">
      <link href="assets/css/remixicon.css" rel="stylesheet">
      <link href="assets/css/simple-datatables.css" rel="stylesheet">
      <link href="assets/css/style.css" rel="stylesheet">
    </head>
    <body>
        <?php include('navigation2.php');?>

         <!-- sidebar start -->
      <aside id="sidebar" class="sidebar">
         <ul class="sidebar-nav" id="sidebar-nav">
         <li class="nav-item"> <a class="nav-link collapsed" href="index2.php"> <i class="bi bi-grid"></i><span>Dashboard</span> </a></li>
         <li class="nav-item">
               <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#"> <i class="bi bi-journal-text"></i><span>Orders</span><i class="bi bi-chevron-down ms-auto"></i> </a>
               <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                  <li> <a href="order2.php"> <i class="bi bi-circle"></i><span>Enter Order</span> </a></li>
                  <li> <a href="transaction2.php"> <i class="bi bi-circle"></i><span>Transactions</span> </a></li>
               </ul>
            </li>

            <li class="nav-item"> <a class="nav-link collapsed" href="customers2.php"> <i class="bi bi-journal-text"></i> <span>Customers</span> </a></li>
         </ul>
      </aside>
      <!-- sidebar end -->

      <main id="main" class="main">
    <section>
<div class="card">
<div class="card-body">
<div class="card-title"><h3><strong>Edit Transaction Details</strong></h3></div>

<form class="row g-2 col-auto" method="POST">

<?php
                
				$trans_upid = $_GET['editid'];

                $trans_sel = pg_query($con, "SELECT * FROM transactions WHERE transaction_id = '$trans_upid' ");
                
				$trans_upque = pg_query($con, "SELECT t.transaction_id, t.trans_date
                ,CONCAT(c.first_name,' ', c.last_name) AS customer_name
                ,CONCAT(a.first_name,' ', a.last_name) AS Staff
                ,CONCAT(service_type,' ', laundry_type) AS Service
                ,price
                ,t.weight,t.total_amount,payment_status,claim_status,laundry_status
                FROM transactions AS t, customers AS c, admin_accounts AS a,laundry_type_services as lts
                WHERE t.customer_id = c.customer_id AND a.id = t.admin_id AND lts.laundry_id = t.service_id AND transaction_id = '$trans_upid'"
                );

				while($rows=pg_fetch_array($trans_upque)){
                    while($row=pg_fetch_array($trans_sel)){ 
			?>
            
<div class="input-group row g-2 mx-auto">
<div class="col">
    <!-- searchable dropdown for cus --> 
    <label for="sel_cus"><strong>Customer</strong></label>
    <select class="form-select" aria-label="Default select example" id='sel_cus' name="sel_cus" disabled>
    <option value="<?php echo $row["customer_id"];?>"> <?php echo $rows['customer_name'];?>  </option>  
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                $i=0;
                while ($get_cus = pg_fetch_assoc($cus_result)){
            ?>
                    <option value="<?php echo $get_cus["customer_id"];
                    // The value we usually set is the primary key
                    ?>">

            <?php echo $get_cus["first_name"];
             // To show the category name to the user
            ?>

            <?php echo $get_cus["last_name"];
            // To show the category name to the user
             ?>
            </option>
            <?php
                $i++;};
                // While loop must be terminated
            ?>
</select>
</div>

<!-- searchable dropdown for service --> 
<div class="col">
                <label for="sel_serv"><strong>Service And Laundry Type</strong></label>  
<select class="form-select" aria-label="Default select example" id='sel_serv' name="sel_serv" disabled>
<option value="<?php echo $row["service_id"];?>"><?php echo $rows['service'];?></option>
     <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                $i=0;
                while($get_serv = pg_fetch_assoc($serv_result)){

            ?>
                <option value="<?php echo $get_serv['laundry_id'];
                    // The value we usually set is the primary key
                ?>">
                
                    <?php echo $get_serv["service_type"];
                        // To show the category name to the user
                    ?>

                    <?php echo $get_serv["laundry_type"];
                        // To show the category name to the user
                    ?>
                    
                    (<?php echo $get_serv["price"];
                        // To show the category name to the user
                    ?>)
                </option>
            <?php
                $i++;};
                // While loop must be terminated
            ?> 
</select>
</div>



 <!-- weight -->
 <div class="col my-0">
    <label for="weight" class="form-label"><strong> Weight</strong></label>
    <input type="text" class="form-control" value="<?php echo $row['weight'];?>" id="weight" name="weight" readonly>
</div>
</div>
<!--  dropdown for payment status --> 
<div class="col">
<label for="payment_status" class="form-label"><strong> Payment Status </strong> </label>
<select class="form-select" aria-label="Default select example" id='payment_status' name="payment_status">
     <option><?php echo $row["payment_status"];?></option>
     <option>Paid</option>
     </select>
     </div>

<!--  dropdown for claim status --> 
<div class="col">
<label for="claim_status" class="form-label"><strong> Claim Status </strong> </label>
<select class="form-select" aria-label="Default select example" id='claim_status' name="claim_status">
     <option><?php echo $row["claim_status"];?></option>
     <option>Claimed</option>
</select>
</div>

<!-- for laundry status -->
<div class="col">
<label for="l_status" class="form-label"><strong>Laundry Status</strong> </label>
<select class="form-select" aria-label="Default select example" id="l_status" name="l_status">
<option><?php echo $row['laundry_status'];?></option>
  <option>Ongoing</option>
  <option>Done</option>
</select>
</div>

<div class="my-2">
<a data-bs-toggle="modal" data-bs-target="#uptrans2"><button type="submit"class="btn btn-primary" id="button" >Update</button></a>
<!-- Modal -->
<div class="modal fade" id="uptrans2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-centered">
                           <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            Are you sure to update transaction data?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="update" >Update</button>
      </div>
    </div>
</div>
</div>
<!-- end modal -->
		<button class="btn btn-secondary">
		<a class="text-light" href="transaction2.php">
                        Cancel
                        </a>
        </div>
</form>
<!-- end form -->
<?php

				}
            }
				?>
</div>
</div>
    </section>
      </main>
      <?php include('script.php') ?>
    </body>
    </html>