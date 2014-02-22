<?php
/*
		$where[] = array('id = ?' => '10');
		$where[] = array('name = ?' => 'luke');
		echo '<pre>'.print_r($where)."\n";
        foreach ($where as &$term) {
            $term = '(' . $term . ')';
            echo '<pre>',print_r($term);
        }
		echo "\n ========== \n";
		echo $term."\n";
		echo "\n -------- \n";
        $where = implode(' AND ', $where);
        echo '<pre>'.print_r($where)."\n";
*/

/*
$a = array(array(':id'=>'1'),array(':id'=>2));
$a = array('id'=>'1','id1'=>2);
echo implode(':,', array_keys($a));
*/


$dbhost     = "localhost";
$dbname     = "test";
$dbuser     = "root";
$dbpass     = "";
 
// database connection
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);

$id = 60;
$pid = 4;
$name = 'Jack Hijack';

// query
$sql = "INSERT INTO aa (id,pid,name) VALUES (:id,:pid,:name),(:id,:pid,:name)";
$q = $conn->prepare($sql);



//$q->execute(array(array(':id'=>60,':pid' =>4,':name'=>'Jack Hijack'),array(':id'=>3,':pid' =>5,':name'=>'mm')));
//$q->execute(array(':id'=>70,':pid' =>6,':name'=>'Hijack'),array(':id'=>3,':pid' =>5,':name'=>'mm'));

/*
$faculty = array(array('pid' => '4', 'id' => '10', 'name' => 'haha'), array('pid' => '5', 'id' => '20', 'name' => 'haha'));
$faculty = array('pid' => '4', 'id' => '10', 'name' => 'haha', array('pid' => '5', 'id' => '20', 'name' => 'haha'));
$faculty = array('pid' => '4', 'id' => '10', 'name' => 'haha');

if(count($faculty, COUNT_RECURSIVE) != count($faculty))
{
	echo 'multimore array '.count($faculty, COUNT_RECURSIVE).' count : '.count($faculty);
}
else
{
	echo 'simple array ';
}
$array_of_parameters = array();
*/
/*
foreach($faculty as $key=>$val){
        $array_of_parameters[$key] = $val;
        $fields[] = sprintf("%s=?", $key);
}
$field_list = join(',', $fields);


$stmt = $conn->prepare(
	'INSERT INTO fhours ('.implode(",", array_keys($faculty)).')'.
    ' VALUES (:'.implode(",:", array_keys($faculty)).')'.
    ' ON DUPLICATE KEY UPDATE :fieldlist');

$stmt->bindParam(':field_list', $field_list);
*/

/*
foreach($faculty as $key=>$val){
	//$stmt->bindParam(':'.$key, $val);
    $fields[] = sprintf("%s = :%s", $key, $key);
}

echo '<pre>';print_r($fields);
*/

$sql = "INSERT INTO aa ";
$b = array('row'=>'id,pid,name','value'=>array(array(70,6,'Hijack'),array(3,5,'mm')));
//$b = array('row'=>'id,pid,name','value'=>array(70,6,'Hijack'));
foreach( $b as $key => $value)
{
	if($key == 'row')
	{
		$col = '(' . $value . ')';
		$colNames = explode(',', $value);
		foreach ($colNames as $curCol)
			$updateCols[] = $curCol . " = VALUES($curCol)";
	}
	else if($key == 'value')
	{
		$invalue = '';

		foreach($value as $v)
		{
			if(is_array($v))
			{
				$invalue .= '('.implode(',',$v).')';
			}
			else
			{
				$invalue = '('.implode(',',$value).')';
				break;
			}
		}
	}
}
$onDup = implode(', ', $updateCols);

echo $sql.$col.$invalue.' ON DUPLICATE KEY UPDATE '.$onDup;