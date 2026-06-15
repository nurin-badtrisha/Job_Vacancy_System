<?php
session_start(); 
if (!isset($_SESSION['username'])) {
    // Terus tendang dia pergi page login balik
    header("Location: LogIn.php");
    exit();
}
include("dbconn.php");

$job_id = isset($_GET['job_id']) ? $_GET['job_id'] : 1;

$sql = "SELECT * FROM job_posting WHERE job_id = '$job_id'";
$query = mysqli_query($dbconn, $sql);

if (!$query) {
    die("Database Error: " . mysqli_error($dbconn));
}

$row = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Apply Job</title>

<style>

body{
    background:#b7a9f0;
    font-family:Segoe UI;
}

.container{
    width:70%;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:20px;
}

img{
    width:100%;
    height:300px;
    object-fit:cover;
    border-radius:15px;
}

h1{
    margin-top:20px;
}

.detail{
    margin-top:15px;
    font-size:18px;
}

.resume-box{
    margin-top:30px;
}

.send-btn{
    margin-top:20px;
    background:#5a2d82;
    color:white;
    border:none;
    padding:12px 30px;
    border-radius:10px;
    cursor:pointer;
    font-size:16px;
}

.send-btn:hover{
    background:#6a3fa0;
}

</style>
</head>

<body>

<div class="container">

    <img src="<?php echo $row['job_image']; ?>">

    <h1>
        <?php echo $row['job_position']; ?>
    </h1>

    <div class="detail">
        📍 Location:
        <?php echo $row['job_location']; ?>
    </div>

    <div class="detail">
        💰 Salary:
        RM <?php echo $row['salary_range']; ?>
    </div>

    <div class="detail">
        🗣 Language:
        <?php echo $row['language_preference']; ?>
    </div>

    <div class="detail">
        🎓 Education:
        <?php echo $row['education']; ?>
    </div>

    <div class="detail">
        💼 Experience:
        <?php echo $row['experience']; ?>
    </div>

    <div class="detail">
        📅 Working Days:
        <?php echo $row['working_days']; ?>
    </div>

    <div class="detail">
        📝 Description:
        <?php echo $row['job_description']; ?>
    </div>

    <form action="sendApplication.php"
          method="POST"
          enctype="multipart/form-data">

        <input type="hidden"
               name="job_id"
               value="<?php echo $row['job_id']; ?>">

        <div class="resume-box">

            <label>
                Upload Resume:
            </label>

            <br><br>

            <input type="file"
                   name="resume"
                   required>

        </div>

        <button type="submit"
                class="send-btn">
            SEND
        </button>

    </form>

</div>

</body>
</html>
