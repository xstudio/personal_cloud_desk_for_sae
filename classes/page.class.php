<?php
	/**
	 * 创建人：越前(yueqian.sinaapp.com)
	 * 创建时间：2012-08-07
	 * 功能描述：分页类
	 */
	class Page{
		private $pageSize;	//每页显示条数
		private $pageNow;	//当前页数
		private $pageCount;	//总页数
		private $rowCount;	//总记录数
		private $uri;
	    private $and;       //多参数之间连接符
	    private $listNum=5;   //定义最多显示的页数
		function __construct($pageSize=10,$rowCount,$path=''){
			$this->pageSize=$pageSize;
			$this->rowCount=$rowCount;
			$this->uri=$this->getUri($path);
			$this->and=strlen(strstr($this->uri,'?'))>1?'&':'';
			$this->pageCount=ceil($this->rowCount/$this->pageSize);
			$this->pageNow=!empty($_GET['p'])?$_GET['p']:1;
		}
		private function getUri($path){
			$url=$_SERVER["REQUEST_URI"].(strpos($_SERVER["REQUEST_URI"], '?')?'':"?").$path;
			$parse=parse_url($url);
			if(isset($parse["query"])){
				parse_str($parse['query'],$params);
				unset($params["p"]);
				$url=$parse['path'].'?'.http_build_query($params);
			}
			return $url;
		}
		private function firstPage(){
			$html='';
			if($this->pageNow!=1&&$this->pageCount>1){
				$html.="<a href='".$this->uri.$this->and."p=1'>首页</a>";
			}
			return $html;
		}
		private function lastPage(){
			$html='';
			if($this->pageNow!=$this->pageCount&&$this->pageCount>1){
				$html.="<a href='".$this->uri.$this->and."p=".$this->pageCount."'>尾页</a>";
			}
			return $html;
		}
		private function prePage(){
			$html='';
			if($this->pageNow!=1&&$this->pageCount>1){
				$html.="<a href='".$this->uri.$this->and."p=".($this->pageNow-1)."'><<页</a>";
			}
			return $html;
		}
		private function nextPage(){
			$html='';
			if($this->pageNow!=$this->pageCount&&$this->pageCount>1){
				$html.="<a href='".$this->uri.$this->and."p=".($this->pageNow+1)."'>>></a>";
			}
			return $html;
	    }
	    //显示页数列表，显示的最大页数根据$this->listNum值而定
		private function pageList(){
	        $html='';
	        if($this->pageCount>1){
	            if($this->pageNow<=ceil($this->listNum/2)){
	                if($this->pageCount<$this->listNum)
	                    $max=$this->pageCount;
	                else
	                    $max=$this->listNum;
	                for($i=1;$i<=$max;$i++){
	                    if($i==$this->pageNow){
	                        $html.='<span>'.$i.'</span>';
	                    }else{
	                        $html.="<a href='".$this->uri.$this->and."p=".$i."'>".$i."</a>";
	                    }
	                } 
	            }else if($this->pageNow>($this->pageCount-$this->listNum)){
	                for($i=($this->pageCount-$this->listNum+1); $i<=$this->pageCount; $i++){
	                    if($i==$this->pageNow){
	                        $html.='<span>'.$i.'</span>';
	                    }else{
	                        $html.="<a href='".$this->uri.$this->and."p=".$i."'>".$i."</a>";
	                    }
	                }
	            }else{
	                if($this->pageCount<(floor($this->listNum/2)+$this->pageNow))
	                    $max=$this->pageCount;
	                else
	                    $max=floor($this->listNum/2)+$this->pageNow;
	                for($i=$this->pageNow-floor($this->listNum/2); $i<=$max; $i++){
	                    if($i==$this->pageNow){
	                        $html.='<span>'.$i.'</span>';
	                    }else{
	                        $html.="<a href='".$this->uri.$this->and."p=".$i."'>".$i."</a>";
	                    }
	                }
	            }
	        }
			return $html;
		}
		private function pageInfo(){
			if($this->pageCount>0)
				return $this->pageNow.'/'.$this->pageCount.'页';
		}
		function limitPage(){
			$page=$this->pageSize*($this->pageNow-1);
			return $page.','.$this->pageSize;
		}
	    function getPageInfo($display=array(0,1,2,3,4,5)){
	        if($this->pageNow<=$this->pageCount){
	            $str[0]=$this->firstPage();
	            $str[1]=$this->prePage();
	            $str[2]=$this->pageList();
	            $str[3]=$this->nextPage();
	            $str[4]=$this->lastPage();
	            $str[5]=$this->pageInfo();
	            $html='';
	            foreach($display as $index){
	                $html.=$str[$index];
	            }
	            return $html;
	        }
		}

	}	

        