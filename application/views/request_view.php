	<style>
		#confirm{
			display:none;
		}
		.Loader-indicator.fade-enter,
		.Loader-content.fade-enter {
		  opacity: 0;
		}

		#ul-app{
			padding:0;
			margin:0;
		}

		#ul-app li:active{
			background-color:#f1f1f1;
		}

		#ul-app li{
			background-color: transparent;
			border:1px solid #1a73e8;
			color:#1a73e8;
			font-family: 'Roboto-regular';
			font-size:13px;
			padding:10px 15px;
			border-radius:3px;
			margin-bottom:5px;
			list-style: none;
			padding-left: 40px;
			cursor:pointer;
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

		function deleteMapping(id){
			var elem = $(id).attr("class")
			$.ajax({
				url:"<?php echo base_url();?>index.php/request/deleteMapping/",
				data:{
					id:'<?php echo $this->session->userdata('account_id');?>',
					pa:elem,
				},
				cache:false,
				type: "POST",
				dataType: 'json',
				success:function(result){
						if(result.status == 'success'){
							$.ajax({
								url:"<?php echo base_url();?>index.php/request/get_approver_list/",
								data:{
									id:'<?php echo $this->session->userdata('account_id');?>',
									nm:$("#name_app").val(),
								},
								cache:false,
								type: "POST",
								dataType: 'json',
								success:function(result){
									$("#ul-app img").remove();
									$("#ul-app li").remove();

									$.each(result, function(i, data){
										$("#ul-app").append("<li class='"+data.Mapping_approval_person+"' onclick='deleteMapping(this)'>"+data.Account_First_Name+" "+data.Account_Last_Name+"<br/><span style='font-size:11px;'>"+data.Position_Name+" ("+data.Department_Name+")<span></li><img src='<?php echo base_url();?>assets/img/trash.png' style='width:20px;position: absolute;margin-top: -40px;margin-left: 15px;'/>");
									});
								}
							});
		        }else{
		          $(".span-message span").remove();
		          $(".span-message").append('<span>Sorry, delete approver was failure</span>');
		          $("#noticeCnt").fadeIn().delay(3000).fadeOut();
		        }
		        $load_id.hide();

				}
			});
		}
	</script>
	<script>
		$(function(){
			$("#datepicker").datepicker({
			  changeMonth: true,
			  changeYear: true,
			  dateFormat: 'yy-mm-dd'
			});

			$("#EntryProfile").hide();
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

			$(function(){
	      $.ajax({
	        url:"<?php echo base_url();?>index.php/request/check_account_mapping/<?php echo $this->session->userdata('account_id');?>",
	        cache:false,
	        type: "POST",
	        dataType: 'json',
	        success:function(result){
	          if(result.complete == 'sip'){
							$("#EntryProfile").slideUp();
						}else if(result.complete == 'not'){
							$.ajax({
				        url:"<?php echo base_url();?>index.php/request/get_data_account_active/<?php echo $this->session->userdata('account_id');?>",
				        cache:false,
				        type: "POST",
				        dataType: 'json',
				        success:function(result){
				          $.each(result, function(i, data){
										$("#first_name").val(data.Account_First_Name);
										$("#last_name").val(data.Account_Last_Name);
										$("#email").val(data.Account_Email);
										$("#phone").val(data.Account_Phone);
									});
								}
							});
							$("#EntryProfile").slideDown();
						}
					}
				});
			});

			$(function(){
	      $.ajax({
	        url:"<?php echo base_url();?>index.php/request/get_dept/",
	        cache:false,
	        type: "POST",
	        dataType: 'json',
	        success:function(result){
						$("#department_self option").remove();
						$("#department_self").append("<option value='' selected disabled> --select department-- </option>");
						$.each(result, function(i, data){
							$("#department_self").append("<option value='"+data.Department_ID+"'>"+data.Department_ID+" - "+data.Department_Name+"</option>");
						});
					}
				});
			});


			$("#department_self").change(function(){
				$.ajax({
	        url:"<?php echo base_url();?>index.php/request/get_pstt/",
					data:{
						dp:$("#department_self").val(),
					},
	        cache:false,
	        type: "POST",
	        dataType: 'json',
	        success:function(result){
						$("#position_self option").remove();
						$("#position_self").append("<option value='' selected disabled> --select position-- </option>");
						$.each(result, function(i, data){
							$("#position_self").append("<option value='"+data.Position_ID+"'>"+data.Position_ID+" - "+data.Position_Name+"</option>");
						});
					}
				});
			});

			$(function(){
	      $.ajax({
	        url:"<?php echo base_url();?>index.php/request/get_dept/",
	        cache:false,
	        type: "POST",
	        dataType: 'json',
	        success:function(result){
						$("#department_app option").remove();
						$("#department_app").append("<option value='' selected disabled> --select department-- </option>");
						$.each(result, function(i, data){
							$("#department_app").append("<option value='"+data.Department_ID+"'>"+data.Department_ID+" - "+data.Department_Name+"</option>");
						});
					}
				});
			});


			$("#department_app").change(function(){
				$.ajax({
	        url:"<?php echo base_url();?>index.php/request/get_pstt/",
					data:{
						dp:$("#department_app").val(),
					},
	        cache:false,
	        type: "POST",
	        dataType: 'json',
	        success:function(result){
						$("#position_app option").remove();
						$("#position_app").append("<option value='' selected disabled> --select position-- </option>");
						$.each(result, function(i, data){
							$("#position_app").append("<option value='"+data.Position_ID+"'>"+data.Position_ID+" - "+data.Position_Name+"</option>");
						});
					}
				});
			});

			$("#position_app").change(function(){
				$.ajax({
	        url:"<?php echo base_url();?>index.php/request/get_apprv/",
					data:{
						dp:$("#department_app").val(),
						ps:$("#position_app").val(),
					},
	        cache:false,
	        type: "POST",
	        dataType: 'json',
	        success:function(result){
						$("#name_app option").remove();
						$("#name_app").append("<option value='' selected disabled> --select approver-- </option>");
						$.each(result, function(i, data){
							$("#name_app").append("<option value='"+data.Account_ID+"'>"+data.Account_ID+" - "+data.Account_First_Name+" "+data.Account_Last_Name+"</option>");
						});
					}
				});
			});

			$('#datepicker').datepicker('setDate', 'today');
			$(".container-mobile-search").hide();
			$(".container-mobile-choose").hide();
			$(".updateDetail").attr("disabled", "disabled");
			$(".updateDetail").css("opacity","0.5");
			$("#all-tab").css('background-color','#f1f1f1');

			$("#tablist-position").hide();
			$("#tablist-approvalperson").hide();

			$("#position-tab").click(function(){
				$("#profile-tab").css('background-color','#fff');
				$("#position-tab").css('background-color','#f1f1f1');
				$("#approvalperson-tab").css('background-color','#fff');
				$("#tablist-profile").hide();
				$("#tablist-position").show();
				$("#tablist-approvalperson").hide();
			});

			$("#approvalperson-tab").click(function(){
				$("#profile-tab").css('background-color','#fff');
				$("#position-tab").css('background-color','#fff');
				$("#approvalperson-tab").css('background-color','#f1f1f1');
				$("#tablist-profile").hide();
				$("#tablist-position").hide();
				$("#tablist-approvalperson").show();
			});

			$("#profile-tab").click(function(){
				$("#profile-tab").css('background-color','#f1f1f1');
				$("#position-tab").css('background-color','#fff');
				$("#approvalperson-tab").css('background-color','#fff');
				$("#tablist-profile").show();
				$("#tablist-position").hide();
				$("#tablist-approvalperson").hide();
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

			$.ajax({
				url:"<?php echo base_url();?>index.php/request/get_approver_list/",
				data:{
					id:'<?php echo $this->session->userdata('account_id');?>',
					nm:$("#name_app").val(),
				},
				cache:false,
				type: "POST",
				dataType: 'json',
				success:function(result){
					$("#ul-app img").remove();
					$("#ul-app li").remove();

					$.each(result, function(i, data){
						$("#ul-app").append("<li class='"+data.Mapping_approval_person+"' onclick='deleteMapping(this)'>"+data.Account_First_Name+" "+data.Account_Last_Name+"<br/><span style='font-size:11px;'>"+data.Position_Name+" ("+data.Department_Name+")<span></li><img src='<?php echo base_url();?>assets/img/trash.png' style='width:20px;position: absolute;margin-top: -40px;margin-left: 15px;'/>");
					});
				}
			});
		});
	</script>
	<script>
		function get_submit(){
			var $load_id = $('#loadingDiv').hide();
			$.ajax({
				url:"<?php echo base_url();?>index.php/request/set_profile/",
				data:{
					id:'<?php echo $this->session->userdata('account_id');?>',
					fs:$("#first_name").val(),
					ls:$("#last_name").val(),
					em:$("#email").val(),
					ph:$("#phone").val(),
					dp:$("#department_self").val(),
					ps:$("#position_self").val(),
					nm:$("#name_app").val(),
				},
				cache:false,
				type: "POST",
				dataType: 'json',
				success:function(result){
						if(result.status == 'success'){
		          $(".span-message span").remove();
		          $(".span-message").append('<span>Update account profile was successful . .</span>');
		          $("#noticeCnt").fadeIn().delay(3000).fadeOut();
		          $("#vendor_id_desktop").val(result.id);

							$("#EntryProfile").slideUp();
		        }else{
		          $(".span-message span").remove();
		          $(".span-message").append('<span>Sorry, Update account profile was failure</span>');
		          $("#noticeCnt").fadeIn().delay(3000).fadeOut();
		        }
		        $load_id.hide();

				}
			});
		}

		function get_added(){
			var $load_id = $('#loadingDiv').hide();
			$.ajax({
				url:"<?php echo base_url();?>index.php/request/set_mapping/",
				data:{
					id:'<?php echo $this->session->userdata('account_id');?>',
					nm:$("#name_app").val(),
				},
				cache:false,
				type: "POST",
				dataType: 'json',
				success:function(result){
						if(result.status == 'success'){
							$.ajax({
								url:"<?php echo base_url();?>index.php/request/get_approver_list/",
								data:{
									id:'<?php echo $this->session->userdata('account_id');?>',
									nm:$("#name_app").val(),
								},
								cache:false,
								type: "POST",
								dataType: 'json',
								success:function(result){
									$("#ul-app li").remove();
									$("#ul-app img").remove();
									$.each(result, function(i, data){
										$("#ul-app").append("<li class='"+data.Mapping_approval_person+"' onclick='deleteMapping(this)'>"+data.Account_First_Name+" "+data.Account_Last_Name+"<br/><span style='font-size:11px;'>"+data.Position_Name+" ("+data.Department_Name+")<span></li><img src='<?php echo base_url();?>assets/img/trash.png' style='width:20px;position: absolute;margin-top: -40px;margin-left: 15px;'/>");
									});
								}
							});
						}else{
							$(".span-message span").remove();
							$(".span-message").append('<span>Sorry, Update approver was failure</span>');
							$("#noticeCnt").fadeIn().delay(3000).fadeOut();
						}
						$load_id.hide();

				}
			});
		}

		function getCreateForm(){
			$(".menu-create").toggle();
		}

		function blockSpecial(event){
	    var even = event.which || event.keyCode;
	    if ((even > 32 && even < 48) || (even > 57 && even < 65) || (even > 90 && even < 97))
	    event.preventDefault();
	  }

	  function blockAlphabeth(event){
	    var even = event.which || event.keyCode;
	    if ((even > 32 && even < 48) || (even > 57 && even < 65) || (even > 90 && even < 97) || (even > 65 && even < 123))
	      event.preventDefault();
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
									<li id="menu_m_draft" onclick="">Draft</li>
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
						<button id="refresh-btn" onclick="listDetail();"></button>
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
					<ul>
						<li>
								<a>
									<div id="list-mobile-left"><div style="color:#d14836;padding:20px;font-family:'Roboto-Regular'">EA</div></div>
									<div id="list-mobile-right">
										<h2 style="margin:0;padding:0;">Mailer.GOC</h2>
										<h5 style="font-size:11px;margin:0;padding:0;">Official Website Purbasari | From ...</h5>
										<p style="margin:0;padding:0;">www.goc.co.id Official Website PT Gloria...</p>
									</div>
								</a>
						</li>
						<li>
								<a>
									<div id="list-mobile-left"><div style="color:#d14836;padding:20px;font-family:'Roboto-Regular'">EA</div></div>
									<div id="list-mobile-right">
										<h2 style="margin:0;padding:0;">Mailer.GOC</h2>
										<h5 style="font-size:11px;margin:0;padding:0;">Official Website Purbasari | From ...</h5>
										<p style="margin:0;padding:0;">www.goc.co.id Official Website PT Gloria...</p>
									</div>
								</a>
						</li>
						<li>
								<a>
									<div id="list-mobile-left"><div style="color:#d14836;padding:20px;font-family:'Roboto-Regular'">EA</div></div>
									<div id="list-mobile-right">
										<h2 style="margin:0;padding:0;">Mailer.GOC</h2>
										<h5 style="font-size:11px;margin:0;padding:0;">Official Website Purbasari | From ...</h5>
										<p style="margin:0;padding:0;">www.goc.co.id Official Website PT Gloria...</p>
									</div>
								</a>
						</li>
						<li>
								<a>
									<div id="list-mobile-left"><div style="color:#d14836;padding:20px;font-family:'Roboto-Regular'">EA</div></div>
									<div id="list-mobile-right">
										<h2 style="margin:0;padding:0;">Mailer.GOC</h2>
										<h5 style="font-size:11px;margin:0;padding:0;">Official Website Purbasari | From ...</h5>
										<p style="margin:0;padding:0;">www.goc.co.id Official Website PT Gloria...</p>
									</div>
								</a>
						</li>
						<li>
								<a>
									<div id="list-mobile-left"><div style="color:#d14836;padding:20px;font-family:'Roboto-Regular'">EA</div></div>
									<div id="list-mobile-right">
										<h2 style="margin:0;padding:0;">Mailer.GOC</h2>
										<h5 style="font-size:11px;margin:0;padding:0;">Official Website Purbasari | From ...</h5>
										<p style="margin:0;padding:0;">www.goc.co.id Official Website PT Gloria...</p>
									</div>
								</a>
						</li>
						<li>
								<a>
									<div id="list-mobile-left"><div style="color:#d14836;padding:20px;font-family:'Roboto-Regular'">EA</div></div>
									<div id="list-mobile-right">
										<h2 style="margin:0;padding:0;">Mailer.GOC</h2>
										<h5 style="font-size:11px;margin:0;padding:0;">Official Website Purbasari | From ...</h5>
										<p style="margin:0;padding:0;">www.goc.co.id Official Website PT Gloria...</p>
									</div>
								</a>
						</li>
						<li>
								<a>
									<div id="list-mobile-left"><div style="color:#d14836;padding:20px;font-family:'Roboto-Regular'">EA</div></div>
									<div id="list-mobile-right">
										<h2 style="margin:0;padding:0;">Mailer.GOC</h2>
										<h5 style="font-size:11px;margin:0;padding:0;">Official Website Purbasari | From ...</h5>
										<p style="margin:0;padding:0;">www.goc.co.id Official Website PT Gloria...</p>
									</div>
								</a>
						</li>
						<li>
								<a>
									<div id="list-mobile-left"><div style="color:#d14836;padding:20px;font-family:'Roboto-Regular'">EA</div></div>
									<div id="list-mobile-right">
										<h2 style="margin:0;padding:0;">Mailer.GOC</h2>
										<h5 style="font-size:11px;margin:0;padding:0;">Official Website Purbasari | From ...</h5>
										<p style="margin:0;padding:0;">www.goc.co.id Official Website PT Gloria...</p>
									</div>
								</a>
						</li>
						<li>
								<a>
									<div id="list-mobile-left"><div style="color:#d14836;padding:20px;font-family:'Roboto-Regular'">EA</div></div>
									<div id="list-mobile-right">
										<h2 style="margin:0;padding:0;">Mailer.GOC</h2>
										<h5 style="font-size:11px;margin:0;padding:0;">Official Website Purbasari | From ...</h5>
										<p style="margin:0;padding:0;">www.goc.co.id Official Website PT Gloria...</p>
									</div>
								</a>
						</li>
						<li>
								<a>
									<div id="list-mobile-left"><div style="color:#d14836;padding:20px;font-family:'Roboto-Regular'">EA</div></div>
									<div id="list-mobile-right">
										<h2 style="margin:0;padding:0;">Mailer.GOC</h2>
										<h5 style="font-size:11px;margin:0;padding:0;">Official Website Purbasari | From ...</h5>
										<p style="margin:0;padding:0;">www.goc.co.id Official Website PT Gloria...</p>
									</div>
								</a>
						</li>

					</ul>
				</div>
				<style>
					.dash-1 .part-1{
						display: inline-block;
						width:29%;
						padding:20px;
						float:left;
					}

					.dash-1 .part-1 .part-2{
						border-bottom:1px dashed #f2f3f8;
						padding:10px 0px;
					}

					.dash-1 .part-1 h3{
						font-weight: bold;
						font-size:16px;
						font-family: 'Roboto-Regular';
						color:#555;
					}

					.dash-1 .part-1 p{
						padding:0;
						margin:5px 0px;
						font-size:13px;
						color:#999;
					}

					.akh{
						border:0px !important;
					}
				</style>
				<div class="list-box" style="background-color:#f2f3f8;">
					<!--<div style="padding:30px;">
						<div class="dash-1" style="background-color:#fff;width:100%;float:left;box-shadow:0px 1px 15px 1px rgba(69,65,78,0.08);">
							<div class="part-1" style="border-right:1px solid #f2f3f8">
								<div class="part-2" style="width:100%;float:left;">
									<div style="width:50%;float:left;">
										<h3>Master Customer</h3>
										<p>Awerage Weekly Profit</p>
									</div>
									<div style="width:50%;float:left;text-align:right">
										<h3 style="color:#d14836 !important;font-size:20px;margin-top:7px;font-family:'Roboto-Thin'">130</h3>
									</div>
								</div>
								<div class="part-2" style="width:100%;float:left;">
									<div style="width:50%;float:left;">
										<h3>Master Vendor</h3>
										<p>Awerage Weekly Profit</p>
									</div>
									<div style="width:50%;float:left;text-align:right">
										<h3 style="color:#d14836 !important;font-size:20px;margin-top:7px;font-family:'Roboto-Thin'">250</h3>
									</div>
								</div>
								<div class="part-2" style="width:100%;float:left;" class="akh">
									<div style="width:50%;float:left;">
										<h3>Master Material</h3>
										<p>Awerage Weekly Profit</p>
									</div>
									<div style="width:50%;float:left;text-align:right">
										<h3 style="color:#d14836 !important;font-size:20px;margin-top:7px;font-family:'Roboto-Thin'">300</h3>
									</div>
								</div>
							</div>
							<div class="part-1" style="border-right:1px solid #f2f3f8">b</div>
							<div class="part-1">c</div>
						</div>
					</div>
				--></div>
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

		<div id="EntryProfile" style="width:100%;height:100%;position:fixed;top:0;left:0;display:flex;align-items:center;background:rgba(0,0,0,0.1)">
			<div class="wild-card" style="width:90%;background-color:#fff;border:1px solid #f1f1f1;margin:auto;-webkit-box-shadow: 0px 2px 19px -6px rgba(85,85,85,1);-moz-box-shadow: 0px 2px 19px -6px rgba(85,85,85,1);box-shadow: 0px 2px 19px -6px rgba(85,85,85,1);">
				<div style="float:left;width:100%;">
					<h2 style="padding:15px 20px;color: #1a73e8;font-family: 'Roboto-Thin';float: left;font-size:18px;">Complete the profile</h2>
				</div>
				<div style="float: left;padding: 20px;padding-top: 0px;">
					<div style="width:100%;border-top:1px solid #f1f1f1;margin-top:10px;float:left;"></div>

					<div id="tab-table" style="float:left;width:100%;margin-top: 20px;margin-bottom:20px;">
						<a class="tab" id="profile-tab">Profile</a>
						<a class="tab" id="position-tab">Position</a>
						<a class="tab" id="approvalperson-tab">Approver</a>
					</div>

					<div id="tablist-profile">
						<h4>Profile Account</h4>
						<div class="group-txt" style="width:45%;margin-right:10px;">
							<label>First Name</label>
							<span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 40 char)</span>
							<input type="text" name="first_name" onkeypress="blockSpecial(event);" id="first_name" maxlength="40"/>
						</div>
						<div class="group-txt" style="width:45%;margin-right:10px;">
							<label>Last Name</label>
							<span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 40 char)</span>
							<input type="text" name="last_name" onkeypress="blockSpecial(event);" id="last_name" maxlength="40"/>
						</div>
						<div class="group-txt" style="width:45%;margin-right:10px;">
							<label>Email</label>
							<span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 20 char)</span>
							<input type="text" name="email" id="email" maxlength="20"/>
						</div>
						<div class="group-txt" style="width:45%;margin-right:10px;">
							<label>Phone</label>
							<span style="font-size:11px;font-family:'roboto-regular';color:red">(Max 20 char)</span>
							<input type="text" name="phone" onkeypress="blockAlphabeth(event);" id="phone" maxlength="20"/>
						</div>
					</div>

					<div id="tablist-position">
						<h4>Position</h4>
						<div class="group-txt" style="width:45%;margin-right:10px;">
							<label>Department *</label>
							<select name="department_self" id="department_self">
								<option value=""> -- select department -- </option>
							</select>
						</div>
						<div class="group-txt" style="width:45%;margin-right:10px;">
							<label>Position *</label>
							<select name="position_self" id="position_self">
								<option value=""> -- select position -- </option>
							</select>
						</div>
					</div>

					<div id="tablist-approvalperson">
						<h4>Approver</h4>
						<div style="width:75%;float:left;">
							<div class="group-txt" style="width:45%;margin-right:10px;">
								<label>Department *</label>
								<select name="department_app" id="department_app">
									<option value=""> -- select department -- </option>
								</select>
							</div>
							<div class="group-txt" style="width:45%;margin-right:10px;">
								<label>Position *</label>
								<select name="position_app" id="position_app">
									<option value=""> -- select position -- </option>
								</select>
							</div>
							<div style="width:100%;border-top:1px solid #f1f1f1;margin-top:10px;float:left;"></div>
							<div class="group-txt" style="width:45%;margin-right:10px;">
								<label>Approver *</label>
								<select name="name_app" id="name_app">
									<option value=""> -- select approver -- </option>
								</select>
							</div>
							<div style="width:30%;float:left;margin-top:20px;">
								<button id="add-btn" onclick="get_added();"><span style="color:#fff;font-size:12px;">Add</span></button>
							</div>
						</div>
						<div style="width:25%;float:right;margin-top: -90px;">
							<ul id="ul-app"></ul>
						</div>
					</div>

					<div style="width:100%;float:left;margin-top:10px;">
						<button id="save-btn" onclick="get_submit();"></button>
					</div>
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
