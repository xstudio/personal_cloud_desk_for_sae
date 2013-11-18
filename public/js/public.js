// JavaScript Document
/*------设定元素样式--------*/
function setStyle(obj,attr,value){
    obj.style[attr]=value;	
}

/*------按class获取元素---*/
function getByClass(oParent,sClass){
	var aEle=oParent.getElementsByTagName('*');
	var result=[];
	var i=0;
	var re=new RegExp('\\s*'+sClass+'\\s*','i');
	for(i=0;i<aEle.length;i++){
		if(re.test(aEle[i].className)){
			result.push(aEle[i]);	
		}	
	}
	return result;
}
/*------事件绑定--------*/
function addEvent(obj, sEvent, fn){
	if(obj.attachEvent)
		obj.attachEvent('on'+sEvent, fn);
	else 
		obj.addEventListener(sEvent, fn, false);
}
        