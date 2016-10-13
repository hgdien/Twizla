<?php
	function uploadVideo($fileName, $maxSize, $maxW, $fullPath, $relPath, $maxH = null){
		$folder = $relPath;
		$maxlimit = $maxSize;
		$allowed_ext = "mp3,avi,swf,mp4,wmv,wmn,wave,flv,mpg";
		$match = "";
		$filesize = $_FILES[$fileName]['size'];
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
						if(!file_exists($save)){

                                                        copy ($_FILES[$fileName]['tmp_name'], $folder.$newfilename) or die ('Could not upload');

						}else{
							$errorList[]= "CANNOT UPLOAD EXISTING VIDEO IT ALREADY EXISTS";
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
			return $relPath.$newfilename;
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
	$maxH = strip_tags($_REQUEST['maxH']);
	$filesize_Video = $_FILES[$filename]['size'];

        $upload_video ="";
	if($filesize_Video > 0){
		$upload_Video = uploadVideo($filename, $maxSize, $maxW, $fullPath, $relPath, $maxH);
		if(is_array($upload_Video)){
			foreach($upload_Video as $key => $value) {
				if($value == "-ERROR-") {
					unset($upload_Video[$key]);
				}
			}
			$document = array_values($upload_Video);
			for ($x=0; $x<sizeof($document); $x++){
				$errorList[] = $document[$x];
			}
			$uploaded = false;
		}else{
			$uploaded = true;
		}
	}else{
		$uploaded = false;
		$errorList[] = "File Size Empty";
	}
?>
<?php

	if($uploaded){

//            echo var_dump($upload_Video);
//
                echo "<input type='hidden' id='uploadedVideo' value='$upload_Video'/>";
                echo "<OBJECT ID='MediaPlayer' width='275' height='160' CLASSID='CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95'
                    STANDBY='Loading Windows Media Player components...' TYPE='application/x-oleobject'>
                    <PARAM NAME='FileName' VALUE='$upload_Video'>
                    <PARAM name='autostart' VALUE='false'>
                    <PARAM name='ShowControls' VALUE='true'>
                    <param name='ShowStatusBar' value='false'>
                    <PARAM name='ShowDisplay' VALUE='true'>
                    <embed  name='MediaPlayer' src='$upload_Video' type='application/x-mplayer2'
                            width='275' height='160' ShowControls='1' ShowStatusBar='0' loop='false' EnableContextMenu='0' DisplaySize='0' Autostart='0'
                            pluginspage='http://www.microsoft.com/Windows/Downloads/Contents/Products/MediaPlayer/'>";
//		echo "<img id='bigPicture' src='$upload_image' border='1' width='275' height='160'";
//                echo "<input type='hidden' id='uploadPath' value='".$upload_image."'/>";
                //successful uploaded, set the picture link hidden field in the
                //main item listing form\
?>
<?php
//        <-script type="text/javascript">
//            var pictureLink = document.getElementById("pictureLink");
//            pictureLink =
//
//        </script>
	}else{
		echo '<img src="webImages/error.gif" width="26" height="26px" border="0" style="marin-bottom: -3px;" /> Error(s) Found: ';
		foreach($errorList as $value){
	    		echo $value.', ';
		}
	}
        echo "<input type='hidden' id='confirmUpload' value='finishedUploading'/>";
?>