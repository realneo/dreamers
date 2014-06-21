
function turn_online() {
	var senddata = "ajax/change_status.php?turn=online";
    $.ajax({
        async:false,
        cache:false,
        url:senddata,
        type:"GET",
        dataType:"text",
        success:function (data) {
			$("#ls_status").html(data);
        }
    });
}

function turn_offline() {
	var senddata = "ajax/change_status.php?turn=offline";
    $.ajax({
        async:false,
        cache:false,
        url:senddata,
        type:"GET",
        dataType:"text",
        success:function (data) {
			$("#ls_status").html(data);
        }
    });
}

function send(session_id) {
	var senddata = "ajax/operator.php?type=send_message";
	var message = $("#form_msg").val();
	if(message == "") { alert("Please enter your message."); }
	else {
		$.ajax({
				async:false,
				cache:false,
				url:senddata,
				type:"POST",
				data: { session_id: session_id, message: message },
				dataType:"text",
				success:function (data) {
					$("#form_msg").val("");
					$("#messages").append(data).scrollTop($("#messages")[0].scrollHeight);;
				}
		});
	}
}

function send_q(session_id) {
	var senddata = "ajax/operator.php?type=send_question";
	var message = $("#fast_msg").val();
	if(message == "") { alert("Please select your message."); }
	else {
		$.ajax({
				async:false,
				cache:false,
				url:senddata,
				type:"POST",
				data: { session_id: session_id, message: message },
				dataType:"text",
				success:function (data) {
					$("#fast_msg").val("");
					$("#messages").append(data).scrollTop($("#messages")[0].scrollHeight);;
				}
		});
	}
}