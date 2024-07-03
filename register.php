<?php
session_start();
  
?>
<?php 
include_once 'include/header.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 py-3 bg-white from-wrapper">
            <div class="container shadow-lg py-3">
            	<h3>Register</h3>
            	<hr>
                <form action="formcode.php" method="POST">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="name">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?php echo (isset($_SESSION ['insert']['name']['value']))? $_SESSION ['insert']['name']['value']:""?>">
                            <small>
                                <?php
                                if(isset($_SESSION['insert']['name']['error']))
                                {
                                    echo $_SESSION ['insert']['name']['error'];
                                }
                                ?>
                            </small>                       
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="mobile">Mobile</label>
                            <input type="text" name="mobile" id="mobile" class="form-control" value="<?php echo (isset($_SESSION ['insert']['mobile']['value']))? $_SESSION ['insert']['mobile']['value']:""?>"">
                            <small>
                                <?php
                                if(isset($_SESSION['insert']['mobile']['error']))
                                {
                                    echo $_SESSION ['insert']['mobile']['error'];
                                }
                                ?>
                            </small> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo (isset($_SESSION ['insert']['email']['value']))? $_SESSION ['insert']['email']['value']:""?>"">
                        <small>
                                <?php
                                if(isset($_SESSION['insert']['email']['error']))
                                {
                                    echo $_SESSION ['insert']['email']['error'];
                                }
                                ?>
                            </small> 
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" value="">
                            <small>
                                <?php
                                if(isset($_SESSION['insert']['password']['error']))
                                {
                                    echo $_SESSION ['insert']['password']['error'];
                                }
                                ?>
                            </small> 
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="cpassword">Confirm Password</label>
                            <input type="cpassword" name="cpassword" id="password" class="form-control" value="">
                            <small>
                                <?php
                                if(isset($_SESSION['insert']['cpassword']['confirm_error']))
                                {
                                    echo $_SESSION ['insert']['cpassword']['confirm_error'];
                                }
                                ?>
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <input type="submit" value="register" name="register" class="btn btn-primary">
                        </div>
                        <div class="col-12 col-sm-8 text-right">
                            <a href="login.php">Already have an account yet?</a>
                        </div>
                    </div>
                </form>
            </div>
            
        </div>
    </div>  
</div>
<?php include_once 'include/footer.php'; ?>