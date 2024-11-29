<?php
session_start();
include 'koneksi.php'; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Hash password dengan MD5
    $role = $_POST['role']; // Input role (admin/kasir)

    // Query untuk memeriksa username, password, dan role
    $query = "SELECT * FROM tb_user WHERE username = '$username' AND password = '$password' AND role = '$role' LIMIT 1";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Jika data cocok, buat sesi dan arahkan ke dashboard sesuai role
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect berdasarkan role
        if ($role == 'admin') {
            header("Location: index.php");
        } else if ($role == 'kasir') {
            header("Location: index.php");
        }
        exit();
    } else {
        echo "<p class='error'>Login gagal! Periksa username, password, atau role.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FFF5EE;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: white;
            width: 100%;
            max-width: 400px;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            font-weight: bold;
            text-align: left;
            margin-bottom: 5px;
            color: #333;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            background-color: #FFF5EE;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #FFA500;
            box-shadow: 0 0 5px rgba(255, 165, 0, 0.5);
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #FFA500;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #FF8C00;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="role">Role:</label>
            <select name="role" required>
                <option value="admin">Admin</option>
                <option value="kasir">Kasir</option>
            </select>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
