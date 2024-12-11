<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['detsuid']==0)) {
  header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Daily Expense Tracker - Dashboard</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
</head>
<body>
	
	<?php include_once('includes/header.php');?>
	<?php include_once('includes/sidebar.php');?>
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Dashboard</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Dashboard</h1>
			</div>
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<div class="panel-body easypiechart-panel">
						<?php
						// Today's Expense
						$userid = $_SESSION['detsuid'];
						$tdate = date('Y-m-d');
						$query = mysqli_query($con, "select sum(ExpenseCost) as todaysexpense from tblexpense where (ExpenseDate)='$tdate' && (UserId='$userid');");
						$result = mysqli_fetch_array($query);
						$sum_today_expense = $result['todaysexpense'];
						?> 

						<h4>Today's Expense</h4>
						<div class="easypiechart" id="easypiechart-blue" data-percent="<?php echo $sum_today_expense; ?>"><span class="percent"><?php echo $sum_today_expense ?: "0"; ?></span></div>
					</div>
				</div>
			</div>

			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<?php
					// Yesterday's Expense
					$ydate = date('Y-m-d', strtotime("-1 days"));
					$query1 = mysqli_query($con, "select sum(ExpenseCost) as yesterdayexpense from tblexpense where (ExpenseDate)='$ydate' && (UserId='$userid');");
					$result1 = mysqli_fetch_array($query1);
					$sum_yesterday_expense = $result1['yesterdayexpense'];
					?> 
					<div class="panel-body easypiechart-panel">
						<h4>Yesterday's Expense</h4>
						<div class="easypiechart" id="easypiechart-orange" data-percent="<?php echo $sum_yesterday_expense; ?>"><span class="percent"><?php echo $sum_yesterday_expense ?: "0"; ?></span></div>
					</div>
				</div>
			</div>

			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<?php
					// Weekly Expense
					$pastdate =  date("Y-m-d", strtotime("-1 week")); 
					$crrntdte = date("Y-m-d");
					$query2 = mysqli_query($con, "select sum(ExpenseCost) as weeklyexpense from tblexpense where ((ExpenseDate) between '$pastdate' and '$crrntdte') && (UserId='$userid');");
					$result2 = mysqli_fetch_array($query2);
					$sum_weekly_expense = $result2['weeklyexpense'];
					?>
					<div class="panel-body easypiechart-panel">
						<h4>Last 7day's Expense</h4>
						<div class="easypiechart" id="easypiechart-teal" data-percent="<?php echo $sum_weekly_expense; ?>"><span class="percent"><?php echo $sum_weekly_expense ?: "0"; ?></span></div>
					</div>
				</div>
			</div>

			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<?php
					// Monthly Expense
					$monthdate =  date("Y-m-d", strtotime("-1 month")); 
					$query3 = mysqli_query($con, "select sum(ExpenseCost) as monthlyexpense from tblexpense where ((ExpenseDate) between '$monthdate' and '$crrntdte') && (UserId='$userid');");
					$result3 = mysqli_fetch_array($query3);
					$sum_monthly_expense = $result3['monthlyexpense'];
					?>
					<div class="panel-body easypiechart-panel">
						<h4>Last 30day's Expenses</h4>
						<div class="easypiechart" id="easypiechart-red" data-percent="<?php echo $sum_monthly_expense; ?>"><span class="percent"><?php echo $sum_monthly_expense ?: "0"; ?></span></div>
					</div>
				</div>
			</div>
		</div><!--/.row-->

		<div class="row">
			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<?php
					// Yearly Expense
					$cyear = date("Y");
					$query4 = mysqli_query($con, "select sum(ExpenseCost) as yearlyexpense from tblexpense where (year(ExpenseDate)='$cyear') && (UserId='$userid');");
					$result4 = mysqli_fetch_array($query4);
					$sum_yearly_expense = $result4['yearlyexpense'];
					?>
					<div class="panel-body easypiechart-panel">
						<h4>Current Year Expenses</h4>
						<div class="easypiechart" id="easypiechart-red" data-percent="<?php echo $sum_yearly_expense; ?>"><span class="percent"><?php echo $sum_yearly_expense ?: "0"; ?></span></div>
					</div>
				</div>
			</div>

			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<?php
					// Total Expense
					$query5 = mysqli_query($con, "select sum(ExpenseCost) as totalexpense from tblexpense where UserId='$userid';");
					$result5 = mysqli_fetch_array($query5);
					$sum_total_expense = $result5['totalexpense'];
					?>
					<div class="panel-body easypiechart-panel">
						<h4>Total Expenses</h4>
						<div class="easypiechart" id="easypiechart-red" data-percent="<?php echo $sum_total_expense; ?>"><span class="percent"><?php echo $sum_total_expense ?: "0"; ?></span></div>
					</div>
				</div>
			</div>
		</div><!--/.row-->

		<!-- Canvas for bar and pie charts -->
		<div class="row">
		    <div class="col-md-6">
		        <h4>Expense Breakdown (Last 30 Days)</h4>
		        <canvas id="expenseBarChart"></canvas>
		    </div>
		    <div class="col-md-6">
		        <h4>Expense Distribution</h4>
		        <canvas id="expensePieChart"></canvas>
		    </div>
		</div>

		<!-- New section for Statistics Line Chart -->
		<div class="row" style="margin-top: 20px;">
		    <div class="col-md-12">
		        <h4>Statistics</h4>
		        <canvas id="statisticsLineChart"></canvas>
		    </div>
		</div>
	</div>	<!--/.main-->

	<?php include_once('includes/footer.php');?>

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<script>
		// PHP variables to JavaScript
		const todayExpense = <?php echo $sum_today_expense ?? 0; ?>;
		const yesterdayExpense = <?php echo $sum_yesterday_expense ?? 0; ?>;
		const weeklyExpense = <?php echo $sum_weekly_expense ?? 0; ?>;
		const monthlyExpense = <?php echo $sum_monthly_expense ?? 0; ?>;
		const yearlyExpense = <?php echo $sum_yearly_expense ?? 0; ?>;
		const totalExpense = <?php echo $sum_total_expense ?? 0; ?>;

		// Bar Chart for Expense Breakdown
		const ctxBar = document.getElementById('expenseBarChart').getContext('2d');
		new Chart(ctxBar, {
		    type: 'bar',
		    data: {
		        labels: ['Today', 'Yesterday', 'Last 7 Days', 'Last 30 Days'],
		        datasets: [{
		            label: 'Expenses',
		            data: [todayExpense, yesterdayExpense, weeklyExpense, monthlyExpense],
		            backgroundColor: 'rgba(75, 192, 192, 0.6)',
		            borderColor: 'rgba(75, 192, 192, 1)',
		            borderWidth: 1
		        }]
		    },
		    options: {
		        responsive: true,
		        scales: {
		            y: { beginAtZero: true }
		        }
		    }
		});

		// Pie Chart for Expense Distribution
		const ctxPie = document.getElementById('expensePieChart').getContext('2d');
		new Chart(ctxPie, {
		    type: 'pie',
		    data: {
		        labels: ['Today', 'Yesterday', 'Last 7 Days', 'Last 30 Days', 'Yearly'],
		        datasets: [{
		            data: [todayExpense, yesterdayExpense, weeklyExpense, monthlyExpense, yearlyExpense],
		            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF9F40'],
		            hoverOffset: 4
		        }]
		    },
		    options: {
		        responsive: true,
		    }
		});

		// Line Chart for Statistics
		const ctxLine = document.getElementById('statisticsLineChart').getContext('2d');
		new Chart(ctxLine, {
		    type: 'line',
		    data: {
		        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		        datasets: [{
		            label: 'Monthly Expenses',
		            data: [1200, 1500, 1800, 1400, 2100, 2300, 1950, 2100, 1750, 2250, 2350, 1900],
		            borderColor: 'rgba(54, 162, 235, 1)',
		            fill: false,
		            tension: 0.1
		        }]
		    },
		    options: {
		        responsive: true,
		        scales: {
		            y: { beginAtZero: true }
		        }
		    }
		});
	</script>
</body>
</html>
<?php } ?>
