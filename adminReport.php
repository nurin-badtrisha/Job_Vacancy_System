<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Report</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #b4bcf4; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column; /* Menyusun nav-header di atas dan kontena di bawah */
            align-items: center;    /* MENGETENGAHKAN KANDUNGAN SECARA MENDATAR (KIRI-KANAN) */
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
            position: relative;
        }

       
        .logo-trigger-box {
            flex: 1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: flex-start;
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
            flex: 1;
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 0.5px;
        }
        
      
        .header-nav {
            flex: 1;
            display: flex;
            justify-content: flex-end;
            gap: 20px; /* Jarakkan dua button di kanan */
        }

        .header-nav a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: text-decoration 0.2s;
        }

        .header-nav a:hover {
            text-decoration: underline;
        }
        
        /* --- Floating Sidebar Menu Styling --- */
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
        
        /* --- Main Content Card --- */
        .container {
            width: 90%;
            max-width: 1000px;
            margin: auto; /* MENGETENGAHKAN KAD KANAN-KIRI DAN ATAS-BAWAH SECARA AUTOMATIK */
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 30px;
            padding: 40px;
            box-shadow: 5px 10px 20px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        /* --- Search Bar --- */
        .search-container {
            display: flex;
            align-items: center;
            background-color: #fffdf6; 
            border-radius: 8px;
            padding: 8px 15px;
            width: 100%;
            max-width: 500px;
            border: 1px solid #f1ece1;
        }

        .search-container i {
            color: #8e8271;
            margin-right: 15px;
            font-size: 16px;
        }

        .search-container input {
            border: none;
            background: transparent;
            width: 100%;
            outline: none;
            font-size: 15px;
            color: #333;
        }

        .search-container input::placeholder {
            color: #c5bdae;
        }

        /* --- Data Table --- */
        .table-wrapper {
            border: 1px solid #b3a2f2;
            border-radius: 4px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f1effd; 
        }

        th {
            background-color: #b3a2f2; 
            color: #000000;
            font-weight: bold;
            font-size: 18px;
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #9c8be0;
        }

        th:not(:last-child), td:not(:last-child) {
            border-right: 1px solid #cbc2f7;
        }

        td {
            padding: 18px;
            height: 55px; 
            border-bottom: 1px solid #cbc2f7;
        }

        tr:last-child td {
            border-bottom: none;
        }

        /* --- Action Button --- */
        .button-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 5px;
        }

        .btn-report {
            background-color: #512da8;
            color: white;
            border: none;
            padding: 12px 28px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-report:hover {
            background-color: #3d1f85;
        }
    </style>
</head>
<body>

<div class="nav-header">
    <div class="logo-trigger-box" id="logoToggle">
        <img src="startIT logo.jpg" alt="startIT Menu Logo" class="nav-logo-img">
    </div>
    
    <div class="header-title">Admin</div>
    
    <div class="header-nav">
        <a href="PICDetails.html">View PIC details</a>
        <a href="registerPIC.php">Register PIC</a>
    </div>
</div>

<div class="sidebar-menu" id="panelSidebar">
    <a href="UpdateProfile.php" class="active-view">Update Profile</a>
    <a href="job_vacancy.php">Job Vacancy</a>
    <a href="applicationStatus.php">Application Status</a>
    <div class="sidebar-divider"></div>
    <a href="logout.php" style="color: #FF8A8A; font-size: 0.95rem;">Log Out</a>
</div>

<div class="container">
    <div class="card">
        
        <div class="search-container">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Search for applicant">
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="width: 40%;">Name</th>
                        <th style="width: 15%;">Email</th>
                        <th style="width: 20%;">Job Position</th>
                        <th style="width: 25%;">Company</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td></td><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td><td></td></tr>
                    <tr><td></td><td></td><td></td><td></td></tr>
                </tbody>
            </table>
        </div>

        <div class="button-container">
            <button class="btn-report">View Report</button>
        </div>

    </div>
</div>

<script>
    const logoToggle = document.getElementById("logoToggle");
    const panelSidebar = document.getElementById("panelSidebar");

    logoToggle.addEventListener("click", function(event) {
        event.stopPropagation(); // Elak trigger ditutup serta merta
        panelSidebar.classList.toggle("active");
    });

    document.addEventListener("click", function(event) {
        if (!panelSidebar.contains(event.target) && !logoToggle.contains(event.target)) {
            panelSidebar.classList.remove("active");
        }
    });
</script>

</body>
</html>
