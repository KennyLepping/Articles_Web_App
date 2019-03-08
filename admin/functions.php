<?php 

function redirect($location){
    header("Location:" . $location);
    exit;

}

function ifItIsMethod($method=null) { // Function argument is null in case method passed to the method is null (argument becomes optional)
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
        return true;
    }
    return false;
}

function isLoggedIn() {
    if(isset($_SESSION['user_role'])) {
        return true;
    }
    return false;
}

function checkIfUserIsLoggedInAndRedirect($redirectLocation=null) {
    
    if(isLoggedIn()) {
        redirect($redirectLocation);
    }
    
} // Checks if user is logged in and redirects user

function escape($string) {
    global $connection;
    
    return mysqli_real_escape_string($connection, trim($string));
}

function confirmQuery($result) {
    
    global $connection;
    
    if(!$result) {
        die('QUERY FAILED' . mysqli_error($connection));
    }
    
}

function insert_categories() {
    
    global $connection;

    if(isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];

        if($cat_title == "" || empty($cat_title)) {
            echo "This field should not be empty.";
        }
        else {
            $stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES(?) ");
            
            mysqli_stmt_bind_param($stmt, 's', $cat_title);
            
            mysqli_stmt_execute($stmt);

            if(!$stmt) {
                die('QUERY FAILED' . mysqli_error($connection));
            }
            mysqli_stmt_close($stmt);
        }
    }
}

function find_all_categories() {
     
    global $connection;
    
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query); 

    while($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>"; 
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>"; 
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";
    }
}
    
function delete_category() {
    global $connection;
    
    if(isset($_GET['delete'])){
        $the_cat_id = $_GET['delete'];

        $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id} ";

        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php"); // Reloads the page
    }
}

// Returns the number posts, comments, users, and categories for the admin homepage based on $table
function recordCount($table) {
    global $connection;
    
    $query = "SELECT * FROM $table"; 
    $select_all_posts = mysqli_query($connection, $query);
    
    return $result = mysqli_num_rows($select_all_posts);

}

// Checks the status of posts, users, and comments to be counted on admin/index.php
function checkStatus($table, $column, $status) {
    global $connection;
    
    $query = "SELECT * FROM $table WHERE $column = '$status'"; 
    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result); 
}

function is_admin($username) {
    global $connection;
    
    $query = "SELECT user_role FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    
    $row = mysqli_fetch_array($result);
    
    if($row['user_role'] == 'admin') {
        return true;
    }
    else {
        return false;
    }
}

function is_subscriber($username) {
    global $connection;
    
    $query = "SELECT user_role FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    
    $row = mysqli_fetch_array($result);
    
    if($row['user_role'] == 'subscriber') {
        header("Location: ../index.php");
    }
    return false;
}

function username_exists($username) {
    global $connection;
    
    $stmt = mysqli_prepare($connection, "SELECT username FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if(mysqli_stmt_num_rows($stmt) > 0) {
        return true;
    }
    else {
        return false;
    }
    mysqli_stmt_close($stmt);
}

function email_exists($email) {
    global $connection;
    
    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    
    if(mysqli_num_rows($result) > 0) {
        return true;
    }
    else {
        return false;
    }
}

function register_user($username, $email, $password) { // Registers new user - make sure query has all values
    global $connection;
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    //  The mysqli_real_escape_string() function escapes special characters in a string for use in an SQL statement.
    $username = mysqli_real_escape_string($connection, $_POST['username']); 
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    $password = password_hash( $password, PASSWORD_BCRYPT, array('cost' => 12));

    $query = "INSERT INTO users (username, user_email, user_password, user_role, user_firstname, user_lastname, token) ";
    $query .= "VALUES('{$username}', '{$email}', '{$password}', 'subscriber', '', '', '')";
    $register_user_query = mysqli_query($connection, $query);

    confirmQuery($register_user_query); 
    
}

function login_user($username, $password) {
    global $connection;
    
    $username = trim($username);
    $password = trim($password);
    
    $username = mysqli_real_escape_string($connection, $username); // Prevents MySQL injection
    $password = mysqli_real_escape_string($connection, $password);
    
    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);
    
    if(!$select_user_query) {
        die("Query Failed" . mysqli_error($connection));
    }

    while($row = mysqli_fetch_array($select_user_query)) {
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];
    
        if (password_verify($password,$db_user_password)) {
            $_SESSION['username'] = $db_username;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;


            if($db_user_role == 'admin') {
                redirect("/phpfun/Articles_Web_App/admin");
            }
            else if($db_user_role == 'subscriber') {
                redirect("/phpfun/Articles_Web_App");
            }
        }
        else {
            return false;
        }
    }
    return true;
}

function login_check($redirect) { // Additional check that redirects subscriber or admin to the correct page
    if(ifItIsMethod('post')) {
        if(isset($_POST['username']) && isset($_POST['password'])) {
            login_user($_POST['username'], $_POST['password']);
        }
        else {
            redirect('/phpfun/Articles_Web_App/' . $redirect);
        }
    }
}

function users_online() {
    
    if(isset($_GET['onlineusers'])) {
    
        global $connection;
        
        if(!$connection) {
            session_start();
            
            include("../includes/db.php");

            $session = session_id(); // This function catches the id of current session
            $time = time(); // This function keeps track of the seconds gone by
            $time_out_in_seconds = 30; // If user is online for more than 30 seconds than amount of users decreases for demonstration purposes
            $time_out = $time - $time_out_in_seconds;

            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);

            if($count == NULL) {
                 mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session','$time')");
            }
            else {
                mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
            }

            $users_online_query =  mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'"); // Where time online is greater than 30 seconds

            echo $count_user = mysqli_num_rows($users_online_query);
        }
        
    } // Get request isset()

}

users_online();

?>