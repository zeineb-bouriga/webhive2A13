<?php

include '../../../controller/AgentController.php';

$agentController = new DeliveryAgentController();
$error = "";
$agent = null;


if (isset($_GET['agent_id'])) {
    $agent= $agentController->showAgent($_GET['agent_id']);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agent_id'], $_POST['full_name'], $_POST['contact_number'])) {
    if (
        !empty($_POST['agent_id']) &&
        !empty($_POST['full_name']) &&
        !empty($_POST['contact_number']) 
    ) {
        
        $agent_status = isset($_POST['agent_status']) ? intval($_POST['agent_status']) : 0;
 
        $agent = new DeliveryAgent(
            null,
            $_POST['full_name'],
            $_POST['contact_number'],
            $agent_status
        );

        // Update the delivery in the database
        $agentController->updateAgent($agent, $_POST['agent_id']);

        // Redirect to delivery list after update
    header('Location: DeliveryAgentList.php');
        exit;
    } else {
        $error = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Update Delivery - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fc;
        }

        .card {
            max-width: 500px;
            width: 100%;
        }

        label {
            font-weight: bold;
        }

        .alert {
            text-align: center;
        }
    </style>
</head>

<body>

<div class="card border-left-primary shadow h-100 py-2">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
        <?php if (!empty($error)) : ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

    <form action="" method="POST" id="agent-form">
        <!-- Form content -->
    
                <!-- Hidden ID field -->
                <input type="hidden" name="agent_id" 
                       value="<?= htmlspecialchars($_GET['agent_id'] ?? $_POST['agent_id'] ?? '') ?>">

                <div class="mb-3">
                    <label for="full_name" class="form-label"> Full Name :</label>
                    <input class="form-control form-control-user" id="full_name" name="full_name" rows="1" 
                              placeholder="Enter Full Name" value="<?= htmlspecialchars($agent['full_name'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="contact_number" class="form-label">Contact Number:</label>
                    <input class="form-control form-control-user" type="text" id="contact_number" name="contact_number" 
                           value="<?= htmlspecialchars($agent['contact_number'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
    <label for="agent_status" class="form-label">Agent Status:</label>
    <select class="form-control form-control-user" id="agent_status" name="agent_status" required>
        <option value="1" <?= isset($agent['agent_status']) && $agent['agent_status'] == 1 ? 'selected' : '' ?>>Available</option>
        <option value="0" <?= isset($agent['agent_status']) && $agent['agent_status'] == 0 ? 'selected' : '' ?>>Unavailable</option>
    </select>
</div>


                <button type="submit" class="btn btn-primary btn-user btn-block">Update Agent</button>
                </form>


        </div>
    </div>
</div>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>
