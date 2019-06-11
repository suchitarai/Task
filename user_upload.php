
<html>
<script src="jquery-3.2.1.min.js"></script>
<link  href="css/style.css" rel="stylesheet">
<head>
<script type="text/javascript">
$(document).ready(function() {
    $("#frmCSVImport").on("submit", function () {
	    $("#response").attr("class", "");
        $("#response").html("");
        var fileType = ".csv";
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
        if (!regex.test($("#file").val().toLowerCase())) {
        	    $("#response").addClass("error");
        	    $("#response").addClass("display-block");
            $("#response").html("Invalid File. Please Upload : <b>" + fileType + "</b> Files.");
            return false;
        }
        return true;
    });
});
</script>
</head>
<?php
include("dbcon.php");
$dbobj=new Dbconfig();
if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
			$unique_query=("SELECT * FROM `users` where email='" . $column[2] . "'");
			if(($dbobj->num_of_rows($unique_query))==0){
				print "------";exit;
				$email = ($column[2]);
				// check if e-mail address is well-formed
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				  $emailErr = 1; 
				}else{
					 $emailErr = 0; 
				}
				if($emailErr==0){
				$sqlInsert = "INSERT into users (name,surname,email)
					   values ('" . ucfirst($column[0]) . "','" . ucfirst($column[1]) . "','" . $column[2] . "')";
				$result = mysqli_query($conn, $sqlInsert);
				}
            }
            if (! empty($result)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
        }
    }
}
?>
<!DOCTYPE html>


<body>
    <h2>Import CSV file into Mysql using PHP</h2>    
    <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
    <div class="outer-scontainer">
        <div class="row">

            <form class="form-horizontal" action="" method="post"
                name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                <div class="input-row">
                    <label class="col-md-4 control-label">Choose CSV
                        File</label> <input type="file" name="file"
                        id="file" accept=".csv">
                    <button type="submit" id="submit" name="import"
                        class="btn-submit">Import</button>
                    <br />
                </div>
            </form>

        </div>
		<?php
		//----------Start: Show data Table-------------//
		$sqlSelect = "SELECT * FROM users";            
		if ($dbobj->num_of_rows($sqlSelect) > 0) {
			?>
			<table id='userTable'>
				<thead>
					<tr>
						<th>Name</th>
						<th>SurName</th>
						<th>Email</th>
					</tr>
				</thead>
				<?php
				$val=$dbobj->fetchAllRows($sqlSelect);
				foreach ($val as $row) {
					?>
					<tbody>
						<tr>
							<td><?php  echo $row->name; ?></td>
							<td><?php  echo $row->surname; ?></td>
							<td><?php  echo $row->email; ?></td>
						</tr>
					<?php
				}
				?>
				</tbody>
			</table>
			<?php }
			//----------END: Show data Table-------------//
		?>
    </div>

</body>

</html>