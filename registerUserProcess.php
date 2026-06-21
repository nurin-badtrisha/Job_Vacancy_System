<?php 
session_start();
include("dbconn.php");

if(isset($_POST['Submit'])){

    $full_name        = $_POST['fullname'];
    $icnumber         = $_POST['icnumber'];
    $education_level  = $_POST['education'];
    $date_of_birth    = $_POST['dob'];
    $skills           = $_POST['skills'];
    $email            = $_POST['email'];
    $experience_years = $_POST['experience'];
    $phone_number     = $_POST['phone'];
    $username         = $_POST['username'];
    $gender           = $_POST['gender'];
    $password         = $_POST['password']; // Storing as plain text default
    $address          = $_POST['address'];
    $state            = $_POST['state'];
    $city             = $_POST['city'];
    $postcode         = $_POST['postcode'];
	
    // Process profile picture file upload cleanly
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $imageName = $_FILES['profile_picture']['name'];
        $tmpName   = $_FILES['profile_picture']['tmp_name'];

        $uniqueImageName = time() . "_" . $imageName;
        $target_dir = "profile_pics/";
        
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $folder = $target_dir . $uniqueImageName;
        move_uploaded_file($tmpName, $folder);
    } else {
        $folder = NULL; 
    }
	
    $sql = "INSERT INTO applicant
    (full_name, icnumber, education_level, date_of_birth, skills, 
    email, experience_years, phone_number, username, gender, 
    password, address, state, city, postcode, profile_picture) 
    VALUES
    ('$full_name', '$icnumber', '$education_level', '$date_of_birth', '$skills',
    '$email', '$experience_years', '$phone_number', '$username', '$gender',
    '$password', '$address', '$state', '$city', '$postcode', '$folder')";
	
    $query = mysqli_query($dbconn, $sql);
	
    if($query) {
        echo "<script>
                alert('Registration Successfully! You can start log in.');
                window.location.href = 'Login.php';
              </script>";
    } else {
        echo 'Database Error: ' . mysqli_error($dbconn);
    }
}

mysqli_close($dbconn);
?>
