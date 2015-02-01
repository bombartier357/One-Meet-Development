console.log("drag_and_drop.js LOADED");



function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
	var user_id = $('#user-id').val();
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    ev.target.appendChild(document.getElementById(data));
    //console.log(data);
    var ajax_local = 'ajax.php';
    $.post(ajax_local,{id:data, user_id:user_id, type:'image_push'})
		.done(function(){
			//location.reload();
			});
}
