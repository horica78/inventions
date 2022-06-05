<html>
<body>
<br>An autocomplete from me 2
<table id="tblg" width="100%" height="100%" cellpadding="0" cellspacing="0">
<tr>
	<td align="center">
Search<input type="text" id="fd"><input type="hidden" id="fdh">
</td>
<td align="center">
<input type="text" id="fd1"><input type="hidden" id="fdh1">
</td>
</tr>
</table>
<br>
<script>
function createautocomplete(id,url,hn){
	var myobj = document.getElementById(id);
	var mydiv = document.createElement("div");
	mydiv.obj = myobj;
	var mydivshow = document.createElement("div");
	myobj.url = url;
	myobj.sid = id;
	myobj.hn = hn;
	var rect = myobj.getBoundingClientRect();
	//console.log(rect.top, rect.right, rect.bottom, rect.left);
	mydiv.style.position = "absolute";
	mydiv.style.top = rect.top;
	mydiv.style.left = rect.left;
	mydiv.style.width = (rect.right-rect.left) +"px";
	mydiv.style.border = "1px solid black";
	mydiv.setAttribute('id',id+'_div');
	mydiv.sid = id;
	mydivshow.setAttribute('id',id+'_div_show');
	mydivshow.setAttribute('tabindex','1');
	mydivshow.sid = id;
	mydivshow.style.width = (rect.right-rect.left) +"px";
	mydivshow.style.display = "none";
	mydivshow.style.backgroundColor = "white";
	var myparent = myobj.parentElement;
	myparent.removeChild(myobj); 
	myparent.appendChild(mydiv);
	mydiv.appendChild(myobj);
	mydiv.appendChild(mydivshow);
	mydivshow.classList.add("my_class");
	if(typeof document.onlick === 'function'){
		var old = document.onlick;
		document.onclick = function () {
            if (old) {
                old();
            }
			if(old.toString().indexOf('my_class') == -1){
				var x = document.getElementsByClassName("my_class");
				var i;
				for (i = 0; i < x.length; i++) {
				  x[i].style.display = "none";
				}
			}
        };
	}
	else{
		document.onlick = function(e){
			var x = document.getElementsByClassName("my_class");
			var i;
			for (i = 0; i < x.length; i++) {
			  x[i].style.display = "none";
			} 
		};
	}
	myobj.oninput = function(){
		var valuz = this.value;
		var selfid = this.sid;
		var selfurl = this.url;
		document.getElementById(selfid+'_div_show').style.display = "block";
		//document.getElementById(selfid+'_div_show').style.height = "100px";
		if(valuz.length > 2){
			var myrec = new XMLHttpRequest();
			myrec.open('GET',selfurl+'?val='+encodeURIComponent(valuz),true);
			myrec.onreadystatechange = function() {
				if(myrec.readyState == 4) {
					if(myrec.status == 200 || myrec.status == 0) {
						var data = JSON.parse(myrec.responseText);
						var items = [];
						if(data.length){
							items.push("<table style='width: 100%;' id='tbl_"+selfid+"'>");
							items.push("<tbody id='tbd_"+selfid+"'>");
							data.forEach(function(val) {
								val = ''+val;
								var arr = val.split(",");
								var word = arr[1].toLowerCase().replace(valuz.toLowerCase(),"<span style='color:red;'>"+valuz.toLowerCase()+"</span>").toUpperCase();
								//console.log(word);
							items.push("<tr onclick=\"document.getElementById('"+selfid+"').dataSelect('"+selfid+"','"+arr[0].toUpperCase()+"','"+arr[1].toUpperCase()+"');\"><td style='cursor:pointer;text-align:left;'>"+word+"</td></tr>");
							});
							items.push("</tbody>");
							items.push("</table>");
						}
						else{
							items.push("<table style='width: 100%;' id='tbl_"+selfid+"'>");
							items.push("<tbody id='tbd_"+selfid+"'>");
							items.push("<tr onclick=\"document.getElementById('"+selfid+"').dataSelect('"+selfid+"','');\"><td  style='cursor:pointer;color:red;'>Nici un rezultat</td></tr>");
							items.push("</tbody>");
							items.push("</table>");
						}
						document.getElementById(selfid+'_div_show').innerHTML = items.join("");
						document.getElementById(selfid+'_div_show').style.display = "block";
						document.getElementById(selfid+'_div_show').style.height = "auto";
					}
				} 
			}
			// Send the request
			myrec.send(null);
		}
	};
	myobj.dataSelect = function(oid,val1,val2){
		//alert(val1);
		//alert(val2);
		document.getElementById(oid).value = val2;
		document.getElementById(document.getElementById(oid).hn).value = val1;
		document.getElementById(oid+'_div_show').style.display = "none";
	};
}
document.onlick = function(e){
			console.log('test');
};
createautocomplete(id="fd",url="json2.php",hn="fdh");
createautocomplete(id="fd1",url="json2.php",hn="fdh1");
</script>
</body>
</html>