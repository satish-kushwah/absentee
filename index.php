<?php
// session_start();
// if (!isset($_SESSION[$section . 'loggedin'])) {
//     header('Location: index.php');
// }
// $showAlert = false;
?>
<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
    <title>Absentee</title>
</head>

<body>
    <div class="container my-3  text-center ">
        <h4>Go to Absentee data of following sections</h4><br>
        <center>
            <div class="container col-xs-8 col-md-3">
                <?php
                foreach (glob('./*', GLOB_ONLYDIR) as $dir) {
                    $dirname = basename($dir);
                    $displayDir = strtoupper(($dirname));
                    echo "<a href='fill_leaves.php?section=$dirname' class='mb-3 btn btn-outline-primary w-100'>$displayDir</a><br>";
                }
                // $path    = './';
                // $files = scandir($path);
                // $files = array_diff(scandir($path), array('.', '..', 'index.php'));
                // foreach ($files as $file) {
                //     $fileUpper = strtoupper($file);
                //     echo "<a href='$file' class='mb-3 btn btn-primary'>$fileUpper</a><br>";
                // }
                ?>
            </div>
        </center>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
</body>

</html>