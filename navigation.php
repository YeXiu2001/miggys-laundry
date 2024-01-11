<?php 

$user_data = check_login($con);
$name = $user_data['first_name'];
$surname = $user_data['last_name'];
$admin_id = $user_data['id'];
$utype = $user_data['user_type'];
$uname = $user_data['username'];
$pword = $user_data['password'];

   //for notif staff approval
	$not_que = "SELECT COUNT(*) FROM admin_accounts where status = 'no'";
	$not_run = pg_query($con, $not_que);
	$not_res = pg_fetch_array($not_run);

   $adm_query = "SELECT * FROM admin_accounts WHERE status = 'no' order by id desc limit 1";
   $adm_result = pg_query($con, $adm_query);
?> 

<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <title>Dashboard - Admin Bootstrap Template</title>
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
    <!-- navigation bar -->
    <header id="header" class="header fixed-top d-flex align-items-center">
         <div class="d-flex align-items-center justify-content-between"> <a href="#" class="logo d-flex align-items-center"> <img src="assets/img/logo.png" alt=""> <span class="d-none d-lg-block"><h4><strong>Miggy's Laundry Shop</strong></h4></span> </a> <i class="bi bi-list toggle-sidebar-btn"></i></div>
         
         <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
               <li class="nav-item d-block d-lg-none"> <a class="nav-link nav-icon search-bar-toggle " href="#"> <i class="bi bi-search"></i> </a></li>
               <li class="nav-item dropdown">
                  <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown"> <i class="bi bi-bell"></i> <span class="badge bg-primary badge-number"><?php echo $not_res[0]; ?></span> </a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                     <li class="dropdown-header"> You have <strong><?php echo $not_res[0]; ?></strong> new staff applicants <a href="staff.php"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a></li>
                     <li>
                        <hr class="dropdown-divider">
                     </li>
                     <li class="notification-item">
                        <i class="bi bi-exclamation-circle text-warning"></i>
                        <div>
                           <h4>Staff Applicant</h4>
                           <p>
                           <?php 
                                    if(pg_num_rows($adm_result) > 0)
                                    {
                                        foreach($adm_result as $rows)
                                            {
                                              echo $rows['first_name'].' '.$rows['last_name'];
                                            }
                                          }else{
                                             echo "There's no staff application";
                                          }
                                 ?>
                                 </p>
                           <p>
                              <?php 
                                    if(pg_num_rows($adm_result) > 0)
                                    {
                                        foreach($adm_result as $rows)
                                            {
                                              echo $rows['date'];
                                            }
                                          }
                                 ?></p>
                           
                        </div>
                     </li>
                  </ul>
               </li>
               <li class="nav-item dropdown pe-3">
                  <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown"> <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle"> <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $name ?></span> </a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                     <li class="dropdown-header">
                        <h6><?php echo $name?></h6>
                        <span><?php echo $utype?></span>
                     </li>
                     <li>
                        <hr class="dropdown-divider">
                     </li>
                     <li> <a class="dropdown-item d-flex align-items-center" href="profile.php"> <i class="bi bi-person"></i> <span>My Profile</span> </a></li>
                     <li>
                        <hr class="dropdown-divider">
                     </li>
                     <li> <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <i class="bi bi-box-arrow-right"></i> <span>Sign Out</span> </a></li>
                  </ul>
               </li>
            </ul>
         </nav>
      </header>
<!-- navigation bar end -->

<!-- Logout Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Ready To Leave</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to leave the current session?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Stay</button>
        <a href="logout.php"><button type="button" class="btn btn-primary">Leave</button></a>
      </div>
    </div>
  </div>
</div>

</body>
</html>