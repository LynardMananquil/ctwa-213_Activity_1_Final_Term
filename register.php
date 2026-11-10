<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($username === '' || $password === '' || $confirm_password === '') {
        $error = 'Please complete all fields.';
    } elseif (strlen($username) < 3) {
        $error = 'Username must be at least 3 characters.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {

        $stmt = $pdo->prepare(
            "SELECT id FROM users WHERE username = ?"
        );

        $stmt->execute([$username]);

        if ($stmt->fetch()) {
            $error = 'Username already exists.';
        } else {

            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $pdo->prepare(
                "INSERT INTO users (username, password, role, status)
                 VALUES (?, ?, 'user', 'approved')"
            );

            $stmt->execute([
                $username,
                $hashed_password
            ]);

            $success = 'Account created successfully! You can now sign in.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nard's Inventory System - Register</title>

    <link rel="stylesheet" href="style.css?v=7">
</head>
<body>

<div class="auth-container">

    <div class="auth-card">

        <div class="auth-header">
            <h1>Nard's Inventory System</h1>
            <p>Create your account</p>
        </div>

        <?php if ($error): ?>
            <div class="error">
                <?= h($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success">
                <?= h($success) ?>
            </div>
        <?php endif; ?>

        <?php if (!$success): ?>

            <form method="POST">

                <div class="form-group">
                    <label for="username">Username</label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Enter username"
                        value="<?= h($_POST['username'] ?? '') ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter password"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>

                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        placeholder="Re-enter password"
                        required
                    >
                </div>

                <button type="submit" class="auth-button">
                    Register
                </button>

            </form>

        <?php endif; ?>

        <p class="auth-switch">
            Already have an account?
            <a href="index.php">Sign In</a>
        </p>

    </div>

</div>

</body>
</html>
