// JavaScript Document
window.onload=function()
{
	//loadFrame('应用市场', 'frame/appmarket.php?icon=推荐', 'market', 600, 425);
	//背景切换
	pageChange();
	//自定义搜索框
	
	searchForm();
	
	window.onclick=function()
	{
		if(document.getElementById('context'))
		{
			document.getElementById('context').parentNode.removeChild(document.getElementById('context'));
		}	
	}
		
};
//主题设置
function sepcialManage(sId, className, title, src)
{
	if(document.getElementById(sId)) return;
	var oParent=document.getElementById('content');
	var oBox=createEle('div', {class:className});
	var oHeader=createEle('div', {class:'header', id:sId});
	oHeader.innerHTML=title;
	var oClose=createEle('a', {class:'close', title:'关闭'});
	oHeader.appendChild(oClose);
	oBox.appendChild(oHeader);
	var oFrame=createEle('iframe', {src:src , class:'fr'});
	oFrame.setAttribute('frameborder', '0', 0);
	oBox.appendChild(oFrame);
	
	oParent.appendChild(oBox);
	
	new Drag(sId);
	oClose.onclick=function()
	{
		changeSize(this.parentNode.parentNode, 'close');	
	};
};
function pageChange()
{
	var oUl1=document.getElementById('listul');
	var oUl2=document.getElementById('ulp');
	var aLi1=oUl1.getElementsByTagName('li');
	var aLi2=oUl2.getElementsByTagName('li');
	for(var i=1; i<aLi1.length; i++)
	{
		aLi1[i].index=i-1;
		aLi1[i].onclick=function()
		{
			for(var i=1; i<aLi1.length; i++)
			{
				aLi1[i].className='list';	
			}
			aLi1[this.index+1].className='active';
			startMove(oUl2, {left:-this.index*aLi2[0].offsetWidth});
		}	
	}		
}
var bChange=false;
function focusChange(obj, txt)
{
	
	obj.onfocus=function()
	{
		if(!bChange) this.value=''; 
	};
	obj.onblur=function()
	{
		if(!bChange) 
		{
			this.value=txt;
		}
	};
	obj.onkeyup=function()
	{
		var re=/\S+/;
		bChange=(this.value==txt||re.test(this.value));
	};	
}
function searchForm()
{
	var oSearch=document.getElementById('sa');
	var oForm=document.getElementById('sform');
	var oTxt=oForm.getElementsByTagName('input')[0];
	var oSub=oForm.getElementsByTagName('input')[1];
	oSearch.onclick=function(e)
	{
		if(getStyle(oForm, 'display')=='none')
			oForm.style.display='block';
		else
			oForm.style.display='none';	
		var oEvent = e || event;
		oEvent.cancelBubble = true;
	}
	oForm.onclick=function(e)
	{
		oForm.style.display='block';
		var oEvent = e || event;
		oEvent.cancelBubble = true;
	};
	addEvent(window, 'click', function(){
		if(getStyle(oForm, 'display')=='block')
			oForm.style.display='none';	
	});
	focusChange(oTxt, '检索应用...');
	oSub.onmouseout=function()
	{
		this.style.backgroundPositionX='-240px';	
	}
	oSub.onmousemove=function()
	{
		this.style.backgroundPositionX='-320px';	
	}
	oSub.onclick=function(e)
	{
		if(bChange)
		{
			sepcialManage('market', 'dialog_ket', '检索应用', 'frame/appmarket.php?action=search&ico_name='+oTxt.value);
		}
		var oEvent = e || event;
		oEvent.cancelBubble = true;
        oTxt.value='';
	}
    oTxt.onkeydown=function(ev){
        var oEvent=ev||event;
        if(oEvent.keyCode==13)
        {
            if(bChange && oTxt.value)
            {
                sepcialManage('market', 'dialog_ket', '检索应用', 'frame/appmarket.php?action=search&ico_name='+oTxt.value);
            }
            oEvent.cancelBubble = true;
            oTxt.value='';
        }
    }
}
//创建元素 并为属性赋值
function createEle(sName, json)
{
	var oEle=document.createElement(sName);
	for(var attr in json)
	{
		if(attr=='class'||attr=='id'||attr=='src'||attr=='href'||attr=='alt'||attr=='title')
			oEle.setAttribute(attr, json[attr]);
		else
			setStyle(oEle, attr, json[attr]);	
	}
	return oEle;
}
//获取当前用户所在页
function getPage()
{
	var aLi1=document.getElementById('listul').getElementsByTagName('li');
	var aLi2=document.getElementById('ulp').getElementsByTagName('li');
	for(var i=1; i<aLi1.length; i++)
	{
		if(aLi1[i].className=='active')
		{
			return i;
		}	
	}
}
//框架加载
zindex=1;
function loadFrame(sIco, sUrl, sId, iWidth, iHeight)
{
	if(document.getElementById(sId))
	{
		return;	
	}
	//创建框架元素并赋值
	var oBox, oHeader;
	var aPageLi=getByClass(document.getElementById('ulp'), 'page');
    zindex++;
	if(iWidth)
	{
        oBox=createEle('div', {class:'dialog_obj', width:iWidth+'px', height:iHeight+'px', "z-index":zindex, left:(aPageLi[0].offsetWidth-iWidth-50)/2+'px', top:'80px'});
		oHeader=createEle('div', {class:'header', id:sId});
	}
	else
	{
		oBox=createEle('div', {class:'dialog1', "z-index":zindex});
		oHeader=createEle('div', {class:'header1', id:sId});
	}
	var oClose=createEle('a', {class:'close', title:'关闭'});
	oHeader.appendChild(oClose);
	var oMid;
	if(!iWidth)
		oMid=createEle('a', {class:'max', title:'还原'});
	else
		oMid=createEle('a', {class:'mid', title:'最大化'});
	oHeader.appendChild(oMid);
	
	var oMin=createEle('a', {class:'min', title:'最小化'});
	oHeader.appendChild(oMin);
	
	var oFrame=createEle('iframe', {src:sUrl, id:'frame'+sId, class:'fr'});
	oFrame.setAttribute('frameborder', '0', 0);
	oBox.appendChild(oFrame);
	
	oBox.insertBefore(oHeader, oFrame);
	aPageLi[getPage()-1].appendChild(oBox);	
	//状态栏添加
	var oState=createEle('a', {href:'#', title:sIco, id:'a'+sId});
	var ostatImg=createEle('img', {alt:'', src:'public/images/icon/'+sIco+'.png'});
	var oSpan=createEle('span');
	oSpan.innerHTML=sIco;
	oState.appendChild(ostatImg);
	oState.appendChild(oSpan);
	//倒序工具栏插入元素
	var oBtBar=document.getElementById('btbar');
	
	if(oBtBar.getElementsByTagName('a').length==0)
		oBtBar.appendChild(oState);
	else
		oBtBar.insertBefore(oState, oBtBar.getElementsByTagName('a')[0]);
	new Drag(sId);
	
	oMid.onclick=function()
	{
		midClick(this, iWidth, iHeight);	
	};
	oMin.onclick=function()
	{
		changeSize(this.parentNode.parentNode, 'min');
	};
	oClose.onclick=function()
	{
		changeSize(this.parentNode.parentNode, 'close','','', sId);	
	};
	oState.onclick=function()
	{
		stateClick(sId);
	};
    oBox.onclick=function()
    {
    	this.style.zIndex=zindex++;
    }
	oState.oncontextmenu=function(ev)
	{
		var oParent=document.getElementById('content');
		if(document.getElementById('context'))
		{
			oParent.removeChild(document.getElementById('context'));
		}
		var oContex=createEle('div', {class:'bar_menu', id:'context'});
		oEvent=ev||event;
		oContex.style.left=oEvent.clientX-100+'px';
		oContex.style.top=oEvent.clientY-27+'px';
		var oA=createEle('a');
		oA.innerHTML='关闭';
		oContex.appendChild(oA);
		oParent.appendChild(oContex);
		oA.onclick=function()
		{
			changeSize(document.getElementById(sId).parentNode, 'close','','', sId);	
		}
		oEvent.cancelBubble = true;	
		return false;	
	}
};
function stateClick(sId)
{
	var	oEle=document.getElementById(sId);
	
	
	if(getStyle(oEle.parentNode, 'display')=='block' && oEle.parentNode.style.zIndex>=zindex)
	{
		oEle.parentNode.style.display='none';
	}
	else
	{
        oEle.parentNode.style.zIndex=++zindex;
		oEle.parentNode.style.display='block';	
	}
	var sClass=oEle.parentNode.parentNode.className;
	var index=parseInt(sClass.substring(4))-1;
	if(index!=(getPage()-1))
	{
		//alert(index+' '+getPage());
		var oUl=document.getElementById('ulp');
		var aLi=document.getElementById('listul').getElementsByTagName('li');
		var iWidth=oUl.getElementsByTagName('li')[0].offsetWidth;
		startMove(oUl, {left:-index*iWidth});	
		for(var i=1; i<aLi.length; i++)
		{
			aLi[i].className='list';	
		}
		aLi[index+1].className='active';
		oEle.parentNode.style.display='block';	
	}
};
function midClick(obj, iWidth, iHeight)
{
	if(obj.className=='mid')
	{
		obj.className='max';	
		changeSize(obj.parentNode.parentNode, 'max');
	}
	else
	{
		obj.className='mid';	
		changeSize(obj.parentNode.parentNode, 'mid', iWidth, iHeight);	
	}
}
function changeSize(obj, size, iWidth, iHeight, sId)
{
	switch(size)
	{
		case 'min':
				obj.style.display='none';
				break;
		case 'mid':
				if(!iWidth)
				{
					obj.style.left=(obj.offsetWidth-1000)/2+'px';
					obj.style.top='80px';
					obj.style.width='1000px';
					obj.style.height='500px';
				}
				else
				{
					obj.style.left=(obj.offsetWidth-iWidth-50)/2+'px';
					obj.style.top='80px';
					obj.style.width=iWidth+'px';
					obj.style.height=iHeight+'px';	
				}
				break;
		case 'max':
				obj.style.width='100%';
				obj.style.height='100%';
				obj.style.left=0;
				obj.style.top=0;
				break;	
		case 'close':
				obj.parentNode.removeChild(obj);
				var oSt=document.getElementById('a'+sId);
				if(oSt)	oSt.parentNode.removeChild(oSt);
				break;
	}	
}
//自定义右键菜单
document.oncontextmenu=function(ev)
{ 
	var oParent=document.getElementById('content');
	if(document.getElementById('context'))
	{
		oParent.removeChild(document.getElementById('context'));
	}
	var oEvent=ev||event;
	var oMenu=createEle('div',{class:'window_menu', id:'context'});
	oMenu.style.left=oEvent.clientX+'px';
	oMenu.style.top=oEvent.clientY+'px';
	var oA1=createEle('a', {href:'#', class:'norm'});
	var oA2=createEle('a', {href:'#', class:'norm'});
	var oA3=createEle('a', {href:'#', class:'norm'});
	var oSplite=createEle('a', {href:'#', class:'splite'});
	oA1.innerHTML='刷新';
	
	oA2.innerHTML='添加应用';
	oA3.innerHTML='设置主题';
	oMenu.appendChild(oA1);
	oMenu.appendChild(oA2);
	oMenu.appendChild(oA3);
	oParent.appendChild(oMenu);
	oA1.onclick=function()
	{
		location.reload();	
	};
	oA2.onclick=function()
	{
		sepcialManage('market', 'dialog_ket', '应用市场', 'frame/appmarket.php?icon=推荐');
	};
	oA3.onclick=function()
	{
		sepcialManage('obmg', 'dialog_obj', '主题设置', 'frame/object.html');
	};
	addEvent(window, 'click', function(){
		if(document.getElementById('context'))
		{
			oParent.removeChild(document.getElementById('context'));
		}
	});
	return false;
}
