<?php
session_start();
// if (!isset($_SESSION[$section . 'loggedin'])) {
//     header('Location: index.php');
// }
$section = $_GET['section'];
?>
<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
    <title>All Leave Statements</title>
</head>

<body>
    <?php
    include 'header.php';

    function validateInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    //checking duplicate entry
    $duplicate_entry = 0;
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['emp_name'])) {
        $absentee = file_get_contents("$section/absentee.json");
        $absentee = json_decode($absentee, true);
        $emp_num = validateInput(explode("-", $_POST['emp_name'])[0]);
        if (array_key_exists($emp_num, $absentee)) {
            $duplicate_entry = 1;
            echo "<div class='alert alert-danger alert-dismissible fade show py-2 mb-0' role='alert'>
                <strong >Error! Your leave statement already submitted, duplicate entry not allowed</strong>
                <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
    }
    //new entry
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['emp_name']) && $duplicate_entry == 0) {
        $emp_name = validateInput(explode("-", $_POST['emp_name'])[1]);
        $emp_num = validateInput(explode("-", $_POST['emp_name'])[0]);
        $temp = explode(".", $_FILES["fileToUpload"]["name"]);
        $newfilename = $emp_num . '.' . end($temp);
        $target_file = "$section/uploads/" . $newfilename;
        // $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        //check file type
        // if ($file_type == 'htm' or $file_type == 'html' or $file_type == 'php' or $file_type == 'asp' or $file_type == 'aspx' or $file_type == 'jsp' or $file_type == 'htaccess') {
        //     $showAlert = true;
        //     $alertMsg =  "Sorry, this file type not allowed, upload it by making zip file.";
        //     $alertClass = "alert-danger";
        // }
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "<div class='alert alert-danger alert-dismissible fade show py-2 mb-0' role='alert'>
                <strong >Error! $target_file already exists </strong>
                <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $filename = htmlspecialchars(basename($_FILES["fileToUpload"]["name"]));
                echo "<div class='alert alert-success alert-dismissible fade show py-2 mb-0' role='alert'>
                <strong >File $filename has been uploaded</strong>
                <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";

                $absentee = file_get_contents("$section/absentee.json");
                $absentee = json_decode($absentee, true);
                if ($absentee == NULL)
                    $absentee = array();
                $employee_record = array();
                array_push($employee_record, $emp_name);
                $leave_data = array();
                $total_rows = $_POST['total_rows'];
                for ($i = 0; $i < $total_rows; $i++) {
                    $leave_type = "leave_type_" . $i;
                    $from = "from_" . $i;
                    $to = "to_" . $i;
                    if ($_POST[$leave_type] != '' and $_POST[$from] != '' and $_POST[$to] != '') {
                        $row = array();
                        $fromdate = date("d.m.Y", strtotime($_POST[$from]));
                        $todate = date("d.m.Y", strtotime($_POST[$to]));
                        array_push($row, $fromdate, $todate, strtoupper($_POST[$leave_type]));
                        array_push($leave_data, $row);
                    }
                }
                // $file_path =  rawurlencode($newfilename);
                array_push($employee_record, $leave_data, $newfilename, 0); //0 for not verified
                $absentee[$emp_num] = $employee_record;
                file_put_contents("$section/absentee.json", json_encode($absentee));
                echo "<div class='alert alert-success alert-dismissible fade show py-2 mb-0' role='alert'>
                <strong >Leave statement saved of $emp_name </strong>
                <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
            } else {
                echo "<div class='alert alert-danger alert-dismissible fade show py-2 mb-0' role='alert'>
                <strong >Error! your record not saved.</strong>
                <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
            }
        }
    }
    //data verification
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['verify_data'])) {
        $emp_num = $_GET['verify_data'];
        $absentee = file_get_contents("$section/absentee.json");
        $absentee = json_decode($absentee, true);
        $emp_data = $absentee[$emp_num];
        $emp_data[3] = 1;
        $absentee[$emp_num] = $emp_data;
        $emp_name = $emp_data[0];
        file_put_contents("$section/absentee.json", json_encode($absentee));
        echo "<div class='alert alert-success alert-dismissible fade show py-2 mb-0' role='alert'>
                <strong >Data verified of $emp_name.</strong>
                <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
    //delete
    if (isset($_SESSION[$section . 'loggedin']) and isset($_GET['delete'])) {
        $emp_num = $_GET['delete'];
        $absentee = file_get_contents("$section/absentee.json");
        $absentee = json_decode($absentee, true);
        $emp_data = $absentee[$emp_num];
        $file = $emp_data[2];
        $emp_name = $emp_data[0];
        if (file_exists("$section/uploads/" . $file)) {
            unlink("$section/uploads/" . $file);
            echo "<div class='alert alert-success alert-dismissible fade show py-2 mb-0' role='alert'>
                <strong >$file deleted </strong>
                <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        unset($absentee[$emp_num]);
        file_put_contents("$section/absentee.json", json_encode($absentee));
        echo "<div class='alert alert-success alert-dismissible fade show py-2 mb-0' role='alert'>
                <strong >Leave statement of $emp_name deleted </strong>
                <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
    //edit employees
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_employees'])) {
        $edit_employees   =  $_POST['edit_employees'];
        // $edit_employees = str_replace('\t', ' ', $edit_employees);
        $edit_employees = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', ' ', $edit_employees);
        file_put_contents("$section/employees.json", $edit_employees);
        echo "<div class='alert alert-success alert-dismissible fade show py-2 mb-0' role='alert'>
                <strong >Employees names updated </strong>
                <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
    //delete all ststements
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_all'])) {
        file_put_contents("$section/absentee.json", "[]");
        if ($handle = opendir("$section/uploads/")) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    unlink("$section/uploads/$file");
                }
            }
        }
        echo "<div class='alert alert-success alert-dismissible fade show py-2 mb-0' role='alert'>
                <strong >All leave statements deleted, also verify from Screenshots page </strong>
                <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }

    ?>
    <div class="container my-3">
        <h4 class='fw-bold'>Leave statements of all employees</h4>
        <div class="my-3 table-responsive">
            <table id="table_id" class="table-bordered w-100 text-center">
                <tr>
                    <td colspan='8' class='text-center fw-bold'>
                        <h5></h5><?php echo $section ?> Section Khyberpass Depot</h5>
                    </td>
                </tr>
                <tr>
                    <td colspan='8' class='text-center fw-bold'>
                        <h5></h5>Leave statements from --- to ---</h5>
                    </td>
                </tr>
                <tr>
                    <td colspan='8'> .</td>
                </tr>
                <!--<thead>-->
                <tr>
                    <th>SN</th>
                    <th style='min-width:150px'>Employee Name</th>
                    <th>Employee Number</th>
                    <th style='min-width:100px'>Leave From</th>
                    <th style='min-width:100px'>Leave Upto</th>
                    <th>Leave Type</th>
                    <th>Leave Approved</th>
                    <th>ESS Screenshot</th>
                </tr>
                <!--</thead>-->
                <tbody>
                    <?php
                    $absentee = file_get_contents("$section/absentee.json");
                    $absentee = json_decode($absentee, true);
                    $sn = 1;
                    //counting from employees.json
                    $employees = file_get_contents("$section/employees.json");
                    $employees = json_decode($employees, true);
                    $total_emp = count($employees);
                    $not_submitted = array();
                    for ($i = 0; $i < $total_emp; $i++) {
                        $emp_num = trim(explode("-", $employees[$i])[0]);
                        if (array_key_exists($emp_num, $absentee)) {
                            $emp_data = $absentee[$emp_num];
                            $emp_name = $emp_data[0];
                            $leave_data   = $emp_data[1];
                            // $file_path   = $emp_data[2];
                            $verification   = $emp_data[3];
                            $verified = '';
                            if ($verification == 1)
                                $verified = 'text-success';
                            $sub_dir  = $_SERVER['PHP_SELF'];
                            $sub_dir = str_replace("all_statements.php", "", $sub_dir);
                            $current_site = 'http://' . $_SERVER['SERVER_NAME'] . $sub_dir;
                            $file_path = $current_site . "view_screenshot.php?section=$section&view_emp=$emp_num";
                            $total_slots = count($leave_data);
                            for ($j = 0; $j < $total_slots; $j++) {
                                $row = $leave_data[$j];
                                $from = $row[0];
                                $to = $row[1];
                                $leave_type = $row[2];
                                echo "<tr class='$verified'>";
                                if ($j == 0)
                                    echo "<td rowspan='$total_slots'>$sn </td>
                                        <td rowspan='$total_slots'>$emp_name </td>
                                        <td rowspan='$total_slots'>$emp_num</td>";
                                echo "<td>$from</td>
                                        <td>$to</td>
                                        <td>$leave_type</td>";
                                if ($j == 0)
                                    echo "<td rowspan='$total_slots'>Yes</td>
                                      <td rowspan='$total_slots'><a href='$file_path'>View</a></td>";
                                echo "</tr>";
                            }
                            if ($total_slots == 0) {
                                echo "<tr class='$verified'>
                                      <td>$sn</td>
                                      <td>$emp_name</td>
                                      <td>$emp_num</td>
                                      <td>NIL</td>
                                      <td>NIL</td>
                                      <td>NIL</td>
                                      <td>NIL</td>
                                      <td><a href='$file_path'>View</a></td>";
                                echo "</tr>";
                            }
                            $sn = $sn + 1;
                        } else {
                            array_push($not_submitted, $employees[$i]);
                        }
                    }
                    ?>
                </tbody>
            </table>
            <a href="export_statements.php?section=<?php echo $section ?>" class="mt-3 btn btn-primary">Export Table in Excel</a><br>
            <a href="zip_screenshots.php?section=<?php echo $section ?>" class="my-3 btn btn-primary">Download All Screenshots</a>
        </div>
        <!-- leave statement not submitted  -->
        <div class="my-3">
            <h4 class="text-danger">Leave statement not submitted by below employees</h4>
            <?php
            for ($i = 1; $i <= count($not_submitted); $i++) {
                $emp = $not_submitted[$i - 1];
                echo "$i. $emp <br>";
            }
            ?>
        </div>

    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
</body>

</html>