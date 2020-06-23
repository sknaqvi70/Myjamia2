function AddProgram() {
}

AddProgram.init = function() {
    try {
       	$('#id_TP_Program_Start_Date').datetimepicker({
       		format: 'DD.MM.YYYY'
       	});
       	$('#id_TP_Program_Start_Time').datetimepicker({
       		format: 'HH:mm:ss A'
       	});
       	$('#id_TP_Program_End_Date').datetimepicker({
       		format: 'DD.MM.YYYY'
       	});
       	$('#id_TP_Program_End_Time').datetimepicker({
       		format: 'HH:mm:ss A'
       	});
        			
    } catch (e) {
        console.log(e);
    }
};

$(document).ready(AddProgram.init);

