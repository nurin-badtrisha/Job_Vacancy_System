<?php
session_start(); // Start session to track which applicant is logged in
include("dbconn.php");

// 1. Check if the user is logged in by username (most login scripts save this)
if (!isset($_SESSION['username'])) {
    die("Error: You must be logged in as an applicant to apply for this job. Please go to the login page and log in first.");
}

// 2. Validate form data arrival from applyJob.php
if (isset($_POST['job_id']) && isset($_FILES['resume'])) {
    
    $username = $_SESSION['username'];
    $job_id = $_POST['job_id'];

    // 3. BYPASS LOOKUP: Find the applicant_id using the username automatically
    $id_lookup_query = "SELECT applicant_id FROM applicant WHERE username = ?";
    $stmt_lookup = mysqli_prepare($dbconn, $id_lookup_query);
    mysqli_stmt_bind_param($stmt_lookup, "s", $username);
    mysqli_stmt_execute($stmt_lookup);
    $result_lookup = mysqli_stmt_get_result($stmt_lookup);
    
    if ($row_user = mysqli_fetch_assoc($result_lookup)) {
        $applicant_id = $row_user['applicant_id']; // Found the true numeric ID!
    } else {
        die("Error: Logged-in user account details not found in the applicant database registry.");
    }
    mysqli_stmt_close($stmt_lookup);

    // 4. Handle file upload safely
    $resumeName = $_FILES['resume']['name'];
    $tmpName = $_FILES['resume']['tmp_name'];
    
    $unique_resume_name = uniqid() . "_" . $resumeName;
    $folder = "resume/" . $unique_resume_name;

    if (move_uploaded_file($tmpName, $folder)) {
        
        // 5. Insert application data into 'apply_job' 
        $sql = "INSERT INTO apply_job (applicant_id, job_id, resume_path, applicant_status, applied_date) 
                VALUES (?, ?, ?, 'Pending', CURDATE())";

        $stmt = mysqli_prepare($dbconn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "iis", $applicant_id, $job_id, $folder);
            $query = mysqli_stmt_execute($stmt);

            if ($query) {
                echo "
                <script>
                    alert('Your application was successful! You can track your application progress in application status.');
                    window.location.href='jobSearching.php';
                </script>
                ";
            } else {
                if (mysqli_errno($dbconn) == 1062) {
                    die("Error: You have already submitted an application for this job vacancy.");
                }
                die("Database Error: " . mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);
        } else {
            die("Preparation Error: " . mysqli_error($dbconn));
        }
    } else {
        // Fix: Removed the problematic backslashes from the path string here
        die("Error: Failed to upload the resume file to the server folder. Please verify that a folder named 'resume' exists inside your StartIT folder.");
    }
} else {
    die("Error: Invalid form submission request.");
}

mysqli_close($dbconn);
?>
