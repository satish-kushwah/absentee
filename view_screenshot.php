<?php
$section = $_GET['section'];
session_start();
// if (!isset($_SESSION[$section . 'loggedin'])) {
// header('Location: index.php');
// }
?>
<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
    <title>View Screenshots</title>
</head>

<body>
    <?php
    include 'header.php';
    if (isset($_GET['view_emp'])) {
        $emp_num = $_GET['view_emp'];
        $absentee = file_get_contents("$section/absentee.json");
        $absentee = json_decode($absentee, true);
        $emp_data = $absentee[$emp_num];
        $emp_name = $emp_data[0];
        $leave_data   = $emp_data[1];
        $file_path   = $emp_data[2];
    }
    ?>
    <div class='container mt-3 mb-5'>
        <a href="all_statements.php?section=<?php echo $section ?>" class="btn btn-primary me-5">
            <- Back</a>
                <?php
                echo "<p class='mt-3' style='white-space: pre-wrap'><b>Employee Name:</b> $emp_name     <b> Employee Number:</b> $emp_num</p>";
                ?>
                <b>ESS Screenshot</b>
                <?php
                echo "<a href='$section/uploads/$file_path' target='_blank'>(Open file)</a>";
                echo "<img src='$section/uploads/$file_path' style='width: 1080px'  alt='ESS Screenshot'>";
                ?>

                <div class="my-3">
                    <table id="table_id" class="table-bordered w-100 mb-3">
                        <thead>
                            <tr>
                                <th>Leave From</th>
                                <th>Leave Upto</th>
                                <th>Leave Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_slots = count($leave_data);
                            for ($j = 0; $j < $total_slots; $j++) {
                                $row = $leave_data[$j];
                                $from = $row[0];
                                $to = $row[1];
                                $leave_type = $row[2];
                                echo "<tr>
                                        <td>$from</td>
                                        <td>$to</td>
                                        <td>$leave_type</td>
                                      </tr>";
                            }
                            if ($total_slots == 0)
                                echo "<tr>
                                    <td>NIL</td>
                                    <td>NIL</td>
                                    <td>NIL</td>
                                </tr>";
                            ?>
                        </tbody>
                    </table>
                    <?php
                    if (isset($_SESSION[$section . 'loggedin']))
                        echo "<a href='all_statements.php?section=$section&verify_data=$emp_num' class='me-3 btn btn-success ' onclick=\"return confirm('Sure to verify data of \'$emp_name\'?')\">Verify</a>
                          <a href='all_statements.php?section=$section&delete=$emp_num' class='btn btn-danger ' onclick=\"return confirm('Sure to delete leave statement of \'$emp_name\'?')\">Delete</a>";
                    ?>
                </div>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
</body>

</html>