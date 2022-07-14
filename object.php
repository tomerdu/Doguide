<?php
    include 'config.php';
    include  'db.php';

    session_start();
    
    $prodId = $_GET["id"];
    
    if(isset($_POST["Removing"])){
        $updateComment = "DELETE FROM tbl_comments_214 WHERE comment_id = " . $_POST["comment_id"];
        mysqli_query($connection,$updateComment);

    }

    if(isset($_POST["sendComment"])){
        $newComment = "insert into tbl_comments_214 (danger_id, user_id, content, upload_time) values (" . $prodId  . ", " . $_SESSION["id"] . ", '" . $_POST["content"] ."', now() ) ";
        mysqli_query($connection,$newComment);
    }

    if(isset($_POST["EditComment"])){
        $updateComment = "update tbl_comments_214 set content = '" . $_POST["newContent"] . "', upload_time = now() where comment_id = " . $_POST["comment_id"];
        mysqli_query($connection,$updateComment);

    }
    
    if(isset($_POST["aprrove"])) {
        $updateQuery = "update tbl_dangers_214 set approved_by = approved_by + 1 where danger_id =" . $prodId;
        mysqli_query($connection,$updateQuery);
        $updateQuery = "insert into tbl_approve_214 (danger_id, user_id) values (" . $prodId . ", " .$_SESSION["id"] ." ) ";
        mysqli_query($connection,$updateQuery);
    }
    
    $checkApproved = "select * from tbl_approve_214 where danger_id =" . $prodId . " AND user_id = " . $_SESSION["id"];
    $ApproveResult = mysqli_query($connection,$checkApproved);

    $query = "select * from tbl_dangers_214 inner join tbl_users_214 using(user_id) where danger_id=" . $prodId;
    $comments = "select * from tbl_comments_214 inner join tbl_users_214 where 
    tbl_comments_214.danger_id = ". $prodId ." and tbl_comments_214.user_id = tbl_users_214.user_id order by upload_time desc;";
    
    $result = mysqli_query($connection, $query);
    if(!$result) {
      die("DB query failed.");
    }
    else
    {
        $row = mysqli_fetch_assoc($result);
    }

    $data = mysqli_query($connection, $comments);
    if(!$data) {
      die("DB query failed.");
    }
    

    // --------------------------------------------------

    if(isset($_POST["delete"]))
    {
        $query_delete_comment = "DELETE FROM tbl_comments_214 WHERE danger_id = $prodId";
        if(!mysqli_query($connection,$query_delete_comment))
        {
            die("DB query failed.");
        }
        $query_delete_approve = "DELETE FROM tbl_approve_214 WHERE danger_id = $prodId";
        if(!mysqli_query($connection,$query_delete_approve))
        {
            die("DB query failed.");
        }
        $query_delete = "DELETE FROM tbl_dangers_214 WHERE danger_id = $prodId";
        if(mysqli_query($connection,$query_delete))
        {
            header('location: ' . URL . 'list.php');
        }
        else
        {
            die("DB query failed.");
        }      
    }

    if(isset($_POST["submit"]))
    {
        if($_FILES["image"]["error"] == 4){
            $newImageName = $_POST["defaultImage"];
          }
          else{
            $fileName = $_FILES["image"]["name"];
            $fileSize = $_FILES["image"]["size"];
            $tmpName = $_FILES["image"]["tmp_name"];
        
            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode('.', $fileName);
            $imageExtension = strtolower(end($imageExtension));
            if ( !in_array($imageExtension, $validImageExtension) ){
              echo
              "
              <script>
                alert('Invalid Image Extension');
              </script>
              ";
            }
            else if($fileSize > 1000000){
              echo
              "
              <script>
                alert('Image Size Is Too Large');
              </script>
              ";
            }
            else{
              $newImageName = uniqid();
              $newImageName .= '.' . $imageExtension;
        
              move_uploaded_file($tmpName, 'images/' . $newImageName);
                
              $newImageName = 'images/' . $newImageName;
            }
        }

        // --------------------------------------------------

        $query_update = "UPDATE tbl_dangers_214 SET 
        classification='" . $_POST["Risk"] . "', title= '" . $_POST["dangerType"] . "', 
        place='" . $_POST["address"] . "', upload_time = now(), 
        img= '$newImageName' , description='" . $_POST["description"] . "'
        , approved_by= 0  WHERE danger_id =" . $row["danger_id"] . ";";

        if(mysqli_query($connection,$query_update))
        {
            header('location: ' . URL . 'list.php');
        }
        else
        {
            die("DB query failed.");
        }      
    }

    // --------------------------------------------------


?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Object-page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script defer src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</head>
<body>
<header>
        <nav class="navbar navbar-light bg-none">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="homepage.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list.php">Dangers zone</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">Account Details</a>
                        </li>
                    </ul>
                </div>
            </div>
            </div>
            </nav>
            <a href="#" alt="Doguide" class="logo"></a>
            <div class="user">
                <div class="Logout">
                <h4>Hello,<br><?php echo $_SESSION["fname"] . " " . $_SESSION["lname"];?></h4>
                    <a href="logout.php"><span>Log out</span></a>
            </div>
            <?php
            echo "<img src='" . $_SESSION["image"] . "' alt='' class='Shoshi'>";
            ?>
        </div>
        <div class="headerLine"></div>
    </header>
    <div id="wrapper">
        <div id="breadCrumbsAndSearchBar">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="homepage.php">Home Page</a></li>
                    <li class="breadcrumb-item"><a href="list.php">Dangers zone</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Object Page</li>
                </ol>
            </nav>
        </div>
        <div class="objectTitle">
            <div class="Title">
                <h1><?php echo $row["title"]; ?></h1>
                <h2><?php echo $row["classification"]; ?></h2>
            </div>
        </div>
        <div id="Container">
            <main id="objectMain">
                <div class="dangerDetails">
                    <div>
                        <h3>Danger Number</h3>
                        <h4><?php echo "00" . $row["danger_id"];?></h4>
                    </div>
                    <div>
                        <h3>Place</h3>
                        <h4><?php echo $row["place"] ?></h4>
                    </div>
                    <div>
                        <h3>Uploaded At </h3>
                        <h4><?php echo $row["upload_time"] ?></h4>
                    </div>
                    <div>
                        <h3>Approved by </h3>
                        <h4><?php echo $row["approved_by"] ?></h4>
                    </div>
                </div>
                    <div class="uploaderComment">
                        <div class="rightTitle">
                            <h3>Uploaded By:</h3>
                            <h4><?php echo $row["f_name"] . " " . $row["l_name"];?></h4>
                            
                        </div>
                        <h3>Uploader Comment</h3>
                        <p><?php echo $row["description"] ?> </p>
                        <div id="buttons">
                           <?php if ($row["user_id"] == $_SESSION["id"]) {
                                echo '<form action="#"  method="post"> 
                                <button type="submit" class="objectButton" name="edit">Edit</button>
                                <button class="objectButton red" type="submit" value="submit" name="delete"> Remove </button>
                                </form>';}
                                elseif (mysqli_fetch_assoc($ApproveResult)){
                                    echo '<button id =approve class="ApprovedButton objectButton" name="aprrove">Aprroved</button>';
                                } 
                                else 
                                {
                                echo '<form action="#"  method="post"> 
                                <button  id = approve type="submit" class="objectButton" name="aprrove">Aprrove</button>
                                </form>';} ?>
                        </div>
                        <img src="<?php echo $row["img"] ?>" alt="">
                    </div>
            </main>
            <aside id="objectAside" 
            <?php if(isset($_POST["edit"]))
            {
                echo 'style="display: none;"';
            }
            else
            {
                echo 'style="display: flex;"';
            }?>>
                <div id="searchBarAndTitle">
                    <div class="moreComments">
                        <h3>More Comments</h3>
                        <form action="#" method="post">
                            <button type="submit" value="submit" name="Add" >Add</button>
                        </form>
                    </div>
                    <div class="total-comments">
                    <?php
                        if(isset($_POST["Add"])){
                        echo "<form action='#' method='post'>";   
                        echo   "<div class='form-floating'>";
                        echo    "<textarea class='form-control details col-10' placeholder='Leave a comment here'
                                id='floatingTextarea' name='content' value=''></textarea>";
                        echo    "<label for='floatingTextarea'>Comments</label>";
                        echo "</div>";
                        echo "<button type='submit' value='submit' class='dangerButton' name='sendComment'>Send</button>";
                        echo "</form>";
                        }
                        elseif(isset($_POST["Editing"])){
                            echo "<form action='#' method='post'>";   
                            echo   "<div class='form-floating'>";
                            echo "<input type='hidden' name='comment_id' value= '". $_POST["comment_id"] ."'>";   
                            echo    "<textarea class='form-control details col-10' placeholder='Leave a comment here'
                                    id='floatingTextarea' name='newContent' value=''>" . $_POST["text"] . "</textarea>";
                            echo    "<label for='floatingTextarea'>Comments</label>";
                            echo "</div>";
                            echo "<button type='submit' value='submit' class='dangerButton' name='EditComment'>Send</button>";
                            echo "</form>";
                        }
                    else
                        {
                            while ($line = mysqli_fetch_assoc($data)) {
                                echo "<div class='comments'>";
                                echo "<div class='commentTitle'>";
                                echo "<h5>" . $line["f_name"] . " " . $line["l_name"] . "</h5>";
                                echo  "<p>" . $line["upload_time"] . "</p>";
                                echo "</div>";
                                echo "<h6>" . $line["content"] . "</h6>";
                                if($line["user_id"] == $_SESSION["id"]){
                                    echo "<form action='#' method='post'>";
                                    echo "<input type='hidden' name='comment_id' value= '". $line["comment_id"] ."'>";   
                                    echo "<input type='hidden' name='text' value= '". $line["content"] ."'>";   
                                    echo "<button type='submit' value='submit' name='Editing' class='commentEditor' >Edit</button>";
                                    echo "<button type='submit' value='submit' name='Removing' class='commentEditor' >Remove</button>";
                                    echo "</form>";
                                }
                                echo "<div class='dividerLine'></div>";
                                echo "</div>";
                            }
                            
                        }
                    ?>                 
                    </div>
                </div>
            </aside>
            <aside id="listAside"
            <?php if(isset($_POST["edit"]))
            {
                echo 'style="display: flex;"';
            }
            else
            {
                echo 'style="display: none;"';
            }?>>
                <div id="searchBarAndTitle">
                    <form class="newDanger" method="post" action="" enctype="multipart/form-data">
                        <div class="newDangerTitle">
                            <h3>Edit Danger</h3>
                        </div>
                        <select id="Type" class="form-select" aria-label="Default select example" name="dangerType">
                            <option value="Electric Pole" <?php if($row["title"] == "Electric Pole") {echo 'selected';} ?>>Electric Pole</option>
                            <option value="Constructions Area" <?php if($row["title"] == "Constructions Area") {echo 'selected';} ?>>Constructions Area</option>
                            <option value="Down Hills" <?php if($row["title"] == "Down Hills") {echo 'selected';} ?>>Down Hills</option>
                            <option value="Object Blocks" <?php if($row["title"] == "Object Blocks") {echo 'selected';} ?>>Object Blocks</option>
                            <option value="Ground Holes" <?php if($row["title"] == "Ground Holes") {echo 'selected';} ?>>Ground Holes</option>
                            <option value="Broken Signpost" <?php if($row["title"] == "Broken Signpost") {echo 'selected';} ?>>Broken Signpost</option>
                            <option value="Stairs" <?php if($row["title"] == "Stairs") {echo 'selected';} ?>>Stairs</option>
                            <option value="Slope" <?php if($row["title"] == "Slope") {echo 'selected';} ?>>Slope</option>
                        </select>
                        <div class="form-check">
                            <input class="form-check-input" id="High" type="radio" name="Risk"
                                id="flexRadioDefault1" value="High Risk" <?php if($row["classification"] == "High Risk") {echo 'checked';} ?>>
                            <label class="form-check-label" for="flexRadioDefault1">
                                High Risk
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="Mid" type="radio" name="Risk"
                                id="flexRadioDefault2" value="Medium Risk" <?php if($row["classification"] == "Medium Risk") {echo 'checked';} ?>>
                            <label class="form-check-label" for="flexRadioDefault2">
                                Mid Risk
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="Low" type="radio" name="Risk"
                                id="flexRadioDefault2" value="Low Risk"  <?php if($row["classification"] == "Low Risk") {echo 'checked';} ?>>
                            <label class="form-check-label" for="flexRadioDefault2">
                                Low Risk
                            </label>
                        </div>
                        <div class="row g-3">
                            <div class="col-10">
                                <input id="Address" type="text" class="form-control details"
                                    placeholder="Place (Address)" aria-label="First name" name="address" value="<?php echo $row["place"]; ?>">
                            </div>
                        </div>
                        <h5>More details</h5>
                        <div class="form-floating">
                            <textarea class="form-control details col-10" placeholder="Leave a comment here"
                                id="floatingTextarea" name="description" value=""><?php echo $row["description"] ?></textarea>
                            <label for="floatingTextarea">Comments</label>
                        </div>
                        <div class="pic">
                                <h5>Add a picture</h5>
                        </div>
                                <input type="hidden" name="defaultImage" value="<?php echo $row["img"] ?>">
                                <input type="file" name="image" id = "image" accept=".jpg, .jpeg, .png" value="">
                        <button type="submit" value="submit" class="dangerButton" name="submit" >submit</button>
                    </form>
                </div>
            </aside>
        </div>
    </div>
    </div>
    <footer>
        <h2>&#169 Developed and designed by DNT</h2>
    </footer>
    <script>
        window.onload = () => { fill(); }
    </script>
</body>

</html>





