<?php
require_once("class.mysql.php");
require_once("class.questionnaire.php");
require_once("class.question.php");

$sql = new MySQL;
$questionnaire = new Questionnaire($sql);
$question = new Question($sql);


//если нажали кнопку отправить
if (isset($_POST["qid"]) && is_numeric($_POST["qid"])) {
	$qid = $sql->link->real_escape_string($_POST["qid"]);
	
	//если поменяли имя
	if (isset($_POST["qname"])) {
		$newqname = $sql->link->real_escape_string($_POST["qname"]);
		$query = 'UPDATE questionnaires SET name="'.$newqname.'"';
		$sql->Query($query);
	}
	
	//добавили вопросы
	if (isset($_POST["question"])) {
		for ($i = 0; $i<count($_POST["question"]); $i++) {
			$text = $sql->link->real_escape_string($_POST["question"][$i]);
			$query = 'INSERT INTO questions (text, id_questionnaire) VALUES ("'.$text.'", '.$qid.')';
			$sql->Query($query);
		}
	}
	header("Location:edit.php?qid=".$qid);
}

//если перешли по ссылке
if (isset($_GET["qid"]) && is_numeric($_GET["qid"])) {
	$qid = $sql->link->real_escape_string($_GET["qid"]);

	if (isset($_GET["action"]) && is_numeric($_GET["quid"])) {
		$quid = $sql->link->real_escape_string($_GET["quid"]);
		switch ($_GET["action"]) {
			case 'remove':
				$question->remove($_GET["quid"]);
				header("Location:edit.php?qid=".$qid);
		}
	}
	
		//TODO::вывод списка параметров.
	
	$qname = $sql->Query("SELECT name FROM questionnaires WHERE id=".$qid);
	$qname = $qname["0"]["name"];
	$questions = $sql->Query("SELECT * FROM questions WHERE id_questionnaire=".$qid);
?>
<!doctype html>
<html>
  <head>
    <title>Редактирование опроса</title>
    <meta charset="utf-8" />
	<script type="text/javascript" src="jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			$('#add').click(function() {
				$('<li><input name="question[]" value="" size="60"/></li>').fadeIn('slow').appendTo('#qlist');
			});
		});
	</script>
  </head>
  <body><br /><br />
	<h1>Редактирование опроса </h1>
	<form method="post" >
	<input type="hidden" name="qid" value="<?php echo $qid; ?>" />
		<h3>Название опроса:</h3>
		<input type="text" name="qname" size="60" value="<?php echo $qname; ?>" />
		<div class="questions">
			<ul id="qlist">
			<?php
				if (isset($_GET["action"]) && $_GET["action"]) == 'new') {
				}
					if ($questions != null) {
					foreach ($questions as $q) {
			?>
					<li><a href="#"><?php echo $q["text"]; ?></a> >>> >>> <a href="edit.php?qid=<?php echo $qid; ?>&quid=<?php echo $q["id"]; ?>&action=edit" class="del">Редактировать</a> ||| <a href="edit.php?qid=<?php echo $qid; ?>&quid=<?php echo $q["id"]; ?>&action=remove" class="del">Удалить</a></li>
			<?php
			}
		} else {
			echo '<p class="note">К сожалению, в этом опросе нет вопросов.</p>';
		}
		?>
			</ul>
		</div>
		<p class="addquestion"><a href="#add" id="add">Добавить вопрос</a></p></div><?php
}
		?>
			<br />
		<input type="submit" class="submit" width="75"/>
	</form>
	<a href="admin.php">Назад, к списку вопросов</a>
  </body>
</html>