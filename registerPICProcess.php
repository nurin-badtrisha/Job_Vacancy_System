<?php 
session_start();
include("dbconn.php");

if(isset($_POST['Submit'])){

    
    $company_name    = mysqli_real_escape_string($dbconn, $_POST['company_name']);
    $company_email   = mysqli_real_escape_string($dbconn, $_POST['company_email']);
    $contact_number   = mysqli_real_escape_string($dbconn, $_POST['company_phone']);
    $username        = mysqli_real_escape_string($dbconn, $_POST['username']);
    $password        =  mysqli_real_escape_string($dbconn, $_POST['password']); 
    $company_address = mysqli_real_escape_string($dbconn, $_POST['company_address']);
    $state           = mysqli_real_escape_string($dbconn, $_POST['state']);
    $city            = mysqli_real_escape_string($dbconn, $_POST['city']);

   
    $full_address = $company_address . ", " . $city . ", " . $state;

    
    $sql_company = "INSERT INTO company (company_name, company_email, company_address, contact_number, company_state, company_city) 
                    VALUES ('$company_name', '$company_email', '$company_address', '$contact_number', '$state', '$city')";
    
    if(mysqli_query($dbconn, $sql_company)) {
        
        
        $company_id = mysqli_insert_id($dbconn);

        
        $admin_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : 1; 

        
        $sql_pic = "INSERT INTO person_in_charge (admin_id, company_id, username, password) 
                    VALUES ('$admin_id', '$company_id', '$username', '$password')";

        if(mysqli_query($dbconn, $sql_pic)) {
            echo "<script>
                    alert('PIC & Company Registration Successful!');
                    window.location.href = 'adminReport.php';
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
