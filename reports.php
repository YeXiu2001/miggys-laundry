<?php
    session_start();

	include("connections.php");
	include("functions.php");
    include("bootstrap.php");

    $user_data = check_login($con);
    $name = $user_data['first_name'];
    $surname = $user_data['last_name'];
    $admin_id = $user_data['id'];

    if(isset($_POST['save'])){
        $sales = $_POST['sales'];
        $expenses = $_POST['expenses'];
        $profit = $_POST['profit'];

        $resque = "SELECT public.check_sumdata_curdate()";
        $res_run = pg_query($con, $resque);
        $res_fetch = pg_fetch_array($res_run);
        
        if($res_fetch[0] > 0)
        {
            $upd_tomodal = pg_query($con, "UPDATE summary SET sales = $sales, expenses = $expenses, profit = $profit WHERE date = current_date");

            if ($upd_tomodal){
                $_SESSION['upsum'] = "Update Daily Report!";
                header("Location: reports.php");
                die;
            }
        }else
        {
            $save_tomodal = pg_query($con, "INSERT INTO summary(sales,expenses,profit)VALUES($sales,$expenses,$profit)");

            if ($save_tomodal){
                $_SESSION['savesum'] = "Save Daily Report!";
                header("Location: reports.php");
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
    <title>Reports</title>
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
            <li class="nav-item"> <a class="nav-link " href="reports.php"> <i class="bi bi-bar-chart"></i> <span>Reports</span> </a></li>
            <li class="nav-item"> <a class="nav-link collapsed" href="expenses.php"> <i class="bi bi-cart"></i> <span>Expenses</span> </a></li>
            <li class="nav-item"> <a class="nav-link collapsed" href="staff.php"> <i class="bi bi-person-plus"></i> <span>Staff</span> </a></li>
         </ul>
      </aside>
      <!-- sidebar end -->

      <main id="main" class="main">
        <section>
        <div class="card">
            <div class="card-body">
      <form action="" method="GET" id="filter">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group my-2">
                                        <label><strong>From Date</strong></label>
                                        <input id="fromdate" type="date" name="from_date" value="<?php if(isset($_GET['from_date'])){ echo $_GET['from_date']; } ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col">
                                <div class="form-group my-2">
                                        <label> <strong>To Date </strong> </label>
                                        <input id="todate" type="date" name="to_date" value="<?php if(isset($_GET['to_date'])){ echo $_GET['to_date']; } ?>" class="form-control">
                                    </div>
                                </div>

                                    <div class="form-group my-2">
                                      <button type="submit" class="btn btn-primary" disabled="disabled" id="filter_btn">Filter</button>
                                      <button type="submit" class="btn btn-warning"><a class="text-white" href="reports.php">Reset</a></button>
                                      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#verticalycentered">Save Daily Report</button>

                                    </div>
                        </form>
            </div>
        </div>
        </section>
      <section class="section">
        <div class="row">
        <div class="col-lg-4">
            <div class="card text-white bg-danger">
                  <div class="card-body text-white">
                        <h5 class="card-title text-white">Total Expenses: <?php 
                                         if(isset($_GET['from_date']) && isset($_GET['to_date']))
                                         {
                      $from_date = $_GET['from_date'];
                     $to_date = $_GET['to_date'];
                     $none = 0;
                    //data for expenses
                    $ex_sum_que = "SELECT filter_exp('$from_date','$to_date')";
                    $ex_sum = pg_query($con, $ex_sum_que);
                    $ex_sum_res = pg_fetch_array($ex_sum);
                    
                     if ($ex_sum_res[0] != 0){
                         echo $ex_sum_res[0];
                     }else{
                         echo $none;
                     }
                                         }else
                                         {
                                        //data for expenses
                                        $ex_sum_que = "SELECT SUM(expenses) FROM summary";
                                        $ex_sum = pg_query($con, $ex_sum_que);
                                        $ex_sum_res = pg_fetch_array($ex_sum);

                                             echo $ex_sum_res[0];
                                         }
                                     
     ?></h5>
                                      
                     </div>
                  </div>
        </div>

             <div class="col-lg-4">
                 <div class="card bg-primary">
                  <div class="card-body">
                        <h5 class="card-title text-white">Total Sales: <?php 
                                         if(isset($_GET['from_date']) && isset($_GET['to_date']))
                                                            {
                                         $from_date = $_GET['from_date'];
                                        $to_date = $_GET['to_date'];
                                        $none = 0;
                                         //data for sales
                                        $sales_sum_que = "SELECT filter_exp('$from_date','$to_date')" ;
                                        $sales_sum_run = pg_query($con, $sales_sum_que);
                                        $sales_sum_res = pg_fetch_array($sales_sum_run);
                                        if ($sales_sum_res[0] != 0){
                                            echo $sales_sum_res[0];
                                        }else{
                                            echo $none;
                                        }
                                        
                                                            
                                                            }else
                                                            {
                                                                 //data for sales
                                                                $sales_sum_que = "SELECT SUM(sales) FROM summary";
                                                                $sales_sum_run = pg_query($con, $sales_sum_que);
                                                                $sales_sum_res = pg_fetch_array($sales_sum_run);

                                                                echo $sales_sum_res[0];
                                                            }
                                                        
                        ?></h5>
                     </div>
                  </div>
                  </div>

                  <div class="col-lg-4">
                 <div class="card bg-success">
                  <div class="card-body">
                        <h5 class="card-title text-white">Total Profit: <?php
                          if(isset($_GET['from_date']) && isset($_GET['to_date']))
                          {
                        $from_date = $_GET['from_date'];
                        $to_date = $_GET['to_date'];
                        $none = 0;
                                         //data for sales
                                         $profit_sum_que = "SELECT filter_profit('$from_date','$to_date')" ;
                                         $profit_sum_run = pg_query($con, $profit_sum_que);
                                         $profit_sum_res = pg_fetch_array($profit_sum_run);   
                                         if ($profit_sum_res[0] != 0){
                                            echo $profit_sum_res[0];
                                        }else{
                                            echo $none;
                                        }
                          }else {
                            $profit_sum_que = "SELECT SUM(profit) FROM summary" ;
                            $profit_sum_run = pg_query($con, $profit_sum_que);
                            $profit_sum_res = pg_fetch_array($profit_sum_run);   
                            
                            echo $profit_sum_res[0];
                          }
                        ?></h5>
                     </div>
                  </div>
                  </div>
      </section>
<section class="section">

         <!-- table for summary -->
         <div class="col">
                  <div class="card">
                     <div class="card-body">
                     <div class="card-title"><h3><strong>Summary Report</strong></h3></div>
                        <table class="table table-info table-bordered datatable" id="sumtrans_table">
                            <thead>
                                <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Sales</th>
                                <th scope="col">Expenses </th>
                                <th scope="col">Profit </th>
                                </tr>
                            </thead>
                                <tbody>
                                <?php
                                  if(isset($_GET['from_date']) && isset($_GET['to_date']))
                                  {
                                      $from_date = $_GET['from_date'];
                                      $to_date = $_GET['to_date'];
  
                                      	//for summary table
                                        $summary_que = "SELECT * FROM summary WHERE date BETWEEN '$from_date' AND '$to_date' ORDER BY date DESC";
                                        $summary_run = pg_query($con,$summary_que);
  
                                        $i=0;
                                        while($row=pg_fetch_assoc($summary_run)) {
                                                  ?>
                                              <tr>
                                                  <td><?= $row['date']; ?></td>
                                                  <td><?= $row['sales']; ?></td>
                                                  <td><?= $row['expenses']; ?></td>
                                                  <td><?= $row['profit']; ?></td>
                                              </tr>
                                              <?php
                                              $i++;}
                                      }
                                      else
                                      {
                                    $summary_que = "SELECT * FROM summary ORDER BY date DESC";
                                    $summary_run = pg_query($con,$summary_que);

                                    $i=0;
                                    while($row=pg_fetch_assoc($summary_run)) {
                                              ?>
                                              <tr>
                                                  <td><?= $row['date']; ?></td>
                                                  <td><?= $row['sales']; ?></td>
                                                  <td><?= $row['expenses']; ?></td>
                                                  <td><?= $row['profit']; ?></td>
                                              </tr>
                                              <?php
                                          $i++;}
                                      }
                                  
                              ?>
                                </tbody>
                            
                        </table>
                        </div>
                </div>
            </div>
        </div>
        <!-- summary table end -->
        
            <div class="row">
                <!-- table for expenses -->
 
               <div class="col-lg-6">
                  <div class="card">
                     <div class="card-body">
                     <div class="card-title"><h3><strong>Expenses Summary</strong></h3></div>
                        <!-- table for transaction summary -->
                        <table class="table table-info table-bordered datatable" id="summexp_table">
                            <thead>
                                <tr>
                                <th scope="col">Date</th>
                                <th  scope="col">Expense Name</th>
                                <th  scope="col">Amount </th>
                                </tr>
                            </thead>
                            
                                <tbody>




                                <?php                        
                                  if(isset($_GET['from_date']) && isset($_GET['to_date']))
                                  {
                                      $from_date = $_GET['from_date'];
                                      $to_date = $_GET['to_date'];
  
                                      $query = "SELECT * FROM expenses WHERE  DATE(ex_date) BETWEEN '$from_date' AND '$to_date' ";
                                      $query_run = pg_query($con, $query);
  
                                      $i=0;
                                    while($row=pg_fetch_assoc($query_run)) {
                                              ?>
                                              <tr>
                                                  <td><?= $row['ex_date']; ?></td>
                                                  <td><?= $row['ex_name']; ?></td>
                                                  <td><?= $row['ex_amount']; ?></td>
                                              </tr>
                                              <?php
                                              $i++;}
                                      }
                                  else{
                                    $query = "SELECT * FROM expenses ORDER BY ex_date DESC";
                                    $query_run = pg_query($con, $query);

                                    $i=0;
                                    while($row=pg_fetch_assoc($query_run)) {
                                              ?>
                                            <tr>
                                                <td><?= $row['ex_date']; ?></td>
                                                <td><?= $row['ex_name']; ?></td>
                                                <td><?= $row['ex_amount']; ?></td>
                                            </tr>
                                            <?php
                                            $i++;}
                                    }
                                  
                              ?>
                                </tbody>
                            
                        </table>
                     </div>

                  </div>
               </div>

            <!-- table for transactions -->
                    <div class="col-lg-6 ">
                  <div class="card">
                     <div class="card-body">
                     <div class="card-title"><h3><strong>Transaction Summary</strong></h3></div>
                        <table class="table table-info table-bordered datatable" id="sumtrans_table">
                            <thead>
                                <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Customer</th>
                                <th  scope="col">Payment </th>
                                </tr>
                            </thead>
                                <tbody>
                                <?php
                                  if(isset($_GET['from_date']) && isset($_GET['to_date']))
                                  {
                                      $from_date = $_GET['from_date'];
                                      $to_date = $_GET['to_date'];
  
                                      $summtrans_que  = "SELECT t.trans_date AS Date
                                      ,CONCAT(c.first_name,' ',c.last_name) AS Customer
                                      ,t.total_amount AS payment
                                      FROM transactions AS t, customers AS c
                                      WHERE t.customer_id = c.customer_id AND t.trans_date::TIMESTAMP::DATE BETWEEN '$from_date' AND '$to_date'";
                                  
                                      $summtrans_res = pg_query($con,$summtrans_que);

                                      
                                      $i=0;
                                    while($row=pg_fetch_assoc($summtrans_res)) {
                                              ?>
                                              <tr>
                                                  <td><?= $row['date']; ?></td>
                                                  <td><?= $row['customer']; ?></td>
                                                  <td><?= $row['payment']; ?></td>
                                              </tr>
                                              <?php
                                          $i++;}
                                      }
                                  else{
                                    $summtrans_que  = "SELECT t.trans_date AS Date
                                    ,CONCAT(c.first_name,' ',c.last_name) AS Customer
                                    ,t.total_amount AS Payment
                                    FROM transactions AS t, customers AS c
                                    WHERE t.customer_id  = c.customer_id ORDER BY trans_date DESC";
                                
                                    $summtrans_res = pg_query($con,$summtrans_que);

                                    $i=0;
                                    while($row=pg_fetch_assoc($summtrans_res)) {
                                              ?>
                                            <tr>
                                                <td><?= $row['date']; ?></td>
                                                <td><?= $row['customer']; ?></td>
                                                <td><?= $row['payment']; ?></td>
                                            </tr>
                                            <?php
                                        $i++;}
                                    }
                                  
                              ?>
                                </tbody>
                            
                        </table>
                        </div>
                </div>
            </div>
        </div>
        <!-- Expenses table end -->


</section>

      </main>

      <script>
filter.addEventListener('input', () => {
if(fromdate.value.length > 0 && todate.value.length > 0){
  filter_btn.removeAttribute('disabled');
}else{
    filter_btn.setAttribute('disabled', 'disabled');
}
});
</script>

      <div class="modal fade" id="verticalycentered" tabindex="-1">
                           <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h5 class="modal-title">Save Daily Report</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                 </div>

                                 <div class="modal-body">
                                 <form method="POST">
                                 <div class="row g-2">
                                <label>Current Date</label>
                                <input type="date" class="form-label" value='<?php echo date('Y-m-d'); ?>' readonly/>
                                    <div class="col">
                                    <label for="sales" class="form-label"><strong>Daily Sales</strong></label>
                                    <input type="text" class="form-control" value= 
                                  '<?php
                                  $zero = 0;
                                  if ($trans_tomodal_res[0] != 0){
                                    echo $trans_tomodal_res[0];
                                  }else{
                                    echo $zero;
                                  }
                                   ?>' id="sales"  name="sales" readonly>
                                    </div>

                                    <div class="col">
                                    <label for="expenses" class="form-label"><strong>Daily Expenses</strong></label>
                                  <input type="text" class="form-control" value= 
                                  '<?php
                                  $zero = 0;
                                  if ($exp_tomodal_res[0] != 0){
                                    echo $exp_tomodal_res[0];
                                  }else{
                                    echo $zero;
                                  }
                                   ?>' id="expenses"  name="expenses" readonly>
                                    </div>

                                    <div class="col">
                                    <label for="profit" class="form-label"><strong>Daily Profit</strong></label>
                                  <input type="text" class="form-control" value= '<?php echo $profit_tomodal?>' id="profit"  name="profit" readonly>
                                    </div>

                                 </div>
                                 <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button> 
                                 <input type="submit" class="btn btn-primary" value="Save Report" id="button" name="save">
                                </div>
                              </div>
                           </div>
                           </div>  <!-- end of modal body -->
                           </form>
                        </div>
      <footer id="footer" class="footer">
         <div class="copyright"> &copy; Copyright <strong><span>P-A-A MOY GROUP EMO</span></strong>. All Rights Reserved</div>
      </footer>
      <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
      <!-- scripts for template -->
<?php include('script.php') ?>
</body>
</html>