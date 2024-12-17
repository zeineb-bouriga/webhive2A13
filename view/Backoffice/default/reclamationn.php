
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Reclamation Form</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Reclamation !</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Reclamation -->
            <li class="nav-item active">
                <a class="nav-link" href="reclamation.php">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Reclamation</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Formulaire de Réclamation</h1>
                    </div>

                    <!-- Form Section -->
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="submit_reclamation.php" method="GET"> <!-- Update action to your form processing script -->
                                <div class="form-group">
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <label for="nom">Nom:</label>
                                                <input type="text" class="form-control" id="nom" name="nom" required>
                                            </td>
                                            <td>
                                                <label for="prenom">Prénom:</label>
                                                <input type="text" class="form-control" id="prenom" name="prenom" required>
                                            </td>
                                            <td>
                                                <label for="email">Email:</label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <button type="submit" class="btn btn-primary">Envoyer la réclamation</button>
                                
                            </form>

                            <!-- Edit and Delete Buttons -->
                            <div class="mt-3">
                                <!--<button href="edit.php" class ="btn btn-warning">Edit</button>-->
                                <button class="btn btn-danger">Delete</button>
                                
                                <button class="edit-btn" onclick="window.location.href='edit_reclamation.php?idreclamtion=<?php echo $chapter['idreclamtion']; ?>'">Edit</button>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

</body>

</html>