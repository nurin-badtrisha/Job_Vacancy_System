<?php
$servername = "localhost";
$username   = "root"; 
$password   = ""; 
$dbname     = "startit";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE applications SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    
    if ($stmt->execute()) {
        echo "Status updated succesfully!";
    } else {
        echo "Failed to update ";
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StartIT</title>
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
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
			
			position: absolute;
			left: 50%;
			transform: translateX(-50%);
			text-align: center;
			
			z-index: 10;
        }

        .header-spacer {
            flex: 1;
        }
        
        /* Floating Sidebar Menu Styling */
        .sidebar-menu {
            position: absolute;
            top: 70px;
            left: -260px;
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
            margin: auto;
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
            font-size: 15px;
            color: #333;
            outline: none;
            transition: background-color 0.2s;
        }

        tr:last-child td {
            border-bottom: none;
        }

       


        /* --- Action Button --- */
        .button-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 5px;
            gap: 15px;
        }

        .btn-back {
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

        .btn-back:hover {
            background-color: #3d1f85;
        }
		
		.status-select {
			width: 100%;
			padding: 8px 12px;
			font-size: 14px;
			font-weight: 600;
			border-radius: 6px;
			border: 1px solid #9c8be0;
			cursor: pointer;
			transition: all 0.2s ease;
		}

		.status-select.approved {
			background-color: #d4edda;
			color: #155724;
			border-color: #c3e6cb;
		}

		.status-select.rejected {
			background-color: #f8d7da;
			color: #721c24;
			border-color: #f5c6cb;
		}
    </style>
</head>
<body>

<div class="nav-header">
    
    <img src="startIT logo.jpg" alt="startIT Menu Logo" class="nav-logo-img">
    
    <div class="header-title">Applicant Status</div>
    <div class="header-spacer"></div>
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
					    <th style="width: 20%;">Applicant name</th>
                        <th style="width: 18%;">Job Position</th>
                        <th style="width: 17%;">Email</th>
                        <th style="width: 20%;">Phone Number</th>
                        <th style="width: 10%;">Resume</th>
						<th style="width: 17%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="editable-cell"></td>
                        <td class="editable-cell"></td>
                        <td class="editable-cell"></td>
                        <td class="editable-cell"></td>
						<td class="editable-cell"></td>
                        <td>
							<select class="status-select" onchange="updateStatusStyle(this)">
								<option value="approved">Approved</option>
								<option value="rejected">Rejected</option>
							</select>
						</td>
                        </td>
                    </tr>
                    <tr>
					    <td class="editable-cell"></td>
                        <td class="editable-cell"></td>
                        <td class="editable-cell"></td>
                        <td class="editable-cell"></td>
						<td class="editable-cell"></td>
						<td>
							<select class="status-select" onchange="updateStatusStyle(this)">
								<option value="approved">Approved</option>
								<option value="rejected">Rejected</option>
							</select>
						</td>
                        </td>
                    </tr>
                   
                </tbody>
            </table>
        </div>

        <div class="button-container">
            <button class="btn-back" onclick="window.location.href='pic.php'">Back</button>
        </div>

    </div>
</div>

<script>
    
    function handleRowEdit(buttonElement) {
       
        const row = buttonElement.closest('tr');
      
        const cells = row.querySelectorAll('.editable-cell');
      
        const isEditing = row.classList.contains('editing-row');

        if (!isEditing) {
       
            row.classList.add('editing-row');
            cells.forEach(cell => {
                cell.setAttribute('contenteditable', 'true');
            });
     
            cells[0].focus();

            buttonElement.innerHTML = '<i class="fa-solid fa-circle-check"></i> Save';
            buttonElement.classList.add('saving');
        } else {
       
            row.classList.remove('editing-row');
            cells.forEach(cell => {
                cell.setAttribute('contenteditable', 'false');
            });

            buttonElement.innerHTML = '<i class="fa-solid fa-pen-to-square"></i> Edit';
            buttonElement.classList.remove('saving');

            alert("Perubahan pada baris kotak ini telah berjaya disimpan!");
        }
		
		function updateStatusStyle(selectElement) {
			selectElement.classList.remove('pending', 'approved', 'rejected');
			
			if (selectElement.value === 'pending') {
				selectElement.classList.add('pending');
			} else if (selectElement.value === 'approved') {
				selectElement.classList.add('approved');
			} else if (selectElement.value === 'rejected') {
				selectElement.classList.add('rejected');
			}
		}
		
		function updateStatusStyle(selectElement) {
        selectElement.classList.remove('approved', 'rejected');
        if (selectElement.value === 'approved') {
            selectElement.classList.add('approved');
        } else if (selectElement.value === 'rejected') {
            selectElement.classList.add('rejected');
        }

        const applicantId = selectElement.getAttribute('data-id');
        const newStatus = selectElement.value;

        fetch('update_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${applicantId}&status=${newStatus}`
        })
        .then(response => response.text())
        .then(data => {
            console.log("Respon Database:", data);
        })
        .catch(error => console.error('Ralat:', error));
       }
    });
</script>

</body>
</html>
