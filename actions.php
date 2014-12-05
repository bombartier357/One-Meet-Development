<?php
//Author: Kyle Austin
//Date: 11/29/2014
//Purpose: Build class that runs class actions for users...
include("config.php");

$host = $global['host'];
$name = $global['name'];
$user = $global['user'];
$pass = $global['pass'];

$con = new PDO('mysql:host='.$host.';dbname='.$name.';charset=utf8', $user, $pass, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			
if (!$con){
	die('Could not connect: ' . mysql_error());
}

if(isset($_GET['pullfile'])){
$newid = $_GET['pullfile'];

try {
    
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES['fileToUpload2']['error']) ||
        is_array($_FILES['fileToUpload2']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }

    // Check $_FILES['fileToUpload2']['error'] value.
    switch ($_FILES['fileToUpload2']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    // You should also check filesize here. 
    if ($_FILES['fileToUpload2']['size'] > 1000000) {
        throw new RuntimeException('Exceeded filesize limit.');
    }

    // DO NOT TRUST $_FILES['fileToUpload2']['mime'] VALUE !!
    // Check MIME Type by yourself.
    /*$finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($_FILES['fileToUpload2']['tmp_name']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ),
        true
    )) {
        throw new RuntimeException('Invalid file format.');
    }*/

    // You should name it uniquely.
    // DO NOT USE $_FILES['fileToUpload2']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.

	$charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		$str = '';
		$length = 251;
		$count = strlen($charset);
		while ($length--) {
			$str .= $charset[mt_rand(0, $count-1)];
		}
		$hash = $str;


	$dir_holder = 'images/user_images/'.$newid.'/'.$hash.'.jpg';
	
    if (!move_uploaded_file(
        $_FILES['fileToUpload2']['tmp_name'],
        sprintf($dir_holder,
            sha1_file($_FILES['fileToUpload2']['tmp_name']),
            $ext
        )
    )) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    echo 'File is uploaded successfully.';

	

	$query = $con->prepare("INSERT INTO images SET owner = ?, filename = ?");
	$query->bindValue(1, $newid, PDO::PARAM_INT);
	$query->bindValue(2, $hash.".jpg", PDO::PARAM_STR);;
	$result = $query->execute();

} catch (RuntimeException $e) {

    echo $e->getMessage();

}

}

?>
