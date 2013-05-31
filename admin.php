<?php
define('LOCKER', 'Yep');

require_once("class.mysql.php");
require_once("class.questionnaire.php");

$sql = new MySQL;
$questionnaire = new Questionnaire($sql);
if (isset($_GET["qid"]) && is_numeric($_GET["qid"]) && isset($_GET["action"])) {
	$qid = $_GET["qid"];
	switch ($_GET["action"]) {
		case 'close':
		$questionnaire->closeq($qid);
		header("Location:admin.php");
		break;
		
		case 'activate':
		$questionnaire->activate($qid);
		header("Location:admin.php");
		break;
		
		case 'remove':
		$questionnaire->remove($qid);
		header("Location:admin.php");
		break;
	}
}



$qactive = $questionnaire->getList('active');
$qdraft = $questionnaire->getList('draft');
$qclosed = $questionnaire->getList('closed');


?>
<!doctype html>
<html>
  <head>
    <title>Админка</title>
    <meta charset="utf-8" />
  </head>
  <body><br /><br />
	<h2>Активный опрос</h2>
	<ul>
		<?php
		if (isset($qactive)) {
			foreach ($qactive as $qa) {
				echo '<li><strong> '.$qa["name"].' </strong><a href="res.php?qid='.$qa["id"].'">Результаты опроса</a> ||| <a href="admin.php?qid='.$qa["id"].'&action=close">Закрыть опрос</a> ||| <a href="admin.php?qid='.$qa["id"].'&action=remove">Удалить опрос</a></li>';
				}
		} else {
			echo '<li>пусто</li>';
		}
		?>
		
	</ul>
	<h2>Черновики</h2>
	<ul>
		<?php
			if (isset($qdraft)) {
				foreach ($qdraft as $qd) {
					echo '<li><strong>'.$qd["name"].'</strong> <a href="edit.php?qid='.$qd["id"].'">Редактировать опрос</a> ||| <a href="admin.php?qid='.$qd["id"].'&action=activate">Активировать опрос</a> ||| <a href="admin.php?qid='.$qd["id"].'&action=remove">Удалить опрос</a></li>';
				}
			} else {
				echo '<li>пусто</li>';
			}
		?>
	</ul>
	<h2>Закрытые</h2>
		<ul>
		<?php
			if (isset($qclosed)) {
				foreach ($qclosed as $qc) {
					echo '<li>'.$qc["name"].'</li> <a href="res.php?qid='.$qc["id"].'">Результаты опроса</a> ||| <a href="admin.php?qid='.$qc["id"].'&action=activate">Активировать опрос</a> ||| <a href="admin.php?qid='.$qc["id"].'&action=remove">Удалить опрос</a>';
				}
			} else {
				echo '<li>пусто</li>';
			}
		?>
	</ul>
	
	<a href="edit.php?action=new">Создать новый опрос</a>
  </body>
</html>