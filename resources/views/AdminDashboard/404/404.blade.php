<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            font-family: 'Avenir', sans-serif;
        }

        .container {
            text-align: center;
        }

        .error-icon {
            width: 250px;
            height: 250px;
            margin-bottom: 30px;
            position: relative;
            animation: bounce 2s infinite;
        }

        .error-icon img {
            width: 500px;
            height: 100%;
            object-fit: contain;
            margin: auto;
        }

        h1 {
            font-size: 48px;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
        }

        a {
            padding: 10px 20px;
            background-color: #3490dc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        a:hover {
            background-color: #2779bd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-icon">
            <img src="assets/img/404-error.webp" alt="404 Poster">
        </div>
        <h1>Oops! Page Not Found</h1>
        <p>The page you're looking for doesn't exist.</p>
        <a href="{{ url('/admin') }}">Go back to Homepage</a>
    </div>
</body>
</html>
