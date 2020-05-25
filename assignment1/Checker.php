<!DOCTYPE html>
<html>
<head>
	<title>Covronavirus Checker</title>
</head>
<style type="text/css">
	body {
		background-color: rgb(240, 235, 248);
		background-color: #B7FFBF;
		/*font-size: ;*/
		font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif
	}

	h1 {
		text-align: center;
		font-weight: 10;
	}
	
	h2 {
		padding: 0;
		margin: 0;
		font-weight: normal;
		font-size: 20px;
	}

	.description {
		padding: 0;
		margin: 0;
		font-size: 13px;
		color: 	#696969;
	}

	.questions {
		background-color: white;
		display: block;
		width: 640px;
		margin: auto;
		padding: 20px;
		margin-top: 20px;
		border-radius: 10px;
	}
	
	.age {
		margin-top: 20px;
		width: 250px;
		height: 20px;
		border: 0;
		border-bottom: 1.6px ridge;
	}

	.radio {
		margin-top: 20px;
		background-color: white;
		transform: scale(1.5);
	}

	.submit-section {
		background-color: transparent;
		padding-top: 0;
	}

	.submit {
		background-color: rgb(103, 58, 183);
		background-color: #00AB08;
		border-radius: 5px;
 		border: none;
  		color: white;
		padding: 16px 32px;
		text-decoration: none;
	    margin: 4px 2px;
   	    cursor: pointer;
	}

	.results {
		width: 70vw;
		/*height: 70vh;*/
		margin: auto;
		padding: 50px;
		background-color: white;
		text-align: center;
	}

	.table-div {
		margin-bottom: 30px;
	}

	table {
		border-collapse: collapse;
		margin: auto;
	}

	td {
 		border: 1px solid;
  		text-align: left;
  		padding: 18px 28px 18px 28px;
	}

	.yesno {
		text-transform: uppercase;
		text-align: center;
	}

	.title {
		font-weight: 700;
    	font-size: 56px;
    	text-transform: uppercase;
	}

	.smalltitle {
		font-size: 1.5em;
		font-weight: bold;
	}

	.alert {
		color: red;
	}

	.resultdescription {
		font-size: 14px;
	}

	@media (max-width: 640px) {
		.questions{
			width: 80vw;
		}
	}
    
</style>
<body>
<?php
	$questions= array(
		array(
			'name' => 'age',
			'question' => 'Your Age',
			'type' => 'number',
			'result' => 'Age'
		),
		array(
			'name' => 'fever',
			'question' => 'Do you have a fever?',
			'description' => 'Body temperature higher than 37.5 °C.',
			'type' => 'radio',
			'result' => 'Fever More Than 37.5°C'
		),
		array(
			'name' => 'breathless',
			'question' => 'Do you experience difficulty to breath?',
			'description' => 'Shortness of breath, Hard to inhale or exhale.',
			'type' => 'radio',
			'result' => 'Experiencing Shortness of Breath'
		),
		array(
			'name' => 'cough',
			'question' => 'Do you have a cough?',
			'type' => 'radio',
			'result' => 'Coughing'
		),
		array(
			'name' => 'sorethroat',
			'question' => 'Do you have a sore throat?',
			'type' => 'radio',
			'result' => 'Sore Throat'
		),
		array(
			'name' => 'international',
			'question' => 'In the last 14 days, have you traveled internationally?',
			'type' => 'radio',
			'result' => 'Recently Return from Abroad'
		),
		array(
			'name' => 'closecontact',
			'question' => 'Have you had a close contact with a confirmed COVID-19 patient?',
			'description' => 'Close Contact means living together in the same household, travelling together or working together in close proximity.',
			'type' => 'radio',
			'result' => 'Close Contact with COVID-19 Patient'
		)
	);
	$results = array(
		'nosymptoms' => array(
			'title' => 'Your risk for COVID-19 is very minimal at the moment',
			'smalltitle' => 'It looks like you are in a good health condition',
			'description' => 'You do not display any symptoms or have any risks of exposure to any infectious diseases including COVID-19. Do follow our prevention steps to ensure your health stays in good condition. Stay healthy and maintain good hygiene!'
		),
		'showsymptoms' => array(
			'title' => 'Your risk for COVID-19 is very minimal at the moment',
			'smalltitle' => 'Your symptoms may be a related to other health issues.',
			'description' => 'Please monitor your symptoms and seek IMMEDIATE attention from a nearby medical facility if your condition worsens or is prolonged. In the meantime, please follow our prevention steps to reduce your risk of exposure to other illnesses including COVID-19.'
		),
		'travelled' => array(
			'title' => 'No symptoms; Self-quarantine may be required',
			'smalltitle' => 'As you have just returned from high risk areas, you may be required to go through self-quarantine to minimize your risk of exposure to others for a period of 14 days.',
			'description' => 'WARNING: If you are starting to develop FEVER, COUGH, DIFFICULTY BREATHING, OR SORE THROAT, please contact MOH Specialist Doctor or Local Health Authority immediately for further action.'
		),
		'travelledandsymptoms' => array(
			'title' => 'Potential suspect for COVID-19',
			'smalltitle' => 'Based on your answer, it is highly possible that you may have been exposed to COVID-19.',
			'description' => 'Please request to speak to a MOH Specialist Doctor IMMEDIATELY or contact Local Health Authority for further verification about your conditions and required action. WARNING:If this is an EMERGENCY, please call 999 IMMEDIATELY.'
		),
	);
?>
<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST'){
		$answer = '';
		if($_POST['international']==='yes'|| $_POST['closecontact']==='yes'){
			if($_POST['fever']==='yes'||$_POST['breathless']==='yes'||$_POST['cough']==='yes'||$_POST['sorethroat']==='yes'){
				$answer = 'travelledandsymptoms';
			} else{
				$answer = 'travelled';
			}
		} else{
			if($_POST['fever']==='yes'||$_POST['breathless']==='yes'||$_POST['cough']==='yes'||$_POST['sorethroat']==='yes'){
				$answer = 'showsymptoms';
			} else{
				$answer = 'nosymptoms';
			}
		}

?>
	<div class= 'results'>
	<?php
		if($answer==='travelledandsymptoms'){
			echo "<h1 class='title alert'>".$results[$answer]['title']."</h1>
				<video controls='' autoplay='true' name='media'><source src='coffin.mp4' type='video/mp4'></video>
			";
		}	else{
			echo "<h1 class='title'>".$results[$answer]['title']."</h1>";
		}
	?>	
		<p class='smalltitle'><?php echo $results[$answer]['smalltitle']?></p>
		<p class='resultdescription'><?php echo $results[$answer]['description']?></p>
		<div>
			<p>Results:</p>
			<table class="table-div">
			<?php
				foreach ($questions as $key => $value) {
					echo '<tr>	
							<td>'. $value["result"] .'</td>
							<td class="yesno">'. $_POST[$value["name"]] . '</td>
						</tr>';		
				}				
			?>	
			</table>
		</div>
		<div class="refresh-div">
			<a href = 'Checker.php' class='submit' >Redo the test here</a>
		</div>
	</div>
<?php	
	} 
	else{
?>		
	<h1><img src="head.jpg" ></h1>
	<div class="form-div">
		<form action="Checker.php" method="post" class="checker-form">
		<?php  
			// foreach($array as $key => $value)
			foreach ($questions as $key => $value ) {
				if($value['type'] === 'radio'){
					echo '
						<section class="questions">
							<h2>'.$value['question'].'</h2>
						';
					if(isset($value['description'])){
						echo '<p class="description">'.$value['description'].'</p>';
					}	
					echo'
							<input type="radio" name="'.$value['name'].'" class = "radio" value="yes" required> <label for="'.$value['name'].'">Yes</label>
							<br>
							<input type="radio" name="'.$value['name'].'" class = "radio" value="no" required> <label for="'.$value['name'].'">No</label>
						</section>
					';
				}
				else{
					echo '
						<section class="questions">
							<h2>'.$value['question'].'</h2>
							<input type="number" name="'.$value['name'].'" min= "1" max ="99" class="age" required>
						</section>
					';
				}
			};
			
		?>
			<section class="submit-section questions">
					<input type="submit" name="Send" class="submit">
			</section>
		</form>
<!-- 
		<iframe src="https://giphy.com/embed/j6ZlX8ghxNFRknObVk" width="480" height="270" frameBorder="0" class="giphy-embed" allowFullScreen></iframe><p><a href="https://giphy.com/gifs/jason-clarke-dancing-pallbearers-ghana-pallbearer-meme-j6ZlX8ghxNFRknObVk">via GIPHY</a></p> -->
		<!-- <embed src="coffin-dance.mp4"></embed> -->
	</div>		
<?php		
	}
?>
</body>

<script type="text/javascript">
	console.log(document.getElementsByTagName('video'));
	document.getElementsByTagName('video')[0].volume = 0.5;
	window.addEventListener('onload', ()=>{
		document.getElementsByTagName('video')[0].play()
;	})
</script>
</html>