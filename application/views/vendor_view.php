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

		$('#vendor_id_desktop').attr('readonly', true);
    $('#vendor_title_desktop').attr("disabled", true);
    $('#vendor_name_desktop').attr('readonly', true);
    $('#vendor_type_desktop').attr("disabled", true);
    $('#vendor_searchterm_desktop').attr('readonly', true);
    $('#vendor_address1_desktop').attr('readonly', true);
    $('#vendor_address2_desktop').attr('readonly', true);
    $('#vendor_address3_desktop').attr('readonly', true);
    $('#vendor_houseno_desktop').attr('readonly', true);
    $('#vendor_city_desktop').attr('readonly', true);
    $('#vendor_postalcode_desktop').attr('readonly', true);
    $('#vendor_province_desktop').attr("disabled", true);
    $('#vendor_country_desktop').attr('readonly', true);
    $('#vendor_phone_desktop').attr('readonly', true);
    $('#vendor_mobile_desktop').attr('readonly', true);
    $('#vendor_npwp_desktop').attr('readonly', true);
    $('#vendor_ppn_desktop').attr("disabled", true);
    $('#vendor_bankkey_desktop').attr('readonly', true);
    $('#vendor_accountno_desktop').attr('readonly', true);
    $('#vendor_accountname_desktop').attr('readonly', true);
    $('#vendor_paymentterm_desktop').attr('readonly', true);

    $('#vendor_id_desktop').css('background', '#f9f9f9');
    $('#vendor_title_desktop').css('background', '#f9f9f9');
    $('#vendor_name_desktop').css('background', '#f9f9f9');
    $('#vendor_type_desktop').css('background', '#f9f9f9');
    $('#vendor_searchterm_desktop').css('background', '#f9f9f9');
    $('#vendor_address1_desktop').css('background', '#f9f9f9');
    $('#vendor_address2_desktop').css('background', '#f9f9f9');
    $('#vendor_address3_desktop').css('background', '#f9f9f9');
    $('#vendor_houseno_desktop').css('background', '#f9f9f9');
    $('#vendor_city_desktop').css('background', '#f9f9f9');
    $('#vendor_postalcode_desktop').css('background', '#f9f9f9');
    $('#vendor_province_desktop').css('background', '#f9f9f9');
    $('#vendor_country_desktop').css('background', '#f9f9f9');
    $('#vendor_phone_desktop').css('background', '#f9f9f9');
    $('#vendor_mobile_desktop').css('background', '#f9f9f9');
    $('#vendor_npwp_desktop').css('background', '#f9f9f9');
    $('#vendor_ppn_desktop').css('background', '#f9f9f9');
    $('#vendor_bankkey_desktop').css('background', '#f9f9f9');
    $('#vendor_accountno_desktop').css('background', '#f9f9f9');
    $('#vendor_accountname_desktop').css('background', '#f9f9f9');
    $('#vendor_paymentterm_desktop').css('background', '#f9f9f9');

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
        $('#vendor_title_desktop').attr("disabled", false);
        $('#vendor_name_desktop').attr('readonly', false);
        $('#vendor_type_desktop').attr("disabled", false);
        $('#vendor_searchterm_desktop').attr('readonly', false);
        $('#vendor_address1_desktop').attr('readonly', false);
        $('#vendor_address2_desktop').attr('readonly', false);
        $('#vendor_address3_desktop').attr('readonly', false);
        $('#vendor_houseno_desktop').attr('readonly', false);
        $('#vendor_city_desktop').attr('readonly', false);
        $('#vendor_postalcode_desktop').attr('readonly', false);
        $('#vendor_province_desktop').attr("disabled", false);
        $('#vendor_country_desktop').attr('readonly', false);
        $('#vendor_phone_desktop').attr('readonly', false);
        $('#vendor_mobile_desktop').attr('readonly', false);
        $('#vendor_npwp_desktop').attr('readonly', false);
        $('#vendor_ppn_desktop').attr("disabled", false);
        $('#vendor_bankkey_desktop').attr('readonly', false);
        $('#vendor_accountno_desktop').attr('readonly', false);
        $('#vendor_accountname_desktop').attr('readonly', false);
        $('#vendor_paymentterm_desktop').attr('readonly', false);

        $('#vendor_title_desktop').css('background', '#ffffff');
        $('#vendor_name_desktop').css('background', '#ffffff');
        $('#vendor_type_desktop').css('background', '#ffffff');
        $('#vendor_searchterm_desktop').css('background', '#ffffff');
        $('#vendor_address1_desktop').css('background', '#ffffff');
        $('#vendor_address2_desktop').css('background', '#ffffff');
        $('#vendor_address3_desktop').css('background', '#ffffff');
        $('#vendor_houseno_desktop').css('background', '#ffffff');
        $('#vendor_city_desktop').css('background', '#ffffff');
        $('#vendor_postalcode_desktop').css('background', '#ffffff');
        $('#vendor_province_desktop').css('background', '#ffffff');
        $('#vendor_country_desktop').css('background', '#ffffff');
        $('#vendor_phone_desktop').css('background', '#ffffff');
        $('#vendor_mobile_desktop').css('background', '#ffffff');
        $('#vendor_npwp_desktop').css('background', '#ffffff');
        $('#vendor_ppn_desktop').css('background', '#ffffff');
        $('#vendor_bankkey_desktop').css('background', '#ffffff');
        $('#vendor_accountno_desktop').css('background', '#ffffff');
        $('#vendor_accountname_desktop').css('background', '#ffffff');
        $('#vendor_paymentterm_desktop').css('background', '#ffffff');
      }else{
        location.reload();
      }
    });

    $("#contact-tab").click(function(){
      if($("#vendor_title_desktop").val() == ''){
        $("#vendor_title_desktop").css('border','1px solid red');
      }else{
        $("#vendor_title_desktop").css('border','1px solid #c1c1c1');
      }

      if($("#vendor_name_desktop").val() == ''){
        $("#vendor_name_desktop").css('border','1px solid red');
      }else{
        $("#vendor_name_desktop").css('border','1px solid #c1c1c1');
      }

      if($("#vendor_type_desktop").val() == ''){
        $("#vendor_type_desktop").css('border','1px solid red');
      }else{
        $("#vendor_name_desktop").css('border','1px solid #c1c1c1');
      }

      if($("#vendor_title_desktop").val() != '' && $("#vendor_name_desktop").val() != '' && $("#vendor_type_desktop").val() != ''){
        $("#profile-tab").css('background-color','#fff');
        $("#contact-tab").css('background-color','#f1f1f1');
        $("#tax-tab").css('background-color','#fff');
        $("#account-tab").css('background-color','#fff');

        $("#vendor_title_desktop").css('border','1px solid #c1c1c1');
        $("#vendor_name_desktop").css('border','1px solid #c1c1c1');
        $("#vendor_type_desktop").css('border','1px solid #c1c1c1');

        $("#tablist-profile").hide();
        $("#tablist-contact").show();
        $("#tablist-tax").hide();
        $("#tablist-account").hide();
      }
    });

    $("#tax-tab").click(function(){
      if($("#vendor_address1_desktop").val() == ''){
        $("#vendor_address1_desktop").css('border','1px solid red');
      }else{
        $("#vendor_address1_desktop").css('border','1px solid #c1c1c1');
      }

      if($("#vendor_houseno_desktop").val() == ''){
        $("#vendor_houseno_desktop").css('border','1px solid red');
      }else{
        $("#vendor_houseno_desktop").css('border','1px solid #c1c1c1');
      }

      if($("#vendor_city_desktop").val() == ''){
        $("#vendor_city_desktop").css('border','1px solid red');
      }else{
        $("#vendor_city_desktop").css('border','1px solid #c1c1c1');
      }

      if($("#vendor_province_desktop").val() == ''){
        $("#vendor_province_desktop").css('border','1px solid red');
      }else{
        $("#vendor_province_desktop").css('border','1px solid #c1c1c1');
      }

      if($("#vendor_country_desktop").val() == ''){
        $("#vendor_country_desktop").css('border','1px solid red');
      }else{
        $("#vendor_country_desktop").css('border','1px solid #c1c1c1');
      }

      if($("#vendor_address1_desktop").val() != '' && $("#vendor_houseno_desktop").val() != '' && $("#vendor_city_desktop").val() != '' && $("#vendor_province_desktop").val() != '' && $("#vendor_country_desktop").val() != ''){
        $("#profile-tab").css('background-color','#fff');
        $("#contact-tab").css('background-color','#fff');
        $("#tax-tab").css('background-color','#f1f1f1');
        $("#account-tab").css('background-color','#fff');

        $("#vendor_address1_desktop").css('border','1px solid #c1c1c1');
        $("#vendor_houseno_desktop").css('border','1px solid #c1c1c1');
        $("#vendor_city_desktop").css('border','1px solid #c1c1c1');
        $("#vendor_province_desktop").css('border','1px solid #c1c1c1');
        $("#vendor_country_desktop").css('border','1px solid #c1c1c1');

        $("#tablist-profile").hide();
        $("#tablist-contact").hide();
        $("#tablist-tax").show();
        $("#tablist-account").hide();
      }
    });

    $("#account-tab").click(function(){
      if($("#vendor_npwp_desktop").val() == ''){
        $("#vendor_npwp_desktop").css('border','1px solid red');
      }else{
        $("#vendor_npwp_desktop").css('border','1px solid #c1c1c1');
      }

      if($("#vendor_ppn_desktop").val() == ''){
        $("#vendor_ppn_desktop").css('border','1px solid red');
      }else{
        $("#vendor_ppn_desktop").css('border','1px solid #c1c1c1');
      }

      if($("#vendor_npwp_desktop").val() != '' && $("#vendor_ppn_desktop").val() != ''){
        $("#profile-tab").css('background-color','#fff');
        $("#contact-tab").css('background-color','#fff');
        $("#tax-tab").css('background-color','#fff');
        $("#account-tab").css('background-color','#f1f1f1');

        $("#vendor_npwp_desktop").css('border','1px solid #c1c1c1');
        $("#vendor_ppn_desktop").css('border','1px solid #c1c1c1');

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
	});
</script>
<script>
	$(function(){
		$(function(){
			var iden = '';
      $.ajax({
        url:"<?php echo base_url();?>index.php/request/get_data_detail_draft/<?php echo $this->uri->segment(3);?>",
        cache:false,
        type: "POST",
        dataType: 'json',
        success:function(result){
					$(".drop ul li").remove();
					$("#tbl-list tbody tr").removeClass("selectVendor");
					$("#<?php echo $this->uri->segment(3);?>").addClass("selectVendor");
          $.each(result, function(i, data){
            $('#vendor_id_desktop').val(data.MDG_Vendor_ID);
						$('#vendor_id_desktop_tl').val(data.MDG_Vendor_ID);
						iden = data.MDG_Vendor_ID;
            $("#vendor_title_desktop option").remove();
            $("#vendor_title_desktop").append("<option value=''>--select vendor title--</option>");
            if(data.MDG_Title == 2){
              $("#vendor_title_desktop").append("<option value='0001'>0001 - Ms.</option>");
              $("#vendor_title_desktop").append("<option value='0002' selected>0002 - Mr.</option>");
              $("#vendor_title_desktop").append("<option value='0003'>0003 - Company</option>");
            }else if(data.MDG_Title == 3){
              $("#vendor_title_desktop").append("<option value='0001'>0001 - Ms.</option>");
              $("#vendor_title_desktop").append("<option value='0002'>0002 - Mr.</option>");
              $("#vendor_title_desktop").append("<option value='0003' selected>0003 - Company</option>");
            }else{
              $("#vendor_title_desktop").append("<option value='0001' selected>0001 - Ms.</option>");
              $("#vendor_title_desktop").append("<option value='0002'>0002 - Mr.</option>");
              $("#vendor_title_desktop").append("<option value='0003'>0003 - Company</option>");
            }

            $('#vendor_name_desktop').val(data.MDG_VendorName);

            $(function(){
              $.ajax({
                url:"<?php echo base_url();?>index.php/request/get_data_vendor_type/",
                cache:false,
                type: "POST",
                dataType: 'json',
                success:function(result){
                  $("#vendor_type_desktop option").remove();
                  $("#vendor_type_desktop").append("<option value=''>--select vendor type--</option>");
                  $.each(result, function(i, data1){
                      if(data.MDG_VendorType_ID == data1.VendorType_ID){
                          $("#vendor_type_desktop").append("<option value='"+data1.VendorType_ID+"' selected>"+data1.VendorType_ID+" - "+data1.VendorType_Name+"</option>");
                      }else{
                          $("#vendor_type_desktop").append("<option value='"+data1.VendorType_ID+"'>"+data1.VendorType_ID+" - "+data1.VendorType_Name+"</option>");
                      }
                  });
                }
              });
            });

            $('#vendor_searchterm_desktop').val(data.MDG_SearchTerm);
            $('#vendor_address1_desktop').val(data.MDG_Address1);
            $('#vendor_address2_desktop').val(data.MDG_Address2);
            $('#vendor_address3_desktop').val(data.MDG_Address3);
            $('#vendor_houseno_desktop').val(data.MDG_HouseNo);
            $('#vendor_city_desktop').val(data.MDG_City);
            $('#vendor_postalcode_desktop').val(data.MDG_PostalCode);
            $(function(){
              $.ajax({
                url:"<?php echo base_url();?>index.php/request/get_data_vendor_province/",
                cache:false,
                type: "POST",
                dataType: 'json',
                success:function(result){
                  $("#vendor_province_desktop option").remove();
                  $("#vendor_province_desktop").append("<option value=''>--select province--</option>");
                  $.each(result, function(i, data2){
                    if(data.VendorProvince_ID == data2.VendorProvince_ID){
                        $("#vendor_province_desktop").append("<option value='"+data2.VendorProvince_ID+"' selected>"+data2.VendorProvince_ID+" - "+data2.VendorProvince_Name+"</option>");
                    }else{
                        $("#vendor_province_desktop").append("<option value='"+data2.VendorProvince_ID+"'>"+data2.VendorProvince_ID+" - "+data2.VendorProvince_Name+"</option>");
                    }
                  });
                }
              });
            });
            $('#vendor_country_desktop').val(data.MDG_Country);
            $('#vendor_phone_desktop').val(data.MDG_Phone);
            $('#vendor_mobile_desktop').val(data.MDG_Mobile);
            $('#vendor_npwp_desktop').val(data.MDG_NPWP);

            if(data.MDG_PPN == 'Yes'){
                $("#vendor_ppn_desktop option").remove();
                $("#vendor_ppn_desktop").append("<option value=''>--select ppn--</option>");
                $("#vendor_ppn_desktop").append("<option value='yes' selected>Yes</option>");
                $("#vendor_ppn_desktop").append("<option value='no'>No</option>");
            }else{
                $("#vendor_ppn_desktop option").remove();
                $("#vendor_ppn_desktop").append("<option value=''>--select ppn--</option>");
                $("#vendor_ppn_desktop").append("<option value='yes'>Yes</option>");
                $("#vendor_ppn_desktop").append("<option value='no' selected>No</option>");
            }
            //$('#vendor_ppn_desktop').val(data.MDG_PPN);
            $('#vendor_bankkey_desktop').val(data.MDG_BankKey);
            $('#vendor_accountno_desktop').val(data.MDG_AccountNo);
            $('#vendor_accountname_desktop').val(data.MDG_AccountName);
            $('#vendor_paymentterm_desktop').val(data.MDG_PaymentTerm);

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
							url:"<?php echo base_url();?>index.php/request/get_log_vendor/",
							data:{
				        id:$('#vendor_id_desktop').val(),
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
        url:"<?php echo base_url();?>index.php/request/get_data_vendor_type/",
        cache:false,
        type: "POST",
        dataType: 'json',
        success:function(result){
          $("#vendor_type_desktop option").remove();
          $("#vendor_type_desktop").append("<option value=''>--select vendor type--</option>");
          $.each(result, function(i, data){
              $("#vendor_type_desktop").append("<option value='"+data.VendorType_ID+"'>"+data.VendorType_ID+" - "+data.VendorType_Name+"</option>");
          });
        }
      });
    });

    $(function(){
      $.ajax({
        url:"<?php echo base_url();?>index.php/request/get_data_vendor_province/",
        cache:false,
        type: "POST",
        dataType: 'json',
        success:function(result){
          $("#vendor_province_desktop option").remove();
          $("#vendor_province_desktop").append("<option value=''>--select province--</option>");
          $.each(result, function(i, data){
              $("#vendor_province_desktop").append("<option value='"+data.VendorProvince_ID+"'>"+data.VendorProvince_ID+" - "+data.VendorProvince_Name+"</option>");
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
			var d = $("#vendor_id_desktop_tl").val();
			$.ajax({
				url:"<?php echo base_url();?>index.php/request/all_approval/"+d,
				cache:false,
				type: "POST",
				dataType: 'json',
				success:function(result){
					$(".drop ul li").remove();
					$.each(result, function(i, data1){
						$(".drop ul").append("<li style='background:transparent;border:1px solid rgb(221, 81, 54);color:rgb(221, 81, 54);padding:5px 10px;' id='"+data1.Mapping_approval_person+"'>"+data1.Account_First_Name+" "+data1.Account_Last_Name+"<span></span></li>");
						$.ajax({
							url:"<?php echo base_url();?>index.php/request/click_approval/"+d,
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
					url:"<?php echo base_url();?>index.php/request/get_send_again_vendor/",
					cache:false,
					data:{
						id:$('#vendor_id_desktop').val(),
						title:$('#vendor_title_desktop').val(),
						name:$('#vendor_name_desktop').val(),
						type:$('#vendor_type_desktop').val(),
						searchterm:$('#vendor_searchterm_desktop').val(),
						address1:$('#vendor_address1_desktop').val(),
						address2:$('#vendor_address2_desktop').val(),
						address3:$('#vendor_address3_desktop').val(),
						houseno:$('#vendor_houseno_desktop').val(),
						city:$('#vendor_city_desktop').val(),
						postal:$('#vendor_postalcode_desktop').val(),
						province:$('#vendor_province_desktop').val(),
						country:$('#vendor_country_desktop').val(),
						phone:$('#vendor_phone_desktop').val(),
						mobile:$('#vendor_mobile_desktop').val(),
						npwp:$('#vendor_npwp_desktop').val(),
						ppn:$('#vendor_ppn_desktop').val(),
						bankkey:$('#vendor_bankkey_desktop').val(),
						accountno:$('#vendor_accountno_desktop').val(),
						accountname:$('#vendor_accountname_desktop').val(),
						paymentterm:$('#vendor_paymentterm_desktop').val(),
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$(".span-message span").remove();
							$(".span-message").append('<span>Create process was successful, wait the approval for the request . .</span>');
							$("#noticeCnt").fadeIn().delay(3000).fadeOut();
							$("#vendor_id_desktop").val(result.id);
						}else if(result.status == 'faillogupdate'){
							$(".span-message span").remove();
							$(".span-message").append('<span>2Create process was successful, wait the approval for the request . .</span>');
							$("#noticeCnt").fadeIn().delay(3000).fadeOut();
							$("#vendor_id_desktop").val(result.id);
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

			function downloadExcel(){
				window.location.href = '<?php echo base_url();?>index.php/control/get_export_excel_vendor';
			}

			function get_save(){
				var $load_id = $('#loadingDiv').hide();
				$load_id.show();
				$.ajax({
					url:"<?php echo base_url();?>index.php/request/get_update_vendor/",
					cache:false,
					data:{
						id:$('#vendor_id_desktop').val(),
						title:$('#vendor_title_desktop').val(),
						name:$('#vendor_name_desktop').val(),
						type:$('#vendor_type_desktop').val(),
						searchterm:$('#vendor_searchterm_desktop').val(),
						address1:$('#vendor_address1_desktop').val(),
						address2:$('#vendor_address2_desktop').val(),
						address3:$('#vendor_address3_desktop').val(),
						houseno:$('#vendor_houseno_desktop').val(),
						city:$('#vendor_city_desktop').val(),
						postal:$('#vendor_postalcode_desktop').val(),
						province:$('#vendor_province_desktop').val(),
						country:$('#vendor_country_desktop').val(),
						phone:$('#vendor_phone_desktop').val(),
						mobile:$('#vendor_mobile_desktop').val(),
						npwp:$('#vendor_npwp_desktop').val(),
						ppn:$('#vendor_ppn_desktop').val(),
						bankkey:$('#vendor_bankkey_desktop').val(),
						accountno:$('#vendor_accountno_desktop').val(),
						accountname:$('#vendor_accountname_desktop').val(),
						paymentterm:$('#vendor_paymentterm_desktop').val(),
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$(".span-message span").remove();
							$(".span-message").append('<span>Update process was successful, Please check draft . .</span>');
							$("#noticeCnt").fadeIn().delay(2000).fadeOut();
							$("#vendor_id_desktop").val(result.id);
						}else if(result.status == 'notlog'){
							$(".span-message span").remove();
							$(".span-message").append('<span>Update process was successful, Please check draft . .</span>');
							$("#noticeCnt").fadeIn().delay(2000).fadeOut();
							$("#vendor_id_desktop").val(result.id);
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
</script>
<body>
	<div class="container">
		<div class="bg-list">
			<div class="middle-box" style="background-color:#fff;border:0;">
				<h3 class="title">MDG Application</h3>

				<div style="float: right;margin-right: 65px;"><h3>Master Vendor List</h3></div>

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
  				<a class="tab" id="form-tab">Detail Vendor</a>
					<a class="tab" id="line-tab">Time Line</a>
  			</div>
  			<div id="tbl-form" style="padding:0px 20px;float:left">
          <div class="list-box" style="width:70%;float:left">
  					<div class="form-create">
  						<h3 style="margin-top:20px;"><span>Master Data Vendor</span></h3>
  						<div style="margin-top:20px;margin-bottom:50px;">
  							<div id="frmDTL">
  								<div class="group-txt" style="width:95%;">
  									<label style="width:100%;float:left;">(Vendor) Request ID</label>
  									<input type="text" style="background:#f9f9f9;width:30%;" name="vendor_id_desktop" id="vendor_id_desktop" readonly/>
										<button id="change-btn" style="background-color:#ffffff;"><span style="font-size:12px;font-family:'Roboto-Regular';color:#555;">Change</span></button>
  								</div>

  								<div style="width:100%;border-top:1px solid #f1f1f1;margin-top:10px;float:left;"></div>

  								<div id="tab-table" style="float:left;width:100%;margin-top: 20px;margin-bottom:20px;">
  									<a class="tab" id="profile-tab">Profile</a>
  									<a class="tab" id="contact-tab">Contact</a>
  									<a class="tab" id="tax-tab">Tax</a>
  									<a class="tab" id="account-tab">Account Bank</a>
  								</div>

  								<div id="tablist-profile">
  									<h4>Vendor Profile</h4>
  									<div class="group-txt" style="width:10%;">
  										<label>Title *</label>
  										<select name="vendor_title_desktop" id="vendor_title_desktop">
  											<option value=""> -- select vendor title -- </option>
  											<option value="0001">0001 - Ms.</option>
  											<option value="0002">0002 - Mr.</option>
  											<option value="0003">0003 - Company</option>
  										</select>
  									</div>
  									<div class="group-txt" style="width:80%;">
  										<label>Name *</label>
  										<span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 40 char)</span>
  										<input type="text" name="vendor_name_desktop" id="vendor_name_desktop" onkeypress="blockSpecial(event);" maxlength="40"/>
  									</div>
  									<div class="group-txt" style="width:90%;">
  										<label style="width:100%;float:left;">Vendor Type *</label>
  										<select style="width:30%;" name="vendor_type_desktop" id="vendor_type_desktop">
  											<option value=""> -- select vendor type -- </option>
  										</select>
  									</div>
  									<div class="group-txt" style="width:90%;margin-bottom:50px;">
  										<div style="width:100%;float:left;">
  											<label>SearchTerm</label>
  											<span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 20 char)</span>
  										</div>
  										<input style="width:30%;" type="text" onkeypress="blockSpecial(event);" name="vendor_searchterm_desktop" id="vendor_searchterm_desktop" maxlength="20"/>
  									</div>
  								</div>

  								<div id="tablist-contact">
  									<h4>Vendor Contact</h4>
  									<div class="group-txt" style="width:90%;">
  										<label>Address 1 *</label>
  										<span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 60 char)</span>
  										<textarea type="text" name="vendor_address1_desktop" onkeypress="blockSpecial(event);" id="vendor_address1_desktop" maxlength="60"></textarea>
  									</div>
  									<div class="group-txt" style="width:90%;">
  										<label>Address 2</label>
  										<span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 40 char)</span>
  										<textarea type="text" name="vendor_address2_desktop" onkeypress="blockSpecial(event);" id="vendor_address2_desktop" maxlength="40"></textarea>
  									</div>
  									<div class="group-txt" style="width:90%;">
  										<label>Address 3</label>
  										<span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 40 char)</span>
  										<textarea type="text" name="vendor_address3_desktop" onkeypress="blockSpecial(event);" id="vendor_address3_desktop" maxlength="40"></textarea>
  									</div>
  									<div class="group-txt" style="width:10%;margin-right:10px;">
  										<div style="width:100%;float:left;">
  											<label>No *</label>
  											<span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 10 char)</span>
  										</div>
  										<input type="text" name="vendor_houseno_desktop" onkeypress="blockSpecial(event);" id="vendor_houseno_desktop" maxlength="10"/>
  									</div>
  									<div class="group-txt" style="width:35%;margin-right:10px;">
  										<label>City *</label>
  										<input type="text" name="vendor_city_desktop" onkeypress="blockSpecial(event);" id="vendor_city_desktop"/>
  									</div>
  									<div class="group-txt" style="width:15%;margin-right:10px;">
  										<label>Postal Code</label>
  										<span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 5 char)</span>
  										<input type="text" name="vendor_postalcode_desktop" onkeypress="blockAlphabeth(event);" id="vendor_postalcode_desktop" maxlength="5"/>
  									</div>
  									<div class="group-txt" style="width:45%;margin-right:10px;">
  										<label>Province *</label>
  										<select name="vendor_province_desktop" id="vendor_province_desktop">
  											<option value=""> -- select province -- </option>
  										</select>
  									</div>
  									<div class="group-txt" style="width:45%;margin-right:10px;margin-top: 5px;">
  										<label>Country *</label>
  										<span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 30 char)</span>
  										<input type="text" name="vendor_country_desktop" onkeypress="blockSpecial(event);" id="vendor_country_desktop" maxlength="30"/>
  									</div>
  									<div class="group-txt" style="width:45%;margin-right:10px;">
  										<label>Phone</label>
  										<span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 20 char)</span>
  										<input type="text" name="vendor_phone_desktop" onkeypress="blockAlphabeth(event);" id="vendor_phone_desktop" maxlength="20"/>
  									</div>
  									<div class="group-txt" style="width:45%;margin-right:10px;margin-bottom:50px;">
  										<label>Mobile</label>
  										<span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 20 char)</span>
  										<input type="text" name="vendor_mobile_desktop" onkeypress="blockAlphabeth(event);" id="vendor_mobile_desktop" maxlength="20"/>
  									</div>
  								</div>

  								<div id="tablist-tax">
  									<h4>Vendor Tax</h4>
  									<div class="group-txt" style="width:90%;">
  										<label>NPWP *</label>
  										<span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 20 char)</span>
  										<input type="text" name="vendor_npwp_desktop" onkeypress="blockAlphabeth(event);" id="vendor_npwp_desktop" maxlength="20"/>
  									</div>
  									<div class="group-txt" style="width:90%;margin-bottom:50px;">
  										<label style="width:90%;float:left;">PPN *</label>
  										<select style="width:30%;" name="vendor_ppn_desktop" id="vendor_ppn_desktop">
  											<option value=""> -- select ppn -- </option>
  											<option value="Yes"> Yes </option>
  											<option value="No"> No </option>
  										</select>
  									</div>
  								</div>

  								<div id="tablist-account">
  									<h4>Vendor Account Bank</h4>
  									<div class="group-txt" style="width:45%;margin-right:10px;">
  										<label>Bank Key</label>
  										<span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 15 char)</span>
  										<input type="text" name="vendor_bankkey_desktop" onkeypress="blockSpecial(event);" id="vendor_bankkey_desktop" maxlength="15"/>
  									</div>
  									<div class="group-txt" style="width:45%;margin-right:10px;">
  										<label>Account No</label>
  										<span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 18 char)</span>
  										<input type="text" name="vendor_accountno_desktop" onkeypress="blockAlphabeth(event);" id="vendor_accountno_desktop" maxlength="18"/>
  									</div>
  									<div class="group-txt" style="width:90%;">
  										<label>Account Name</label>
  										<span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 60 char)</span>
  										<input type="text" name="vendor_accountname_desktop" onkeypress="blockSpecial(event);" id="vendor_accountname_desktop" maxlength="60"/>
  									</div>
  									<div class="group-txt" style="width:45%;margin-right:10px;margin-bottom:50px;">
  										<label>Payment Term *</label>
  										<select name="vendor_paymentterm_desktop" id="vendor_paymentterm_desktop">
  											<option value=""> -- select payment terms -- </option>
  											<option value="0001">COD / DP</option>
  											<option value="0002">7 HARI</option>
  											<option value="0003">14  HARI</option>
  											<option value="0003">30 HARI</option>
  										</select>
  									</div>
  								</div>
  								<div style="float:left;width:100%;"><span style="font-size:13px;font-family:'Roboto-regular'">*) Fill the column</span></div>
  							</div>
  						</div>
  					</div>
  				</div>
          <div class="list-box" style="width:30%;float:left;background-color:#fff;">
						<h3 style="margin-top:20px;">Log Data Vendor</h3>
            <ul class="list-log">
              <li></li>
            </ul>
          </div>
  			</div>

				<div id="tbl-line" style="padding:0px 20px;float:left;">
					<h3 style="margin-top:20px;"><span>Timline (Data Vendor)</span></h3>
					<div style="margin-top:20px;margin-bottom:50px;">
						<div id="frmDTL">
							<div class="group-txt" style="width:95%;">
								<label style="width:100%;float:left;">(Vendor) Request ID</label>
								<input type="text" style="background:#f9f9f9;width:30%;" name="vendor_id_desktop_tl" id="vendor_id_desktop_tl" readonly/>
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
