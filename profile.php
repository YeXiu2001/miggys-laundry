<?php
    session_start();

	include("connections.php");
	include("functions.php");
    include("bootstrap.php");

    $user_data = check_login($con);
    $name = $user_data['first_name'];
    $surname = $user_data['last_name'];
    $admin_id = $user_data['id'];
    $utype = $user_data['user_type'];
    $uname = $user_data['username'];
    $pword = $user_data['password'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
</head>
<body>
         <!-- sidebar and navigation -->
   <?php
      include('sidebar.php');
      include('navigation.php');
   ?>
      <!-- sidebar and navigation -->

      <main id="main" class="main">
         <div class="pagetitle">
            <h1>Profile</h1>
            <nav>
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                  <li class="breadcrumb-item">Users</li>
                  <li class="breadcrumb-item active">Profile</li>
               </ol>
            </nav>
         </div>
         <section class="section profile">
            <div class="row">
               <div class="col-xl-4">
                  <div class="card">
                     <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                        <h2><?php echo $name ?></h2>
                        <h3>Miggy's Laundry Shop<?php echo ' '.$utype ?></h3>
                        <div class="social-links mt-2"> <a href="#" class="twitter"><i class="bi bi-twitter"></i></a> <a href="#" class="facebook"><i class="bi bi-facebook"></i></a> <a href="#" class="instagram"><i class="bi bi-instagram"></i></a> <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a></div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-8">
                  <div class="card">
                     <div class="card-body pt-3">
                        <ul class="nav nav-tabs nav-tabs-bordered">
                           <li class="nav-item"> <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button></li>
                           <!-- <li class="nav-item"> <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button></li> -->
                        </ul>
                        <div class="tab-content pt-2">
                           <div class="tab-pane fade show active profile-overview" id="profile-overview">
                              <h4 class="card-title">Profile Details</h4>
                              <div class="row">
                                 <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                 <div class="col-lg-9 col-md-8"><?php echo $name.' '.$surname; ?></div>
                              </div>
                              <div class="row">
                                 <div class="col-lg-3 col-md-4 label">Position</div>
                                 <div class="col-lg-9 col-md-8"><?php echo $utype ;?></div>
                              </div>
                              <div class="row">
                                 <div class="col-lg-3 col-md-4 label">Username</div>
                                 <div class="col-lg-9 col-md-8"><?php echo $uname ?></div>
                              </div>
                              <div class="row">
                                 <div class="col-lg-3 col-md-4 label">Password</div>
                                 <div class="col-lg-9 col-md-8"><?php echo $pword ?></div>
                              </div>
                           </div>
                           <!-- <div class="tab-pane fade pt-3" id="profile-change-password">
                              <form class="row g-3 needs-validation" novalidate  method="POST">
                                 <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-lg-4 col-form-label"><strong>New Password</strong></label>
                                    <div class="col-md-8 col-lg-8"> 
                                       <input name="password" type="password" class="form-control" id="password" required>
                                       <div class="invalid-feedback">Please enter correct password!</div>
                                    </div>
                                 </div>
                                 <div class="row mb-3">
                                    <label for="re-password" class="col-md-4 col-lg-4 col-form-label"><strong>Re-Enter New Password</strong></label>
                                    <div class="col-md-8 col-lg-8"> 
                                       <input name="repassword" type="password" class="form-control" id="repassword" required>
                                       <div class="invalid-feedback">Please enter correct password!</div>
                                    </div>
                                 </div>
                                 <div class="text-center"> <button type="submit" class="btn btn-primary" name="cpass">Change Password</button></div>
                              </form>
                           </div> -->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </main>
      <?php include('script.php')  ?>
</body>
</html>