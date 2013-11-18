<?php
	class ValidateCode{
		private $width;
		private $height;
		private $num;
		private $img;
		private $pxNum;
		private $valCode;
		function __construct($width=130,$height=53,$num=4){
			$this->width=$width;
			$this->height=$height;
			$this->num=$num;
			$this->valCode=$this->createCode();
			$this->pxNum=floor($this->width*$this->height/40);
		}
		private function imagelinethick($image, $x1, $y1, $x2, $y2, $color, $thick = 1)
		{
			/* 下面两行只在线段直角相交时好使
			imagesetthickness($image, $thick);
			return imageline($image, $x1, $y1, $x2, $y2, $color);
			*/
			if ($thick == 1) {
				return imageline($image, $x1, $y1, $x2, $y2, $color);
			}
			$t = $thick / 2 - 0.5;
			if ($x1 == $x2 || $y1 == $y2) {
				return imagefilledrectangle($image, round(min($x1, $x2) - $t), round(min($y1, $y2) - $t), round(max($x1, $x2) + $t), round(max($y1, $y2) + $t), $color);
			}
			$k = ($y2 - $y1) / ($x2 - $x1); //y = kx + q
			$a = $t / sqrt(1 + pow($k, 2));
			$points = array(
				round($x1 - (1+$k)*$a), round($y1 + (1-$k)*$a),
				round($x1 - (1-$k)*$a), round($y1 - (1+$k)*$a),
				round($x2 + (1+$k)*$a), round($y2 - (1-$k)*$a),
				round($x2 + (1-$k)*$a), round($y2 + (1+$k)*$a),
			);
			imagefilledpolygon($image, $points, 4, $color);
			return imagepolygon($image, $points, 4, $color);
		}
		
		//创建背景图片
		private function createImg(){
			$this->img=imagecreatetruecolor($this->width,$this->height);
			$bgColor=imagecolorallocate($this->img,245,245,245);
			imagefill($this->img,0,0,$bgColor);
			$border=imagecolorallocate($this->img, 221, 221, 221);
			imagerectangle($this->img, 0, 0, $this->width-1, $this->height-1, $border);
		}
		//设置干扰元素
		private function setPx(){
			$pxColor=imagecolorallocate($this->img,1,95,182);
			$this->imagelinethick($this->img,0,rand(5,$this->height-5),$this->width/5,rand(5,$this->height-5),$pxColor,2);
			$this->imagelinethick($this->img,$this->width/5+10,rand(5,$this->height-5),$this->width,rand(5,$this->height-5),$pxColor,2);
		}
		//创建随机字符
		private function createCode(){
			$str='';
			$code='23456789abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
			for($i=0;$i<$this->num;$i++){
				$str.=$code{rand(0,strlen($code)-1)};
			}
			return $str;
		}
		//输出文本
		private function outText(){
			for($i=0;$i<$this->num;$i++){
				$color=imagecolorallocate($this->img,1,95,182);
				$x=$this->num*5*$i+10;
				$y=rand(30,$this->height-5);
				imagettftext($this->img,35,rand(-30,30),$x,$y,$color,'simhei.ttf',$this->valCode{$i});
			}
		}
		//输出图像
		private function outImg(){
			if(imagetypes() & IMG_GIF){
				header("Content-type:gif");
				imagegif($this->img);
			}else if(imagetypes() & IMG_PNG){
				header("Content-type:png");
				imagepng($this->img);	
			}else{
				header("Content-type:jpeg");
				imagejpeg($this->img);
			}
		}


		//显示图像
		function viewImg(){
			$this->createImg();
			$this->setPx();
			$this->outText();
			$this->outImg();
		}
		
		//获取产生的随机数
		function getCode(){
			return $this->valCode;
		}
		//析构函数，销毁图像资源
		function __destruct(){
			imagedestroy($this->img);
		}
	}