<?php
    session_start();

	include("connections.php");
	include("functions.php");
    include("bootstrap.php");

    $user_data = check_login($con);
    $name = $user_data['first_name'];
    $surname = $user_data['last_name'];
    $admin_id = $user_data['id'];

    if(isset($_POST['save_exp']))
	{
		//something was posted
        $ex_date =  $_POST['ex_date'];
        $ex_name = $_POST['ex_name'];
        $ex_amnt =  $_POST['ex_amnt'];
         
        if(!empty($ex_date) && !empty($ex_name) && !empty($ex_amnt))
        {
            // Performing insert query execution
             // here our table name is college
        $ins_ex = "CALL insert_expense('$ex_date','$ex_name','$ex_amnt')";

        $exrun = pg_query($con, $ins_ex);
        if($exrun){
          $_SESSION['exsave'] = "Expense Data Submitted!";
          header("Location: expenses.php");
          die;
          }else{
            $_SESSION['notsumbit'] = "Data Not Submitted";
            header("Location: expenses.php");
          }
        }
    };
    
    if(isset($_POST['ex_delete_btn'])) //call name sa delete button sa expenses
{
    $ex_delete_id = $_POST['exp_delete_id'];
    $extract_exdel_id = implode(',' , $ex_delete_id);
    // echo $extract_id;

    if(($extract_exdel_id != NULL)){
    $ex_del_query = "DELETE FROM expenses WHERE expense_id IN($extract_exdel_id) ";
    $ex_del_query_run = pg_query($con, $ex_del_query);

    if($ex_del_query_run)
    {
      $_SESSION['exdeltd'] = "Expense Data Deletion";
      header("Location: expenses.php");
      die;
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
    <title>expenses</title>
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
            <li class="nav-item"> <a class="nav-link collapsed" href="services.php"> <i class="bi bi-menu-app"></i> <span>Services</span> </a></li>
            <li class="nav-item"> <a class="nav-link collapsed" href="reports.php"> <i class="bi bi-bar-chart"></i> <span>Reports</span> </a></li>
            <li class="nav-item"> <a class="nav-link " href="expenses.php"> <i class="bi bi-cart"></i> <span>Expenses</span> </a></li>
            <li class="nav-item"> <a class="nav-link collapsed" href="staff.php"> <i class="bi bi-person-plus"></i> <span>Staff</span> </a></li>
         </ul>
      </aside>
      <!-- sidebar end -->

<!-- Container Main start -->
      <main id="main" class="main">
    <section>
        
<div class="card">
<div class="card-body">
<div class="card-title"><h3><strong>Enter Expenses Details</strong></h3></div>
      
    <form class = "needs-validation" method="POST" id="save_exp_form" novalidate>
            <div class="row g-2">
            <div class="col">
                <label for="date" class="form-label"><strong>Date </strong></label>
                        <input type="datetime-local" class="form-control" name="ex_date" id="ex_date"  required>
                </div>
                        <div class="col">
            <label for="ex_name" class="form-label"><strong>Expense Name</strong></label>
            <input type="text" class="form-control" id="ex_name" placeholder="Expense Name" name="ex_name">
        </div>

                        <div class="col">
         <label for="ex_amnt" class="form-label"><strong>Amount</strong></label>
            <input type="text" class="form-control" id="ex_amnt"  placeholder="Amount" name="ex_amnt">
    </div>         
    </div>
    <div class="my-2">
        <Button disabled = "disabled" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#submit" id="save_ex">Submit</Button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="submit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-centered">
                           <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            Are you sure to submit data?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" id="save_exp"  name="save_exp" >Submit</button>
      </div>
    </div>
</div>
</div>
<!-- end modal -->
</form>
</div>
</div>

<div class="card">
<div class="card-body">
<div class="card-title"><h3><strong>Expenses Records</strong></h3></div>
        <!-- table for expenses -->
<form class="row g-2"method="POST" action="expenses.php" id="del_form">
<table class="table table-bordered table-info datatable" id="exp_table">
  <thead >

    <!-- delete button -->
<div class="col-auto">
<button disabled="disabled" type="button" class="btn btn-danger" name="exdel" id="exdel" style="width: 150px;" data-bs-toggle="modal" data-bs-target="#delete">Delete</button>
</div>
<!-- delete button end -->

<!-- Modal -->
<div class="modal fade" id="delete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-centered">
                           <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            Are you sure to delete data?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger" name="ex_delete_btn" >Delete</button>
      </div>
    </div>
</div>
</div>
    <tr>
    <th  scope="col"></th>
      <th scope="col">Date</th>
      <th  scope="col">Expense Name</th>
      <th  scope="col">Amount </th>
    </tr>
  </thead>

  <tbody>
  <?php

$i=0;
while($rows = pg_fetch_assoc($ex_result)){
 ?>
 <tr>
          <td  style="width:10px;">
            <input type="checkbox" name="exp_delete_id[]" id="exp_box" onclick="enable()"  value="<?= $rows['expense_id']; ?>">
            </td>
                 <td ><?= $rows['ex_date']; ?></td>
                 <td ><?= $rows['ex_name']; ?></td>
                 <td ><?= $rows['ex_amount']; ?></td>

         </tr>

         <?php
$i++;}
                                    ?>
        </tbody>
</table>
</form>
</div>
</div>
    
</section>
        </main> 
        <!-- end container -->

<!-- function for toggle delete -->
<script>
  function enable(){
    var exp_box = document.getElementById("exp_box");
    var exdel = document.getElementById("exdel");
    if(exp_box.checked){
      exdel.removeAttribute("disabled");
    }
  }
</script>
<!-- function end -->

<script>
save_exp_form.addEventListener('input', () => {
if(ex_date.value.length > 0 && ex_name.value.length > 0 && ex_amnt.value.length > 0){
  save_ex.removeAttribute('disabled');
}else{
  save_ex.setAttribute('disabled', 'disabled');
}
});
</script>


<footer id="footer" class="footer">
         <div class="copyright"> &copy; Copyright <strong><span>P-A-A MOY GROUP EMO</span></strong>. All Rights Reserved</div>
      </footer>
      <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


<?php include('script.php') ?>
</body>
</html>