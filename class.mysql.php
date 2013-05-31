<?php
class MySQL {

    // credentials
    private $hostname    = "p:localhost";
    private $username    = "questionnaire";
    private $password    = "questionnaire";
    private $database  = "questionnaire";
    public $link     = 0;
    private $qry      = "";
    private $data;

    function __construct() {
        if (strlen($this->hostname) > 0 && strlen($this->username) > 0)
        {
			$this->link = new mysqli($this->hostname, $this->username, $this->password, $this->database);
			$this->link->set_charset("utf8");
			// check connection
			if ($this->link->connect_error) {
				die('Connect Error ('.$mysqli->connect_errno.') '.$mysqli->connect_error);
        }
        }
    }

    public function Query($qry) {
        $this->qry = $qry;
		$this->data = $this->link->query($this->qry);
			if (!is_bool($this->data)) {
				$return = array();
				while($row = $this->data->fetch_assoc()) {
					$return[] = $row;
				}
			} else $return = null;
        return $return;
    }
	
	public function select($table, $rows = '*', $where = null, $order = null) {
		$q = 'SELECT '.$rows.' FROM '.$table;
		if($where != null) $q .= ' WHERE '.$where;  
        if($order != null) $q .= ' ORDER BY '.$order;
		return $this->Query($q);
	}
	
	public function insert($table, $values, $rows = null) {  
        $insert = 'INSERT INTO '.$table;  
            if($rows != null){  
                $insert .= ' ('.$rows.')';
            }
            for($i = 0; $i < count($values); $i++) {
				if(is_string($values[$i])) $values[$i] = '"'.$values[$i].'"';
            }
            $values = implode(',',$values);
            $insert .= ' VALUES ('.$values.')';
            if($this->Query($insert)) {  
                return true;  
            } else {  
                return false;  
            }  
    }
	
	
    public function __destruct() {
        unset($this->qry);
        unset($this->data);
        unset($this->link);
    }

}
?>