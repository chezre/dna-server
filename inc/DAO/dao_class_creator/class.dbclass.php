<?php

class dbclass extends db {
    function __construct($post) {
		if (empty($post['table'])) return;
		
		$dbConfig = simplexml_load_file('../dbconnection.xml');
		foreach ($dbConfig->children() as $k=>$v) $this->$k = $v;
        $this->connect();
		
        foreach ($post as $k=>$v) $this->$k = $v;
		
		$this->connectionname = 'db'; 
        $this->classname = (!empty($this->prefix)) ? strtolower(preg_replace('/'.$this->prefix.'/','',$this->table)) : strtolower($this->table);
        
        $result = $this->getTableInfo();
        $excl_primary_key_result = array();
        $this->properties = '';
        foreach ($result as $k=>$v) {
            $this->properties .= 'var $'.$v['Field'] . ';' . "\n\t";
            if ($v['Field']!=$this->pk_field) $excl_primary_key_result[] = $v;
        }
        
        $this->updatefields = '';
        $this->insertfields = '';
        $this->insertvalues = '';
        $total_fields = count($excl_primary_key_result);
        $cnt = 1;
        foreach ($excl_primary_key_result as $k => $v) {
            $this->updatefields .= '`'.$v['Field']."` = '\$this->".$v['Field']."'"; 
            $this->updatefields .= ($total_fields!=$cnt) ? ',' ."\n\t\t\t" : '';
            
            $this->insertfields .= '`'.$v['Field'].'`';
            $this->insertfields .= ($total_fields!=$cnt) ? ',' ."\n\t\t\t" : '';
            
            $this->insertvalues .= "'\$this->".$v['Field']."'";
            $this->insertvalues .= ($total_fields!=$cnt) ? ',' ."\n\t\t\t" : '';
            
            $cnt++;
        }
        $this->createClass();
    }
    
    function getTableInfo() {
        $sql = "SHOW COLUMNS FROM `$this->table`";
		$result = $this->select($sql);
        return $result;
    }
    
    function createClass() {
        $patterns = $replacements = array();
        $parent = get_class_vars(get_parent_class($this));
        foreach ($parent as $k=>$v) $parentVars[] = $k;
        foreach ($this as $k=>$v) {
            if (!in_array($k, $parentVars)) {
                $patterns[] = "/###$k###/";
                $replacements[] = $this->$k;
            }
        }
        $content = preg_replace($patterns, $replacements, file_get_contents('template.txt'));   
        $filename = 'class.'.$this->classname.'.php';
        
        header("Cache-Control: no-cache");
        header('Content-type: text/plain');
        header('Content-disposition: attachment; filename='. $filename);
        echo $content;
			
    }
    
    
}