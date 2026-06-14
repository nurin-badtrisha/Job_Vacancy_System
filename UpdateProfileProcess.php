<?php
include('dbconn.php');
session_start();

$applicant_id = $_SESSION['applicant_id'] ?? 'APP001';


if (isset($_POST['update'])) {
    
  
    $full_name        = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $phone_number     = mysqli_real_escape_string($conn, trim($_POST['phone_number']));
    $date_of_birth    = mysqli_real_escape_string($conn, trim($_POST['date_of_birth']));
    $gender           = mysqli_real_escape_string($conn, trim($_POST['gender']));
    $education_level  = mysqli_real_escape_string($conn, trim($_POST['education_level']));
    $experience_years = mysqli_real_escape_string($conn, trim($_POST['experience_years']));
    $address          = mysqli_real_escape_string($conn, trim($_POST['address']));
    $username         = mysqli_real_escape_string($conn, trim($_POST['username']));
    
    $image_query = "";

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $target_dir  = "uploads/";
        
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_name   = time() . "_" . basename($_FILES["profile_picture"]["name"]);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_types = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            }
        }
    }

    $sql = "UPDATE APPLICANT SET 
            username = '$username',
            full_name = '$full_name',
            phone_number = '$phone_number',
            date_of_birth = '$date_of_birth',
            gender = '$gender',
            education_level = '$education_level',
            experience_years = '$experience_years',
            address = '$address'
            $image_query
            WHERE applicant_id = '$applicant_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Profil berjaya dikemas kini!'); window.location='updateprofile.php';</script>";
    } else {
        echo "<script>alert('Ralat semasa mengemas kini: " . mysqli_error($conn) . "'); window.location='updateprofile.php';</script>";
    }
} else {
    header("Location: updateprofile.php");
    exit();
}
?>