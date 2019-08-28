<?php
ob_start();
session_start();
if($_SESSION['name']!='admin')
{
	header('location: login.php');
}
?>
<?php include("header.php"); ?>
<h2>All Un-approved Comments</h2>

<table class="tbl2" width="100%">
	<tr>
		<th width="">Serial</th>
		<th width="">Name</th>
		<th width="">Email</th>
		<th width="">URL</th>
		<th width="">Message</th>
		<th width="">Post ID</th>
		<th width="">Action</th>
	</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>
				<a class="fancybox" href="#inline"></a>
				
				<div id="inline" style="width:700px;display: none;">
				<h3 style="border-bottom:2px solid #808080;margin-bottom:10px;">View Post Details</h3>
				<p>
						
						<table>
						<tr>
							<td><b>Title</b></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td><b>Description</b></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td><b>Featured Image</b></td>
						</tr>
						<tr>
							<td><img src="../uploads/" alt=""></td>
						</tr>
						<tr>
							<td><b>Category</b></td>
						</tr>
						<tr>
							<td>
								
							</td>
						</tr>
						<tr>
							<td><b>Tag</b></td>
						</tr>
						<tr>
							<td>
								
							</td>
						</tr>
						
					</table>
						
						
					
					
					
					
				</p>
			</div>
				
				
				
				
			</td>
			<td><a href="comment-approve.php">Approve</a></td>	
		</tr>
	
</table>


<h2>All Approved Comments</h2>


<table class="tbl2" width="100%">
	<tr>
		<th width="">Serial</th>
		<th width="">Name</th>
		<th width="">Email</th>
		<th width="">URL</th>
		<th width="">Message</th>
		<th width="">Post ID</th>
	</tr>
	

		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>
				<a class="fancybox" href="#inline"</a>
				
				<div id="inline" style="width:700px;display: none;">
				<h3 style="border-bottom:2px solid #808080;margin-bottom:10px;">View Post Details</h3>
				<p>						
						
						<table>
						<tr>
							<td><b>Title</b></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td><b>Description</b></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td><b>Featured Image</b></td>
						</tr>
						<tr>
							<td><img src="../uploads/" alt=""></td>
						</tr>
						<tr>
							<td><b>Category</b></td>
						</tr>
						<tr>
							<td>
								
							</td>
						</tr>
						<tr>
							<td><b>Tag</b></td>
						</tr>
						<tr>
							<td>
								
							</td>
						</tr>
						
					</table>
						

					
					
				</p>
			</div>
				
				
				
				
			</td>
		</tr>
		
	
</table>


<?php include("footer.php"); ?>			