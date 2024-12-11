<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['detsuid'] == 0)) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Daily Expense Tracker || Detailed Monthly Expense Report</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<!-- Custom Font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
</head>
<body>
	<?php include_once('includes/header.php'); ?>
	<?php include_once('includes/sidebar.php'); ?>

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><em class="fa fa-home"></em></a></li>
				<li class="active">Detailed Monthly Expense Report</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Detailed Monthly Expense Report</div>
					<div class="panel-body">
						<div class="col-md-12">

<?php
$month = $_POST['month'];
$year = date('Y', strtotime($month));
$monthNum = date('m', strtotime($month));
?>
<h5 align="center" style="color:blue">Detailed Monthly Expense Report for <?php echo date("F Y", strtotime($month)); ?></h5>
<hr />

<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th>S.NO</th>
            <th>Date</th>
            <th>Description</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $userid = $_SESSION['detsuid'];
        $cnt = 1;
        $monthlyTotal = 0;

        // Fetch individual expenses for the selected month and year
        $expenseQuery = mysqli_query($con, "SELECT ExpenseDate, ExpenseItem, ExpenseCost 
                                            FROM tblexpense 
                                            WHERE MONTH(ExpenseDate) = '$monthNum' 
                                            AND YEAR(ExpenseDate) = '$year' 
                                            AND UserId = '$userid'");
        
        while ($expenseRow = mysqli_fetch_array($expenseQuery)) {
            $expenseDate = $expenseRow['ExpenseDate'];
            $expenseItem = $expenseRow['ExpenseItem'];
            $expenseAmount = $expenseRow['ExpenseCost'];
            
            // Display each expense row
            echo "<tr>
                    <td>$cnt</td>
                    <td>$expenseDate</td>
                    <td>$expenseItem</td>
                    <td>$expenseAmount</td>
                  </tr>";
            
            $monthlyTotal += $expenseAmount;
            $cnt++;
        }
        ?>
        <tr style="background-color:#e0f7fa;">
            <th colspan="3" style="text-align:right;">Total for <?php echo date("F Y", strtotime($month)); ?>:</th>
            <th><?php echo $monthlyTotal; ?></th>
        </tr>
    </tbody>
</table>

						</div>
					</div>
				</div><!-- /.panel-->
			</div><!-- /.col-->
			<?php include_once('includes/footer.php'); ?>
		</div><!-- /.row -->
	</div><!--/.main-->

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/chart.min.js"></script>
<script src="js/chart-data.js"></script>
<script src="js/easypiechart.js"></script>
<script src="js/easypiechart-data.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/custom.js"></script>

</body>
</html>
<?php } ?>
