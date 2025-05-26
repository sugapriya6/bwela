<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_db";
$conn = new mysqli($servername, $username, $password, "", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);
$conn->query("CREATE TABLE IF NOT EXISTS student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    age INT,
    gender VARCHAR(10),
    department VARCHAR(50),
    dob VARCHAR(50),
    district VARCHAR(50)
)");
$conn->query("CREATE TABLE IF NOT EXISTS search_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filter_type VARCHAR(50),
    filter_value VARCHAR(50),
    time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
if (isset($_POST['submit_student'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $department = $_POST['department'];
    $dob = $_POST['dob'];
    $district = $_POST['district'];

    $sql = "INSERT INTO student (name, age, gender, department, dob, district)
            VALUES ('$name', $age, '$gender', '$department', '$dob', '$district')";
    $conn->query($sql);
}
if (isset($_POST['filter'])) {
    $filterType = $_POST['filter_type'];
    $filterValue = $_POST['filter_value'];

    $_SESSION['filters'][$filterType] = $filterValue;
    setcookie("filter_$filterType", $filterValue, time() + 86400, "/");

    $stmt = $conn->prepare("INSERT INTO search_logs (filter_type, filter_value) VALUES (?, ?)");
    $stmt->bind_param("ss", $filterType, $filterValue);
    $stmt->execute();
    $stmt->close();
}
if (isset($_POST['clear_filters'])) {
    unset($_SESSION['filters']);
    foreach ($_COOKIE as $key => $val) {
        if (strpos($key, 'filter_') === 0) {
            setcookie($key, '', time() - 3600, "/");
        }
    }
}
$where = [];
if (isset($_SESSION['filters'])) {
    foreach ($_SESSION['filters'] as $key => $value) {
        $where[] = "$key = '$value'";
    }
}
$whereSQL = $where ? "WHERE " . implode(" AND ", $where) : "";
$result = null;
if (!empty($_SESSION['filters'])) {
    $result = $conn->query("SELECT * FROM student $whereSQL");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Entry & Filter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        h2, h3 {
            color: #333;
        }
        form {
            background: #fff;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            max-width: 400px;
        }
        input[type="text"], input[type="number"], input[type="date"], select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"], button {
            padding: 8px 16px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background-color: white;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #aaa;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        hr {
            margin: 30px 0;
        }
        p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <h2>Enter Student Details</h2>
    <form method="post">
        <input type="text" name="name" placeholder="Name" required>
        <input type="number" name="age" placeholder="Age" required>
        <select name="gender" required>
            <option value="">Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        <input type="text" name="department" placeholder="Department" required>
        <input type="date" name="dob" placeholder="dob" required>
        <input type="text" name="district" placeholder="district" required>
        <input type="submit" name="submit_student" value="Add Student">
    </form>
    <hr>
    <h2>Filter Students</h2>
    <form method="post">
        <select name="filter_type" required>
            <option value="">Select Filter Type</option>
            <option value="gender">Gender</option>
            <option value="name">Name</option>
            <option value="department">Department</option>
            <option value="district">District</option>
        </select>
        <input type="text" name="filter_value" placeholder="Enter value" required>
        <input type="submit" name="filter" value="Apply Filter">
    </form>
    <form method="post" style="margin-top: 10px;">
        <input type="submit" name="clear_filters" value="Clear Filters">
    </form>
    <h3>Active Filters:</h3>
    <?php
    if (!empty($_SESSION['filters'])) {
        foreach ($_SESSION['filters'] as $k => $v) {
            echo "<p><strong>$k:</strong> $v</p>";
        }
    } else {
        echo "<p>No filters applied.</p>";
    }
    ?>
    <?php if (!empty($_SESSION['filters'])): ?>
        <h2>Filtered Students</h2>
        <table>
            <tr>
                <th>ID</th><th>Name</th><th>Age</th><th>Gender</th><th>Department</th><th>Date of Birth</th><th>District</th>
            </tr>
            <?php
            if ($result && $result->num_rows > 0):
                while($row = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['age'] ?></td>
                <td><?= $row['gender'] ?></td>
                <td><?= $row['department'] ?></td>
                <td><?= $row['dob'] ?></td>
                <td><?= $row['district'] ?></td>
            </tr>
            <?php endwhile; else: ?>
            <tr><td colspan="7">No student found matching the filters.</td></tr>
            <?php endif; ?>
        </table>
    <?php endif; ?>
</body>
</html>
