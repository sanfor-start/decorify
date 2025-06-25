<?php
session_start();

$server = "localhost";
$user = "root";
$pass = "";
$dbname = "projet";
$connexion = mysqli_connect($server, $user, $pass, $dbname);

// Check connection
if (!$connexion) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";
$error = "";

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Add new product
    if (isset($_POST['add_product'])) {
        $name = mysqli_real_escape_string($connexion, $_POST['name']);
        $description = mysqli_real_escape_string($connexion, $_POST['description']);
        $price = floatval($_POST['price']);
        $stock = intval($_POST['stock']);

        // Logic d'ajjoute d'image
        $image_name = null;

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image_name = time() . '_' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], 'image/' . $image_name);
        }
        // finir ici

        if (!empty($name) && !empty($description) && $price > 0) {
            $sql = "INSERT INTO produit (name, description, price, stock, image) VALUES ('$name', '$description', '$price', '$stock', " . ($image_name ? "'$image_name'" : "NULL") . ")";
            if (mysqli_query($connexion, $sql)) {
                $message = "Product added successfully!";
            } else {
                $error = "Error adding product: " . mysqli_error($connexion);
            }
        } else {
            $error = "Please fill all fields correctly.";
        }
    }

    // Update product
    if (isset($_POST['update_product'])) {
        $id = intval($_POST['id']);
        $name = mysqli_real_escape_string($connexion, $_POST['name']);
        $description = mysqli_real_escape_string($connexion, $_POST['description']);
        $price = floatval($_POST['price']);
        $stock = intval($_POST['stock']);

        // Logic de modifier une image
        $image_sql = "";

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image_name = time() . '_' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], 'image/' . $image_name);
            $image_sql = ", image='$image_name'";
        }
        // finir ici

        if (!empty($name) && !empty($description) && $price > 0) {
            $sql = "UPDATE produit SET name='$name', description='$description', price='$price', stock='$stock' $image_sql WHERE Id=$id";
            if (mysqli_query($connexion, $sql)) {
                $message = "Product updated successfully!";
            } else {
                $error = "Error updating product: " . mysqli_error($connexion);
            }
        } else {
            $error = "Please fill all fields correctly.";
        }
    }

    // Delete product
    if (isset($_POST['delete_product'])) {
        $id = intval($_POST['id']);
        $sql = "DELETE FROM produit WHERE Id=$id";
        if (mysqli_query($connexion, $sql)) {
            $message = "Product deleted successfully!";
        } else {
            $error = "Error deleting product: " . mysqli_error($connexion);
        }
    }
}

// Get all products
$sql = "SELECT * FROM produit ORDER BY Id DESC";
$result = mysqli_query($connexion, $sql);

// Get product for editing
$edit_product = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $edit_sql = "SELECT * FROM produit WHERE Id=$edit_id";
    $edit_result = mysqli_query($connexion, $edit_sql);
    $edit_product = mysqli_fetch_assoc($edit_result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Product Management</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .nav-links {
            margin-top: 20px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            padding: 8px 16px;
            border: 2px solid white;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .nav-links a:hover {
            background: white;
            color: #667eea;
        }

        .content {
            padding: 30px;
        }

        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .form-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 4px solid #667eea;
        }

        .form-section h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-group textarea {
            height: 100px;
            resize: vertical;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            margin-right: 10px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .products-table th,
        .products-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .products-table th {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-weight: bold;
        }

        .products-table tr:hover {
            background-color: #f5f5f5;
        }

        .products-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .products-table tr:nth-child(even):hover {
            background-color: #f0f0f0;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .no-products {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 18px;
        }

        @media (max-width: 768px) {
            .container {
                margin: 10px;
            }

            .content {
                padding: 15px;
            }

            .products-table {
                font-size: 14px;
            }

            .products-table th,
            .products-table td {
                padding: 8px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                margin-bottom: 5px;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🛠️ Admin Panel</h1>
            <p>Product Management System</p>
            <div class="nav-links">
                <a href="pageaceuil.php">🏠 Home</a>
                <a href="produitcom.php">🛍️ Products</a>
                <a href="cart.php">🛒 Cart</a>
            </div>
        </div>

        <div class="content">
            <!-- Messages -->
            <?php if (!empty($message)): ?>
                <div class="message success"><?php echo $message; ?></div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="message error"><?php echo $error; ?></div>
            <?php endif; ?>

            <!-- Add/Edit Product Form -->
            <div class="form-section">
                <h2><?php echo $edit_product ? '✏️ Edit Product' : '➕ Add New Product'; ?></h2>
                <form method="POST" action="" enctype="multipart/form-data">
                    <?php if ($edit_product): ?>
                        <input type="hidden" name="id" value="<?php echo $edit_product['Id']; ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="name">Product Name:</label>
                        <input type="text" id="name" name="name"
                            value="<?php echo $edit_product ? htmlspecialchars($edit_product['name']) : ''; ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" required><?php echo $edit_product ? htmlspecialchars($edit_product['description']) : ''; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="price">Price ($):</label>
                        <input type="number" id="price" name="price" step="0.01" min="0"
                            value="<?php echo $edit_product ? $edit_product['price'] : ''; ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="stock">Stock:</label>
                        <input type="number" id="stock" name="stock" min="0"
                            value="<?php echo $edit_product ? $edit_product['stock'] : '0'; ?>"
                            required>
                    </div>

                    <!-- image upload -->

                    <div class="form-group">
                        <label for="image">Image du produit :</label>
                        <input type="file" id="image" name="image" accept="image/*">
                        <?php if ($edit_product && !empty($edit_product['image'])): ?>
                            <img src="image/<?php echo htmlspecialchars($edit_product['image']); ?>" alt="Image actuelle" width="80">
                        <?php endif; ?>
                    </div>

                    <?php if ($edit_product): ?>
                        <button type="submit" name="update_product" class="btn btn-success">✅ Update Product</button>
                        <a href="admin.php" class="btn btn-secondary">❌ Cancel</a>
                    <?php else: ?>
                        <button type="submit" name="add_product" class="btn btn-primary">➕ Add Product</button>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Products List -->
            <div class="form-section">
                <h2>📦 Products List</h2>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?php echo $row['Id']; ?></td>
                                    <td>
                                        <?php if (!empty($row['image'])): ?>
                                            <img src="image/<?php echo htmlspecialchars($row['image']); ?>" alt="Produit" width="60">
                                        <?php else: ?>
                                            <span>Pas d'image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars(substr($row['description'], 0, 50)) . '...'; ?></td>
                                    <td>$<?php echo number_format($row['price'], 2); ?></td>
                                    <td><?php echo $row['stock']; ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="admin.php?edit=<?php echo $row['Id']; ?>" class="btn btn-warning">✏️ Edit</a>
                                            <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                <input type="hidden" name="id" value="<?php echo $row['Id']; ?>">
                                                <button type="submit" name="delete_product" class="btn btn-danger">🗑️ Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-products">
                        <p>📭 No products found. Add your first product above!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>