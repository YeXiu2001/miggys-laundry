<?php 
session_start();

	include("connections.php");
	include("functions.php");
	include("bootstrap.php");
	include("bg.php");

	if ( isset($_GET['sucuname']) && $_GET['sucuname'] == 1 )
{
	 unset($_SESSION['sucuname']);
}

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//variables from html forms
		$username = $_POST['uname'];
		$password = $_POST['pword'];
		//check input
		if(!empty($username) && !empty($password) && !is_numeric($username))
		{

			//db query
			$query = "select * from admin_accounts where username = '$username' AND password = '$password' AND user_type = 'Owner'";
			$result = pg_query($con, $query);

			$query2 = "select * from admin_accounts where username = '$username' AND password = '$password' AND user_type = 'Staff' AND status = 'yes'";
			$result2 = pg_query($con, $query2);

			$query3 = "select * from admin_accounts where username = '$username' AND password = '$password' AND status = 'no'";
			$result3 = pg_query($con, $query3);

			if($result)
			{
				if($result && pg_num_rows($result) > 0)
				{

					$user_data = pg_fetch_assoc($result);
					
					if($user_data['password'] === $password)
					{

						$_SESSION['username'] = $user_data['username'];
						$_SESSION['password'] = $user_data['password'];
						header("Location:index.php");
						die;
					}else{
						$_SESSION['invalid'] = "Invalid Account Details!";
					}
				}
			}else{
				$_SESSION['invalid'] = "Invalid Account Details!";
			}
			
			if($result2)
			{
				if($result2 && pg_num_rows($result2) > 0)
				{

					$user_data = pg_fetch_assoc($result2);
					
					if($user_data['password'] === $password)
					{

						$_SESSION['username'] = $user_data['username'];
						$_SESSION['password'] = $user_data['password'];
						header("Location:index2.php");
						die;
					
					}else{
						$_SESSION['invalid'] = "Invalid Account Details!";}
				}else{
					$_SESSION['invalid'] = "Invalid Account Details!";
				}
			}else{
				$_SESSION['invalid'] = "Invalid Account Details!";}
			
			if($result3){
				if($result3 && pg_num_rows($result3) > 0)
				{
					$user_data = pg_fetch_assoc($result3);
					
					if($user_data['password'] === $password)
					{
						$_SESSION['username'] = $user_data['username'];
						$_SESSION['password'] = $user_data['password'];
					$_SESSION['invalid'] = "Invalid Account Details!";
					}
				}
			}
		}else //for walang input sa textbox
		{
			echo "invalid username or password!";
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
		<title>Login Page</title>
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
                                 <h5 class="card-title text-center pb-0 fs-4"><strong>Login to Your Account</strong></h5>
                                 <p class="text-center small">Enter your Username and Password to login</p>
                              </div>
                              <form class="row g-3 needs-validation" novalidate method="POST">
                                 <div class="col-12">
                                    <label for="uname" class="form-label">Username</label>
                                    <div class="input-group has-validation">
                                       <span class="input-group-text" id="inputGroupPrepend">@</span> <input type="text" name="uname" class="form-control" id="uname" required>
                                       <div class="invalid-feedback">Please enter your username.</div>
                                    </div>
                                 </div>
                                 <div class="col-12">
                                    <label for="pword" class="form-label">Password</label> <input type="password" name="pword" class="form-control" id="pword" required>
                                    <div class="invalid-feedback">Please enter your password!</div>
                                 </div>
                                 <div class="col-12"> <button class="btn btn-primary w-100" type="submit">Login</button></div>
                                 <div class="col-12">
                                    <p class="small mb-0">Don't have account? <a href="signup.php">Create an account</a></p>
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
<?php include('script.php');?>
	</body>
</html>

