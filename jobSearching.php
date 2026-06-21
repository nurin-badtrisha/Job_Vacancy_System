<?php
include("dbconn.php");

/* ================= SEARCH & FILTER ================= */
$search = "";
$location = "";
$salary = "";

$query = "SELECT * FROM job_posting WHERE 1";

if(isset($_GET['search'])){

    $search = $_GET['search'];
    $location = $_GET['location'];
    $salary = $_GET['salary'];

    if($search != ""){
        $query .= " AND (
                        job_position LIKE '%$search%'
                        OR job_description LIKE '%$search%'
                    )";
    }

    if($location != ""){
        $query .= " AND job_location LIKE '%$location%'";
    }

    if($salary != ""){
        $query .= " AND salary_range >= '$salary'";
    }
}

/* latest post appear first */
$query .= " ORDER BY posted_date DESC";

$result = mysqli_query($dbconn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Vacancy</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", sans-serif;
        }

        body {
            background-color: #b7a9f0;
        }
		
		/* ===== Navigation Header ===== */
		.nav-header {
			background-color: #4f0f69;
			width: 100%;
			height: 70px;
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: 0 40px;
			position: relative;
			box-shadow: 0 4px 15px rgba(0,0,0,0.15);
			z-index: 10;
		}

		.header-title {
			color: white;
			font-size: 1.4rem;
			font-weight: 500;
			position: absolute;
			left: 50%;
			transform: translateX(-50%);
		}

		/* ===== Logo Button ===== */
		.logo-trigger-box {
			cursor: pointer;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 6px;
			border-radius: 8px;
			transition: 0.2s;
		}

		.logo-trigger-box:hover {
			background-color: rgba(255,255,255,0.15);
		}

		.nav-logo-img {
			width: 45px;
			height: 45px;
			object-fit: contain;
		}

		/* ===== Sidebar ===== */
		.sidebar-menu {
			position: absolute;
			top: 70px;
			left: -260px;
			width: 240px;
			background-color: #4A154B;
			box-shadow: 4px 8px 25px rgba(0,0,0,0.3);
			border-bottom-right-radius: 12px;
			padding: 20px 0;
			display: flex;
			flex-direction: column;
			transition: left 0.3s ease;
			z-index: 20;
		}

		.sidebar-menu.active {
			left: 0;
		}

		.sidebar-menu a {
			color: white;
			padding: 16px 25px;
			text-decoration: none;
			font-size: 1rem;
			font-weight: 500;
			border-left: 4px solid transparent;
			transition: 0.2s;
		}

		.sidebar-menu a:hover {
			background-color: rgba(255,255,255,0.1);
		}

		.sidebar-menu a.active-view {
			background-color: rgba(255,255,255,0.15);
			border-left: 4px solid #B4A4EB;
			font-weight: bold;
		}

		.sidebar-divider {
			height: 1px;
			background-color: rgba(255,255,255,0.15);
			margin: 10px 25px;
		}

        /* ===== Main ===== */
        .main {
            padding: 60px 20px;
            text-align: center;
        }

        .headline {
            font-size: 36px;
            color: black;
            margin-bottom: 40px;
        }

        .headline span {
            color: #6b4b3e;
            font-weight: bold;
        }

        /* ===== Search Box ===== */
        .search-box {
            width: 90%;
            max-width: 900px;
            margin: 0 auto 40px;
            background-color: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        .search-box form {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        .search-box input,
        .search-box select {
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ccc;
            width: 220px;
        }

        /* ===== UPDATED: Search Button Styles (Matches Dark Purple Back Button) ===== */
        .search-btn {
            background-color: #4A154B;
            color: #FFFFFF;
            border: none;
            padding: 12px 35px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .search-btn:hover {
            opacity: 0.9;
            background-color: #4A154B; /* Maintains matching base color background */
        }

        /* ===== Cards Container ===== */
        .cards {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background-color: white;
            width: 280px;
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
            text-align: left;
        }

        .card img {
            width: 100%;
            border-radius: 10px;
            height: 150px;
            object-fit: cover;
        }

        .company {
            font-weight: bold;
            margin-top: 10px;
            font-size: 18px;
        }

        .tag {
            display: inline-block;
            background-color: #e7c8ff;
            color: #4b1f6f;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            margin: 8px 0;
        }

        .job-title {
            font-size: 14px;
            color: #444;
            margin-bottom: 8px;
        }

        .details {
            font-size: 13px;
            color: #666;
            margin-top: 5px;
        }

        /* ===== UPDATED: Apply Job Button Styles (Matches Dark Purple Back Button) ===== */
        .apply-btn {
            width: 100%;
            margin-top: 12px;
            background-color: #4A154B;
            color: #FFFFFF;
            border: none;
            padding: 12px 40px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .apply-btn:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>

<div class="nav-header">
    <div class="logo-trigger-box" id="logoToggle">
        <img src="startIT logo.jpg" alt="startIT Menu Logo" class="nav-logo-img">
    </div>

    <div class="header-title">Job Vacancy</div>

    <div></div>
</div>

<div class="sidebar-menu" id="panelSidebar">
    <a href="UpdateProfile.php">Update Profile</a>
    <a href="jobSearching.php" class="active-view">Job Vacancy</a>
    <a href="applicationStatus.php">Application Status</a>

    <div class="sidebar-divider"></div>

    <a href="Login.php" style="color:#FF8A8A; font-size:0.95rem;">
        Log Out
    </a>
</div>

<div class="main">

    <img src="StartIT.png" width="30%">

    <div class="headline">
        Find your <span>Dream</span><br>
        <span>Job</span> here!
    </div>

    <div class="search-box">
        <form method="GET">

            <input type="text" 
                   name="search" 
                   placeholder="Search job title"
                   value="<?php echo htmlspecialchars($search); ?>">

            <input type="text" 
                   name="location" 
                   placeholder="Filter by location"
                   value="<?php echo htmlspecialchars($location); ?>">

            <select name="salary">
                <option value="">Salary Range</option>
                <option value="1000" <?php if($salary == "1000") echo "selected"; ?>>RM1000+</option>
                <option value="2000" <?php if($salary == "2000") echo "selected"; ?>>RM2000+</option>
                <option value="3000" <?php if($salary == "3000") echo "selected"; ?>>RM3000+</option>
                <option value="4000" <?php if($salary == "4000") echo "selected"; ?>>RM4000+</option>
            </select>

            <button type="submit" class="search-btn">
                Search
            </button>

        </form>
    </div>

    <div class="cards">

        <?php
        if(mysqli_num_rows($result) > 0){

            while($row = mysqli_fetch_assoc($result)){
                $imagePath = !empty($row['job_image']) ? $row['job_image'] : 'https://cdn-icons-png.flaticon.com/512/685/685655.png';
        ?>

        <div class="card">
            <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Job Image">

            <div class="company">
                <?php echo htmlspecialchars($row['company_name']); ?>
            </div>

            <div class="tag">
                <?php echo htmlspecialchars($row['job_position']); ?>
            </div>

            <div class="details">
                📍 <?php echo htmlspecialchars($row['job_location']); ?>
            </div>

            <div class="details">
                💰 RM <?php echo htmlspecialchars($row['salary_range']); ?>
            </div>

            <a href="applyJob.php?id=<?php echo urlencode($row['job_id']); ?>">
                <button class="apply-btn">
                    Apply Job
                </button>
            </a>
        </div>

        <?php
            }
        } else {
            echo "<h3>No job found.</h3>";
        }
        ?>

    </div> </div>

<script>
const logoToggle = document.getElementById('logoToggle');
const panelSidebar = document.getElementById('panelSidebar');

logoToggle.addEventListener('click', function(event) {
    event.stopPropagation();
    panelSidebar.classList.toggle('active');
});

document.addEventListener('click', function(event) {
    if (!panelSidebar.contains(event.target) &&
        !logoToggle.contains(event.target)) {

        panelSidebar.classList.remove('active');
    }
});
</script>

</body>
</html>
