<?php
$section = $_GET['section'];
session_start();
?>
<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
    <title>Help</title>
</head>

<body>
    <?php
    include 'header.php';
    ?>
    <div class="container my-3">
        <h4>Export Leave Statements table into excel</h4>
        <p>Export table into excel by clicking on "Export Table" button. To get the table in same format as shown You can use this website, <a href="https://products.aspose.app/cells/conversion/html-to-xlsx" target="_blank">https://products.aspose.app/cells/conversion/html-to-xlsx</a>. Copy the url/link of page containing leave statements of all employees and paste in the given website then convert to excel and download.</p>

        <h4>Forgot password</h4>
        <p>Default password is 0000, you can change it after login also you can see it in password.php file after logging in into your hosting account.</p>

        <h4>Features available after login</h4>
        <p>1. Verify and hightlight the absentee data submitted by employee after verification</p>
        <p>2. Delete the leave statement of individual employee.</p>
        <p>3. Download, delete and upload ESS screenshots.</p>
        <p>4. Add, delete and edit employees names.</p>
        <p>5. Delete leave statements of all employees and their ESS screenshots with a single click for taking new entries. </p>
        <p>6. Change login password.</p>

        <h4>Download the source code of this web app</h4>
        <a href="https://github.com/satish-kushwah/absentee/archive/refs/heads/main.zip" target="_blank">https://github.com/satish-kushwah/absentee/archive/refs/heads/main.zip</a>

        <p></p>
        <h4>Support</h4>
        <p>For any query reach satishkushwahdigital@gmail.com in Millwright section</p>
        <i class="text-danger fs-5">Developer: satishkushwahdigital@gmail.com</i>

    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
</body>

</html>