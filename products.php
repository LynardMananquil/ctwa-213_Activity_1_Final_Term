```php
<?php
require_once 'config.php';

$stmt = $pdo->query(
    "SELECT id, name, description, quantity, price
     FROM products
     ORDER BY id DESC"
);

$products = $stmt->fetchAll();

$total_products = count($products);

$total_stock = 0;

foreach ($products as $product) {
    $total_stock += (int)$product['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inventory - Nard's Inventory System</title>

    <link rel="stylesheet" href="style.css?v=7">
</head>
<body>

<?php include 'nav.php'; ?>

<main class="dashboard-container">

    <section class="welcome-section">
        <div>
            <span class="eyebrow">NARD'S INVENTORY SYSTEM</span>
            <h1>Inventory Overview</h1>
            <p>View the available products in your inventory.</p>
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

        <span class="eyebrow">INVENTORY RECORDS</span>

        <h2>Product List</h2>

        <div class="table-container">

            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if ($total_products > 0): ?>

                        <?php foreach ($products as $product): ?>

                            <tr>
                                <td><?= (int)$product['id'] ?></td>

                                <td><?= h($product['name']) ?></td>

                                <td><?= h($product['description']) ?></td>

                                <td><?= (int)$product['quantity'] ?></td>

                                <td>
                                    ₱<?= number_format(
                                        (float)$product['price'],
                                        2
                                    ) ?>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="5">No inventory records available.</td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

        <p>Total Products Displayed: <?= (int)$total_products ?></p>

    </section>

    <footer class="dashboard-footer">
        <span>Nard's Inventory System</span>
        <span>Inventory Overview</span>
    </footer>

</main>

</body>
</html>
```