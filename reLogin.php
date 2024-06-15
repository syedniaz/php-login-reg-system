<?php
    session_start();
    include 'dbConnect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reauthenticate</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    
    <section class="container">
        
        <form action="reLogin.php" method="post" class="form-el">
            <?php
                $success = (isset($_GET["success"])) ? $_GET["success"]: "";
                if (!empty($_GET["success"])){
                    echo "<p class='success'>$success</p>";
                }
            ?>

            <h1>Confirm your identity</h1>

            <label for="email">Email</label>
            <input type="email" name="email">
            <br>

            <label for="password">Password</label>
            <input type="password" name="password">
            <br>

            <?php
                $error = (isset($_GET["error"])) ? $_GET["error"]: "";
                if (!empty($_GET["error"])){
                    echo "<p class='error'>$error</p>";
                }
            ?>

            <input type="submit" name="login" value="Login" class="btn">

            <p>Don't have an account? <a href="index.php">Sign Up</a></p>
        </form>
    </section>
</body>
</html>

<?php
    if(isset($_POST["login"])){
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);

        $sql = "SELECT password FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            if(password_verify($password, $row["password"])){ 
                $_SESSION["email"] = $email;
                header("Location: updateProfile.php");
            } else {
                // echo "<script>
                //     alert('Incorrect Password');
                //     window.location.href='login.php';
                //     </script>";
                header("Location: reLogin.php?error=Incorrect+Password");
            }
        } else {
            header("Location: reLogin.php?error=Email+not+found");
        }
    }
?>