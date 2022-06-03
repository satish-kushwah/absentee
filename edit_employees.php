<?php
$section = $_GET['section'];
session_start();
if (!isset($_SESSION[$section . 'loggedin'])) {
    header('Location: index.php');
}
?>
<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
    <title>Edit employees</title>
</head>

<body>
    <?php
    include 'header.php';
    ?>
    <div class="container my-3">
        <form method='POST' action='all_statements.php?section=<?php echo $section ?>'>
            <div class='mb-3'>
                <label for='employees' class='form-label float-start text-danger me-2'>Edit Employees Names (employees data to be written in proper json format with - between employee number and employee name) </label>
                <a href="sample.json" target='_blank'>View sample json file</a>
                <?php
                $employees = file_get_contents("$section/employees.json");
                echo "<textarea class='form-control ' name='edit_employees' id='edit_employees' cols='30' rows='30'>$employees</textarea>";
                ?>
            </div>
            <button type='submit' class='btn btn-primary' onclick="return confirm('Make sure employees data is in proper json format')">Submit</button>
        </form>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
</body>

</html>