<?php
    session_start();
    include 'dbConnect.php';

    $email = $_SESSION["email"];
    $sql = "SELECT name, password FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if($result){
        $row = mysqli_fetch_assoc($result);
        $name = $row["name"];
    } else {
        echo "Error fetching user details.";
    }
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
            <button class="back-btn"><a href="profile.php">Go Back</a></button>
            <h1>Update Profile</h1>

            <label for="name">Name</label>
            <input type="text" name="name" value="<?php echo $name ?>">
            <br>

            <label for="email">Email</label>
            <input type="email" name="email" value="<?php echo $_SESSION["email"] ?>">
            <br>

            <label for="password">Enter new password (keep it blank to leave it unchanged)</label>
            <input type="password" name="password">
            <br>
            <br>

            <div class="buttons">
                <input type="submit" name="update" value="Update" class="btn">
                <button class="btn log-out"><a href="logout.php">Log out</a></button>
            </div>
        </form>
    </section>
</body>
</html>

<?php

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);

    if (isset($_POST['update'])){
        if (!empty($_POST['password'])){
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $password = mysqli_real_escape_string($conn, $hash);
    
            $query = "UPDATE users SET name='$name', email='$new_email', password='$password' WHERE email='$email' ";
            $query_run = mysqli_query($conn, $query);
    
            if ($query_run) {
                $_SESSION["email"] = $new_email;
                header("Location: profile.php?success=Account+updated+successfully");
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
        else{
            $query = "UPDATE users SET name='$name', email='$new_email' WHERE email='$email' ";
            $query_run = mysqli_query($conn, $query);
    
            if ($query_run) {
                $_SESSION["email"] = $new_email;
                header("Location: profile.php?success=Account+updated+successfully");
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }

?>