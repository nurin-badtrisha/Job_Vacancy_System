<?php
$servername = "localhost";
$username   = "root"; 
$password   = "";     
$dbname = "startit"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection to database failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StartIT - Dashboard</title>
    <link rel="stylesheet" href="dashboard-style.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body, html {
            height: 100%;
            background-color: #f7f5f0;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* --- LEFT SIDE STYLING --- */
        .left-col {
            width: 50%;
            background-color: #FAF6F0; 
            padding: 40px 60px;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            transition: width 0.3s ease;
        }

        .left-col.full-width {
            width: 100%;
        }

        .header-logo { 
            display: flex;         
            align-items: center;
            gap: 12px;
        }

        .header-logo img {
            width: 45px;
            max-height: 45px;
        }

        .logo-text {
            font-family: serif;
            font-size: 20px;
            font-weight: bold;
            color: #111;
        }

        .left-content {
            margin-top: 15%;
            max-width: 450px;
            z-index: 2;
        }

        .left-content h1 {
            font-size: 3.2rem;
            color: #584137; 
            line-height: 1.15;
            margin-bottom: 25px;
        }

        .left-content .subtitle {
            color: #72625A;
            font-size: 1.05rem;
            line-height: 1.6;
        }

        .building-bg {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80%;
            height: 40%;
            background: linear-gradient(135deg, #e3d5ca 0%, #d5bdaf 100%);
            border-top-right-radius: 12px;
            opacity: 0.6;
            z-index: 1;
        }

        /* --- RIGHT SIDE STYLING --- */
        .right-col {
            width: 50%;
            background-color: #B4A4EB; 
            padding: 40px 60px;
            display: none; 
            flex-direction: column;
            align-items: flex-end;
            animation: fadeIn 0.5s ease-in-out;
        }

        .right-col.show-history {
            display: flex;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .top-nav {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-bottom: 50px;
        }

        .btn {
            display: inline-block;
            padding: 12px 28px;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            border-radius: 6px;
            letter-spacing: 0.5px;
            cursor: pointer;
            border: none;
            transition: transform 0.2s, opacity 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .btn-primary {
            background-color: #4A154B; 
            color: white;
        }

        .btn-secondary {
            background-color: #4A154B;
            color: white;
        }

        .feed-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
            max-width: 500px;
            width: 100%;
        }

        .section-title {
            color: #4A154B;
            font-size: 1.6rem;
            margin-bottom: 10px;
            align-self: flex-start;
        }

        .job-card {
            background-color: #FFFDF9;
            border-radius: 12px;
            padding: 20px; 
            display: flex;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            position: relative;
            transition: transform 0.2s;
            width: 100%;
        }

        .job-card:hover {
            transform: scale(1.02);
        }

        .job-card:nth-child(even) { margin-left: -20px; }
        .job-card:nth-child(odd):not(.section-title) { margin-left: 20px; }

        .card-details {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 6px;
        }

        .badge {
            align-self: flex-start;
            padding: 4px 10px;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 20px;
        }

        .badge-orange {
            background-color: #FFEEDB;
            color: #D48C46;
        }

        .card-details h3 {
            font-size: 1.2rem;
            color: #444;
        }

        .location {
            color: #888;
            font-size: 0.9rem;
        }

        .card-meta {
            margin-left: auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-end;
            padding-bottom: 4px;
        }

        .edit-link {
            color: #b0b0b0;
            font-size: 0.85rem;
            text-decoration: none;
        }

        .edit-link:hover {
            color: #4A154B;
            text-decoration: underline;
        }

        .time-stamp {
            color: #b0b0b0;
            font-size: 0.85rem;
        }

        @media (max-width: 900px) {
            .dashboard-container { flex-direction: column; }
            .left-col, .right-col { width: 100%; padding: 30px; }
            .job-card:nth-child(even), .job-card:nth-child(odd) { margin-left: 0; }
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        
        <div class="left-col full-width" id="leftColumn">
            <div class="header-logo">
                <img src="startIt logo.jpg" alt="Logo">
                <span class="logo-text">Person In Charge</span>
            </div>

            <div class="left-content">
                <h1>Post Your Job<br>Vacancy Here!</h1>
                <p class="subtitle">
                    Start IT is the platform to all company posted and review the applicant in IT field easily.
                </p>
                <br>
                <button type="button" class="btn btn-primary" id="initPostBtn" onclick="toggleHistoryView()" style="align-self: flex-start; margin-top: 15px;">JOB POST</button>
            </div>
            
            <div class="building-bg"></div>
        </div>

        <div class="right-col" id="rightColumn">
            
            <div class="top-nav">
                <a href="jobPosting.php" class="btn btn-primary">JOB POST</a>
                <a href="applicantStatus.php" class="btn btn-secondary">APPLICANT</a>
            </div>

            <div class="feed-section">
                <h2 class="section-title">History Post</h2>

                <?php
                $query = "SELECT * FROM jobs ORDER BY created_at DESC"; 
                $result = $conn->query($query); 

                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) { 
                        
                        $time_posted = strtotime($row['created_at']);
                        $time_diff = time() - $time_posted;
                        
                        if ($time_diff < 60) {
                            $time_display = "Just now";
                        } elseif ($time_diff < 3600) {
                            $time_display = round($time_diff / 60) . " min ago";
                        } elseif ($time_diff < 86400) {
                            $time_display = round($time_diff / 3600) . " hour ago";
                        } else {
                            $time_display = round($time_diff / 86400) . " day ago";
                        }
                        ?>
                        
                        <div class="job-card">
                            <div class="card-details">
                                <span class="badge badge-orange"><?php echo htmlspecialchars($row['job_position']); ?></span>
                                <h3><?php echo htmlspecialchars($row['company_name']); ?></h3>
                                <p class="location"><?php echo htmlspecialchars($row['location']); ?></p>
                            </div>
                            <div class="card-meta">
                                <a href="editJob.php?id=<?php echo $row['id']; ?>" class="edit-link">Edit</a>
                                <span class="time-stamp"><?php echo $time_display; ?></span>
                            </div>
                        </div>

                        <?php
                    }
                } else {
                    echo "<p style='color: white; font-style: italic;'>No history posts found.</p>";
                }
                $conn->close();
                ?>

            </div>

        </div>

    </div>

    <script>
        function toggleHistoryView() {
            const leftCol = document.getElementById('leftColumn');
            const rightCol = document.getElementById('rightColumn');
            const initBtn = document.getElementById('initPostBtn');

            leftCol.classList.remove('full-width');
            rightCol.classList.add('show-history');
            initBtn.style.display = 'none';
        }
    </script>

</body>
</html>