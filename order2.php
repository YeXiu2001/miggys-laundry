<?php
    session_start();

	include("connections.php");
	include("functions.php");
    include("bootstrap.php");

    $user_data = check_login($con);
    $name = $user_data['first_name'];
    $surname = $user_data['last_name'];
    $admin_id = $user_data['id'];

    			//for order2 tab
			$order2_query = "SELECT t.transaction_id, 
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
            ORDER BY transaction_id DESC
            LIMIT 3";
			$order2_result = pg_query($con, $order2_query);
            
    if(isset($_POST['order_sub']))
	{

       //something was posted
       $trans_cus =  $_POST['sel_cus'];
       $trans_admin =  $admin_id;
       $trans_serv = $_POST['sel_serv'];
       $trans_weight =  $_POST['weight'];
       $payment_stat = $_POST['pay_status'];
       $claim_stat = $_POST['claim_status'];
       $trans_lstat = $_POST['l_status'];


       $serv_price_que = "SELECT price FROM laundry_type_services WHERE laundry_id = $trans_serv";
       $serv_price_run = pg_query($con, $serv_price_que);
       $serv_price = pg_fetch_array($serv_price_run);
       
        if(!empty($trans_cus) && !empty($trans_admin) && !empty($trans_serv)&& !empty($trans_weight)&& !empty($payment_stat)&& !empty($trans_lstat)&& !empty($claim_stat))
        {
            // Performing insert query execution
        $trans_amnt = $trans_weight * $serv_price[0];

        $sql = "CALL insert_order('$trans_cus','$trans_admin','$trans_serv','$trans_weight','$trans_amnt','$payment_stat','$claim_stat','$trans_lstat')";

        $insorder = pg_query($con, $sql);

        if($insorder){
            $_SESSION['ord'] = "Order Submitted!";
            header("Location: order2.php");
            die;
        }else
		{
			echo "Please enter some valid information!";
		}
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
      <!-- Select2 CSS --> 
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> 

<!-- jQuery --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 

<!-- Select2 JS --> 
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>    
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
                  <li> <a href="order2.php"> <i class="bi bi-circle" ></i><span>Enter Order</span> </a></li>
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
<div class="card-title"><h3><strong>Enter Order Details</strong></h3></div>

    <form class="row g-2 col-auto needs-validation" id="sub_ord" method="POST" novalidate>
    <div class="input-group row g-2 mx-auto">
    <div class="col">
<!-- searchable dropdown for cus --> 
<label for="sel_cus"><strong>Customer</strong></label>
    <select class="form-select" aria-label="Default select example" id='sel_cus' name="sel_cus">
        <option value="">Select Customer</option> 
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
<select class="form-select" aria-label="Default select example" id='sel_serv' name="sel_serv">
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
<div class="col  my-0">
    <label for="weight" class="form-label" ><strong> Weight</strong></label>
    <input type="text" class="form-control" id="weight" name="weight" placeholder="weight in kg." required>
    </div>
    </div>

<!--  dropdown for payment status --> 
<div class="col">
<label for="pay_status" class="form-label"><strong>Payment Status</strong> </label>
<select class="form-select" aria-label="Default select example" id='pay_status' name="pay_status">
     <option>Unpaid</option> 
     <option>Paid</option> 
</select>
</div>

<!--  dropdown for claim status --> 
<div class="col">
<label for="claim_status" class="form-label"><strong>Claim Status</strong> </label>
<select class="form-select" aria-label="Default select example" id='claim_status' name="claim_status">
     <option>Unclaimed</option> 
</select>
</div>

<!-- for laundry status -->
<div class="col">
<label for="l_status" class="form-label"><strong>Laundry Status</strong> </label>
<select class="form-select" aria-label="Default select example" id="l_status" name="l_status">
  <option selected>Pending</option>
</select>
</div>
</div>
<button type="button"class="btn btn-primary mx-3" data-bs-toggle="modal" data-bs-target="#order" name="ord_sub" id="ord_sub" disabled="disabled" style="width: 100px;">Submit</button>
        <!-- Modal -->
        <div class="modal fade" id="order" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-centered">
                           <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            Are you sure to submit order data?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary"  name="order_sub" >Submit</button>
      </div>
    </div>
</div>
</div>
<!-- end modal -->
</form>
<!-- end form -->
</div>
      </div>

      <div class="card">
<div class="card-body">
<div class="card-title"><h3><strong>Recent Order Records</strong></h3></div>
 <!-- table -->
 <table class="table table-bordered table-info datatable">
<thead >
<tr>

<th scope="col">Order Date</th>
<th scope="col">Customer Name</th>
<th scope="col">Service</th>
<th scope="col">Weight</th>
<th scope="col">Total Amount</th>
<th scope="col">Payment Status</th>
<th scope="col">Claim Status</th>
<th scope="col">Laundry Status</th>
</tr>

</thead>
<tbody>

<?php
$i=0;
while($rows=pg_fetch_assoc($order2_result))
{
?>
  <tr>
         <td ><?= $rows['tdate']; ?></td>
         <td ><?= $rows['customer_name']; ?></td>
         <td ><?= $rows['service'];echo '(';echo $rows['price'];echo ')'; ?></td>
         <td ><?= $rows['weight']; ?></td>
         <td ><?= $rows['total_amount']; ?></td>
         <td ><?= $rows['payment_status']; ?></td>
         <td ><?= $rows['claim_status']; ?></td>
         <td><?= $rows['laundry_status']; ?></td>
 </tr>

    <?php
$i++;}
?>

</tbody>
</table>
    <!-- end table -->
    </section>
      </main>

      <script>
$(document).ready(function(){
 
 // Initialize select2
 $("#sel_cus").select2();
});
</script>

<script>
sub_ord.addEventListener('input', () => {
if(sel_cus.value.length > 0 && sel_serv.value.length > 0 && weight.value.length > 0){
  ord_sub.removeAttribute('disabled');
}else{
  ord_sub.setAttribute('disabled', 'disabled');
}
});
</script>

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