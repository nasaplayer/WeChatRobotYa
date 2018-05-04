<?php
/*
** @描述 php特性与mysqli构造智能数据库插入类,根据表结构自适应参数类型
** 
** @作者 百万强心剂 <nasaplayer@qq.com> 
** @最新修改 2018年5月3日17:11  (2018年3月11日起)
** @版本要求 PHP5.6+ 用到了... 操作符
** 
*/
class myDB{
	
	public $tableName = '';
	
	public function __construct($tableName){
		$this->tableName = $tableName;
	}
	
public function db(){
	$config = array(
		'host'=>'115.159.98.27',
		'user'=>'root',
		'password'=>'12345678',
		'database'=>'test',
		'port'=>3306,
	);
	$set = array_values($config);
	$mysqli = new mysqli(...$set);
//	$query = 'SET NAMES UTF8';
//	$mysqli->query($query);
	
	if($mysqli->errno){
		printf("连接数据库错误<br/> %s",$mysqli->error);
		exit;
	}
	return $mysqli;
}
	
	public function add($data){
		$mysqli = $this->db();
		
		$tableName = $this->tableName;
		$dataArr = $this->filterFromTable($tableName,$data);
		
		
		$this->co($dataArr);
		
		//获得$sql ,$typeList,$needData
		extract($dataArr);
		
		$stmt = $mysqli->stmt_init();  
		
		$stmt->prepare($sql);
		
		$stmt->bind_param($typeList,...$needData);
	
		if ( $result = $stmt->execute() ){ 
			$insert_id = $stmt->insert_id;
			echo "成功插入ID".$insert_id;
		}else {  
		    echo "执行失败".$stmt->errno;
		    echo '</br>';
		    echo $stmt->error;  
			$insert_id = 0;
			
		}
		return $insert_id;
	}	
	
	public function filterFromTable($tableName,$data){
		
		$sqlField = '';//字段:  a,b,c
		$sqlQ = '';//问号:  ?,?,?
		$typeList = '';//字段的类型: ssdib 
		$needData = array();
		//根据表结构获取字段类型列表
		$fieldTypeArr = $this->fieldTypeArr($tableName);
		
		$this->co($fieldTypeArr);
		
	//第一种、循环数据表存在字段
		foreach($fieldTypeArr as $field=>$type){
			$param = @$data[$field]??'编程夜未眠';//传入参数存在该字段
			if($param != '编程夜未眠'){
				$sqlField .= $field.',';
				$sqlQ .= '?,';
				
				$typeList .= $type;
				$needData[] = $param;
			}
		}
	
		
	//第二种、循环输入参数数组
//		foreach($data as $key=>$param){
//			$type =  @$fieldTypeArr[$key];
//			if(!empty($type)){//类型存在数据库表
//				$sqlField .= $key.',';
//				$sqlQ .= '?,';
//				
//				$typeList .= $type;
//				$needData[] = $param;
//			}
//		}
		
		$sqlField = substr( $sqlField,0,strlen($sqlField)-1 ); 
		$sqlQ = substr( $sqlQ,0,strlen($sqlQ)-1 ); 
		
		$sql = "INSERT INTO {$tableName}({$sqlField}) 
		VALUES({$sqlQ})";
		
		$dataArr = array(
			'sql'=>$sql,
			'typeList'=>$typeList,
			'needData'=>$needData,
		);
		
		return $dataArr;
	}
	
	public function fieldTypeArr($tableName){
		$arr= array();
		
		$mysqli = $this->db();
		$sql = "DESC {$tableName}";
		
		$result_obj = $mysqli->query($sql);
		
		while($row = $result_obj->fetch_object() ){
			
			$type = $row->Type;
			$field= $row->Field;
			$str = $this->oneFieldType($type);
			$arr[$field] = $str;
			
		}
		
		$mysqli->close();
		
		return $arr;
	}
	
	public function oneFieldType($type){
		$str = '';
		
		if(strstr($type,'int')){
			$str = 'i';
		}else if( strstr($type,'float') || strstr($type,'decimal') || strstr($type,'double')   ){
			$str = 'd';
		}else if( strstr($type,'blob') ){
			$str = 'b';
		}else{
			$str = 's';
		}
		return $str;
	}
	
	public function co($value){
/* 		echo '<pre>';
		print_r($value);
		echo '</pre>'; */
	}
	
}//End Class

?>