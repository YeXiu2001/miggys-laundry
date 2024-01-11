<?php
session_start();

   include("connections.php");
   include("functions.php");
   include("bootstrap.php");

   $user_data = check_login($con);
   $name = $user_data['first_name'];
   $surname = $user_data['last_name'];

?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <title>Dashboard</title>

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
         <li class="nav-item"> <a class="nav-link" href="index.php"> <i class="bi bi-grid"></i><span>Dashboard</span> </a></li>
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
            <li class="nav-item"> <a class="nav-link collapsed" href="staff.php"> <i class="bi bi-person-plus"></i> <span>Staff</span> </a></li>
         </ul>
      </aside>
      <!-- sidebar end -->

      <!-- container start -->
      <main id="main" class="main">
         <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Dashboard</li>
               </ol>
            </nav>
         </div>

         <!-- Cards Start -->
         <section class="section dashboard">
            <div class="row">
               <div class="col-lg-7">
                  <div class="row">
                     <div class="col-xxl-6 col-md-6">
                        <div class="card info-card sales-card">
                           <div class="card-body">
                              <h5 class="card-title">Expenses <span>| Total</span></h5>
                              <div class="d-flex align-items-center">
                                 <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-cart"></i></div>
                                 <div class="ps-3">
                                    <h6><?php echo '₱ '.$tot_exp_res[0];?></h6>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="col-xxl-6 col-md-6">
                        <div class="card info-card revenue-card">
   
                           <div class="card-body">
                              <h5 class="card-title">Sales <span>| Total</span></h5>
                              <div class="d-flex align-items-center">
                                 <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-cash-stack"></i></div>
                                 <div class="ps-3">
                                    <h6><?php echo '₱ '.$tot_sales_res[0]?></h6>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="col-xxl-6 col-md-6">
                        <div class="card info-card revenue-card">
   
                           <div class="card-body">
                              <h5 class="card-title">Profit <span>| Total</span></h5>
                              <div class="d-flex align-items-center">
                                 <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-cash-stack"></i></div>
                                 <div class="ps-3">
                                    <h6><?php echo '₱ '.$profit ?></h6>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="col-xxl-6 col-xl-12">
                        <div class="card info-card customers-card">
                           <div class="card-body">
                              <h5 class="card-title">Customers <span>| Total</span></h5>
                              <div class="d-flex align-items-center">
                                 <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-people"></i></div>
                                 <div class="ps-3">
                                    <h6><?php echo $tot_cus_res[0];?></h6>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- cards end -->

                     <!-- chart start -->
                     <div class="col-12 ">
                        <div class="card">
                           <div class="card-body">
                              <h5 class="card-title">Reports <span>| Monthly</span></h5>
                              <div id="reportsChart"></div>
                              <script>document.addEventListener("DOMContentLoaded", () => {
                                 new ApexCharts(document.querySelector("#reportsChart"), {
                                   series: [{
                                     name: 'Sales',
                                     data: <?php echo json_encode($sum_sales)?>,
                                   }, {
                                     name: 'Profit',
                                     data: <?php echo json_encode($sum_profit)?>
                                   }, {
                                     name: 'Expenses',
                                     data: <?php echo json_encode($sum_exp)?>
                                   }],
                                   chart: {
                                     height: 350,
                                     type: 'area',
                                     toolbar: {
                                       show: false
                                     },
                                   },
                                   markers: {
                                     size: 4
                                   },
                                   colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                   fill: {
                                     type: "gradient",
                                     gradient: {
                                       shadeIntensity: 1,
                                       opacityFrom: 0.3,
                                       opacityTo: 0.4,
                                       stops: [0, 90, 100]
                                     }
                                   },
                                   dataLabels: {
                                     enabled: false
                                   },
                                   stroke: {
                                     curve: 'smooth',
                                     width: 2
                                   },
                                   xaxis: {
                                     type: 'mm',
                                     categories: <?php echo json_encode($month)?>
                                   },
                                   tooltip: {
                                     x: {
                                       format: 'mm'
                                     },
                                   }
                                 }).render();
                                 });
                              </script> 
                           </div>
                        </div>
                     </div>
                     <!-- chart end -->

                     <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                           <div class="card-body">
                              <h5 class="card-title">Recent Sales <span>| Records</span></h5>
                              <table class="table table-bordered datatable">
                                 <thead>
                                    <tr>
                                       <th scope="col">Date</th>
                                       <th scope="col">Customer</th>
                                       <th scope="col">Service</th>
                                       <th scope="col">Payment</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                  <?php

                                    $i=0;
                                    while($rows=pg_fetch_assoc($trans_result)) {
                                              ?>
 <tr>
                 <td><?= $rows['tdate']; ?></td>
                 <td><?= $rows['customer_name']; ?></td>
                 <td><?= $rows['service']; ?></td>
                 <td><?= $rows['total_amount']; ?></td>
         </tr>

         <?php
                                            $i++;}
                                    ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="card top-selling overflow-auto">
                           <div class="card-body pb-0">
                              <h5 class="card-title">Recent Expenses <span>| Records</span></h5>
                              <table class="table table-bordered datatable">
                                 <thead>
                                    <tr>
                                       <th scope="col">Date</th>
                                       <th scope="col">Product</th>
                                       <th scope="col">Amount</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 <?php

$i=0;
                                    while($rows=pg_fetch_assoc($ex_result)) {
                                              ?>
 <tr>
                 <td><?= $rows['ex_date']; ?></td>
                 <td><?= $rows['ex_name']; ?></td>
                 <td><?= $rows['ex_amount']; ?></td>
         </tr>

         <?php
         $i++; }
                                        
                                       
                                    ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-5">
                  <div class="card recent-sales overflow-auto">
                     <div class="card-body pb-0">
                        <h5 class="card-title">Recent Customers <span>| Records</span></h5>
                           <table class="table table-bordered datatable">
                                 <thead>
                                    <tr>
                                       <th scope="col">Date</th>
                                       <th scope="col">Customer</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 <?php

$i=0;
                                    while($rows=pg_fetch_assoc($recent_cusrun)) {
                                              ?>
 <tr>
                 <td><?= $rows['cus_date']; ?></td>
                 <td><?= $rows['customer']; ?></td>
         </tr>

         <?php
         $i++;}
                                    ?>
                                 </tbody>
                              </table>
                     </div>
                  </div>
                     <div class="col-lg-15">
                     <div class="card ">
                     <div class="card-body">
                        <h5 class="card-title">Service Distribution <span>| Total</span></h5>
                        <div id="trafficChart" style="min-height: 450px;" class="echart"></div>
                        <script>document.addEventListener("DOMContentLoaded", () => {
                           echarts.init(document.querySelector("#trafficChart")).setOption({
                             tooltip: {
                               trigger: 'item'
                             },
                             legend: {
                               top: '0%',
                               left: 'center'
                             },
                             series: [{
                               name: 'Service Availed',
                               type: 'pie',
                               radius: ['35%', '70%'],
                               avoidLabelOverlap: false,
                               label: {
                                 show: false,
                                 position: 'center'
                               },
                               emphasis: {
                                 label: {
                                   show: true,
                                   fontSize: '18',
                                   fontWeight: 'bold'
                                 }
                               },
                               labelLine: {
                                 show: false
                               },
                               data: [{
                                   value: <?php echo json_encode($reps_nrs)?> ,
                                   name: <?php echo json_encode($services_nrs)?>
                                 },
                                 {
                                   value: <?php echo json_encode($rep_nrj)?>,
                                   name: <?php echo json_encode($nrj)?>
                                 },
                                 {
                                   value: <?php echo json_encode($rep_nrc)?>,
                                   name: <?php echo json_encode($nrc)?>
                                 },
                                 {
                                   value: <?php echo json_encode($rep_rc)?>,
                                   name: <?php echo json_encode($rc)?>
                                 },
                                 {
                                   value: <?php echo json_encode($rep_rj)?>,
                                   name: <?php echo json_encode($rj)?>
                                 },
                                 {
                                   value: <?php echo json_encode($rep_rs)?>,
                                   name: <?php echo json_encode($rs)?>
                                 },
                               ]
                             }]
                           });
                           });
                        </script> 
                     </div>
                  </div>
                  </div>
               </div>

         </section>
      </main>
      <footer id="footer" class="footer">
         <div class="copyright"> &copy; Copyright <strong><span>P-A-A MOY GROUP EMO</span></strong>. All Rights Reserved</div>
      </footer>
      <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>  

       
<!-- scripts for template -->
<script src="assets/js/apexcharts.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/chart.min.js"></script>
        <script src="assets/js/echarts.min.js"></script>
        <script src="assets/js/quill.min.js"></script>
        <script src="assets/js/simple-datatables.js"></script>
        <script src="assets/js/tinymce.min.js"></script>
        <script src="assets/js/validate.js"></script>
        <script src="assets/js/main.js"></script> 
   </body>
</html>