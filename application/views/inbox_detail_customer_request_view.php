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
		$("#tbl-product").hide();

		$("#vendor-tab").click(function(){
			$("#all-tab").css('background-color','#fff');
			$("#vendor-tab").css('background-color','#f1f1f1');
			$("#product-tab").css('background-color','#fff');
			$("#tbl-all").hide();
			$("#tbl-vendor").show();
			$("#tbl-product").hide();
		});

		$("#product-tab").click(function(){
			$("#all-tab").css('background-color','#fff');
			$("#vendor-tab").css('background-color','#fff');
			$("#product-tab").css('background-color','#f1f1f1');
			$("#tbl-all").hide();
			$("#tbl-vendor").hide();
			$("#tbl-product").show();
		});

		$("#all-tab").click(function(){
			$("#all-tab").css('background-color','#f1f1f1');
			$("#vendor-tab").css('background-color','#fff');
			$("#product-tab").css('background-color','#fff');
			$("#tbl-all").show();
			$("#tbl-vendor").hide();
			$("#tbl-product").hide();
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
				url:"<?php echo base_url();?>index.php/request/read_request/<?php echo $this->uri->segment(2);?>/<?php echo $this->uri->segment(7);?>",
				cache:false,
				type: "POST",
				dataType: 'json',
				success:function(result){
					$.ajax({
						url:"<?php echo base_url();?>index.php/request/get_thenew/",
						cache:false,
						type: "POST",
						dataType: 'json',
						success:function(result){
							$.each(result, function(i, data){
								$("#bell-desktop ul .newUpdate").remove();
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
				<div id="title-mail" style="margin-left:20px;float:left;"><h3><?php echo "Request Data Customer";?></h3></div>

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


				<div style="background-color:#f9f9f9;font-family:Helvetica,Arial,sans-serif;float: left;">
										<table style="margin:1% 5%;background-color:#fff;border-collapse:collapse;width:90%;border:none;">
											<tbody>
												<tr style="background-image:url(http://purbasari.com/assets/background-flat.jpg);background-size:cover;">
													<td style="width:100%;padding:0px;" colspan="2">
														<table style="width:100%;height:300px;margin:0;padding:0;background:rgba(0,0,0,0.3)">
															<tr style="background:transparent;border:0;">
																<td><span style="color:#fff;font-family:arial;font-size:12px;margin:0px;margin-left:20px;font-weight:normal;">&nbsp;</span></td>
																<td style="text-align:right"><h1 style="color:#fff;font-family:Andalus,Arial;font-size:32px;margin:0px;margin-right:20px;font-weight:normal;">#MDGApplication</h1>
																<span style="text-align:right;color:#fff;margin-right:20px;font-size:12px;">Master Data Utility Application for SAP ERP.</span></td>
															</tr>
														</table>
													</td>
												</tr>
												<tr>
													<td style="width:100%;font-family:calibri;padding:10px;border-bottom:1px solid #f9f9f9;border-top:1px solid #f9f9f9;padding-bottom:30px;padding-top:30px;" colspan="2" align="center">
														<table style="width:80%;">
															<tr style="border:0;">
																<td style="border:0;">
																	<div style="margin-left:10px;color:#999;">
																	<p>Hi, <?php echo $first.' '.$last;?>,</p>
																	<p>We have received approval form (Master Data Customer).<br/>Now you can look at the bottom for link form master data customer, Please visit here.</p>
																		<p>
																			Link (Approve):	<?php echo base_url().'index.php/request/approval_master_customer/'.$id_mdg.'/'.$id_acc;?>
																			<br/>
																		</p>
																	</div>
																</td>
															</tr>
														</table>
													</td>
												</tr>
												<tr>
													<td style="width:100%;font-family:arial;padding:20px;text-align:center;" colspan="2">
														<span style="color:#999;font-size:12px;">Email ini dibuat secara otomatis, mohon untuk tidak mengirimkan pesan balasan ke email ini.</span>
													</td>
												</tr>
												<tr style="border-collapse:collapse;background:#f1f1f1;margin:0;padding:0;">
													<td style="width:100%;padding:0px;" colspan="2">
														<table style="margin:0;">
															<tr style="border:0;background:#f1f1f1">
																<td style="width:5%;text-align:center;">
																	<img src="http://purbasari.com/assets/unnamed.png" style="padding:20px;"/>
																</td>
																<td style="width:95%;font-family:arial;">
																	<div style="color:#999;font-size:12px;padding-right:20px;line-height:150%;">Segala bentuk informasi seperti nomor kontak, alamat e-mail, atau password anda bersifat rahasia. Jangan menginformasikan data-data tersebut kepada siapa pun, termasuk kepada pihak yang mengatasnamakan Purbasari atau PT Gloria Origita Cosmetics.</div>
																</td>
															</tr>
														</table>
													</td>
												</tr>
												<tr style="border-collapse:collapse;background:#f9f9f9;margin:0;padding:0;">
													<td style="width:100%;">
														<table style="width:50%;margin:0 auto;">
															<tr style="text-align:center;background: transparent;border: 0;">
																<td style="width:95%;padding:0;font-family:arial;border-collapse:collapse;text-align:justify">
																	<div style="text-align:center;">
																		<img src="http://www.goc.co.id/assets/icon/logo_goc.png" style="padding-left:10px;padding-top:10px;padding-bottom:10px;" width="100"/>
																	</div>
																	<div style="text-align:center;">
																		<span style="color:#999;font-size:11px;">Jika Butuh Bantuan, Silahkan Hubungi Kami di <a href="http://purbasari.com/index.php/home/contact/">Sini</a>.</span>
																	</div>
																	<div style="margin-top:-2px;text-align:center;">
																		<span style="color:#999;font-size:11px;">2016 &copy; PT Gloria Origita Cosmetics</span>
																	</div>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</tbody>
											</table>
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
