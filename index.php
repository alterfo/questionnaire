<?php

require_once("class.mysql.php");
require_once("class.questionnaire.php");

$sql = new MySQL;
$questionnaire = new Questionnaire($sql);

$qactive = $questionnaire->getList('active');

?>
<!doctype html>	
<html>
  <head>
    <title>Опрос <?php echo $qactive["0"]["name"]; ?></title>
    <meta charset="utf-8" />
  </head>
  <body><br /><br />
		<?php
			echo $questionnaire->showactive($qactive);
		?>
  </body>
</html>