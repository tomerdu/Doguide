<?php
include 'config.php';
include  'db.php';

session_start();

// -------------------------------------------------------------

if(isset($_POST["submit"])){
  if($_FILES["image"]["error"] == 4){
    $newImageName = "default.png";
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

    }}};

    // -------------------------------------------------------


    if(!empty($_POST["Risk"]))
{
    
    $query = "INSERT INTO tbl_dangers_214 
    (user_id, classification, title,
    place, upload_time, img, description, 
    approved_by) values ('" . $_SESSION["id"] ."','" . $_POST["Risk"] . "','" . $_POST["dangerType"]. "','" 
    . $_POST["address"] . "', now(), 'images/$newImageName','" .$_POST["description"] . "',
    '0');";
    
    /*------------------------------------------------------*/
    
    if(!mysqli_query($connection ,$query))
    {
        mysqli_error($connection);
    }
}


// -------------------------------------------------------------------
$querry = "select * from tbl_dangers_214";

if(isset($_POST["Sort"]))
{
$sort = $_POST["Sort"];

    if($sort == "Classification"){
        $querry = "select * from tbl_dangers_214 order by classification";
    }
    elseif ($sort == "Danger"){
        $querry = "select * from tbl_dangers_214 order by title";
    }
    elseif ($sort == "Time"){
        $querry = "select * from tbl_dangers_214 order by upload_time desc";
    }
    elseif ($sort == "sorter"){
        $message = "<p>please select a valid option!</p>";
    }
}

  
$result = mysqli_query($connection,$querry);
if (!$result) {
    die("DB querry falied");
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daners-Zone</title>
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src = "js/script_json.js"></script>
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
                    <li class="breadcrumb-item active" aria-current="page">Dangesr zone</li>
                </ol>
            </nav>
        </div>
        <div id="Container">
            <main id="listMain">
                <h1>Dangers Zone</h1>
                <form action="#" method="post" id="sort">
                    <select id="Type" class="form-select col-6" aria-label="Default select example" name="Sort">
                        <option value="sorter" selected>Sort By</option>
                        <option value="Classification">Classification</option>
                        <option value="Danger">Danger Type</option>
                        <option value="Time">Time</option>
                    </select>   
                    <button type="submit" value="submit" class="" name="sort" >Sort</button>
                </form>
                <?php if (isset($message)) {echo $message;} ?>
                <section id="dangersList">
                    <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<article>";
                            echo "<a href='object.php?id=" .$row["danger_id"] ."'>";
                            echo "<img src='" . $row["img"] . "' alt='" . $row["title"] . "' title='" . $row["title"] . "'>";
                            echo "<h2>". $row["title"] ."</h2>";
                            echo "<h4>Classification:</h4>";
                            echo "<h5>" . $row["classification"] . "</h5>";
                            echo "<h4>Place:</h4>";
                            echo "<h5>" . $row["place"] . "</h5>";
                            echo "</a>";
                            echo "</article>";
                        }
                    ?>
                </section>
            </main>
            <aside id="listAside">
                <div id="searchBarAndTitle">
                    <form class="newDanger" method="post" action="#" enctype="multipart/form-data">
                        <div class="newDangerTitle">
                            <h3>New Danger</h3>
                        </div>
                        <select id="option_type" class="form-select" aria-label="Default select example" name="dangerType">
                        <!-- json injection -->
                        </select>
                        <div class="form-check">
                            <input class="form-check-input" id="High" type="radio" name="Risk"
                                id="flexRadioDefault1" value="High Risk">
                            <label class="form-check-label" for="flexRadioDefault1">
                                High Risk
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="Mid" type="radio" name="Risk"
                                id="flexRadioDefault2" value="Medium Risk">
                            <label class="form-check-label" for="flexRadioDefault2">
                                Mid Risk
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="Low" type="radio" name="Risk"
                                id="flexRadioDefault2" value="Low Risk" checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                Low Risk
                            </label>
                        </div>
                        <div class="row g-3">
                            <div class="col-10">
                                <input id="Address" type="text" class="form-control details"
                                    placeholder="Place (Address)" aria-label="First name" name="address">
                            </div>
                        </div>
                        <h5>More details</h5>
                        <div class="form-floating">
                            <textarea class="form-control details col-10" placeholder="Leave a comment here"
                                id="floatingTextarea" name="description"></textarea>
                            <label for="floatingTextarea">Comments</label>
                        </div>
                        <div class="pic">
                                <input type="file" name="image" id = "image" accept=".jpg, .jpeg, .png" value="">
                            </div>
                        <button type="submit" value="submit" class="dangerButton" name="submit" >submit</button>
                    </form>
                </div>
            </aside>
        </div>
    </div>
    <footer>
        <h2>&#169 Developed and designed by DNT</h2>
    </footer>
    <!-- <?php
     mysqli_free_result($result);
    ?> -->
</body>

</html>
<?php
  mysqli_close($connection);
?>