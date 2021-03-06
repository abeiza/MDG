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

    $(".menu-create").hide();
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

    //ini script tab list//

    $(function(){
      $.ajax({
        url:"<?php echo base_url();?>index.php/request/get_data_detail_draft_customer_app/<?php echo $this->uri->segment(3);?>/<?php echo $this->uri->segment(4);?>",
        cache:false,
        type: "POST",
        dataType: 'json',
        success:function(result){
            if(result.status == 'blm'){
              //bisa input approval
              $.ajax({
                url:"<?php echo base_url();?>index.php/request/get_data_detail_customer_draft/<?php echo $this->uri->segment(3);?>",
                cache:false,
                type: "POST",
                dataType: 'json',
                success:function(result){
                  $.each(result, function(i, data){
                    if(data.MDG_Status == 2){
                      //$('#not_edit').show();
                      $('#customer_id_desktop').val(data.MDG_Customer_ID);
                      $("#customer_title_desktop option").remove();
                      $("#customer_title_desktop").append("<option value=''>--select vendor title--</option>");
                      if(data.MDG_Title == 2){
                        $("#customer_title_desktop").append("<option value='0001'>0001 - Person</option>");
                        $("#customer_title_desktop").append("<option value='0002' selected>0002 - Organization</option>");
                        $("#customer_title_desktop").append("<option value='0003'>0003 - Group</option>");
                      }else if(data.MDG_Title == 3){
                        $("#customer_title_desktop").append("<option value='0001'>0001 - Person</option>");
                        $("#customer_title_desktop").append("<option value='0002'>0002 - Organization</option>");
                        $("#customer_title_desktop").append("<option value='0003' selected>0003 - Group</option>");
                      }else{
                        $("#customer_title_desktop").append("<option value='0001' selected>0001 - Person</option>");
                        $("#customer_title_desktop").append("<option value='0002'>0002 - Organization</option>");
                        $("#customer_title_desktop").append("<option value='0003'>0003 - Group</option>");
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
                    }else{
                      $('#customer_id_desktop').val(data.MDG_Customer_ID);
                      $("#customer_title_desktop option").remove();
                      $("#customer_title_desktop").append("<option value=''>--select customer title--</option>");
                      if(data.MDG_Title == 2){
                        $("#customer_title_desktop").append("<option value='0001'>0001 - Person</option>");
                        $("#customer_title_desktop").append("<option value='0002' selected>0002 - Organization</option>");
                        $("#customer_title_desktop").append("<option value='0003'>0003 - Group</option>");
                      }else if(data.MDG_Title == 3){
                        $("#customer_title_desktop").append("<option value='0001'>0001 - Person</option>");
                        $("#customer_title_desktop").append("<option value='0002'>0002 - Organization</option>");
                        $("#customer_title_desktop").append("<option value='0003' selected>0003 - Group</option>");
                      }else{
                        $("#customer_title_desktop").append("<option value='0001' selected>0001 - Person</option>");
                        $("#customer_title_desktop").append("<option value='0002'>0002 - Organization</option>");
                        $("#customer_title_desktop").append("<option value='0003'>0003 - Group</option>");
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
                    }
                  });
                }
              });
            }else{
              //tidak bisa
              $.ajax({
                url:"<?php echo base_url();?>index.php/request/cek_approval_customer_next_ver/<?php echo $this->uri->segment(3);?>/<?php echo $this->uri->segment(4);?>",
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
                url:"<?php echo base_url();?>index.php/request/get_data_detail_customer_draft/<?php echo $this->uri->segment(3);?>",
                cache:false,
                type: "POST",
                dataType: 'json',
                success:function(result){
                  $.each(result, function(i, data){
                    if(data.MDG_Status == 2){
                      $('#customer_id_desktop').val(data.MDG_Customer_ID);
                      $("#customer_title_desktop option").remove();
                      $("#customer_title_desktop").append("<option value=''>--select vendor title--</option>");
                      if(data.MDG_Title == 2){
                        $("#customer_title_desktop").append("<option value='0001'>0001 - Person</option>");
                        $("#customer_title_desktop").append("<option value='0002' selected>0002 - Organization</option>");
                        $("#customer_title_desktop").append("<option value='0003'>0003 - Group</option>");
                      }else if(data.MDG_Title == 3){
                        $("#customer_title_desktop").append("<option value='0001'>0001 - Person</option>");
                        $("#customer_title_desktop").append("<option value='0002'>0002 - Organization</option>");
                        $("#customer_title_desktop").append("<option value='0003' selected>0003 - Group</option>");
                      }else{
                        $("#customer_title_desktop").append("<option value='0001' selected>0001 - Person</option>");
                        $("#customer_title_desktop").append("<option value='0002'>0002 - Organization</option>");
                        $("#customer_title_desktop").append("<option value='0003'>0003 - Group</option>");
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
                    }else{
                      $('#customer_id_desktop').val(data.MDG_Customer_ID);
                      $("#customer_title_desktop option").remove();
                      $("#customer_title_desktop").append("<option value=''>--select customer title--</option>");
                      if(data.MDG_Title == 2){
                        $("#customer_title_desktop").append("<option value='0001'>0001 - Person</option>");
                        $("#customer_title_desktop").append("<option value='0002' selected>0002 - Organization</option>");
                        $("#customer_title_desktop").append("<option value='0003'>0003 - Group</option>");
                      }else if(data.MDG_Title == 3){
                        $("#customer_title_desktop").append("<option value='0001'>0001 - Person</option>");
                        $("#customer_title_desktop").append("<option value='0002'>0002 - Organization</option>");
                        $("#customer_title_desktop").append("<option value='0003' selected>0003 - Group</option>");
                      }else{
                        $("#customer_title_desktop").append("<option value='0001' selected>0001 - Person</option>");
                        $("#customer_title_desktop").append("<option value='0002'>0002 - Organization</option>");
                        $("#customer_title_desktop").append("<option value='0003'>0003 - Group</option>");
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
                    }
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
      url:"<?php echo base_url();?>index.php/request/get_approval_customer/",
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
        <h3 style="margin-top:20px;padding:0px 25px"><span>Display Master Data Customer</span></h3>
        <div style="margin-top:20px;margin-bottom:50px;padding:0px 25px;">
          <div id="frmDTL">
            <div class="group-txt" style="width:100%;">
              <label style="width:100%;float:left;">(Customer) Request ID</label>
              <input type="text" style="background:#f9f9f9;width:30%;" name="customer_id_desktop" id="customer_id_desktop" readonly/>
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
