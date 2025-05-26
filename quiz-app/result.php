<?php session_start();
include 'db.php';

$score = 0;
$answers = $_POST['answer'] ?? [];

foreach ($_SESSION['quiz'] as $q) {
    $qid = $q['id'];
    $correct = $q['correct_option'];
    $userAnswer = $answers[$qid] ?? '';

    if ($userAnswer === $correct) {
        $score++;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Quiz Result</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f0f4f8;
      margin: 0;
      padding: 40px;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .result-container {
      background: white;
      padding: 30px 40px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      text-align: center;
      max-width: 500px;
      width: 100%;
    }

    h2 {
      color: #2c3e50;
    }

    h3 {
      color: #27ae60;
      margin-top: 15px;
    }

    a {
      display: inline-block;
      margin-top: 25px;
      padding: 10px 20px;
      background-color: #3498db;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    a:hover {
      background-color: #2980b9;
    }
  </style>
</head>
<body>
  <div class="result-container">
    <h2>Hi, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <h3>Your score: <?php echo $score; ?> / <?php echo count($_SESSION['quiz']); ?></h3>
    <a href="quiz.php">Try Another Set</a>
  </div>
</body>
</html>











































 
