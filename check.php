<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title></title>
<meta name="Keywords" content=" ">
<meta name="Description" content=" ">

<!--[if lt IE 9]>
<script src="common/js/html5shiv.js"></script>
<![endif]-->

<!--[if lte IE 6 ]>
<script src="common/js/DD_belatedPNG.js" charset="utf-8"></script>
<![endif]-->

<link rel="stylesheet" href="common/css/base.css" media="screen,tv,print" />

<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="common/js/script.js"></script>


</head>
<body>
<pre>
<?php
if($_FILES){
	if (move_uploaded_file($_FILES['checkfile']['tmp_name'],'./'.$_FILES['checkfile']['name'])) {
		require_once 'File_Format_Iaf.php';
		$iaf = new File_Format_Iaf();
		
		$iaf->load($_FILES['checkfile']['name']);
		print_r($iaf->getFields());
		
	} else {
		echo 'アップロードに失敗しました。';
	}
	
	unlink('./'.$_FILES['checkfile']['name']);
}
?>
</pre>
</body>
</html>