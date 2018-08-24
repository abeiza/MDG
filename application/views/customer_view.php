<style>
	#EditDetail{
		display:none;
	}
	#confirm{
		display:none;
	}
	#FailEditHeader{
		display:none;
	}
	.Loader-indicator.fade-enter,
	.Loader-content.fade-enter {
		opacity: 0;
	}

	.Loader-indicator.fade-enter-active,
	.Loader-content.fade-enter-active {
		opacity: 1;
	}

	.Loader-indicator.fade-leave,
	.Loader-content.fade-leave {
		opacity: 1;
	}

	.Loader-indicator.fade-leave-active,
	.Loader-content.fade-leave-active {
		opacity: 0;
	}

	.Loader-content,
	.Loader-indicator {
		transition: opacity 1s;
	}

	.Loader-ellipsisDot {
		padding: 0 3px 0 1px;
		opacity: 0;
		animation-duration: 3000ms;
		animation-iteration-count: infinite;
		animation-timing-function: linear;
	}

	@keyframes Loader-ellipsisDot1 {
		0%   { opacity: 0; }
		25%  { opacity: 0; }
		35%  { opacity: 1; }
		100% { opacity: 1; }
	}

	@keyframes Loader-ellipsisDot2 {
		0%   { opacity: 0; }
		50%  { opacity: 0; }
		60%  { opacity: 1; }
		100% { opacity: 1; }
	}

	@keyframes Loader-ellipsisDot3 {
		0%   { opacity: 0; }
		75%  { opacity: 0; }
		85%  { opacity: 1; }
		100% { opacity: 1; }
	}

	.Loader-ellipsisDot:nth-child(1) {
		animation-name: Loader-ellipsisDot1;
	}

	.Loader-ellipsisDot:nth-child(2) {
		animation-name: Loader-ellipsisDot2;
	}

	.Loader-ellipsisDot:nth-child(3) {
		animation-name: Loader-ellipsisDot3;
	}

	#tbl-all tbody .odd td{
		background:#fff;
		font-size:13.5px;
	}

	#tbl-all tbody .even td{
		background:#fafafa;
		font-size:13.5px;
	}

	#tbl-vendor tbody .odd td{
		background:#fff;
		font-size:13.5px;
	}

	#tbl-vendor tbody .even td{
		background:#fafafa;
		font-size:13.5px;
	}

	#tbl-product tbody .odd td{
		background:#fff;
		font-size:13.5px;
	}

	#tbl-product tbody .even td{
		background:#fafafa;
		font-size:13.5px;
	}

	#tbl-packaging tbody .odd td{
		background:#fff;
		font-size:13.5px;
	}

	#tbl-packaging tbody .even td{
		background:#fafafa;
		font-size:13.5px;
	}

	#tbl-others tbody .odd td{
		background:#fff;
		font-size:13.5px;
	}

	#tbl-others tbody .even td{
		background:#fafafa;
		font-size:13.5px;
	}

	.tab{
		padding:10px 20px;
		font-family:'Roboto-Regular';
		font-size:13px;
		border:1px solid #ddd;
		color:#555;
		margin-right:5px;
		float:left;
		border-bottom:none;
		cursor:pointer;
	}
</style>
<script>
	function get_signout(){
		$("#confirm").css('display','flex');
		$(".span-confirm span").remove();
		$(".span-confirm").append('<span>Do you want to log off?</span>');
	}

	function linkDisplayNew(id){
			var elem = $(id).attr("class");
			var id_new = $(id).attr("id");
			window.location.href = '<?php echo base_url()?>'+elem+'/'+id_new;
	}

	function linkUpdate(){

	}

	function linkDisplayDraft(id){
		var elem = $(id).attr("class");
		//alert(elem);
		window.open('<?php echo base_url()?>index.php/request/get_display_draft/'+elem);
	}
</script>
<script>
	$(function(){
		$("#datepicker").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'
		});

		$("#noticeCnt").hide();
    var hei = $(window).innerHeight() - 145;
		var heibasic = $(window).innerHeight()-130;
		$('.menu-box, .list-box').css({ height: hei });
		$(window).resize(function(){
			$('.menu-box, .list-box').css({ height: hei });
		});

		$('#list-box-mobile').css({ height: heibasic });
		$(window).resize(function(){
			$('#list-box-mobile').css({ height: heibasic });
		});

		$("#save-btn").hide();
		$("#send-btn").hide();

		$('#customer_id_desktop').attr('readonly', true);
    $('#customer_title_desktop').attr("disabled", true);
    $('#customer_name_desktop').attr('readonly', true);
    $('#customer_type_desktop').attr("disabled", true);
    $('#customer_searchterm_desktop').attr('readonly', true);
    $('#customer_address1_desktop').attr('readonly', true);
    $('#customer_address2_desktop').attr('readonly', true);
    $('#customer_address3_desktop').attr('readonly', true);
    $('#customer_houseno_desktop').attr('readonly', true);
    $('#customer_city_desktop').attr('readonly', true);
    $('#customer_postalcode_desktop').attr('readonly', true);
    $('#customer_province_desktop').attr("disabled", true);
    $('#customer_country_desktop').attr('readonly', true);
    $('#customer_phone_desktop').attr('readonly', true);
    $('#customer_mobile_desktop').attr('readonly', true);
    $('#customer_npwp_desktop').attr('readonly', true);
    $('#customer_ppn_desktop').attr("disabled", true);
    $('#customer_bankkey_desktop').attr('readonly', true);
    $('#customer_accountno_desktop').attr('readonly', true);
    $('#customer_accountname_desktop').attr('readonly', true);
    $('#customer_paymentterm_desktop').attr('disabled', true);
    $('#customer_billtoparty_desktop').attr('readonly', true);
    $('#same_bill_toparty_desktop').attr('disabled', true);

    $('#customer_id_desktop').css('background', '#f9f9f9');
    $('#customer_title_desktop').css('background', '#f9f9f9');
    $('#customer_name_desktop').css('background', '#f9f9f9');
    $('#customer_type_desktop').css('background', '#f9f9f9');
    $('#customer_searchterm_desktop').css('background', '#f9f9f9');
    $('#customer_address1_desktop').css('background', '#f9f9f9');
    $('#customer_address2_desktop').css('background', '#f9f9f9');
    $('#customer_address3_desktop').css('background', '#f9f9f9');
    $('#customer_houseno_desktop').css('background', '#f9f9f9');
    $('#customer_city_desktop').css('background', '#f9f9f9');
    $('#customer_postalcode_desktop').css('background', '#f9f9f9');
    $('#customer_province_desktop').css('background', '#f9f9f9');
    $('#customer_country_desktop').css('background', '#f9f9f9');
    $('#customer_phone_desktop').css('background', '#f9f9f9');
    $('#customer_mobile_desktop').css('background', '#f9f9f9');
    $('#customer_npwp_desktop').css('background', '#f9f9f9');
    $('#customer_ppn_desktop').css('background', '#f9f9f9');
    $('#customer_bankkey_desktop').css('background', '#f9f9f9');
    $('#customer_accountno_desktop').css('background', '#f9f9f9');
    $('#customer_accountname_desktop').css('background', '#f9f9f9');
    $('#customer_paymentterm_desktop').css('background', '#f9f9f9');
    $('#customer_billtoparty_desktop').css('background', '#f9f9f9');
    $('#same_bill_toparty_desktop').css('background', '#f9f9f9');

		$('#datepicker').datepicker('setDate', 'today');
		$(".container-mobile-search").hide();
		$(".container-mobile-choose").hide();
		$(".updateDetail").attr("disabled", "disabled");
		$(".updateDetail").css("opacity","0.5");
		$("#list-tab").css('background-color','#f1f1f1');

    $("#tablist-contact").hide();
    $("#tablist-tax").hide();
    $("#tablist-account").hide();

    $("#profile-tab").css('background-color','#f1f1f1');

    $("#profile-tab").click(function(){
      $("#profile-tab").css('background-color','#f1f1f1');
      $("#contact-tab").css('background-color','#fff');
      $("#tax-tab").css('background-color','#fff');
      $("#account-tab").css('background-color','#fff');

      $("#tablist-profile").show();
      $("#tablist-contact").hide();
      $("#tablist-tax").hide();
      $("#tablist-account").hide();
    });

		$("#change-btn").click(function(){
      var colr = $('#change-btn').css("background-color");
      //alert(colr);
			if(colr == 'rgb(255, 255, 255)'){
        $('#change-btn').css("background-color","#f1f1f1");
        $('.form-create h3 span').remove();
        $('.form-create h3').append("<span>Change Master Data Vendor</span>");
        $('#customer_title_desktop').attr("disabled", false);
        $('#customer_name_desktop').attr('readonly', false);
        $('#customer_type_desktop').attr("disabled", false);
        $('#customer_searchterm_desktop').attr('readonly', false);
        $('#customer_address1_desktop').attr('readonly', false);
        $('#customer_address2_desktop').attr('readonly', false);
        $('#customer_address3_desktop').attr('readonly', false);
        $('#customer_houseno_desktop').attr('readonly', false);
        $('#customer_city_desktop').attr('readonly', false);
        $('#customer_postalcode_desktop').attr('readonly', false);
        $('#customer_province_desktop').attr("disabled", false);
        $('#customer_country_desktop').attr('readonly', false);
        $('#customer_phone_desktop').attr('readonly', false);
        $('#customer_mobile_desktop').attr('readonly', false);
        $('#customer_npwp_desktop').attr('readonly', false);
        $('#customer_ppn_desktop').attr("disabled", false);
        $('#customer_bankkey_desktop').attr('readonly', false);
        $('#customer_accountno_desktop').attr('readonly', false);
        $('#customer_accountname_desktop').attr('readonly', false);
        $('#customer_paymentterm_desktop').attr('disabled', false);
        $('#customer_billtoparty_desktop').attr('readonly', false);
        $('#same_bill_toparty_desktop').attr('disabled', false);

        $('#customer_title_desktop').css('background', '#ffffff');
        $('#customer_name_desktop').css('background', '#ffffff');
        $('#customer_type_desktop').css('background', '#ffffff');
        $('#customer_searchterm_desktop').css('background', '#ffffff');
        $('#customer_address1_desktop').css('background', '#ffffff');
        $('#customer_address2_desktop').css('background', '#ffffff');
        $('#customer_address3_desktop').css('background', '#ffffff');
        $('#customer_houseno_desktop').css('background', '#ffffff');
        $('#customer_city_desktop').css('background', '#ffffff');
        $('#customer_postalcode_desktop').css('background', '#ffffff');
        $('#customer_province_desktop').css('background', '#ffffff');
        $('#customer_country_desktop').css('background', '#ffffff');
        $('#customer_phone_desktop').css('background', '#ffffff');
        $('#customer_mobile_desktop').css('background', '#ffffff');
        $('#customer_npwp_desktop').css('background', '#ffffff');
        $('#customer_ppn_desktop').css('background', '#ffffff');
        $('#customer_bankkey_desktop').css('background', '#ffffff');
        $('#customer_accountno_desktop').css('background', '#ffffff');
        $('#customer_accountname_desktop').css('background', '#ffffff');
        $('#customer_paymentterm_desktop').css('background', '#ffffff');
        $('#customer_billtoparty_desktop').css('background', '#ffffff');
        $('#same_bill_toparty_desktop').css('background', '#ffffff');
      }else{
        location.reload();
      }
    });

		$("#contact-tab").click(function(){
      if($("#customer_title_desktop").val() == ''){
        $("#customer_title_desktop").css('border','1px solid red');
      }else{
        $("#customer_title_desktop").css('border','1px solid #c1c1c1');
      }

      if($("#customer_name_desktop").val() == ''){
        $("#customer_name_desktop").css('border','1px solid red');
      }else{
        $("#customer_name_desktop").css('border','1px solid #c1c1c1');
      }

      if($("#customer_type_desktop").val() == ''){
        $("#customer_type_desktop").css('border','1px solid red');
      }else{
        $("#customer_name_desktop").css('border','1px solid #c1c1c1');
      }

      if($("#customer_title_desktop").val() != '' && $("#customer_name_desktop").val() != '' && $("#customer_type_desktop").val() != ''){
        $("#profile-tab").css('background-color','#fff');
        $("#contact-tab").css('background-color','#f1f1f1');
        $("#tax-tab").css('background-color','#fff');
        $("#account-tab").css('background-color','#fff');

        $("#customer_title_desktop").css('border','1px solid #c1c1c1');
        $("#customer_name_desktop").css('border','1px solid #c1c1c1');
        $("#customer_type_desktop").css('border','1px solid #c1c1c1');

        $("#tablist-profile").hide();
        $("#tablist-contact").show();
        $("#tablist-tax").hide();
        $("#tablist-account").hide();
      }
    });

    $("#tax-tab").click(function(){
      if($("#customer_address1_desktop").val() == ''){
        $("#customer_address1_desktop").css('border','1px solid red');
      }else{
        $("#customer_address1_desktop").css('border','1px solid #c1c1c1');
      }

      if($("#customer_houseno_desktop").val() == ''){
        $("#customer_houseno_desktop").css('border','1px solid red');
      }else{
        $("#vendor_houseno_desktop").css('border','1px solid #c1c1c1');
      }

      if($("#customer_city_desktop").val() == ''){
        $("#customer_city_desktop").css('border','1px solid red');
      }else{
        $("#customer_city_desktop").css('border','1px solid #c1c1c1');
      }

      if($("#customer_province_desktop").val() == ''){
        $("#customer_province_desktop").css('border','1px solid red');
      }else{
        $("#customer_province_desktop").css('border','1px solid #c1c1c1');
      }

      if($("#customer_country_desktop").val() == ''){
        $("#customer_country_desktop").css('border','1px solid red');
      }else{
        $("#customer_country_desktop").css('border','1px solid #c1c1c1');
      }

      if($("#customer_address1_desktop").val() != '' && $("#customer_houseno_desktop").val() != '' && $("#customer_city_desktop").val() != '' && $("#customer_province_desktop").val() != '' && $("#customer_country_desktop").val() != ''){
        $("#profile-tab").css('background-color','#fff');
        $("#contact-tab").css('background-color','#fff');
        $("#tax-tab").css('background-color','#f1f1f1');
        $("#account-tab").css('background-color','#fff');

        $("#customer_address1_desktop").css('border','1px solid #c1c1c1');
        $("#customer_houseno_desktop").css('border','1px solid #c1c1c1');
        $("#customer_city_desktop").css('border','1px solid #c1c1c1');
        $("#customer_province_desktop").css('border','1px solid #c1c1c1');
        $("#customer_country_desktop").css('border','1px solid #c1c1c1');

        $("#tablist-profile").hide();
        $("#tablist-contact").hide();
        $("#tablist-tax").show();
        $("#tablist-account").hide();
      }
    });

    $("#account-tab").click(function(){
      if($("#customer_npwp_desktop").val() == ''){
        $("#customer_npwp_desktop").css('border','1px solid red');
      }else{
        $("#customer_npwp_desktop").css('border','1px solid #c1c1c1');
      }

      if($("#customer_ppn_desktop").val() == ''){
        $("#customer_ppn_desktop").css('border','1px solid red');
      }else{
        $("#customer_ppn_desktop").css('border','1px solid #c1c1c1');
      }

      if($("#customer_npwp_desktop").val() != '' && $("#vendor_ppn_desktop").val() != ''){
        $("#profile-tab").css('background-color','#fff');
        $("#contact-tab").css('background-color','#fff');
        $("#tax-tab").css('background-color','#fff');
        $("#account-tab").css('background-color','#f1f1f1');

        $("#customer_npwp_desktop").css('border','1px solid #c1c1c1');
        $("#customer_ppn_desktop").css('border','1px solid #c1c1c1');

        $("#tablist-profile").hide();
        $("#tablist-contact").hide();
        $("#tablist-tax").hide();
        $("#tablist-account").show();
      }
    });

    $("#tbl-line").hide();

		$("#form-tab").click(function(){
			$("#form-tab").css('background-color','#f1f1f1');
			$("#line-tab").css('background-color','#fff');
			$("#tbl-form").show();
			$("#tbl-line").hide();
		});

		$("#line-tab").click(function(){
			$("#form-tab").css('background-color','#fff');
			$("#line-tab").css('background-color','#f1f1f1');
			$("#tbl-form").hide();
			$("#tbl-line").show();
		});

		var $loading = $('#loadingDiv').hide();
		$('#formuploadFile').hide();

		$("#btnConfirmYes").click(function(){
			window.location = '<?php echo base_url();?>index.php/request/get_Logout/';
		});

		$("#btnConfirmNo").click(function(){
			$("#confirm").fadeOut();
		});

		$(".btn-close-mobile-menu").click(function(){
			$(".container-mobile-menu").hide();
		});

		$("#mobile-menuBtn").click(function(){
			$(".container-mobile-menu").show();
		});

		$("#back-mobile-button").click(function(){
				$(".container-mobile-search").hide();
		});

		$("#search-mobile-button").click(function(){
				$(".container-mobile-search").show();
		});

		$("#cancelBtnChooseMobile").click(function(){
				$(".container-mobile-choose").hide();
		});

		$("#btnAdd-Mobile").click(function(){
				$(".container-mobile-choose").show();
		});

		$("#btnAdd-Mobile").click(function(){
				$(".container-mobile-choose").show();
		});

		$(".drop-collapse-menu-btn").click(function(){
				$(".drop-collapse-menu").toggle();
		});

		$(".drop-collapse-bell-btn").click(function(){
				$(".drop-collapse-bell").toggle();
		});

		$(".drop-collapse-usr-btn").click(function(){
				$(".drop-collapse-usr").toggle();
		});

		$("#g_billtoparty").hide();

    $("#same_bill_toparty_desktop").click(function(){
      if($("#same_bill_toparty_desktop").val() == 'No'){
        $("#g_billtoparty").show();
        $("#blank").hide();
      }else{
        $("#blank").show();
        $("#g_billtoparty").hide();
        $("#customer_billtoparty_desktop").val("");
      }
    });
	});
</script>
<script>
	$(function(){
		$(function(){
			var iden = '';
      $.ajax({
        url:"<?php echo base_url();?>index.php/request/get_data_detail_customer_draft/<?php echo $this->uri->segment(3);?>",
        cache:false,
        type: "POST",
        dataType: 'json',
        success:function(result){
					$(".drop ul li").remove();
					$("#tbl-list tbody tr").removeClass("selectVendor");
					$("#<?php echo $this->uri->segment(3);?>").addClass("selectVendor");
          $.each(result, function(i, data){
            $('#customer_id_desktop').val(data.MDG_Customer_ID);
						$('#customer_id_desktop_tl').val(data.MDG_Customer_ID);
						iden = data.MDG_Customer_ID;
            $("#customer_title_desktop option").remove();
            $("#customer_title_desktop").append("<option value=''>--select customer title--</option>");
            if(data.MDG_Title == 2){
              $("#customer_title_desktop").append("<option value='0001'>0001 - Ms.</option>");
              $("#customer_title_desktop").append("<option value='0002' selected>0002 - Mr.</option>");
              $("#customer_title_desktop").append("<option value='0003'>0003 - Company</option>");
            }else if(data.MDG_Title == 3){
              $("#customer_title_desktop").append("<option value='0001'>0001 - Ms.</option>");
              $("#customer_title_desktop").append("<option value='0002'>0002 - Mr.</option>");
              $("#customer_title_desktop").append("<option value='0003' selected>0003 - Company</option>");
            }else{
              $("#customer_title_desktop").append("<option value='0001' selected>0001 - Ms.</option>");
              $("#customer_title_desktop").append("<option value='0002'>0002 - Mr.</option>");
              $("#customer_title_desktop").append("<option value='0003'>0003 - Company</option>");
            }

            $('#customer_name_desktop').val(data.MDG_CustomerName);

            $(function(){
              $.ajax({
                url:"<?php echo base_url();?>index.php/request/get_data_customer_type/",
                cache:false,
                type: "POST",
                dataType: 'json',
                success:function(result){
                  $("#customer_type_desktop option").remove();
                  $("#customer_type_desktop").append("<option value=''>--select customer type--</option>");
                  $.each(result, function(i, data1){
                      if(data.MDG_CustomerType_ID == data1.CustomerType_ID){
                          $("#customer_type_desktop").append("<option value='"+data1.CustomerType_ID+"' selected>"+data1.CustomerType_ID+" - "+data1.CustomerType_Name+"</option>");
                      }else{
                          $("#customer_type_desktop").append("<option value='"+data1.CustomerType_ID+"'>"+data1.CustomerType_ID+" - "+data1.CustomerType_Name+"</option>");
                      }
                  });
                }
              });
            });

            $('#customer_searchterm_desktop').val(data.MDG_SearchTerm);
            $('#customer_address1_desktop').val(data.MDG_Address1);
            $('#customer_address2_desktop').val(data.MDG_Address2);
            $('#customer_address3_desktop').val(data.MDG_Address3);
            $('#customer_houseno_desktop').val(data.MDG_HouseNo);
						$(function(){
							$.ajax({
								url:"<?php echo base_url();?>index.php/request/get_data_customer_city/",
								cache:false,
								type: "POST",
								dataType: 'json',
								success:function(result){
									$("#customer_city_desktop option").remove();
									$("#customer_city_desktop").append("<option value=''>--select customer city--</option>");
									$.each(result, function(i, data1){
										if(data.CustomerCity_ID == data1.ObjectID){
												$("#customer_city_desktop").append("<option value='"+data1.ObjectID+"' selected>"+data1.ObjectID+" - "+data1.CustomerCity_Name+"</option>");
										}else{
												$("#customer_city_desktop").append("<option value='"+data1.ObjectID+"'>"+data1.ObjectID+" - "+data1.CustomerCity_Name+"</option>");
										}
									});
								}
							});
						});
            $('#customer_postalcode_desktop').val(data.MDG_PostalCode);
            $(function(){
              $.ajax({
                url:"<?php echo base_url();?>index.php/request/get_data_customer_province/",
                cache:false,
                type: "POST",
                dataType: 'json',
                success:function(result){
                  $("#customer_province_desktop option").remove();
                  $("#customer_province_desktop").append("<option value=''>--select province--</option>");
                  $.each(result, function(i, data2){
                    if(data.CustomerProvince_ID == data2.CustomerProvince_ID){
                        $("#customer_province_desktop").append("<option value='"+data2.CustomerProvince_ID+"' selected>"+data2.CustomerProvince_ID+" - "+data2.CustomerProvince_Name+"</option>");
                    }else{
                        $("#customer_province_desktop").append("<option value='"+data2.CustomerProvince_ID+"'>"+data2.CustomerProvince_ID+" - "+data2.CustomerProvince_Name+"</option>");
                    }
                  });
                }
              });
            });
            $('#customer_country_desktop').val(data.MDG_Country);
            $('#customer_phone_desktop').val(data.MDG_Phone);
            $('#customer_mobile_desktop').val(data.MDG_Mobile);
            $('#customer_npwp_desktop').val(data.MDG_NPWP);

            if(data.MDG_PPN == 'Yes'){
                $("#customer_ppn_desktop option").remove();
                $("#customer_ppn_desktop").append("<option value=''>--select ppn--</option>");
                $("#customer_ppn_desktop").append("<option value='yes' selected>Yes</option>");
                $("#customer_ppn_desktop").append("<option value='no'>No</option>");
            }else{
                $("#customer_ppn_desktop option").remove();
                $("#customer_ppn_desktop").append("<option value=''>--select ppn--</option>");
                $("#customer_ppn_desktop").append("<option value='yes'>Yes</option>");
                $("#customer_ppn_desktop").append("<option value='no' selected>No</option>");
            }
            //$('#vendor_ppn_desktop').val(data.MDG_PPN);
            $('#customer_bankkey_desktop').val(data.MDG_BankKey);
            $('#customer_accountno_desktop').val(data.MDG_AccountNo);
            $('#customer_accountname_desktop').val(data.MDG_AccountName);
						$('#customer_billtoparty_desktop').val(data.MDG_Billtoparty);
						$('#same_bill_toparty_desktop').val(data.MDG_SameBill);
						if(data.MDG_SameBill == 'Yes'){
							$("#g_billtoparty").show();
							$("#blank").hide();
						}else{
							$("#blank").show();
							$("#g_billtoparty").hide();
							$("#customer_billtoparty_desktop").val("");
						}
						$(function(){
							$.ajax({
								url:"<?php echo base_url();?>index.php/request/get_data_customer_term/",
								cache:false,
								type: "POST",
								dataType: 'json',
								success:function(result){
									$("#customer_paymentterm_desktop option").remove();
									$("#customer_paymentterm_desktop").append("<option value=''>--select payment terms--</option>");
									$.each(result, function(i, data1){
										if(data.PaymentTerm_ID == data1.ObjectID){
												$("#customer_paymentterm_desktop").append("<option value='"+data1.ObjectID+"' selected>"+data1.ObjectID+" - "+data1.MDG_TermName+"</option>");
										}else{
												$("#customer_paymentterm_desktop").append("<option value='"+data1.ObjectID+"'>"+data1.ObjectID+" - "+data1.MDG_TermName+"</option>");
										}
									});
								}
							});
						});

						$("#save-btn").show();
						$("#send-btn").show();
						$(".tl-request").removeClass('tl-request-b');
						$(".tl-send").removeClass('tl-send-b');
						$(".tl-approval").removeClass('tl-approval-b');
						$(".tl-posted").removeClass('tl-posted-b');
						//----------------------------------------------------------------------------------------------
						// RESET
						//----------------------------------------------------------------------------------------------
						$(".tl-request").css({"background-color":"transparent","color":"#dd5136","border":"2px solid #dd5136"});
						$(".tl-request").removeClass('tl-request-b');
						$(".tl-send").css({"background-color":"transparent","color":"#dd5136","border":"2px solid #dd5136"});
						$(".tl-send").removeClass('tl-send-b');
						$(".tl-approval").css({"background-color":"transparent","color":"#dd5136","border":"2px solid #dd5136"});
						$(".tl-approval").removeClass('tl-approval-b');

						if(data.MDG_Status == '1'){
							$(".tl-request").css({"background-color":"#dd5136","color":"#FFF","border":"1px solid #dd5136"});
							$(".tl-request").toggleClass('tl-request-b');
						}else if(data.MDG_Status == '2'){
							$(".tl-request").css({"background-color":"#dd5136","color":"#FFF","border":"1px solid #dd5136"});
							$(".tl-request").toggleClass('tl-request-b');
							$(".tl-send").css({"background-color":"#dd5136","color":"#FFF","border":"1px solid #dd5136"});
							$(".tl-send").toggleClass('tl-send-b');
						}else if(data.MDG_Status == '3' || data.MDG_Status == '4'){
							$(".tl-request").css({"background-color":"#dd5136","color":"#FFF","border":"1px solid #dd5136"});
							$(".tl-request").toggleClass('tl-request-b');
							$(".tl-send").css({"background-color":"#dd5136","color":"#FFF","border":"1px solid #dd5136"});
							$(".tl-send").toggleClass('tl-send-b');
							$(".tl-approval").css({"background-color":"#dd5136","color":"#FFF","border":"1px solid #dd5136"});
						  $(".tl-approval").toggleClass('tl-approval-b');
						}else if(data.MDG_Status == '5'){
							$(".tl-request").css({"background-color":"#dd5136","color":"#FFF","border":"1px solid #dd5136"});
							$(".tl-request").toggleClass('tl-request-b');
							$(".tl-send").css({"background-color":"#dd5136","color":"#FFF","border":"1px solid #dd5136"});
							$(".tl-send").toggleClass('tl-send-b');
							$(".tl-approval").css({"background-color":"#dd5136","color":"#FFF","border":"1px solid #dd5136"});
						  $(".tl-approval").toggleClass('tl-approval-b');
							$(".tl-posted").css({"background-color":"#dd5136","color":"#FFF","border":"1px solid #dd5136"});
						  $(".tl-posted").toggleClass('tl-approval-b');
						}

						$.ajax({
							url:"<?php echo base_url();?>index.php/request/get_log_customer/",
							data:{
				        id:$('#customer_id_desktop').val(),
							},
							cache:false,
							type: "POST",
							dataType: 'json',
							success:function(result){
								$.each(result, function(i, data){
									$(".list-log li").remove();
									$.each(result, function(i, data){
				            if(data.MDG_Category == 'Request'){
				                $(".list-log").append("<li class='newUpdate'><div><span style='font-size:11px;color:#4285f4;'>Request</span><p style='margin:0;font-size:12px;'>"+data.Information+" ("+data.Log_Status+")</p><span style='font-size:11px;color:#4285f4;'>"+data.Posting_Date+" -- "+data.Account_Name+"</span></div></li>");
				            }else{
				                $(".list-log").append("<li class='newUpdate''><div><span style='font-size:11px;color:#4285f4;'>Approval</span><p style='margin:0;font-size:12px;'>"+data.Information+" ("+data.Log_Status+")</p><span style='font-size:11px;color:#4285f4;'>"+data.Posting_Date+" -- "+data.Account_Name+"</span></div></li>");
				            }
									});
								});
								$('#loadingDivNews').hide();
							}
						});
        });
      }
      });

      $("#list-tab").css('background-color','#fff');
			$("#form-tab").css('background-color','#f1f1f1');
			$("#tbl-list").hide();
			$("#tbl-form").show();
    });

    $(function(){
      $.ajax({
        url:"<?php echo base_url();?>index.php/request/get_data_customer_type/",
        cache:false,
        type: "POST",
        dataType: 'json',
        success:function(result){
          $("#customer_type_desktop option").remove();
          $("#customer_type_desktop").append("<option value=''>--select customer type--</option>");
          $.each(result, function(i, data){
              $("#customer_type_desktop").append("<option value='"+data.CustomerType_ID+"'>"+data.CustomerType_ID+" - "+data.CustomerType_Name+"</option>");
          });
        }
      });
    });

    $(function(){
      $.ajax({
        url:"<?php echo base_url();?>index.php/request/get_data_customer_province/",
        cache:false,
        type: "POST",
        dataType: 'json',
        success:function(result){
          $("#customer_province_desktop option").remove();
          $("#customer_province_desktop").append("<option value=''>--select province--</option>");
          $.each(result, function(i, data){
              $("#customer_province_desktop").append("<option value='"+data.CustomerProvince_ID+"'>"+data.CustomerProvince_ID+" - "+data.CustomerProvince_Name+"</option>");
          });
        }
      });
    });

		$(".menu-create").hide();
		var $loading = $('#loadingDivNews').show();
		$.ajax({
			url:"<?php echo base_url();?>index.php/request/get_thenew/",
			cache:false,
			type: "POST",
			dataType: 'json',
			success:function(result){
				$.each(result, function(i, data){
					$("#bell-desktop ul li").remove();
					$.each(result, function(i, data){
						if(data.New_Type == 'Request'){
								$("#bell-desktop ul").append("<li class='"+data.New_Link+"/"+data.New_Type+"/"+data.Account_To+"' id="+data.ObjectID+'/'+data.LOG_ID+" onclick='linkDisplayNew(this)'><div><span style='font-size:11px;color:#4285f4;'>Request</span><p style='margin:0;font-size:12px;'>"+data.New_Description+" ("+data.MDG_Name+")</p><span style='font-size:11px;color:#4285f4;'>"+data.New_ActyDt+"</span></div></li>");
						}else{
								$("#bell-desktop ul").append("<li class='"+data.New_Link+"/"+data.New_Type+"/"+data.Account_To+"' id="+data.ObjectID+'/'+data.LOG_ID+" onclick='linkDisplayNew(this)'><div><span style='font-size:11px;color:#4285f4;'>Approval</span><p style='margin:0;font-size:12px;'>"+data.New_Description+" ("+data.MDG_Name+")</p><span style='font-size:11px;color:#4285f4;'>"+data.New_ActyDt+"</span></div></li>");
						}
					});
					$("#bell-desktop ul").append('<li id="read-all" onclick="clickAll()" style="font-size:13px;color:#4285f4;">Read More</li>');
				});
				$('#loadingDivNews').hide();
			}
		});

		$(".tl-approval").click(function(){
			var $loading = $('#loadingDivNews').show();
			var d = $("#customer_id_desktop_tl").val();
			$.ajax({
				url:"<?php echo base_url();?>index.php/request/all_approval_customer/"+d,
				cache:false,
				type: "POST",
				dataType: 'json',
				success:function(result){
					$(".drop ul li").remove();
					$.each(result, function(i, data1){
						$(".drop ul").append("<li style='background:transparent;border:1px solid rgb(221, 81, 54);color:rgb(221, 81, 54);padding:5px 10px;' id='"+data1.Mapping_approval_person+"'>"+data1.Account_First_Name+" "+data1.Account_Last_Name+"<span></span></li>");
						$.ajax({
							url:"<?php echo base_url();?>index.php/request/click_approval_customer/"+d,
							cache:false,
							type: "POST",
							dataType: 'json',
							success:function(result){
								$.each(result, function(i, data){
									if(data1.Mapping_approval_person == data.account){
										if(data.status == 1){
											$(".drop ul #"+data.account+" span").append("<img src='<?php echo base_url();?>assets/img/check.png' style='width:10px;'/>");
											$(".drop ul #"+data.account).css("background-color","#3C78DD");
											$(".drop ul #"+data.account).css("color","#fff");
											$(".drop ul #"+data.account).css("border","1px solid #3C78DD");
										}else{
											$(".drop ul #"+data.account+" span").append("<img src='<?php echo base_url();?>assets/img/padlock.png' style='width:10px;'/>");
											$(".drop ul #"+data.account).css("background-color","#d14836 !important");
											$(".drop ul #"+data.account).css("color","#fff");
											$(".drop ul #"+data.account).css("border","1px solid #d14836 !important");
										}
									}
								});
								$('#loadingDivNews').hide();
							}
						});
					});
				}
			});
		});
	});
</script>
<script>
	function getCreateForm(){
		$(".menu-create").toggle();
	}


			function get_send(){
				var $load_id = $('#loadingDiv').hide();
				$load_id.show();
				$.ajax({
					url:"<?php echo base_url();?>index.php/request/get_send_again_customer/",
					cache:false,
					data:{
						id:$('#customer_id_desktop').val(),
						title:$('#customer_title_desktop').val(),
						name:$('#customer_name_desktop').val(),
						type:$('#customer_type_desktop').val(),
						searchterm:$('#customer_searchterm_desktop').val(),
						address1:$('#customer_address1_desktop').val(),
						address2:$('#customer_address2_desktop').val(),
						address3:$('#customer_address3_desktop').val(),
						houseno:$('#customer_houseno_desktop').val(),
						city:$('#customer_city_desktop').val(),
						postal:$('#customer_postalcode_desktop').val(),
						province:$('#customer_province_desktop').val(),
						country:$('#customer_country_desktop').val(),
						phone:$('#customer_phone_desktop').val(),
						mobile:$('#customer_mobile_desktop').val(),
						npwp:$('#customer_npwp_desktop').val(),
						ppn:$('#customer_ppn_desktop').val(),
						bankkey:$('#customer_bankkey_desktop').val(),
						accountno:$('#customer_accountno_desktop').val(),
						accountname:$('#customer_accountname_desktop').val(),
						sambill:$('#same_bill_toparty_desktop').val(),
						billtoparty:$('#customer_billtoparty_desktop').val(),
						paymentterm:$('#customer_paymentterm_desktop').val(),
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$(".span-message span").remove();
							$(".span-message").append('<span>Create process was successful, wait the approval for the request . .</span>');
							$("#noticeCnt").fadeIn().delay(3000).fadeOut();
							$("#customer_id_desktop").val(result.id);
						}else if(result.status == 'faillogupdate'){
							$(".span-message span").remove();
							$(".span-message").append('<span>2Create process was successful, wait the approval for the request . .</span>');
							$("#noticeCnt").fadeIn().delay(3000).fadeOut();
							$("#customer_id_desktop").val(result.id);
						}else if(result.status == 'refresh'){
							$(".span-message span").remove();
							$(".span-message").append('<span>ID Vendor not to use, Please Refesh this form and try again . .</span>');
							$("#noticeCnt").fadeIn().delay(3000).fadeOut();
						}else if(result.status == 'tryagain'){
							$(".span-message span").remove();
							$(".span-message").append('<span>Sorry, you must waiting for previous approval</span>');
							$("#noticeCnt").fadeIn().delay(3000).fadeOut();
						}else if(result.status == 'require'){
							$(".span-message span").remove();
							$(".span-message").append('<span>Please complete your entry to asterisk column (*)</span>');

							$("#noticeCnt").fadeIn().delay(3000).fadeOut();
						}else if(result.status == 'accountnot'){
								$(".span-message span").remove();
								$(".span-message").append('<span>Sorry, you can not use this account for execute this MDG!</span>');

								$("#noticeCnt").fadeIn().delay(2000).fadeOut();
						}else{
							$(".span-message span").remove();
							$(".span-message").append('<span>Sorry, create process was failure</span>');
							$("#noticeCnt").fadeIn().delay(1000).fadeOut();
						}
						$load_id.hide();
					}
				});
			}

			function blockSpecial(event){
				var even = event.which || event.keyCode;
				if ((even > 32 && even < 44) || (even > 57 && even < 65) || (even > 90 && even < 97) || (even == 45) || (even == 47) || (even > 122 && even <=176))
				event.preventDefault();
			}

			function blockAlphabeth(event){
				var even = event.which || event.keyCode;
				if ((even > 32 && even < 48) || (even > 57 && even < 65) || (even > 90 && even < 97) || (even > 65 && even < 123) || (even > 122 && even <=176))
					event.preventDefault();
			}

			function get_save(){
				var $load_id = $('#loadingDiv').hide();
				$load_id.show();
				$.ajax({
					url:"<?php echo base_url();?>index.php/request/get_update_customer/",
					cache:false,
					data:{
						id:$('#customer_id_desktop').val(),
						title:$('#customer_title_desktop').val(),
						name:$('#customer_name_desktop').val(),
						type:$('#customer_type_desktop').val(),
						searchterm:$('#customer_searchterm_desktop').val(),
						address1:$('#customer_address1_desktop').val(),
						address2:$('#customer_address2_desktop').val(),
						address3:$('#customer_address3_desktop').val(),
						houseno:$('#customer_houseno_desktop').val(),
						city:$('#customer_city_desktop').val(),
						postal:$('#customer_postalcode_desktop').val(),
						province:$('#customer_province_desktop').val(),
						country:$('#customer_country_desktop').val(),
						phone:$('#customer_phone_desktop').val(),
						mobile:$('#customer_mobile_desktop').val(),
						npwp:$('#customer_npwp_desktop').val(),
						ppn:$('#customer_ppn_desktop').val(),
						bankkey:$('#customer_bankkey_desktop').val(),
						accountno:$('#customer_accountno_desktop').val(),
						accountname:$('#customer_accountname_desktop').val(),
						sambill:$('#same_bill_toparty_desktop').val(),
						billtoparty:$('#customer_billtoparty_desktop').val(),
						paymentterm:$('#customer_paymentterm_desktop').val(),
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$(".span-message span").remove();
							$(".span-message").append('<span>Update process was successful, Please check draft . .</span>');
							$("#noticeCnt").fadeIn().delay(2000).fadeOut();
							$("#customer_id_desktop").val(result.id);
						}else if(result.status == 'notlog'){
							$(".span-message span").remove();
							$(".span-message").append('<span>Update process was successful, Please check draft . .</span>');
							$("#noticeCnt").fadeIn().delay(2000).fadeOut();
							$("#customer_id_desktop").val(result.id);
						}else if(result.status == 'refresh'){
							$(".span-message span").remove();
							$(".span-message").append('<span>ID Vendor is empty, Please select data vendor on list vendor tab . .</span>');
							$("#noticeCnt").fadeIn().delay(2000).fadeOut();
						}else if(result.status == 'require'){
							$(".span-message span").remove();
							$(".span-message").append('<span>Please complete your entry to asterisk column (*)</span>');

							$("#noticeCnt").fadeIn().delay(2000).fadeOut();
						}else if(result.status == 'tryagain'){
							$(".span-message span").remove();
							$(".span-message").append('<span>Sorry, you can not save this request because you must waiting for previous approval</span>');

							$("#noticeCnt").fadeIn().delay(2000).fadeOut();
						}else if(result.status == 'accountnot'){
								$(".span-message span").remove();
								$(".span-message").append('<span>Sorry, you can not use this account for execute this MDG!</span>');

								$("#noticeCnt").fadeIn().delay(2000).fadeOut();
						}else{
							$(".span-message span").remove();
							$(".span-message").append('<span>Sorry, update process was failure</span>');
							$("#noticeCnt").fadeIn().delay(2000).fadeOut();
						}
						$load_id.hide();
					}
				});
			}

  function getLinked(menu){
    var code = menu.id;
    if(code == 'menu_inbox'){
      window.location.href = '<?php echo base_url()?>index.php/request/get_inbox/';
    }else if(code == 'menu_outbox'){
      window.location.href = '<?php echo base_url()?>index.php/request/get_outbox/';
    }else if(code == 'menu_draft'){
      window.location.href = '<?php echo base_url()?>index.php/request/get_draft/';
    }else if(code == 'menu_ms_vendor'){
      window.location.href = '<?php echo base_url()?>index.php/request/get_ms_vendor/';
    }else if(code == 'menu_ms_customer'){
      window.location.href = '<?php echo base_url()?>index.php/request/get_ms_customer/';
    }else if(code == 'menu_ms_users'){
      window.location.href = '<?php echo base_url()?>index.php/control/get_ms_users/';
    }else if(code == 'menu_ms_confirm'){
      window.location.href = '<?php echo base_url()?>index.php/control/get_ms_confirm/';
    }
  }

	function linkRequest(link){
		window.location.href = link;
	}

	function downloadExcel(){
		window.location.href = '<?php echo base_url();?>index.php/control/get_export_excel_customer';
	}
</script>
<body>
	<div class="container">
		<div class="bg-list">
			<div class="middle-box" style="background-color:#fff;border:0;">
				<h3 class="title">MDG Application</h3>

				<div style="float: right;margin-right: 65px;"><h3>Master Customer List</h3></div>

				<a id="btnAdd-Mobile" style="float:right;margin-right:50px;"><img src="<?php echo base_url().'assets/img/edit.png';?>" style="width:25px;"/></a>
				<div class="container-mobile-choose">
					<div class="box-mobile-choose">
						<div class="box-question">
							<div style="margin:auto;text-align:center;">
								<h3 style="font-family:'Roboto-Thin';color:#fff;">Select Form Request</h3>
								<select style="border:none;border-bottom:1px solid #fff;padding:10px;color:#fff;background:transparent;">
									<option value="" disabled selected> --Select Form Request-- </option>
								</select>
							</div>
						</div>
						<div class="box-answer">
							<a id="cancelBtnChooseMobile" style="margin:auto;background-color:transparent;color:#dd4b39 !important;font-family:'Roboto-Regular';padding:5px;">CANCEL</a>
							<a id="submitBtnChooseMobile" style="margin:auto;background-color:transparent;color:#16a765 !important;font-family:'Roboto-Regular';padding:5px;">SUBMIT</a>
						</div>
					</div>
				</div>
			</div>
			<div class="list-box" style="width: 100%;margin-top:-20px;">
  			<div id="tab-table" style="float:left;width:100%;margin-top: 20px;">
  				<a class="tab" id="form-tab">Detail Customer</a>
					<a class="tab" id="line-tab">Time Line</a>
  			</div>

  			<div id="tbl-form" style="padding:0px 20px;float:left">
          <div class="list-box" style="width:70%;float:left">
  					<div class="form-create">
  						<h3 style="margin-top:20px;"><span>Master Data Customer</span></h3>
  						<div style="margin-top:20px;margin-bottom:50px;">
  							<div id="frmDTL">
  								<div class="group-txt" style="width:95%;">
  									<label style="width:100%;float:left;">(Customer) Request ID</label>
  									<input type="text" style="background:#f9f9f9;width:30%;" name="customer_id_desktop" id="customer_id_desktop" readonly/>
										<button id="change-btn" style="background-color:#ffffff;"><span style="font-size:12px;font-family:'Roboto-Regular';color:#555;">Change</span></button>
  								</div>

  								<div style="width:100%;border-top:1px solid #f1f1f1;margin-top:10px;float:left;"></div>

  								<div id="tab-table" style="float:left;width:100%;margin-top: 20px;margin-bottom:20px;">
  									<a class="tab" id="profile-tab">Profile</a>
  									<a class="tab" id="contact-tab">Contact</a>
  									<a class="tab" id="tax-tab">Tax</a>
  									<a class="tab" id="account-tab">Finance Info</a>
  								</div>

									<div id="tablist-profile">
		                <h4>Customer Profile</h4>
		                <div class="group-txt" style="width:10%;">
		                  <label>Title *</label>
		                  <select name="customer_title_desktop" id="customer_title_desktop">
		                    <option value=""> -- select customer title -- </option>
		                    <option value="0001">0001 - Person</option>
		                    <option value="0002">0002 - Organization</option>
		                    <option value="0003">0003 - Group</option>
		                  </select>
		                </div>
		                <div class="group-txt" style="width:80%;">
		                  <label>Name *</label>
		                  <span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 40 char)</span>
		                  <input type="text" name="customer_name_desktop" id="customer_name_desktop" onkeypress="blockSpecial(event);" maxlength="40"/>
		                </div>
		                <div class="group-txt" style="width:90%;">
		                  <label style="width:100%;float:left;">Customer Type *</label>
		                  <select style="width:30%;" name="customer_type_desktop" id="customer_type_desktop">
		                    <option value=""> -- select customer type -- </option>
		                  </select>
		                </div>
		                <div class="group-txt" style="width:90%;margin-bottom:50px;">
		                  <div style="width:100%;float:left;">
		                    <label>SearchTerm</label>
		                    <span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 20 char)</span>
		                  </div>
		                  <input style="width:30%;" type="text" onkeypress="blockSpecial(event);" name="customer_searchterm_desktop" id="customer_searchterm_desktop" maxlength="20"/>
		                </div>
		              </div>

		              <div id="tablist-contact">
		                <h4>Customer Contact</h4>
		                <div class="group-txt" style="width:90%;">
		                  <label>Address 1 *</label>
		                  <span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 60 char)</span>
		                  <textarea type="text" name="customer_address1_desktop" onkeypress="blockSpecial(event);" id="customer_address1_desktop" maxlength="60"></textarea>
		                </div>
		                <div class="group-txt" style="width:90%;">
		                  <label>Address 2</label>
		                  <span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 40 char)</span>
		                  <textarea type="text" name="customer_address2_desktop" onkeypress="blockSpecial(event);" id="customer_address2_desktop" maxlength="40"></textarea>
		                </div>
		                <div class="group-txt" style="width:90%;">
		                  <label>Address 3</label>
		                  <span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 40 char)</span>
		                  <textarea type="text" name="customer_address3_desktop" onkeypress="blockSpecial(event);" id="customer_address3_desktop" maxlength="40"></textarea>
		                </div>
		                <div class="group-txt" style="width:10%;margin-right:10px;">
		                  <div style="width:100%;float:left;">
		                    <label>No *</label>
		                    <span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 10 char)</span>
		                  </div>
		                  <input type="text" name="customer_houseno_desktop" onkeypress="blockSpecial(event);" id="customer_houseno_desktop" maxlength="10"/>
		                </div>
		                <div class="group-txt" style="width:35%;margin-right:10px;">
		                  <label>City *</label>
		                  <select style="width:100%;" name="customer_city_desktop" id="customer_city_desktop">
		                    <option value=""> -- select customer city -- </option>
		                  </select>
		                </div>
		                <div class="group-txt" style="width:15%;margin-right:10px;margin-bottom:5px;">
		                  <label>Postal Code</label>
		                  <span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 5 char)</span>
		                  <input type="text" name="customer_postalcode_desktop" onkeypress="blockAlphabeth(event);" id="customer_postalcode_desktop" maxlength="5"/>
		                </div>
		                <div class="group-txt" style="width:45%;margin-right:10px;">
		                  <label>Province *</label>
		                  <select name="customer_province_desktop" id="customer_province_desktop">
		                    <option value=""> -- select province -- </option>
		                  </select>
		                </div>
		                <div class="group-txt" style="width:45%;margin-right:10px;margin-top: 5px;">
		                  <label>Country *</label>
		                  <span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 30 char)</span>
		                  <input type="text" name="customer_country_desktop" onkeypress="blockSpecial(event);" id="customer_country_desktop" maxlength="30"/>
		                </div>
		                <div class="group-txt" style="width:45%;margin-right:10px;">
		                  <label>Phone</label>
		                  <span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 20 char)</span>
		                  <input type="text" name="customer_phone_desktop" onkeypress="blockAlphabeth(event);" id="customer_phone_desktop" maxlength="20"/>
		                </div>
		                <div class="group-txt" style="width:45%;margin-right:10px;margin-bottom:50px;">
		                  <label>Mobile</label>
		                  <span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 20 char)</span>
		                  <input type="text" name="customer_mobile_desktop" onkeypress="blockAlphabeth(event);" id="customer_mobile_desktop" maxlength="20"/>
		                </div>
		              </div>

		              <div id="tablist-tax">
		                <h4>Customer Tax</h4>
		                <div class="group-txt" style="width:90%;">
		                  <label>NPWP *</label>
		                  <span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 20 char)</span>
		                  <input type="text" name="customer_npwp_desktop" onkeypress="blockAlphabeth(event);" id="customer_npwp_desktop" maxlength="20"/>
		                </div>
		                <div class="group-txt" style="width:90%;margin-bottom:50px;">
		                  <label style="width:90%;float:left;">PPN *</label>
		                  <select style="width:30%;" name="customer_ppn_desktop" id="customer_ppn_desktop">
		                    <option value=""> -- select ppn -- </option>
		                    <option value="Yes"> Yes </option>
		                    <option value="No"> No </option>
		                  </select>
		                </div>
		              </div>

		              <div id="tablist-account">
		                <h4>Customer Finance Info</h4>
		                <div class="group-txt" style="width:45%;margin-right:10px;">
		                  <label>Bank Key</label>
		                  <span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 15 char)</span>
		                  <input type="text" name="customer_bankkey_desktop" onkeypress="blockSpecial(event);" id="customer_bankkey_desktop" maxlength="15"/>
		                </div>
		                <div class="group-txt" style="width:45%;margin-right:10px;">
		                  <label>Account No</label>
		                  <span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 18 char)</span>
		                  <input type="text" name="customer_accountno_desktop" onkeypress="blockAlphabeth(event);" id="customer_accountno_desktop" maxlength="18"/>
		                </div>
		                <div class="group-txt" style="width:90%;">
		                  <label>Account Name</label>
		                  <span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 60 char)</span>
		                  <input type="text" name="customer_accountname_desktop" onkeypress="blockSpecial(event);" id="customer_accountname_desktop" maxlength="60"/>
		                </div>
		                <div class="group-txt" style="width:15%;margin-right:10px;">
		                  <label>Same Bill to Party ? *</label>
		                  <select style="width:74%;" name="same_bill_toparty_desktop" id="same_bill_toparty_desktop">
		                    <option value=""> -- select bill -- </option>
		                    <option value="Yes"> Yes </option>
		                    <option value="No"> No </option>
		                  </select>
		                </div>
		                <div class="group-txt" style="width:80%;margin-bottom:5px;">
		                  <div id="blank" style="margin-bottom:25px;">
		                    <label style="color:transparent">Blank</label>
		                    <span style="font-size:11px;font-family:'roboto-regular';color:transparent">(Max 60 char)</span>
		                    <input type="hidden" disabled/>
		                  </div>
		                  <div id="g_billtoparty">
		                    <label>Bill to Party *</label>
		                    <span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 60 char)</span>
		                    <input type="text" name="customer_billtoparty_desktop" onkeypress="blockSpecial(event);" id="customer_billtoparty_desktop" maxlength="60"/>
		                  </div>
		                </div>
		                <div class="group-txt" style="width:45%;margin-right:10px;margin-bottom:50px;">
		                  <label>Payment Term *</label>
		                  <select name="customer_paymentterm_desktop" id="customer_paymentterm_desktop">
		                    <option value=""> -- select payment terms -- </option>
		                  </select>
		                </div>
		              </div>
		              <div style="float:left;width:100%;"><span style="font-size:13px;font-family:'Roboto-regular'">*) Fill the column</span></div>
		            </div>
  						</div>
  					</div>
  				</div>
          <div class="list-box" style="width:30%;float:left;background-color:#fff;">
						<h3 style="margin-top:20px;">Log Data Customer</h3>
            <ul class="list-log">
              <li></li>
            </ul>
          </div>
  			</div>

				<div id="tbl-line" style="padding:0px 20px;float:left">
					<h3 style="margin-top:20px;"><span>Timline (Data Customer)</span></h3>
					<div style="margin-top:20px;margin-bottom:50px;">
						<div id="frmDTL">
							<div class="group-txt" style="width:95%;">
								<label style="width:100%;float:left;">(Customer) Request ID</label>
								<input type="text" style="background:#f9f9f9;width:30%;" name="customer_id_desktop_tl" id="customer_id_desktop_tl" readonly/>
							</div>
						</div>
					</div>
					<div style="width:100%;border-top:1px solid #f1f1f1;margin-top:10px;float:left;"></div>
					<div style="float: left;align-items: center;margin: auto;display: flex;height:200px;width:100%;background-color:transparent">
						<h3 style="position: absolute;color: #555;margin-top: -80px;margin-left: 10px;"><span>Timeline Preview :</span></h3>
						<div style="float: left;align-items: center;margin: auto;display: flex;">
							<div class="tl-request" id="object">
								<h4>Request</h4>
								<hr id=""/>
								<div class="tick"></div>
							</div>
							<div class="tl-send" id="object">
								<h4>Send</h4>
								<div class="tick"></div>
							</div>
							<div class="tl-approval" id="object">
								<h4>Approval</h4>
								<div class="tick"></div>
								<div class="drop">
									<ul></ul>
								</div>
							</div>
							<div class="tl-posted" id="object">
								<h4>Posted</h4>
								<div class="tick"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="loadingDiv" style="font-family:'Roboto-regular';font-size:13.5px;position:fixed;width:100%;height:100%;left:0;top:0;background:rgba(0,0,0,0.5);display:flex;align-item:center;border-weight:bolder;">
		<div style="width:300px;height:75px;border:1px solid #fff;border-radius:3px;margin:auto;background:#fff;display:flex;align-item:center;">
			<div style="margin:auto;">
				<span class="Loader">
					<div class="Loader-indicator" >
					<h4 style="font-family:'Roboto-medium';margin:0;margin-bottom:5px;">
						<span>Loading</span>
						<span class="Loader-ellipsis" >
						<span class="Loader-ellipsisDot">.</span>
						<span class="Loader-ellipsisDot">.</span>
						<span class="Loader-ellipsisDot">.</span>
						</span>
					</h4>
					<span>Please wait a few moments</span>
					</div>
				</span>
				</div>
		</div>
	</div>

	<div id="noticeCnt" style="font-family:'Roboto-regular';position:fixed;width:100%;height:100%;left:0;top:0;background:rgba(0,0,0,0.4);border-weight:bolder;">
		<div style="width:350px;height:175px;background-color:#05b085;border:1px solid transparent;border-radius:3px;color:#fff;padding-top:20px;padding-left:20px;bottom:10px;right:10px;position:fixed;">
			<div style="margin:auto;">
				<span class="Loader">
					<div class="Loader-indicator" >
					<h4 style="font-family:'Roboto-thin';margin:0;margin-bottom:5px;">
						<span>Message</span>
					</h4>
					<div class="span-message" style="height:95px;align-items:center;display:flex;font-size:14px;">
						<span>Sorry, Create Data was unsuccessfully !</span>
					</div>
					<button id="btnClose" style="padding:10px 20px; border:1px solid #fff; background:transparent;color:#fff;cursor:pointer;border-radius:3px;"><span>Close</span></button>
					</div>
				</span>
				</div>
		</div>
	</div>
	<div id="confirm" style="font-family:'Roboto-regular';position:fixed;width:100%;height:100%;left:0;top:0;background:rgba(0,0,0,0.5);align-item:center;border-weight:bolder;">
		<div style="width:350px;height:175px;border:1px solid #fff;border-radius:3px;margin:auto;background:#fff;display:flex;align-item:center;">
			<div style="margin:auto;width:80%;">
				<span class="Loader">
					<div class="Loader-indicator" >
					<h4 style="font-family:'Roboto-medium';margin:0;margin-bottom:5px;">
						<span>Message</span>
					</h4>
					<span class="span-confirm" style="font-size:13px;"></span>
					<div style="margin-top:20px;">
						<button id="btnConfirmNo" style="float:right;margin-left:5px;background-color:#d14836 !important;" class="btn right">No</button>
						<button id="btnConfirmYes" style="float:right;" class="btn right">Yes</button>
					</div>
					</div>
				</span>
				</div>
		</div>
	</div>
</body>
