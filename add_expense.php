<?php
include("session.php");
$update = false;
$del = false;
$expenseamount = "";
$expensename = "";
$expensedate = date("Y-m-d");
$expensecategory = "Anderes";
if (isset($_POST['add'])) {
    $expenseamount = $_POST['expenseamount'];
    $expensedate = $_POST['expensedate'];
    $expensename = $_POST['expensename'];
    $expensecategory = $_POST['expensecategory'];

    $expenses = "INSERT INTO expenses (user_id, expense,expensedate,expensecategory,name) VALUES ('$userid', '$expenseamount','$expensedate','$expensecategory','$expensename')";
    $result = mysqli_query($con, $expenses) or die("Something Went Wrong!");
    header('location: add_expense.php');
}

if (isset($_POST['update'])) {
    $id = $_GET['edit'];
    $expenseamount = $_POST['expenseamount'];
    $expensedate = $_POST['expensedate'];
    $expensename = $_POST['expensename'];
    $expensecategory = $_POST['expensecategory'];

    $sql = "UPDATE expenses SET expense='$expenseamount', expensedate='$expensedate', expensecategory='$expensecategory', name='$expensename' WHERE user_id='$userid' AND expense_id='$id'";
    if (mysqli_query($con, $sql)) {
        echo "Einträge wurden erfolgreich geupdatet.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
    header('location: manage_expense.php');
}

if (isset($_POST['update'])) {
    $id = $_GET['edit'];
    $expenseamount = $_POST['expenseamount'];
    $expensedate = $_POST['expensedate'];
    $expensename = $_POST['expensename'];
    $expensecategory = $_POST['expensecategory'];

    $sql = "UPDATE expenses SET expense='$expenseamount', expensedate='$expensedate', expensecategory='$expensecategory' WHERE user_id='$userid' AND expense_id='$id'";
    if (mysqli_query($con, $sql)) {
        echo "Einträge wurden erfolgreich geupdatet.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
    header('location: manage_expense.php');
}

if (isset($_POST['delete'])) {
    $id = $_GET['delete'];
    $expenseamount = $_POST['expenseamount'];
    $expensedate = $_POST['expensedate'];
    $expensename = $_POST['expensename'];
    $expensecategory = $_POST['expensecategory'];

    $sql = "DELETE FROM expenses WHERE user_id='$userid' AND expense_id='$id'";
    if (mysqli_query($con, $sql)) {
        echo "Einträge wurden erfolgreich geupdatet.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
    header('location: manage_expense.php');
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($con, "SELECT * FROM expenses WHERE user_id='$userid' AND expense_id=$id");
    if (mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        $expenseamount = $n['expense'];
        $expensedate = $n['expensedate'];
        $expensename = $n['expensename'];
        $expensecategory = $n['expensecategory'];
    } else {
        echo ("WARNING: AUTHORIZATION ERROR: Trying to Access Unauthorized data");
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $del = true;
    $record = mysqli_query($con, "SELECT * FROM expenses WHERE user_id='$userid' AND expense_id=$id");

    if (mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        $expenseamount = $n['expense'];
        $expensedate = $n['expensedate'];
        $expensecategory = $n['expensecategory'];
    } else {
        echo ("WARNING: AUTHORIZATION ERROR: Trying to Access Unauthorized data");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Budget Manager - Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Feather JS for Icons -->
    <script src="js/feather.min.js"></script>

</head>

<body>

    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="border-right" id="sidebar-wrapper">
            <div class="user">
                <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="120">
                <h5><?php echo $username ?></h5>
                <p><?php echo $useremail ?></p>
            </div>
            <div class="sidebar-heading">Management</div>
            <div class="list-group list-group-flush">
                <a href="index.php" class="list-group-item list-group-item-action"><span data-feather="home"></span> Dashboard</a>
                <a href="add_expense.php" class="list-group-item list-group-item-action sidebar-active"><span data-feather="plus-square"></span> Ausgabe hinzufügen</a>
                <a href="manage_expense.php" class="list-group-item list-group-item-action"><span data-feather="dollar-sign"></span> Ausgabe bearbeiten</a>
            </div>
            <div class="sidebar-heading">Einstellungen </div>
            <div class="list-group list-group-flush">
                <a href="profile.php" class="list-group-item list-group-item-action "><span data-feather="user"></span> Profil</a>
                <a href="logout.php" class="list-group-item list-group-item-action "><span data-feather="power"></span> Logout</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg navbar-light  border-bottom">


                <button class="toggler" type="button" id="menu-toggle" aria-expanded="false">
                    <span data-feather="menu"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="25">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="profile.phcol-mdp">Dein Profil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container">
                <h3 class="mt-4 text-center">Füge eine Ausgabe hinzu!</h3>
                <hr>
                <div class="row ">

                    <div class="col-md-3"></div>

                    <div class="col-md" style="margin:0 auto;">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label for="expenseamount" class="col-sm-6 col-form-label"><b>Betrag eingeben(€)</b></label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control col-sm-12" step="0.01" value="<?php echo $expenseamount; ?>" id="expenseamount" name="expenseamount" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="expensename" class="col-sm-6 col-form-label"><b>Name eingeben</b></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control col-sm-12" value="<?php echo $expensename; ?>" id="expensename" name="expensename" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="expensedate" class="col-sm-6 col-form-label"><b>Datum</b></label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control col-sm-12" value="<?php echo $expensedate; ?>" name="expensedate" id="expensedate" required>
                                </div>
                            </div>
                            <fieldset class="form-group">
                                <div class="row">
                                    <legend class="col-form-label col-sm-6 pt-0"><b>Kategorie</b></legend>
                                    <div class="col-md">

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="expensecategory" id="expensecategory4" value="Wohnzimmer" <?php echo ($expensecategory == 'Wohnzimmer') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="expensecategory4">
                                            Wohnzimmer
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="expensecategory" id="expensecategory3" value="Schlafzimmer" <?php echo ($expensecategory == 'Schlafzimmer') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="expensecategory3">
                                            Schlafzimmer
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="expensecategory" id="expensecategory2" value="Küche" <?php echo ($expensecategory == 'Küche') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="expensecategory2">
                                            Küche
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="expensecategory" id="expensecategory1" value="Flur" <?php echo ($expensecategory == 'Flur') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="expensecategory1">
                                            Flur
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="expensecategory" id="expensecategory7" value="Balkon" <?php echo ($expensecategory == 'Balkon') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="expensecategory7">
                                            Balkon
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="expensecategory" id="expensecategory6" value="Deko" <?php echo ($expensecategory == 'Deko') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="expensecategory6">
                                            Deko
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="expensecategory" id="expensecategory8" value="Gebrauchs Gegenstände" <?php echo ($expensecategory == 'Gebrauchs Gegenstände') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="expensecategory8">
                                            Gebrauchs Gegenstände
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="expensecategory" id="expensecategory5" value="Anderes" <?php echo ($expensecategory == 'Anderes') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="expensecategory5">
                                            Anderes
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group row">
                                <div class="col-md-12 text-right">
                                    <?php if ($update == true) : ?>
                                        <button class="btn btn-lg btn-block btn-warning" style="border-radius: 0%;" type="submit" name="update">Update</button>
                                    <?php elseif ($del == true) : ?>
                                        <button class="btn btn-lg btn-block btn-danger" style="border-radius: 0%;" type="submit" name="delete">Löschen</button>
                                    <?php else : ?>
                                        <button type="submit" name="add" class="btn btn-lg btn-block btn-success" style="border-radius: 0%;">Ausgabe hinzufügen</button>
                                    <?php endif ?>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-3"></div>
                    
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="js/jquery.slim.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <!-- Menu Toggle Script -->
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
    <script>
        feather.replace();
    </script>
    <script>

    </script>
</body>
</html>