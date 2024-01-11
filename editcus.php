<?php
    session_start();

	include("connections.php");
	include("functions.php");
    include("bootstrap.php");

    $user_data = check_login($con);
    $name = $user_data['first_name'];
    $surname = $user_data['last_name'];
    $admin_id = $user_data['id'];

    if(isset($_POST['update'])){

        $cus_upid = $_GET['editid'];
        
        $cus_fname =  $_POST['cus_fname'];
        $cus_lname = $_POST['cus_lname'];
        $cus_num =  $_POST['cus_num'];
        
        $cus_up_sql = pg_query($con, "UPDATE customers SET first_name='$cus_fname',last_name='$cus_lname',contact_no='$cus_num' WHERE customer_id = '$cus_upid'");
        
        if ($cus_up_sql){
            header("Location: customers.php?updcus=1");
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
        <title>Edit Customer</title>
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
<div class="card-title"><h3><strong>Update Customers Details</strong></h3></div>
<form class="row g-2"  method="POST">

<?php
        $cus_upid = $_GET['editid'];
        $cus_upque = pg_query($con, "SELECT * FROM customers WHERE customer_id = '$cus_upid'");
        while($rows=pg_fetch_array($cus_upque)){
    ?>

 <div class="col">
    <label for="cus_fname" class="form-label"><strong>First Name</strong></label>
    <input type="text" class="form-control" value="<?php echo $rows['first_name'];?>" id="cus_fname" placeholder="first Name" name="cus_fname">
</div>

<div class="col">
 <label for="cus_lname" class="form-label"><strong>Last Name</strong></label>
    <input type="text" class="form-control" id="cus_lname"  placeholder="Last Name" value="<?php echo $rows['last_name'];?>" name="cus_lname">
</div>

<div class="col">
 <label for="cus_num" class="form-label"><strong>Contact No.</strong></label>
    <input type="text" class="form-control" id="cus_num" placeholder="Phone Number" value="<?php echo $rows['contact_no'];?>" name="cus_num">
</div>
<div class="my-2">
<a data-bs-toggle="modal" data-bs-target="#upcus"><button type="submit"class="btn btn-primary" id="button" >Update</button></a>
<!-- Modal -->
<div class="modal fade" id="upcus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-centered">
                           <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            Are you sure to update customer data?
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
<a class="text-light" href="customers.php" type="submit">
                Cancel
                </a>
</div>
</form> 

<?php

}
?>  
</div>
        </div>

        </section>
      </main>

<?php include('script.php')?>
    </body>
    </html>