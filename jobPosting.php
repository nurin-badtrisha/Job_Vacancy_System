<?php session_start(); 
if (!isset($_SESSION['username'])) {
    // Terus tendang dia pergi page login balik
    header("Location: LogIn.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Job Posting</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: "Segoe UI", sans-serif;
}

body{
    background:#b7a9f0;
}

.main-container{
    max-width:1200px;   /* control width */
    margin:50px auto;   /* CENTER */
    padding:20px;
}

/* ===== Top Bar ===== */
	.top-bar {
		background-color: #5a2d82;
		height: 70px;
		display: flex;
		align-items: center;
		padding: 0 20px;
		color: white;
		position: relative;
	}

	.top-title {
		flex-grow: 1;
		text-align: center;
		font-size: 22px;
	}

/* Upload Box */
.upload-container{
    display:flex;
    justify-content:center;
    margin-bottom:60px;
}

.upload-box{
    width:190px;
    height:180px;
    background:#dfe2e6;
    border-radius:25px;
    display:flex;
    justify-content:center;
    align-items:center;
    overflow:hidden;
    cursor:pointer;
    box-shadow:0 10px 15px rgba(0,0,0,0.15);
}

.upload-box img{
    width:70px;
    opacity:0.7;
}

.upload-box:hover{
    transform:scale(1.02);
    transition:0.3s;
}

#previewImage.preview-active{
    width:100%;
    height:100%;
    object-fit:cover;
    opacity:1;
}

/* Form Grid */
.form-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:30px 25px;
}

/* Form Group */
.form-group label{
    font-size:24px;
    font-weight:bold;
    display:block;
    margin-bottom:10px;
}

/* Button */
.button-container{
    display:flex;
    justify-content:flex-end;
    gap:15px; /* jarak antara button */
    margin-top:30px;
}

.post-btn{
    background:#5d2d91;
    color:white;
    border:none;
    padding:10px 30px;
    font-size:18px;
    font-weight:bold;
    border-radius:8px;
    cursor:pointer;
    transition:0.3s;
}

.post-btn:hover{
    background:#4a2373;
    transform:scale(1.05);
}

.back-btn{
    background:#d1c6ec;
    color:#2d2525;
    border:3px solid #2d2525;
    padding:10px 25px;
    font-size:18px;
    font-weight:bold;
    border-radius:8px;
    cursor:pointer;
    transition:0.3s;
}

.back-btn:hover{
    background:#b7a9f0;
}

@media(max-width:900px){

    .form-grid{
        grid-template-columns:1fr;
    }

    .title{
        font-size:45px;
    }

}

.form-group.full-width {
    grid-column: span 3;
}

.form-group textarea{
    width:100%;
    height:150px;
    border:6px solid #2d2525;
    font-size:18px;
    padding:10px;
    outline:none;
    background:white;
    resize:none;
    box-shadow:6px 6px 0 rgba(0,0,0,0.15);
}

.form-group input {
    width: 100%;             
    height: 60px;
    border: 6px solid #2d2525;
    font-size: 18px;
    padding: 10px;
    outline: none;
    background: white;
    box-shadow: 6px 6px 0 rgba(0,0,0,0.15);
    display: block;          
}

</style>

<!-- TOP BAR -->
<div class="top-bar">
	<div class="top-title">Job Posting</div>
</div>

<!-- Icons -->
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>

<div class="main-container">
    <!-- Form -->
    <form method="POST" action="jobPostingProcess.php" enctype="multipart/form-data">

		 <!-- Upload Image Section -->
		<div class="upload-container">

        <label for="jobImage" class="upload-box">

            <img id="previewImage"
            src="https://cdn-icons-png.flaticon.com/512/685/685655.png"
            alt="Upload Image">

        </label>

        <input type="file"
        id="jobImage"
        name="job_image"
		accept="image/*"
        hidden>

		</div>
	
        <div class="form-grid">

			<div class="form-group">
                <label>Job Position:</label>
                <input type="text" name="job_position" required>
            </div>

            <div class="form-group">
                <label>Company Name:</label>
                <input type="text" name="company_name" required>
            </div>
			
			<div class="form-group">
				<label>Location:</label>
				<input type="text" name="job_location" required>
			</div>

            <div class="form-group">
                <label>Language Preferences:</label>
                <input type="text" name="language">
            </div>

            <div class="form-group">
                <label>Educational Level:</label>
                <input type="text" name="education">
            </div>

            <div class="form-group">
                <label>Years of Working Experience:</label>
                <input type="text" name="experience">
            </div>

            <div class="form-group">
                <label>Working Days:</label>
                <input type="text" name="working_days">
            </div>

            <div class="form-group">
                <label>Salary Range:</label>
                <input type="text" name="salary_range">
            </div>
			
			<div class="form-group full width">
				<label> Job Description:</label>
				<textarea placeholder="Enter job description here.." name="job_description" required></textarea>
			</div>
        </div>

        <div class="button-container">
			 <button type="button" class="back-btn"
				onclick="window.location.href='PICinterfaces.php'">
				BACK
			 </button>
	
            <button type="submit" name="submit" class="post-btn">
				POST!
			</button>
        </div>

    </form>

</div>

<script>

const imageInput = document.getElementById("jobImage");
const previewImage = document.getElementById("previewImage");

imageInput.addEventListener("change", function(){

    const file = this.files[0];

    if(file){

        const reader = new FileReader();

        reader.onload = function(e){

            previewImage.setAttribute("src", e.target.result);
            previewImage.classList.add("preview-active");

        }

        reader.readAsDataURL(file);

    }

});

</script>
</body>
</html>
