	<style>
		#notice{
			display:none;
		}

		#RegisterHeader{
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
	</style>

	<script>
	$(function(){
		var $loading = $('#loadingDiv').hide();

		/*$.ajax({
			url:"<?php echo base_url();?>index.php/request/get_thenew/",
			cache:false,
			type: "POST",
			dataType: 'json',
			success:function(result){
				$("#tl_input").val('');
				$.each(result, function(i, data){
					$("#tl_combo option").remove();
					$.each(result, function(i, data){
						$("#tl_combo").append("<option value='"+data.ID_TL+"'>"+data.ID_TL+" - "+data.NAMA_TL+"</option>");
					});
				});
				$('#loadingDivTL').hide();
			}
		});*/

		$('#role').keypress(function(e){
				if(e.which == 13){//Enter key pressed
					var $loading = $('#loadingDiv').hide();
					$loading.show();
					$.ajax({
						url:"<?php echo base_url();?>index.php/request/get_login/",
						cache:false,
						data:{
							username:$('#username').val(),
							password:$('#password').val(),
							role:$('#role').val()
						},
						type: "POST",
						dataType: 'json',
						success:function(result){
							if(result.status == 'success'){
								window.location = '<?php echo base_url();?>index.php/request/get_List/';
							}else if(result.status == 'inactive'){
								$("#notice").css('display','flex');
								$(".span-message span").remove();
								$(".span-message").append('<span>Sorry, your account is not active..</span>');
								$("#notice").fadeIn().delay(1000).fadeOut();
							}else{
								$("#notice").css('display','flex');
								$(".span-message span").remove();
								$(".span-message").append('<span>Sorry, Your Username or Password is Invalid !</span>');
								$("#notice").fadeIn().delay(1000).fadeOut();
							}
							$loading.hide();
						}
					});
				}
		});

		$("#btnLogin").click(function(){
			var $loading = $('#loadingDiv').hide();
			$loading.show();
			$.ajax({
				url:"<?php echo base_url();?>index.php/request/get_login/",
				cache:false,
				data:{
					username:$('#username').val(),
					password:$('#password').val(),
					role:$('#role').val()
				},
				type: "POST",
				dataType: 'json',
				success:function(result){
					if(result.status == 'success'){
						window.location = '<?php echo base_url();?>index.php/request/get_List/';
					}else if(result.status == 'inactive'){
						$("#notice").css('display','flex');
						$(".span-message span").remove();
						$(".span-message").append('<span>Sorry, your account is not active..</span>');
						$("#notice").fadeIn().delay(1000).fadeOut();
					}else{
						$("#notice").css('display','flex');
						$(".span-message span").remove();
						$(".span-message").append('<span>Sorry, Your Username or Password is Invalid !</span>');
						$("#notice").fadeIn().delay(1000).fadeOut();
					}
					$loading.hide();
				}
			});
		});

		$("#btnSubmit").click(function(){
			var $loading = $('#loadingDiv').hide();
			$loading.show();
			$.ajax({
				url:"<?php echo base_url();?>index.php/request/get_forgot/",
				cache:false,
				data:{
					email:$('#email').val()
				},
				type: "POST",
				dataType: 'json',
				success:function(result){
					if(result.status == 'success'){
						$("#notice").css('display','flex');
						$(".span-message span").remove();
						$(".span-message").append('<span>Check your email, We send your privacy account.</span>');
						$("#notice").fadeIn().delay(1000).fadeOut();
					}else if(result.status == 'fail'){
						$("#notice").css('display','flex');
						$(".span-message span").remove();
						$(".span-message").append('<span>Sorry, The system can not send your data to your email.</span>');
						$("#notice").fadeIn().delay(1000).fadeOut();
					}else if(result.status == 'double'){
						$("#notice").css('display','flex');
						$(".span-message span").remove();
						$(".span-message").append('<span>Please call IT Division, your email is double account.</span>');
						$("#notice").fadeIn().delay(1000).fadeOut();
					}else if(result.status == 'notavailable'){
						$("#notice").css('display','flex');
						$(".span-message span").remove();
						$(".span-message").append('<span>Sorry, Your email is Invalid !</span>');
						$("#notice").fadeIn().delay(1000).fadeOut();
					}
					$loading.hide();
				}
			});
		});

		$("#btnRegist").click(function(){
			var $loading = $('#loadingDiv').hide();
			$loading.show();

			if($('#r_password').val() == $('#r_conf').val()){
				$.ajax({
					url:"<?php echo base_url();?>index.php/request/act_register/",
					cache:false,
					data:{
						first:$('#r_first').val(),
						last:$('#r_last').val(),
						username:$('#r_username').val(),
						password:$('#r_password').val(),
						email:$('#r_email').val()
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notice").css('display','flex');
							$(".span-message span").remove();
							$(".span-message").append('<span>Link activation send to your email, Please open your email and click the link.</span>');
							$("#notice").fadeIn().delay(1000).fadeOut();
							$('#r_first').val('');
							$('#r_last').val('');
							$('#r_username').val('');
							$('#r_email').val('');
							$('#r_password').val('');
							$('#r_conf').val('');
						}else if(result.status == 'error'){
							$("#notice").css('display','flex');
							$(".span-message span").remove();
							$(".span-message").append('<span>Link activation is failure to send, Please confirm to IT Div.</span>');
							$("#notice").fadeIn().delay(1000).fadeOut();
							$('#r_first').val('');
							$('#r_last').val('');
							$('#r_username').val('');
							$('#r_email').val('');
							$('#r_password').val('');
							$('#r_conf').val('');
						}else if(result.status == 'pass'){
							$("#notice").css('display','flex');
							$(".span-message span").remove();
							$(".span-message").append('<span>Your password is already used, Please change your password.</span>');
							$("#notice").fadeIn().delay(1000).fadeOut();
						}else if(result.status == 'mail'){
							$("#notice").css('display','flex');
							$(".span-message span").remove();
							$(".span-message").append('<span>Your email is already used, Please change your email.</span>');
							$("#notice").fadeIn().delay(1000).fadeOut();
						}else{
							$("#notice").css('display','flex');
							$(".span-message span").remove();
							$(".span-message").append('<span>Sorry, register process is failure.</span>');
							$("#notice").fadeIn().delay(1000).fadeOut();
						}
						$loading.hide();
					}
				});
			}else{
				$("#notice").css('display','flex');
				$(".span-message span").remove();
				$(".span-message").append('<span>Sorry, password column is not same with re-type password column.</span>');
				$("#notice").fadeIn().delay(1000).fadeOut();
				$loading.hide();
			}
		});

		$("#box-password").hide();
		$("#box-role").hide();
		$("#box-forgot").hide();
		$("#box-register").hide();

		$("#btnPassword").attr('disabled','disabled');
		$("#btnPassword").css('opacity','0.5');
		$("#btnRole").attr('disabled','disabled');
		$("#btnRole").css('opacity','0.5');
		$("#btnLogin").attr('disabled','disabled');
		$("#btnLogin").css('opacity','0.5');

		$("#btnBackUs").click(function(){
			$("#box-username").show();
			$("#box-register").hide();
		});

		$("#btnRegister").click(function(){
			$("#box-register").show();
			$("#box-username").hide();
			$("#box-forgot").hide();
		});

		$("#btnRegister2").click(function(){
			$("#box-register").show();
			$("#box-password").hide();
			$("#box-forgot").hide();
		});

		$("#btnRegister3").click(function(){
			$("#box-register").show();
			$("#box-role").hide();
			$("#box-forgot").hide();
		});

		$("#btnRegister4").click(function(){
			$("#box-register").show();
			$("#box-forget").hide();
			$("#box-forgot").hide();
		});

		$("#btnBackPassword").click(function(){
			$("#box-username").hide();
			$("#box-password").show();
			$("#box-role").hide();
		});

		$('#username').keypress(function(e){
        if(e.which == 13){//Enter key pressed
					$("#box-username").hide();
					$("#box-password").show();
					$("#box-role").hide();
        }
    });

		$("#btnBackUsername").click(function(){
			$("#box-username").show();
			$("#box-password").hide();
			$("#box-role").hide();
		});

		$("#username").keyup(function(){
			if($("#username").val() != ''){
				$("#btnPassword").removeAttr("disabled");
				$("#btnPassword").css('opacity','1');
			}else {
				$("#btnPassword").attr('disabled','disabled');
				$("#btnPassword").css('opacity','0.5');
			}
		});

		$("#password").keyup(function(){
			if($("#password").val() != ''){
				$("#btnRole").removeAttr("disabled");
				$("#btnRole").css('opacity','1');
			}else {
				$("#btnRole").attr('disabled','disabled');
				$("#btnRole").css('opacity','0.5');
			}
		});

		$('#password').keypress(function(e){
				if(e.which == 13){//Enter key pressed
					$("#box-username").hide();
					$("#box-password").hide();
					$("#box-role").show();
				}
		});

		$("#role").change(function(){
			if($("#role").val() != ''){
				$("#btnLogin").removeAttr("disabled");
				$("#btnLogin").css('opacity','1');
			}else {
				$("#btnLogin").attr('disabled','disabled');
				$("#btnLogin").css('opacity','0.5');
			}
		});

		$("#btnForgot").click(function(){
			$("#box-forgot").show();
			$("#box-username").hide();
			$("#box-password").hide();
		});

		$("#btnBackUsnm").click(function(){
			$("#box-forgot").hide();
			$("#box-username").show();
			$("#box-password").hide();
		});

		$("#btnForgot1").click(function(){
			$("#box-forgot").show();
			$("#box-username").hide();
			$("#box-password").hide();
		});

		$("#btnForgot2").click(function(){
			$("#box-forgot").show();
			$("#box-username").hide();
			$("#box-password").hide();
			$("#box-role").hide();
		});

		$("#btnPassword").click(function()
		{
			var user_name = $("#username").val();
			$("#usrnm span").remove();
			$("#usrnm").append('<span>'+user_name+'</span>');
			$("#usrnm1 span").remove();
			$("#usrnm1").append('<span>'+user_name+'</span>');
			$("#box-username").hide();
			$("#box-password").show();
		});

		$("#btnRole").click(function()
		{
			$("#box-password").hide();
			$("#box-role").show();
		});

		$("#btnLogin").click(function()
		{
			$("#box-register").hide();
			$("#box-login").show();
			$("#box-register").hide();
		});

		$("#clear1").click(function(){
			$("#username").val('');
			$("#password").val('');
		});

		$("#clear2").click(function(){
			$("#r_name").val('');
			$("#r_username").val('');
			$("#r_password").val('');
		});
	});
	</script>
	<body>
		<div class="container">
			<div class="bg-welcome">
				<div class="layout">
					<div class="box">
						<div id="box-username" style="float:left;width:100%;">
						<div>
							<h1 style="font-size:14px;">MDG Application</h1>
						</div>
						<h2>Sign In</h2>
						<p>to continue to request master data SAP.</p>
						<div style="margin:100px 0px;">
							<label style="width:100%;float:left;font-family:'Roboto-regular';font-size:13px;padding-bottom:5px;text-align:left;color:#4285f4;">Enter your user ID : </label>
							<input type="text" id="username" placeholder="Username" class="login-txt"/>
							<div>
								<a id="btnForgot" style="cursor:pointer;font-size:13px;color:blue;float:left;font-family:'Roboto-Regular'">Forgot ID?</a>
							</div>
						</div>

						<div style="margin-top:20px;">
							<a id="btnRegister" style="cursor:pointer;font-size:13px;color:blue;float:left;font-family:'Roboto-Regular'">Create Account</a>
							<button id="btnPassword" style="float:right;" class="btn right">Next</button>
						</div>
						</div>

						<div id="box-forgot" style="float:left;width:100%;">
						<div>
							<h1 style="font-size:14px;">MDG Application</h1>
						</div>
						<h2>Welcome</h2>
						<div class="ff">
							<img src="<?php echo base_url().'assets/img/sms.gif';?>"/>
						</div>
						<div style="margin:100px 0px;margin-top: 0px;">
							<label style="width:100%;float:left;font-family:'Roboto-regular';font-size:13px;padding-bottom:5px;text-align:left;color:#4285f4;">Enter your email account : </label>
							<input type="text" id="email" placeholder="email" class="login-txt"/>
						</div>
						<div style="margin-top:20px;">
							<a id="btnRegister4" style="cursor:pointer;font-size:13px;color:blue;float:left;font-family:'Roboto-Regular'">Create Account</a>
							<button id="btnSubmit" style="float:right;margin-left:5px;" class="btn right">Submit</button>
							<button id="btnBackUsnm" style="float:right;background-color:#fff;color:#555;border:0;box-shadow:none;" class="btn right">Back</button>
						</div>
						</div>

						<div id="box-register" style="float:left;width:100%;">
						<div>
							<h1 style="font-size:14px;">MDG Application</h1>
						</div>
						<h2>Create your MDG Account</h2>
						<span style="font-family:'Roboto-Regular';font-size:12px;">to continue to entry and approval master data SAP.</span>
						<div style="margin-top: 10px;">
							<label style="width:100%;float:left;font-family:'Roboto-regular';font-size:13px;padding-bottom:5px;text-align:left;color:#4285f4;">Enter your name : </label>
							<input type="text" id="r_first" style="width:45%;display:inline;" placeholder="First Name" class="login-txt"/>
							<input type="text" id="r_last" style="width:45%;display:inline;" placeholder="Last Name" class="login-txt"/>
						</div>
						<div style="margin-top: 10px;">
							<input type="text" id="r_email" placeholder="Email" class="login-txt"/>
						</div>
						<div style="margin-top: 10px;">
							<label style="width:100%;float:left;font-family:'Roboto-regular';font-size:13px;padding-bottom:5px;text-align:left;color:#4285f4;">Enter your username : </label>
							<input type="text" id="r_username" placeholder="Username" class="login-txt"/>
						</div>
						<div style="margin-top: 10px;">
							<label style="width:100%;float:left;font-family:'Roboto-regular';font-size:13px;padding-bottom:5px;text-align:left;color:#4285f4;">Enter your password : </label>
							<input type="password" id="r_password" placeholder="Password" class="login-txt"/>
						</div>
						<div style="margin-top: 10px;">
							<label style="width:100%;float:left;font-family:'Roboto-regular';font-size:13px;padding-bottom:5px;text-align:left;color:#4285f4;">Enter re-type password : </label>
							<input type="password" id="r_conf" placeholder="Confirm Password" class="login-txt"/>
						</div>
						<div style="margin-top:20px;">
							<button id="btnRegist" style="float:right;margin-left:5px;" class="btn right">Submit</button>
							<button id="btnBackUs" style="float:right;background-color:#fff;color:#555;border:0;box-shadow:none;" class="btn right">Back</button>
						</div>
						</div>

						<div id="box-password" style="float:left;width:100%;">
						<div>
							<h1 style="font-size:14px;">MDG Application</h1>
						</div>
						<h2>Welcome</h2>
						<div>
							<img src="<?php echo base_url().'assets/img/user.png';?>" style="width:25px;float:left;"/>
							<h6 id="usrnm" style="float:left;margin:0;padding:5px 20px;font-size:14px;font-weight:normal;font-family:'Roboto-Regular'"><span></span></h6>
						</div>
						<div style="margin:100px 0px;">
							<label style="width:100%;float:left;font-family:'Roboto-regular';font-size:13px;padding-bottom:5px;text-align:left;color:#4285f4;">Enter your password : </label>
							<input type="password" id="password" placeholder="Password" class="login-txt"/>
							<div>
								<a id="btnForgot1" style="cursor:pointer;font-size:13px;color:blue;float:left;font-family:'Roboto-Regular'">Forgot Password?</a>
							</div>
						</div>
						<div style="margin-top:20px;">
							<a id="btnRegister2" style="cursor:pointer;font-size:13px;color:blue;float:left;font-family:'Roboto-Regular'">Create Account</a>
							<button id="btnRole" style="float:right;margin-left:5px;" class="btn right">Next</button>
							<button id="btnBackUsername" style="float:right;background-color:#fff;color:#555;border:0;box-shadow:none;" class="btn right">Back</button>
						</div>
						</div>

						<div id="box-role" style="float:left;width:100%;">
						<div>
							<h1 style="font-size:14px;">MDG Application</h1>
						</div>
						<h2>Welcome</h2>
						<div>
							<img src="<?php echo base_url().'assets/img/user.png';?>" style="width:25px;float:left;"/>
							<h6 id="usrnm1" style="float:left;margin:0;padding:5px 20px;font-size:14px;font-weight:normal;font-family:'Roboto-Regular'"><span></span></h6>
						</div>
						<div style="margin:100px 0px;">
							<label style="width:100%;float:left;font-family:'Roboto-regular';font-size:13px;padding-bottom:5px;text-align:left;color:#4285f4;">Enter your role access : </label>
							<select id="role" name="role" class="login-txt">
								<option value="" disabled selected>- choose position -</option>
								<option value="1">Administrator</option>
								<option value="0">Uploader</option>
							</select>
							<div>
								<a id="btnForgot2" style="cursor:pointer;font-size:13px;color:blue;float:left;font-family:'Roboto-Regular'">Forgot Password?</a>
							</div>
						</div>
						<div style="margin-top:20px;">
							<a id="btnRegister3" style="cursor:pointer;font-size:13px;color:blue;float:left;font-family:'Roboto-Regular'">Create Account</a>
							<button id="btnLogin" style="float:right;" class="btn right">Login</button>
							<button id="btnBackPassword" style="float:right;background-color:#fff;color:#555;border:0;box-shadow:none;" class="btn right">Back</button>
						</div>
						</div>
				</div>
			</div>
		</div>
	</body>
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
	<div id="notice" style="font-family:'Roboto-regular';position:fixed;width:100%;height:100%;left:0;top:0;background:rgba(0,0,0,0.5);align-item:center;border-weight:bolder;">
		<div style="width:350px;height:175px;border:1px solid #fff;border-radius:3px;margin:auto;background:#fff;display:flex;align-item:center;">
			<div style="margin:auto;">
				<span class="Loader">
				  <div class="Loader-indicator" style="padding:30px;">
					<h4 style="font-family:'Roboto-medium';margin:0;margin-bottom:5px;">
					  <span>Message</span>
					</h4>
					<span class="span-message" style="font-size:13px;"><span></span></span>
				  </div>
				</span>
			  </div>
		</div>
	</div>
	<div id="RegisterHeader" style="font-family:'Roboto-regular';position:fixed;width:100%;height:100%;left:0;top:0;background:rgba(0,0,0,0.5);align-item:center;border-weight:bolder;">
		<div style="width:350px;height:175px;border:1px solid #fff;border-radius:3px;margin:auto;background:#fff;display:flex;align-item:center;">
			<div style="margin:auto;">
				<span class="Loader">
				  <div class="Loader-indicator" style="padding:20px;">
					<h4 style="font-family:'Roboto-medium';margin:0;margin-bottom:5px;">
					  <span>Message</span>
					</h4>
					<span>Your account was successfully created, please contact design staff for approval Account!</span>
				  </div>
				</span>
			  </div>
		</div>
	</div>


	<!--<script>
		$(function(){
			$("#create").click(function(){
				window.location = '<?php //echo base_url();?>index.php/request/get_List/';
			});
		});
	</script>-->
