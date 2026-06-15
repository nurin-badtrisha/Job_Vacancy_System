<?php
if (!isset($_SESSION['username'])) {
    header("Location: LogIn.php");
    exit();
}
session_start();

$host       = "localhost";
$db_user    = "root";         
$db_pass    = "";             
$db_name    = "startit"; 

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Failed Database Connection !! : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_user  = trim($_POST['username']); 
    $password    = trim($_POST['password']);
    $chosen_role = trim($_POST['user_role']); 

    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    $login_berjaya = false;

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            
            $match_user = false;
            foreach ($row as $key => $value) {
                if (strpos(strtolower($key), 'id') !== false || strpos(strtolower($key), 'user') !== false) {
                    if (trim($value) === $input_user) {
                        $match_user = true;
                    }
                }
            }

            if ($match_user && $password === $row['password'] && strtolower($chosen_role) === strtolower($row['role'])) {
                
                $_SESSION['user_id']  = isset($row['id']) ? $row['id'] : 1;
                $_SESSION['username'] = $input_user; 
                $_SESSION['role']     = strtolower($row['role']);

                $login_berjaya = true;

                if ($_SESSION['role'] === 'admin') {
                    header("Location: admin_dashboard.php");
                } elseif ($_SESSION['role'] === 'person_in_charge' || $_SESSION['role'] === 'pic') {
                    header("Location: pic.php");
                } elseif ($_SESSION['role'] === 'applicant') {
                    header("Location: menu.php");
                }
                exit();
            }
        }
    }

    header("Location: login.php?error= WRONG USERNAME, PASSWORD OR ROLE !!");
    exit();
}
$conn->close();
?>
