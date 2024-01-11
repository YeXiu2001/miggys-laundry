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
            header("Location: customers2.php?updcus=1");
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
        <title>edit cus</title>
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
<a data-bs-toggle="modal" data-bs-target="#upcus2"><button type="submit"class="btn btn-primary" id="button" >Update</button></a>
<!-- Modal -->
<div class="modal fade" id="upcus2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
<a class="text-light" href="customers2.php" type="submit">
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
      <?php include('script.php') ?>
    </body>
    </html>