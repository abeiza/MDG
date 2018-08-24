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

	#tbl-customer tbody .odd td{
		background:#fff;
		font-size:13.5px;
	}

	#tbl-customer tbody .even td{
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
		var elem = $(id).attr("class")
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

		$('#datepicker').datepicker('setDate', 'today');
		$(".container-mobile-search").hide();
		$(".container-mobile-choose").hide();
		$(".updateDetail").attr("disabled", "disabled");
		$(".updateDetail").css("opacity","0.5");
		$("#all-tab").css('background-color','#f1f1f1');

		$("#tbl-vendor").hide();
		$("#tbl-customer").hide();

		$("#vendor-tab").click(function(){
			$("#all-tab").css('background-color','#fff');
			$("#vendor-tab").css('background-color','#f1f1f1');
			$("#customer-tab").css('background-color','#fff');
			$("#tbl-all").hide();
			$("#tbl-vendor").show();
			$("#tbl-customer").hide();
		});

		$("#customer-tab").click(function(){
			$("#all-tab").css('background-color','#fff');
			$("#vendor-tab").css('background-color','#fff');
			$("#customer-tab").css('background-color','#f1f1f1');
			$("#tbl-all").hide();
			$("#tbl-vendor").hide();
			$("#tbl-customer").show();
		});

		$("#all-tab").click(function(){
			$("#all-tab").css('background-color','#f1f1f1');
			$("#vendor-tab").css('background-color','#fff');
			$("#customer-tab").css('background-color','#fff');
			$("#tbl-all").show();
			$("#tbl-vendor").hide();
			$("#tbl-customer").hide();
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
			$.ajax({
				url:"<?php echo base_url();?>index.php/request/get_list_draft/",
				cache:false,
				type: "POST",
				dataType: 'json',
				success:function(result){
					$("#tbl-all tbody tr").remove();
					$("#tbl-all tbody").append("<tr><td>Request ID (Vendor)</td><td>Vendor Name</td><td>Vendor Type</td><td>Posted Date</td><td>Created By</td></tr>");
					$.each(result, function(i, data){
						//$("#tbl-all tbody").append("<tr><td>Request ID (Vendor)</td><td>Vendor Name</td><td>Vendor Type</td><td>Posted Date</td><td>Created By</td></tr>");
						$("#tbl-all tbody").append("<tr class='"+data.MDG_ID+"' onclick='linkDisplayDraft(this)' style='Font-size:13px;font-family:Roboto-Regular'><td>"+data.MDG_ID+"</td><td>"+data.name+"</td><td>"+data.type_id+" - "+data.typename+"</td><td>"+data.effdate+"</td><td>"+data.account+"-"+data.first+" "+data.last+"</td></tr>");
					});
				}
			});
		});

		$(function(){
			$.ajax({
				url:"<?php echo base_url();?>index.php/request/get_list_draft_vendor/",
				cache:false,
				type: "POST",
				dataType: 'json',
				success:function(result){
					$("#tbl-vendor tbody tr").remove();
					$("#tbl-vendor tbody").append("<tr><td>Request ID (Vendor)</td><td>Vendor Name</td><td>Vendor Type</td><td>Posted Date</td><td>Created By</td></tr>");
					$.each(result, function(i, data){
						//$("#tbl-all tbody").append("<tr><td>Request ID (Vendor)</td><td>Vendor Name</td><td>Vendor Type</td><td>Posted Date</td><td>Created By</td></tr>");
						$("#tbl-vendor tbody").append("<tr class='"+data.MDG_Vendor_ID+"' onclick='linkDisplayDraft(this)' style='Font-size:13px;font-family:Roboto-Regular'><td>"+data.MDG_Vendor_ID+"</td><td>"+data.MDG_VendorName+"</td><td>"+data.MDG_VendorType_ID+" - "+data.VendorType_Name+"</td><td>"+data.effdate+"</td><td>"+data.Account_ID+"-"+data.Account_First_Name+" "+data.Account_Last_Name+"</td></tr>");
					});
				}
			});
		});

		$(function(){
			$.ajax({
				url:"<?php echo base_url();?>index.php/request/get_list_draft_customer/",
				cache:false,
				type: "POST",
				dataType: 'json',
				success:function(result){
					$("#tbl-customer tbody tr").remove();
					$("#tbl-customer tbody").append("<tr><td>Request ID (Customer)</td><td>Customer Name</td><td>Customer Type</td><td>Posted Date</td><td>Created By</td></tr>");
					$.each(result, function(i, data){
						//$("#tbl-all tbody").append("<tr><td>Request ID (Vendor)</td><td>Vendor Name</td><td>Vendor Type</td><td>Posted Date</td><td>Created By</td></tr>");
						$("#tbl-customer tbody").append("<tr class='"+data.MDG_Customer_ID+"' onclick='linkDisplayDraft(this)' style='Font-size:13px;font-family:Roboto-Regular'><td>"+data.MDG_Customer_ID+"</td><td>"+data.MDG_CustomerName+"</td><td>"+data.MDG_CustomerType_ID+" - "+data.CustomerType_Name+"</td><td>"+data.effdate+"</td><td>"+data.Account_ID+"-"+data.Account_First_Name+" "+data.Account_Last_Name+"</td></tr>");
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
								<li id="menu_m_ms_customer" onclick="">Master Customer</li>
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
				<div style="float: right;margin-right: 65px;"><h3>Draft List</h3></div>

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
			<div class="list-box">
			<div id="tab-table" style="float:left;width:100%;margin-top: 20px;">
				<a class="tab" id="all-tab">All</a>
				<a class="tab" id="vendor-tab">Master Vendor</a>
				<a class="tab" id="customer-tab">Master Customer</a>
			</div>

			<table id="tbl-all">
				<tbody>
					<tr><td colspan='5' style="text-align:center;padding:20px 0;font-family:'Roboto-regular';font-size:13.5px;">Sorry, Request Data's not available</td></tr>
				</tbody>
			</table>

			<table id="tbl-vendor">
				<tbody>
					<tr><td colspan='5' style="text-align:center;padding:20px 0;font-family:'Roboto-regular';font-size:13.5px;">Sorry, Request Data's not available</td></tr>
				</tbody>
			</table>

			<table id="tbl-customer">
				<tbody>
					<tr><td colspan='5' style="text-align:center;padding:20px 0;font-family:'Roboto-regular';font-size:13.5px;">Sorry, Request Data's not available</td></tr>
				</tbody>
			</table>
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

	<div id="FailEditHeader" style="font-family:'Roboto-regular';position:fixed;width:100%;height:100%;left:0;top:0;background:rgba(0,0,0,0.5);align-item:center;border-weight:bolder;">
		<div style="width:350px;height:175px;border:1px solid #fff;border-radius:3px;margin:auto;background:#fff;display:flex;align-item:center;">
			<div style="margin:auto;">
				<span class="Loader">
					<div class="Loader-indicator" >
					<h4 style="font-family:'Roboto-medium';margin:0;margin-bottom:5px;">
						<span>Message</span>
					</h4>
					<span>Sorry, Create Data was unsuccessfully !</span>
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
