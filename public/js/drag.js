// JavaScript Document
function Drag(id){
	this.disX=0;
	this.disY=0;	
	this.oDiv=document.getElementById(id);
	var This=this;
	this.oDiv.onmousedown=function(ev){
		This.fnDown(ev);	
		return false;	//解决FF拖拽Bug
	}
}
Drag.prototype={
	fnDown:function(ev){
		var This=this;
		var oEvent=ev||event;
		this.disX=oEvent.clientX-this.oDiv.parentNode.offsetLeft;
		this.disY=oEvent.clientY-this.oDiv.parentNode.offsetTop;
		if(this.oDiv.setCapture){	//兼容IE拖拽选中文字Bug
			this.oDiv.onmousemove=function(ev){
				This.fnMove(ev);	
			};
			this.oDiv.onmouseup=function(){
				This.fnUp();	
			}	
			this.oDiv.setCapture();
		}else{
			document.onmousemove=function(ev){
				This.fnMove(ev);	
			};
			document.onmouseup=function(){
				This.fnUp();	
			}	
		}
	},
	fnUp:function(){
		this.oDiv.onmousemove=null;
		document.onmousemove=null;
		this.oDiv.onmouseup=null;
		document.onmouseup=null;
		if(this.oDiv.releaseCapture)
		{
			this.oDiv.releaseCapture();
		}
	},	
	fnMove:function(ev){
		var oEvent=ev||event;
		var l=oEvent.clientX-this.disX;
		var t=oEvent.clientY-this.disY;
		if(t<0) t=0;
		this.oDiv.parentNode.style.left=l+'px';
		this.oDiv.parentNode.style.top=t+'px';
	}
};