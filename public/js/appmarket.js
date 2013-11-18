// JavaScript Document
function getPage()
{
	var aLi1=window.top.document.getElementById('listul').getElementsByTagName('li');
	for(var i=1; i<aLi1.length; i++)
	{
		if(aLi1[i].className=='active')
		{
			return i;
		}	
	}
};
function sendRequest(action, ico_name, ico_url, obj)
{
	ajax({		//发送ajax请求
		type:"GET",
		url:"../public/ajax/ico.ajax.php?action="+action+"&page="+getPage()+"&ico_name="+ico_name+"&ico_url="+ico_url,
		onSuccess:function(data){
			obj.parentNode.innerHTML='<span style="color:red; font-size:12px">已添加</span>';
			setTimeout(function(){
				window.top.location.href='../';	
			},1000)
		},
	});
};