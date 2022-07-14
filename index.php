<?php

include 'db.php';
include 'config.php';

session_start();

if (!empty($_POST["loginMail"])) {
    $query = "SELECT * FROM tbl_users_214 WHERE email ='"
        . $_POST["loginMail"]
        . "'and password ='"
        . $_POST["loginPass"]
        . "'";

    /*------------------------------------------------------*/

    $result = mysqli_query($connection, $query);
    $row    = mysqli_fetch_array($result);

    if (is_array($row)) {
        $_SESSION["fname"] = $row["f_name"];
        $_SESSION["lname"] = $row["l_name"];
        $_SESSION["id"] = $row["user_id"];
        $_SESSION["job"] = $row["job"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["phone"] = $row["phone"];
        $_SESSION["address"] = $row["address"];
        $_SESSION["image"] = $row["img_user"];
        header('location: ' . URL . 'homepage.php');
    } else {
        $message = "Invalid Username or Password !";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home-page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script defer src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <a href="#" alt="Doguide" class="logo"></a>
    </header>

    <div class="warpper-form">
        <div class="content">
            <h1>Login</h1>
            <form action="#" method="post" id="frm">
                <div class="form-group">
                    <label for="loginMail">Email: </label>
                    <input type="email" class="form-control" name="loginMail" id="loginMail" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="loginPass">Password: </label>
                    <input type="password" class="form-control" name="loginPass" id="loginPass" placeholder="Enter Password">
                </div>
                <button type="submit" class="btn btn-primary loginBtn">Log Me In</button>
                <div class="error-message"><?php if (isset($message)) {
                                                echo $message;
                                            } ?></div>
            </form>
        </div>
    </div>
</body>

</html>