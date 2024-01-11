<?php
    session_start();

	  include("connections.php");
	  include("functions.php");
    include("bootstrap.php");

    $user_data = check_login($con);
    $name = $user_data['first_name'];
    $surname = $user_data['last_name'];
    $admin_id = $user_data['id'];

    if(isset($_POST['cus']))
	{
		//something was posted
        $cus_fname =  $_POST['cus_fname'];
        $cus_lname = $_POST['cus_lname'];
        $cus_num =  $_POST['cus_num'];
         
        if ( isset($_GET['updcus']) && $_GET['updcus'] == 1 )
        {
             unset($_SESSION['update']);
        }

        if(!empty($cus_fname) && !empty($cus_lname) && !empty($cus_num))
        {
            // Performing insert query execution
             // here our table name is college
             $sql = "CALL insert_cus('$cus_fname','$cus_lname','$cus_num')";

        $cusuc = pg_query($con, $sql);
        if($cusuc){
            $_SESSION['cusuc'] = "Customers Submitted!";
            header("Location: customers2.php");
            die;
            }
        }
    }
    if(isset($_POST['cus_delete_btn'])) //call name sa delete button sa expenses
    {
        $cus_delete_id = $_POST['cus_delete_id']; //checkbox id
        $extract_cusdel_id = implode(',' , $cus_delete_id);
        // echo $extract_id;
    
        $cus_del_query = "DELETE FROM customers WHERE customer_id IN($extract_cusdel_id) ";
        $cus_del_query_run = pg_query($con, $cus_del_query);
    
        if($cus_del_query_run)
        {
            $_SESSION['cusdeltd'] = "Customer Data Deletion";
            header("Location: customers2.php");
            die;
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

            <li class="nav-item"> <a class="nav-link " href="customers2.php"> <i class="bi bi-journal-text"></i> <span>Customers</span> </a></li>
         </ul>
      </aside>
      <!-- sidebar end -->
    <main id="main" class="main">
        <section>
<!--Container Main start-->
<div class="card">
<div class="card-body">
<div class="card-title"><h3><strong>Enter Customer Details</strong></h3></div>

        <form class="row g-2"  method="POST"  id="save_cus_form">
         <div class="col">
            <label for="cus_fname" class="form-label"><strong>First Name</strong></label>
            <input type="text" class="form-control" id="cus_fname" placeholder="First Name" name="cus_fname">
        </div>

        <div class="col">
         <label for="cus_lname" class="form-label"><strong>Last Name</strong></label>
            <input type="text" class="form-control" id="cus_lname"  placeholder="Last Name" name="cus_lname">
    </div>

    <div class="col">
         <label for="cus_num" class="form-label"><strong>Contact No.</strong></label>
            <input type="text" class="form-control" id="cus_num" placeholder="Phone Number" name="cus_num">
     </div>
     <div class="my-2 mb-3">
     <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cus" name="cus_mod" id="cus_mod" disabled="disabled">Submit</a></button>
    </div>
     <!-- Modal -->
     <div class="modal fade" id="cus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-centered">
                           <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            Are you sure to submit customer data?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="cus" >Submit</button>
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
<div class="card-title"><h3><strong> Customer Records</strong></h3></div>
<form class="row g-2"method="POST">
<table class="table table-info table-bordered datatable" id="cus_table">
  <thead >
  <br>

<div class="col-auto">
<button type="button" name="delcuss" id="delcuss"  class="btn btn-danger" disabled="disabled" data-bs-toggle="modal" data-bs-target="#delcus" style="width: 150px;" >Delete</button>
</div>
        <!-- Modal -->
        <div class="modal fade" id="delcus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-centered">
                           <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">WARNING!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            Are you sure to delete customer data?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger"  name="cus_delete_btn" >Delete</button>
      </div>
    </div>
</div>
</div>
<!-- end modal -->
</div>
        
    <tr>
      <th class="table-primary" scope="col"></th>
      <th class="table-primary" scope="col">First Name</th>
      <th class="table-primary" scope="col">Last Name</th>
      <th class="table-primary" scope="col">Contact Number</th>
      <th class="table-primary" scope="col"></th>
    </tr>

  </thead>
  <tbody>
  <?php
$i = 0;
while($rows = pg_fetch_assoc($cus_result))
{
 ?><tr>
          <td class="table-primary" style="width:10px; text-align: center;">
          <input type="checkbox" name="cus_delete_id[]" id="cusbox" onclick="enable()" value="<?= $rows['customer_id']; ?>">
            </td>
                 <td class="table-primary"><?= $rows['first_name']; ?></td>
                 <td class="table-primary"><?= $rows['last_name']; ?></td>
                 <td class="table-primary"><?= $rows['contact_no']; ?></td>
                 <td class="table-primary">
                   <button class="btn btn-warning">
                        <a class="text-dark" type="submit" href="editcus2.php?editid=<?php echo htmlentities($rows['customer_id']);?>">
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
    <!--Container Main end-->
</div>
</div>
        </section>
      </main>

      <script>
save_cus_form.addEventListener('input', () => {
if(cus_fname.value.length > 0 && cus_lname.value.length > 0 && cus_num.value.length > 0){
  cus_mod.removeAttribute('disabled');
}else{
  cus_mod.setAttribute('disabled', 'disabled');
}
});
</script>

<!-- function for toggle delete -->
<script>
  function enable(){
    var cusbox = document.getElementById("cusbox");
    var delcuss = document.getElementById("delcuss");
    if(cusbox.checked){
      delcuss.removeAttribute("disabled");
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