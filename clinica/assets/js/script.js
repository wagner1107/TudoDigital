function pegarCidade(obj){
	var item = obj.value;

//	alert(item);

	$.ajax({
		url: "pegarCidade.php",
		type: "POST",
		data: {estado:item},
		dataType: 'json',
		success:function(json){
			var html = "";

			for(var i in json){
				html += '<option value="'+json[i].id+'">'+json[i].nome+'</option>';
				}
			$("#cidade").html(html);

		}

	});
}