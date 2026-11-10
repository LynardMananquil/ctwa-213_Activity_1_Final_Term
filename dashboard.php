<?php
require_once 'config.php';

$stmt = $pdo->query("SELECT COUNT(*) FROM products");
$total_products = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COALESCE(SUM(quantity), 0) FROM products");
$total_stock = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nard's Inventory System - Dashboard</title>

    <link rel="stylesheet" href="style.css?v=7">
</head>
<body>

<?php include 'nav.php'; ?>

<main class="dashboard-container">

    <section class="welcome-section">

        <div>
            <span class="eyebrow">NARD'S INVENTORY SYSTEM</span>

            <h1>Dashboard</h1>

            <p>Welcome to Nard's Inventory System!</p>
        </div>

        <div class="welcome-icon">📦</div>

    </section>

    <section class="dashboard-cards">

        <div class="card blue-card">

            <div class="card-icon">📦</div>

            <span>Total Products</span>

            <h2><?= (int)$total_products ?></h2>

            <small>Products in inventory</small>

        </div>

        <div class="card green-card">

            <div class="card-icon">📊</div>

            <span>Total Stock</span>

            <h2><?= (int)$total_stock ?></h2>

            <small>Total available quantity</small>

        </div>

    </section>

    <section class="dashboard-section">

        <div>
            <span class="eyebrow">SYSTEM INFORMATION</span>

            <h2>Inventory Overview</h2>

            <p>
                Monitor the total number of products and available
                stock in your inventory.
            </p>
        </div>

    </section>

    <footer class="dashboard-footer">

        <span>Nard's Inventory System</span>

        <span>Inventory Overview</span>

    </footer>

</main>

</body>
</html>