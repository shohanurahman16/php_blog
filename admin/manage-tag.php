<?php
ob_start();
session_start();
if($_SESSION['name']!='admin')
{
	header('location: login.php');
}
include ('../config.php');
?>
<?php 
if(isset($_POST['form1']))	{
	try {
		if(empty($_POST['tag_name']))	{
		throw new Exception('Tag Can not Be empty');
		}

		$statement = $db->prepare("SELECT * FROM tbl_tag WHERE tag_name=?");
		$statement->execute(array($_POST['tag_name']));
		$total = $statement->rowCount();
		
		if($total>0) {
			throw new Exception("Tag Name already exists.");
		}

		$statement = $db->prepare("INSERT INTO tbl_Tag (tag_name) VALUES (?)");
		$statement->execute(array($_POST['tag_name']));
		
		$success_message = "Tag name has been inserted successfully.";

	}

		catch (Exception $e) {
			$error_message = $e->getMessage();
			
		}	
}

if(isset($_POST['form2']))	{
	try {
		
		if(empty($_POST['tag_name'])) {
			throw new Exception("Tag Name can not be empty.");
		}
		
		$statement = $db->prepare("UPDATE tbl_Tag SET tag_name=? WHERE tag_id=?");
		$statement->execute(array($_POST['tag_name'],$_POST['hdn']));
		
		$success_message1 = "Tag Name has been updated successfully.";
		
	}
	catch(Exception $e) {
		$error_message1 = $e->getMessage();
	}

}

if(isset($_REQUEST['id']))	{
	$id = $_REQUEST['id'];

	$statement = $db->prepare("DELETE FROM tbl_tag WHERE tag_id=?");
	$statement->execute(array($id));
	$success_message2 = "Tag Name has been deleted successfully.";

}

 ?>

<?php include("header.php"); ?>
<h2>Add New Tag</h2>
<?php
if(isset($error_message)) {echo "<br><div class='error'>".$error_message."</div>";}
if(isset($success_message)) {echo "<br><div class='success'>".$success_message."</div>";}
?>

<form action="" method="post">
<table class="tbl1">
<tr>
	<td>Tag Name</td>
</tr>
<tr>
	<td><input class="short" type="text" name="tag_name"></td>
</tr>
<tr>
	<td><input type="submit" value="SAVE" name="form1"></td>
</tr>
</table>	
</form>


<h2>View  All Categories</h2>
<?php
if(isset($error_message1)) {echo "<br><div class='error'>".$error_message1."</div>";}
if(isset($success_message1)) {echo "<br><div class='success'>".$success_message1."</div>";}

if(isset($success_message2)) {echo "<br><div class='success'>".$success_message2."</div>";}
?>

<table class="tbl2" width="100%">
	<tr>
		<th width="5%">Serial</th>
		<th width="75%">Tag Name</th>
		<th width="15%">Action</th>
	</tr>
	<?php 
		$i = 0;
		$statement = $db->prepare("SELECT * FROM tbl_tag ORDER BY tag_name ASC");
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row)	{
			$i++;
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row['tag_name']; ?></td>
				<td>
					<a class="fancybox" href="#inline<?php echo $i; ?>">Edit</a>
					<div id="inline<?php echo $i; ?>" style="width:400px;display: none;">
						<h3>Edit Data</h3>
						<p>
							<form action="" method="post">
							<input type="hidden" name="hdn" value="<?php echo $row['tag_id']; ?>">
							<table>
								<tr>
									<td>Tag Name</td>
								</tr>
								<tr>
									<td><input type="text" name="tag_name" value="<?php echo $row['tag_name']; ?>"></td>
								</tr>
								<tr>
									<td><input type="submit" value="UPDATE" name="form2"></td>
								</tr>
							</table>
							</form>
						</p>
					</div>
					&nbsp;|&nbsp;
					<a onclick='return confirmDelete();' href="manage-tag.php?id=<?php echo $row['tag_id']; ?>">Delete</a>
				</td>
			</tr>
			<?php
		}
	 ?>
	
</table>


<?php include("footer.php"); ?>			