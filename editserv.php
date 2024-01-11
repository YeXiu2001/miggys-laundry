<?php
session_start();
	include('connections.php');
	include('functions.php');
    include('bootstrap.php');
    
    if(isset($_POST['update'])){

        $ser_upid = $_GET['editid'];
    
        $service =  $_POST['service'];
        $price = $_POST['price'];
        $laundry = $_POST['laundry_type'];
    
        $ser_up_sql = pg_query($con, "UPDATE laundry_type_services SET service_type='$service',laundry_type=' $laundry',price='$price' WHERE laundry_id = '$ser_upid'");
    
        if ($ser_up_sql){
            header("Location: services.php?upd=1");
            $_SESSION['update'] = "Data Update?!";
            die;
        }else{
            echo "<script>alert('Error');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Services</title>
</head>
<body>
            <!-- sidebar and navigation -->
            <?php
            include('sidebar.php');
            include('navigation.php');
        ?>
      <!-- sidebar and navigation --> 
      <main id="main" class="main">
    <section>
<div class="card">
<div class="card-body">
<div class="card-title"><h3><strong>Edit Service Details</strong></h3></div>
            <!-- Forms -->
            <form class="row g-2"  method="POST">

<?php
				$ser_upid = $_GET['editid'];
				$ser_upque = pg_query($con, "SELECT * FROM laundry_type_services WHERE laundry_id = '$ser_upid'");
				while($rows=pg_fetch_array($ser_upque)){
			?>

 <div class="col">
    <label for="service" class="form-label"> <strong>Service Type </strong> </label>
    <input type="text" class="form-control" id="service" placeholder="e.g (rush, non-rush)" value="<?php echo $rows['service_type'];?>" name="service">
</div>

<div class="col">
    <label for="laundry_type" class="form-label"><strong>Laundry Type </strong></label>
    <input type="text" class="form-control" id="laundry_type" value="<?php echo $rows['laundry_type'];?>"  placeholder="e.g (Shirts, Jeans, Comforters)" name="laundry_type">
</div>

<div class="col">
 <label for="price" class="form-label"><strong> Price per KG</strong></label>
    <input type="text" class="form-control" id="price" value="<?php echo $rows['price'];?>"  placeholder="Price per Kilogram" name="price">
</div>
<div class="mb-3">
<a data-bs-toggle="modal" data-bs-target="#upserv"><button type="submit"class="btn btn-primary" id="button" >Update</button></a>
<!-- Modal -->
<div class="modal fade" id="upserv" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-centered">
                           <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            Are you sure to update service data?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="update" >Update</button>
      </div>
    </div>
</div>
</div>
<!-- end modal -->
		<button class="btn btn-secondary">
		<a class="text-light" href="services.php">
                        Cancel
                        </a>
        </div>
</form> 
<?php

				}
				?>
</div>
</div>
    </section>
      </main>
      <?php include('script.php')?>
</body>
</html>