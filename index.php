<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<body>

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
               
               <?php 
                
                $per_page = 2;
                
                if(isset($_GET['page'])) {
                    
                    $page = $_GET['page'];
                }
                else {
                    $page = "";
                }
                
                if($page == "" || $page == 1) {
                    $page_1 = 0;
                }
                else {
                    $page_1 = ($page * $per_page) - $per_page;
                }
                
                if(isset($_SESSION['username']) && is_admin($_SESSION['username'])) {
                    $post_query_count = "SELECT * FROM posts ";
                } else {
                    $post_query_count = "SELECT * FROM posts WHERE post_status = 'published'";  
                } 

                $find_count = mysqli_query($connection, $post_query_count);
                $count = mysqli_num_rows($find_count); // Counts the number of rows in the database query
                
                if($count < 1) { // If there are no posts available - $count keeps track of the number of posts per page
                    echo "<h1 class='text-center'>No posts available</h1>";
                } else {
                
                $count = ceil($count / $per_page); // ceil() rounds float (decimal) up
                
                if(isset($_SESSION['username']) && is_admin($_SESSION['username'])) {
                    $query = "SELECT * FROM posts ORDER BY post_id DESC LIMIT $page_1, $per_page";
                }   
                else {
                    $query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC LIMIT $page_1, $per_page";
                }
                $select_all_posts_query = mysqli_query($connection, $query); 
                    
                echo "<h1>Articles</h1>";
                
                // While loop for iterating through post info from the posts table
                while($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_user = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = substr($row['post_content'], 0, 100);
                        $post_status = $row['post_status'];
                ?>

                <!-- First Blog Post -->
                
                <h2 class="space-above">
                    <a href="post/<?php echo $post_id; ?>"><?php echo $post_title; echo ($post_status == 'draft') ? ' (Draft)' : ''; ?></a>
                </h2>
                    <p class="lead">
                        by <a href="author_posts.php?author=<?php echo $post_user; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_user; ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; // Date changes to the date the post is updated in admin ?></p>
                <hr>
                    <a href="post.php?p_id=<?php echo $post_id; ?>">
                        <img class="img-responsive" src="/phpfun/Articles_Web_App/images/<?php echo $post_image; ?>" alt="">
                    </a>
                <hr>
                    <p><?php echo $post_content; ?></p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr> 
                        
                 <?php } } ?>
               
            </div>

                <!-- Contains the sidebar menu -->
                <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>
        
        <ul class="pager">
            
            <?php 
            
            for($i = 1; $i <= $count; $i++) { // $count is half of the total posts
                if($i == $page) {
                    echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>"; // For making the current page number styled as an active link
                }
                else {
                    echo "<li><a href='index.php?page={$i}'>{$i}</a></li>"; // Horizontally lists page numbers at bottom of web page
                }
            }
            
            ?>
            
        </ul>

        <?php include "includes/footer.php"; ?>