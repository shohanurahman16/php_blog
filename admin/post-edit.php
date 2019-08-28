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

if(!isset($_REQUEST['id'])) {
	header("location: post-view.php");
}
else {
	$id = $_REQUEST['id'];
}
?>


<?php

if(isset($_POST['form1'])) {


	try {
	
		if(empty($_POST['post_title'])) {
			throw new Exception("Title can not be empty.");
		}
		
		if(empty($_POST['post_description'])) {
			throw new Exception("Description can not be empty.");
		}		
		
		if(empty($_POST['cat_id'])) {
			throw new Exception("Category Name can not be empty.");
		}
		
		if(empty($_POST['tag_id'])) {
			throw new Exception("Tag Name can not be empty.");
		}
		
				
		$tag_id = $_POST['tag_id'];
		
		$i=0;
		if(is_array($tag_id))
		{
			foreach($tag_id as $key=>$val)
			{
				$arr[$i] = $val;
				$i++;
			}
		}
		
		$tag_ids = implode(",",$arr);
		
		
		if(empty($_FILES["post_image"]["name"])) {
						
			$statement = $db->prepare("UPDATE tbl_post SET post_title=?, post_description=?, cat_id=?, tag_id=? WHERE post_id=?");
			$statement->execute(array($_POST['post_title'],$_POST['post_description'],$_POST['cat_id'],$tag_ids,$id));
			
		}
		else {
			
			$up_filename=$_FILES["post_image"]["name"];
			$file_basename = substr($up_filename, 0, strripos($up_filename, '.')); 
			$file_ext = substr($up_filename, strripos($up_filename, '.'));
			$f1 = $id . $file_ext;
		
			if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif'))
				throw new Exception("Only jpg, jpeg, png and gif format images are allowed to upload.");
			
			
			$statement = $db->prepare("SELECT * FROM tbl_post WHERE post_id=?");
			$statement->execute(array($id));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $row)
			{
				$real_path = "../uploads/".$row['post_image'];
				unlink($real_path);
			}
			move_uploaded_file($_FILES["post_image"]["tmp_name"],"../uploads/" . $f1);
			
			
			$statement = $db->prepare("UPDATE tbl_post SET post_title=?, post_description=?,post_image=?, cat_id=?, tag_id=? WHERE post_id=?");
			$statement->execute(array($_POST['post_title'],$_POST['post_description'],$f1,$_POST['cat_id'],$tag_ids,$id));
			
		}

		$success_message = "Post is updated successfully.";
			
	}
	
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}


}

?>



<?php
$statement = $db->prepare("SELECT * FROM tbl_post WHERE post_id=?");
$statement->execute(array($id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row)
{
	$post_title = $row['post_title'];
	$post_description = $row['post_description'];
	$post_image = $row['post_image'];
	$cat_id = $row['cat_id'];
	$tag_id = $row['tag_id'];
}
?>


<?php include("header.php"); ?>
<h2>Edit Post</h2>

<?php
if(isset($error_message)) {echo "<div class='error'>".$error_message."</div>";}
if(isset($success_message)) {echo "<div class='success'>".$success_message."</div>";}
?>


<form action="post-edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
<!--<input type="hidden" name="id" value="<?php echo $id; ?>">-->
<table class="tbl1">
<tr><td>Title</td></tr>
<tr><td><input class="long" type="text" name="post_title" value="<?php echo $post_title; ?>"></td></tr>
<tr><td>Description</td></tr>
<tr>
<td>
<textarea name="post_description" cols="30" rows="10"><?php echo $post_description; ?></textarea>
<script type="text/javascript">
	if ( typeof CKEDITOR == 'undefined' )
	{
		document.write(
			'<strong><span style="color: #ff0000">Error</span>: CKEditor not found</strong>.' +
			'This sample assumes that CKEditor (not included with CKFinder) is installed in' +
			'the "/ckeditor/" path. If you have it installed in a different place, just edit' +
			'this file, changing the wrong paths in the &lt;head&gt; (line 5) and the "BasePath"' +
			'value (line 32).' ) ;
	}
	else
	{
		var editor = CKEDITOR.replace( 'post_description' );
		//editor.setData( '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' );
	}

</script>
</td>
</tr>
<tr><td>Previous Featured Image Preview</td></tr>
<tr><td><img src="../uploads/<?php echo $post_image; ?>" alt="" width="200"></td></tr>
<tr><td>New Featured Image</td></tr>
<tr><td><input type="file" name="post_image"></td></tr>
<tr><td>Select a Category</td></tr>
<tr>
<td>
<select name="cat_id">
<option value="">Select a Category</option>
<?php
$statement = $db->prepare("SELECT * FROM tbl_category ORDER BY cat_name ASC");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row)
{

	if($row['cat_id'] == $cat_id)
	{
		?><option value="<?php echo $row['cat_id']; ?>" selected><?php echo $row['cat_name']; ?></option><?php
	}
	else
	{
		?><option value="<?php echo $row['cat_id']; ?>"><?php echo $row['cat_name']; ?></option><?php
	}
		
	
	
}
?>
</select>
</td>
</tr>
<tr><td>Select a Tag</td></tr>
<tr>
<td>
<?php
$statement = $db->prepare("SELECT * FROM tbl_tag ORDER BY tag_name ASC");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row)
{
		
	$arr2 = explode(",",$tag_id);
	$count_arr2 = count(explode(",",$tag_id));
	$is_there = 0;
	for($j=0;$j<$count_arr2;$j++)
	{
		if($arr2[$j]==$row['tag_id'])
		{
			$is_there = 1;
			break;
		}
	}
	
	if($is_there == 1)
	{
		?><input type="checkbox" name="tag_id[]" value="<?php echo $row['tag_id']; ?>" checked>&nbsp;<?php echo $row['tag_name']; ?><br><?php
	}
	else
	{
		?><input type="checkbox" name="tag_id[]" value="<?php echo $row['tag_id']; ?>">&nbsp;<?php echo $row['tag_name']; ?><br><?php
	}	
}
?>
</td>
</tr>
<tr><td><input type="submit" value="UPDATE" name="form1"></td></tr>
</table>	
</form>
<?php include("footer.php"); ?>			