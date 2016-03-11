<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$target_dir_txt = "uploads/txt";
	$target_file_txt = $target_dir_txt . basename($_FILES["text"]["name"]);
	$file_type_txt = pathinfo($target_file_txt, PATHINFO_EXTENSION);
	
	$target_dir_img = "uploads/img";
	$target_file_img = $target_dir_img . basename($_FILES["image"]["name"]);
	$file_type_img = pathinfo($target_file_img, PATHINFO_EXTENSION);
	
	
	if(isset($_POST["submit"])) {
		//text file
		if($file_type_txt == "txt") {
			if(move_uploaded_file($_FILES["text"]["tmp_name"], "uploads/txt/lab2_upload.txt")) {
				echo "Second line of file: ";
				$file = file("uploads/txt/lab2_upload.txt");
				echo $file[1] . "<br>";
				echo "File size: ";
				echo filesize("uploads/txt/lab2_upload.txt");
				echo "<br>";
			}
		}
		else {
			echo "Sorry, not a text file<br>";
		}		
		
		//png file
		if($file_type_img == "png") {
			$check = getimagesize($_FILES["image"]["tmp_name"]);
			if($check != false) {
				if(move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/img/lab2_upload.png")) {
					chmod("uploads/img/lab2_upload.png",0777);
					echo "Image file size: ";
					echo filesize("uploads/img/lab2_upload.png") . "<br>";
					echo '<img src= "uploads/img/lab2_upload.png" height="300" width="300">';
				}
			}
			else {
				echo "error uploading image";
			}
		}
		else {
			echo "File not png<br>";
		}
		$time = time();
		echo "<br>Time of upload: " . date("h:i:sa", $time);
	}
}
?>

<head>
	<title>File Upload</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
	<h1>Upload all dem files</h1>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
		<div>
			<label>Upload text</label>
			<input type="file" name="text" id="text"><br>
			<label>Upload image</label>
			<input type="file" name="image" id="image"><br>
			<button type="submit" name="submit">Upload</button>
		</div>
	</form>
</body>