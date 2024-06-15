<?php
    session_start();
    include 'dbConnect.php';
     
    $email = $_SESSION["email"];
    $sql = "SELECT name FROM users WHERE email = '$email'";
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
    <title>Profile Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <section class="container">
        <div class="form-el">
            <?php
                $success = (isset($_GET["success"])) ? $_GET["success"]: "";
                if (!empty($_GET["success"])){
                    echo "<p class='success'>$success</p>";
                }
            ?>

            <p>Hello <?php echo $name;?></p>

            <p>Your Email: <?php echo $email;?></p>

            <div class="buttons">
                <button class="btn"><a href="reLogin.php">Update Profile</a></button>
                <button class="btn log-out"><a href="logout.php">Log out</a></button>
            </div>
        </div>
    </section>
</body>
</html>

<?php

?>