<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: LogIn.php");
    exit();
}

// 2. Database Connection
$host = "localhost";
$user = "root";
$pass = "";
$db   = "startit"; // Menghubungkan semula ke pangkalan data projek anda

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// 3. Ambil penapis bulan & tahun (Default: bulan & tahun semasa)
$selected_month = isset($_GET['month']) ? intval($_GET['month']) : intval(date('m'));
$selected_year  = isset($_GET['year']) ? intval($_GET['year']) : intval(date('Y'));

$months_list = [
    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
];

// 4. Query untuk kira jumlah pemohon mengikut syarikat pada bulan dipilih
$query = "
    SELECT c.company_name, COUNT(aj.applicant_id) as total_applicants
    FROM apply_job aj
    JOIN company c ON aj.company_id = c.company_id
    WHERE MONTH(aj.apply_date) = ? AND YEAR(aj.apply_date) = ?
    GROUP BY c.company_id, c.company_name
    ORDER BY total_applicants DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $selected_month, $selected_year);
$stmt->execute();
$result = $stmt->get_result();

$chart_data = [];
$max_applicants = 0;

while ($row = $result->fetch_assoc()) {
    $chart_data[] = [
        'company' => $row['company_name'],
        'total' => intval($row['total_applicants'])
    ];
    if (intval($row['total_applicants']) > $max_applicants) {
        $max_applicants = intval($row['total_applicants']);
    }
}

// Supaya grid graf tak pecah kalau data kosong
if ($max_applicants == 0) { $max_applicants = 10; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusConnect - Demand Report</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', sans-serif; margin: 0; padding: 0; }
        body { background-color: #f4f6f9; color: #333; padding: 30px; }
        .report-container { max-width: 1000px; margin: 0 auto; background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 40px; }
        .header-section { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #edf2f7; padding-bottom: 20px; margin-bottom: 30px; }
        .title-area h1 { font-size: 24px; color: #1a365d; }
        .title-area p { font-size: 14px; color: #718096; margin-top: 4px; }
        
        /* Filter Form */
        .filter-form { background: #f7fafc; padding: 15px 20px; border-radius: 8px; border: 1px solid #e2e8f0; display: inline-flex; gap: 15px; align-items: center; margin-bottom: 30px; }
        .filter-form label { font-size: 14px; font-weight: 600; color: #4a5568; }
        .filter-form select { padding: 8px 12px; border-radius: 6px; border: 1px solid #cbd5e0; background: #fff; font-size: 14px; }
        .btn-filter { background: #3182ce; color: #fff; border: none; padding: 8px 16px; border-radius: 6px; font-weight: 600; cursor: pointer; }
        .btn-filter:hover { background: #2b6cb0; }
        .btn-print { background: #2f855a; color: white; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer; font-weight: 600; }
        .btn-print:hover { background: #22543d; }

        /* Chart & Table CSS */
        .chart-box { background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 25px; margin-bottom: 35px; text-align: center; }
        .chart-title { font-size: 16px; font-weight: bold; color: #2d3748; margin-bottom: 20px; text-align: left; }
        .table-section h2 { font-size: 18px; color: #2d3748; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { text-align: left; padding: 12px 15px; border-bottom: 1px solid #e2e8f0; }
        th { background-color: #ebf8ff; color: #2b6cb0; font-weight: 600; }
        tr:hover { background-color: #f7fafc; }
        .badge-count { background: #e2e8f0; color: #4a5568; padding: 4px 10px; border-radius: 12px; font-weight: bold; font-size: 13px; }
        .no-data { padding: 40px; text-align: center; color: #a0aec0; font-style: italic; }

        /* Sembunyikan bahagian butang masa print kertas real */
        @media print {
            body { background: #fff; padding: 0; }
            .report-container { box-shadow: none; padding: 0; }
            .filter-form, .btn-print { display: none !important; }
        }
    </style>
</head>
<body>

<div class="report-container">
    <div class="header-section">
        <div class="title-area">
            <h1>Monthly Application Demand Report</h1>
            <p>UiTM Cawangan Pahang Kampus Raub • CampusConnect System</p>
        </div>
        <button class="btn-print" onclick="window.print()">🖨️ Print Report</button>
    </div>

    <!-- Filter Form (Boleh tukar bulan-bulan secara dinamik) -->
    <form class="filter-form" method="GET" action="">
        <label for="month">Month:</label>
        <select name="month" id="month">
            <?php foreach ($months_list as $num => $name): ?>
                <option value="<?php echo $num; ?>" <?php echo ($num == $selected_month) ? 'selected' : ''; ?>><?php echo $name; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="year">Year:</label>
        <select name="year" id="year">
            <?php 
            $current_yr = intval(date('Y'));
            for ($y = $current_yr; $y >= $current_yr - 3; $y--): 
            ?>
                <option value="<?php echo $y; ?>" <?php echo ($y == $selected_year) ? 'selected' : ''; ?>><?php echo $y; ?></option>
            <?php endfor; ?>
        </select>
        <button type="submit" class="btn-filter">Filter</button>
    </form>

    <!-- Graf Bar Menggunakan SVG (X-axis: Company, Y-axis: Total) -->
    <div class="chart-box">
        <div class="chart-title">Company Demand Chart (<?php echo $months_list[$selected_month] . " " . $selected_year; ?>)</div>
        
        <?php if (empty($chart_data)): ?>
            <div class="no-data">No applications recorded for this month.</div>
        <?php else: 
            $svg_width = 800; $svg_height = 400;
            $p_left = 60; $p_right = 40; $p_top = 30; $p_bottom = 60;
            $plot_w = $svg_width - $p_left - $p_right;
            $plot_h = $svg_height - $p_top - $p_bottom;
            
            $item_count = count($chart_data);
            $group_w = $plot_w / $item_count;
            $bar_w = $group_w * 0.6;
        ?>
            <svg width="100%" height="100%" viewBox="0 0 <?php echo $svg_width; ?> <?php echo $svg_height; ?>" style="max-height: 380px;">
                <!-- Garisan Grid Belakang -->
                <?php for($i = 0; $i <= 5; $i++): 
                    $y_line = $p_top + $plot_h - ($plot_h / 5) * $i;
                    $label_y = round(($max_applicants / 5) * $i);
                ?>
                    <line x1="<?php echo $p_left; ?>" y1="<?php echo $y_line; ?>" x2="<?php echo $svg_width - $p_right; ?>" y2="<?php echo $y_line; ?>" stroke="#e2e8f0" stroke-dasharray="5,5" />
                    <text x="<?php echo $p_left - 15; ?>" y="<?php echo $y_line + 4; ?>" font-size="12" fill="#718096" text-anchor="end"><?php echo $label_y; ?></text>
                <?php endfor; ?>

                <!-- Paksi X & Y -->
                <line x1="<?php echo $p_left; ?>" y1="<?php echo $p_top + $plot_h; ?>" x2="<?php echo $svg_width - $p_right; ?>" y2="<?php echo $p_top + $plot_h; ?>" stroke="#718096" stroke-width="2" />
                <line x1="<?php echo $p_left; ?>" y1="<?php echo $p_top; ?>" x2="<?php echo $p_left; ?>" y2="<?php echo $p_top + $plot_h; ?>" stroke="#718096" stroke-width="2" />

                <!-- Lukis Graf Bar mengikut Data DB -->
                <?php foreach ($chart_data as $index => $data): 
                    $x_pos = $p_left + ($index * $group_w) + ($group_w - $bar_w) / 2;
                    $bar_h = ($data['total'] / $max_applicants) * $plot_h;
                    $y_pos = $p_top + $plot_h - $bar_h;
                ?>
                    <!-- Tiang Bar -->
                    <rect x="<?php echo $x_pos; ?>" y="<?php echo $y_pos; ?>" width="<?php echo $bar_w; ?>" height="<?php echo $bar_h; ?>" fill="#3182ce" rx="4" />
                    <!-- Angka Jumlah Pemohon (Y-Axis Value) -->
                    <text x="<?php echo $x_pos + $bar_w/2; ?>" y="<?php echo $y_pos - 8; ?>" font-size="12" font-weight="bold" fill="#2b6cb0" text-anchor="middle"><?php echo $data['total']; ?></text>
                    <!-- Nama Syarikat (X-Axis Label) -->
                    <text x="<?php echo $x_pos + $bar_w/2; ?>" y="<?php echo $p_top + $plot_h + 25; ?>" font-size="11" font-weight="600" fill="#4a5568" text-anchor="middle">
                        <?php echo (strlen($data['company']) > 12) ? substr($data['company'], 0, 10).'..' : $data['company']; ?>
                    </text>
                <?php endforeach; ?>
            </svg>
        <?php endif; ?>
    </div>

    <!-- Jadual Ringkasan Berangka -->
    <div class="table-section">
        <h2>Detailed Summary Table</h2>
        <table>
            <thead>
                <tr>
                    <th style="width: 15%;">Rank</th>
                    <th>Company Name</th>
                    <th style="text-align: center; width: 30%;">Total Applicants</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($chart_data)): ?>
                    <tr><td colspan="3" style="text-align: center; color: #a0aec0;">No records found.</td></tr>
                <?php else: $rank = 1; foreach ($chart_data as $data): ?>
                    <tr>
                        <td><strong>#<?php echo $rank++; ?></strong></td>
                        <td><?php echo htmlspecialchars($data['company']); ?></td>
                        <td style="text-align: center;"><span class="badge-count"><?php echo $data['total']; ?> applicants</span></td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
<?php $conn->close(); ?>
