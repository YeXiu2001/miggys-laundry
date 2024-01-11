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