<?php
Class Question {
	private $name;
	private $type;
	private $sql;
	
	function __construct($sql) {
		$this->sql = $sql;
	}
	
	public function getQuestion($quid) {
		$result = $this->sql->Query("SELECT * FROM questions WHERE id='".$quid."'");
		return $result;
	}
	
	public function add() {
			echo '<div class="question">
				<h3>Вопрос № <?php echo $question->id; ?></h3>
				<input type="hidden" name="id[]" value="<?php echo $question->id;?>" />
				<input type="text" name="text[]" value="<?php echo $question->text; ?>" size="60" />
				<input type="checkbox" name="several[]" <?php if ($question->checkbox == "checked") echo "checked"; ?>/> Несколько вариантов ответа <br />
				<input type="checkbox" name="required[]" <?php if ($question->required == "yes") echo "checked"; ?> /> Обязательный
				<h3>Варианты ответов(в столбик)</h3>
				<textarea name="answers[]" cols="75" rows="10"><?php
				$variants = $sql->Query("SELECT * FROM variants WHERE id_question=".$question->id);
				if ($variants != null) {
					foreach ($variants as $variant) {
						echo $variant->text."\n";
					}
				}
				?></textarea>
			</div>';
			$list = explode("\n", $_POST["answers"][$i]);
		$newid = $sql->link->insert_id;
		foreach ($list as $element) {
			echo $element.'<br />';
			$query = 'INSERT INTO variants (text, id_question) VALUES ('.$element.', '.$newid.')';
			var_dump($query);
			//echo $sql->Query($query);
		}
	}
	
	public function remove($quid) {
		$result = $this->sql->Query("DELETE FROM questions WHERE id='".$quid."'");
		return $result;
	}
	
}



?>