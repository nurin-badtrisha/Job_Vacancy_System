<?php 

session_start();
include("dbconn.php");

if(isset($_POST['Submit'])){

	$full_name = $_POST['fullname'];
	$icnumber = $_POST ['icnumber'];
	$education_level = $_POST['education'];
	$date_of_birth = $_POST['dob'];
	$skills = $_POST['skills'];
	$email = $_POST['email'];
	$experience_years = $_POST['experience'];
	$phone_number = $_POST['phone'];
	$username = $_POST['username'];
	$gender = $_POST['gender'];
	$password = $_POST['password'];
	$address = $_POST['address'];
	$state = $_POST['state'];
	$city = $_POST['city'];
	$postcode = $_POST['postcode'];
	
	$sql= "INSERT INTO applicant
	(full_name, icnumber, education_level, date_of_birth, skills, 
	email, experience_years, phone_number, username, gender, 
	password, address, state, city, postcode) 
	VALUES
	 ('$full_name', '$icnumber', '$education_level', '$date_of_birth', '$skills',
    '$email', '$experience_years', '$phone_number', '$username', '$gender',
    '$password', '$address', '$state', '$city', '$postcode')";
	
	$query = mysqli_query($dbconn, $sql);
	
	if($query) {

    echo "<script>
            alert('Registration Successful');
            window.location.href = 'mainMenu.php';
          </script>";

		} else {

			echo "Database Error: " . mysqli_error($dbconn);
		}

}

mysqli_close($dbconn);

?>
