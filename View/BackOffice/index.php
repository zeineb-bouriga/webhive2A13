<?php
include '../../controller/ReclamationController.php';
$travelOfferC = new ReclamationController();
$chapters = $travelOfferC->listReclamations();
$som = $travelOfferC->countReclamation(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SB Admin 2 - User Data Management</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        button {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .edit-btn {
            background-color: #ffa500;
            color: white;
        }

        .delete-btn {
            background-color: #f44336; /* Red background */
            color: white;
        }

        .send-message-btn {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Reclamation</div>
            </a>
            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Reclamation</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
                <p class="text-center mb-2"><strong>Manage your reclamations easily!</strong></p>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <span class ="badge badge-danger badge-counter" id="notificationCount"><?php echo $som; ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="notificationsDropdown">
                                <h6 class="dropdown-header">Notifications</h6>
                                <a class="dropdown-item" href="#">New message from John Doe</a>
                                <a class="dropdown-item" href="#">Your reclamation was updated</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-center" href="#">Show All Notifications</a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <h1 class="h3 mb-0 text-gray-800">Gestion des Données Utilisateurs</h1>

                    <!-- User Data Management Table -->
                    <h2 class="h4 mb-4">Tableau des Réclamations</h2>
                    <table id="userTable">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Reclamation</th>
                                <th>Message</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($chapters as $chapter): ?>
<tr>
    <td><?php echo htmlspecialchars($chapter['nom']); ?></td>
    <td><?php echo htmlspecialchars($chapter['prenom']); ?></td>
    <td><?php echo htmlspecialchars($chapter['email']); ?></td>
    <td><?php echo isset($chapter['reclamation']) ? htmlspecialchars($chapter['reclamation']) : 'Aucune réclamation'; ?></td>
    <td>
    <?php 
    echo $travelOfferC->listMessages($chapter['idreclamation']);
    ?>
</td>

    <td>
        <button class="edit-btn" data-id="<?php echo $chapter['idreclamation']; ?>" data-nom="<?php echo htmlspecialchars($chapter['nom']); ?>" data-prenom="<?php echo htmlspecialchars($chapter['prenom']); ?>" data-email="<?php echo htmlspecialchars($chapter['email']); ?>" data-toggle="modal" data-target="#editModal">Edit</button>
        <a href="delete.php?idreclamation=<?php echo $chapter['idreclamation']; ?>" class="delete-btn">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
                    </table>
                </div>
                <!-- End of Main Content -->

            </div>
            <!-- End of Content Wrapper -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>© Votre Site Web 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Page Wrapper -->

    </div>
    <!-- End of Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Script to handle modal for messages -->
    <script>
$('.view-messages').on('click', function() {
    var idReclamation = $(this).data('id');
    $.ajax({
        url: 'get_messages.php', // Make sure this URL points to the correct endpoint
        type: 'GET',
        data: { idreclamation: idReclamation },
        success: function(data) {
            $('#modalMessagesBody').html(data); // Insert the returned messages into the modal body
        }
    });
});

$('#editModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var idReclamation = button.data('id');
    var nom = button.data('nom');
    var prenom = button.data('prenom');
    var email = button.data('email');

    var modal = $(this);
    modal.find('#edit_id_reclamation').val(idReclamation);
    modal.find('#edit_nom').val(nom);
    modal.find('#edit_prenom').val(prenom);
    modal.find('#edit_email').val(email);
});

    </script>

 ```html
    <!-- Modal for Messages -->
    <div class="modal fade" id="messagesModal" tabindex="-1" role="dialog" aria-labelledby="messagesModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messagesModalLabel">Messages</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalMessagesBody">
                    <!-- Messages will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Sending a Message -->
    <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Envoyer un Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="send_message.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="messageContent">Votre Message</label>
                            <textarea class="form-control" id="messageContent" name="message" rows="5" required></textarea>
                        </div>
                        <input type="hidden" name="id_reclamation" id="id_reclamation" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn send-message-btn">Envoyer le Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Reclamation -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modifier Réclamation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="update_reclamation.php" method="POST" onsubmit="return validateEditForm()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_nom">Nom</label>
                            <input type="text" class="form-control" id="edit_nom" name="nom" maxlength="10" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_prenom">Prénom</label>
                            <input type="text" class="form-control" id="edit_prenom" name="prenom" maxlength="10" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_email">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <input type="hidden" name="id_reclamation" id="edit_id_reclamation" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function validateEditForm() {
            var nom = document.getElementById('edit_nom').value;
            var prenom = document.getElementById('edit_prenom').value;
            var email = document.getElementById('edit_email').value;

            if (nom.length > 10) {
                alert("Le nom ne peut pas dépasser 10 caractères.");
                return false;
            }

            if (prenom.length > 10) {
                alert("Le prénom ne peut pas dépasser 10 caractères.");
                return false;
            }

            if (!email.includes('@')) {
                alert("L'email doit contenir un '@'.");
                return false;
            }

            return true; // Form is valid
        }
    </script>

</body>
</html>