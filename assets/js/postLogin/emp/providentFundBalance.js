function ProvidentFundBalance() {
}
ProvidentFundBalance.init = function() {
    try {
       	$('#id_fromPFPeriod').change(function(){
            ProvidentFundBalance.selectFromPFPeriod();
        });
        $('#id_toPFPeriod').change(function(){
            ProvidentFundBalance.selectToPFPeriod();
        });		
    } catch (e) {
        console.log(e);
    }
};

ProvidentFundBalance.selectFromPFPeriod = function(){
	try {
	var v_fromYear = $('#id_fromPFPeriod').val();
	var base_url = $('#base').val();
        $.ajax({
            url:base_url+"Employee/getToPFPeriod",
            method: 'post',
            data: {v_fromYear: v_fromYear},
            dataType: 'json',
            success: function(prm_objResponse){
            // Remove options  
            $('#id_toPFPeriod').find('option').not(':first').remove(); 
            // Add options
            $.each(prm_objResponse,function(index,data){
            $('#id_toPFPeriod').append('<option value="'+data['TO_YEAR']+'">'+data['TO_YEAR']+'</option>');
            });
            }
        });
        } catch (e) {
		console.log(e);
	}
};

ProvidentFundBalance.selectToPFPeriod = function(){
	try {
		var base_url = $('#base').val();
		$.post({
			url : base_url+"Employee/getPFAccountStatementSummary",
			data : {
				v_fromYear : $('#id_fromPFPeriod').val(),
				v_toYear : $('#id_toPFPeriod').val()
			},
			cache : false,
		}).done(function(prm_objResponse) {
			console.log(prm_objResponse);
			objResponse = JSON.parse(prm_objResponse);
			ProvidentFundBalance.renderPFEmpDtlHTML(objResponse);
			//ProvidentFundBalance.renderCPFEmpDtlHTML(objResponse);
		}).fail(function(prm_objError) {
			console.log(prm_objError);
		});
	} catch (e) {
		console.log(e);
	}
};

/* render renderPFEmpDtlHTML HTML */
ProvidentFundBalance.renderPFEmpDtlHTML = function(objResponse) {
	//console.dir(document.locaction);
	var v_from = $('#id_fromPFPeriod').val();
	var v_to = $('#id_toPFPeriod').val();
	var v_gPFEmpDtlList = objResponse.getGPFAccountStatementSummary;
	var v_gPFTotal = objResponse.getTotalGPF;
	var v_gPFClosingBalance = objResponse.getClosingGPF;
	var v_gPFEmpDtlList_data = "";
	var v_cPFEmpDtlList = objResponse.getCPFAccountStatementSummary;
	var v_cPFClosingBalanceEmployee = objResponse.getClosingEmployeeCPF;
	var v_cPFEmpDtlList_data = "";
	
	try {
		if (v_gPFEmpDtlList.length > 0) {
			v_gPFEmpDtlList_data += '<div class="col-md-12 ">';
			v_gPFEmpDtlList_data += '<div style="max-width: 100% ; margin-left: auto ; margin-right: auto ;">';
			//v_pFEmpDtlList_data +=document.write("<img src='C:/xampp/htdocs/CI/application/assets/images/appllogo1.png' alt='alt tag'>");
			v_gPFEmpDtlList_data += '<img src="C:/xampp/htdocs/CI/application/assets/images/appllogo1.png" alt="" style="width: 80px; height: 80px; float: left ;">';
			v_gPFEmpDtlList_data += '</div>';
			v_gPFEmpDtlList_data += '<div style="width: 400px ;max-width: 100% ;margin-left: auto ;margin-right: auto ;color: blue;font-family: Arial;font-weight: bold;text-align: center;">';
			//v_pFEmpDtlList_data += '<center style="color: blue;font-family: Arial;font-weight: bold;">';
			v_gPFEmpDtlList_data += '<p style="font-size:25px;">Finance And Account Office</p>';
			v_gPFEmpDtlList_data += '<p style="font-size:22px;">PF & Pension Section,</p>';
			v_gPFEmpDtlList_data += '<p style="font-size:22px;">Jamia Millia Islamia</p>';
			v_gPFEmpDtlList_data += '<p style="font-size:16px;">(A Central University by an act of Parliament)</p>';
			v_gPFEmpDtlList_data += '<p style="font-size:22px; text-align: center;color: blue;">New Delhi - 110025</p><br><br>';
			v_gPFEmpDtlList_data += '</div>';
			for (i = 0; i < v_gPFEmpDtlList.length; i++) {
				var dataList = v_gPFEmpDtlList[i];
				if (dataList["EMP_PF_TYPE"] == 'G') {
					v_gPFEmpDtlList_data += '<p style="font-size:20px;text-align: center; color:blue;">Annual Statement of G.P.F A/C for the Financial Year <b>From :</b> '+v_from+'  <b>To :</b> '+v_to+' </p>';
				} else {
					v_gPFEmpDtlList_data += '<p style="font-size:20px;text-align: center; color:blue;">Annual Statement of P.F A/C for the Financial Year <b>From :</b> '+v_from+'  <b>To :</b> '+v_to+' </p>';
				}
			}			
			//v_pFEmpDtlList_data += '</center>';
			v_gPFEmpDtlList_data += '<table class="table table-striped table-bordered table-hover">';
			for (i = 0; i < v_gPFEmpDtlList.length; i++) {
				var dataList = v_gPFEmpDtlList[i];
				v_gPFEmpDtlList_data += '<tr>';
				v_gPFEmpDtlList_data += '<td valign="top" align="left"><span style=" font-weight: bold;">PF A/C No</b> ';
				v_gPFEmpDtlList_data += '<td valign="top" align="left">' + dataList["EMP_PF_NO"] + '</td>';
				v_gPFEmpDtlList_data += '<td valign="top" align="left"><span style=" font-weight: bold;">Employee Id</b> ';
				v_gPFEmpDtlList_data += '<td valign="top" align="left">' + dataList["EMP_ID"] + '</td>';
				v_gPFEmpDtlList_data += '</tr>';
				v_gPFEmpDtlList_data += '<tr>';
				v_gPFEmpDtlList_data += '<td valign="top" align="left"><span style=" font-weight: bold;">Employee Name</b> ';
				v_gPFEmpDtlList_data += '<td valign="top" align="left">' + dataList["EMP_NAME"] + '</td>';
				v_gPFEmpDtlList_data += '<td valign="top" align="left"><span style=" font-weight: bold;">Designation</b> ';
				v_gPFEmpDtlList_data += '<td valign="top" align="left">' + dataList["DSG_DESC"] + '</td>';
				v_gPFEmpDtlList_data += '</tr>';
				v_gPFEmpDtlList_data += '<tr>';
				v_gPFEmpDtlList_data += '<td valign="top" align="left"><span style=" font-weight: bold;">Department</b> ';
				v_gPFEmpDtlList_data += '<td valign="top" align="left" colspan="3">' + dataList["DEP_DESC"] + '</td>';
				v_gPFEmpDtlList_data += '</tr>';
				v_gPFEmpDtlList_data += '<table class="table table-striped table-bordered table-hover"'+
				'align="center" style="font-size:15px; font-family:Calibri;border: 2px solid black;border-color: coral">';
				v_gPFEmpDtlList_data += '<thead style=" font-weight: bold;text-align: center;">';
				v_gPFEmpDtlList_data += '<tr>';
				v_gPFEmpDtlList_data += '<td valign="top" align="left" colspan="6"><span style=" font-weight: bold; padding-left: 40%;">S&nbsp;&nbsp;U&nbsp;&nbsp;B&nbsp;&nbsp;S&nbsp;&nbsp;C&nbsp;&nbsp;R&nbsp;&nbsp;I&nbsp;&nbsp;P&nbsp;&nbsp;T&nbsp;&nbsp;I&nbsp;&nbsp;O&nbsp;&nbsp;N</b> ';
				v_gPFEmpDtlList_data += '</tr>';
				v_gPFEmpDtlList_data += '<tr>';
				v_gPFEmpDtlList_data += '<td>Opening Balance <br>(Rs)</td><i class="fa fa-inr" aria-hidden="true"></i>';
				v_gPFEmpDtlList_data += '<td>Deposit & Refund <br>(Rs.)</td><i class="fa fa-inr" aria-hidden="true"></i>';
				v_gPFEmpDtlList_data += '<td>Interest</td> ';
				v_gPFEmpDtlList_data += '<td>TOTAL (Rs.)</td><i class="fa fa-inr" aria-hidden="true"></i>';
				v_gPFEmpDtlList_data += '<td>Withdrawal<br> (During the year)<br>(Rs.)<i class="fa fa-rupee"></i></td>';
				v_gPFEmpDtlList_data += '<td>Closing Balance <br>(Rs)</td>';
				v_gPFEmpDtlList_data += '</tr>';
				v_gPFEmpDtlList_data += '</thead>';
				v_gPFEmpDtlList_data += '<tbody>';
				v_gPFEmpDtlList_data += '<tr style="text-align:right">';
				v_gPFEmpDtlList_data += '<td>' + dataList["PF_OPENG"] + '</td>';
				v_gPFEmpDtlList_data += '<td>' + dataList["RECOVERED"] + '</td>';
				v_gPFEmpDtlList_data += '<td>' + dataList["INTEREST"] + '</td> ';
				for (i = 0; i < v_gPFTotal.length; i++) {
				var dataList = v_gPFTotal[i];
					v_gPFEmpDtlList_data += '<td>' + dataList["TOTAL"] + '</td>';
				}
				for (i = 0; i < v_gPFEmpDtlList.length; i++) {
				var dataList = v_gPFEmpDtlList[i];
					v_gPFEmpDtlList_data += '<td>' + dataList["WITHDRAWAL"] + '</td>';
				}
				for (i = 0; i < v_gPFClosingBalance.length; i++) {
				var dataList = v_gPFClosingBalance[i];
					v_gPFEmpDtlList_data += '<td>' + dataList["CLOSING_BALANCE"] + '</td>';
				}
				v_gPFEmpDtlList_data += '</tr>';
				v_gPFEmpDtlList_data += '</tbody>';
				v_gPFEmpDtlList_data += '</table>';
			}
			v_gPFEmpDtlList_data += '</table>';
			v_gPFEmpDtlList_data += '<br<br><p>NOTE: THE SUBSCRIBER IS REQUESTED TO SATISFY HIMSELF/HERSELF AS TO THE CORRECTNESS OF THE'+
			'STATEMENT AND TO BRING ERRORS,IF ANY,TO THE NOTICE OF THE ACCOUNTS OFFICER.</p>'
			v_gPFEmpDtlList_data += '</div>';
			
			$("#id_pFEmpDtl").html(v_gPFEmpDtlList_data);
		} else if (v_cPFEmpDtlList.length > 0) {
			v_cPFEmpDtlList_data += '<div class="col-md-12 ">';
			v_cPFEmpDtlList_data += '<div style="max-width: 100% ; margin-left: auto ; margin-right: auto ;">';
			//v_pFEmpDtlList_data +=document.write("<img src='C:/xampp/htdocs/CI/application/assets/images/appllogo1.png' alt='alt tag'>");
			v_cPFEmpDtlList_data += '<img src="C:/xampp/htdocs/CI/application/assets/images/appllogo1.png" alt="" style="width: 80px; height: 80px; float: left ;">';
			v_cPFEmpDtlList_data += '</div>';
			v_cPFEmpDtlList_data += '<div style="width: 400px ;max-width: 100% ;margin-left: auto ;margin-right: auto ;color: blue;font-family: Arial;font-weight: bold;text-align: center;">';
			//v_pFEmpDtlList_data += '<center style="color: blue;font-family: Arial;font-weight: bold;">';
			v_cPFEmpDtlList_data += '<p style="font-size:25px;">Finance And Account Office</p>';
			v_cPFEmpDtlList_data += '<p style="font-size:22px;">PF & Pension Section,</p>';
			v_cPFEmpDtlList_data += '<p style="font-size:22px;">Jamia Millia Islamia</p>';
			v_cPFEmpDtlList_data += '<p style="font-size:16px;">(A Central University by an act of Parliament)</p>';
			v_cPFEmpDtlList_data += '<p style="font-size:22px; text-align: center;color: blue;">New Delhi - 110025</p><br><br>';
			v_cPFEmpDtlList_data += '</div>';
			for (i = 0; i < v_cPFEmpDtlList.length; i++) {
				var dataList = v_cPFEmpDtlList[i];
				if (dataList["EMP_PF_TYPE"] == 'C') {
					v_cPFEmpDtlList_data += '<p style="font-size:20px;text-align: center; color:blue;">Annual Statement of C.P.F A/C for the Financial Year <b>From :</b> '+v_from+'  <b>To :</b> '+v_to+' </p>';
				} else {
					v_cPFEmpDtlList_data += '<p style="font-size:20px;text-align: center; color:blue;">Annual Statement of P.F A/C for the Financial Year <b>From :</b> '+v_from+'  <b>To :</b> '+v_to+' </p>';
				}
			}
			
			//v_pFEmpDtlList_data += '</center>';
			v_cPFEmpDtlList_data += '<table class="table table-striped table-bordered table-hover">';
			for (i = 0; i < v_cPFEmpDtlList.length; i++) {
				var dataList = v_cPFEmpDtlList[i];
				v_cPFEmpDtlList_data += '<tr>';
				v_cPFEmpDtlList_data += '<td valign="top" align="left"><span style=" font-weight: bold;">PF A/C No</b> ';
				v_cPFEmpDtlList_data += '<td valign="top" align="left">' + dataList["EMP_PF_NO"] + '</td>';
				v_cPFEmpDtlList_data += '<td valign="top" align="left"><span style=" font-weight: bold;">Employee Id</b> ';
				v_cPFEmpDtlList_data += '<td valign="top" align="left">' + dataList["EMP_ID"] + '</td>';
				v_cPFEmpDtlList_data += '</tr>';
				v_cPFEmpDtlList_data += '<tr>';
				v_cPFEmpDtlList_data += '<td valign="top" align="left"><span style=" font-weight: bold;">Employee Name</b> ';
				v_cPFEmpDtlList_data += '<td valign="top" align="left">' + dataList["EMP_NAME"] + '</td>';
				v_cPFEmpDtlList_data += '<td valign="top" align="left"><span style=" font-weight: bold;">Designation</b> ';
				v_cPFEmpDtlList_data += '<td valign="top" align="left">' + dataList["DSG_DESC"] + '</td>';
				v_cPFEmpDtlList_data += '</tr>';
				v_cPFEmpDtlList_data += '<tr>';
				v_cPFEmpDtlList_data += '<td valign="top" align="left"><span style=" font-weight: bold;">Department</b> ';
				v_cPFEmpDtlList_data += '<td valign="top" align="left" colspan="3">' + dataList["DEP_DESC"] + '</td>';
				v_cPFEmpDtlList_data += '</tr>';
				v_cPFEmpDtlList_data += '<table class="table table-striped table-bordered table-hover"'+
				'align="center" style="font-size:15px; font-family:Calibri;border: 2px solid black;border-color: coral">';
				v_cPFEmpDtlList_data += '<thead style=" font-weight: bold;text-align: center;">';
				v_cPFEmpDtlList_data += '<tr>';
				v_cPFEmpDtlList_data += '<td valign="top" align="left" colspan="5"><span style=" font-weight: bold; padding-left: 20%;">CPF SUBSCRIPTION (Employee Share)</b> ';
				v_cPFEmpDtlList_data += '<td valign="top" align="left" colspan="5"><span style=" font-weight: bold; padding-left: 20%;">CPF CONTRIBUTION (Employer Share)</b> ';
				v_cPFEmpDtlList_data += '</tr>';
				v_cPFEmpDtlList_data += '<tr>';
				v_cPFEmpDtlList_data += '<td>Opening Balance <br>(Rs)</td><i class="fa fa-inr" aria-hidden="true"></i>';
				v_cPFEmpDtlList_data += '<td>Deposit & Refund <br>(Rs.)</td><i class="fa fa-inr" aria-hidden="true"></i>';
				v_cPFEmpDtlList_data += '<td>Interest</td> ';
				v_cPFEmpDtlList_data += '<td>Withdrawal<br> (During the year)<br>(Rs.)</td><i class="fa fa-inr" aria-hidden="true"></i>';
				v_cPFEmpDtlList_data += '<td>Closing Balance <br>(Rs)</td>';
				v_cPFEmpDtlList_data += '<td>Opening Balance <br>(Rs)</td>';
				v_cPFEmpDtlList_data += '<td>Deposit</td> ';
				v_cPFEmpDtlList_data += '<td>Interest</td>';
				v_cPFEmpDtlList_data += '<td>Withdrawal<br> (During the year)<br>(Rs.)<i class="fa fa-rupee"></i></td>';
				v_cPFEmpDtlList_data += '<td>Closing Balance <br>(Rs)</td>';
				v_cPFEmpDtlList_data += '</tr>';
				v_cPFEmpDtlList_data += '</thead>';
				v_cPFEmpDtlList_data += '<tbody>';
				v_cPFEmpDtlList_data += '<tr style="text-align:right">';
				v_cPFEmpDtlList_data += '<td>' + dataList["PF_OPENG"] + '</td>';
				v_cPFEmpDtlList_data += '<td>' + dataList["RECOVERED"] + '</td>';
				v_cPFEmpDtlList_data += '<td>' + dataList["INTEREST"] + '</td> ';
				v_cPFEmpDtlList_data += '<td>' + dataList["WITHDRAWAL"] + '</td>';
				for (i = 0; i < v_cPFClosingBalanceEmployee.length; i++) {
				var dataList = v_cPFClosingBalanceEmployee[i];
					v_cPFEmpDtlList_data += '<td>' + dataList["CLOSING_BALANCE_EMPLOYEE"] + '</td>';
				}
				
				for (i = 0; i < v_cPFEmpDtlList.length; i++) {
				var dataList = v_cPFEmpDtlList[i];
				v_cPFEmpDtlList_data += '<td>' + dataList["PFO_OPENG_CPF"] + '</td>';
				v_cPFEmpDtlList_data += '<td>' + dataList["DEPOSITS_CPF"] + '</td>';
				v_cPFEmpDtlList_data += '<td>' + dataList["PFO_INT_TOT_PF"] + '</td> ';
				v_cPFEmpDtlList_data += '<td>' + dataList["WITH_CPF"] + '</td> ';					
				v_cPFEmpDtlList_data += '<td>' + dataList["PFO_CLOSG_CPF"] + '</td>';
				}
				
				v_cPFEmpDtlList_data += '</tr>';
				v_cPFEmpDtlList_data += '</tbody>';
				v_cPFEmpDtlList_data += '</table>';
			}
			v_cPFEmpDtlList_data += '</table>';
			v_cPFEmpDtlList_data += '<br<br><p>NOTE: THE SUBSCRIBER IS REQUESTED TO SATISFY HIMSELF/HERSELF AS TO THE CORRECTNESS OF THE'+
			'STATEMENT AND TO BRING ERRORS,IF ANY,TO THE NOTICE OF THE ACCOUNTS OFFICER.</p>'
			v_cPFEmpDtlList_data += '</div>';
			
			$("#id_pFEmpDtl").html(v_cPFEmpDtlList_data);
		} else {
			$("#id_pFEmpDtl").html('<tr><td colspan="6">No Data</td></tr>');
		}

	} catch (e) {
		console.log(e);
	}
};
/* end render renderCPFEmpDtlHTML HTML */

/*ProvidentFundBalance.renderCPFEmpDtlHTML = function(objResponse) {
	var v_from = $('#id_fromPFPeriod').val();
	var v_to = $('#id_toPFPeriod').val();
	var v_cPFEmpDtlList = objResponse.getCPFAccountStatementSummary;
	var v_cPFTotal = objResponse.getTotalCPF;
	var v_cPFClosingBalance = objResponse.getClosingCPF;
	var v_cPFEmpDtlList_data = "";
	
	try {
		if (v_cPFEmpDtlList.length > 0) {
			v_cPFEmpDtlList_data += '<div class="col-md-12 ">';
			v_cPFEmpDtlList_data += '<div style="max-width: 100% ; margin-left: auto ; margin-right: auto ;">';
			//v_pFEmpDtlList_data +=document.write("<img src='C:/xampp/htdocs/CI/application/assets/images/appllogo1.png' alt='alt tag'>");
			v_cPFEmpDtlList_data += '<img src="C:/xampp/htdocs/CI/application/assets/images/appllogo1.png" alt="" style="width: 80px; height: 80px; float: left ;">';
			v_cPFEmpDtlList_data += '</div>';
			v_cPFEmpDtlList_data += '<div style="width: 400px ;max-width: 100% ;margin-left: auto ;margin-right: auto ;color: blue;font-family: Arial;font-weight: bold;text-align: center;">';
			//v_pFEmpDtlList_data += '<center style="color: blue;font-family: Arial;font-weight: bold;">';
			v_cPFEmpDtlList_data += '<p style="font-size:25px;">Finance And Account Office</p>';
			v_cPFEmpDtlList_data += '<p style="font-size:22px;">PF & Pension Section,</p>';
			v_cPFEmpDtlList_data += '<p style="font-size:22px;">Jamia Millia Islamia</p>';
			v_cPFEmpDtlList_data += '<p style="font-size:16px;">(A Central University by an act of Parliament)</p>';
			v_cPFEmpDtlList_data += '<p style="font-size:22px; text-align: center;color: blue;">New Delhi - 110025</p><br><br>';
			v_cPFEmpDtlList_data += '</div>';
			for (i = 0; i < v_cPFEmpDtlList.length; i++) {
				var dataList = v_cPFEmpDtlList[i];
				if (dataList["EMP_PF_TYPE"] == 'C') {
					v_cPFEmpDtlList_data += '<p style="font-size:20px;text-align: center; color:blue;">Annual Statement of C.P.F A/C for the Financial Year <b>From :</b> '+v_from+'  <b>To :</b> '+v_to+' </p>';
				} else if (dataList["EMP_PF_TYPE"] == 'G') {
					v_cPFEmpDtlList_data += '<p style="font-size:20px;text-align: center; color:blue;">Annual Statement of G.P.F A/C for the Financial Year <b>From :</b> '+v_from+'  <b>To :</b> '+v_to+' </p>';
				} else if (dataList["EMP_PF_TYPE"] == 'N') {
					v_cPFEmpDtlList_data += '<p style="font-size:20px;text-align: center; color:blue;">Annual Statement of N.P.S A/C for the Financial Year <b>From :</b> '+v_from+'  <b>To :</b> '+v_to+' </p>';
				} else {
					v_cPFEmpDtlList_data += '<p style="font-size:20px;text-align: center; color:blue;">Annual Statement of P.F A/C for the Financial Year <b>From :</b> '+v_from+'  <b>To :</b> '+v_to+' </p>';
				}
			}
			
			//v_pFEmpDtlList_data += '</center>';
			v_cPFEmpDtlList_data += '<table class="table table-striped table-bordered table-hover">';
			for (i = 0; i < v_cPFEmpDtlList.length; i++) {
				var dataList = v_cPFEmpDtlList[i];
				v_cPFEmpDtlList_data += '<tr>';
				v_cPFEmpDtlList_data += '<td valign="top" align="left"><span style=" font-weight: bold;">PF A/C No</b> ';
				v_cPFEmpDtlList_data += '<td valign="top" align="left">' + dataList["EMP_PF_NO"] + '</td>';
				v_cPFEmpDtlList_data += '<td valign="top" align="left"><span style=" font-weight: bold;">Employee Id</b> ';
				v_cPFEmpDtlList_data += '<td valign="top" align="left">' + dataList["EMP_ID"] + '</td>';
				v_cPFEmpDtlList_data += '</tr>';
				v_cPFEmpDtlList_data += '<tr>';
				v_cPFEmpDtlList_data += '<td valign="top" align="left"><span style=" font-weight: bold;">Employee Name</b> ';
				v_cPFEmpDtlList_data += '<td valign="top" align="left">' + dataList["EMP_NAME"] + '</td>';
				v_cPFEmpDtlList_data += '<td valign="top" align="left"><span style=" font-weight: bold;">Designation</b> ';
				v_cPFEmpDtlList_data += '<td valign="top" align="left">' + dataList["DSG_DESC"] + '</td>';
				v_cPFEmpDtlList_data += '</tr>';
				v_cPFEmpDtlList_data += '<tr>';
				v_cPFEmpDtlList_data += '<td valign="top" align="left"><span style=" font-weight: bold;">Department</b> ';
				v_cPFEmpDtlList_data += '<td valign="top" align="left" colspan="3">' + dataList["DEP_DESC"] + '</td>';
				v_cPFEmpDtlList_data += '</tr>';
				v_cPFEmpDtlList_data += '<table class="table table-striped table-bordered table-hover"'+
				'align="center" style="font-size:15px; font-family:Calibri;border: 2px solid black;border-color: coral">';
				v_cPFEmpDtlList_data += '<thead style=" font-weight: bold;text-align: center;">';
				v_cPFEmpDtlList_data += '<tr>';
				v_cPFEmpDtlList_data += '<td valign="top" align="left" colspan="6"><span style=" font-weight: bold; padding-left: 40%;">S&nbsp;&nbsp;U&nbsp;&nbsp;B&nbsp;&nbsp;S&nbsp;&nbsp;C&nbsp;&nbsp;R&nbsp;&nbsp;I&nbsp;&nbsp;P&nbsp;&nbsp;T&nbsp;&nbsp;I&nbsp;&nbsp;O&nbsp;&nbsp;N</b> ';
				v_cPFEmpDtlList_data += '</tr>';
				v_cPFEmpDtlList_data += '<tr>';
				v_cPFEmpDtlList_data += '<td>Opening Balance <br>(Rs)</td><i class="fa fa-inr" aria-hidden="true"></i>';
				v_cPFEmpDtlList_data += '<td>Deposit & Refund <br>(Rs.)</td><i class="fa fa-inr" aria-hidden="true"></i>';
				v_cPFEmpDtlList_data += '<td>Interest</td> ';
				v_cPFEmpDtlList_data += '<td>TOTAL (Rs.)</td><i class="fa fa-inr" aria-hidden="true"></i>';
				v_cPFEmpDtlList_data += '<td>Withdrawal<br> (During the year)<br>(Rs.)<i class="fa fa-rupee"></i></td>';
				v_cPFEmpDtlList_data += '<td>Closing Balance <br>(Rs)</td>';
				v_cPFEmpDtlList_data += '</tr>';
				v_cPFEmpDtlList_data += '</thead>';
				v_cPFEmpDtlList_data += '<tbody>';
				v_cPFEmpDtlList_data += '<tr style="text-align:right">';
				v_cPFEmpDtlList_data += '<td>' + dataList["PF_OPENG"] + '</td>';
				v_cPFEmpDtlList_data += '<td>' + dataList["RECOVERED"] + '</td>';
				v_cPFEmpDtlList_data += '<td>' + dataList["INTEREST"] + '</td> ';
				for (i = 0; i < v_cPFTotal.length; i++) {
				var dataList = v_cPFTotal[i];
					v_cPFEmpDtlList_data += '<td>' + dataList["TOTAL"] + '</td>';
				}
				for (i = 0; i < v_cPFEmpDtlList.length; i++) {
				var dataList = v_cPFEmpDtlList[i];
					v_cPFEmpDtlList_data += '<td>' + dataList["WITHDRAWAL"] + '</td>';
				}
				for (i = 0; i < v_cPFClosingBalance.length; i++) {
				var dataList = v_cPFClosingBalance[i];
					v_cPFEmpDtlList_data += '<td>' + dataList["CLOSING_BALANCE"] + '</td>';
				}
				v_cPFEmpDtlList_data += '</tr>';
				v_cPFEmpDtlList_data += '</tbody>';
				v_cPFEmpDtlList_data += '</table>';
			}
			v_cPFEmpDtlList_data += '</table>';
			v_cPFEmpDtlList_data += '<br<br><p>NOTE: THE SUBSCRIBER IS REQUESTED TO SATISFY HIMSELF/HERSELF AS TO THE CORRECTNESS OF THE'+
			'STATEMENT AND TO BRING ERRORS,IF ANY,TO THE NOTICE OF THE ACCOUNTS OFFICER.</p>'
			v_cPFEmpDtlList_data += '</div>';
			
			$("#id_pFEmpDtl").html(v_cPFEmpDtlList_data);
		} else {
			$("#id_pFEmpDtl").html('<tr><td colspan="6">No Data</td></tr>');
		}

	} catch (e) {
		console.log(e);
	}
};
*/

$(document).ready(ProvidentFundBalance.init);