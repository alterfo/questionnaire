<?php
Class Questionnaire {
	public $name;
	public $status;
	private $sql;
	
	function __construct($sql) {
		$this->sql = $sql;
	}
	
	public function getList($type) {
		$type = $this->sql->link->real_escape_string($type);
		$result = $this->sql->Query("SELECT * FROM questionnaires WHERE status='".$type."'");
		return $result;
	}
	
	
	public function showactive($qactive) {
		if ($qactive != null) {
		$content = "<h3>Опрос «".$qactive["0"]["name"]."»</h3>";
		$questions = $this->sql->Query('SELECT * FROM questions WHERE id_questionnaire='.$qactive["0"]["id"]);
			if ($questions != null) {
				$content .= '<form method="post" action="send.php"><input type="hidden" name="nqid" value="'.$qactive["0"]["id"].'" />';
				foreach ($questions as $question) {
					$variants = $this->sql->Query('SELECT * FROM variants WHERE id_question='.$question["id"]);
					$content .= '<label for="q['.$question["id"].']">'.$question["text"].'</label><br />';
					if ($variants != null) {
						if ($question["checkbox"] == 'true') {
							foreach ($variants as $variant) {
								$content .=  '<input type="checkbox" name="q['.$question["id"].']" value="q['.$question["id"].'v'.$variant["id"].']" />'.$variant["text"].'<br />';
						 	}
						} else { 
							foreach ($variants as $variant) {
								$content .=  '<input type="radio" name="q['.$question["id"].']" value="q['.$question["id"].'v'.$variant["id"].']" />'.$variant["text"].'<br />';
						 	}
						}
					}
				}
			$content .= '<input type="submit" value="отправить" /></form>';
			//вывод списка
			} else {
				$content = "<h3>К сожалению у нас нет активных опросов.</h3>";
			}
		} else {
			$content = "<h3>К сожалению у нас нет активных опросов.</h3>";
		}
		return $content;
	}
	
	
	public function closeq($qid) {
		$qid = $this->sql->link->real_escape_string($qid);
		$result = $this->sql->Query("UPDATE questionnaires SET status='closed' WHERE id='".$qid."'");
		return $result;
	}
	
	
	public function remove($qid) {
		$qid = $this->sql->link->real_escape_string($qid);
		$result = $this->sql->Query("DELETE FROM questionnaires WHERE id='".$qid."'");
		return $result;
	}
	
	
	public function activate($qid) {
		$qid = $this->sql->link->real_escape_string($qid);
		if ($check = $this->getList('active')) {
			$result = "Уже есть один активный вопрос";
		} else {
			$result = $this->sql->Query("UPDATE questionnaires SET status='active' WHERE id='".$qid."'");
		}
		return $result;
	}

	
	public function add() {
		//
	}
	
}

?>