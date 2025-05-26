<?php
$servername = "localhost";
$username = "root";
$password = "Hema@5541"; // Leave empty for XAMPP
$dbname = "student_records";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // To store success or error messages

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $roll_no = $conn->real_escape_string($_POST['roll_no']);
    $department = $conn->real_escape_string($_POST['department']);
    $year = (int) $_POST['year'];
    $dob = $conn->real_escape_string($_POST['dob']);
    $email = $conn->real_escape_string($_POST['email']);

    // Check if roll_no or email already exists
    $check_sql = "SELECT * FROM students WHERE roll_no = '$roll_no' OR email = '$email'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        $message = "<p style='color: red;'>Roll Number or Email already exists! Please use a different one.</p>";
    } else {
        // Insert data if roll_no and email do not exist
        $sql = "INSERT INTO students (name, roll_no, department, year, dob, email) 
                VALUES ('$name', '$roll_no', '$department', '$year', '$dob', '$email')";

        if ($conn->query($sql) === TRUE) {
            $message = "<p style='color: green;'>Record added successfully!</p>";
        } else {
            $message = "<p style='color: red;'>Error: " . $conn->error . "</p>";
        }
    }
}

// Handle search query
$search_results = "";
if (isset($_GET['search_name']) && !empty($_GET['search_name'])) {
    $search_name = $conn->real_escape_string($_GET['search_name']); // Prevent SQL injection
    $sql = "SELECT * FROM students WHERE name LIKE '%$search_name%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $search_results .= "<h2>Search Results</h2>";
        $search_results .= "<table><tr><th>Name</th><th>Roll No</th><th>Department</th><th>Year</th><th>Date of Birth</th><th>Email</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $search_results .= "<tr>
                                    <td>{$row['name']}</td>
                                    <td>{$row['roll_no']}</td>
                                    <td>{$row['department']}</td>
                                    <td>{$row['year']}</td>
                                    <td>{$row['dob']}</td>
                                    <td>{$row['email']}</td>
                                </tr>";
        }
        $search_results .= "</table>";
    } else {
        $search_results .= "<p>No records found for '$search_name'</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f4f4f4;
            text-align: center;
        }
        form {
            background: white;
            padding: 20px;
            width: 40%;
            margin: auto;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        input, select, button {
            padding: 8px;
            margin: 10px;
            width: 93%;
            display: block;
        }
        button {
            background: blue;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: darkblue;
        }
        table {
            width: 70%;
            margin: auto;
            background: white;
            border-collapse: collapse;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #333;
            color: white;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
    </style>
</head>
<body>
<h2>Student Registration</h2>
<form method="post">
    <input type="text" name="name" placeholder="Enter Name" required>
    <input type="text" name="roll_no" placeholder="Enter Roll No" required>
    <input type="text" name="department" placeholder="Enter Department" required>
    <input type="number" name="year" placeholder="Enter Year" required min="1" max="5">
    <input type="date" name="dob" required>
    <input type="email" name="email" placeholder="Enter Email" required>
    <button type="submit" name="submit">Submit</button>
</form>

<?= $message; ?>

<h2>Search Student by Name</h2>
<form method="get">
    <input type="text" name="search_name" placeholder="Enter Name" required>
    <button type="submit">Search</button>
</form>

<?= $search_results; ?>

</body>
</html>
