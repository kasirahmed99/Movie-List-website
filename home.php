<?php
session_start();

$servername = "localhost"; 
$username = "root";
$password = ""; 
$database = "mozilista"; 


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = sha1($password);

    //
    $sql = "SELECT id FROM users WHERE user_name = ? AND password = ?";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ss", $username, $hashedPassword);

    // Execute the statement
    if ($stmt->execute() === FALSE) {
        die("Error executing SQL statement: " . $stmt->error);
    }

    // Get the result
    $result = $stmt->get_result();

    // Check if there is a row returned
    if ($result->num_rows == 1) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - MoziLista</title>
    <!-- CSS styles -->
    <style>
        body {
            background-color: #111;
        }

        h1 {
            font-family: 'Times New Roman', Times, serif, sans-serif;
            font-style: italic;
            font-size: 50px;
            color: #E90D0D;
            text-align: center;
            text-transform: uppercase;
            margin-top: 30px;
        }

        h2 {
            color: #da0c0c;
        }

        h3 {
            color: #f2eeee;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #da0c0c;
        }

        li {
            float: left;
        }

            li a {
                display: block;
                color: white;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
            }

                li a:hover {
                    background-color: #111;
                }


        iframe {
            width: 100%;
            height: 400px;
            border: none;
            margin-bottom: 20px
        }

        p {
            color: #f2eeee;
        }

        #video-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .video-container {
            flex: 1;
            margin-right: 20px;
        }

            .video-container video {
                width: 100%;
                height: auto;
            }

            .video-container iframe {
                width: 100%;
                height: auto;
            }

        #map-section {
            width: 100%;
            height: 25%;
            position: sticky;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+Z6Lqg5x8N9xu2+j0Ipe0qXh+8tjy5BDJi8jv4u" crossorigin="anonymous">
</head>


<body>

    <h1>MoziLista </h1>

    <ul>
        <?php if (isset($_SESSION['username'])) : ?>
        <li><a href="index.php?menu=logout">Log Out</a></li>
        <li><a href="index.php?menu=add_movie">Add Movie</a></li>
        <li><a href="index.php?menu=movie_list">Movie List</a></li>
        <li><a href="index.php?menu=gallery">Image Gallery</a></li>
        <li><a href="index.php?menu=upload_image">Upload Image</a></li>
        <li><a href="index.php?menu=view_message">Messages</a></li>
        <?php else : ?>
        <li><a href="index.php?menu=login">Log In</a></li>
        <li><a href="index.php?menu=register">Register</a></li>
        <?php endif; ?>
        <li><a href="index.php?menu=contact">Contact</a></li>
    </ul>
    <h2>How it works:</h2>
    <h3>Create an Account:</h3>
    <p>
        Sign up for a free account to get started.
        Simply provide your email and choose a password.
    </p>

    <h3>Log In:</h3>
    <p>
        Once you've created an account, log in to access your personalized movie lists.
    </p>

    <h3>Add Movies:</h3>

    <p>
        Start adding movies to your lists. You can categorize them as:
    </p>

    <p>Watching: Movies you're currently watching.</p>
    <p>Watched: Movies you've already watched.</p>
    <p>To Watch: Movies you want to watch in the future.</p>

    <p>
        With MoziLista, you'll never forget a movie you want to watch or lose track of what you've already seen.<br>
        Keep your movie-watching experience organized and enjoyable!
    </p>



    <!--video source and Css-->
    <section id="video-section">
        <div class="video-container">
            <video controls autoplay>
                <source src="assets/video.mp4" type="video/mp4">
            </video>
        </div>
        <div class="video-container">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/SOP5v53DD74" frameborder="0" allowfullscreen></iframe>
        </div>
    </section>



    <section id="map-section">
        <h2>Our Location</h2>
        <iframe src="https://www.google.com/maps/place/Kecskem%C3%A9t,+Izs%C3%A1ki+%C3%BAt+10,+6000/@46.8951452,19.6662058,17z/data=!4m6!3m5!1s0x4743da7757651367:0xfe9bb765d75b9fc6!8m2!3d46.8951452!4d19.6676768!16s%2Fg%2F11bw4337jh?entry=ttu" frameborder="0" allowfullscreen></iframe>
    </section>
    


 <?php include 'footer.php'; ?>
