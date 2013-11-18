// JavaScript Document
/*-----表单校验-------*/
//定义表单是否应该提交
var stat=[0, 0, 0, 0];
var oLog=document.getElementById('log');
var oRg=document.getElementById('rg');
function register()
{
	oLog.style.display='none';	
	oRg.style.display='block';	
	startMove(oLog, {marginLeft:-410, opacity:0});	
	startMove(oRg, {marginLeft:-310, opacity:100});	
}
function login()
{
	oLog.style.display='block';	
	oRg.style.display='none';	
	startMove(oLog, {marginLeft:-210, opacity:100});	
	startMove(oRg, {marginLeft:-510, opacity:0});	
}
function check(obj, info, validate, click){
	var oTd=obj.parentNode.nextSibling;
	obj.onfocus=function(){	
		if(this.name=='regvcode')
			this.className='cod';	
		else
			this.className='txt';
		oTd.innerHTML=info;
		oTd.className='e';
	}
	obj.onblur=function(){
		if(validate(this.value)){
			oTd.innerHTML="";
		}else{
			if(this.name=='regvcode')
				this.className='errc';	
			else
				this.className='err';
			oTd.className='error';
		}
	}

	if(click=="click"){
		obj.onblur();
	}
}
function validateData(click){
	var oTxt1=document.getElementsByName('regname')[0];
	var oTxt2=document.getElementsByName('regpassword')[0];
	var oTxt3=document.getElementsByName('regrepassword')[0];
	var oTxt4=document.getElementsByName('regvcode')[0];
	check(oTxt1, "3-20个中英文字符或下划线组成", function(val){
		var oTd1=oTxt1.parentNode.nextSibling;
		if(val.match(/^[0-9A-Za-z\u4E00-\u9FA5]+(_)*$/) && val.length >=3 && val.length <=20){
			oTd1.innerHTML='';
			ajax({		//发送ajax请求
				type:"GET",
				url:"public/ajax/username.ajax.php?user_name="+oTxt1.value,
				onSuccess:function(data){
					if(data=='ok')
						stat[0]=1;
					else{
						stat[0]=0;
						if(oTxt1.name=='regvcode')
							oTxt1.className='errc';	
						else
							oTxt1.className='err';
						oTd1.className='error';
						oTd1.innerHTML='该用户名已经被注册';
					}
				},
			});
			return true;
		}else {
			stat[0]=0;
			if(!val.match(/^\S+$/)){
				stat[0]=0;
				oTd1.innerHTML='用户名不能为空';
				return false;
			}else if(val.length<3){
				stat[0]=0;
				oTd1.innerHTML='用户名长度为3到20个字符';
				return false;
			}else if(!val.match(/^[0-9A-Za-z\u4E00-\u9FA5]+(_)*$/)){
				stat[0]=0;
				oTd1.innerHTML='不能包含非法字符';
				return false;
			}else{
				stat[0]=0;
				return false;
			}	
		}
	}, click);
	check(oTxt2, "6-21个字符组成", function(val){
		var oTd2=oTxt2.parentNode.nextSibling;
		if(val.match(/^\S+$/) && val.length >=6){
			stat[1]=1;
			return true;
		}else {
			stat[1]=0;
			if(!val.match(/^\S+$/)){
				oTd2.innerHTML='密码不能为空';
				return false;
			}else if(val.length<6){
				oTd2.innerHTML='密码最小长度为6个字符';
				return false;
			}else{
				return false;
			}	
		}
	}, click);

	check(oTxt3, "确认密码", function(val){
		var oTd3=oTxt3.parentNode.nextSibling;
		if(val.match(/^\S+$/) && val==oTxt2.value){
			stat[2]=1;
			return true;
		}else {
			stat[2]=0;
			if(!val.match(/^\S+$/)){
				oTd3.innerHTML='请再次输入密码';
				return false;
			}else if(val!=oTxt2.value){
				oTd3.innerHTML='两次密码输入不一致';
				return false;
			}else{
				return false;
			}	
		}
	}, click);
	check(oTxt4, "请填写验证码", function(val){
		var oTd4=oTxt4.parentNode.nextSibling;
		if(val.match(/^\S+$/)){
			oTd4.innerHTML='';
			ajax({		//发送ajax请求
				type:"GET",
				url:"public/ajax/vcode.ajax.php?vcode="+oTxt4.value,
				onSuccess:function(data){
					if(data=='ok')
						stat[3]=1;
					else{
						stat[3]=0;
						if(oTxt4.name=='regvcode')
							oTxt4.className='errc';	
						else
							oTxt4.className='err';
						oTd4.className='error';
						oTd4.innerHTML='验证码填写有误';
					}
				},
			});
			return true;
		}else{
			stat[3]=0;
			oTd4.innerHTML='验证码填写有误';
			return false;
		}
	}, click);
	if(stat[0]+stat[1]+stat[2]+stat[3]==4)
		return true;
	else 
		return false;
}
window.onload=function()
{
	startMove(oLog, {marginLeft:-210, opacity:100});	
	validateData();	
}