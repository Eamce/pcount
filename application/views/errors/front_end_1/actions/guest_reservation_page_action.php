<script type="text/javascript">
	function isDate(txtDate)
	{
		var currVal = txtDate;
		if(currVal == '')
			return false;
		var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
		var dtArray = currVal.match(rxDatePattern); 
		if (dtArray == null) 
			return false;
		dtMonth = dtArray[1];
		dtDay= dtArray[3];
		dtYear = dtArray[5];        
		if (dtMonth < 1 || dtMonth > 12) 
			return false;
		else if (dtDay < 1 || dtDay> 31) 
			return false;
		else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31) 
			return false;
		else if (dtMonth == 2) 
		{
			var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
			if (dtDay> 29 || (dtDay ==29 && !isleap)) 
				return false;
		}
		return true;
	}
	$('.btn_reserve').on('click', function(){
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		var bday = $('#bday').val();
		var fname = $('#fname').val();
		var lname = $('#lname').val();
		var email = $('#email').val();
		var pnum = $('#pnum').val();
		var country = $('#country').val();
		var dtfrom = $('#dtfrom').val();
		var dtto = $('#dtto').val();
		var adult = $('#adult').val();
		var children = $('#children').val();
		var gender = $('#gender').val();
		var company = $('#company').val();
		var address = $('#address').val();
		var notes = $('#notes').val();
		var rtype_id = $('#rtype_id').val();
		var room_num = $('#room_num').val();
		var age = $('#age').val();
		if(bday == '' || fname == '' || lname == '' || email == '' || pnum ==''|| country =='' ||dtfrom == '' || dtto =='' || gender ==''|| address =='' || rtype_id == '' || room_num == ''){
			swal({
				title: "Information",
				text: "(*) Required fields must not be empty.",
				type: "info"
			});
		}else if(!re.test(email) || !/^[0-9]*$/g.test(pnum)){
			if(!re.test(email) && !/^[0-9]*$/g.test(pnum)){
				swal({
					title: "Information",
					text:  'Invalid input, please check you Email & Phone Number and try again.',
					type: "info"
				});
			}
			else if(!re.test(email)){
				swal({
					title: "Information",
					text:  'Invalid input, please check you Email and try again.',
					type: "info"
				});
			}
			else if(!/^[0-9]*$/g.test(pnum)){
				swal({
					title: "Information",
					text:  'Invalid input, please check you Phone Number and try again.',
					type: "info"
				});
			}
		}else if(adult == ''){
			if(adult == '' && children !=  ''){
				swal({
					title: "Information",
					text:  "Invalid to reserve, children's without an adult or guardian are not allowed.",
					type: "info"
				});
			}else{
				swal({
					title: "Information",
					text:  "Please input  No. of Adult's and/or Children's",
					type: "info"
				});
			}
		}
		else{
			if(age <= 17){
				var gen = '';
				var gn = '';
				if(gender == 'MALE'){
					gen = 'Mr. '+fname+' '+lname;
					gn = 'his';
				}else{
					gen = 'Ms. '+fname+' '+lname;
					gn = 'her';
				}
				swal({
					title: "Information",
					text: "Sorry!,"+gen+" you are below 18 can't Check-In or Reserve by your own, under the company rules."
				});
				setTimeout("window.location.reload();",3000);
			}else{
				$.post('front_end/save_guest_reservation_online',
				{
					bday:bday,
					fname:fname,
					lname:lname,
					email:email,
					pnum:pnum,
					country:country,
					dtfrom:dtfrom,
					dtto:dtto,
					adult:adult,
					children:children,
					gender:gender,
					company:company,
					address:address,
					notes:notes,
					rtype_id:rtype_id,
					room_num:room_num
				}, 
				function(msg){
					if(!/^[0-9]*$/g.test(msg.trim())){
						swal({
							title: "Information",
							text:  msg,
							type: "info"
						});
					}else{
						$.post('front_end/get_invoice_data', 
						{
							t_g_id:msg
						}, 
						function(datas){
							$('#invoice').html(datas);
							$('#reservation-page').hide();
							$('#invoice').show();
						});
					}
				});	
			}
		}
	});
	$(function(){	
		$('#reservation-page').show();
		$('#invoice').hide();
		$('#btn_reserve').prop('disabled', true);
	});
	$('#bday').on('change', function(){
		var bday = $(this).val();
		$.ajax({
			url:'file/check_bday_input',
			method:'POST',
			data:{
				bday:bday
			},
			dataType:'json',
			success:function(msg){
				if(msg.trim() == 'error1'){
					swal({
						title: "Information",
						text:'Invalid birth date input, please check and try again.'
					});
					$('#age').val('');
					$('#dtfrom, #dtto').prop('disabled', true);
				}else if(msg.trim() == 'error2'){
					swal({
						title: "Information",
						text:'Sorry, Age below 18yrs old is not allowed to reserve.'
					});
					$('#age').val('');
					$('#dtfrom, #dtto').prop('disabled', true);
					setTimeout("window.location.reload();",4000);
				}
				else{
					$('#age').val(msg);
					$('#dtfrom, #dtto').prop('disabled', false);
				}
			}
		});
	});
	$('#dtfrom, #dtto').on('change', function(){
		var dtfrom = $('#dtfrom').val();
		var dtto = $('#dtto').val();
		var rtype_id = $('#rtype_id').val();
		if(dtfrom != '' && dtto != ''){
			if(dtfrom  >= dtto){
				swal({
					title: "Information",
					text:  'Invalid date input, please check Arrival/Departure date and try again.',
				});
				$('#room_num').prop('disabled', true);
				$('#btn_reserve').prop('disabled', true);
			}else{
				$.post('front_end/compute_arrivate_date', 
				{
					dtfrom:dtfrom
				}, 
				function(msg){
					if(msg.trim() != 'success'){
						swal({
							title: "Information",
							text:  msg,
						});
						$('#room_num').prop('disabled', true);
						$('#btn_reserve').prop('disabled', true);
					}else{
						
						$.post('transaction/count_check_in_dates', 
						{
							c_in:dtfrom
						}, 
						function(msg){
							if(msg.trim() == 'success'){
								$.ajax({
									url:'transaction/get_room_by_rt',
									method:'POST',
									data:{
										dt_ci:dtfrom,
										dt_co:dtto,
										rt:rtype_id
									},
									dataType:'json',
									success:function(data){
										$.each(data, function(i, d) {
											$('#room_num').append($('<option/>',{
												value:d.room_id,
												text:d.room
											}));
										});
										$('#room_num').prop('disabled', false);
										$('#btn_reserve').prop('disabled', false);
									}
								});
							}else{
								swal({
									title: "Information",
									text:msg
								});
								$('#room_num').prop('disabled', true);
								$('#btn_reserve').prop('disabled', true);
							}
						});
					}
				});
			}
		}else{
			if(dtfrom != ''){
				$.post('front_end/compute_arrivate_date', 
				{
					dtfrom:dtfrom
				}, 
				function(msg){
					if(msg.trim() != 'success'){
						swal({
							title: "Information",
							text:  msg,
						});
						$('#room_num').prop('disabled', true);
						$('#btn_reserve').prop('disabled', true);
						$('#dtto').prop('disabled', true);
					}else{
						$.post('transaction/count_check_in_dates', 
						{
							c_in:dtfrom
						}, 
						function(msg){
							if(msg.trim() != 'success'){
								swal({
									title: "Information",
									text:msg
								});
								$('#room_num').prop('disabled', true);
								$('#btn_reserve').prop('disabled', true);
								$('#dtto').prop('disabled', true);
							}else{
								$('#dtto').prop('disabled', false);
							}
						});
					}
				});
			}
		}
	});
</script>