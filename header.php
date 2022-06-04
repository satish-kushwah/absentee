<nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
    <div class='container-fluid text-center'>
        <a class='navbar-brand active ' href='./index.php'>Absentee</a>
        <!-- <img src='images/logo.png' alt='BrandName' width='30' height='30'> -->
        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse' id='navbarSupportedContent'>
            <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
                <li class='nav-item'>
                    <a class='nav-link active ' aria-current='page' href='fill_leaves.php?section=<?php echo $section ?>'>New Entry</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link active ' aria-current='page' href='all_statements.php?section=<?php echo $section ?>'>View All</a>
                </li>
                <?php
                if (isset($_SESSION[$section . 'loggedin'])) {
                    echo "<li class='nav-item'>
                    <a class='nav-link active ' aria-current='page' href='edit_employees.php?section=$section'>Edit Employees</a>
                </li>";
                }
                ?>
                <li class='nav-item'>
                    <a class='nav-link active ' aria-current='page' href='help.php?section=<?php echo $section ?>'>Help</a>
                </li>
            </ul>
            <?php
            if (!isset($_SESSION[$section . 'loggedin'])) {
                echo "<a href='login.php?section=$section' class='btn btn-primary ' >Login</a>";
            } else {
                echo "<div class='btn-group '>
                        <button id='userMenu' type='button' class='btn btn-success dropdown-toggle ' data-bs-toggle='dropdown' aria-expanded='false' value=''>
                        Menu
                        </button>
                        <ul class='dropdown-menu dropdown-menu-lg-end'>
                        <li><a class='dropdown-item ' href='all_screenshots.php?section=$section'>Screenshots</a></li>
                        <li><a class='dropdown-item ' href='edit_employees.php?section=$section'>Edit Employees</a></li>
                        <li><a class='dropdown-item ' href='delete_statements.php?section=$section'>Delete Statements</a></li>
                        <li><a class='dropdown-item ' href='change_password.php?section=$section'>Change Password</a></li>
                        <li><a class='dropdown-item ' href='logout.php?section=$section'>Logout</a></li>
                        </ul>
                        </div>";
            }
            ?>
        </div>
    </div>
</nav>
<div class="text-center text-success h4">
    Section: <?php
                echo strtoupper($section);
                ?>
</div>

<style>
    body {
        background-color: rgb(218, 225, 233);
    }

    @media only screen and (min-width: 960px) {
        .navbar .navbar-nav .nav-item .nav-link {
            padding: 0 0.5em;
        }

        .navbar .navbar-nav .nav-item:not(:last-child) .nav-link {
            border-right: 1px solid #f8efef;
        }
    }
</style>