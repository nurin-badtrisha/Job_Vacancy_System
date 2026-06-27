<?php
session_start();
include "dbconn.php";


if (!isset($_SESSION['username'])) {
    die("Error: Please log in first.");
}

if (isset($_POST['submit'])) {
	
    $username = $_SESSION['username'];

    
    $id_lookup_query = "SELECT pic_id FROM person_in_charge WHERE username = ?";
    $stmt_lookup = mysqli_prepare($dbconn, $id_lookup_query);
    mysqli_stmt_bind_param($stmt_lookup, "s", $username);
    mysqli_stmt_execute($stmt_lookup);
    $result = mysqli_stmt_get_result($stmt_lookup);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $pic_id = $row['pic_id']; 
    } else {
        die("Error: Logged in user does not exist in the Person in Charge table.");
    }
    mysqli_stmt_close($stmt_lookup);

    
    $job_position        = $_POST['job_position'];
    $job_description     = $_POST['job_description'];
    $experience          = $_POST['experience'];
    $education           = $_POST['education'];
    $salary_range        = $_POST['salary_range'];
    $job_location        = $_POST['job_location'];
    $language_preference = $_POST['language']; 
    $working_days        = $_POST['working_days'];
    $company_name        = $_POST['company_name'];

   
    if (isset($_FILES['job_image']) && $_FILES['job_image']['error'] === 0) {
        $imageName = $_FILES['job_image']['name'];
        $tmpName   = $_FILES['job_image']['tmp_name'];
        $unique_image_name = uniqid() . "_" . $imageName;
        $folder            = "jobImages/" . $unique_image_name;
        move_uploaded_file($tmpName, $folder);
    } else {
        $folder = NULL; 
    }
	
   
    $sql = "INSERT INTO job_posting 
            (pic_id, job_position, job_description, experience, education, salary_range, job_location, language_preference, working_days, company_name, job_image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($dbconn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param(
            $stmt, 
            "issssssssss", 
            $pic_id, 
            $job_position, 
            $job_description, 
            $experience, 
            $education, 
            $salary_range, 
            $job_location, 
            $language_preference, 
            $working_days, 
            $company_name, 
            $folder
        );

        $query = mysqli_stmt_execute($stmt);
	
        if ($query) {
            echo "<script>
                    alert('Job posting Successful');
                    window.location.href = 'pic.php';
                  </script>";
        } else {
            die("Database Error: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
    } else {
        die("Preparation Error: " . mysqli_error($dbconn));
    }
}

mysqli_close($dbconn);
?>
