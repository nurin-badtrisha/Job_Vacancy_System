<?php session_start(); 
if (!isset($_SESSION['username'])) {
    header("Location: LogIn.php");
    exit();
}
?>
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #b3a2f2; /* Light purple outer background */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* --- Header Section --- */
        header {
            background-color: #512da8; /* Dark purple header */
            color: white;
            width: 100%;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Placeholder logo mimicking the clock icon */
        .logo-icon {
            width: 30px;
            height: 30px;
            border: 3px dashed white;
            border-radius: 50%;
        }

        header h1 {
            font-size: 24px;
            font-weight: 500;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .header-nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .header-nav a:hover {
            text-decoration: underline;
        }

        /* --- Main Content Card --- */
        .container {
            width: 90%;
            max-width: 1000px;
            margin-top: 40px;
            margin-bottom: 40px;
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
            background-color: #fffdf6; /* Light cream tint matching the image */
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
            background-color: #f1effd; /* Very light purple table rows */
        }

        th {
            background-color: #b3a2f2; /* Light purple header */
            color: #000000;
            font-weight: bold;
            font-size: 18px;
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #9c8be0;
        }

        /* Ensuring border separation inside the table layout */
        th:not(:last-child), td:not(:last-child) {
            border-right: 1px solid #cbc2f7;
        }

        td {
            padding: 18px;
            height: 55px; /* Keeps rows spacious even when empty */
            border-bottom: 1px solid #cbc2f7;
        }

        tr:last-child td {
            border-bottom: none;
        }

        /* --- Action Button --- */
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px; 
        background-color: #3b145a;
        color: white !important;
        padding: 10px 20px; 
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }

    /* Kesan bila user letak cursor atas butang (Hover) */
    .btn-primary:hover {
        background-color: #3b145a;
        transform: translateY(-1px); /* Butang naik atas sikit */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15); /* Bayang jadi tebal sikit */
    }

    /* Kesan bila user tekan/klik butang (Active) */
    .btn-primary:active {
        transform: translateY(1px); /* Butang nampak macam ditekan ke dalam */
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }
		
    </style>
</head>
<body>

    <header>
        <div class="header-left">
            <div class="logo-icon"></div>
        </div>
        <h1>Admin</h1>
        <nav class="header-nav">
            <a href="PICdetails.html" class="active-view">View PIC details</a>
            <a href="registerPIC.php" class="active-view">Register PIC</a>
        </nav>
    </header>

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

            <div class="button-container" style="text-align: right; width: 100%;">
				<a href="generateReport.php" class="btn-primary">View Report</a>
            </div>

        </div>
    </div>

</body>
</html>
