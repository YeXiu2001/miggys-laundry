<?php 
session_start();

	include("connections.php");
	include("functions.php");
    include("bootstrap.php");
    include("bg.php");

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
		$username = $_POST['uname'];
		$password = $_POST['pword'];

		if(!empty($username) && !empty($password) && !empty($fname) && !empty($lname) && !is_numeric($username))
		{
         $chckque = "select count(*) from admin_accounts where username = '$username'";
         $chk_run = pg_query($con, $chckque);
         $chk_fetch = pg_fetch_array($chk_run);
         
         if($chk_fetch[0] > 0){
           $_SESSION['unameex'] ="Username is already taken!";

         }
         else{
			//save to database
			$query = "CALL reg_staff('$fname','$lname','$username','$password')";
      
			$query_run = pg_query($con, $query);
         
         if($query_run){
         header("Location: login.php?sucuname=1");
         $_SESSION['sucname'] ="Account Creation Successful!";
         die;
                        }
      }
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>SIGNUP</title>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

    </head>
    <body>
    <main>
         <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
               <div class="container">
                  <div class="row justify-content-center">
                     <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="card mb-3">
                           <div class="card-body">
                              <div class="pt-4 pb-2">
                                 <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                                 <p class="text-center small">Enter your personal details to create account</p>
                              </div>
                              <form class="row g-3 needs-validation" novalidate method="POST">
                                 <div class="col-12">
                                    <label for="fname" class="form-label">First Name</label> <input type="text" name="fname" class="form-control" id="fname" required>
                                    <div class="invalid-feedback">Please, enter your first name!</div>
                                 </div>
                                 <div class="col-12">
                                    <label for="lname" class="form-label">Last Name</label> <input type="text" name="lname" class="form-control" id="lname" required>
                                    <div class="invalid-feedback">Please enter your last name!</div>
                                 </div>
                                 <div class="col-12">
                                    <label for="uname" class="form-label">Username</label>
                                    <div class="input-group has-validation">
                                       <span class="input-group-text" id="inputGroupPrepend">@</span> <input type="text" name="uname" class="form-control" id="uname" required>
                                       <div class="invalid-feedback">Please choose a username.</div>
                                    </div>
                                 </div>
                                 <div class="col-12">
                                    <label for="pword" class="form-label">Password</label> <input type="password" name="pword" class="form-control" id="pword" required>
                                    <div class="invalid-feedback">Please enter your password!</div>
                                 </div>
                                 <div class="col-12">
                                    <div class="form-check">
                                       <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required> <label class="form-check-label" for="acceptTerms">I agree and accept the <a href="#">terms and conditions</a></label>
                                       <div class="invalid-feedback">You must agree before submitting.</div>
                                    </div>
                                 </div>
                                 <div class="col-12"> <button class="btn btn-primary w-100" type="submit">Create Account</button></div>
                                 <div class="col-12">
                                    <p class="small mb-0">Already have an account? <a href="login.php">Log in</a></p>
                                 </div>
                              </form>
                           </div>
                        </div>
                      
                     </div>
                  </div>
               </div>
            </section>
         </div>
      </main>
<?php include('script.php') ?>
    </body>
</html>
