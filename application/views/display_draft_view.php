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
</script>
<script>
  $(function(){
    $("#datepicker").datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: 'yy-mm-dd'
    });

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

    $("#noticeCnt").hide();
    $('#datepicker').datepicker('setDate', 'today');
    $(".container-mobile-search").hide();
    $(".container-mobile-choose").hide();
    $(".updateDetail").attr("disabled", "disabled");
    $(".updateDetail").css("opacity","0.5");

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

    $("#btnClose").click(function(){
      $("#noticeCnt").hide();
    });
  });
</script>
<script>
  $(function(){
    $(".menu-create").hide();
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

    $('#not_edit').hide();

    $(function(){
      $.ajax({
        url:"<?php echo base_url();?>index.php/request/get_data_detail_draft/<?php echo $this->uri->segment(3);?>",
        cache:false,
        type: "POST",
        dataType: 'json',
        success:function(result){
          $.each(result, function(i, data){
            if(data.MDG_Status == 2){
              $('#not_edit').show();
              $('#vendor_id_desktop').val(data.MDG_Vendor_ID);
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
            }else{
              $('#vendor_id_desktop').val(data.MDG_Vendor_ID);
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
            }
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

  function get_refresh(){
    location.reload();
  }

  function get_send(){
    var $load_id = $('#loadingDiv').hide();
    $load_id.show();
    $.ajax({
      url:"<?php echo base_url();?>index.php/request/get_send_draft/",
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
          $("#noticeCnt").fadeIn().delay(1000).fadeOut();
          $("#vendor_id_desktop").val(result.id);
        }else if(result.status == 'notlog'){
          $(".span-message span").remove();
          $(".span-message").append('<span>Create process was successful, wait the approval for the request . .</span>');
          $("#noticeCnt").fadeIn().delay(1000).fadeOut();
          $("#vendor_id_desktop").val(result.id);
        }else if(result.status == 'refresh'){
          $(".span-message span").remove();
          $(".span-message").append('<span>ID Vendor not to use, Please Refesh this form and try again . .</span>');
          $("#noticeCnt").fadeIn().delay(1000).fadeOut();
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
      url:"<?php echo base_url();?>index.php/request/get_save_edit_vendor/",
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
          $(".span-message").append('<span>Create process was successful, Please check draft . .</span>');
          $("#noticeCnt").fadeIn().delay(2000).fadeOut();
          $("#vendor_id_desktop").val(result.id);
        }else if(result.status == 'notlog'){
          $(".span-message span").remove();
          $(".span-message").append('<span>Create process was successful, Please check draft . .</span>');
          $("#noticeCnt").fadeIn().delay(2000).fadeOut();
          $("#vendor_id_desktop").val(result.id);
        }else if(result.status == 'refresh'){
          $(".span-message span").remove();
          $(".span-message").append('<span>ID Vendor not to use, Please Refesh this form and try again . .</span>');
          $("#noticeCnt").fadeIn().delay(2000).fadeOut();
        }else if(result.status == 'require'){
          $(".span-message span").remove();
          $(".span-message").append('<span>Please complete your entry to asterisk column (*)</span>');

          $("#noticeCnt").fadeIn().delay(2000).fadeOut();
        }else{
          $(".span-message span").remove();
          $(".span-message").append('<span>Sorry, create process was failure</span>');
          $("#noticeCnt").fadeIn().delay(2000).fadeOut();
        }
        $load_id.hide();
      }
    });
  }
</script>
<body>
  <div class="container">
    <div class="bg-list">
      <div class="header-box">
        <div id="desktop-menu">
          <h2 class="fgrey" style="float:left">GOC Cosmetics</h2>
          <input type="text" id="search-txt"/>
          <button id="search-btn" onclick="btnSearchDetail()"></button>
          <a class="drop-collapse-usr-btn" style="margin-right: 35px;position: absolute;right: 0;"><img id="bell-mobile-button" src="<?php echo base_url().'assets/img/user.png';?>" style="width:25px;"/></a>
          <div class="drop-collapse-usr">
            <ul>
              <li>
                <div>
                  <div style="width:100%;display:flex;height:150px;">
                    <div style="width:100%;margin:auto;text-align:center;">
                      <img style="width:40%;margin:auto;" src="<?php echo base_url().'assets/img/user.png';?>"/>
                      <br/>
                      <span style="font-size:16px;"><?php echo $first_name.' '.$last_name;?></span>
                      <br/>
                      <span style="font-size:13px;margin-left:-3px;"><?php echo '('.$username.')';?></span>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <a class="drop-collapse-bell-btn" style="float:right;margin-right:60px;margin-top:0px;"><img id="bell-mobile-button" src="<?php echo base_url().'assets/img/bell.png';?>" style="width:25px;"/><div class="news-bell"><?php echo $c_update;?> </div></a>
          <div class="drop-collapse-bell" id="bell-desktop">
            <ul>
              <li id="read-all" onclick="clickAll()" style="font-size:13px;color:#4285f4;">Read More</li>
            </ul>
          </div>
        </div>
        <div id="mobile-menu">
            <a id="mobile-menuBtn"><img src="<?php echo base_url().'assets/img/menu.png';?>" style="width:20px;"/></a>
            <h2 style="position: absolute;top:0;margin-top:18px;margin-left:35px;font-size: 20px;color:#555;">GOC</h2>
            <a style="margin-right:35px;margin-top:2px;position:absolute;right:0;"><img id="search-mobile-button" src="<?php echo base_url().'assets/img/search-mini.png';?>" style="width:20px;"/></a>
            <a class="drop-collapse-bell-btn" style="float:right;margin-right:50px;margin-top:0px;"><img id="bell-mobile-button" src="<?php echo base_url().'assets/img/bell.png';?>" style="width:25px;"/><div class="news-bell"><?php echo $c_update;?> </div></a>
            <div class="drop-collapse-bell" id="bell-desktop">
              <ul>
                <li style="font-size:13px;color:#4285f4;">Read More</li>
              </ul>
            </div>
          <div class="container-mobile-search" style="width:100%;height:100%;position:fixed;top:0;left:0;background:rgba(0,0,0,0);">
            <div style="position:absolute;top:0;left:0;width:100%;">
              <img id="back-mobile-button" src="<?php echo base_url().'assets/img/left.png';?>" style="width: 20px;position: fixed;top: 19px;left: 0;margin-left: 3%;"/>
              <input type="text" id="btnsearchMobile"/>
              <img id="search-mobile-button" src="<?php echo base_url().'assets/img/search-mini.png';?>" style="width: 20px;float: left;position: fixed;top: 19px;right: 0;margin-right: 3%;"/>
            </div>
          </div>
        </div>
        <div class="container-mobile-menu">
          <div class="span-mobile-menu">
            <div class="top-mobile-menu">
              <div style="float:right;padding:10px;" class="btn-close-mobile-menu"><img src="<?php echo base_url().'assets/img/cancel.png'?>"/></div>
              <div style="position:absolute;bottom:0;width:100%;">
                <div style="padding:50px 20px;">
                  <h5 style="margin:0;color:#fff;float:left;font-family:'Roboto-Regular'">Evan Abeiza<br/>evan.abeiza@gmail.com</h5>
                  <img class="drop-collapse-menu-btn" style="float:right;margin-top:10px;padding:5px;border-radius:50%;" src="<?php echo base_url().'assets/img/down.png';?>"/>
                  <div class="drop-collapse-menu">
                    <ul>
                      <li>My Account</li>
                      <li>My Privacy</li>
                      <li style="border-bottom:1px solid #f1f1f1;">Settings</li>
                      <li>Sign Out</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="bottom-mobile-menu">
              <ul id="sidebar">
                <li id="menu_m_inbox" onclick="">Inbox</li>
                <li id="menu_m_outbox" onclick="">Outbox</li>
                <li id="menu_m_ms_vendor" onclick="">Master Vendor</li>
                <li id="menu_m_ms_product" onclick="">Master Product</li>
                <li id="menu_m_ms_users" onclick="">Users</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="middle-box">
        <h3 class="title">MDG Application</h3>
        <div class="group-btn">
          <button id="print-btn" onclick="get_print();"></button>
          <button id="refresh-btn" onclick="get_refresh();"></button>
          <button id="send-btn" onclick="get_send();"></button>
        </div>
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
      <div class="menu-box">
        <button id="create" onclick="getCreateForm()" class="btn right red full">Create</button>
        <div class="menu-create">
          <h3>Form Request Master Data (SAP)</h3>
          <ul>
            <?php
              $query = $this->db->query("select * from Ms_Form_Request order by Request_Name");
              foreach($query->result() as $f){
            ?>
            <li onclick="linkRequest('<?php echo base_url().'index.php/request/'.$f->Request_Link;?>')" ><?php echo $f->Request_Name;?></li>
            <?php
              }
            ?>
          </ul>
        </div>
        <ul>
          <li id="menu_inbox" onclick="getLinked(this)">Inbox</li>
          <li id="menu_outbox" onclick="getLinked(this)">Outbox</li>
          <li id="menu_draft" onclick="getLinked(this)">Draft</li>
          <div style="border-bottom:1px dashed #e1e1e1"></div>
          <li id="menu_ms_vendor" onclick="getLinked(this)">Master Vendor</li>
          <li id="menu_ms_customer" onclick="getLinked(this)">Master Customer</li>
          <?php
          if($this->session->userdata('role') == '1'){
          ?>
            <div style="border-top:1px dashed #e1e1e1"></div>
            <li id="menu_ms_users" onclick="getLinked(this)">Users Control</li>
            <li id="menu_ms_confirm" onclick="getLinked(this)">Confirm Master Data</li>
          <?php
          }
          ?>
          <li id="menu_src_print" onclick="get_signout();">Sign Out</li>
        </ul>
      </div>
      <div id="list-box-mobile">
        <div class="form-create" style="padding: 0px 20px;">
          <h3 style="margin-top:20px;">Request Master Data Vendor</h3>
          <div style="margin-top:20px;margin-bottom:50px;">
            <div class="group-txt" style="width:350px;">
              <label>Vendor ID</label>
              <input type="text" name="vendor_id" id="vendor_id"/>
            </div>
            <div class="group-txt" style="width:350px;">
              <label>Vendor Type</label>
              <select name="vendor_type" id="vendor_type">
                <option value=""> -- select vendor type -- </option>
              </select>
            </div>
            <div class="group-txt" style="width:350px;">
              <label>Title</label>
              <input type="text" name="vendor_title" id="vendor_title"/>
            </div>
            <div class="group-txt" style="width:350px;">
              <label>Name</label>
              <input type="text" name="vendor_name" id="vendor_name"/>
            </div>
            <div class="group-txt" style="width:350px;">
              <label>SearchTerm</label>
              <input type="text" name="vendor_searchterm" id="vendor_searchterm"/>
            </div>
            <div class="group-txt" style="width:350px;">
              <label>Address 1</label>
              <textarea type="text" name="vendor_address1" id="vendor_address1"></textarea>
            </div>
            <div class="group-txt" style="width:350px;">
              <label>Address 2</label>
              <textarea type="text" name="vendor_address2" id="vendor_address2"></textarea>
            </div>
            <div class="group-txt" style="width:350px;">
              <label>Address 3</label>
              <textarea type="text" name="vendor_address3" id="vendor_address3"></textarea>
            </div>

            <div class="group-txt" style="width:350px;">
              <label>House No</label>
              <input type="text" name="vendor_houseno" id="vendor_houseno"/>
            </div>
            <div class="group-txt" style="width:350px;">
              <label>City</label>
              <input type="text" name="vendor_city" id="vendor_city"/>
            </div>
            <div class="group-txt" style="width:350px;">
              <label>Postal Code</label>
              <input type="text" name="vendor_postalcode" id="vendor_postalcode"/>
            </div>
            <div class="group-txt" style="width:350px;">
              <label>Province</label>
              <select name="vendor_province" id="vendor_province">
                <option value=""> -- select province -- </option>
              </select>
            </div>
            <div class="group-txt" style="width:350px;">
              <label>Country</label>
              <input type="text" name="vendor_country" id="vendor_country"/>
            </div>
            <div class="group-txt" style="width:350px;">
              <label>Phone</label>
              <input type="text" name="vendor_phone" id="vendor_phone"/>
            </div>
            <div class="group-txt" style="width:350px;">
              <label>Mobile</label>
              <input type="text" name="vendor_mobile" id="vendor_mobile"/>
            </div>
            <div class="group-txt" style="width:350px;">
              <label>NPWP</label>
              <input type="text" name="vendor_npwp" id="vendor_npwp"/>
            </div>
            <div class="group-txt" style="width:350px;">
              <label>PPN</label>
              <input style="width: 10px;" type="checkbox" name="vendor_ppn" id="vendor_ppn"/>
            </div>
            <div class="group-txt" style="width:350px;">
              <label>Bank Key</label>
              <input type="text" name="vendor_bankkey" id="vendor_bankkey"/>
            </div>
            <div class="group-txt" style="width:350px;">
              <label>Account No</label>
              <input type="text" name="vendor_accountno" id="vendor_accountno"/>
            </div>
            <div class="group-txt" style="width:350px;">
              <label>Account Name</label>
              <input type="text" name="vendor_accountname" id="vendor_accountname"/>
            </div>
            <div class="group-txt" style="width:350px;">
              <label>Payment Term</label>
              <input type="text" name="vendor_paymentterm" id="vendor_paymentterm"/>
            </div>
          </div>
        </div>
      </div>
      <div class="list-box">
        <div class="form-create">
          <h3 style="margin-top:20px;"><span>Display Master Data Vendor</span></h3>
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
  <div id="not_edit" style="background-color:rgba(255,255,255,0.5);position:fixed;width:100%;height:100%;left:0;top:0;display:flex;align-items:center;">
    <div style="width:250px;height:150px;padding:10px;margin:auto;align-items:center;display:flex;text-align:center;border:2px solid #555;border-radius:5px;background:#fff;">
      <div>
      <h2 style="width:100%;float:left;font-family:'Roboto-Light'; font-size:13px;color:#555;">Sorry you can't edit this MDG. You must waiting for approval status.</h2>
      <span><a href="<?php echo base_url().'index.php/request/get_draft/';?>">back to list draft</a></span>
      </div>
    </div>
  </div>
</body>
