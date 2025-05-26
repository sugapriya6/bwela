<?php session_start();
include 'db.php';

$username = $_POST['username'] ?? $_SESSION['username'];
$_SESSION['username'] = $username;

$conn->query("insert ignore into users (username) values ('$username')");

$result = $conn->query("select * from questions order by RAND() limit 5");

$_SESSION['quiz'] = [];
while ($row = $result->fetch_assoc()) {
    $_SESSION['quiz'][] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Quiz</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      margin: 0;
      padding: 20px;
    }

    form {
      background: white;
      padding: 25px;
      border-radius: 10px;
      max-width: 800px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h3 {
      text-align: center;
      color: #2c3e50;
    }

    fieldset {
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 20px;
      background-color: #fafafa;
    }

    legend {
      font-weight: bold;
      color: #34495e;
    }

    label {
      display: block;
      margin: 8px 0;
      cursor: pointer;
    }

    input[type="radio"] {
      margin-right: 10px;
    }

    button[type="submit"] {
      background-color: #3498db;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      display: block;
      margin: 0 auto;
      transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
      background-color: #2980b9;
    }
  </style>
</head>
<body>
  <form action="result.php" method="post">
    <h3>Quiz for <?php echo htmlspecialchars($username); ?></h3>
    <?php foreach ($_SESSION['quiz'] as $index => $q): ?>
      <fieldset>
        <legend><?php echo ($index + 1) . ". " . $q['question']; ?></legend>
        <label><input type="radio" name="answer[<?php echo $q['id']; ?>]" value="A"> <?php echo $q['option_a']; ?></label>
        <label><input type="radio" name="answer[<?php echo $q['id']; ?>]" value="B"> <?php echo $q['option_b']; ?></label>
        <label><input type="radio" name="answer[<?php echo $q['id']; ?>]" value="C"> <?php echo $q['option_c']; ?></label>
        <label><input type="radio" name="answer[<?php echo $q['id']; ?>]" value="D"> <?php echo $q['option_d']; ?></label>
      </fieldset>
    <?php endforeach; ?>
    <button type="submit">Submit Quiz</button>
  </form>
</body>
</html>






































<!-- <?php session_start();
include 'db.php';

$username=$_POST['username'] ?? $_SESSION['username'];
$_SESSION['username']=$username;

$conn->query("insert ignore into users (username) values ('username')");

$result=$conn->query("select * from questions order by RAND() limit 5");

$_SESSION['quiz']=[];
while($row=$result->fetch_assoc()){
    $_SESSION['quiz'][]=$row;
}
?>
<form action="result.php" method="post">
    <h3>Quiz for <?php echo htmlspecialchars($username); ?></h3>
    <?php foreach ($_SESSION['quiz'] as $index=>$q):?>
        <fieldset>
            <legend><?php echo ($index + 1).".".$q['question']; ?></legend>
            <label for=""><input type="radio" name="answer[<?php echo $q['id']; ?>]" value="A"> <?php echo $q['option_a']; ?></label><br>
            <label for=""><input type="radio" name="answer[<?php echo $q['id']; ?>]" value="B"> <?php echo $q['option_b']; ?></label><br>
            <label for=""><input type="radio" name="answer[<?php echo $q['id']; ?>]" value="C"> <?php echo $q['option_c']; ?></label><br>
            <label for=""><input type="radio" name="answer[<?php echo $q['id']; ?>]" value="D"> <?php echo $q['option_d']; ?></label><br>
           
        </fieldset>
        <br>
        <?php endforeach; ?>
        <button type="submit">Submit Quiz</button>
</form> -->