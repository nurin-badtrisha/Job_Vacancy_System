<?php 
session_start();
include("dbconn.php");

if(isset($_POST['Submit'])){

    // 1. Fetch data from your new HTML input attributes
    $company_name    = mysqli_real_escape_string($dbconn, $_POST['company_name']);
    $company_email   = mysqli_real_escape_string($dbconn, $_POST['company_email']);
    $contact_number   = mysqli_real_escape_string($dbconn, $_POST['company_phone']);
    $username        = mysqli_real_escape_string($dbconn, $_POST['username']);
    $password        = $_POST['password']; // Will be hashed below
    $company_address = mysqli_real_escape_string($dbconn, $_POST['company_address']);
    $state           = mysqli_real_escape_string($dbconn, $_POST['state']);
    $city            = mysqli_real_escape_string($dbconn, $_POST['city']);

    // Combine city and state for a clean single string database insertion
    $full_address = $company_address . ", " . $city . ", " . $state;

    // Securely hash the password before saving it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 2. INSERT into COMPANY table first
    $sql_company = "INSERT INTO company (company_name, company_email, company_address, contact_number, company_state, company_city) 
                    VALUES ('$company_name', '$company_email', '$company_address', '$contact_number', '$state', '$city')";
    
    if(mysqli_query($dbconn, $sql_company)) {
        
        // Grab the auto-incremented ID generated for this new company
        $company_id = mysqli_insert_id($dbconn);

        // For testing/fallback until your main Admin panel registration loop is complete
        $admin_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : 1; 

        // 3. INSERT into PERSON_IN_CHARGE table using the retrieved company ID
        $sql_pic = "INSERT INTO person_in_charge (admin_id, company_id, email, password) 
                    VALUES ('$admin_id', '$company_id', '$company_email', '$hashed_password')";

        if(mysqli_query($dbconn, $sql_pic)) {
            echo "<script>
                    alert('PIC & Company Registration Successful!');
                    window.location.href = 'mainMenu.php';
                  </script>";
        } else {
            echo "Error creating PIC user account: " . mysqli_error($dbconn);
        }

    } else {
        echo "Error saving Company details: " . mysqli_error($dbconn);
    }
}

mysqli_close($dbconn);
?>