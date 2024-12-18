    <?php
    if (session_status() == PHP_SESSION_ACTIVE) {
        echo json_encode(['success' => false, 'message' => 'User is not logged in.']);
    } else {
        // Session is not started, so start it
        session_start();
        $userId = $_SESSION['id'];  // Get user ID from session
        echo($userId);
    }
                        ?>
        <br>
        <a href="http://localhost/REID/maghraoui/public/index.php" class="btn">Back to List</a>

        <div class="products-box">
            <div class="container">
                <div class="title-all text-center">
                    <h1>Our Articles</h1>
                    <p>Discover our latest articles and updates</p>
                </div>
            

                <!-- Card Grid Container -->
                <div class="card-grid">
                    <input type="hidden" id="mag" value="<?= $_SESSION['id'] ?>">
                    <?php if (!empty($articles)): ?>
                        <?php foreach ($articles as $article): ?>
                            <div class="card"  data-article-id="<?= $article['id'] ?>">
                                <img class="card-image" src="/maghraoui/public/uploads/<?= htmlspecialchars($article['articlePicture']) ?>" alt="<?= htmlspecialchars($article['title']) ?>">
                                <div class="card-body">
                                    <h2 class="card-title"><?= htmlspecialchars($article['title']) ?></h2>
                                    <p class="card-description">
                                        <span class="short-text" id="short-text-<?= $article['id'] ?>">
                                            <?= htmlspecialchars(substr($article['description'], 0, 20)) ?>...
                                        </span>
                                        <span class="full-text" id="full-text-<?= $article['id'] ?>" style="display: none;">
                                            <?= htmlspecialchars($article['description']) ?>
                                        </span>
                                        <?php if (strlen($article['description']) > 20): ?>
                                            <button class="view-more-btn" onclick="toggleDescription(<?= $article['id'] ?>)">View More</button>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                            
                                <div class="card-footer">
                                    <div class="reaction-container">
                                        <span class="reaction-icon" onclick="toggleReaction(this, <?= $article['id'] ?>)">
                                            <span class="emoji-placeholder" id="emoji-placeholder-<?= $article['id'] ?>">🤍</span>
                                        </span>
                                        <div class="reaction-popup" id="reaction-popup-<?= $article['id'] ?>">
                                            <span class="emoji" onclick="selectReaction(this, <?= $article['id'] ?>)">❤️</span>
                                        </div>
                                    </div>
                                                        <?php if (empty($comments)): ?>
                                             <p id="no-comments-<?= $article['id'] ?>" onclick="showCommentSection(<?= $article['id'] ?>)">see all comments.</p>
                    
                    
                                                            <?php endif; ?>


    <span class="reaction-icon" onclick="toggleCommentSection(<?= $article['id'] ?>)">💬</span>
                                    
                                </div>
                                

                                <div class="comment-section" id="comment-section-<?= $article['id'] ?>" style="display: none;">
                                    <div class="comment-input">
                                        <input type="text" placeholder="Add a comment..." id="comment-input-<?= $article['id'] ?>">
                                        <div class="menu-container">
                        <!-- Icône des trois points verticaux -->
                        <!-- <div class="menu-icon" onclick="toggleMenu(<?= $article['id'] ?>)">&#8942;</div> -->
                                                    <!-- Liste déroulante -->
                        <!-- <div class="menu-list" id="menuList">
                            <ol>
                                <li onclick="handleEdit()">Edit</li>
                                <li onclick="handleDelete()">Delete</li>
                            </ol>
                            </div>
                        -->     
                            
                        <div class="comment-section" id="comment-section-<?= $article['id'] ?>" style="display: none;">
                                    <div class="comment-list" id="comment-list-<?= $article['id'] ?>">
                                        <!-- Comments will be displayed here -->
                                    </div>
                                </div>
                        </div>
                                        <button onclick="addComment(<?= $article['id'] ?>)">Send</button>
                                    </div>
                                    <div class="comment-list" id="comment-list-<?= $article['id'] ?>"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center">
                            <p>No articles found.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
                    
        <script>
            // Toggle the visibility of the menu (Edit/Delete options)
        function toggleMenu(articleId, commentId) {
            const menu = document.getElementById(`menuList-${commentId}`);
            menu.classList.toggle('show');
        }

        // Handle Edit
        function handleEdit(commentId) {
            alert(`Edit comment ${commentId}`);
        }

        // Handle Delete
        function handleDelete(commentId) {
            const comment = document.getElementById(`comment-${commentId}`);
            comment.remove(); // Remove the comment from the DOM
            alert(`Comment ${commentId} deleted`);
        }

        // Close the menu if clicked outside
        window.onclick = function(event) {
            if (!event.target.matches('.menu-icon')) {
                const menus = document.querySelectorAll('.menu-list');
                menus.forEach(menu => {
                    if (menu.classList.contains('show')) {
                        menu.classList.remove('show');
                    }
                });
            }
        };
        // Toggle the visibility of the menu (Edit/Delete options)
        function toggleMenu(articleId, commentId) {
            const menu = document.getElementById(`menuList-${commentId}`);
            menu.classList.toggle('show');
        }

                // Fonction pour Edit
                function handleEdit() {
                    alert('Edit option selected');
                }

                // Fonction pour Delete
                function handleDelete() {
                    alert('Delete option selected');
                }

                // Ferme le menu lorsqu'on clique en dehors
                window.onclick = function(event) {
                    if (!event.target.matches('.menu-icon')) {
                        const menu = document.getElementById('menuList');
                        if (menu.classList.contains('show')) {
                            menu.classList.remove('show');
                        }
                    }
                };
                // Load comments for each article when the page loads
        function loadComments(articleId) {
        userId= document.getElementById("mag")
            console.log($userId.value); // Debugging line

            fetch(`/REID/maghraoui/public/index.php?controller=comment&action=userCommentsForArticle&id=${articleId}&user_id=${userId}`)
            .then(response => response.json())
                .then(comments => {
                    const commentList = document.getElementById(`comment-list-${articleId}`);
                    commentList.innerHTML = '';  // Clear existing comments

                    if (comments.length > 0) {
                        comments.forEach(comment => {
                            const commentElement = document.createElement('div');
                            commentElement.className = 'comment';
                            commentElement.innerHTML = `
                                <p>${comment.comment_text}</p>
                                <div class="comment-footer">
                                    <span class="reaction-icon" onclick="toggleReaction(this, ${articleId}, ${comment.id})">🤍</span>
                                    <div class="reaction-popup" id="reaction-popup-${articleId}">
                                        <span class="emoji" onclick="selectReaction(this, ${articleId})">❤️</span>
                                    </div>
                                    <div class="menu-container">
                                        <div class="menu-icon" onclick="toggleMenu(${articleId}, ${comment.id})">&#8942;</div>
                                        <div class="menu-list" id="menuList-${comment.id}">
                                            <ol>
                                                <li onclick="handleEdit(${comment.id})">Edit</li>
                                                <li onclick="handleDelete(${comment.id})">Delete</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            `;
                            commentList.appendChild(commentElement);
                        });
                    } else {
                        commentList.innerHTML = '<p>No comments yet. Be the first to comment!</p>';
                    }
                })
                .catch(error => console.error('Error fetching comments:', error));
        }

        // document.addEventListener('DOMContentLoaded', () => {
        //     const articles = document.querySelectorAll('.card');
        //     articles.forEach(article => {
        //         const articleId = article.getAttribute('data-article-id');
        //         $idlol= document.getElementById("mag")
        //     console.log($idlol.value); 
        //         console.log(articleId+20)
        //         loadComments(articleId);
        //     });
        // });

        // Toggle the emoji reaction (white heart to red heart) on click
        function toggleReaction(icon, articleId, commentId = null) {
            if (!commentId) {
                commentId = icon.closest('.comment').getAttribute('data-comment-id'); // Get the comment ID from the data attribute
            }
            console.log('toggleReaction called with:', { icon, articleId, commentId }); // Debugging log
            const emojiPlaceholder = document.getElementById(`emoji-placeholder-${articleId}`);

            // Check current emoji and update accordingly
            if (emojiPlaceholder.textContent === '🤍') {
                emojiPlaceholder.textContent = '❤️';  // Change to red heart
                updateReaction(articleId, 'like');  // Send like to the backend
            } else {
                emojiPlaceholder.textContent = '🤍';  // Change back to white heart
                updateReaction(articleId, 'dislike');  // Send dislike to the backend
            }
        }

        // Send reaction (like/dislike) to the backend
        function updateReaction(articleId, reaction) {
            const data = { article_id: articleId, reaction: reaction };

            fetch('/REID/maghraoui/public/index.php?controller=comment&action=like', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Reaction updated');
                } else {
                    console.error('Failed to update reaction:', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }


        // Select the emoji and set it to the reaction icon of a specific article's reaction
        function selectReaction(emojiElement, articleId) {
            const selectedEmoji = emojiElement.textContent; // Update the selected emoji
            const emojiPlaceholder = document.getElementById(`emoji-placeholder-${articleId}`);
            emojiPlaceholder.textContent = selectedEmoji; // Update the placeholder with the selected emoji
            hideReactions(articleId);
        }

        // Hide all reaction popups
        function hideReactions(articleId) {
            const popups = document.querySelectorAll('.reaction-popup');
            popups.forEach(popup => popup.style.display = 'none');
        }

                    function toggleCommentSection(articleId) {
                const section = document.getElementById(`comment-section-${articleId}`);
                const loadingIndicator = document.getElementById(`loading-${articleId}`);
                const commentList = document.getElementById(`comment-list-${articleId}`);

                if (!section) {
                    console.error(`Comment section with ID 'comment-section-${articleId}' not found`);
                    return;
                }

                // Toggle visibility of the comment section
                section.style.display = section.style.display === 'none' ? 'block' : 'none';

                // If section is now visible, fetch and display comments
                if (section.style.display === 'block') {
                    // Show loading indicator
                    loadingIndicator.style.display = 'block';
                } else {
                    commentList.innerHTML = '';  // Clear comments when hiding the section
                    loadingIndicator.style.display = 'none';  // Hide loading indicator
                }
            }
            function showCommentSection(articleId) {
    const section = document.getElementById(`comment-section-${articleId}`);
    const noCommentMessage = document.getElementById(`no-comments-${articleId}`);
    
    if (!section) {
        console.error(`Comment section with ID 'comment-section-${articleId}' not found`);
        return;
    }

    // Show the comment section and hide the "No comments" message
    section.style.display = 'block';
    noCommentMessage.style.display = 'none';
    
    // You can optionally load comments if needed
    fetchComments(articleId);
}

            // Fetch comments for the specific article
function fetchComments(articleId) {
    const userId = document.getElementById("mag").value; // Assuming the user ID is in an input with id="mag"
    const url = `/REID/maghraoui/public/index.php?controller=comment&action=userCommentsForArticle&id=${articleId}&user_id=${userId}`;

    console.log(`Fetching comments for articleId: ${articleId} and userId: ${userId}`);

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const commentList = document.getElementById(`comment-list-${articleId}`);
            const loadingIndicator = document.getElementById(`loading-${articleId}`);

            // Hide the loading indicator after fetching data
            loadingIndicator.style.display = 'none';

            if (data.length > 0) {
                commentList.innerHTML = ''; // Clear existing content
                data.forEach(comment => {
                    const commentRow = document.createElement('tr');
                    commentRow.innerHTML = `
                        <td>${comment.comment_text}</td>
                        <td>${comment.created_at}</td>
                    `;
                    commentList.appendChild(commentRow);
                });
            } else {
                commentList.innerHTML = '<p>No comments available for this article.</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching comments:', error);
            const commentList = document.getElementById(`comment-list-${articleId}`);
            const loadingIndicator = document.getElementById(`loading-${articleId}`);
            loadingIndicator.style.display = 'none';
            commentList.innerHTML = '<p>Error fetching comments. Please try again later.</p>';
        });
}
        function addComment(articleId) {
            const input = document.getElementById(`comment-input-${articleId}`);
            const commentList = document.getElementById(`comment-list-${articleId}`);
            const commentText = input.value.trim();

            if (commentText) {
                // Create a unique comment ID based on the timestamp (or you can use other logic)
                const commentId = Date.now();

                // Create a new comment element in the front-end
                const comment = document.createElement('div');
                comment.className = 'comment';
                comment.innerHTML = `
                    ${commentText}
                    <div class="comment-footer">
            <span class="reaction-icon" onclick="toggleReaction(this, ${articleId}, '${commentId}')">
                🤍
            </span>
            <div class="reaction-popup" id="reaction-popup-${articleId}">
                <span class="emoji" onclick="selectReaction(this, ${articleId})">❤️</span>
            </div>
            <!-- Comment Edit and Delete Menu -->
            <div class="menu-container">
                <div class="menu-icon" onclick="toggleMenu(${articleId}, '${commentId}')">&#8942;</div>
                <div class="menu-list" id="menuList-${commentId}">
                    <ol>
                        <li onclick="handleEdit(${commentId})">Edit</li>
                        <li onclick="handleDelete(${commentId})">Delete</li>
                    </ol>
                </div>
            </div>
        </div>
                    <div class="reply-container"></div>
                `;
                commentList.appendChild(comment);
                input.value = ''; // Clear the input field

                // Send the comment data to the PHP backend
                const data = {
                    article_id: articleId,
                    comment_text: commentText
                };

                fetch('/REID/maghraoui/public/index.php?controller=comment&action=store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(responseData => {
                    if (responseData.success) {
                        console.log('Comment successfully added',responseData.comment);
                    } else {
                        console.error('Failed to add comment:', responseData.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        }
        // Toggle the emoji reaction (white heart to red heart) on click
        function toggleReaction(icon, articleId, commentId = null) {
            if (!commentId) {
                commentId = icon.closest('.comment').getAttribute('data-comment-id'); // Get the comment ID from the data attribute
            }
            console.log('toggleReaction called with:', { icon, articleId, commentId }); // Debugging log
            // If it's a comment, use the comment's emoji ID, otherwise use the article's emoji
            const emojiPlaceholder = commentId 
                ? icon  // Here we use the clicked element itself since it's the emoji
                : document.getElementById(`emoji-placeholder-${articleId}`);

            // Toggle between white and red heart emojis
            if (emojiPlaceholder.textContent === '🤍') {
                emojiPlaceholder.textContent = '❤️';  // Change to red heart
            } else {
                emojiPlaceholder.textContent = '🤍';  // Change back to white heart
            }
        }
        //




        // Toggle the description visibility
        function toggleDescription(articleId) {
            const shortText = document.getElementById(`short-text-${articleId}`);
            const fullText = document.getElementById(`full-text-${articleId}`);
            const button = document.querySelector(`.view-more-btn[onclick="toggleDescription(${articleId})"]`);

            if (shortText.style.display === 'none') {
                shortText.style.display = 'inline';
                fullText.style.display = 'none';
                button.textContent = 'View More';
            } else {
                shortText.style.display = 'none';
                fullText.style.display = 'inline';
                button.textContent = 'View Less';
            }
        }

        </script>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }
            .card-description .full-text {
            white-space: normal; /* Allows the full description to wrap */
            word-break: break-word; /* Ensures long words break properly */
            display: none; /* Hidden by default */
        }

            .products-box {
                margin: 0 auto;
                max-width: 1200px;
            }

            .card-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 20px;
            }

            .card {
                border: 1px solid #ccc;
                border-radius: 8px;
                padding: 16px;
                background-color: #fff;
                display: flex;
                flex-direction: column;
            }

            .card-image {
            width: 100%; /* Ensures the image takes the full width of the card */
            height: 200px; /* Fixed height for consistent appearance */
            object-fit: cover; /* Ensures the image fills the area while maintaining its aspect ratio */
            border-radius: 8px;
            margin-bottom: 10px;
        }
            .card-title {
                font-size: 1.5em;
                margin-bottom: 10px;
            }
            .card-description {
            margin-bottom: 10px;
            white-space: nowrap; /* Keeps the short description in a single line */
            overflow: hidden;
            text-overflow: ellipsis;
        }

            .card-footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .reaction-container {
                position: relative;
            }

            .reaction-popup {
                display: none;
                position: absolute;
                bottom: 30px;
                left: 0;
                background: white;
                border: 1px solid #ccc;
                border-radius: 8px;
                padding: 8px;
                z-index: 10;
            }

            .reaction-icon {
                cursor: pointer;
                font-size: 1.5em;
            }

            .comment-section {
                margin-top: 10px;
                display: none;
            }

            .comment-input {
                display: flex;
                margin-bottom: 10px;
            }

            .comment-input input {
                flex-grow: 1;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            .comment-input button {
                margin-left: 5px;
                padding: 8px 12px;
                border: none;
                background: #007bff;
                color: white;
                border-radius: 4px;
                cursor: pointer;
            }

            .comment-list .comment {
                margin-bottom: 10px;
            }
            .view-more-btn {
            background: none;
            border: none;
            color: #007bff;
            cursor: pointer;
            font-size: 0.9em;
            padding: 0;
        }
        .menu-container {
            position: relative;
            display: inline-block;
        }

        .menu-icon {
            cursor: pointer;
            font-size: 24px;
            user-select: none;
        }

        .menu-list {
            display: none;
            position: absolute;
            top: 25px;
            left: -20px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
            width: 100px;
            padding: 5px 0;
            z-index: 10;
        }

        .menu-list.show {
            display: block;
        }

        .menu-list ol {
            margin: 0;
            padding-left: 20px;
        }

        .menu-list li {
            list-style: decimal;
            padding: 5px 10px;
            cursor: pointer;    
        }

        .menu-list li:hover {
            background-color: #f2f2f2;
        }

        .loading-indicator {
    font-size: 14px;
    color: #777;
    margin: 10px;
}
.comment {
    padding: 10px;
    border: 1px solid #ccc;
    margin-bottom: 10px;
    background-color: #f9f9f9;
}
.comment small {
    color: #666;
    font-size: 0.8em;
}

        </style>