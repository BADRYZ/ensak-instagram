<?php
include("../../connection.php");
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram</title>
    <link rel="stylesheet" href="../../sass/vender/bootstrap.css">
    <link rel="shortcut icon" type="x-icon" href="..\..\images\instaicon.png">
    <link rel="stylesheet" href="../../sass/vender/bootstrap.min.css">
    <link rel="stylesheet" href="../../owlcarousel/owl.theme.default.min.css">
    <link rel="stylesheet" href="../../owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.css">
    <link rel="stylesheet" href="../../sass/main.css">
    <style>
        /* Style for modal */
        .create_modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .create_modal-content {
            background-color: #f2f2f2; /* Light gray background */
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            height: auto;
            border-radius: 10px; /* Rounded corners */
            text-align: center; /* Center align content */
        }
        
        .create_modal-content h1 {
            color: #333; /* Dark gray text color */
            margin-bottom: 20px; /* Add some space below the heading */
        }
        
        .create_modal-content button {
            background-color: #c171d5; /* Purple button background */
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px; /* Add space between buttons and upload fields */
            float: right;
            margin-left: 300px;
            margin: 10px; /* Add space between buttons */
        }
        
        .create_modal-content button:hover {
            background-color: #e5a9f4; /* Lighter purple on hover */
        }
        
        .create_modal-content input[type=file],
        .create_modal-content select,
        .create_modal-content textarea {
            margin: 0 auto 10px auto; /* Center align and add space below */
            width: 40%; /* Take 40% of the page width */
            padding: 8px; /* Add some padding */
            border: 1px solid #ccc; /* Light gray border */
            border-radius: 5px; /* Rounded corners */
            box-sizing: border-box; /* Include padding and border in the element's total width and height */
        }
        
        .create_modal-content button, .create_modal-content input[type=file], .create_modal-content select {
            display: block; /* Display buttons and inputs as block elements */
        }         
        
        textarea {
            display: block; 
        } 

        .main_section {
            margin-top: 10px;
            margin-left: 100px; 
            min-height: 100vh;
            width: 100vw;
        }
        .show_posts {
            /* margin-left: 100px; */
            width: 500px;
            height: auto;
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            gap: 8px;
        }
        .show_posts .post {
            width: 100%;
            height: auto;
            border-bottom: 1px solid gray;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .show_posts .post img {
            width: 100%;
            object-fit: contain;
        }
        .show_posts .post caption {
            font-size: 16px;
        }
        .show_posts .post .hashtags {
            font-size: 12px;
            color: blue;
        }


    </style>
</head>
<body>

    <div class="post_page">
        <!--***** nav menu start ****** -->
        <div class="nav_menu">
            <div class="fix_top">
                <!-- nav for big->medium screen -->
                <div class="nav">
                    <div class="logo">
                        <a href="http://localhost/ensk_insta/src/views/home.php">
                            <img class="d-block d-lg-none small-logo" src="../../images/instagram.png" alt="logo">
                            <img class="d-none d-lg-block" src="../../images/logo_menu.png" alt="logo">
                        </a>
                    </div>
                    <div class="menu">
                        <ul>
                            <li>
                                <a class="active" href="http://localhost/ensk_insta/src/views/home.php">
                                    <img src="../../images/accueil.png">
                                    <span class="d-none d-lg-block ">Home</span>
                                </a>
                            </li>
                            <li id="search_icon">
                                <a href="#">
                                    <img src="../../images/search.png">
                                    <span class="d-none d-lg-block search">Search </span>
                                </a>
                            </li>
                            <!-- <li>
                                <a href="../../explore.html">
                                    <img src="../../images/compass.png">
                                    <span class="d-none d-lg-block ">Explore</span>
                                </a>
                            </li> -->
                            <li>
                                <a href="./reels.html">
                                    <img src="../../images/video.png">
                                    <span class="d-none d-lg-block ">Reels</span>
                                </a>
                            </li>
                            <li>
                                <a href="./messages.html">
                                    <img src="../../images/send.png">
                                    <span class="d-none d-lg-block ">Messages</span>
                                </a>
                            </li>
                            <li class="notification_icon">
                                <a href="#">
                                    <img src="../../images/love.png">
                                    <span class="d-none d-lg-block ">Notifications</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#create_modal">
                                    <img src="../../images/tab.png">
                                    <span class="d-none d-lg-block " onclick="openModal()">Create</span>
                                    
                                </a>

                            </li>
                            <li>
                                <a href="../../profile.html">
                                    <!-- Here we need to put the user's image -->
                                    <?php
                                    $user_id = $_SESSION['user_id'];
                                    $sql = "SELECT f.file FROM files f JOIN users u ON u.image_id = f.file_id WHERE u.user_id = $user_id ;";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        $profile_picture = $result->fetch_assoc()['file'];
                                        echo '<img class="circle story" src="data:image/jpeg;base64,'.base64_encode($profile_picture).'"/>';
                                    }
                                    ?>
                                    <span class="d-none d-lg-block ">Profile</span>
                                </a>
                            </li>                            
                        </ul>
                    </div>
                    <div class="more">
                        <div class="btn-group dropup">
                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img src="../../images/menu.png">
                                <span class="d-none d-lg-block ">More</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">
                                        <span>Settings</span>
                                        <img src="../../images/reglage.png">
                                    </a></li>
                                <li><a class="dropdown-item" href="#">
                                        <span>Your activity</span>
                                        <img src="../../images/history.png">
                                    </a></li>
                                <li><a class="dropdown-item" href="#">
                                        <span>Saved</span>
                                        <img src="../../images/save-instagram.png">
                                    </a></li>
                                <li><a class="dropdown-item" href="#">
                                        <span>Switch apperance</span>
                                        <img src="../../images/moon.png">
                                    </a></li>
                                <li><a class="dropdown-item" href="#">
                                        <span>Report a problem</span>
                                        <img src="../../images/problem.png">
                                    </a></li>
                                <li><a class="dropdown-item bold_border" href="#">
                                        <span>Switch accounts</span>
                                    </a></li>
                                <li><a class="dropdown-item" href="./login.html">
                                        <span>Log out</span>
                                    </a></li>
                            </ul>
                        </div>
                        <!--  -->

                    </div>
                <!-- Create modal -->
        <div class="create_modal" id="create_modal">
            <div class="create_modal-content">
                <h1>Create a new post</h1>
                <form action="../controllers/create_post.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="file">
                    <select name="type">
                        <option value="image">Image</option>
                        <option value="video">Video</option>
                    </select>
                    <textarea name="caption" id="caption" placeholder="Write a caption about your post"></textarea>
                    <textarea name="hashtags" id="hashtags" placeholder="#travelling, #Eating ..."></textarea>
                    <button type="submit" name="submit">Add Post</button>
                </form>
                <button onclick="closeModal()">Close</button>
            </div>
        </div>

    </div>

    <div class="main_section">
        <!-- Here we'll try to display the posts -->
        <div class="show_posts">
            <?php
            //1. We need to get the data from the database:
            $sql = "SELECT p.*, f.file, GROUP_CONCAT(h.hashtag SEPARATOR ', ') AS hashtags FROM posts p LEFT JOIN files f ON p.image_id = f.file_id LEFT JOIN hashtagmappings hm ON p.POST_ID = hm.POST_ID LEFT JOIN hashtags h ON hm.HASHTAG_ID = h.HASHTAG_ID GROUP BY p.POST_ID ORDER BY p.DATETIME_ADDED DESC;";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $image = base64_encode($row['file']);
                    $caption = $row['CAPTION'];
                    $hashtags = $row['hashtags'];
                    echo '<div class="post">';
                    echo '<img src="data:image/jpeg;base64,'.$image.'" />';
                    echo '<div class="caption">'.$caption.'</div>';
                    echo '<div class="hashtags">'.$hashtags.'</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
    

    <script>
        function openModal() {
            document.getElementById('create_modal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('create_modal').style.display = 'none';
        }
    </script>
</body>

</html>