<?php
// Include necessary files and configurations
include_once "../../config.php"; // Assuming this file contains database connection configuration
include_once "../../Controller/topicC.php"; // Assuming this file contains the Topic controller
include_once "../../Model/topic.php"; // Assuming this file contains the Topic model

// Initialize variables
$error = "";


$topicC = new TopicC();
    $topic = $topicC->getTopicById($_GET["id"]);
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if required fields are set and not empty
    if (
        isset($_POST["topicTitle"]) &&
        isset($_POST["topicContent"])
    ) {
        if (
            !empty($_POST["topicTitle"]) &&
            !empty($_POST["topicContent"])
        ) {
            // Process image upload if provided
            $imageName = ""; // Initialize image name variable
            if (isset($_FILES["topicImage"]) && $_FILES["topicImage"]["error"] === 0) {
                // A new image is uploaded in the form
                $imageTmpName = $_FILES["topicImage"]["tmp_name"];
                $imageExt = strtolower(pathinfo($_FILES["topicImage"]["name"], PATHINFO_EXTENSION));
                $allowedExts = array("jpg", "jpeg", "png");
                if (in_array($imageExt, $allowedExts)) {
                    $imageName = uniqid() . "." . $imageExt;
                    $imageDestination = "../Back Office/uploads/" . $imageName;
                    move_uploaded_file($imageTmpName, $imageDestination);
                } else {
                    $error = "Invalid image format. Only JPG, JPEG, and PNG files are allowed.";
                }
            } elseif (!empty($_POST["existingImage"])) {
                // No new image uploaded, retain the existing image
                $imageName = $_POST["existingImage"];
            }

            // Create a new instance of the Topic controller
            $topicC = new TopicC();

            // Create a new topic object
            $topic = new Topic(
                $_POST["topicTitle"],
                $_POST["topicContent"],
                1, // Assuming user ID is stored in session
                $_POST["topicTags"],
                $imageName // Image name
            );

            // Check if topic ID is set (for editing)
        
                // Update existing topic
                $topic->setTopicID($_POST["topicID"]); // Set topic ID
                $topicC->updateTopic($topic);

            header("Location: mytopics.php");
            exit();
        } else {
            $error = "Missing information";
        }
    } else {
        $error = "Missing information";
    }
} 

?>
<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Site Metas -->
    <title>Freshshop - Ecommerce Bootstrap 4 HTML Template</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Site CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/custom.css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
        <!-- Start Navigation -->
        <?php require ('menu.php'); ?>
        <!-- End Navigation -->
    </header>
    <!-- End Main Top -->

    <!-- Start Top Search -->
    <div class="top-search">
        <div class="container">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search">
                <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
            </div>
        </div>
    </div>

    
    <div class="latest-blog">
    <div class="container mt-5">
        <h2>Edit Topic</h2>
        <form action="edit_topic.php" method="POST" enctype="multipart/form-data">
            <!-- Display error message if any -->
            <?php if (!empty($error)) : ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <input type="hidden" name="topicID" value="<?php echo isset($topic) ? $topic['id'] : ''; ?>">
            <div class="form-group">
                <label for="topicTitle">Topic Title</label>
                <input type="text" class="form-control" id="topicTitle" name="topicTitle" value="<?php echo isset($topic) ? $topic['topicTitle'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="topicContent">Topic Content</label>
                <textarea class="form-control" id="topicContent" name="topicContent" rows="6"><?php echo isset($topic) ? $topic['topicContent'] : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="topicTags">Tags</label>
                <input type="text" class="form-control" id="topicTags" name="topicTags" placeholder="Enter tags separated by commas" value="<?php echo isset($topic) ? $topic['tags'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="topicImage">Upload Image</label>
                <input type="file" class="form-control-file" id="topicImage" name="topicImage">
            </div>
            <input type="hidden" name="existingImage" value="<?php echo isset($topic) ? $topic['image'] : ''; ?>">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
   






        </div>
    </div>
    <!-- End Blog  -->


    <!-- Start Footer  -->
    <footer>
        <div class="footer-main">
            <div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-12 col-sm-12">
						<div class="footer-top-box">
							<h3>Business Time</h3>
							<ul class="list-time">
								<li>Monday - Friday: 08.00am to 05.00pm</li> <li>Saturday: 10.00am to 08.00pm</li> <li>Sunday: <span>Closed</span></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12">
						<div class="footer-top-box">
							<h3>Newsletter</h3>
							<form class="newsletter-box">
								<div class="form-group">
									<input class="" type="email" name="Email" placeholder="Email Address*" />
									<i class="fa fa-envelope"></i>
								</div>
								<button class="btn hvr-hover" type="submit">Submit</button>
							</form>
						</div>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12">
						<div class="footer-top-box">
							<h3>Social Media</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
							<ul>
                                <li><a href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-google-plus" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-rss" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-whatsapp" aria-hidden="true"></i></a></li>
                            </ul>
						</div>
					</div>
				</div>
				<hr>
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-widget">
                            <h4>About Freshshop</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> 
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p> 							
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-link">
                            <h4>Information</h4>
                            <ul>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Customer Service</a></li>
                                <li><a href="#">Our Sitemap</a></li>
                                <li><a href="#">Terms &amp; Conditions</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Delivery Information</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-link-contact">
                            <h4>Contact Us</h4>
                            <ul>
                                <li>
                                    <p><i class="fas fa-map-marker-alt"></i>Address: Michael I. Days 3756 <br>Preston Street Wichita,<br> KS 67213 </p>
                                </li>
                                <li>
                                    <p><i class="fas fa-phone-square"></i>Phone: <a href="tel:+1-888705770">+1-888 705 770</a></p>
                                </li>
                                <li>
                                    <p><i class="fas fa-envelope"></i>Email: <a href="mailto:contactinfo@gmail.com">contactinfo@gmail.com</a></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer  -->

    <!-- Start copyright  -->
    <div class="footer-copyright">
        <p class="footer-company">All Rights Reserved. &copy; 2018 <a href="#">ThewayShop</a> Design By :
            <a href="https://html.design/">html design</a></p>
    </div>
    <!-- End copyright  -->

    <a href="#" id="back-to-top" title="Back to top" style="display: none;">&uarr;</a>

    <!-- ALL JS FILES -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- ALL PLUGINS -->
    <script src="js/jquery.superslides.min.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/inewsticker.js"></script>
    <script src="js/bootsnav.js."></script>
    <script src="js/images-loded.min.js"></script>
    <script src="js/isotope.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/baguetteBox.min.js"></script>
    <script src="js/form-validator.min.js"></script>
    <script src="js/contact-form-script.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>