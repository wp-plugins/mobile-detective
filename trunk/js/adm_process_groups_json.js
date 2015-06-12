function btnAddFunction (i){
	// Change visual presentation of members
		document.getElementById('group'+i+'_1').textContent +=
		', '+document.getElementById('selector_'+i).options[document.getElementById('selector_'+i).selectedIndex].value;
	// parse json
		var obj = JSON.parse(document.getElementById('MD_groups_json').value); 
	// add member to array
		obj[i][1]=obj[i][1]+', '+document.getElementById('selector_'+i).options[document.getElementById('selector_'+i).selectedIndex].value;
	// return array back to json
		var json_str = JSON.stringify(obj);
	// json to hidden field
		document.getElementById('MD_groups_json').value=json_str;
	// change dropbox deleter__ (add added item)
		var select = document.getElementById('deleter_'+i);
		select.options[select.options.length] = new Option(document.getElementById('selector_'+i).options[document.getElementById('selector_'+i).selectedIndex].text,
			document.getElementById('selector_'+i).options[document.getElementById('selector_'+i).selectedIndex].value);
	// change dropbox selector_i (disable added item)
		//document.getElementById('selector_'+i).options[document.getElementById('selector_'+i).selectedIndex]=null;
		document.getElementById('selector_'+i).options[document.getElementById('selector_'+i).selectedIndex].disabled=true;		
		document.getElementById('selector_'+i).options[document.getElementById('selector_'+i).selectedIndex+1].selected=true;		
}

function btnDelFunction (i){
	// Change visual presentation of members
		var str=document.getElementById('group'+i+'_1').textContent; //Read
		document.getElementById('group'+i+'_1').textContent=str.replace(', '+document.getElementById('deleter_'+i).options[document.getElementById('deleter_'+i).selectedIndex].value, ''); //Delete element
	// parse json
		var obj = JSON.parse(document.getElementById('MD_groups_json').value); 
	// correct member in array
		obj[i][1]=document.getElementById('group'+i+'_1').textContent;
	// return array back to json
		var json_str = JSON.stringify(obj);
	// json to hidden field
		document.getElementById('MD_groups_json').value=json_str;
	// change dropbox  selector_i(enable added item)
		var select = document.getElementById('selector_'+i);
		/*select.options[select.options.length] = new Option(document.getElementById('deleter_'+i).options[document.getElementById('deleter_'+i).selectedIndex].text,
			document.getElementById('deleter_'+i).options[document.getElementById('deleter_'+i).selectedIndex].value);*/
		for (var j=0;j<select.options.length;j++){
			if (select.options[j].value==document.getElementById('deleter_'+i).options[document.getElementById('deleter_'+i).selectedIndex].value) {
				document.getElementById('selector_'+i).options[j].disabled=false;	
				break;
			}
		}
	// change dropbox  deleter_(delete added item)
		document.getElementById('deleter_'+i).options[document.getElementById('deleter_'+i).selectedIndex]=null;
}

function btnDelGrFunction (i,t){
	// Delete group from json
		var obj = JSON.parse(document.getElementById('MD_groups_json').value); 
		obj.splice(i, 1);
	// return array back to json
		var json_str = JSON.stringify(obj);
	// json to hidden field
		document.getElementById('MD_groups_json').value=json_str;
	//Delete row in table
		var row = t.parentNode.parentNode;
		document.getElementById('GroppsTable').deleteRow(row.rowIndex);
}

function btnRenGrFunction (i){
	var oname=document.getElementById('group'+i+'_0').innerHTML;
	var gname = prompt('Please enter new group function', '');
	if (oname == gname) {alert ('You used old name'); return;}
	var obj;
	if (document.getElementById('MD_groups_json').value!=''){
		obj	= JSON.parse(document.getElementById('MD_groups_json').value); 
		// Check if name exists
		for (var j=0;j<obj.length;j++)
			if (obj[j][0]==gname){ alert ('Name '+gname+' exists'); return;}
		
	} 
		// Find old name and change		
		for (var j=0;j<obj.length;j++)
			if (obj[j][0]==oname){ obj[j][0]=gname; break;}
		var json_str = JSON.stringify(obj);
		document.getElementById('group'+i+'_0').innerHTML=gname;
		document.getElementById('MD_groups_json').value=json_str;
}

function getNewGroup() {
    var gname = prompt("Please enter new group name", "");
    if (gname != null) {
		if (gname.indexOf(" ") >0) {alert ('Sorry. No spaces in group names.'); return; }
	// parse json
	var obj;
	if (document.getElementById('MD_groups_json').value!=""){
		obj	= JSON.parse(document.getElementById('MD_groups_json').value); 
		// Check if name exists
		for (var i=0;i<obj.length;i++)
			if (obj[i][0]==gname){ alert ('Name '+gname+' exists'); return;}
	} else obj	= JSON.parse('[]');
	// Create table row		
		var ne=[gname,''];
		obj.push(ne);
	// return array back to json
		var json_str = JSON.stringify(obj)
	// json to hidden field (temp copy)
		document.getElementById('MD_groups_json_t').value=json_str;
	alert ('Group '+gname+' created');
    }
}