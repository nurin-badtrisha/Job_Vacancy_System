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
    <title>Job Vacancy - StartIT</title>

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

        .logo-btn {
            cursor: pointer;
            font-size: 28px;
            margin-right: 20px;
        }

        .top-title {
            flex-grow: 1;
            text-align: center;
            font-size: 22px;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            position: absolute;
            top: 70px;
            left: 0;
            width: 220px;
            background-color: #4b1f6f;
            display: none;
            flex-direction: column;
            box-shadow: 4px 4px 10px rgba(0,0,0,0.3);
            z-index: 10;
        }

        .sidebar a {
            padding: 18px;
            color: white;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .sidebar a:hover {
            background-color: #6a3fa0;
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
        }

        .search-box input,
        .search-box select {
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ccc;
            width: 220px;
        }

        .search-btn {
            background-color: #5a2d82;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            cursor: pointer;
        }

        .search-btn:hover {
            background-color: #6a3fa0;
        }

        /* ===== Cards ===== */
        .cards {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
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

        .apply-btn {
            width: 100%;
            margin-top: 12px;
            padding: 10px;
            border: none;
            border-radius: 10px;
            background-color: #5a2d82;
            color: white;
            font-size: 14px;
            cursor: pointer;
        }

        .apply-btn:hover {
            background-color: #6a3fa0;
        }
    </style>
</head>

<body>

<!-- ===== Top Bar ===== -->
<div class="top-bar">
    <div class="logo-btn" onclick="toggleMenu()">☰</div>
    <div class="top-title">Job Vacancy</div>

    <div class="sidebar" id="sidebar">
        <a href="#">Update Profile</a>
        <a href="menu2.php">Job Vacancy</a>
        <a href="applicationStatus.php">Application Status</a>
    </div>
</div>

<!-- ===== Main ===== -->
<div class="main">

    <img src="StartIT.png" width="30%">

    <div class="headline">
        Find your <span>Dream</span><br>
        <span>Job</span> here!
    </div>

    <!-- ===== SEARCH & FILTER ===== -->
    <div class="search-box">
        <form method="GET">

            <input type="text" 
                   name="search" 
                   placeholder="Search job title"
                   value="<?php echo $search; ?>">

            <input type="text" 
                   name="location" 
                   placeholder="Filter by location"
                   value="<?php echo $location; ?>">

            <select name="salary">
                <option value="">Salary Range</option>
                <option value="1000">RM1000+</option>
                <option value="2000">RM2000+</option>
                <option value="3000">RM3000+</option>
                <option value="4000">RM4000+</option>
            </select>

            <button type="submit" class="search-btn">
                Search
            </button>

        </form>
    </div>

    <!-- ===== JOB CARDS ===== -->

        <?php
        if(mysqli_num_rows($result) > 0){

            while($row = mysqli_fetch_assoc($result)){
        ?>

		<div class="card">
			<img src="<?php echo $row['image']; ?>">

			<div class="company">
				<?php echo $row['company_name']; ?>
			</div>

			<div class="tag">
				<?php echo $row['job_position']; ?>
			</div>

			<div class="details">
				📍 <?php echo $row['location']; ?>
			</div>

			<div class="details">
				💰 RM <?php echo $row['salary']; ?>
			</div>

			<a href="applyJob.php?id=<?php echo $row['id']; ?>">
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

</div>

<!-- ===== JavaScript ===== -->
<script>

function toggleMenu() {
    const sidebar = document.getElementById("sidebar");

    sidebar.style.display =
        sidebar.style.display === "flex"
        ? "none"
        : "flex";
}

</script>

</body>
</html>