<?php session_start(); 
if (!isset($_SESSION['username'])) {
    // Terus tendang dia pergi page login balik
    header("Location: LogIn.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Update Profile</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #b4bcf4; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column; /* Biar nav bar duduk kat atas sekali */
            min-height: 100vh;
        }

        .nav-header {
            background-color: #4f0f69; 
            width: 100%;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        /* Logo Interactive Box */
        .logo-trigger-box {
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 6px;
            border-radius: 8px;
            transition: background-color 0.2s, transform 0.1s;
        }

        .logo-trigger-box:hover {
            background-color: rgba(255, 255, 255, 0.15);
            transform: scale(1.03);
        }

        .nav-logo-img {
            width: 45px;
            height: 45px;
            display: block;
            object-fit: contain;
        }

        .header-title {
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 0.5px;
        }
		
		/* Floating Sidebar Menu Styling */
        .sidebar-menu {
            position: absolute;
            top: 70px;
            left: -260px; /* Hidden offscreen initially */
            width: 240px;
            background-color: #4A154B;
            box-shadow: 4px 8px 25px rgba(0, 0, 0, 0.3);
            border-bottom-right-radius: 12px;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            transition: left 0.3s ease;
            z-index: 5;
        }

        /* Active flyout reveal utility */
        .sidebar-menu.active {
            left: 0;
        }

        .sidebar-menu a {
            color: #FFFFFF;
            padding: 16px 25px;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            border-left: 4px solid transparent;
            transition: background 0.2s, border-left 0.2s;
        }

        .sidebar-menu a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Active item indicator highlighting current location view */
        .sidebar-menu a.active-view {
            background-color: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #B4A4EB;
            font-weight: bold;
        }

        .sidebar-divider {
            height: 1px;
            background-color: rgba(255, 255, 255, 0.15);
            margin: 10px 25px;
        }
		
        /* Container wrapper untuk bagi form duduk tengah skrin bawah nav bar */
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .profile-container {
            background-color: #512b7c;
            width: 100%;
            max-width: 900px;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
            display: flex;
            gap: 40px;
            align-items: flex-start;
        }
    
        .avatar-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            font-size: 18px;
            font-weight: 500;
            width: 160px;
        }

        .avatar-container {
            position: relative;
            width: 140px;
            height: 140px;
            margin-bottom: 15px;
        }

        .avatar-container img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ff99bb; 
            background-color: #ffccd5;
        }

        .file-input-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            opacity: 0;
            cursor: pointer;
        }

        .edit-label {
            cursor: pointer;
            transition: color 0.2s;
        }

        .edit-label:hover {
            color: #ff99bb;
        }
      
        /* Grid System yang lebih stabil */
        .form-section {
            flex: 1;
            display: grid;
            grid-template-columns: 120px 1fr 120px 1fr; /* Set size lebar label siap-siap */
            gap: 15px 15px;
            align-items: center;
        }

        .form-section label {
            color: white;
            font-weight: bold;
            font-size: 13px;
            white-space: nowrap;
        }

        .form-section input[type="text"],
        .form-section input[type="email"],
        .form-section input[type="password"],
        .form-section input[type="date"],
        .form-section select {
            width: 100%;
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            background-color: white;
            color: #333;
            font-size: 13px;
            box-sizing: border-box;
        }

        /* Pembetulan khas untuk wrapper div yang bungkus input skills */
        .skills-wrapper {
            grid-column: span 1;
            width: 100%;
        }

        .full-width-row {
            grid-column: span 3; /* Span 3 baki ruangan grid selepas tolak label */
        }

        .radio-group {
            display: flex;
            align-items: center;
            gap: 15px;
            color: white;
            font-size: 13px;
        }

        .radio-group label {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }

        .radio-group input[type="radio"] {
            margin: 0;
            accent-color: #ff99bb;
        }

        .button-section {
            grid-column: span 4;
            display: flex;
            justify-content: flex-end;
            margin-top: 15px;
        }

        .btn-update {
            background-color: #6320a0; 
            color: white;
            font-weight: bold;
            font-size: 14px;
            padding: 10px 40px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: background-color 0.2s, transform 0.1s;
        }

        .btn-update:hover {
            background-color: #7b2cb7;
            transform: translateY(-1px);
        }

        .btn-update:active {
            transform: translateY(1px);
        }
    </style>
</head>
<body>

<?php
if (isset($_POST['update'])) {
    echo "<script>alert('Update Successful');</script>";
}
?>

<div class="nav-header">
    <div class="logo-trigger-box" id="logoToggle">
        <img src="startIT logo.jpg" alt="startIT Menu Logo" class="nav-logo-img">
    </div>
    <div class="header-title">Update Profile</div>
    <div></div>
</div>

<div class="sidebar-menu" id="panelSidebar">
	<a href="UpdateProfile.php" class="active-view">Update Profile</a>
	<a href="job_vacancy.php">Job Vacancy</a>
	<a href="applicationStatus.php">Application Status</a>
	<div class="sidebar-divider"></div>
	<a href="logout.php" style="color: #FF8A8A; font-size: 0.95rem;">Log Out</a>
</div>
	
<div class="main-content">
    <form method="POST" enctype="multipart/form-data" style="width: 100%; max-width: 900px;">
        <div class="profile-container">
            
            <div class="avatar-section">
				<label for="profile_picture" class="avatar-container" style="display: block; margin-bottom: 15px;">
				<img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Profile Picture" style="cursor: pointer;">
				<input type="file" id="profile_picture" name="profile_picture" class="file-input-wrapper"> </label>
    
				<label for="profile_picture" class="edit-label">Edit</label>
			</div>
			
            <div class="form-section">
                
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname">
                
                <label for="education">Education Level:</label>
                <input type="text" id="education" name="education">

                <label for="ic_number">IC Number:</label>
                <input type="text" id="ic_number" name="ic_number">
                
                <label for="skills">Skills:</label>
                <div class="skills-wrapper">
                    <input type="text" id="skills" name="skills" list="skills-list" placeholder="Select or Type">
                    <datalist id="skills-list">
                        <option value="HTML / CSS">
                        <option value="JavaScript">
                        <option value="Python">
                        <option value="Java">
                        <option value="PHP">
                    </datalist>
                </div>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required>
                
                <label for="experience">Experience years:</label>
                <input type="text" id="experience" name="experience">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
                
                <label for="username">Username:</label>
                <input type="text" id="username" name="username">

                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone">
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">

                <label>Gender:</label>
                <div class="radio-group">
                    <label><input type="radio" name="gender" value="Male"> Male</label>
                    <label><input type="radio" name="gender" value="Female"> Female</label>
                </div>
                
                <div></div><div></div>

                <label for="address">Address:</label>
                <div class="full-width-row">
                    <input type="text" id="address" name="address">
                </div>

                <label for="state">State:</label>
                <input type="text" id="state" name="state">
                
                <label for="city">City:</label>
                <input type="text" id="city" name="city">

                <label for="postcode">Posscode:</label>
                <input type="text" id="postcode" name="postcode">
                
                <div></div><div></div>

                <div class="button-section">
                    <input type="submit" name="update" value="Update" class="btn-update">
                </div>

            </div>
        </div>
    </form>
</div>

<script>
        const logoToggle = document.getElementById('logoToggle');
        const panelSidebar = document.getElementById('panelSidebar');

        // Clicking the icon reveals or conceals the vertical sidebar menu
        logoToggle.addEventListener('click', function(event) {
            event.stopPropagation();
            panelSidebar.classList.toggle('active');
        });

        // Hides sidebar instantly if clicking out bounds of the navigation elements
        document.addEventListener('click', function(event) {
            if (!panelSidebar.contains(event.target) && !logoToggle.contains(event.target)) {
                panelSidebar.classList.remove('active');
            }
        });
</script>

</body>
</html>
