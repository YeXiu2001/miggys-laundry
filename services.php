<?php
    session_start();

	include("connections.php");
	include("functions.php");
    include("bootstrap.php");

    $user_data = check_login($con);
    $name = $user_data['first_name'];
    $surname = $user_data['last_name'];
    $admin_id = $user_data['id'];

    if ( isset($_GET['update']) && $_GET['update'] == 1 )
    {
         unset($_SESSION['update']);
    }

    if(isset($_POST['serv']))
	{
		//something was posted
        $service =  $_POST['service'];
        $price = $_POST['price'];
        $laundry = $_POST['laundry_type'];
         
        if(!empty($service) && !empty($price) && !empty($laundry))
        {
            // Performing insert query execution
        $sql = "CALL insert_service('$service','$laundry','$price')";

        $servsuc = pg_query($con, $sql);

        if($servsuc){
        $_SESSION['servsuc'] = "Services Submitted!";
        header("Location: services.php");
        die;
        }
        }
    }

    if(isset($_POST['serv_delete_btn'])) //call name sa delete button sa expenses
{
    $serv_delete_id = $_POST['serv_delete_id']; //checkbox id
    $extract_servdel_id = implode(',' , $serv_delete_id);
    // echo $extract_id;

    $serv_del_query = "DELETE FROM laundry_type_services WHERE laundry_id IN($extract_servdel_id) ";
    $serv_del_query_run = pg_query($con, $serv_del_query);

    if($serv_del_query_run)
    {
        $_SESSION['delserv'] = "Service Data Deletion";
        header("Location: services.php");
        die;
    }
    else
    {
        $_SESSION['status'] = "Multiple Data Not Deleted";
        header("Location: services.php");
    }
}

    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
</head>
<body>
     <!-- sidebar and navigation -->
   <?php
      include('navigation.php');
   ?>
      <!-- sidebar and navigation -->

      <!-- sidebar start -->
      <aside id="sidebar" class="sidebar">
         <ul class="sidebar-nav" id="sidebar-nav">
         <li class="nav-item"> <a class="nav-link collapsed" href="index.php"> <i class="bi bi-grid"></i><span>Dashboard</span> </a></li>
         <li class="nav-item">
               <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#"> <i class="bi bi-journal-text"></i><span>Orders</span><i class="bi bi-chevron-down ms-auto"></i> </a>
               <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                  <li> <a href="order.php"> <i class="bi bi-circle"></i><span>Enter Order</span> </a></li>
                  <li> <a href="transaction.php"> <i class="bi bi-circle"></i><span>Transactions</span> </a></li>
               </ul>
            </li>
            <li class="nav-item"> <a class="nav-link collapsed" href="customers.php"> <i class="bi bi-people"></i> <span>Customers</span> </a></li>
            <li class="nav-item"> <a class="nav-link " href="services.php"> <i class="bi bi-menu-app"></i> <span>Services</span> </a></li>
            <li class="nav-item"> <a class="nav-link collapsed" href="reports.php"> <i class="bi bi-bar-chart"></i> <span>Reports</span> </a></li>
            <li class="nav-item"> <a class="nav-link collapsed" href="expenses.php"> <i class="bi bi-cart"></i> <span>Expenses</span> </a></li>
            <li class="nav-item"> <a class="nav-link collapsed" href="staff.php"> <i class="bi bi-person-plus"></i> <span>Staff</span> </a></li>
         </ul>
      </aside>
      <!-- sidebar end -->


      <main id="main" class="main">
        <section>
        <div class="card">
<div class="card-body">
<div class="card-title"><h3><strong>Enter Service Details</strong></h3></div>
  <!-- Forms -->
  <form class="row g-2 needs-validation" action="services.php" id="serv_sub" method="POST" novalidate>
 <div class="col">
    <label for="service" class="form-label"> <strong>Service Type </strong> </label>
    <input type="text" class="form-control" id="service" placeholder="e.g (rush, non-rush)" name="service" required>
</div>

<div class="col">
    <label for="laundry_type" class="form-label"><strong>Laundry Type </strong></label>
    <input type="text" class="form-control" id="laundry_type" placeholder="e.g (Shirts, Jeans, Comforters)" name="laundry_type" required>
</div>

<div class="col">
 <label for="price" class="form-label"><strong> Price per KG</strong></label>
    <input type="text" class="form-control" id="price"  placeholder="Price per Kilogram" name="price" required>
</div>
<div class="mb-3">
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#serv" name="serv_mod" id="serv_mod" disabled="disabled">Submit
</button>
        <!-- Modal -->
        <div class="modal fade" id="serv" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-centered">
                           <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            Are you sure to submit service data?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary"  name="serv" >Submit</button>
      </div>
    </div>
</div>
</div>
<!-- end modal -->
</div>
</form>  
</div>
        </div>
        <div class="card">
<div class="card-body">
<div class="card-title"><h3><strong>Services Offered</strong></h3></div>
<!-- table -->
<form class="row g-2" method="POST">
<table class="table table-info table-bordered datatable" id="serv_table">
<thead >
<div class="col-auto">
<button disabled = "disabled" type="button" name="servv_del" id="servv_del" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delserv" style="width: 150px;">Delete</button>
        <!-- Modal -->
        <div class="modal fade" id="delserv" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-centered">
                           <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">WARNING!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            Are you sure to delete service data?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger"  name="serv_delete_btn" >Delete</button>
      </div>
    </div>
</div>
</div>
<!-- end modal -->
</div>  
<tr>

<th scope="col"></th>
<th scope="col">Laundry Type</th>
<th  scope="col">Service Type</th>
<th  scope="col">Service Amount</th>
<th  scope="col">action</th>
</tr>

</thead>
<tbody>


<?php

$i=0;
while($rows = pg_fetch_assoc($serv_result)){


 ?>
  <tr>
         <td style="width:10px; text-align: center;">
            <input type="checkbox" name="serv_delete_id[]" id="service_box" onclick="enable()" value="<?= $rows['laundry_id']; ?>">
            </td>
            <td ><?= $rows['service_type']; ?></td>
         <td ><?= $rows['laundry_type']; ?></td>
         <td><?= $rows['price']; ?></td>
         <td>
         <button class="btn btn-warning">
                        <a class="text-dark" href="editserv.php?editid=<?php echo htmlentities($rows['laundry_id']);?>">
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
</div>
        </div>
        </section>
      </main>

      <script>
serv_sub.addEventListener('input', () => {
if(service.value.length > 0 && laundry_type.value.length > 0 && price.value.length > 0){
  serv_mod.removeAttribute('disabled');
}else{
  serv_mod.setAttribute('disabled', 'disabled');
}
});
</script>

<!-- function for toggle delete -->
<script>
  function enable(){
    var service_box = document.getElementById("service_box");
    var servv_del = document.getElementById("servv_del");
    if(service_box.checked){
      servv_del.removeAttribute("disabled");
    }
  }
</script>
<!-- function end -->

      <footer id="footer" class="footer">
         <div class="copyright"> &copy; Copyright <strong><span>P-A-A MOY GROUP EMO</span></strong>. All Rights Reserved</div>
      </footer>
      <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>  

<?php include('script.php'); ?>
</body>
</html>