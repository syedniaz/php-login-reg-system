<?php
    session_start();
    include 'dbConnect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <section class="container">
        <form action="" method="post" class="form-el">
            <h1>Sign Up Page</h1>

            <label for="name">Name</label>
            <input type="text" name="name">
            <br>

            <label for="email">Email</label>
            <input type="email" name="email">
            <br>

            <label for="password">Password</label>
            <input type="password" name="password">
            <br>

            <label for="con_password">Confirm Password</label>
            <input type="password" name="con_password">

            <?php
                $error = (isset($_GET["error"])) ? $_GET["error"]: "";
                if (!empty($_GET["error"])){
                    echo "<p class='error'>$error</p>";
                }

                $success = (isset($_GET["success"])) ? $_GET["success"]: "";
                if (!empty($_GET["success"])){
                    echo "<p class='success'>$success</p>";
                }
            ?>

            <br>

            <input type="submit" name="register" value="Register" class="btn">

            <p>Already have an account? <a href="login.php">Login</a></p>

        </form>
        
    </section>
</body>
</html>

<?php

    if (isset($_POST['register'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        $sql = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if (empty($name)){
            header("Location: index.php?error=Name field cannot be empty");
        }
        elseif (empty($email)){
            header("Location: index.php?error=Email field cannot be empty");
        }
        elseif (empty($_POST['password'])){
            header("Location: index.php?error=Password field cannot be empty");
        }
        elseif (empty($_POST['con_password'])){
            header("Location: index.php?error=Please confirm your password");
        }
        elseif (empty(strpos($email, "."))){
            header("Location: index.php?error=Please enter a valid email");
        }
        else{
            if(mysqli_num_rows($result) > 0){
                header("Location: index.php?error=User with same email already exists");
            }
            else{
                if (strlen($_POST['password']) >= 8){
                    if ($_POST['password'] == $_POST['con_password']){
                        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                        $password = mysqli_real_escape_string($conn, $hash);
                
                        $query = "INSERT INTO users (name,email,password) VALUES ('$name','$email','$password')";
                
                        $query_run = mysqli_query($conn, $query);
                        if ($query_run) {
                            header("Location: login.php?success=Account+created+successfully");
                        } else {
                            header("Location: index.php?error=Something+went+wrong+Please+try+again");
                        }
                    }
                    else{
                        header("Location: index.php?error=Passwords don't match");
                    }
                }
                else{
                    header("Location: index.php?error=Password has to be at least 8 characters");
                }
            }
        }
    }
    
?>