
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

        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <?php
        if(isset($_SESSION['unameex']) && $_SESSION['unameex'] !='')
        {
?>
        <script>
            swal({
            title: "<?php echo $_SESSION['unameex'];?>",
            text: "Choose another username",
            icon: "error",
            button: "okay!",
            });
</script>
<?php
    unset($_SESSION['unameex']);
        }
?>

<?php
        if(isset($_SESSION['sucname']) && $_SESSION['sucname'] !='')
        {
?>
        <script>
            swal({
            title: "<?php echo $_SESSION['sucname'];?>",
            text: "Please wait for owner approval",
            icon: "success",
            button: "okay!",
            });
</script>
<?php
    unset($_SESSION['sucname']);
        }
?>

<?php
        if(isset($_SESSION['apv']) && $_SESSION['apv'] !='')
        {
?>
        <script>
            swal({
            title: "<?php echo $_SESSION['apv'];?>",
            text: "Staff Applicant Approved",
            icon: "success",
            button: "okay!",
            });
</script>
<?php
    unset($_SESSION['apv']);
        }
?>

<?php
        if(isset($_SESSION['rej']) && $_SESSION['rej'] !='')
        {
?>
        <script>
            swal({
            title: "<?php echo $_SESSION['rej'];?>",
            text: "Staff Applicant Rejected",
            icon: "info",
            button: "okay!",
            });
</script>
<?php
    unset($_SESSION['rej']);
        }
?>

<?php
        if(isset($_SESSION['ord']) && $_SESSION['ord'] !='')
        {
?>
        <script>
            swal({
            title: "<?php echo $_SESSION['ord'];?>",
            text: "You have submitted order",
            icon: "success",
            button: "Done!",
            });
</script>
<?php
    unset($_SESSION['ord']);
        }
?>
<?php
        if(isset($_SESSION['dltdtrans']) && $_SESSION['dltdtrans'] !='')
        {
?>
        <script>
            swal({
            title: "<?php echo $_SESSION['dltdtrans'];?>",
            text: "You have deleted transaction record/s",
            icon: "success",
            button: "Done!",
            });
</script>
<?php
    unset($_SESSION['dltdtrans']);
        }
?>

<?php
        if(isset($_SESSION['servsuc']) && $_SESSION['servsuc'] !='')
        {
?>
        <script>
            swal({
            title: "<?php echo $_SESSION['servsuc'];?>",
            text: "You have Submitted Service Data",
            icon: "success",
            button: "Done!",
            });
</script>
<?php
    unset($_SESSION['servsuc']);
        }
?>

<?php
        if(isset($_SESSION['delserv']) && $_SESSION['delserv'] !='')
        {
?>
        <script>
            swal({
            title: "<?php echo $_SESSION['delserv'];?>",
            text: "Service Data Deleted",
            icon: "info",
            button: "Done!",
            });
</script>
<?php
    unset($_SESSION['delserv']);
        }
?>

<?php
        if(isset($_SESSION['cusuc']) && $_SESSION['cusuc'] !='')
        {
?>
        <script>
            swal({
            title: "<?php echo $_SESSION['cusuc'];?>",
            text: "You have Submitted Customer Data",
            icon: "success",
            button: "Done!",
            });
</script>
<?php
    unset($_SESSION['cusuc']);
        }
?>

<?php
        if(isset($_SESSION['cusdeltd']) && $_SESSION['cusdeltd'] !='')
        {
?>
        <script>
            swal({
            title: "<?php echo $_SESSION['cusdeltd'];?>",
            text: "Customer Data Deleted",
            icon: "info",
            button: "Done!",
            });
</script>
<?php
    unset($_SESSION['cusdeltd']);
        }
?>


<?php
        if(isset($_SESSION['upsum']) && $_SESSION['upsum'] !='')
        {
?>
        <script>
            swal({
            title: "<?php echo $_SESSION['upsum'];?>",
            text: "Daily Report Updated!",
            icon: "info",
            button: "Done!",
            });
</script>
<?php
    unset($_SESSION['upsum']);
        }
?>

<?php
        if(isset($_SESSION['savesum']) && $_SESSION['savesum'] !='')
        {
?>
        <script>
            swal({
            title: "<?php echo $_SESSION['savesum'];?>",
            text: "Daily Report Saved!",
            icon: "success",
            button: "Done!",
            });
</script>
<?php
    unset($_SESSION['savesum']);
        }
?>

<?php
        if(isset($_SESSION['exsave']) && $_SESSION['exsave'] !='')
        {
?>
        <script>
            swal({
            title: "<?php echo $_SESSION['exsave'];?>",
            text: "Expense Data Saved!",
            icon: "success",
            button: "Done!",
            });
</script>
<?php
    unset($_SESSION['exsave']);
        }
?>

<?php
        if(isset($_SESSION['exdeltd']) && $_SESSION['exdeltd'] !='')
        {
?>
        <script>
            swal({
            title: "<?php echo $_SESSION['exdeltd'];?>",
            text: "Expense Data Deleted!",
            icon: "info",
            button: "Done!",
            });
</script>
<?php
    unset($_SESSION['exdeltd']);
        }
?>

<?php
        if(isset($_SESSION['update']) && $_SESSION['update'] !='')
        {
?>
        <script>
            swal({
            title: "<?php echo $_SESSION['update'];?>",
            text: "Data Updated Successfully!",
            icon: "info",
            button: "Done!",
            });
</script>
<?php
    unset($_SESSION['update']);
        }
?>

<?php
        if(isset($_SESSION['invalid']) && $_SESSION['invalid'] !='')
        {
?>
        <script>
            swal({
            title: "<?php echo $_SESSION['invalid'];?>",
            text: "Invalid Username or Password",
            icon: "error",
            button: "Okay!",
            });
</script>
<?php
    unset($_SESSION['invalid']);
        }
?>

<?php
        if(isset($_SESSION['inv']) && $_SESSION['inv'] !='')
        {
?>
        <script>
            swal({
            title: "<?php echo $_SESSION['inv'];?>",
            text: "Customer Still has Transactions!",
            icon: "error",
            button: "Okay!",
            });
</script>
<?php
    unset($_SESSION['inv']);
        }
?>

<?php
        if(isset($_SESSION['notsubmit']) && $_SESSION['notsubmit'] !='')
        {
?>
        <script>
            swal({
            title: "<?php echo $_SESSION['notsubmit'];?>",
            text: "Please Check the Data!",
            icon: "error",
            button: "Okay!",
            });
</script>
<?php
    unset($_SESSION['notsubmit']);
        }
?>

