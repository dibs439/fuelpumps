<?php


function resize_image($file, $destination, $w, $h) {
    //Get the original image dimensions + type
    list($source_width, $source_height, $source_type) = getimagesize($file);

    //Figure out if we need to create a new JPG, PNG or GIF
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if ($ext == "jpg" || $ext == "jpeg") {
        $source_gdim=imagecreatefromjpeg($file);
    } elseif ($ext == "png") {
        $source_gdim=imagecreatefrompng($file);
    } elseif ($ext == "gif") {
        $source_gdim=imagecreatefromgif($file);
    } else {
        //Invalid file type? Return.
        return;
    }

    //If a width is supplied, but height is false, then we need to resize by width instead of cropping
    if ($w && !$h) {
        $ratio = $w / $source_width;
        $temp_width = $w;
        $temp_height = $source_height * $ratio;

        $desired_gdim = imagecreatetruecolor($temp_width, $temp_height);
        imagecopyresampled(
            $desired_gdim,
            $source_gdim,
            0, 0,
            0, 0,
            $temp_width, $temp_height,
            $source_width, $source_height
        );
    } else {
        $source_aspect_ratio = $source_width / $source_height;
        $desired_aspect_ratio = $w / $h;

        if ($source_aspect_ratio > $desired_aspect_ratio) {
            /*
             * Triggered when source image is wider
             */
            $temp_height = $h;
            $temp_width = ( int ) ($h * $source_aspect_ratio);
        } else {
            /*
             * Triggered otherwise (i.e. source image is similar or taller)
             */
            $temp_width = $w;
            $temp_height = ( int ) ($w / $source_aspect_ratio);
        }

        /*
         * Resize the image into a temporary GD image
         */

        $temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
        imagecopyresampled(
            $temp_gdim,
            $source_gdim,
            0, 0,
            0, 0,
            $temp_width, $temp_height,
            $source_width, $source_height
        );

        /*
         * Copy cropped region from temporary image into the desired GD image
         */

        $x0 = ($temp_width - $w) / 2;
        $y0 = ($temp_height - $h) / 2;
        $desired_gdim = imagecreatetruecolor($w, $h);
        imagecopy(
            $desired_gdim,
            $temp_gdim,
            0, 0,
            $x0, $y0,
            $w, $h
        );
    }

    /*
     * Render the image
     * Alternatively, you can save the image in file-system or database
     */

    if ($ext == "jpg" || $ext == "jpeg") {
        ImageJpeg($desired_gdim,$destination,100);
    } elseif ($ext == "png") {
        ImagePng($desired_gdim,$destination);
    } elseif ($ext == "gif") {
        ImageGif($desired_gdim,$destination);
    } else {
        return;
    }

    ImageDestroy ($desired_gdim);
}

function createThumb($src, $dest, $desired_width = false, $desired_height = false) {
 
    /* If no dimenstion for thumbnail given, return false */    
    if (!$desired_height && !$desired_width)
        return false;
 
    $fparts = pathinfo($src);
    $ext = strtolower($fparts['extension']);
 
    /* if its not an image return false */
    if (!in_array($ext, array(
            'gif',
            'jpg',
            'png',
            'jpeg'
        )))
        return false;
 
    /* read the source image */
    if ($ext == 'gif')
        $resource = imagecreatefromgif($src);
    else if ($ext == 'png')
        $resource = imagecreatefrompng($src);
    else if ($ext == 'jpg' || $ext == 'jpeg')
        $resource = imagecreatefromjpeg($src);
 
    $width = imagesx($resource);
    $height = imagesy($resource);
 
    /* find the “desired height” or “desired width” of this thumbnail, relative
     * to each other, if one of them is not given */
    if (!$desired_height)
        $desired_height = floor($height * ($desired_width / $width));
 
    if (!$desired_width)
        $desired_width = floor($width * ($desired_height / $height));
	
	

	
 
    /* create a new, “virtual” image */
    $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
 
    switch ($ext)
    {
    case "png":
        // integer representation of the color black (rgb: 0,0,0)
        $background = imagecolorallocate($virtual_image, 0, 0, 0);
 
        // removing the black from the placeholder
        imagecolortransparent($virtual_image, $background);
 
        // turning off alpha blending (to ensure alpha channel information 
        // is preserved, rather than removed (blending with the rest of the 
        // image in the form of black))
        imagealphablending($virtual_image, false);
 
        // turning on alpha channel information saving (to ensure the full range 
        // of transparency is preserved)
        imagesavealpha($virtual_image, true);
 
        break;
    case "gif":
        // integer representation of the color black (rgb: 0,0,0)
        $background = imagecolorallocate($virtual_image, 0, 0, 0);
 
        // removing the black from the placeholder
        imagecolortransparent($virtual_image, $background);
 
        break;
    }
 
    /* copy source image at a resized size */
    imagecopyresampled($virtual_image, $resource, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
 
    /* create the physical thumbnail image to its destination */
    /* Use correct function based on the desired image type from $dest thumbnail
     * source */
    $fparts = pathinfo($dest);
    $ext = strtolower($fparts['extension']);
    /* if dest is not an image type, default to jpg */
    if (!in_array($ext, array(
            'gif',
            'jpg',
            'png',
            'jpeg'
        )))
        $ext = 'jpg';
    $dest = $fparts['dirname'] . '/' . $fparts['filename'] . '.' . $ext;
 
    if ($ext == 'gif')
        imagegif($virtual_image, $dest);
    else if ($ext == 'png')
        imagepng($virtual_image, $dest, 1);
    else if ($ext == 'jpg' || $ext == 'jpeg')
        imagejpeg($virtual_image, $dest, 100);
 
    return array(
        'width' => $width,
        'height' => $height,
        'new_width' => $desired_width,
        'new_height' => $desired_height,
        'dest' => $dest
    );
}


function resize_values($image){
    #for the purpose of this example, we'll set this here
    #to make this function more powerful, i'd pass these 
    #to the function on the fly
    $maxWidth = 200; 
    $maxHeight = 200;

    #get the size of the image you're resizing.
    $origHeight = imagesy($image);
    $origWidth = imagesx($image);

    #check for longest side, we'll be seeing that to the max value above
    if($origHeight > $origWidth){ #if height is more than width
         $newWidth = ($maxHeight * $origWidth) / $origHeight;

         $retval = array(width => $newWidth, height => $maxHeight);
    }else{
         $newHeight= ($maxWidth * $origHeight) / $origWidth;

         $retval = array(width => $origWidth, height => $newHeight);
    }
return $retval;
}

function createThumbnail($image_name,$new_width,$new_height,$uploadDir,$moveToDir)
{
    $path = $uploadDir . '/' . $image_name;

    $mime = getimagesize($path);

    if($mime['mime']=='image/png'){ $src_img = imagecreatefrompng($path); }
    if($mime['mime']=='image/jpg'){ $src_img = imagecreatefromjpeg($path); }
    if($mime['mime']=='image/jpeg'){ $src_img = imagecreatefromjpeg($path); }
    if($mime['mime']=='image/pjpeg'){ $src_img = imagecreatefromjpeg($path); }

    $old_x          =   imageSX($src_img);
    $old_y          =   imageSY($src_img);

    if($old_x > $old_y) 
    {
        $thumb_w    =   $new_width;
        $thumb_h    =   $old_y*($new_height/$old_x);
    }

    if($old_x < $old_y) 
    {
        $thumb_w    =   $old_x*($new_width/$old_y);
        $thumb_h    =   $new_height;
    }

    if($old_x == $old_y) 
    {
        $thumb_w    =   $new_width;
        $thumb_h    =   $new_height;
    }

    $dst_img        =   ImageCreateTrueColor($thumb_w,$thumb_h);

    imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 


    // New save location
    $new_thumb_loc = $moveToDir . $image_name;

    if($mime['mime']=='image/png'){ $result = imagepng($dst_img,$new_thumb_loc,8); }
    if($mime['mime']=='image/jpg'){ $result = imagejpeg($dst_img,$new_thumb_loc,80); }
    if($mime['mime']=='image/jpeg'){ $result = imagejpeg($dst_img,$new_thumb_loc,80); }
    if($mime['mime']=='image/pjpeg'){ $result = imagejpeg($dst_img,$new_thumb_loc,80); }

    imagedestroy($dst_img); 
    imagedestroy($src_img);

    return $result;
}
