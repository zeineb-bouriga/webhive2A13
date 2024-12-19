<?php
session_start();
// Include necessary files and configurations
include_once('../../../tas/Controller/UserController.php');

include_once "../../../config.php"; // Assuming this file contains database connection configuration
include_once "../../../Controller/TopicC.php"; // Assuming this file contains the Topic controller
if (!isset($_SESSION["name"]) || !isset($_SESSION['email']) || !isset($_SESSION['role']) || !isset($_SESSION['phone'])) {
    header('location: ../back/auth/auth-login.php');
}
$userC = new UserController();
// Create a new instance of the Topic controller
$topicC = new TopicC();

// Get all topics from the database
$topicsData = $topicC->displayTopics("user"); // Assuming a function getAllTopics() retrieves all topics

// Convert topics data to array of objects
$topics = [];
foreach ($topicsData as $topic) {
    $topics[] = [
        'id' => $topic['id'],
        'topicTitle' => $topic['topicTitle'],
        'topicContent' => $topic['topicContent'],
        'image' => $topic['image'],
        'tags' => explode('-', $topic['tags']), // Assuming tags are stored as hyphen-separated string
        'views' => $topic['views'],
        'likes' => $topic['likes'],
        'commentsCount' => $topic['commentsCount'],
        'creationDate' => $topic['creationDate']
    ];
}
?><!DOCTYPE html>
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
    <link rel="stylesheet" href="forum.css">

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
    <h2 class="mb-4">All Topics</h2>

    <!-- Search form -->
    <form id="searchForm" class="mb-3">
        <div class="form-group">
            <input type="text" class="form-control" id="searchInput" placeholder="Search topics">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <!-- Filter by tags -->
    <div class="form-group">
        <label for="tagSelect">Filter by Tags:</label>
        <select id="tagSelect" class="form-control">
            <option value="">All</option>
            <!-- Dynamically populate options using JavaScript -->
        </select>
    </div>

    <!-- Topic cards container -->
    <div id="topicCards" class="row">
        <!-- Topics will be dynamically loaded here -->
    </div>

    <!-- Pagination links -->
    <nav id="pagination" aria-label="Topics Pagination" class="d-flex justify-content-center mt-4">
        <!-- Pagination links will be dynamically loaded here -->
    </nav>







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
    <script>
    // Sample topics data (replace with actual data)
    const topics = <?php echo json_encode($topics); ?>;
console.log(topics);
    // Function to display topics based on current page and search/filter criteria
    function displayTopics(page = 1, search = '', tag = '') {
        // Clear previous topics
        $('#topicCards').empty();

        // Filter topics based on search and tag
        let filteredTopics = topics.filter(topic => {
            // Search by title and content
            const matchSearch = topic.topicTitle.toLowerCase().includes(search.toLowerCase())
                || topic.topicContent.toLowerCase().includes(search.toLowerCase());
            // Filter by tag
            const matchTag = tag === '' || topic.tags.includes(tag);
            return matchSearch && matchTag;
        });

        // Paginate the filtered topics
        const itemsPerPage = 4;
        const startIndex = (page - 1) * itemsPerPage;
        const paginatedTopics = filteredTopics.slice(startIndex, startIndex + itemsPerPage);

        // Display paginated topics
        paginatedTopics.forEach(topic => {
            const cardHtml = `
                <div class="card topic-card">
                    <div class="card-body">
                        <img src="../Back Office/uploads/${topic.image}" alt="Topic Image">
                        <div class="topic-details">
                            <h5 class="card-title">${topic.topicTitle}</h5>
                            <p class="card-text">${topic.topicContent.length > 150 ? topic.topicContent.slice(0, 150) + '...' : topic.topicContent}</p>
                            <p>
                                ${topic.tags.map(tag => `<span class="tag">${tag}</span>`).join(' ')}
                            </p>
                            <p><i class="far fa-eye"></i> Views: ${topic.views}</p>
                            <p><i class="fas fa-arrow-up"></i> Upvotes: ${topic.likes}</p>
                            <p><i class="far fa-comments"></i> Comments: ${topic.commentsCount}</p>
                            <p>Posted ${getTimeElapsed(topic.creationDate)}</p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="topic.php?id=${topic.id}" class="btn btn-primary float-right">Read More</a>
                    </div>
                </div>`;
            $('#topicCards').append(cardHtml);
        });

         // Display pagination links
         displayPagination(page, filteredTopics.length, itemsPerPage);
    }

    // Function to display pagination links
    function displayPagination(currentPage, totalItems, itemsPerPage) {
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        let paginationHtml = '';
        for (let i = 1; i <= totalPages; i++) {
            paginationHtml += `
                <li class="page-item ${currentPage === i ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="displayTopics(${i})">${i}</a>
                </li>`;
        }
        $('#pagination').html(`<ul class="pagination">${paginationHtml}</ul>`);
    }

    // Function to calculate time elapsed since creation date
    function getTimeElapsed(creationDate) {
        const now = new Date();
        const createdAt = new Date(creationDate);
        const diff = Math.floor((now - createdAt) / (1000 * 60)); // Difference in minutes
        if (diff < 1) {
            return 'just now';
        } else if (diff < 60) {
            return diff + 'm ago';
        } else if (diff < 1440) {
            return Math.floor(diff / 60) + 'h ago';
        } else {
            return Math.floor(diff / 1440) + 'd ago';
        }
    }

    // Populate tag options
    function populateTags() {
        const tags = [...new Set(topics.flatMap(topic => topic.tags))];
        const tagSelect = $('#tagSelect');
        tags.forEach(tag => {
            tagSelect.append(`<option value="${tag}">${tag}</option>`);
        });
    }
    $(document).ready(function () {
    // Check if topics array is empty
    if (topics.length === 0) {
        console.log("Topics array is empty. Check PHP code to ensure data retrieval is successful.");
        return;
    }

    // Initial display of topics
    displayTopics();

    // Populate tag options
    populateTags();

    // Search form submission
    $('#searchForm').submit(function (event) {
        event.preventDefault();
        const searchInput = $('#searchInput').val();
        displayTopics(1, searchInput);
    });

    // Tag filter change
    $('#tagSelect').change(function () {
        const selectedTag = $(this).val();
        displayTopics(1, '', selectedTag);
    });
});


</script>
</body>

</html>


