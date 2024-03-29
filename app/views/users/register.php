<?php require APPROOT."/views/inc/header.php" ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Create an Account</h2>
            <p>Please fill this form to register whit us</p>
            <form action="<?php echo URLROOT;?>/users/register" method="post">
            <div class="form-group mt-2">
                <label for="name">Name: <sup>*</sup></label>
                <input type="text" name="name" class="form-control form-control-lg <?php echo(!empty($data["name_err"]))? "is-invalid": ""; ?> " value="<?php echo $data['name'] ?>">
                <span class="invalid-feedback"><?php echo $data["name_err"] ?></span>
            </div>
            <div class="form-group mt-2">
                <label for="email">Email: <sup>*</sup></label>
                <input type="email" name="email" class="form-control form-control-lg  <?php echo(!empty($data["email_err"]))? "is-invalid": ""; ?>" value="<?php echo $data['email'] ?>">
                <span class="invalid-feedback"><?php echo $data["email_err"] ?></span>
            </div>
            <div class="form-group mt-2">
                <label for="password">Password: <sup>*</sup></label>
                <input type="password" name="password" class="form-control form-control-lg <?php echo(!empty($data["password_err"]))? "is-invalid": ""; ?>" value="<?php echo $data['password'] ?>">
                <span class="invalid-feedback"><?php echo $data["password_err"] ?></span>
            </div>
            <div class="form-group mt-2">
                <label for="confirm_pass">Confirm Password: <sup>*</sup></label>
                <input type="password" name="confirm_pass" class="form-control form-control-lg <?php echo(!empty($data["confirm_pass_err"]))? "is-invalid": ""; ?>" value="<?php echo $data['confirm_pass'] ?>">
                <span class="invalid-feedback"><?php echo $data["confirm_pass_err"] ?></span>
            </div>
            <div class="row">
                <div class="col-7">
                    <input type="submit" value="Register" class="btn btn-outline-primary w-50 mt-4">
                </div>
                <div class="col">
                    <a href="<?php echo URLROOT;?>/users/login" class="btn btn-light mt-4 float-right">Have an account? Login</a>  
                </div>
            </div>

            </form>
            
        </div>
    </div>
</div>


<?php require APPROOT."/views/inc/footer.php" ?>