<?php
        $PROJECT_PATH = "http://www.twizla.com.au/";
	function uploadImage($fileName, $maxSize, $maxW, $fullPath, $relPath, $colorR, $colorG, $colorB, $maxH = null){
            
		$folder = $relPath;
//                $folder = $fullPath;
		$maxlimit = $maxSize;
		$allowed_ext = "jpg,jpeg,gif,png,bmp";
		$match = "";
		$filesize = $_FILES[$fileName]['size'];
                $errorList = array();
                
		if($filesize > 0){
			$filename = strtolower($_FILES[$fileName]['name']);
			$filename = preg_replace('/\s/', '_', $filename);
		   	if($filesize < 1){
				$errorList[] = "File size is empty.";
			}
			if($filesize > $maxlimit){
				$errorList[] = "File size is too big.";
			}
			if(count($errorList)<1){
				$file_ext = preg_split("/\./",$filename);
				$allowed_ext = preg_split("/\,/",$allowed_ext);
				foreach($allowed_ext as $ext){
					if($ext==end($file_ext)){
						$match = "1"; // File is allowed
						$NUM = time();
						$front_name = substr($file_ext[0], 0, 15);
						$newfilename = $front_name."_".$NUM.".".end($file_ext);
						$filetype = end($file_ext);
						$save = $folder.$newfilename;
                                                $smallSave = $folder."small_".$newfilename;
						if(!file_exists($save)){
							list($width_orig, $height_orig) = getimagesize($_FILES[$fileName]['tmp_name']);
							if($maxH == null){
								if($width_orig < $maxW){
									$fwidth = $width_orig;

								}else{
									$fwidth = $maxW;
								}
								$ratio_orig = $width_orig/$height_orig;
								$fheight = $fwidth/$ratio_orig;

								$blank_height = $fheight;
								$top_offset = 0;

							}else{
                                                                
								if($width_orig <= $maxW && $height_orig <= $maxH){
									$fheight = $height_orig;
									$fwidth = $width_orig;
								}else{
									if($width_orig > $maxW){
										$ratio = ($width_orig / $maxW);
										$fwidth = $maxW;
										$fheight = ($height_orig / $ratio);
										if($fheight > $maxH){
											$ratio = ($fheight / $maxH);
											$fheight = $maxH;
											$fwidth = ($fwidth / $ratio);
										}
									}
									if($height_orig > $maxH){
										$ratio = ($height_orig / $maxH);
										$fheight = $maxH;
										$fwidth = ($width_orig / $ratio);
										if($fwidth > $maxW){
											$ratio = ($fwidth / $maxW);
											$fwidth = $maxW;
											$fheight = ($fheight / $ratio);
										}
									}
								}
								if($fheight == 0 || $fwidth == 0 || $height_orig == 0 || $width_orig == 0)
                                                                {
									die("FATAL ERROR REPORT ERROR CODE [add-pic-line-67-orig] to <a href='http://www.atwebresults.com'>AT WEB RESULTS</a>");
								}
								if($fheight < 45){
									$blank_height = 45;
									$top_offset = round(($blank_height - $fheight)/2);
								}else{
									$blank_height = $fheight;
								}
							}

							$image_p = imagecreatetruecolor($fwidth, $blank_height);
							$white = imagecolorallocate($image_p, $colorR, $colorG, $colorB);
							imagefill($image_p, 0, 0, $white);
							switch($filetype){
								case "gif":
									$image = imagecreatefromgif($_FILES[$fileName]['tmp_name']);
								break;
								case "jpg":
									$image = imagecreatefromjpeg($_FILES[$fileName]['tmp_name']);
								break;
								case "jpeg":
									$image = imagecreatefromjpeg($_FILES[$fileName]['tmp_name']);
								break;
								case "png":
									$image = imagecreatefrompng($_FILES[$fileName]['tmp_name']);
								break;
							}
							imagecopyresampled($image_p, $image, 0, $top_offset, 0, 0, $fwidth, $fheight, $width_orig, $height_orig);
                                                        
                                                        //put Twizla sign into the picture for preventing copy , dimesion of the sign is 55 x 55,
                                                        //formal big picture to display is 595 x 690, so we shall resize the Twizla sign based on the
                                                        //dimesion of the upload pic
                                                        $twizlaSign = imagecreatefrompng("../webImages/twatermark.png");

                                                        if($fwidth > $fheight)
                                                        {
                                                            $ratio = $fheight / 690;
                                                        }
                                                        else
                                                        {
                                                            $ratio = $fwidth / 595;
                                                        }
                                                        $signWidth = $ratio * 55;
                                                        $signHeight = $ratio * 55;
                                                        imagecopyresampled ($image_p,  $twizlaSign, ($fwidth - $signWidth), ($fheight - $signHeight), 0,0 , $signWidth, $signHeight, 55 , 55);
                                                        
                                                        //create a small version of the picture to speed up the page, dimesion of the box contain small picture is 110 x 110 px
                                                        if($fwidth > $fheight)
                                                        {
                                                            $ratio = 110 /$fheight;
                                                        }
                                                        else
                                                        {
                                                            $ratio = 110 / $fwidth;
                                                        }

                                                        //gets the new value and applies the percentage, then rounds the value
                                                        $small_fwidth = round($fwidth * $ratio);
                                                        $small_fheight = round($fheight * $ratio);

//                                                        //final check if the  new width and height fit on the box
//                                                        if($width > $targetW)
//                                                        {
//                                                            $percentage = ($targetW / $width);
//                                                            $width = round($width * $percentage);
//                                                            $height = round($height * $percentage);
//                                                        }
//                                                        else if($height > $targetH)
//                                                        {
//                                                            $percentage = ($targetH / $height);
//                                                            $width = round($width * $percentage);
//                                                            $height = round($height * $percentage);
//                                                        }
							$small_image_p = imagecreatetruecolor($small_fwidth, $small_fheight);
							imagefill($small_image_p, 0, 0, $white);
                                                        imagecopyresampled($small_image_p, $image, 0, $top_offset, 0, 0, $small_fwidth, $small_fheight, $width_orig, $height_orig);

							switch($filetype)
                                                        {
								case "gif":
									if(!imagegif($image_p, $save) || !imagegif($small_image_p, $smallSave)){
										$errorList[]= "PERMISSION DENIED [GIF]";
									}
								break;
								case "jpg":
									if(!imagejpeg($image_p, $save, 100) || !imagegif($small_image_p, $smallSave, 100)){
										$errorList[]= "PERMISSION DENIED [JPG]";
									}
								break;
								case "jpeg":
									if(!imagejpeg($image_p, $save, 100) || !imagegif($small_image_p, $smallSave, 100)){
										$errorList[]= "PERMISSION DENIED [JPEG]";
									}
								break;
								case "png":
									if(!imagepng($image_p, $save, 0) || !imagegif($small_image_p, $smallSave, 0)){
										$errorList[]= "PERMISSION DENIED [PNG]";
									}
								break;
							}

							imagedestroy($image);

						}
                                                else
                                                {
							$errorList[]= "CANNOT MAKE IMAGE IT ALREADY EXISTS";
						}
					}
				}
			}
		}else{
			$errorList[]= "NO FILE SELECTED";
		}
		if(!$match){
		   	$errorList[]= "File type isn't allowed: $filename";
		}

		if(sizeof($errorList) == 0){
			return "uploads/".$newfilename;
		}else{
			$eMessage = array();
			for ($x=0; $x<sizeof($errorList); $x++){
				$eMessage[] = $errorList[$x];
			}
		   	return $eMessage;
		}
	}

	$filename = strip_tags($_REQUEST['filename']);
	$maxSize = strip_tags($_REQUEST['maxSize']);
	$maxW = strip_tags($_REQUEST['maxW']);
	$fullPath = strip_tags($_REQUEST['fullPath']);
	$relPath = strip_tags($_REQUEST['relPath']);
	$colorR = strip_tags($_REQUEST['colorR']);
	$colorG = strip_tags($_REQUEST['colorG']);
	$colorB = strip_tags($_REQUEST['colorB']);
	$maxH = strip_tags($_REQUEST['maxH']);
        $uploadedList = $_REQUEST['uploadedList'];

	$filesize_image = $_FILES[$filename]['size'];
        $upload_image ="";
	if($filesize_image > 0){
		$upload_image = uploadImage($filename, $maxSize, $maxW, $fullPath, $relPath, $colorR, $colorG, $colorB, $maxH);
		if(is_array($upload_image)){
			foreach($upload_image as $key => $value) {
				if($value == "-ERROR-") {
					unset($upload_image[$key]);
				}
			}
			$document = array_values($upload_image);
			for ($x=0; $x<sizeof($document); $x++){
				$errorList[] = $document[$x];
			}
			$imgUploaded = false;
		}else{
			$imgUploaded = true;
		}
	}else{
		$imgUploaded = false;
		$errorList[] = "File Size Empty";
	}
?>

<script>
        displayAddImageButton();
    </script>
<?php
        
	if($imgUploaded)
        {
                //display big picture
                include_once '../imageResize.inc.php';
                $imageSize = getimagesize($PROJECT_PATH.$upload_image);
                echo "<div id='bigPictureBox' >";
//                echo imageResize($imageSize[0],$imageSize[1], 160);
		echo "<img id='picture' src='".$PROJECT_PATH.$upload_image."' alt='picture' ".imageResize($imageSize[0],$imageSize[1],160, 275)."/>";

                echo "</div>";
//                echo "<input type='hidden' id='uploadPath' value='".$upload_image."'/>";
	}
        else{
                echo "<div id='bigPictureBox'>";
		echo '<img src="'.$PROJECT_PATH.'webImages/error.gif" width="26" height="26px"  style="margin-bottom: -3px;" /> Error(s) Found: ';
		foreach($errorList as $value){
	    		echo $value.', ';
		}
                echo "</div>";
	}
        //set the picture to the small panel underneath the big picture
        $numberOfUploaded = 0;
        $fullUpload = false;
        echo "<ul id='smallListingPics'>";
        //display uploaded pictures
        if(strlen($uploadedList) > 0)
        {
            //Separate the string and display them
            $link = strtok($uploadedList,'|');
            $numberOfUploaded ++;
            $imageSize = getimagesize($link);
            echo "<li>
                    <input type='hidden' id='resize_smallPic".$numberOfUploaded."' value='".imageResize($imageSize[0],$imageSize[1],  160, 275)."' />
                    <img id='smallPic".$numberOfUploaded."' class='smallPic' src='".$link."'  ".imageResize($imageSize[0],$imageSize[1],  44, 41)." alt='smallpic' onclick='setBigPicture(this)' onmousemove='displayMiniCross($numberOfUploaded)' onmouseout='hideMiniCross($numberOfUploaded)' />
                    <img id='removePictureButton".$numberOfUploaded."' class='removePictureButton' src='".$PROJECT_PATH."webImages/miniMinus.png' onclick='removePicture($numberOfUploaded)'  onmousemove='displayMiniCross($numberOfUploaded)' onmouseout='hideMiniCross($numberOfUploaded)'/>
                    </li>";

            while(is_string($link))
            {
                $link = strtok("|");
                if($link)
                {
                    $numberOfUploaded ++;
                    $imageSize = getimagesize($link);
                    echo "<li>
                            <input type='hidden' id='resize_smallPic".$numberOfUploaded."' value='".imageResize($imageSize[0],$imageSize[1],  160, 275)."' />
                            <img id='smallPic".$numberOfUploaded."' class='smallPic' src='".$link."'  ".imageResize($imageSize[0],$imageSize[1],  44, 41)." alt='smallpic' onclick='setBigPicture(this)'  onmousemove='displayMiniCross($numberOfUploaded)' onmouseout='hideMiniCross($numberOfUploaded)'/>
                            <img id='removePictureButton".$numberOfUploaded."' class='removePictureButton' src='".$PROJECT_PATH."webImages/miniMinus.png' onclick='removePicture($numberOfUploaded)'  onmousemove='displayMiniCross($numberOfUploaded)' onmouseout='hideMiniCross($numberOfUploaded)' />
                            </li>";

                }
                //check if the maximum number of picture is reached, if reached then replace the last uploaded picture with the current uploaded pic
                if($numberOfUploaded == 5 AND $imgUploaded)
                {
                    $numberOfUploaded ++;
                    $imageSize = getimagesize($PROJECT_PATH.$upload_image);
                    echo "<li>
                            <input type='hidden' id='resize_smallPic".$numberOfUploaded."' value='".imageResize($imageSize[0],$imageSize[1],  160, 275)."' />
                            <img id='smallPic".$numberOfUploaded."' class='smallPic' src='".$PROJECT_PATH.$upload_image."'  ".imageResize($imageSize[0],$imageSize[1],  44, 41)." alt='smallpic' onclick='setBigPicture(this)'  onmousemove='displayMiniCross($numberOfUploaded)' onmouseout='hideMiniCross($numberOfUploaded)'/>
                            <img id='removePictureButton".$numberOfUploaded."' class='removePictureButton' src='".$PROJECT_PATH."webImages/miniMinus.png' onclick='removePicture($numberOfUploaded)'  onmousemove='displayMiniCross($numberOfUploaded)' onmouseout='hideMiniCross($numberOfUploaded)' />
                            </li>";
                    $fullUpload = true;
                    break;
                }
            }
        }

        if(!$fullUpload)
        {
            if($imgUploaded)
            {
                //adding the current uploading picture
                $numberOfUploaded ++;
                $imageSize = getimagesize($PROJECT_PATH.$upload_image);
                echo "<li>
                        <input type='hidden' id='resize_smallPic".$numberOfUploaded."' value='".imageResize($imageSize[0],$imageSize[1],  160, 275)."' />
                        <img id='smallPic".$numberOfUploaded."' class='smallPic' src='".$PROJECT_PATH.$upload_image."'  ".imageResize($imageSize[0],$imageSize[1],  44, 41)." alt='smallpic' onclick='setBigPicture(this)'  onmousemove='displayMiniCross($numberOfUploaded)' onmouseout='hideMiniCross($numberOfUploaded)'/>
                        <img id='removePictureButton".$numberOfUploaded."' class='removePictureButton' src='".$PROJECT_PATH."webImages/miniMinus.png' onclick='removePicture($numberOfUploaded)'  onmousemove='displayMiniCross($numberOfUploaded)' onmouseout='hideMiniCross($numberOfUploaded)' />
                        </li>";
            }

            //fill up the rest with empty panel, start with the next panel number (1 + $numberOfUploaded)
            for($count = (1 + $numberOfUploaded); $count < 7; $count++)
            {
                echo "<li><img id='smallPic".$count."' class='smallPic' src='".$PROJECT_PATH."webImages/smallPicBG.jpg' style='width: 41px; height: 44px;' alt=''/></li>";
            }

            echo "</ul>";
        }

?>
