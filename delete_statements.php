<?php
$section = $_GET['section'];
session_start();
if (!isset($_SESSION[$section . 'loggedin'])) {
    header("Location: fille_leaves.php?section=$section");
}
?>
<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
    <title>Delete Statements</title>
</head>

<body>
    <?php
    include 'header.php';
    ?>
    <div class="container my-3">
        <p class="text-danger fs-5">On clicking Delete All Statements, leave statements of all employees including ESS screenshots will be deleted. Be sure before deleting all leave statements. </p>
        <form method='POST' action='all_statements.php?section=<?php echo $section ?>'>
            <div class='mb-3'>
                <!-- <label for='' class='form-label float-start'></label> -->
                <input type='text' hidden class='form-control' id='delete_all' name='delete_all'>
            </div>
            <button type='submit' class='btn btn-danger' onclick="return confirm('Sure to delete all statements?')">Delete All Statements</button>
        </form>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
</body>

</html>