function addtag(){
	alert('กำลังทำการบันทึกข้อมูล');
	alert('บันทึกข้อมูลเรียบร้อย');
}
function fndate(){
	var x = document.getElementById("date").value;
	var y = document.getElementById("date1").value;
	if(x>=y){
		return true;
	}else{
		alert("ไม่สามารถเลือกวันที่ย้อนหลังได้\nกรุณาเลือกวันที่ใหม่");
		document.getElementById("date").focus();
		return false;
	}
}