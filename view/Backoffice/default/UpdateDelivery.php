<?php

include '../../../controller/DeliveryController.php';

$deliveryController = new DeliveryController();
$error = "";
$delivery = null;

// Fetch the delivery details if the `id` is provided
if (isset($_GET['delivery_id'])) {
    $delivery = $deliveryController->showDelivery($_GET['delivery_id']);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delivery_id'], $_POST['order_id'], $_POST['delivery_address'], $_POST['delivery_date'], $_POST['delivery_status'], $_POST['delivery_agent_id'])) {
    if (
        !empty($_POST['delivery_id']) &&
        !empty($_POST['order_id']) &&
        !empty($_POST['delivery_address']) &&
        !empty($_POST['delivery_date']) &&
        !empty($_POST['delivery_status']) &&
        !empty($_POST['delivery_agent_id'])
    ) {
        // Create a new delivery object
        $delivery = new Delivery(
            null,
            $_POST['order_id'],
            $_POST['delivery_address'],
            new DateTime($_POST['delivery_date']),
            $_POST['delivery_status'],
            $_POST['delivery_agent_id']
        );

        // Update the delivery in the database
        $deliveryController->updateDelivery($delivery, $_POST['delivery_id']);

        // Redirect to delivery list after update
        header('Location: DeliveryList.php');
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

<?php
if (isset($_POST['delivery_id'])) {
    $delivery = $deliveryController->showDelivery($_POST['delivery_id']);
?>
    <form action="" method="POST" id="delivery-form">
        <!-- Form content -->
    
                <!-- Hidden ID field -->
                <input type="hidden" name="delivery_id" 
                       value="<?= htmlspecialchars($_GET['delivery_id'] ?? $_POST['delivery_id'] ?? '') ?>">

                <div class="mb-3">
                    <label for="order_id" class="form-label">Order ID:</label>
                    <textarea class="form-control form-control-user" id="order_id" name="order_id" rows="1" 
                              placeholder="Enter Order ID" required><?= htmlspecialchars($delivery['order_id'] ?? '') ?></textarea>
                    <small id="order-id-error" class="text-danger" style="display: none;">Order ID must contain only numbers.</small>
                </div>

                <div class="mb-3">
                    <label for="delivery_address" class="form-label">Delivery Address:</label>
                    <input class="form-control form-control-user" type="text" id="delivery_address" name="delivery_address" 
                           value="<?= htmlspecialchars($delivery['delivery_address'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="delivery_date" class="form-label">Delivery Date:</label>
                    <input class="form-control form-control-user" type="date" id="delivery_date" name="delivery_date" 
                           value="<?= htmlspecialchars($delivery['delivery_date'] ?? '') ?>" required>
                </div>

                <div class="mb-3">
    <label for="delivery_status" class="form-label">Delivery Status:</label>
    <select class="form-control form-control-user" id="delivery_status" name="delivery_status" required>
        <option value="Pending" <?= isset($delivery['delivery_status']) && $delivery['delivery_status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
        <option value="In Transit" <?= isset($delivery['delivery_status']) && $delivery['delivery_status'] === 'In Transit' ? 'selected' : '' ?>>In Transit</option>
        <option value="Delivered" <?= isset($delivery['delivery_status']) && $delivery['delivery_status'] === 'Delivered' ? 'selected' : '' ?>>Delivered</option>
        <option value="Cancelled" <?= isset($delivery['delivery_status']) && $delivery['delivery_status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
    </select>
</div>



                <div class="mb-3">
                    <label for="delivery_agent_id" class="form-label">Delivery Agent ID:</label>
                    <textarea class="form-control form-control-user" id="delivery_agent_id" name="delivery_agent_id" rows="1" 
                              placeholder="Enter Delivery Agent ID" required><?= htmlspecialchars($delivery['delivery_agent_id'] ?? '') ?></textarea>
                    <small id="delivery-agent-id-error" class="text-danger" style="display: none;">Delivery Agent ID must contain only numbers.</small>
                </div>

                <button type="submit" class="btn btn-primary btn-user btn-block">Update Delivery</button>
                </form>
<?php } ?>

        </div>
    </div>
</div>

<script>
    // Get references to elements
    const orderIdField = document.getElementById('order_id');
    const orderIdError = document.getElementById('order-id-error');
    const deliveryAgentField = document.getElementById('delivery_agent_id');
    const deliveryAgentError = document.getElementById('delivery-agent-id-error');

    // Validate Order ID input
    orderIdField.addEventListener('input', function () {
        if (/^\d*$/.test(this.value)) {
            orderIdError.style.display = 'none';
        } else {
            orderIdError.style.display = 'block';
        }
    });

    // Validate Delivery Agent ID input
    deliveryAgentField.addEventListener('input', function () {
        if (/^\d*$/.test(this.value)) {
            deliveryAgentError.style.display = 'none';
        } else {
            deliveryAgentError.style.display = 'block';
        }
    });

    // Prevent form submission if validation fails
    document.getElementById('delivery-form').addEventListener('submit', function (event) {
        let valid = true;

        if (!/^\d*$/.test(orderIdField.value)) {
            orderIdError.style.display = 'block';
            valid = false;
        }

        if (!/^\d*$/.test(deliveryAgentField.value)) {
            deliveryAgentError.style.display = 'block';
            valid = false;
        }

        if (!valid) {
            event.preventDefault();
        }
    });
</script>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>
