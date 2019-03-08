      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
           
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <!-- Hamburger menu -->
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/phpfun/Articles_Web_App">Home</a>
            </div>
            
            <!-- Collect the nav links, forms, and other content for toggling -->
            
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                   
                   <?php 
                    global $connection;
                    $query = "SELECT * FROM categories LIMIT 3";
                    
                    $select_all_categories_query = mysqli_query($connection, $query); 
                    
                    while($row = mysqli_fetch_assoc($select_all_categories_query)) {
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];
                        
                        $category_class = '';
                        $registration_class = '';
                        $contact_class = '';
                        
                        $pageName = basename($_SERVER['PHP_SELF']); // basename($_SERVER['PHP_SELF']) gets the category id from the url (the URL name after the /)
                        $registration = 'registration.php';
                        $contact = 'contact.php';
                        $login = 'login.php';
                        
                        if(isset($_GET['category']) && $_GET['category'] == $cat_id) {
                            $category_class = 'active';
                        } 
                        else if($pageName == $registration) {
                            $registration_class = 'active';
                        }
                        else if($pageName == $contact) {
                            $contact_class = 'active';
                        }
                        else if($pageName == $login) {
                            $login_class = 'active';
                        }
                        
                        echo "<li class='$category_class'><a href='/phpfun/Articles_Web_App/category/$cat_id'>{$cat_title}</a></li>"; // "" for putting variable inside echo statement
                    } 
                    
                    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                        echo "<li><a href='/phpfun/Articles_Web_App/admin'>Admin</a></li>";
                    }
                    else {
                        echo "";
                    }
                       
                   ?>
                    
                    <?php if(isLoggedIn()): ?>
                    
                    <li class="<?php echo $login_class; ?>">
                        <a href="/phpfun/Articles_Web_App/includes/logout.php">Logout</a>
                    </li>
                    
                    <?php else: ?>
                    
                    <li class="<?php echo $login_class; ?>">
                        <a href="/phpfun/Articles_Web_App/login">Login</a>
                    </li>
                    
                    <?php endif; ?>

                    <li class="<?php echo $registration_class; ?>">
                        <a href="/phpfun/Articles_Web_App/registration">Register</a>
                    </li>
                       
                    <li class="<?php echo $contact_class ?>">
                        <a href="/phpfun/Articles_Web_App/contact">Contact</a>
                    </li>
                    
                    <?php 
                    
                    if(isset($_SESSION['user_role'])) { // *For users and administrators to edit their posts
                        if(isset($_GET['p_id'])) {
                            $the_post_id = $_GET['p_id'];
                                
                            echo "<li><a href='/phpfun/Articles_Web_App/admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";
                        }
                    }
                    
                    ?>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>