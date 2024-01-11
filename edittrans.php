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
            header("Location: transaction.php?updateftrans=1");
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
    <title>Update Transaction</title>
</head>
<body>

     <!-- sidebar and navigation -->
     <?php
            include('sidebar.php');
            include('navigation.php');
        ?>
      <!-- sidebar and navigation --> 

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
    <select class="form-select" disabled aria-label="Default select example" id='sel_cus' name="sel_cus">
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
<a data-bs-toggle="modal" data-bs-target="#uptrans"><button type="submit"class="btn btn-primary" id="button" >Update</button></a>
<!-- Modal -->
<div class="modal fade" id="uptrans" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
		<a class="text-light" href="transaction.php">
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
      <?php include('script.php'); ?>
</body>
</html>