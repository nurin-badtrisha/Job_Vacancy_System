<?php

session_start();
include "dbconn.php";

if(isset($_POST['submit'])){
	
	$pic_id = $_SESSION['pic_id'];

    $job_position       = $_POST['job_position'];
    $job_description    = $_POST['job_description'];
    $experience         = $_POST['experience'];
    $education          = $_POST['education'];
    $salary_range       = $_POST['salary_range'];
    $job_location       = $_POST['job_location'];
    $language_preference = $_POST['language']; 
    $working_days       = $_POST['working_days'];
    $company_name       = $_POST['company_name'];

    /* IMAGE */
	if (isset($_FILES['job_image']) && $_FILES['job_image']['error'] === 0) {
        $imageName = $_FILES['job_image']['name'];
        $tmpName = $_FILES['job_image']['tmp_name'];

        $unique_image_name = uniqid() . "_" . $imageName;
        $folder = "jobImages/" . $unique_image_name;
        
        move_uploaded_file($tmpName, $folder);
    } else {
        $folder = NULL; 
    }
	
    $sql = "INSERT INTO job_posting 
            (pic_id, job_position, job_description, experience, education, salary_range, job_location, language_preference, working_days, company_name, job_image)
            VALUES 
            ('$pic_id', '$job_position', '$job_description', '$experience', '$education', '$salary_range', '$job_location', '$language_preference', '$working_days', '$company_name', '$folder')";

    $query = mysqli_query($dbconn, $sql);
	
	if($query) {
		echo "<script>
				alert('Job posting Successful');
				window.location.href = 'menu2.php';
			  </script>";

	} else {

		die("Database Error: ". mysqli_error($dbconn));
	}
}

mysqli_close($dbconn);
?>