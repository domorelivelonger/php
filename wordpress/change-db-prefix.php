<?php
if(isset($_POST['submit'])){
$database_host = $_POST['dbhname'];
$database_user = $_POST['dbuname'];
$database_password = $_POST['password'];
$database_name = $_POST['dbname'];
$new_table_prefix = $_POST['newpref'];
$old_table_prefix = $_POST['oldpref'];


// Connect to database
$db = mysqli_connect($database_host, $database_user, $database_password, $database_name) or die('MySQL connect failed');

// List all tables
$result = mysqli_query($db, "SHOW TABLES") or die('SHOW TABLES failed');

// Loop through all tables
while($row = mysqli_fetch_array($result)) {
    $old_table = $row[0];

    // Check if old prefix is correct
    if(!empty($old_table_prefix) && !preg_match('/^'.$old_table_prefix.'/', $old_table)) {
        echo "Table $old_table does not match prefix $old_table_prefix<br/>\n";
        continue;
    }

    // Preliminary check: Is the old table prefix the same as the new one?
    if(preg_match('/^'.$new_table_prefix.'/', $old_table)) {
        echo "Table $old_table already done<br/>\n";
        continue;
    }

    // Construct the new table prefix and rename the table
    if(!empty($old_table_prefix)) {
        $new_table = preg_replace('/^'.$old_table_prefix.'/', $new_table_prefix, $old_table);
    } else {
        $new_table = $new_table_prefix.$old_table;
    }
    // Rename the table
    echo "Renaming $old_table to $new_table<br/>\n";
    mysqli_query($db, "RENAME TABLE `$old_table`  TO `$new_table`");
    header("Refresh: 2; URL = prefix.php"); //Name of the script file
}
echo "Renaming complete";
mysqli_close($db);
}else{
?>
<html>
<head>
<title>Change Table Prefix</title>
<body>

<form name="PrefixChanger" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
<table>
<tr><td>DB Hostname</td><td> <input type="text" required name="dbhname" value=""></td></tr>
<tr><td>DB Name</td><td> <input type="text" required name="dbname" value=""></td></tr>
<tr><td>DB Username</td><td> <input type="text" required name="dbuname" value=""></td></tr>
<tr><td>DB Password</td><td> <input type="password" required name="password" value=""></td></tr>
<tr><td>New Prefix</td><td> <input type="text" required name="newpref" value=""></td></tr>
<tr><td>Old Prefix</td><td> <input type="text" name="oldpref" value=""></td></tr>
<tr><td></td><td align="right"><input type="submit" name="submit" value="submit"></td></tr>
</table>
</form>

</body>
</head>
</html>
<?php } ?>
