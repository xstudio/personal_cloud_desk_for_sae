<?php
	/**
	 * 创建人：小笙
	 * 创建时间：2012-08-07
	 * 功能描述：验证类，主要用于用户数据提交合法性验证
	 */
	class Validate{
	    //UTF-8编码的用户名[字母/数字/下划线/汉字]
		public static function userName($val=''){
			$val=trim($val);
			if(preg_match('/^\s*([0-9a-zA-Z\x7f-\xff_]){3,20}\s*$/',$val)){
				return $val;	
			}else{
				return FALSE;	
			}
        }
        //邮箱
		public static function email($val=''){
			$val=trim($val);
			if(preg_match('/^\s*[a-zA-Z0-9]\w*[a-z0-9A-Z]@[a-zA-Z0-9]+(.[a-zA-Z]+)+\s*$/',$val)){
				return $val;	
			}else{
				return FALSE;	
			}
        }
        //URL
		public static function url($val=''){
			$val=trim($val);
			if(preg_match('/^(https?|ftp|mms):\/\/([A-z0-9]+[_\-]?[A-z0-9]+\.)*[A-z0-9]+\-?[A-z0-9]+\.[A-z]{2,}(\/.*)*\/?$/',$val)){
				return $val;	
			}else{
				return FALSE;	
			}
        }
        //判断是否有一组数据通过post方式提交，并且非空
		public static function isPost($arr=array()){
			$result=TRUE;
			foreach($arr as $val){
				if(!isset($_POST[$val])||empty($_POST[$val]))
					$result=FALSE;
			}
			return $result;
        }
        //判断是否有一组数据通过get方式提交，并且非空
		public static function isGet($arr=array()){
			$result=FALSE;
			foreach($arr as $val){
				if(isset($_POST[$val])&&!empty($_POST[$val])){
					$result=TRUE;
				}else{
					$result=FALSE;	
				}	
			}
			return $result;
        }
    }

