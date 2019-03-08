<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?> 

<?php 

if($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    $error = [
        
        'username' => '',
        'email' => '',
        'password' => ''
        
    ];
    
    if(strlen($username) < 4) {
        $error['username'] = 'Username needs to be longer.';
        
    }
    
    if(strlen($username) == '') {
        $error['username'] = 'Username cannot be empty.';
        
    }
    
    if(username_exists($username)) {
        $error['username'] = 'Username already exists. Please choose another username.';
    }
    
    if(strlen($email) == '') {
        $error['email'] = 'Email cannot be empty.';
        
    }
    
    if(username_exists($email)) {
        $error['email'] = 'Email already exists. <a href="index.php"> Please login</a>';
    }
    
    if($password == '') {
        $error['password'] = 'Password cannot be empty.';
    }
    
    foreach($error as $key => $value) { // Checks if there are strings in the $error array and unsets elements if empty to finish the loop
        if(empty($value)) {
            unset($error[$key]);
        }
    }
    
    if(empty($error)) {  // If the error string is empty, then the user is registered then logged in
        register_user($username, $email, $password);
        
        login_user($username, $password);
    }
        
}

?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                       
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Create Username"
                            autocomplete="on" 
                            
                            value="<?php echo isset($username) ? $username : ''; // If $username is empty, then the error message is displayed ?>">
                            
                                <p><?php echo isset($error['username']) ? $error['username'] : ''; ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com"
                            autocomplete="on" 
                            
                            value="<?php echo isset($email) ? $email : ''; ?>">
                            
                            <p><?php echo isset($error['email']) ? $error['email'] : ''; ?></p>
                        </div>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Create Password">
                            
                            <p><?php echo isset($error['password']) ? $error['password'] : ''; ?></p>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn-primary btn-lg btn-block" value="Register">
                   
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

        <hr>

<?php include "includes/footer.php";?>
