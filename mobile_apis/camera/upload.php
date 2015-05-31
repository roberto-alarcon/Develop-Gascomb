
<?php
print_r($_FILES);
error_reporting(E_ALL);

// we first include the upload class, as we will need it here to deal with the uploaded file
include_once('class.upload.php');

// retrieve eventual CLI parameters
$cli = (isset($argc) && $argc > 1);
if ($cli) {
    if (isset($argv[1])) $_GET['file'] = $argv[1];
    if (isset($argv[2])) $_GET['dir'] = $argv[2];
    if (isset($argv[3])) $_GET['pics'] = $argv[3];
}

// set variables
$dir_dest = './';
$dir_pics = (isset($_GET['pics']) ? $_GET['pics'] : $dir_dest);

if (!$cli && !(isset($_SERVER['HTTP_X_FILE_NAME']) && isset($_SERVER['CONTENT_LENGTH']))) {
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv=content-type content="text/html; charset=UTF-8">


<body>

    <h1>class.upload.php test forms</h1>

<?php
}



    // ---------- IMAGE UPLOAD ----------

    // we create an instance of the class, giving as argument the PHP object
    // corresponding to the file field from the form
    // All the uploads are accessible from the PHP object $_FILES
    $handle = new Upload($_FILES['my_field']);
    

    // then we check if the file has been uploaded properly
    // in its *temporary* location in the server (often, it is /tmp)
    if ($handle->uploaded) {

        // yes, the file is on the server
        // below are some example settings which can be used if the uploaded file is an image.
        $handle->image_resize            = true;
        $handle->image_ratio_y           = true;
        $handle->image_x                 = 800;
        $handle->image_rotate           = '180';
        $handle->image_text            = 'Grupo Automotriz en Servicios de Combustibles, S.A. de C.V.';
        $handle->image_text_color      = '#FFFFFF';
        $handle->image_text_position   = 'BL';
        $handle->image_text_padding_x  = 10;
        $handle->image_text_padding_y  = 2;
        $handle->file_new_name_body     = $_POST['area'].'_'.time();

        $handle->Process($dir_dest);
        $handle-> Clean();

    } else {
        // if we're here, the upload file failed for some reasons
        // i.e. the server didn't receive the file
        echo '<p class="result">';
        echo '  <b>File not uploaded on the server</b><br />';
        echo '  Error: ' . $handle->error . '';
        echo '</p>';
    }





if (!$cli && !(isset($_SERVER['HTTP_X_FILE_NAME']) && isset($_SERVER['CONTENT_LENGTH']))) {

    echo '<p class="result"><a href="index.html">do another test</a></p>';

    if (isset($handle)) {
        echo '<pre>';
        echo($handle->log);
        echo '</pre>';
    }
?>
</body>

</html>

<?php
}
?>
