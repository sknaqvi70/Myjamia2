function EarnLeaveProgram() {
}
EarnLeaveProgram.init = function() {
    try {
       	$('#id_fromPeriod').change(function(){
            EarnLeaveProgram.selectFromPeriod();
        });
        $('#id_toPeriod').change(function(){
            EarnLeaveProgram.selectToPeriod();
        });		
    } catch (e) {
        console.log(e);
    }
};

EarnLeaveProgram.selectFromPeriod = function(){
	try {
	var v_from = $('#id_fromPeriod').val();
	var base_url = $('#base').val();
        $.ajax({
            url:base_url+"Employee/getToPeriod",
            method: 'post',
            data: {v_from: v_from},
            dataType: 'json',
            success: function(prm_objResponse){
            // Remove options  
            $('#id_toPeriod').find('option').not(':first').remove(); 
            // Add options
            $.each(prm_objResponse,function(index,data){
            $('#id_toPeriod').append('<option value="'+data['TO_DATE']+'">'+data['TO_DATE']+'</option>');
            });
            }
        });
        } catch (e) {
		console.log(e);
	}
};

EarnLeaveProgram.selectToPeriod = function(){
	try {
		var base_url = $('#base').val();
		$.post({
			url : base_url+"Employee/getDetailsEarnLeaveBalance",
			data : {
				v_from : $('#id_fromPeriod').val(),
				v_to : $('#id_toPeriod').val()
			},
			cache : false,
		}).done(function(prm_objResponse) {
			console.log(prm_objResponse);
			objResponse = JSON.parse(prm_objResponse);
			EarnLeaveProgram.renderEarnLeaveEmpDtlHTML(objResponse);
			EarnLeaveProgram.renderLeaveTakenDtlHTML(objResponse);
		}).fail(function(prm_objError) {
			console.log(prm_objError);
		});
	} catch (e) {
		console.log(e);
	}
};

/* render renderEarnLeaveEmpDtl HTML */
EarnLeaveProgram.renderEarnLeaveEmpDtlHTML = function(objResponse) {
	var v_from = $('#id_fromPeriod').val();
	var v_to = $('#id_toPeriod').val();
	var v_earnLeaveEmpDtlList = objResponse.getEarnLeaveEmpDtl;
	var v_enCashEmpDtlList = objResponse.getEnCashEmpDtl;
	var v_earnLeaveEmpDtlList_data = "";
	
	try {
		if (v_earnLeaveEmpDtlList.length > 0) {
			v_earnLeaveEmpDtlList_data += '<center>';
			v_earnLeaveEmpDtlList_data += '<p style="font-size:25px; font-family:Calibri;">Earn Leave Balance Report</p>';
			v_earnLeaveEmpDtlList_data += '<p style="font-size:20px; font-family:Calibri;">Period <b>From :</b> '+v_from+'  <b>To :</b> '+v_to+' </p>';
			v_earnLeaveEmpDtlList_data += '</center>';
			v_earnLeaveEmpDtlList_data += '<table class="table table-striped table-bordered table-hover">';
			for (i = 0; i < v_earnLeaveEmpDtlList.length; i++) {
				var dataList = v_earnLeaveEmpDtlList[i];
				v_earnLeaveEmpDtlList_data += '<tr>';
				v_earnLeaveEmpDtlList_data += '<td valign="top" align="left"><span style=" font-weight: bold;">Employee Id</b> ';
				v_earnLeaveEmpDtlList_data += '<td valign="top" align="left">' + dataList["LV_EMP_ID"] + '</td>';
				v_earnLeaveEmpDtlList_data += '</tr>';
				v_earnLeaveEmpDtlList_data += '<tr>';
				v_earnLeaveEmpDtlList_data += '<td valign="top" align="left"><span style=" font-weight: bold;">Employee Name</b> ';
				v_earnLeaveEmpDtlList_data += '<td valign="top" align="left">' + dataList["NAME"] + '</td>';
				v_earnLeaveEmpDtlList_data += '</tr>';
				v_earnLeaveEmpDtlList_data += '<tr>';
				v_earnLeaveEmpDtlList_data += '<td valign="top" align="left"><span style=" font-weight: bold;">Opening Balance</b> ';
				v_earnLeaveEmpDtlList_data += '<td valign="top" align="left">' + dataList["LV_OP_BAL"] + '</td>';
				v_earnLeaveEmpDtlList_data += '</tr>';
			}
			for (i = 0; i < v_enCashEmpDtlList.length; i++) {
				var dataList = v_enCashEmpDtlList[i];
				v_earnLeaveEmpDtlList_data += '<tr>';
				v_earnLeaveEmpDtlList_data += '<td valign="top" align="left"><span style=" font-weight: bold;">Total Encashed Leaves</b> ';
				v_earnLeaveEmpDtlList_data += '<td valign="top" align="left">' + dataList["SUM_ENC_LV"] + '</td>';
				v_earnLeaveEmpDtlList_data += '</tr>';
			}
			v_earnLeaveEmpDtlList_data += '</table>';
			
			
			$("#id_earnLeaveEmpDtl").html(v_earnLeaveEmpDtlList_data);
		} else {
			$("#id_earnLeaveEmpDtl").html('<tr><td colspan="6">No Data</td></tr>');
		}

	} catch (e) {
		console.log(e);
	}
};
/* end render renderEarnLeaveEmpDtl HTML */

EarnLeaveProgram.renderLeaveTakenDtlHTML = function(objResponse) {
	var v_leaveTakenDtlList = objResponse.getLeaveTakenDtl;
	var v_leaveTakenDtlList_data = "";
	
	try {
		if (v_leaveTakenDtlList.length > 0) {
			for (i = 0; i < v_leaveTakenDtlList.length; i++) {
				var dataList = v_leaveTakenDtlList[i];
				v_leaveTakenDtlList_data += '<tr>';
				v_leaveTakenDtlList_data += '<td valign="top" align="left">'+ dataList["LVD_LVM_TYPE"] +'</td>';
				v_leaveTakenDtlList_data += '<td valign="top" align="left">'+ dataList["LVD_FROM_DATE"] + '</td>';
				v_leaveTakenDtlList_data += '<td valign="top" align="left">'+ dataList["LVD_TO_DATE"] +'</td>';
				v_leaveTakenDtlList_data += '<td valign="top" align="left">' + dataList["LVD_NOOFDAYS"] + '</td>';
				v_leaveTakenDtlList_data += '<td valign="top" align="left">' + dataList["LVD_APPLY_DATE"] + '</td>';
				v_leaveTakenDtlList_data += '<td valign="top" align="left"></td>';
				v_leaveTakenDtlList_data += '</tr>';
			}
			v_leaveTakenDtlList_data += '<tr>';
			v_leaveTakenDtlList_data += '<td colspan="6">';
			v_leaveTakenDtlList_data += '<p style="font-size:15px; font-family:Calibri;font-weight: bold; color:red;">'+
			'<i>Please bring any discrepancy in the above information to the notice of Assistant Registrar (Leave Section )</i></p>';
			v_leaveTakenDtlList_data += '</td>';
			v_leaveTakenDtlList_data += '</tr>';
			$("#id_leaveTakenDtl").html(v_leaveTakenDtlList_data);
		} else {
			$("#id_leaveTakenDtl").html('<tr><td colspan="6">No Data</td></tr>');
		}

	} catch (e) {
		console.log(e);
	}
};





$(document).ready(EarnLeaveProgram.init);