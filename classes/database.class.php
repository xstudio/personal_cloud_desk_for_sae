<?php
    /**
     * ==================================================================================
     * 封装的Msqli操作类，包括数据表的增加、删除、更新、及查询操作
     * 可实现的查询有：普通查询、聚集函数查询
     * 复杂的SQL语句或者一组SQL语句，可尝试使用execs()函数执行
     * ==================================================================================
     * $Author： 小笙$
     * $Date：2012-11-14 $
     * ==================================================================================
     */
    class DataBase{

        private $mysqli;                //mysqli操作对象
        private $tableName;             //定义需要操作的表名
        private $set_arr=array();       //更新数据表中的字段
        private $select_val;            //需要查询的字段[array]或使用的聚集函数[string]
        private $order='';              //定义查询的默认排序
        private $group='';              //定义查询的分组排序
        private $where_case='';         //定义数据查询条件字符串
        private $limit_str='';          //定义limit查询的限制条数
        private $bind_param=array();    //绑定变量
        private $types='';              //绑定变量的类型

		//构造方法，对象被创建时自动连接数据库
		public function __construct(){
			$this->mysqli=@new mysqli(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS,SAE_MYSQL_DB);
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				$this->mysqli=FALSE;
   				exit();
			}
        }
        /**
         * 功能描述：清空所有私有属性的值，在每次增删改查执行成功后调用
         * 以便不干扰下一次的数据表操作
         */
        private function clear(){
            $this->tableName=$this->insert_value=$this->select_val=$this->order=$this->group=$this->where_case=$this->limit_str=$this->types='';
            $this->set_arr=$this->bind_param=array();
        }
        /**
         * 参数：表名 类型：字符串
         * 为私有属性$tableName赋值 以确定要插入数据的表
         * 返回值为$this
         */
        public function INSERT_INTO($tableName){
            $this->tableName=PRETABLE.$tableName;
            return $this;
        }
        /**
         * 参数：表名 类型：字符串
         * 为私有属性$tableName赋值 以确定要查询数据的表
         * 返回值为$this
         */
        public function FROM($tableName){
            $this->tableName=PRETABLE.$tableName;
            return $this;
        }
        /**
         * 参数：表名 类型：字符串
         * 为私有属性$tableName赋值 以确定要删除数据的表
         * 返回值为$this
         */
        public function DELETE_FROM($tableName){
            $this->tableName=PRETABLE.$tableName;
            return $this;
        }
        /**
         * 参数：需要向数据表中插入的数据 类型：数组
         * 返回值：$this
         */
        public function VALUES($arr=array()){
            $this->bind_param=$arr;
            return $this;
        }
        /**
         * 参数：$key=>数据表中的字段名 $value=>更新的新值 类型：数组
         * 返回值：$this
         */
        public function SET($arr=array()){
            $this->set_arr=$arr;
            return $this;
        }
        /**
         * 功能描述：运算关系转换，为WHERE()、OR()、AND()函数辅助函数
         * 参数：1、需拆分的字符串 2、连接条件 可空
         *
         */
        private function setCase($str, $case=''){  
            if(strpos($str, '>=')!==false){
                $arr=explode('>=', $str);
                $this->where_case.=$case.$arr[0].'>=? ';
                array_push($this->bind_param, $arr[1]);
                $this->types.='s';
            }else if(strpos($str, '<=')!==false){
                $arr=explode('<=', $str);
                $this->where_case.=$case.$arr[0].'<=? ';
                array_push($this->bind_param, $arr[1]);
                $this->types.='s';
            }else if(strpos($str, '!=')!==false){
                $arr=explode('!=', $str);
                $this->where_case.=$case.$arr[0].'!=? ';
                array_push($this->bind_param, $arr[1]);
                $this->types.='s';
            }else if(strpos($str, '=')!==false){
                $arr=explode('=', $str);
                $this->where_case.=$case.$arr[0].'=? ';
                array_push($this->bind_param, $arr[1]);
                $this->types.='s';
            }else if(strpos($str, '>')!==false){
                $arr=explode('>', $str);
                $this->where_case.=$case.$arr[0].'>? ';
                array_push($this->bind_param, $arr[1]);
                $this->types.='s';
            }else if(strpos($str, '<')!==false){
                $arr=explode('<', $str);
                $this->where_case.=$case.$arr[0].'<? ';
                array_push($this->bind_param, $arr[1]);
                $this->types.='s';
            }else if(strpos($str, 'like')!==false){
                $arr=explode('like', $str);
                $this->where_case.=$case.$arr[0].'like ?';
                array_push($this->bind_param, '%'.trim($arr[1]).'%');
                $this->types.='s';
            }
        }
        /**
         * 参数：WHERE字句紧跟查询条件 类型：数组
         * 返回值：$this
         */
        public function WHERE($case, $arr=array()){
            $this->setCase($case);
            if(!empty($arr)){
                foreach($arr as $key=>$val){
                    if($key=='AND'||$key=='and'){
                        $this->setCase($val, 'AND ');
                    }else if($key=='OR'||$key=='or'){
                        $this->setCase($val, 'OR ');
                    }
                }
            }
            return $this;
        }
        /**
         * 参数：定义数据数据查询的排序方式 类型：字符串
         * 返回值：$this
         */
        public function ORDER_BY($val){
            $this->order=$val;
            return $this;
        }
        /**
         * 参数：定义数据数据分组查询的排序方式 类型：字符串
         * 返回值：$this
         */
        public function GROUP_BY($val){
            $this->group=$val;
            return $this;
        }
        /**
         * 参数：定义数据查询的限制条数 类型：字符串
         * 返回值：$this
         */
        public function LIMIT($val){
            $this->limit_str=$val;
            return $this;
        }
        /**
         * 用户执行一组SQL语句
         * 1、参数：一条SQL语句 数据类型：字符串
         * 2、参数：一组SQL语句 数据类型：数组
         * 返回值：无
         */
        public function execs($sqls){
            $result=FALSE;
            if(is_array($sqls)){
                $i=0;
                foreach($sqls as $sql){
                    if($this->mysqli->query($sql)){
                        $i++;
                    }
                }
                if($i===count($sqls)) $result=TRUE;
            }else{
                if($this->mysqli->query($sqls)){
                    $result=TRUE;
                }
            }   
            return $result;
        }
        /**
         * 功能描述：返回操作影响的行数
         * 为INSERT()、DELETE()、UPDATE()函数共用
         */
        private function affected_rows($sql, $bind_val, $val_type){
            if($stmt=$this->mysqli->prepare($sql)){
				$this->_bindParams($stmt,$bind_val,(array)$val_type);
                if($stmt->execute()){
                    $this->clear();
					return $stmt->affected_rows;
				}
			}
        }
		/**
		 * 功能描述：插入一条记录
		 * 返回值：影响行数
	     */
        public function INSERT(){
			$tabVal='';	    //表明后所跟字符串
			$strVal='';	    //value值
			foreach($this->bind_param as $key=>$val){
				$tabVal.=$key.',';
				$strVal.='?,';
				$this->types.='s';	
			}
			$tabVal=substr($tabVal,0,strlen($tabVal)-1);
			$strVal=substr($strVal,0,strlen($strVal)-1);
            $sql="INSERT INTO $this->tableName($tabVal) values ($strVal)";
            //echo $sql;echo gettype( $this->bind_param); print_r( $this->bind_param); print_r($this->types);
            return $this->affected_rows($sql, $this->bind_param, $this->types);
		}
        /**
         * 1、$tableName 值不为空
         * 参数：表名 类型：字符串
         * 为私有属性$tableName赋值 以确定要更新数据的表
         * 返回值为$this
         * 2、$tableName 值为空
         * 功能描述：更新一条记录
         * 返回值：影响的行数
         */
        public function UPDATE($tableName=''){
            if(!empty($tableName)){
                $this->tableName=PRETABLE.$tableName;
                return $this;
            }else{
                $setVal='';		//set字串
                foreach($this->set_arr as $key=>$val){
                    $setVal.=$key.'=?,';
                    $this->types.='s';	//默认所有数据的类型为字符串类型
                }
                if(!empty($this->where_case)){
                    $this->where_case='WHERE '.$this->where_case;
                }
                $setVal=substr($setVal,0,strlen($setVal)-1);
                $sql="UPDATE $this->tableName SET $setVal $this->where_case";
                //echo $sql;
                $arr=array_merge($this->set_arr, $this->bind_param);
                //print_r($arr);
                return $this->affected_rows($sql, $arr, $this->types);
            }
        }
        /**
         * 功能描述：删除一条记录
         * 返回值：影响函数
         */
        public function DELETE(){
            if(!empty($this->where_case)){
                $this->where_case='WHERE '.$this->where_case;
            }
            $sql="DELETE FROM $this->tableName $this->where_case";
            //echo $sql;
            //print_r($this->bind_param);
            return $this->affected_rows($sql, $this->bind_param, $this->types);
        }
        /**
         * 1、$val 值不为空
         * 参数：查询条件 类型：数组[普通查询] 字符串[聚集函数查询]
         * 为私有属性$select_val赋值
         * 返回值为$this
         * 2、$val 值为空
         * 功能描述：查询一组数据，根据$select_val的数据类型，确定使用普通查询或者聚集函数查询
         * 返回值：查询结果
         *
         */
        public function SELECT($val=''){
            if(!empty($val)){
                $this->select_val=$val;
                return $this;
            }else{      //执行查询语句
                $result=array();    //查询返回二维数组
                $select_str='';     //需要查询字段
                $fields=array();    //绑定的结果集
                if(!empty($this->where_case)){
                    $this->where_case='WHERE '.$this->where_case;
                }
                if(!empty($this->order)){
                    $this->order='ORDER BY '.$this->order;
                }
                if(!empty($this->group)){
                    $this->group='GROUP BY '.$this->group;
                }
                if(!empty($this->limit_str)){
                    $this->limit_str='LIMIT '.$this->limit_str;
                }
                if(is_array($this->select_val)){    //普通查询
                    foreach($this->select_val as $key=>$value){
                        $select_str.=$value.',';
                        $fields[$value]='';
                    }
                    $select_str=rtrim($select_str, ', ');
                }else{  //聚集函数查询
                    $select_str=$this->select_val;
                }
                $sql="SELECT $select_str FROM $this->tableName $this->where_case $this->order  $this->group $this->limit_str";
                //echo $sql;
                if($stmt=$this->mysqli->prepare($sql)){
                    if(!empty($this->where_case)){
				    	$this->_bindParams($stmt, $this->bind_param, (array)$this->types);
			    	}
                    $stmt->execute();
                    $field=$this->toBtArray($fields);
                    if(is_array($this->select_val)){
                        call_user_func_array(array($stmt,'bind_result'), $field);
                    }else{
                        $stmt->bind_result($result);
                    }
                    while($stmt->fetch()){
                        if(is_array($this->select_val)){
                            $a=array();
			    		    foreach($field as $key=>$value){
			    			    $a[$key]=$value;
			    		    }
                            $result[]=$a;
                        }
                    }
                }
                $this->clear();
                return $result;
			}
        }
        /**
		 * 格式化数组
		 * php5.3后问题
		 */
		private function toBtArray(&$arr){
			$fields=array();	//结果集绑定数组
			foreach($arr as $key=>$value){
				$fields[$key]=&$arr[$key];
			}
			return $fields;
		}
		/**
		 * 封装mysqli_bind_param函数
         * 参数类型为引用传递 
         * 第一个参数：绑定对象
         * 第二个参数：绑定值，类型为数组
         * 第三个参数：绑定值类型
		 * 变量绑定成功返回真
         */
		private  function _bindParams(&$stmt,$valsArray=array(),$valsType=array()){
			$result=FALSE;
			if (count($valsArray) > 0){
				$params = array_merge($valsType, $valsArray);
				$tmpArray = array();
				foreach ($params as $key => $value){
					$tmpArray[$key] = &$params[$key];
                }
                $result = call_user_func_array(array($stmt,'bind_param'), $tmpArray);
			}
			return $result;
		}
		
		//关闭数据库连接
		private function close(){
			if($this->mysqli){
				$this->mysqli->close();
			}
			$this->mysqli=FALSE;
		}
		//析构方法、自动关闭连接
		public function __destruct(){
			$this->close();
		}
	}
