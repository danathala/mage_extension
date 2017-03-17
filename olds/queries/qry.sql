$querySelect->join(array('table_name'=>'alias'), ' conditions', array('field_to_select'));
$querySelect->joinLeft(array('table_name'=>'alias'), ' conditions', array('field_to_select'));
$querySelect->joinRight(array('table_name'=>'alias'), ' conditions', array('field_to_select'));