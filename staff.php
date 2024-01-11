<?php
    session_start();

	include("connections.php");
	include("functions.php");
    include("bootstrap.php");

    $user_data = check_login($con);
    $name = $user_data['first_name'];
    $surname = $user_data['last_name'];
    $admin_id = $user_data['id'];

    if(isset($_GET['rejectid']))
    {
    $id = $_GET['rejectid'];

    $reject_que = "DELETE FROM admin_accounts WHERE id = $id";
    $reject_que_result = pg_query($con, $reject_que);

    if($reject_que_result){
    $_SESSION['rej'] = "Staff Rejected!";
    header('location: staff.php');
    die;
    }
    }
    
    if(isset($_GET['approveid']))
{
$id = $_GET['approveid'];

$approve_que = "UPDATE admin_accounts SET status = 'yes' WHERE id = $id";
$approve_que_result = pg_query($con, $approve_que);

if($approve_que_result){
$_SESSION['apv'] = "Staff approved!";
header('location: staff.php');
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
    <title>Staffs</title>
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
            <li class="nav-item"> <a class="nav-link collapsed" href="expenses.php"> <i class="bi bi-cart"></i> <span>Expenses</span> </a></li>
            <li class="nav-item"> <a class="nav-link " href="staff.php"> <i class="bi bi-person-plus"></i> <span>Staff</span> </a></li>
         </ul>
      </aside>
      <!-- sidebar end -->

      <!-- Container Main start -->
      <main id="main" class="main">
    <section>
    <div class="card">
<div class="card-body">
<div class="card-title"><h3><strong>Staff Approval</strong></h3></div>
<!-- start staff approval -->
<form method="POST">
    <table class="table table-bordered table-warning datatable" id="approve_admins">
  <thead >
<tr>
      <th scope="col">Date of Registration</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Username</th>
      <th scope="col">Actions</th>
    </tr>

  </thead>
  <tbody>
  <?php
$i=0;
while($rows = pg_fetch_assoc($approval_result))
        {
 ?><tr>
                <td><?= $rows['date']; ?></td>
                 <td><?= $rows['first_name']; ?></td>
                 <td><?= $rows['last_name']; ?></td>
                 <td><?= $rows['username']; ?></td>
                 <td>               
                <a href="staff.php?rejectid=<?= $rows['id']; ?>" class="btn btn-danger" >Reject</a>
                <a href="staff.php?approveid=<?= $rows['id']; ?>" class="btn btn-success" >Approve</a>
                </td>
         </tr>
         <?php
                                            $i++;}
                                        
                                    ?>
   
        </tbody>
</table>

</form>
    <!-- end staff approval -->
</div>
    </div>

    <div class="card">
<div class="card-body">
<div class="card-title"><h3><strong>Active Staffs</strong></h3></div>
 <!-- start staff table -->
 <table class="table table-bordered table-info datatable" id="active_admins">
  <thead >

<tr>
      <th scope="col">Date of Registration</th>
      <th  scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Username</th>
      <th scope="col">User_Type</th>
    </tr>

  </thead>
  <tbody>
  <?php
$i=0;
while($rows=pg_fetch_assoc($act_run))
        {
 ?><tr>
                <td><?= $rows['date']; ?></td>
                 <td><?= $rows['first_name']; ?></td>
                 <td  ><?= $rows['last_name']; ?></td>
                 <td><?= $rows['username']; ?></td>
                 <td><?= $rows['user_type']; ?></td>
         </tr>
         <?php
                                            $i++;}
                                        
                                 ?>
   
        </tbody>
</table>

<!-- end of staff table -->
</div>
    </div>
    </section>
      </main>

      <footer id="footer" class="footer">
         <div class="copyright"> &copy; Copyright <strong><span>P-A-A MOY GROUP EMO</span></strong>. All Rights Reserved</div>
      </footer>
      <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a> 
      <?php include('script.php')  ?>
</body>
</html>