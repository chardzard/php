<head>
	<title>Society Survey</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<style>
		.error {
			color: #FF0000;
		}
		.red{
			border: 1px solid red;
		}
	</style>
</head>
<?php
$nameErr = $messErr = $satErr = $ideaErr = $selectErr = $emailErr = "";
$name = $mess = $sat = $idea = $select = $email = "";
$err = false;
if($_SERVER["REQUEST_METHOD"] == "POST") {
	if(empty($_POST["name"])) {
		$nameErr = "No name input";
		$nameErrBool = true;
		$err = true;
	} else {
		$name = $_POST["name"];
	}
	
	if(empty($_POST["message"]) && stristr($_POST["message"], "validated") != false) {
		$messErr = "Message not validated";
		$messErrBool = true;
		$err = true;
	} else {
		$mess = $_POST["message"];
	}
	
	if(empty($_POST["satisfied"])) {
		$satErr = "No satisfaction selected";
		$satErrBool = true;
		$err = true;
	} else {
		$sat = $_POST["satisfied"];
	}
	
	if(sizeof($_POST["idea"]) < 2) {
		$ideaErr = "Need at least 2 suggestions";
		$ideaErrBool = true;
		$err = true;
	} else {
		$idea = $_POST["idea"];
		$n = count($idea);
		$ideas = "";
		for($i=0; $i<$n; $i++)
		{
			$ideas = $ideas . $idea[$i] . ", ";
		}
	}
	
	if(empty($_POST["select"])) {
		$selectErr = "No name input";
		$selectErrBool = true;
		$err = true;
	} else {
		$select = $_POST["select"];
	}
	
	if(!$err) {
		$body = $name . " | " . $mess . " | " . $sat . " | " .$ideas . " | " . $select . "\n";
		
		$fo = fopen("storage.txt", 'a') or die("Failed to open");
		fwrite($fo, $body) or die("Could not write");
		fclose($fo);
		
		if(!empty($_POST["email"])) {
			if(empty($_POST["emailText"])) {
				$emailErr = "No email address input";
				$emailErrBool = true;
				$err = true;
			} else {
				$email = $_POST["emailText"];
				mail($email, "form", $body);
			}
		}
	}
	
}	
?>
<body>
	<h1>INFX 2670 Assignment 1</h1>
	<h3>Society Survey</h3>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<div>			
			<label for="name">Your name: </label>
			<span class="error">* <?php echo $nameErr;?></span><br>
			<input type="text" name="name" class='<?php echo ($nameErrBool)?"red":""; ?>' value='<?php if(!empty($name)) echo $name; ?>'>	
						
		</div>
		<div>
			<label for="message" class='<?php echo ($messErrBool)?"red":""; ?>'>Is there anything more your society can do for you?</label>
			<span class="error">* <?php echo $messErr;?></span><br>
			<textarea name="message"><?php if(!empty($mess)) echo $mess; ?></textarea>
		</div>
		<div>
			<label for="satisfaction" class='<?php echo ($satErrBool)?"red":""; ?>'>How satisfied are you with the society? </label>
			<span class="error">* <?php echo $satErr;?></span><br>
			<input type="radio" name="satisfied" value="very" <?php if (isset($sat) && $sat == "very") echo "checked"; ?>>Very Satisfied</input><br>
			<input type="radio" name="satisfied" value="some" <?php if (isset($sat) && $sat == "some") echo "checked"; ?>>Somewhat Satisfied</input><br>
			<input type="radio" name="satisfied" value="not" <?php if (isset($sat) && $sat == "not") echo "checked"; ?>>Not Satisfied</input><br>
		</div>
		<div>
			<label for="suggestions" class='<?php echo ($ideaErrBool)?"red":""; ?>'>What would you like to see us do? </label>
			<span class="error">* <?php echo $ideaErr;?></span><br>
			<input type="checkbox" name="idea[]" value="A" <?php if(isset($_POST['idea']) && is_array($_POST['idea']) && in_array('A', $_POST['idea'])) echo 'checked="checked"'; ?>>Stuff and things</label><br>
			<input type="checkbox" name="idea[]" value="B" <?php if(isset($_POST['idea']) && is_array($_POST['idea']) && in_array('B', $_POST['idea'])) echo 'checked="checked"'; ?>>Stuff and things</label><br>
			<input type="checkbox" name="idea[]" value="C" <?php if(isset($_POST['idea']) && is_array($_POST['idea']) && in_array('C', $_POST['idea'])) echo 'checked="checked"'; ?>>Stuff and things</label><br>
		</div>
		<div>
			<label for="see" class='<?php echo ($selectErrBool)?"red":""; ?>'>How often would you like to see your society executive? </label>
			<span class="error">* <?php echo $selectErr;?></span><br>
			<select name="select">
				<option value="always" <?php if (isset($select) && $select == "always") echo "selected"; ?>>Always</option>
				<option value="sometimes" <?php if (isset($select) && $select == "sometimes") echo "selected"; ?>>Sometimes</option>
				<option value="never" <?php if (isset($select) && $select == "never") echo "selected"; ?>>Never</option>
			</select><br>
		</div>
		<div>
			<input type="checkbox" name="email" value="email" <?php if (isset($_POST["email"])) echo "checked='checked'"; ?>>Send results via email</input><br>			
		</div>
		<div>			
			<input type="text" name="emailText" class='<?php echo ($emailErrBool)?"red":""; ?>' value='<?php if(!empty($emailText)) echo $emailText; ?>'>
			<span class="error">* <?php echo $emailErr;?></span><br>
		</div>
		<div>
			<button type="submit">Submit</button>
		</div>
	</form>
	<label>Name: </label><?php if($err == false) {
									echo "\t" . htmlspecialchars($name);
								}?>
	<br>
	<label>Message: </label><?php if($err == false) {
									echo "\t" . htmlspecialchars($mess);
								}?>
	<br>
	<label>Satisfied: </label><?php if($err == false) {
									echo "\t" . htmlspecialchars($sat);
								}?>
	<br>
	<label>Suggestions: </label><?php if($err == false) {
									echo "\t" . htmlspecialchars($ideas);
								}?>
	<br>
	<label>Selection: </label><?php if($err == false) {
									echo "\t" . htmlspecialchars($select);
								}?>
	<br>
</body>