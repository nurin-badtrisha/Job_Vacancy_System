<?phpsession_start(); 
if (!isset($_SESSION['username'])) {
    header("Location: LogIn.php");
    exit();
}
include("dbconn.php");

$job_id = $_POST['job_id'];

$resumeName = $_FILES['resume']['name'];
$tmpName = $_FILES['resume']['tmp_name'];

$folder = "resume/" . $resumeName;

move_uploaded_file($tmpName, $folder);

/* INSERT APPLICATION */
$sql = "INSERT INTO application
(job_id, resume)

VALUES
('$job_id', '$folder')";

mysqli_query($dbconn, $sql);

echo "
<script>

alert('Your Applicant are successful! You can track your application progress in application status.');

window.location.href='menu.php';

</script>
";
?>
