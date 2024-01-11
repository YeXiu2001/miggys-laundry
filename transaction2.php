<?php
    session_start();

	include("connections.php");
	include("functions.php");
  include("bootstrap.php");

    if (isset($_GET['update']) && $_GET['update'] == 1 )
    {
         unset($_SESSION['update']);
    }

    $user_data = check_login($con);
    $name = $user_data['first_name'];
    $surname = $user_data['last_name'];
    $admin_id = $user_data['id'];

    		//for transaction2 tab
		$trans2_query = "SELECT t.transaction_id, 
    t.trans_date AS tdate
    ,CONCAT(c.first_name,' ', c.last_name) AS customer_name
    ,CONCAT(a.first_name,' ', a.last_name) AS Staff
    ,CONCAT(service_type,' ', laundry_type) AS Service
    ,price
    ,t.weight
    ,t.total_amount
    ,payment_status
    ,claim_status
    ,laundry_status
    FROM transactions AS t, customers AS c, admin_accounts AS a,laundry_type_services as lts
    WHERE t.customer_id = c.customer_id AND a.id = t.admin_id AND lts.laundry_id = t.service_id AND admin_id = $admin_id
    ORDER BY transaction_id DESC";
	
		$trans2_result = pg_query($con, $trans2_query);
        
        if(isset($_POST['trans_delete_btn'])) //call name sa delete button sa expenses
{
    $trans_delete_id = $_POST['trans_delete_id']; //checkbox id
    $extract_transdel_id = implode(',' , $trans_delete_id);
    // echo $extract_id;

    $trans_del_query = "DELETE FROM transactions WHERE transaction_id IN($extract_transdel_id) ";
    $trans_del_query_run = pg_query($con, $trans_del_query);

    if($trans_del_query_run)
    {
        $_SESSION['dltdtrans'] = "Transaction Data Deletion!";
        header("Location: transaction2.php");
        die;
    }
    else
    {
        $_SESSION['status'] = "Multiple Data Not Deleted";
        header("Location: transaction2.php");
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
               <a class="nav-link " data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#"> <i class="bi bi-journal-text"></i><span>Orders</span><i class="bi bi-chevron-down ms-auto"></i> </a>
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
<div class="card-title"><h3><strong>Transaction Records</strong></h3></div>
<!--Container Main start-->
<?php 
                    if(isset($_SESSION['status']))
                    {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Hey!</strong> <?php echo $_SESSION['status']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                        unset($_SESSION['status']);
                    }
                ?>
       <!-- table -->
       <form class="row g-2" method="POST">
<table class="table table-info table-bordered datatable" id="trans_table">
<thead >

<div class="col-sm-2">
<div class="my-0 mb-2">
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deltrans" id="transdel" name="deltrans" style="width: 150px;" disabled="disabled">Delete</button>
        <!-- Modal -->
        <div class="modal fade" id="deltrans" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-centered">
                           <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">WARNING!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            Are you sure to delete order data?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger"  name="trans_delete_btn" >Delete</button>
      </div>
    </div>
</div>
</div>
<!-- end modal -->
</div> 
</div>
<tr>
<th scope="col"></th>
<th scope="col">Order Date</th>
<th scope="col">Customer Name</th>
<th scope="col">Staff</th>
<th scope="col">Service</th>
<th scope="col">Kg</th>
<th scope="col">Price</th>
<th scope="col">Payment Status</th>
<th scope="col">Claim Status</th>
<th scope="col">Laundry Status</th>
<th scope="col"></th>
</tr>
</thead>

<tbody>

<?php

$i=0;
while($rows = pg_fetch_assoc($trans2_result))
        {
 ?>

<tr>
  <td style="width:10px; text-align: center;">
            <input type="checkbox" name="trans_delete_id[]" id="transbox" onclick="enable()" value="<?= $rows['transaction_id']; ?>">
            </td>
         <td ><?= $rows['tdate']; ?></td>
         <td ><?= $rows['customer_name']; ?></td>
         <td ><?= $rows['staff']; ?></td>
         <td ><?= $rows['service'];echo '(';echo $rows['price'];echo ')'; ?></td>
         <td ><?= $rows['weight']; ?></td>
         <td ><?= $rows['total_amount']; ?></td>
         <td ><?= $rows['payment_status']; ?></td>
         <td ><?= $rows['claim_status']; ?></td>
         <td><?= $rows['laundry_status']; ?></td>
         <td>
                    <button class="btn btn-warning">
                        <a class="text-dark" href="edittrans.php?editid=<?php echo htmlentities($rows['transaction_id']);?>">
                        Edit
                        </a>
                    </button>
                </td>
 </tr>

 <?php
                                            $i++;}
                                        
                                        
                                    ?>

</tbody>
</table>
       </form>
    <!-- end table -->
    <!--Container Main end-->
</div>
        </div>
        </section>
      </main>

<!-- function for toggle delete -->
<script>
  function enable(){
    var transbox = document.getElementById("transbox");
    var transdel = document.getElementById("transdel");
    if(transbox.checked){
      transdel.removeAttribute("disabled");
    }
  }
</script>
<!-- function end -->

      <!-- footer start -->
      <footer id="footer" class="footer">
         <div class="copyright"> &copy; Copyright <strong><span>P-A-A MOY GROUP EMO</span></strong>. All Rights Reserved</div>
      </footer>
      <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a> 
    <!-- footer end -->
             <!-- scripts for template -->
<?php include('script.php') ?>
    </body>
    </html>