<?php



if(isset($_GET['pullfile'])){
$newid = $_GET['pullfile'];
}

if(isset($_GET['pulldoc'])){
$newid = $_GET['pulldoc'];
}

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
    $finfo = new finfo(FILEINFO_MIME_TYPE);
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
    }

    // You should name it uniquely.
    // DO NOT USE $_FILES['fileToUpload2']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
	if(isset($_GET['pulldoc'])){
	$dir_holder = 'DocPatientImage';
	}else{
	$dir_holder = 'PatientImage';
	}
    if (!move_uploaded_file(
        $_FILES['fileToUpload2']['tmp_name'],
        sprintf('./'.$dir_holder.'/'.$newid.'.jpg',
            sha1_file($_FILES['fileToUpload2']['tmp_name']),
            $ext
        )
    )) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    echo 'File is uploaded successfully.';

} catch (RuntimeException $e) {

    echo $e->getMessage();

}

?>
