<?php
    include 'config.php';
    include  'db.php';
    
    session_start();
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home-page</title>
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
                    <li class="breadcrumb-item active" aria-current="page">Home Page</li>
                </ol>
            </nav>
        </div>
        <div id="Container">
            <main id="homePageMain">
                <div class="leftMain">
                    <h2>Dog Details</h2>
                    <div class="upperDiv">
                        <div class="dogDetails">
                            <h3>Status:</h3>
                            <h4>Charging</h4>
                        </div>
                        <div class="dogDetails">
                            <h3>Battery:</h3>
                            <h4>87%</h4>
                        </div>
                        <div class="dogDetails">
                            <h3>Last inspection:</h3>
                            <h4>12.07.2022</h4>
                        </div>
                    </div>
                    <div class="lowerDiv">
                        <div class="todayTracks">
                            <h2>Today's Tracks</h2>
                            <div class="dividerLine"></div>
                        </div>
                        <div class="trackDetails">
                            <h4>07:37</h4>
                            <h4>School</h4>
                            <img src="images/Add_Alert_Icon.png" alt="">
                            <div class="dividerLine"></div>
                        </div>
                        <div class="trackDetails">
                            <h4>12:30</h4>
                            <h4>Home</h4>
                            <img src="images/Add_Alert_Icon.png" alt="">
                            <div class="dividerLine"></div>
                        </div>
                        <div class="trackDetails">
                            <h4>15:42</h4>
                            <h4>Ping Pong</h4>
                            <img src="images/Add_Alert_Icon.png" alt="">
                            <div class="dividerLine"></div>
                        </div>
                    </div>
                </div>
                <div class="rightMain">
                    <h2 id="dangersTitle">Dangers List</h2>
                    <main id="listMain">
                        <a href="list.php">
                            <h3>Dangers Zone</h3>
                        </a>
                    <section id="dangersList">
                        <?php
                            $querry = "select * from tbl_dangers_214 order by upload_time desc limit 4;";
                            $result = mysqli_query($connection,$querry);
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
                </div>
            </main>
            <aside>
                <div id="searchBarAndTitle">

                    <div class="picSlider">
                        <h3>You should join our community...</h3>
                        <div class="slideshow-container">

                            <div class="mySlides">
                                <div class="numbertext">1 / 3</div>
                                <img src="images/pingPong.png">
                                <div class="text">Ping Pong</div>
                            </div>

                            <div class="mySlides">
                                <div class="numbertext">2 / 3</div>
                                <img src="images/bike.jpg">
                                <div class="text">Bike Riding</div>
                            </div>

                            <div class="mySlides">
                                <div class="numbertext">3 / 3</div>
                                <img src="images/goalball.jfif">
                                <div class="text">Goalball</div>
                            </div>

                            <a class="prev" onclick="plusSlides(-1)">❮</a>
                            <a class="next" onclick="plusSlides(1)">❯</a>

                        </div>
                        <br>

                        <div style="text-align:center">
                            <span class="dot" onclick="currentSlide(1)"></span>
                            <span class="dot" onclick="currentSlide(2)"></span>
                            <span class="dot" onclick="currentSlide(3)"></span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
    <footer>
        <h2>&#169 Developed and designed by DNT</h2>
    </footer>
    <script>
        window.onload = () => { showSlides(slideIndex); }
    </script>
</body>

</html>