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
  $(function(){
    $("#noticeCnt").hide();
    $("#loadingDiv").hide();
    $(".form-create").hide();
    $("#not_edit").hide();

    $(".btn-display").click(function(){
        $(".form-create").slideToggle(function(){
          if($(".btn-display span").text() == 'Open Detail MDG'){
            $(".btn-display span").remove();
            $(".btn-display").append("<span>Close Detail MDG</span>");
          }else{
            $(".btn-display span").remove();
            $(".btn-display").append("<span>Open Detail MDG</span>");
          }
        });
    });

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

    //ini script tab list//

    $(function(){
      $.ajax({
        url:"<?php echo base_url();?>index.php/request/get_data_detail_draft_app/<?php echo $this->uri->segment(3);?>/<?php echo $this->uri->segment(4);?>",
        cache:false,
        type: "POST",
        dataType: 'json',
        success:function(result){
            if(result.status == 'blm'){
              //bisa input approval
              $.ajax({
                url:"<?php echo base_url();?>index.php/request/get_data_detail_draft/<?php echo $this->uri->segment(3);?>",
                cache:false,
                type: "POST",
                dataType: 'json',
                success:function(result){
                  $.each(result, function(i, data){
                    if(data.MDG_Status == '2' || data.MDG_Status == '3'){
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
                      $("#not_edit").show();
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
            }else{
              //tidak bisa
              $.ajax({
                url:"<?php echo base_url();?>index.php/request/cek_approval_next_ver/<?php echo $this->uri->segment(3);?>/<?php echo $this->uri->segment(4);?>",
                cache:false,
                type: "POST",
                dataType: 'json',
                success:function(result){
                  if(result.status == 'ada'){
                    $("#not_edit").hide();
                  }else{
                    $("#not_edit").show();
                  }
                }
              });

              $.ajax({
                url:"<?php echo base_url();?>index.php/request/get_data_detail_draft/<?php echo $this->uri->segment(3);?>",
                cache:false,
                type: "POST",
                dataType: 'json',
                success:function(result){
                  $.each(result, function(i, data){
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
                  });
                }
              });
            }
        }
      });
    });

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
  });
</script>
<script>
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

  function sendApprove(){
    var $load_id = $('#loadingDiv').hide();
    $load_id.show();
    var app;
    var remark;
    if($('#approve').is(':checked')){
      app = 1;
    }else if($('#not_approve').is(':checked')){
      app = 0;
    }

    remark = $("#remark").val();

    $.ajax({
      url:"<?php echo base_url();?>index.php/request/get_approval_vendor/",
      cache:false,
      data:{
        id:'<?php echo $this->uri->segment(3);?>',
        app:app,
        remark:remark,
        acc:'<?php echo $this->uri->segment(4);?>',
      },
      type: "POST",
      dataType: 'json',
      success:function(result){
        if(result.status == 'success'){
          $(".span-message span").remove();
          $(".span-message").append('<span>Approval process was successful . .</span>');
          $("#noticeCnt").fadeIn().delay(2000).fadeOut();
          $("#vendor_id_desktop").val(result.id);
        }else if(result.status == 'notlog'){
          $(".span-message span").remove();
          $(".span-message").append('<span>Approval process was successful . .</span>');
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
          $(".span-message").append('<span>Sorry, approval process was failure</span>');
          $("#noticeCnt").fadeIn().delay(2000).fadeOut();
        }
        $load_id.hide();
      }
    });
  }
</script>
<body class="app-body">
  <div class="app-header">
    <div class="icon">
      <h1>Gloria Origita Cosmetics</h1>
    </div>
  </div>
  <div class="app-tool">
    <div>
      <h2>MDG Approval Form</h2>
    </div>
    <div>
      <button id="print-btn" onclick="get_print();"></button>
      <button id="refresh-btn" onclick="listDetail();"></button>
    </div>
  </div>
  <div class="app-main">
    <!------------MAIN DISPLAY------------->
    <div class="list-box">
      <div class="form-create" style="float:left;width:100%;background-color:#f9f9f9;">
        <h3 style="margin-top:20px;padding:0px 25px"><span>Display Master Data Vendor</span></h3>
        <div style="margin-top:20px;margin-bottom:50px;padding:0px 25px;">
          <div id="frmDTL">
            <div class="group-txt" style="width:100%;">
              <label style="width:100%;float:left;">(Vendor) Request ID</label>
              <input type="text" style="background:#f9f9f9;width:30%;" name="vendor_id_desktop" id="vendor_id_desktop" readonly/>
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
    <!------------MAIN DISPLAY------------->
  </div>
  <div class="app-footer">
    <div class="btn-display"><span>Open Detail MDG</span></div>
    <div style="width:100%;">
      <div class="group-txt" style="width:100%;padding:0;margin:0;margin-bottom:5px;font-family:'Roboto-Regular'">
        <label>Approve ?</label>
        <input type="radio" name="vendor_app_desktop" value="1" style="width: fit-content;width: auto;" id="approve"/><span style="font-size:13px;">Yes</span>
        <input type="radio" name="vendor_app_desktop" value="0" style="width: fit-content;width: auto;" id="not_approve"/><span style="font-size:13px;">No</span>
      </div>
      <div class="group-txt" style="width:45%;padding:0;margin:0;font-family:'Roboto-Regular'">
        <div style="width:100%;float:left;padding:0;">
          <label>Remark</label>
          <span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 15 char)</span>
        </div>
        <textarea name="vendor_remark_desktop" style="width:70%;height:100px;" onkeypress="blockSpecial(event);" id="remark" maxlength="150"></textarea>
        <button id="send-btn" onclick="sendApprove();"></button>
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
      <h2 style="width:100%;float:left;font-family:'Roboto-Light'; font-size:13px;color:#555;">Sorry this approval form is disabled because approval was processed.</h2>
      <span><a href="<?php echo base_url().'index.php/request/get_draft/';?>">back to list draft</a></span>
      </div>
    </div>
  </div>
</body>
