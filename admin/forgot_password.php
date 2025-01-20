<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .forgot-password-container {
            background: white;
            padding: 2rem;
            border-radius: 0px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .forgot-password-container h2 {
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .form-control {
            border-radius: 0px;
        }
        .btn-custom {
            background-color: #ffc107;
            color: white;
            border-radius: 0px;
            padding: 0.5rem 1.5rem;
        }
        .btn-custom:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>

<div class="forgot-password-container">
    <h2>Lupa Password</h2>
    <form action="forgot_password.php" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" required="required" class="form-control" placeholder="Enter your email">
        </div>
        <div class="mb-3 text-center">
            <input type="submit" name="submit" class="btn btn-custom" value="Kirim Reset Link">
        </div>
    </form>
</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"></script>
</body>
</html>
