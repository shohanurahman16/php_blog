<?php
ob_start();
// session_start();
if($_SESSION['name']!='admin')
{
	header('location: login.php');
}
?>
</div>
		</div>
	</div>

	
</body>
</html>