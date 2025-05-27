<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Quiz</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to right, #74ebd5, #ACB6E5);
        }

        form {
            background-color: white;
            text-align: center;
            border: 2px solid #ff4d4d;
            border-radius: 10px;
            width: 350px;
            padding: 40px 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        label {
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
        }

        input[type="text"] {
            margin-top: 10px;
            padding: 10px;
            width: 80%;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        button {
            margin-top: 20px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            color: white;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form action="quiz.php" method="post">
        <label for="username">Enter your name:</label><br>
        <input type="text" name="username" id="username" required><br>
        <button type="submit">Start Quiz</button>
    </form>
</body>
</html>
