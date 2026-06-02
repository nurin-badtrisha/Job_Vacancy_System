<?php require_once 'status.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StartIT</title>
</head>
<body>

    <div class="nav-header">
        <div class="logo-trigger-box" id="logoToggle">
            <img src="startIT logo.jpg" alt="startIT Menu Logo" class="nav-logo-img">
        </div>
        <div class="header-title">Application Status</div>
        <div></div> </div>

    <div class="sidebar-menu" id="panelSidebar">
        <a href="update_profile.php">Update Profile</a>
        <a href="job_vacancy.php">Job Vacancy</a>
        <a href="applicationStatus.php" class="active-view">Application Status</a>
        <div class="sidebar-divider"></div>
        <a href="logout.php" style="color: #FF8A8A; font-size: 0.95rem;">Log Out</a>
    </div>

    <div class="laptop-mockup-frame">
        <div class="status-canvas">
            
            <div class="status-grid">
                <?php if (empty($applications)): ?>
                    <div class="no-data-msg">You haven't applied for any jobs yet.</div>
                <?php else: ?>
                    <?php foreach ($applications as $row): 
                        $jobTitle = htmlspecialchars($row['job_title']);
                        $statusText = htmlspecialchars($row['status']);
                        
                        // Select styling profile based on status text string data
                        $statusClass = 'status-in-progress';
                        if (strtolower($statusText) == 'rejected') {
                            $statusClass = 'status-rejected';
                        } elseif (strtolower($statusText) == 'approve' || strtolower($statusText) == 'approved') {
                            $statusClass = 'status-approve';
                        }
                    ?>
                        <div class="status-box">
                            <div class="company-name">PETRONAS</div>
                            <span class="badge badge-applied">Applied</span>
                            <div class="job-title"><?php echo $jobTitle; ?></div>
                            <div class="process-text <?php echo $statusClass; ?>">
                                <?php echo $statusText; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="action-row">
                <button type="button" onclick="window.location.href='applicant_dashboard.php'" class="back-btn">Back</button>
            </div>

        </div>
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
	
	<style>
        /* Base Reset & Styling Rules */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #B4A4EB;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Full Screen Top Navigation Bar */
        .nav-header {
            background-color: #4f0f69; 
            width: 100%;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            z-index: 10;
        }

        .header-title {
            color: #FFFFFF;
            font-size: 1.4rem;
            font-weight: 500;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
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

        /* Workspace Grid Box Layout Containers */
        .laptop-mockup-frame {
            width: 100%;
            max-width: 1100px;
            padding: 45px 20px;
        }

        .status-canvas {
            background-color: #FFFDF9;
            border-radius: 35px;
            padding: 50px 45px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .status-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 40px;
        }

        .status-box {
            background-color: #ECEAFB; 
            border-radius: 12px;
            padding: 35px 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
        }

        .company-name {
            font-size: 1.15rem;
            font-weight: 700;
            color: #2D2D2D;
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 14px;
            border-radius: 20px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .badge-applied {
            background-color: #F5C2ED;
            color: #A34E97;
        }

        .job-title {
            font-size: 0.95rem;
            color: #555555;
            font-weight: 500;
            margin-top: 4px;
        }

        .process-text {
            font-size: 0.8rem;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-top: 5px;
            text-transform: uppercase;
        }

        /* Status colors */
        .status-in-progress { color: #A0A0A0; }
        .status-rejected { color: #E76F51; }
        .status-approve { color: #2A9D8F; }

        .no-data-msg {
            grid-column: span 3;
            text-align: center;
            color: #777;
            font-size: 1.1rem;
            padding: 40px 0;
        }

        .action-row {
            display: flex;
            justify-content: flex-end;
        }

        .back-btn {
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

        .back-btn:hover {
            opacity: 0.9;
        }

        @media (max-width: 900px) {
            .status-grid { grid-template-columns: repeat(2, 1fr); }
            .no-data-msg { grid-column: span 2; }
        }
        @media (max-width: 600px) {
            .status-grid { grid-template-columns: 1fr; }
            .no-data-msg { grid-column: span 1; }
        }
    </style>
	
</body>
</html>