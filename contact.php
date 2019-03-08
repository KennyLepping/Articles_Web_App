<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
 
<?php 

$message = '';

if(isset($_POST['submit'])) {
  
    $to      = "kennylepping@gmail.com";
    $subject = wordwrap($_POST['subject'], 70);
    $body    = $_POST['body'];
    $header  = "From: " . $_POST['email'];
        
    if(!empty($subject) && !empty($body) && !empty($header)) {
        mail($to, $subject, $body, $header);
        $message = "Your message has been submitted.";
    }  
    else {
        $message = "Fields cannot be empty.";
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
                <h1>Contact</h1>
                    <form role="form" action="" method="post" id="login-form" autocomplete="off">
                      
                        <h5 class="text-center"><?php echo $message; ?></h5>
                       
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                        </div>
                        
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter your subject">
                        </div>
                        
                         <div class="form-group">
                            <textarea class="form-control" name="body" id="body" cols="50" rows="10"></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn-primary btn-lg btn-block" value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

        <hr>

<?php include "includes/footer.php";?>
