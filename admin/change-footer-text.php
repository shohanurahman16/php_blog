<?php
ob_start();
session_start();
if($_SESSION['name']!='admin')
{
	header('location: login.php');
}
include("../config.php");
?>
<?php
if(isset($_POST['form1'])) {
	
	try {
	
		if(empty($_POST['description'])) {
			throw new Exception("Footer Text can not be empty");
		}
		
		$statement = $db->prepare("UPDATE tbl_footer SET description=? WHERE id=1");
		$statement->execute(array($_POST['description']));
		
		$success_message = "Footer text is updated successfully.";
		
	
	}
	
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
		
}
?>


<?php
$statement = $db->prepare("SELECT * FROM tbl_footer WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row)
{
	$description_new = $row['description'];
}

?>

<?php include("header.php"); ?>
<h2>Change Footer text</h2>
<?php
if(isset($error_message)) {echo "<br><div class='error'>".$error_message."</div>";}
if(isset($success_message)) {echo "<br><div class='success'>".$success_message."</div>";}
?>
<form action="" method="post">
<table class="tbl1">
<tr>
	<td>Footer Text</td>
</tr>
<tr>
	<td><input class="long" type="text" name="description" value="<?php echo $description_new; ?>"></td>
</tr>
<tr>
	<td><input type="submit" value="SAVE" name="form1"></td>
</tr>
</table>	
</form>

<?php include("footer.php"); ?>			