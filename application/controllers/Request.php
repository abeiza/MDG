<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');

	class Request extends CI_Controller{
		function __construct(){
			parent::__construct();
			date_default_timezone_set('Asia/Jakarta');
		}

		//------------------------------------------------------LOGIN ACCESS ACT --------------------------------------------------------------------------//

		function index(){
				$cek_status = $this->session->userdata('success_data');
				if(!$cek_status){
					$this->load->view('top_view');
					$this->load->view('welcome_view');
					$this->load->view('bottom_view');
				}else{
					?>
					<script>
						window.location.href = '<?php echo base_url();?>index.php/request/get_List/';
					</script>
					<?php
				}
		}

		function get_login(){
			date_default_timezone_set('Asia/Jakarta');
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$role = $this->input->post('role');

			$result = $this->model_app->login_data($password,$username,$role);
			if($result == 'success'){
				$data = array(
					'status' => 'success'
				);
				echo json_encode($data);
			}else if($result == 'inactive'){
				$data = array(
					'status' => 'inactive'
				);
				echo json_encode($data);
			}else if($result == 'invalid'){
				$data = array(
					'status' => 'invalid'
				);
				echo json_encode($data);
			}
		}

		function check_account_mapping($id){
			$id = $this->uri->segment(3);

			$query = $this->db->query("select * from Ms_Account where (SO_ID is null or SO_ID ='') and Account_ID = '".$id."'");
			if($query->num_rows() == 0){
				$data = array(
					'complete' => 'sip'
				);

				echo json_encode($data);
			}else{
				$data = array(
					'complete' => 'not'
				);

				echo json_encode($data);
			}
		}

		function get_data_account_active($id){
			$id = $this->uri->segment(3);

			$query = $this->db->query("select * from Ms_Account where Account_ID = '".$id."'");
			foreach($query->result() as $ac){
				$data[] = $ac;
			}
			echo json_encode($data);
		}

		function get_dept(){
			$query = $this->db->query("select distinct o.Department_ID, d.Department_Name from Ms_Structure_Organization as o inner join Ms_Department as d on o.Department_ID = d.Department_ID order by o.Department_ID");
			foreach($query->result() as $dp){
				$data[] = $dp;
			}
			echo json_encode($data);
		}

		function get_pstt(){
			$dp = $this->input->post('dp');

			$query = $this->db->query("select distinct o.Position_ID, p.Position_Name from Ms_Structure_Organization as o inner join Ms_Position as p on o.Position_ID = p.Position_ID order by o.Position_ID");
			foreach($query->result() as $ps){
				$data[] = $ps;
			}
			echo json_encode($data);
		}

		function get_apprv(){
			$dp = $this->input->post('dp');
			$ps = $this->input->post('ps');

			$query = $this->db->query("select Account_ID, Account_First_Name, Account_Last_Name from Ms_Account as a inner join Ms_Structure_Organization as o on a.SO_ID = o.SO_ID where Department_ID = '".$dp."' and Position_ID = '".$ps."' order by Account_ID");
			foreach($query->result() as $ps){
				$data[] = $ps;
			}
			echo json_encode($data);
		}

		function set_mapping(){
			date_default_timezone_set('Asia/Jakarta');
			$id = $this->input->post('id');
			$nm = $this->input->post('nm');
			$data_map['Account_ID'] = $id;
			$data_map['Mapping_approval_person'] = $nm;
			$data_map['Mapping_CreateDate'] = date('Y-m-d H:i:s');
			$data_map['Mapping_Status'] = '1';

			$cek_mapping = $this->db->query("select * from Ms_Mapping where Account_ID = '".$id."' and Mapping_approval_person = '".$nm."'");
			if($cek_mapping->num_rows() == 0){
				$insert_mapping = $this->model_app->insert_data("Ms_Mapping", $data_map);
				if($insert_mapping){
					$data = array(
						'status' => 'success'
					);
					echo json_encode($data);
				}else{
					$data = array(
						'status' => 'fail'
					);
					echo json_encode($data);
				}
			}
		}

		function get_approver_list(){
			$query = $this->db->query("select * from Ms_Mapping as m inner join Ms_Account as a on m.Mapping_approval_person = a.Account_ID
			inner join Ms_Structure_Organization as s on a.SO_ID = s.SO_ID inner join Ms_Department as d on s.Department_ID = d.Department_ID inner join Ms_Position as p on s.Position_ID = p.Position_ID
		 	where m.Account_ID = '".$this->session->userdata('account_id')."'");
			foreach($query->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
		}

		function set_profile(){
			date_default_timezone_set('Asia/Jakarta');
			$id = $this->input->post('id');
			$fs = $this->input->post('fs');
			$ls = $this->input->post('ls');
			$em = $this->input->post('em');
			$ph = $this->input->post('ph');

			$dp = $this->input->post('dp');
			$ps = $this->input->post('ps');
			if($dp == '' and $ps == ''){
				$data = array(
					'status' => 'fail'
				);
				echo json_encode($data);
			}else{
				$query_so = $this->db->query("select * from Ms_Structure_Organization where Position_ID = '".$ps."' and Department_ID='".$dp."'");
				foreach($query_so->result() as $so){
					$data['SO_ID'] = $so->SO_ID;
				}
				$data['Account_First_Name'] = $fs;
				$data['Account_Last_Name'] = $ls;
				$data['Account_Email'] = $em;
				$data['Account_Phone'] = $ph;

				$update_account = $this->model_app->update_data("Ms_Account", "Account_ID", $id, $data);
				if($update_account){
						$data = array(
							'status' => 'success'
						);
						echo json_encode($data);
				}else{
					$data = array(
						'status' => 'fail'
					);
					echo json_encode($data);
				}
			}
		}

		function get_activation($id_param){
			date_default_timezone_set('Asia/Jakarta');
			$id_param = $this->uri->segment(3);
			$query = $this->db->query("select * from Ms_Account_Privacy where user_ID = '".$id_param."' and Status = 0");
			if($query->num_rows() == 0){
				$set['paragraph'] = "Sorry this link activation is not valid";
				$set['span'] = "Back to login";
				$this->load->view('top_view');
				$this->load->view('activation_view',$set);
				$this->load->view('bottom_view');
			}else{
				$id = $id_param;
				$data['Status'] = 1;
				$act_activate = $this->model_app->update_data("Ms_Account_Privacy", "User_ID", $id, $data);
				if($act_activate){
					$set['paragraph'] = "Thank you, now you can access this application with this account";
					$set['span'] = "Back to login";
					$this->load->view('top_view');
					$this->load->view('activation_view',$set);
					$this->load->view('bottom_view');
				}else{
					$set['paragraph'] = "Error Query : executing query update status account is failure";
					$set['span'] = "Back to login";
					$this->load->view('top_view');
					$this->load->view('activation_view',$set);
					$this->load->view('bottom_view');
				}
			}
		}

		function act_register(){
			date_default_timezone_set('Asia/Jakarta');
			$first = $this->input->post('first');
			$last = $this->input->post('last');
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$email = $this->input->post('email');
			$role = '0';
			$id_user = $this->model_app->getMaxKode('Ms_Account_Privacy', 'User_ID', 'USR');
			$id_account = $this->model_app->getMaxKode('Ms_Account', 'User_ID', 'ACO');

			$data_a['Account_ID'] = $id_account;
			$data_a['User_ID'] = $id_user;
			$data_a['Account_First_Name'] = $first;
			$data_a['Account_Last_Name'] = $last;
			$data_a['Account_Email'] = $email;
			$data_a['User_ID'] = $id_user;
			$data_a['SO_Level'] = $role;
			$data_a['Account_CreateDt'] = date('Y-m-d H:i:s');

			$data_p['User_ID'] = $id_user;
			$data_p['Username'] = $username;
			$data_p['Password'] = $password;
			$data_p['Status'] = 0;

			$cek_privacy = $this->db->query("select * from Ms_Account_Privacy where username = '".$username."' and password = '".$password."'");
			$cek_email = $this->db->query("select * from Ms_Account where Account_Email = '".$email."'");
			if($cek_privacy->num_rows() == 0 and $cek_email->num_rows() == 0){
				$result_p = $this->model_app->insert_data('Ms_Account_Privacy', $data_p);
				$result_a = $this->model_app->insert_data('Ms_Account', $data_a);
				if($result_p and $result_a){
						$username = 'mailer.goc';
						$sender_email = 'mailer.goc@gmail.com';
						$user_password = 'gl0ria0rigitac0smetic';
						$subject = 'MDG Application | Link Activation';

						$message = '<div style="background-color:#f9f9f9;font-family:Helvetica,Arial,sans-serif;">
												<table style="margin:1% 5%;background-color:#fff;border-collapse:collapse;width:90%;border:none;">
													<tbody>
														<tr style="background-image:url(http://purbasari.com/assets/background-flat.jpg);background-size:cover;">
															<td style="width:100%;padding:0px;" colspan="2">
																<table style="width:100%;height:300px;background-color:#000;opacity:0.5">
																	<tr>
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
																	<tr>
																		<td>
																			<div style="margin-left:10px;color:#999;">
																				<h2>Your Privacy Account :</h2>
																				<p>
																					Hi,	'.$first.' '.$last.'<br/>
																					Please click this link for activation account.<br/>
																					'.base_url().'index.php/request/get_activation/'.$id_user.'/<br/>
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
															<td style="width:100%;padding:10px 0px;" colspan="2">
																<table>
																	<tr>
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
																	<tr style="text-align:center;">
																		<td style="width:95%;font-family:arial;padding-top:0px;padding-bottom:10px;padding-right:10px;border-collapse:collapse;text-align:justify">
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
												</div>';

						// Configure email library
						$config['protocol'] = 'smtp';
						$config['smtp_host'] = 'ssl://smtp.googlemail.com';
						$config['smtp_port'] = 465;
						$config['smtp_user'] = $sender_email;
						$config['smtp_pass'] = $user_password;
						$config['mailtype'] = 'html';
						$config['charset'] = 'iso-8859-1';


						// Load email library and passing configured values to email library
						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");
						// Sender email address
						$this->email->from($sender_email, $username);
						// Receiver email address
						$this->email->to($email);
						$this->email->cc('it.mis@goc.co.id');
						// Subject of email
						$this->email->subject($subject);
						// Message in email
						$this->email->message($message);
						// Action Sending Mesage
						$send_user = $this->email->send();
						if($send_user == true){
							$data = array(
								'status' => 'success'
							);
							echo json_encode($data);
						}else{
							$data = array(
								'status' => 'error'
							);
							echo json_encode($data);
						}
				}else{
					$data = array(
						'status' => 'fail'
					);
					echo json_encode($data);
				}
			}else if($cek_privacy->num_rows() == 0 and $cek_email->num_rows() == 1){
				$data = array(
					'status' => 'mail'
				);
				echo json_encode($data);
			}else{
				$data = array(
					'status' => 'pass'
				);
				echo json_encode($data);
			}
		}

		function get_Logout(){
			$cek = $this->session->userdata('success_data');
			if($cek){
				$this->session->sess_destroy();
				?>
				<script>
					window.location.href = '<?php echo base_url();?>index.php/';
				</script>
			<?php
			}
		}

		function get_forgot(){
			header("Access-Control-Allow-Origin: *");
			header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
			header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");
			date_default_timezone_set('Asia/Jakarta');
			$email = $this->input->post('email');
			$query = $this->db->query("select p.Username, p.Password, p.Status, a.Account_First_Name, a.Account_Last_Name, a.Account_Email from Ms_Account as a inner join Ms_Account_Privacy as p on a.User_ID = p.User_ID where a.Account_Email = '".$email."'");

			if($query->num_rows() == 0){
				$data = array(
					'status' => 'notavailable'
				);
				echo json_encode($data);
			}else if($query->num_rows() > 1){
				$data = array(
					'status' => 'double'
				);
				echo json_encode($data);
			}else if($query->num_rows() == 1){
				foreach($query->result() as $db){
					$username = 'mailer.goc';
					$sender_email = 'mailer.goc@gmail.com';
					$user_password = 'gl0ria0rigitac0smetic';
					$subject = 'MDG Application | Request Privacy Account';

					$message = '<div style="background-color:#f9f9f9;font-family:Helvetica,Arial,sans-serif;">
											<table style="margin:1% 5%;background-color:#fff;border-collapse:collapse;width:90%;border:none;">
												<tbody>
													<tr style="background-image:url(http://purbasari.com/assets/background-flat.jpg);background-size:cover;">
														<td style="width:100%;padding:0px;" colspan="2">
															<table style="width:100%;height:300px;background-color:#000;opacity:0.5">
																<tr>
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
																<tr>
																	<td>
																		<div style="margin-left:10px;color:#999;">
																		<p>Hi, '.$db->Account_First_Name.' '.$db->Account_Last_Name.',</p>
																		<p>We have received your request for privacy account.<br/>Now you can look at the bottom for your username and password.</p>
																			<p>
																				Username	:	'.$db->Username.'<br/>
																				Password	:	'.$db->Password.'<br/>
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
														<td style="width:100%;padding:10px 0px;" colspan="2">
															<table>
																<tr>
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
																<tr style="text-align:center;">
																	<td style="width:95%;font-family:arial;padding-top:0px;padding-bottom:10px;padding-right:10px;border-collapse:collapse;text-align:justify">
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
											</div>';

					// Configure email library
					$config['protocol'] = 'smtp';
					$config['smtp_host'] = 'ssl://smtp.googlemail.com';
					$config['smtp_port'] = 465;
					$config['smtp_user'] = $sender_email;
					$config['smtp_pass'] = $user_password;
					$config['mailtype'] = 'html';
					$config['charset'] = 'iso-8859-1';


					// Load email library and passing configured values to email library
					$this->load->library('email', $config);
					$this->email->set_newline("\r\n");
					// Sender email address
					$this->email->from($sender_email, $username);
					// Receiver email address
					$this->email->to($db->Account_Email);
					$this->email->cc('it.mis@goc.co.id');
					// Subject of email
					$this->email->subject($subject);
					// Message in email
					$this->email->message($message);
					// Action Sending Mesage
					$send_user = $this->email->send();
					if($send_user == true){
						$data = array(
							'status' => 'success'
						);
						echo json_encode($data);
					}else{
						$data = array(
							'status' => 'fail'
						);
						echo json_encode($data);
					}
				}
			}
		}

		function get_List(){
				$cek_status = $this->session->userdata('success_data');
				if(!$cek_status){
					?>
					<script>
						window.location.href = '<?php echo base_url();?>';
					</script>
					<?php
				}else{
					$query = $this->db->query("select * from Ms_Account as a inner join Ms_Account_Privacy as p on a.User_ID = p.User_ID where Account_ID = '".$this->session->userdata('account_id')."'");
					$query_c_update = $this->db->query("select * from NewUpdate where New_Status = 0 and Account_To = '".$this->session->userdata('account_id')."'");
					foreach($query->result() as $acc){
						$data['first_name'] = $acc->Account_First_Name;
						$data['last_name'] = $acc->Account_Last_Name;
						$data['username'] = $acc->Username;
					}

					$data['c_update'] = $query_c_update->num_rows();

					$this->load->view('top_view');
					$this->load->view('request_view',$data);
					$this->load->view('bottom_view');
				}
		}

		function get_thenew(){
			$query = $this->db->query("select top 3 n.*, v.MDG_Name from NewUpdate as n inner join Vw_Union_MDG_NewUpdate as v on n.MDG_ID = v.MDG_ID where New_Status = '0' and Account_To = '".$this->session->userdata('account_id')."' order by ObjectID desc");
			foreach($query->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
		}

		function create($name){
			date_default_timezone_set('Asia/Jakarta');
			$cek_status = $this->session->userdata('success_data');
			if(!$cek_status){
				?>
				<script>
					window.location.href = '<?php echo base_url();?>';
				</script>
				<?php
			}else{
				$name = $this->uri->segment(3);
				if($name == 'request_vendor'){
					$query = $this->db->query("select * from Ms_Account as a inner join Ms_Account_Privacy as p on a.User_ID = p.User_ID where Account_ID = '".$this->session->userdata('account_id')."'");
					$query_c_update = $this->db->query("select * from NewUpdate where New_Status = 0  and Account_To = '".$this->session->userdata('account_id')."'");
					foreach($query->result() as $acc){
						$data['first_name'] = $acc->Account_First_Name;
						$data['last_name'] = $acc->Account_Last_Name;
						$data['username'] = $acc->Username;
					}

					$data['c_update'] = $query_c_update->num_rows();

					$this->load->view('top_view');
					$this->load->view('create_vendor_view',$data);
					$this->load->view('bottom_view');
				}else	if($name == 'request_customer'){
						$query = $this->db->query("select * from Ms_Account as a inner join Ms_Account_Privacy as p on a.User_ID = p.User_ID where Account_ID = '".$this->session->userdata('account_id')."'");
						$query_c_update = $this->db->query("select * from NewUpdate where New_Status = 0  and Account_To = '".$this->session->userdata('account_id')."'");
						foreach($query->result() as $acc){
							$data['first_name'] = $acc->Account_First_Name;
							$data['last_name'] = $acc->Account_Last_Name;
							$data['username'] = $acc->Username;
						}

						$data['c_update'] = $query_c_update->num_rows();

						$this->load->view('top_view');
						$this->load->view('create_customer_view',$data);
						$this->load->view('bottom_view');
				}else{
					$query = $this->db->query("select * from Ms_Account as a inner join Ms_Account_Privacy as p on a.User_ID = p.User_ID where Account_ID = '".$this->session->userdata('account_id')."'");
					$query_c_update = $this->db->query("select * from NewUpdate where New_Status = 0 and Account_To = '".$this->session->userdata('account_id')."'");
					foreach($query->result() as $acc){
						$data['first_name'] = $acc->Account_First_Name;
						$data['last_name'] = $acc->Account_Last_Name;
						$data['username'] = $acc->Username;
					}

					$data['c_update'] = $query_c_update->num_rows();

					$this->load->view('top_view');
					$this->load->view('request_view',$data);
					$this->load->view('bottom_view');
				}
			}
		}

		//-----------------------------------------------------DREAFT LIST---------------------------------------------------------------------------------//

		function get_draft(){
				$cek_status = $this->session->userdata('success_data');
				if(!$cek_status){
					?>
					<script>
						window.location.href = '<?php echo base_url();?>';
					</script>
					<?php
				}else{
					$query = $this->db->query("select * from Ms_Account as a inner join Ms_Account_Privacy as p on a.User_ID = p.User_ID where Account_ID = '".$this->session->userdata('account_id')."'");
					$query_c_update = $this->db->query("select * from NewUpdate where New_Status = 0 and Account_To = '".$this->session->userdata('account_id')."'");
					foreach($query->result() as $acc){
						$data['first_name'] = $acc->Account_First_Name;
						$data['last_name'] = $acc->Account_Last_Name;
						$data['username'] = $acc->Username;
					}

					$data['c_update'] = $query_c_update->num_rows();

					$this->load->view('top_view');
					$this->load->view('draft_view',$data);
					$this->load->view('bottom_view');
				}
		}

		function get_data_detail_draft($id){
			$id = $this->uri->segment(3);
			$query = $this->db->query("select * from Ms_Vendor_MDG as m inner join Ms_Vendor_Type as t on m.MDG_VendorType_ID = t.VendorType_ID inner join Ms_Vendor_Province as p on m.VendorProvince_ID = p.VendorProvince_ID where MDG_Vendor_ID = '".$id."'");

			foreach($query->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
		}

		function get_data_detail_search($id){
			$id = $this->uri->segment(3);
			$query = $this->db->query("select * from Ms_Vendor_MDG as m inner join Ms_Vendor_Type as t on m.MDG_VendorType_ID = t.VendorType_ID inner join Ms_Vendor_Province as p on m.VendorProvince_ID = p.VendorProvince_ID where MDG_Vendor_ID = '".$id."'");

			foreach($query->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
		}

		function get_data_detail_customer_draft($id){
			$id = $this->uri->segment(3);
			$query = $this->db->query("select * from Ms_Customer_MDG as m inner join Ms_Customer_Type as t on m.MDG_CustomerType_ID = t.CustomerType_ID inner join Ms_Customer_Province as p on m.CustomerProvince_ID = p.CustomerProvince_ID
			inner join Ms_Customer_City as c on m.CustomerCity_ID = c.ObjectID inner join Ms_Customer_Term as tr on m.PaymentTerm_ID = tr.ObjectID where MDG_Customer_ID = '".$id."'");

			foreach($query->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
		}

		function get_data_detail_draft_app($id,$ac){
			$id = $this->uri->segment(3);
			$ac = $this->uri->segment(4);
			$query = $this->db->query("select m.*,t.*,p.*,ap.ObjectID as Approval_ID, ap.ParentObjectID as MDG_Approval, ap.MDG_Approval as Approval, ap.MDG_Remark as remark, ap.Account_ID as ID_approver from Ms_Vendor_MDG as m inner join Ms_Vendor_Type as t on m.MDG_VendorType_ID = t.VendorType_ID inner join Ms_Vendor_Province as p on m.VendorProvince_ID = p.VendorProvince_ID inner join Ms_Vendor_MDG_Approval as ap on ap.ParentObjectID = m.MDG_Vendor_ID where MDG_Vendor_ID = '".$id."' and ap.Account_ID = '".$ac."'");
			if($query->num_rows() == 0){
				$data = array(
					'status' => 'blm'
				);
				echo json_encode($data);
			}else{
				$data = array(
					'status' => 'ada'
				);
				echo json_encode($data);
			}
		}

		function get_data_detail_draft_customer_app($id,$ac){
			$id = $this->uri->segment(3);
			$ac = $this->uri->segment(4);
			$query = $this->db->query("select m.*,t.*,p.*,ap.ObjectID as Approval_ID, ap.ParentObjectID as MDG_Approval, ap.MDG_Approval as Approval, ap.MDG_Remark as remark, ap.Account_ID as ID_approver from Ms_Customer_MDG as m inner join Ms_customer_Type as t on m.MDG_CustomerType_ID = t.CustomerType_ID inner join Ms_Customer_Province as p on m.CustomerProvince_ID = p.CustomerProvince_ID inner join Ms_Customer_MDG_Approval as ap on ap.ParentObjectID = m.MDG_Customer_ID where MDG_Customer_ID = '".$id."' and ap.Account_ID = '".$ac."'");
			if($query->num_rows() == 0){
				$data = array(
					'status' => 'blm'
				);
				echo json_encode($data);
			}else{
				$data = array(
					'status' => 'ada'
				);
				echo json_encode($data);
			}
		}

		function get_display_draft($id){
			$id = $this->uri->segment(3);
			$cek_status = $this->session->userdata('success_data');
			if(!$cek_status){
				?>
				<script>
					window.location.href = '<?php echo base_url();?>';
				</script>
				<?php
			}else{
					$query = $this->db->query("select * from Ms_Account as a inner join Ms_Account_Privacy as p on a.User_ID = p.User_ID where Account_ID = '".$this->session->userdata('account_id')."'");
					$query_c_update = $this->db->query("select * from NewUpdate where New_Status = 0 and Account_To = '".$this->session->userdata('account_id')."'");
					foreach($query->result() as $acc){
						$data['first_name'] = $acc->Account_First_Name;
						$data['last_name'] = $acc->Account_Last_Name;
						$data['username'] = $acc->Username;
					}

					$data['c_update'] = $query_c_update->num_rows();

					if(substr($id,4,3) == 'VNR'){
						$this->load->view('top_view');
						$this->load->view('display_draft_view', $data);
						$this->load->view('bottom_view');
					}else if(substr($id,4,3) == 'CST'){
						$this->load->view('top_view');
						$this->load->view('display_draft_customer_view', $data);
						$this->load->view('bottom_view');
					}else{
						echo substr($id,5,3);
					}
				}
		}

		function get_inbox(){
				$cek_status = $this->session->userdata('success_data');
				if(!$cek_status){
					?>
					<script>
						window.location.href = '<?php echo base_url();?>';
					</script>
					<?php
				}else{
					$query = $this->db->query("select * from Ms_Account as a inner join Ms_Account_Privacy as p on a.User_ID = p.User_ID where Account_ID = '".$this->session->userdata('account_id')."'");
					$query_c_update = $this->db->query("select * from NewUpdate where New_Status = 0 and Account_To = '".$this->session->userdata('account_id')."'");
					foreach($query->result() as $acc){
						$data['first_name'] = $acc->Account_First_Name;
						$data['last_name'] = $acc->Account_Last_Name;
						$data['username'] = $acc->Username;
					}

					$data['c_update'] = $query_c_update->num_rows();

					$this->load->view('top_view');
					$this->load->view('inbox_view',$data);
					$this->load->view('bottom_view');
				}
		}

		function get_search($src){
			$cek_status = $this->session->userdata('success_data');
			if(!$cek_status){
				?>
				<script>
					window.location.href = '<?php echo base_url();?>';
				</script>
				<?php
			}else{
				$src = $this->uri->segment(3);
				$query = $this->db->query("select * from Ms_Account as a inner join Ms_Account_Privacy as p on a.User_ID = p.User_ID where Account_ID = '".$this->session->userdata('account_id')."'");
				$query_c_update = $this->db->query("select * from NewUpdate where New_Status = 0 and Account_To = '".$this->session->userdata('account_id')."'");
				foreach($query->result() as $acc){
					$data['first_name'] = $acc->Account_First_Name;
					$data['last_name'] = $acc->Account_Last_Name;
					$data['username'] = $acc->Username;
				}

				$data['c_update'] = $query_c_update->num_rows();

				$this->load->view('top_view');
				$this->load->view('search_view',$data);
				$this->load->view('bottom_view');
			}
		}

		function get_list_search_all(){
			$src = $this->input->post('src');

			$query_search = $this->db->query("select * from VIEW_MDG_ALL where name like '%".$src."%' or MDG_ID like '%".$src."%' or address like '%".$src."%' or cast(first+' '+last as varchar) like '%".$src."%'");

			foreach($query_search->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
		}

		function get_detail_search($id){
			$id = $this->uri->segment(3);
			$cek_status = $this->session->userdata('success_data');
			if(!$cek_status){
				?>
				<script>
					window.location.href = '<?php echo base_url();?>';
				</script>
				<?php
			}else{
				$query = $this->db->query("select * from Ms_Account as a inner join Ms_Account_Privacy as p on a.User_ID = p.User_ID where Account_ID = '".$this->session->userdata('account_id')."'");
				$query_c_update = $this->db->query("select * from NewUpdate where New_Status = 0 and Account_To = '".$this->session->userdata('account_id')."'");
				foreach($query->result() as $acc){
					$data['first_name'] = $acc->Account_First_Name;
					$data['last_name'] = $acc->Account_Last_Name;
					$data['username'] = $acc->Username;
				}

				$data['c_update'] = $query_c_update->num_rows();

				if(substr($id,4,3) == 'VNR'){
					$this->load->view('top_view');
					$this->load->view('search_detail_vendor_view',$data);
					$this->load->view('bottom_view');
				}else if(substr($id,4,3) == 'CST'){
					$this->load->view('top_view');
					$this->load->view('search_detail_customer_view',$data);
					$this->load->view('bottom_view');
				}else if(substr($id,4,3) == 'MTR'){
					$this->load->view('top_view');
					$this->load->view('search_detail_material_view',$data);
					$this->load->view('bottom_view');
				}
			}
		}

		function get_new_all(){
				$cek_status = $this->session->userdata('success_data');
				if(!$cek_status){
					?>
					<script>
						window.location.href = '<?php echo base_url();?>';
					</script>
					<?php
				}else{
					$query = $this->db->query("select * from Ms_Account as a inner join Ms_Account_Privacy as p on a.User_ID = p.User_ID where Account_ID = '".$this->session->userdata('account_id')."'");
					$query_c_update = $this->db->query("select * from NewUpdate where New_Status = 0 and Account_To = '".$this->session->userdata('account_id')."'");
					foreach($query->result() as $acc){
						$data['first_name'] = $acc->Account_First_Name;
						$data['last_name'] = $acc->Account_Last_Name;
						$data['username'] = $acc->Username;
					}

					$data['c_update'] = $query_c_update->num_rows();

					$this->load->view('top_view');
					$this->load->view('all_new_view',$data);
					$this->load->view('bottom_view');
				}
		}

		function get_list_inbox(){
			$query_pst = $this->db->query("select * from Ms_Account as a inner join Ms_Structure_Organization as s on a.SO_ID = s.SO_ID where a.Account_ID = '".$this->session->userdata('account_id')."'");

			foreach($query_pst->result() as $pst){
				$account = $pst->Account_ID;
				$level = $pst->SO_Level;
			}

			if($level == '1'){
					$query_get_vendor = $this->db->query("select * from NewInbox as i inner join Ms_Account as a on i.InboxMDG_From_Account = a.Account_ID order by InboxMDG_Arrived desc");
					foreach($query_get_vendor->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}else{
					$query_get_vendor = $this->db->query("select * from NewInbox as i inner join Ms_Account as a on i.InboxMDG_From_Account = a.Account_ID where i.InboxMDG_To_Account = '".$account."' order by InboxMDG_Arrived desc");
					foreach($query_get_vendor->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}
		}

		function get_list_all_new(){
			$query_pst = $this->db->query("select * from Ms_Account as a inner join Ms_Structure_Organization as s on a.SO_ID = s.SO_ID where a.Account_ID = '".$this->session->userdata('account_id')."'");

			foreach($query_pst->result() as $pst){
				$account = $pst->Account_ID;
				$level = $pst->SO_Level;
			}

			if($level == '1'){
					$query_get_vendor = $this->db->query("select * from NewInbox as i inner join Ms_Account as a on i.InboxMDG_From_Account = a.Account_ID where i.InboxMDG_Status = 0 order by InboxMDG_Arrived desc");
					foreach($query_get_vendor->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}else{
					$query_get_vendor = $this->db->query("select * from NewInbox as i inner join Ms_Account as a on i.InboxMDG_From_Account = a.Account_ID where i.InboxMDG_Status = 0 and i.InboxMDG_To_Account = '".$account."' order by InboxMDG_Arrived desc");
					foreach($query_get_vendor->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}
		}

		function get_list_inbox_vendor(){
			$query_pst = $this->db->query("select * from Ms_Account as a inner join Ms_Structure_Organization as s on a.SO_ID = s.SO_ID where a.Account_ID = '".$this->session->userdata('account_id')."'");

			foreach($query_pst->result() as $pst){
				$account = $pst->Account_ID;
				$level = $pst->SO_Level;
			}

			if($level == '1'){
					$query_get_vendor = $this->db->query("select * from NewInbox as i inner join Ms_Account as a on i.InboxMDG_From_Account = a.Account_ID where i.MDG_ID like 'MDG-VNR%'");
					foreach($query_get_vendor->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}else{
					$query_get_vendor = $this->db->query("select * from NewInbox as i inner join Ms_Account as a on i.InboxMDG_From_Account = a.Account_ID where i.MDG_ID like 'MDG-VNR%' and i.InboxMDG_To_Account = '".$account."'");
					foreach($query_get_vendor->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}
		}

		function get_list_new_vendor(){
			$query_pst = $this->db->query("select * from Ms_Account as a inner join Ms_Structure_Organization as s on a.SO_ID = s.SO_ID where a.Account_ID = '".$this->session->userdata('account_id')."'");

			foreach($query_pst->result() as $pst){
				$account = $pst->Account_ID;
				$level = $pst->SO_Level;
			}

			if($level == '1'){
					$query_get_vendor = $this->db->query("select * from NewInbox as i inner join Ms_Account as a on i.InboxMDG_From_Account = a.Account_ID where i.InboxMDG_Status = 0 and i.MDG_ID like 'MDG-VNR%'");
					foreach($query_get_vendor->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}else{
					$query_get_vendor = $this->db->query("select * from NewInbox as i inner join Ms_Account as a on i.InboxMDG_From_Account = a.Account_ID where i.InboxMDG_Status = 0 and i.MDG_ID like 'MDG-VNR%' and i.InboxMDG_To_Account = '".$account."'");
					foreach($query_get_vendor->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}
		}


		function get_list_inbox_customer(){
			$query_pst = $this->db->query("select * from Ms_Account as a inner join Ms_Structure_Organization as s on a.SO_ID = s.SO_ID where a.Account_ID = '".$this->session->userdata('account_id')."'");

			foreach($query_pst->result() as $pst){
				$account = $pst->Account_ID;
				$level = $pst->SO_Level;
			}

			if($level == '1'){
					$query_get_customer = $this->db->query("select * from NewInbox as i inner join Ms_Account as a on i.InboxMDG_From_Account = a.Account_ID where i.MDG_ID like 'MDG-CST%'");
					foreach($query_get_customer->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}else{
					$query_get_customer = $this->db->query("select * from NewInbox as i inner join Ms_Account as a on i.InboxMDG_From_Account = a.Account_ID where i.MDG_ID like 'MDG-CST%' and i.InboxMDG_To_Account = '".$account."'");
					foreach($query_get_customer->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}
		}

		function get_list_new_customer(){
			$query_pst = $this->db->query("select * from Ms_Account as a inner join Ms_Structure_Organization as s on a.SO_ID = s.SO_ID where a.Account_ID = '".$this->session->userdata('account_id')."'");

			foreach($query_pst->result() as $pst){
				$account = $pst->Account_ID;
				$level = $pst->SO_Level;
			}

			if($level == '1'){
					$query_get_customer = $this->db->query("select * from NewInbox as i inner join Ms_Account as a on i.InboxMDG_From_Account = a.Account_ID where i.InboxMDG_Status = 0 and i.MDG_ID like 'MDG-CST%'");
					foreach($query_get_customer->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}else{
					$query_get_customer = $this->db->query("select * from NewInbox as i inner join Ms_Account as a on i.InboxMDG_From_Account = a.Account_ID where i.InboxMDG_Status = 0 and i.MDG_ID like 'MDG-CST%' and i.InboxMDG_To_Account = '".$account."'");
					foreach($query_get_customer->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}
		}


		function get_outbox(){
				$cek_status = $this->session->userdata('success_data');
				if(!$cek_status){
					?>
					<script>
						window.location.href = '<?php echo base_url();?>';
					</script>
					<?php
				}else{
					$query = $this->db->query("select * from Ms_Account as a inner join Ms_Account_Privacy as p on a.User_ID = p.User_ID where Account_ID = '".$this->session->userdata('account_id')."'");
					$query_c_update = $this->db->query("select * from NewUpdate where New_Status = 0 and Account_To = '".$this->session->userdata('account_id')."'");
					foreach($query->result() as $acc){
						$data['first_name'] = $acc->Account_First_Name;
						$data['last_name'] = $acc->Account_Last_Name;
						$data['username'] = $acc->Username;
					}

					$data['c_update'] = $query_c_update->num_rows();

					$this->load->view('top_view');
					$this->load->view('outbox_view',$data);
					$this->load->view('bottom_view');
				}
		}

		function get_list_outbox(){
			$query_pst = $this->db->query("select * from Ms_Account as a inner join Ms_Structure_Organization as s on a.SO_ID = s.SO_ID where a.Account_ID = '".$this->session->userdata('account_id')."'");

			foreach($query_pst->result() as $pst){
				$account = $pst->Account_ID;
				$level = $pst->SO_Level;
			}

			if($level == '1'){
					$query_get_vendor = $this->db->query("select * from NewOutbox as o inner join Ms_Account as a on o.OutboxMDG_To_Account = a.Account_ID order by OutboxMDG_Send desc");
					foreach($query_get_vendor->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}else{
					$query_get_vendor = $this->db->query("select * from NewOutbox as o inner join Ms_Account as a on o.OutboxMDG_To_Account = a.Account_ID where o.OutboxMDG_From_Account = '".$account."' order by OutboxMDG_Send desc");
					foreach($query_get_vendor->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}
		}

		function get_list_outbox_vendor(){
			$query_pst = $this->db->query("select * from Ms_Account as a inner join Ms_Structure_Organization as s on a.SO_ID = s.SO_ID where a.Account_ID = '".$this->session->userdata('account_id')."'");

			foreach($query_pst->result() as $pst){
				$account = $pst->Account_ID;
				$level = $pst->SO_Level;
			}

			if($level == '1'){
					$query_get_vendor = $this->db->query("select * from NewOutbox as o inner join Ms_Account as a on o.OutboxMDG_To_Account = a.Account_ID where o.MDG_ID like 'MDG-VNR%' order by OutboxMDG_Send desc");
					foreach($query_get_vendor->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}else{
					$query_get_vendor = $this->db->query("select * from NewOutbox as o inner join Ms_Account as a on o.OutboxMDG_To_Account = a.Account_ID where o.MDG_ID like 'MDG-VNR%' and o.OutboxMDG_From_Account = '".$account."' order by OutboxMDG_Send desc");
					foreach($query_get_vendor->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}
		}

		function get_list_outbox_customer(){
			$query_pst = $this->db->query("select * from Ms_Account as a inner join Ms_Structure_Organization as s on a.SO_ID = s.SO_ID where a.Account_ID = '".$this->session->userdata('account_id')."'");

			foreach($query_pst->result() as $pst){
				$account = $pst->Account_ID;
				$level = $pst->SO_Level;
			}

			if($level == '1'){
					$query_get_customer = $this->db->query("select * from NewOutbox as o inner join Ms_Account as a on o.OutboxMDG_To_Account = a.Account_ID where o.MDG_ID like 'MDG-CST%' order by OutboxMDG_Send desc");
					foreach($query_get_customer->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}else{
					$query_get_customer = $this->db->query("select * from NewOutbox as o inner join Ms_Account as a on o.OutboxMDG_To_Account = a.Account_ID where o.MDG_ID like 'MDG-CST%' and o.OutboxMDG_From_Account = '".$account."' order by OutboxMDG_Send desc");
					foreach($query_get_customer->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}
		}


		function get_list_draft(){
			$query_pst = $this->db->query("select * from Ms_Account as a inner join Ms_Structure_Organization as s on a.SO_ID = s.SO_ID where a.Account_ID = '".$this->session->userdata('account_id')."'");

			foreach($query_pst->result() as $pst){
				$account = $pst->Account_ID;
				$level = $pst->SO_Level;
			}

			if($level == '1'){
					$query_get_vendor = $this->db->query("select *, case when updatedate is null then createdate else updatedate end as effdate from VIEW_MDG_DRAFT order by effdate");
					foreach($query_get_vendor->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}else{
					$query_get_vendor = $this->db->query("select *, case when updatedate is null then createdate else updatedate end as effdate from VIEW_MDG_DRAFT AS v where v.Account = '".$account."' order by effdate");
					foreach($query_get_vendor->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}
		}

		function get_list_draft_vendor(){
			$query_pst = $this->db->query("select * from Ms_Account as a inner join Ms_Structure_Organization as s on a.SO_ID = s.SO_ID where a.Account_ID = '".$this->session->userdata('account_id')."'");

			foreach($query_pst->result() as $pst){
				$account = $pst->Account_ID;
				$level = $pst->SO_Level;
			}

			if($level == '1'){
					$query_get_vendor = $this->db->query("select *, case when MDG_UpdateDt is null then MDG_CreateDt else MDG_UpdateDt end as effdate from Ms_Vendor_MDG as v inner join Ms_Account as a on v.Account_ID = a.Account_ID
					inner join Ms_Vendor_Type as t on v.MDG_VendorType_ID =  t.VendorType_ID  where MDG_Status = '1'  order by effdate");
					foreach($query_get_vendor->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}else{
					$query_get_vendor = $this->db->query("select *, case when MDG_UpdateDt is null then MDG_CreateDt else MDG_UpdateDt end as effdate from Ms_Vendor_MDG as v inner join Ms_Account as a on v.Account_ID = a.Account_ID
					inner join Ms_Vendor_Type as t on v.MDG_VendorType_ID =  t.VendorType_ID  where MDG_Status = '1' and v.Account_ID = '".$account."'  order by effdate");
					foreach($query_get_vendor->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}
		}

		function get_list_draft_customer(){
			$query_pst = $this->db->query("select * from Ms_Account as a inner join Ms_Structure_Organization as s on a.SO_ID = s.SO_ID where a.Account_ID = '".$this->session->userdata('account_id')."'");

			foreach($query_pst->result() as $pst){
				$account = $pst->Account_ID;
				$level = $pst->SO_Level;
			}

			if($level == '1'){
					$query_get_customer = $this->db->query("select *, case when MDG_UpdateDt is null then MDG_CreateDt else MDG_UpdateDt end as effdate from Ms_Customer_MDG as v inner join Ms_Account as a on v.Account_ID = a.Account_ID
					inner join Ms_Customer_Type as t on v.MDG_CustomerType_ID =  t.CustomerType_ID  where MDG_Status = '1'  order by effdate");
					foreach($query_get_customer->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}else{
					$query_get_customer = $this->db->query("select *, case when MDG_UpdateDt is null then MDG_CreateDt else MDG_UpdateDt end as effdate from Ms_Customer_MDG as v inner join Ms_Account as a on v.Account_ID = a.Account_ID
					inner join Ms_Customer_Type as t on v.MDG_CustomerType_ID =  t.CustomerType_ID  where MDG_Status = '1' and v.Account_ID = '".$account."'  order by effdate");
					foreach($query_get_customer->result() as $grid5){
						$data[] = $grid5;
					}
					echo json_encode($data);
			}
		}

		//-----------------------------------------------------CREATE VENDOR-------------------------------------------------------------------------------//

		function get_data_vendor_type(){
			$query_vendor = $this->db->query("select VendorType_ID, VendorType_Name from Ms_Vendor_Type where VendorType_Status = 1 order by VendorType_ID");
			foreach($query_vendor->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
		}

		function get_data_customer_type(){
			$query_customer = $this->db->query("select CustomerType_ID, CustomerType_Name from Ms_Customer_Type where CustomerType_Status = 1 order by CustomerType_ID");
			foreach($query_customer->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
		}

		function get_data_vendor_province(){
			$query_vendor = $this->db->query("select VendorProvince_ID, VendorProvince_Name from Ms_Vendor_Province where VendorProvince_Status = 1 order by VendorProvince_ID");
			foreach($query_vendor->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
		}

		function get_data_customer_province(){
			$query_customer = $this->db->query("select CustomerProvince_ID, CustomerProvince_Name from Ms_Customer_Province where CustomerProvince_Status = 1 order by CustomerProvince_ID");
			foreach($query_customer->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
		}

		function get_data_customer_city(){
			$query_city = $this->db->query("select ObjectID, CustomerCity_Name from Ms_Customer_City order by CustomerCity_Name");
			foreach($query_city->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
		}

		function get_data_customer_term(){
			$query_term = $this->db->query("select ObjectID, MDG_TermName from Ms_Customer_Term order by ObjectID");
			foreach($query_term->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
		}

		function get_send_vendor(){
			date_default_timezone_set('Asia/Jakarta');
			if($this->input->post('title') == '' or $this->input->post('name') == '' or $this->input->post('type') == '' or $this->input->post('address1') == '' or $this->input->post('houseno') == '' or
			$this->input->post('city') == '' or $this->input->post('province') == '' or $this->input->post('country') == '' or $this->input->post('npwp') == '' or $this->input->post('ppn') == '' or
			$this->input->post('paymentterm') == ''){
				$data = array(
					'status' => 'require'
				);
				echo json_encode($data);
			}else{
				if($this->input->post('id') == ''){
					$ven = '';
					$data['MDG_Title'] = $this->input->post('title'); //m
					$data['MDG_VendorName'] = $this->input->post('name'); //m
					$data['MDG_VendorType_ID'] = $this->input->post('type'); //m
					$data['MDG_SearchTerm'] = $this->input->post('searchterm');
					$data['MDG_Address1'] = $this->input->post('address1'); //m
					$data['MDG_Address2'] = $this->input->post('address2');
					$data['MDG_Address3'] = $this->input->post('address3');
					$data['MDG_HouseNo'] = $this->input->post('houseno'); //m
					$data['MDG_City'] = $this->input->post('city'); //m
					$data['MDG_PostalCode'] = $this->input->post('postal');
					$data['VendorProvince_ID'] = $this->input->post('province'); //m
					$data['MDG_Country'] = $this->input->post('country'); //m
					$data['MDG_Phone'] = $this->input->post('phone');
					$data['MDG_Mobile'] = $this->input->post('mobile');
					$data['MDG_NPWP'] = $this->input->post('npwp'); //m
					$data['MDG_PPN'] = $this->input->post('ppn'); //m
					$data['MDG_BankKey'] = $this->input->post('bankkey');
					$data['MDG_AccountNo'] = $this->input->post('accountno');
					$data['MDG_AccountName'] = $this->input->post('accountname');
					$data['MDG_PaymentTerm'] = $this->input->post('paymentterm'); //m

					$data['MDG_Vendor_ID'] = $this->model_app->getMaxKode('Ms_Vendor_MDG', 'MDG_Vendor_ID', 'MDG-VNR');
					$ven = $data['MDG_Vendor_ID'];
					$data['MDG_CreateDt'] = date('Y-m-d H:i:s');
					$data['MDG_Status'] = 1;
					$data['Account_ID'] = $this->session->userdata('account_id');

					//--------------------------------------------------------------------------------------------------------------------//
					//LOG MDG VENDOR Request
					//--------------------------------------------------------------------------------------------------------------------//
					$req_log['MDG_Title'] = $this->input->post('title'); //m
					$req_log['MDG_VendorName'] = $this->input->post('name'); //m
					$req_log['MDG_VendorType_ID'] = $this->input->post('type'); //m
					$req_log['MDG_SearchTerm'] = $this->input->post('searchterm');
					$req_log['MDG_Address1'] = $this->input->post('address1'); //m
					$req_log['MDG_Address2'] = $this->input->post('address2');
					$req_log['MDG_Address3'] = $this->input->post('address3');
					$req_log['MDG_HouseNo'] = $this->input->post('houseno'); //m
					$req_log['MDG_City'] = $this->input->post('city'); //m
					$req_log['MDG_PostalCode'] = $this->input->post('postal');
					$req_log['VendorProvince_ID'] = $this->input->post('province'); //m
					$req_log['MDG_Country'] = $this->input->post('country'); //m
					$req_log['MDG_Phone'] = $this->input->post('phone');
					$req_log['MDG_Mobile'] = $this->input->post('mobile');
					$req_log['MDG_NPWP'] = $this->input->post('npwp'); //m
					$req_log['MDG_PPN'] = $this->input->post('ppn'); //m
					$req_log['MDG_BankKey'] = $this->input->post('bankkey');
					$req_log['MDG_AccountNo'] = $this->input->post('accountno');
					$req_log['MDG_AccountName'] = $this->input->post('accountname');
					$req_log['MDG_PaymentTerm'] = $this->input->post('paymentterm'); //m
					$req_log['LOG_ID'] = $this->model_app->getMaxKode('Ms_Vendor_MDG_Log', 'LOG_ID', 'LOG-VNR');
					$req_log['MDG_Vendor_ID'] = $data['MDG_Vendor_ID'];
					$req_log['MDG_CreateDt'] = date('Y-m-d H:i:s');
					$req_log['MDG_Status'] = 1;
					$req_log['Account_ID'] = $this->session->userdata('account_id');

					$query = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
					foreach($query->result() as $acc){
						$data1['Account_Name'] = $acc->Account_First_Name.' '.$acc->Account_Last_Name;
					}

					$data1['MDG_Type'] = 'Vendor';
					$data1['MDG_Category'] = 'Request';
					$data1['MDG_ID'] = $data['MDG_Vendor_ID'];
					$data1['Information'] = 'Request Data Vendor (Send for approval)';
					$data1['Posting_Date'] = date('Y-m-d H:i:s');
					$data1['Account_ID'] = $this->session->userdata('account_id');
					$data1['Log_Status'] = 'Created (to Send)';

					$insert = $this->model_app->insert_data('Ms_Vendor_MDG', $data);
					$insert1 = $this->model_app->insert_data('MDG_Log', $data1);
					$insert_req_log = $this->model_app->insert_data('Ms_Vendor_MDG_Log', $req_log);
					if(!$insert){
						$data = array(
							'status' => 'fail'
						);
						echo json_encode($data);
					}else{
						if($insert1){
							//send approval to approver
							$query_mapping = $this->db->query("select * from Ms_Mapping AS m inner join Ms_Account as a on m.Mapping_approval_person = a.Account_ID inner join Ms_Structure_Organization as o on a.SO_ID = o.SO_ID where m.Account_ID = '".$this->session->userdata('account_id')."'");
							foreach($query_mapping->result() as $map){
								$username = 'mailer.goc';
								$sender_email = 'mailer.goc@gmail.com';
								$user_password = 'gl0ria0rigitac0smetic';
								$subject = 'MDG Application | Approval Master Data Vendor';

								$message = '<div style="background-color:#f9f9f9;font-family:Helvetica,Arial,sans-serif;">
														<table style="margin:1% 5%;background-color:#fff;border-collapse:collapse;width:90%;border:none;">
															<tbody>
																<tr style="background-image:url(http://purbasari.com/assets/background-flat.jpg);background-size:cover;">
																	<td style="width:100%;padding:0px;" colspan="2">
																		<table style="width:100%;height:300px;background-color:#000;opacity:0.5">
																			<tr>
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
																			<tr>
																				<td>
																					<div style="margin-left:10px;color:#999;">
																					<p>Hi, '.$map->Account_First_Name.' '.$map->Account_Last_Name.',</p>
																					<p>We have received approval form (Master Data Vendor).<br/>Now you can look at the bottom for link form master data vendor, Please visit here.</p>
																						<p>
																							Link (Approve):	'.base_url().'index.php/request/approval_master_vendor/'.$ven.'/'.$map->Mapping_approval_person.'<br/>
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
																	<td style="width:100%;padding:10px 0px;" colspan="2">
																		<table>
																			<tr>
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
																			<tr style="text-align:center;">
																				<td style="width:95%;font-family:arial;padding-top:0px;padding-bottom:10px;padding-right:10px;border-collapse:collapse;text-align:justify">
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
														</div>';

								//$message = 'test';
								// Configure email library
								$config['protocol'] = 'smtp';
								$config['smtp_host'] = 'ssl://smtp.googlemail.com';
								$config['smtp_port'] = 465;
								$config['smtp_user'] = $sender_email;
								$config['smtp_pass'] = $user_password;
								$config['mailtype'] = 'html';
								$config['charset'] = 'iso-8859-1';


								// Load email library and passing configured values to email library
								$this->load->library('email', $config);
								$this->email->set_newline("\r\n");
								// Sender email address
								$this->email->from($sender_email, $username);
								// Receiver email address
								$this->email->to($map->Account_Email);
								$this->email->cc('it.mis@goc.co.id');
								// Subject of email
								$this->email->subject($subject);
								// Message in email
								$this->email->message($message);
								// Action Sending Mesage
								$send_user = $this->email->send();
								if($send_user == true){
									//update status menjadi 2 jika berhasil terkirim
									$id_status2 = $ven;
									$update_status2['MDG_Status'] = '2';

									$update_stts2 = $this->model_app->update_data('Ms_Vendor_MDG', 'MDG_Vendor_ID', $id_status2, $update_status2);
									if($update_stts2){
										$query_log = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
										foreach($query_log->result() as $acc1){
											$update_data_log['Account_Name'] = $acc1->Account_First_Name.' '.$acc1->Account_Last_Name;
										}

										$update_data_log['MDG_Type'] = 'Vendor';
										$update_data_log['MDG_Category'] = 'Request';
										$update_data_log['MDG_ID'] = $ven;
										$update_data_log['Information'] = 'Request Data Vendor send to mail '.$map->Account_Email;
										$update_data_log['Posting_Date'] = date('Y-m-d H:i:s');
										$update_data_log['Account_ID'] = $this->session->userdata('account_id');
										$update_data_log['Log_Status'] = 'Send Mail';

										$insert_send_mail = $this->model_app->insert_data('MDG_Log', $update_data_log);
										if($insert_send_mail){
											$outbox['OutboxMDG_ID'] = $this->model_app->getMaxKode('NewOutbox', 'OutboxMDG_ID', 'OTBX');
											$outbox['OutboxMDG_To'] = $map->Account_Email;
											$outbox['OutboxMDG_From_Account'] = $this->session->userdata('account_id');
											$outbox['OutboxMDG_To_Account'] = $map->Mapping_approval_person;
											$outbox['OutboxMDG_Subject'] = $subject;
											$outbox['OutboxMDG_ShortText'] = substr("Hi, ".$map->Account_First_Name.' '.$map->Account_Last_Name." We have received request form (Master Data Vendor). Now you can look at the bottom for link form master data vendor, Please visit here.",0,90);
											$outbox['OutboxMDG_Send'] = $update_data_log['Posting_Date'];
											$outbox['OutboxMDG_Link'] = 'index.php/request/outbox/vendor/'.$ven;
											$outbox['OutboxType'] = 'Request';
											$outbox['MDG_ID'] = $ven;
											$outbox['LOG_ID'] = $req_log['LOG_ID'];
											$outbox['OutboxMDG_Status'] = 0;
											$insert_outbox = $this->model_app->insert_data('NewOutbox', $outbox);


											$inbox['InboxMDG_ID'] = $this->model_app->getMaxKode('NewInbox', 'InboxMDG_ID', 'INBX');
											$inbox['InboxMDG_From'] = $map->Account_Email;
											$inbox['InboxMDG_From_Account'] = $this->session->userdata('account_id');
											$inbox['InboxMDG_To_Account'] = $map->Mapping_approval_person;
											$inbox['InboxMDG_Subject'] = $subject;
											$inbox['InboxMDG_ShortText'] = substr("Hi, ".$map->Account_First_Name.' '.$map->Account_Last_Name." We have received request form (Master Data Vendor). Now you can look at the bottom for link form master data vendor, Please visit here.",0,90);
											$inbox['InboxMDG_Arrived'] = $update_data_log['Posting_Date'];
											$inbox['InboxMDG_Link'] = 'index.php/request/inbox/vendor/'.$ven;
											$inbox['InboxType'] = 'Request';
											$inbox['MDG_ID'] = $ven;
											$inbox['LOG_ID'] = $req_log['LOG_ID'];
											$inbox['InboxMDG_Status'] = 0;
											$insert_inbox = $this->model_app->insert_data('NewInbox', $inbox);


											$newupdate['Account_ID'] = $this->session->userdata('account_id');
											$newupdate['Account_To'] = $map->Mapping_approval_person;
											$newupdate['New_ActyDt'] = date('Y-m-d H:i:s');
											$newupdate['New_Type'] = 'Request';
											$newupdate['MDG_ID'] = $ven;
											$newupdate['LOG_ID'] = $req_log['LOG_ID'];
											$newupdate['New_Description'] = "Request Master Vendor ".$ven;
											$newupdate['New_Link'] = 'index.php/request/new/vendor/'.$ven;
											$newupdate['New_Status'] = 0;
											$insert_newupdate = $this->model_app->insert_data('NewUpdate', $newupdate);

											if($insert_outbox){
												if($insert_inbox){
													if($insert_newupdate){
														$data = array(
															'status' => 'success',
															'id' => $ven
														);
														//echo json_encode($data);
													}

													else{
														$data = array(
															'status' => 'gagal',
															'id' => $data['MDG_Vendor_ID']
														);
														//echo json_encode($data);
													}
												}

												else{
													$data = array(
														'status' => 'gagal2',
														'id' => $data['MDG_Vendor_ID']
													);
													//echo json_encode($data);
												}
											}

											else{
												$data = array(
													'status' => 'gagal3',
													'id' => $data['MDG_Vendor_ID']
												);
												//echo json_encode($data);
											}

										}else{
											$data = array(
												'status' => 'faillogsend',
												'id' => $ven
											);
											//echo json_encode($data);
										}
									}else{
										$data = array(
											'status' => 'failstatus2',
											'id' => $ven
										);
										//echo json_encode($data);
									}
								}else{
									$data = array(
										'status' => 'failsend',
										'id' => $ven
									);
									//echo json_encode($data);
								}
							}
							echo json_encode($data);
						}else{
							$data = array(
								'status' => 'faillogupdate',
								'id' => $ven
							);
							echo json_encode($data);
						}
					}
				}else{
					$data = array(
						'status' => 'refresh'
					);
					echo json_encode($data);
				}
			}
		}

		function get_send_customer(){
			date_default_timezone_set('Asia/Jakarta');
			if($this->input->post('title') == '' or $this->input->post('name') == '' or $this->input->post('type') == '' or $this->input->post('address1') == '' or $this->input->post('houseno') == '' or
			$this->input->post('city') == '' or $this->input->post('province') == '' or $this->input->post('country') == '' or $this->input->post('npwp') == '' or $this->input->post('ppn') == '' or
			$this->input->post('paymentterm') == '' or $this->input->post('sambill') == ''){
				$data = array(
					'status' => 'require'
				);
				echo json_encode($data);
			}else if($this->input->post('sambill') == 'No'){
				if($this->input->post('billtoparty') == ''){
					$data = array(
						'status' => 'require'
					);
					echo json_encode($data);
				}else{
					//------------------------------------------
					if($this->input->post('id') == ''){
						$cus = '';
						$data['MDG_Title'] = $this->input->post('title'); //m
						$data['MDG_CustomerName'] = $this->input->post('name'); //m
						$data['MDG_CustomerType_ID'] = $this->input->post('type'); //m
						$data['MDG_SearchTerm'] = $this->input->post('searchterm');
						$data['MDG_Address1'] = $this->input->post('address1'); //m
						$data['MDG_Address2'] = $this->input->post('address2');
						$data['MDG_Address3'] = $this->input->post('address3');
						$data['MDG_HouseNo'] = $this->input->post('houseno'); //m
						$data['CustomerCity_ID'] = $this->input->post('city'); //m
						$data['MDG_PostalCode'] = $this->input->post('postal');
						$data['CustomerProvince_ID'] = $this->input->post('province'); //m
						$data['MDG_Country'] = $this->input->post('country'); //m
						$data['MDG_Phone'] = $this->input->post('phone');
						$data['MDG_Mobile'] = $this->input->post('mobile');
						$data['MDG_NPWP'] = $this->input->post('npwp'); //m
						$data['MDG_PPN'] = $this->input->post('ppn'); //m
						$data['MDG_BankKey'] = $this->input->post('bankkey');
						$data['MDG_AccountNo'] = $this->input->post('accountno');
						$data['MDG_AccountName'] = $this->input->post('accountname');
						$data['MDG_SameBill'] = $this->input->post('sambill');
						$data['MDG_Billtoparty'] = $this->input->post('billtoparty');
						$data['PaymentTerm_ID'] = $this->input->post('paymentterm'); //m

						$data['MDG_Customer_ID'] = $this->model_app->getMaxKode('Ms_Customer_MDG', 'MDG_Customer_ID', 'MDG-CST');
						$cus = $data['MDG_Customer_ID'];
						$data['MDG_CreateDt'] = date('Y-m-d H:i:s');
						$data['MDG_Status'] = 1;
						$data['Account_ID'] = $this->session->userdata('account_id');

						//--------------------------------------------------------------------------------------------------------------------//
						//LOG MDG CUSTOMER Request
						//--------------------------------------------------------------------------------------------------------------------//
						$req_log['MDG_Title'] = $this->input->post('title'); //m
						$req_log['MDG_CustomerName'] = $this->input->post('name'); //m
						$req_log['MDG_CustomerType_ID'] = $this->input->post('type'); //m
						$req_log['MDG_SearchTerm'] = $this->input->post('searchterm');
						$req_log['MDG_Address1'] = $this->input->post('address1'); //m
						$req_log['MDG_Address2'] = $this->input->post('address2');
						$req_log['MDG_Address3'] = $this->input->post('address3');
						$req_log['MDG_HouseNo'] = $this->input->post('houseno'); //m
						$req_log['CustomerCity_ID'] = $this->input->post('city'); //m
						$req_log['MDG_PostalCode'] = $this->input->post('postal');
						$req_log['CustomerProvince_ID'] = $this->input->post('province'); //m
						$req_log['MDG_Country'] = $this->input->post('country'); //m
						$req_log['MDG_Phone'] = $this->input->post('phone');
						$req_log['MDG_Mobile'] = $this->input->post('mobile');
						$req_log['MDG_NPWP'] = $this->input->post('npwp'); //m
						$req_log['MDG_PPN'] = $this->input->post('ppn'); //m
						$req_log['MDG_BankKey'] = $this->input->post('bankkey');
						$req_log['MDG_AccountNo'] = $this->input->post('accountno');
						$req_log['MDG_AccountName'] = $this->input->post('accountname');
						$req_log['MDG_SameBill'] = $this->input->post('sambill');
						$req_log['MDG_Billtoparty'] = $this->input->post('billtoparty');
						$req_log['PaymentTerm_ID'] = $this->input->post('paymentterm');
						$req_log['LOG_ID'] = $this->model_app->getMaxKode('Ms_Customer_MDG_Log', 'LOG_ID', 'LOG-CST');
						$req_log['MDG_Customer_ID'] = $data['MDG_Customer_ID'];
						$req_log['MDG_CreateDt'] = date('Y-m-d H:i:s');
						$req_log['MDG_Status'] = 1;
						$req_log['Account_ID'] = $this->session->userdata('account_id');

						$query = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
						foreach($query->result() as $acc){
							$data1['Account_Name'] = $acc->Account_First_Name.' '.$acc->Account_Last_Name;
						}

						$data1['MDG_Type'] = 'Customer';
						$data1['MDG_Category'] = 'Request';
						$data1['MDG_ID'] = $data['MDG_Customer_ID'];
						$data1['Information'] = 'Request Data Customer (Send for approval)';
						$data1['Posting_Date'] = date('Y-m-d H:i:s');
						$data1['Account_ID'] = $this->session->userdata('account_id');
						$data1['Log_Status'] = 'Created (to Send)';

						$insert = $this->model_app->insert_data('Ms_Customer_MDG', $data);
						$insert1 = $this->model_app->insert_data('MDG_Log', $data1);
						$insert_req_log = $this->model_app->insert_data('Ms_Customer_MDG_Log', $req_log);
						if(!$insert){
							$data = array(
								'status' => 'fail'
							);
							echo json_encode($data);
						}else{
							if($insert1){
								//send approval to approver
								$query_mapping = $this->db->query("select * from Ms_Mapping AS m inner join Ms_Account as a on m.Mapping_approval_person = a.Account_ID inner join Ms_Structure_Organization as o on a.SO_ID = o.SO_ID where m.Account_ID = '".$this->session->userdata('account_id')."'");
								foreach($query_mapping->result() as $map){
									$username = 'mailer.goc';
									$sender_email = 'mailer.goc@gmail.com';
									$user_password = 'gl0ria0rigitac0smetic';
									$subject = 'MDG Application | Approval Master Data Customer';

									$message = '<div style="background-color:#f9f9f9;font-family:Helvetica,Arial,sans-serif;">
															<table style="margin:1% 5%;background-color:#fff;border-collapse:collapse;width:90%;border:none;">
																<tbody>
																	<tr style="background-image:url(http://purbasari.com/assets/background-flat.jpg);background-size:cover;">
																		<td style="width:100%;padding:0px;" colspan="2">
																			<table style="width:100%;height:300px;background-color:#000;opacity:0.5">
																				<tr>
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
																				<tr>
																					<td>
																						<div style="margin-left:10px;color:#999;">
																						<p>Hi, '.$map->Account_First_Name.' '.$map->Account_Last_Name.',</p>
																						<p>We have received approval form (Master Data Customer).<br/>Now you can look at the bottom for link form master data customer, Please visit here.</p>
																							<p>
																								Link (Approve):	'.base_url().'index.php/request/approval_master_customer/'.$cus.'/'.$map->Mapping_approval_person.'<br/>
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
																		<td style="width:100%;padding:10px 0px;" colspan="2">
																			<table>
																				<tr>
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
																				<tr style="text-align:center;">
																					<td style="width:95%;font-family:arial;padding-top:0px;padding-bottom:10px;padding-right:10px;border-collapse:collapse;text-align:justify">
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
															</div>';

									//$message = 'test';
									// Configure email library
									$config['protocol'] = 'smtp';
									$config['smtp_host'] = 'ssl://smtp.googlemail.com';
									$config['smtp_port'] = 465;
									$config['smtp_user'] = $sender_email;
									$config['smtp_pass'] = $user_password;
									$config['mailtype'] = 'html';
									$config['charset'] = 'iso-8859-1';


									// Load email library and passing configured values to email library
									$this->load->library('email', $config);
									$this->email->set_newline("\r\n");
									// Sender email address
									$this->email->from($sender_email, $username);
									// Receiver email address
									$this->email->to($map->Account_Email);
									$this->email->cc('it.mis@goc.co.id');
									// Subject of email
									$this->email->subject($subject);
									// Message in email
									$this->email->message($message);
									// Action Sending Mesage
									$send_user = $this->email->send();
									if($send_user == true){
										//update status menjadi 2 jika berhasil terkirim
										$id_status2 = $cus;
										$update_status2['MDG_Status'] = '2';

										$update_stts2 = $this->model_app->update_data('Ms_Customer_MDG', 'MDG_Customer_ID', $id_status2, $update_status2);
										if($update_stts2){
											$query_log = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
											foreach($query_log->result() as $acc1){
												$update_data_log['Account_Name'] = $acc1->Account_First_Name.' '.$acc1->Account_Last_Name;
											}

											$update_data_log['MDG_Type'] = 'Customer';
											$update_data_log['MDG_Category'] = 'Request';
											$update_data_log['MDG_ID'] = $cus;
											$update_data_log['Information'] = 'Request Data Customer send to mail '.$map->Account_Email;
											$update_data_log['Posting_Date'] = date('Y-m-d H:i:s');
											$update_data_log['Account_ID'] = $this->session->userdata('account_id');
											$update_data_log['Log_Status'] = 'Send Mail';

											$insert_send_mail = $this->model_app->insert_data('MDG_Log', $update_data_log);
											if($insert_send_mail){
												$outbox['OutboxMDG_ID'] = $this->model_app->getMaxKode('NewOutbox', 'OutboxMDG_ID', 'OTBX');
												$outbox['OutboxMDG_To'] = $map->Account_Email;
												$outbox['OutboxMDG_From_Account'] = $this->session->userdata('account_id');
												$outbox['OutboxMDG_To_Account'] = $map->Mapping_approval_person;
												$outbox['OutboxMDG_Subject'] = $subject;
												$outbox['OutboxMDG_ShortText'] = substr("Hi, ".$map->Account_First_Name.' '.$map->Account_Last_Name." We have received request form (Master Data Customer). Now you can look at the bottom for link form master data customer, Please visit here.",0,90);
												$outbox['OutboxMDG_Send'] = $update_data_log['Posting_Date'];
												$outbox['OutboxMDG_Link'] = 'index.php/request/outbox/customer/'.$cus;
												$outbox['OutboxType'] = 'Request';
												$outbox['MDG_ID'] = $cus;
												$outbox['LOG_ID'] = $req_log['LOG_ID'];
												$outbox['OutboxMDG_Status'] = 0;
												$insert_outbox = $this->model_app->insert_data('NewOutbox', $outbox);


												$inbox['InboxMDG_ID'] = $this->model_app->getMaxKode('NewInbox', 'InboxMDG_ID', 'INBX');
												$inbox['InboxMDG_From'] = $map->Account_Email;
												$inbox['InboxMDG_From_Account'] = $this->session->userdata('account_id');
												$inbox['InboxMDG_To_Account'] = $map->Mapping_approval_person;
												$inbox['InboxMDG_Subject'] = $subject;
												$inbox['InboxMDG_ShortText'] = substr("Hi, ".$map->Account_First_Name.' '.$map->Account_Last_Name." We have received request form (Master Data Customer). Now you can look at the bottom for link form master data customer, Please visit here.",0,90);
												$inbox['InboxMDG_Arrived'] = $update_data_log['Posting_Date'];
												$inbox['InboxMDG_Link'] = 'index.php/request/inbox/customer/'.$cus;
												$inbox['InboxType'] = 'Request';
												$inbox['MDG_ID'] = $cus;
												$inbox['LOG_ID'] = $req_log['LOG_ID'];
												$inbox['InboxMDG_Status'] = 0;
												$insert_inbox = $this->model_app->insert_data('NewInbox', $inbox);


												$newupdate['Account_ID'] = $this->session->userdata('account_id');
												$newupdate['Account_To'] = $map->Mapping_approval_person;
												$newupdate['New_ActyDt'] = date('Y-m-d H:i:s');
												$newupdate['New_Type'] = 'Request';
												$newupdate['MDG_ID'] = $cus;
												$newupdate['LOG_ID'] = $req_log['LOG_ID'];
												$newupdate['New_Description'] = "Request Master Customer ".$cus;
												$newupdate['New_Link'] = 'index.php/request/new/customer/'.$cus;
												$newupdate['New_Status'] = 0;
												$insert_newupdate = $this->model_app->insert_data('NewUpdate', $newupdate);

												if($insert_outbox){
													if($insert_inbox){
														if($insert_newupdate){
															$data = array(
																'status' => 'success',
																'id' => $cus
															);
															//echo json_encode($data);
														}

														else{
															$data = array(
																'status' => 'gagal',
																'id' => $data['MDG_Customer_ID']
															);
															//echo json_encode($data);
														}
													}

													else{
														$data = array(
															'status' => 'gagal2',
															'id' => $data['MDG_Customer_ID']
														);
														//echo json_encode($data);
													}
												}

												else{
													$data = array(
														'status' => 'gagal3',
														'id' => $data['MDG_Customer_ID']
													);
													//echo json_encode($data);
												}

											}else{
												$data = array(
													'status' => 'faillogsend',
													'id' => $cus
												);
												//echo json_encode($data);
											}
										}else{
											$data = array(
												'status' => 'failstatus2',
												'id' => $cus
											);
											//echo json_encode($data);
										}
									}else{
										$data = array(
											'status' => 'failsend',
											'id' => $cus
										);
										//echo json_encode($data);
									}
								}
								echo json_encode($data);
							}else{
								$data = array(
									'status' => 'faillogupdate',
									'id' => $cus
								);
								echo json_encode($data);
							}
						}
					}else{
						$data = array(
							'status' => 'refresh'
						);
						echo json_encode($data);
					}
					//------------------------------------------
				}
			}else{
				if($this->input->post('id') == ''){
					$cus = '';
					$data['MDG_Title'] = $this->input->post('title'); //m
					$data['MDG_CustomerName'] = $this->input->post('name'); //m
					$data['MDG_CustomerType_ID'] = $this->input->post('type'); //m
					$data['MDG_SearchTerm'] = $this->input->post('searchterm');
					$data['MDG_Address1'] = $this->input->post('address1'); //m
					$data['MDG_Address2'] = $this->input->post('address2');
					$data['MDG_Address3'] = $this->input->post('address3');
					$data['MDG_HouseNo'] = $this->input->post('houseno'); //m
					$data['CustomerCity_ID'] = $this->input->post('city'); //m
					$data['MDG_PostalCode'] = $this->input->post('postal');
					$data['CustomerProvince_ID'] = $this->input->post('province'); //m
					$data['MDG_Country'] = $this->input->post('country'); //m
					$data['MDG_Phone'] = $this->input->post('phone');
					$data['MDG_Mobile'] = $this->input->post('mobile');
					$data['MDG_NPWP'] = $this->input->post('npwp'); //m
					$data['MDG_PPN'] = $this->input->post('ppn'); //m
					$data['MDG_BankKey'] = $this->input->post('bankkey');
					$data['MDG_AccountNo'] = $this->input->post('accountno');
					$data['MDG_AccountName'] = $this->input->post('accountname');
					$data['MDG_SameBill'] = $this->input->post('sambill');
					$data['PaymentTerm_ID'] = $this->input->post('paymentterm'); //m

					$data['MDG_Customer_ID'] = $this->model_app->getMaxKode('Ms_Customer_MDG', 'MDG_Customer_ID', 'MDG-CST');
					$cus = $data['MDG_Customer_ID'];
					$data['MDG_CreateDt'] = date('Y-m-d H:i:s');
					$data['MDG_Status'] = 1;
					$data['Account_ID'] = $this->session->userdata('account_id');

					//--------------------------------------------------------------------------------------------------------------------//
					//LOG MDG CUSTOMER Request
					//--------------------------------------------------------------------------------------------------------------------//
					$req_log['MDG_Title'] = $this->input->post('title'); //m
					$req_log['MDG_CustomerName'] = $this->input->post('name'); //m
					$req_log['MDG_CustomerType_ID'] = $this->input->post('type'); //m
					$req_log['MDG_SearchTerm'] = $this->input->post('searchterm');
					$req_log['MDG_Address1'] = $this->input->post('address1'); //m
					$req_log['MDG_Address2'] = $this->input->post('address2');
					$req_log['MDG_Address3'] = $this->input->post('address3');
					$req_log['MDG_HouseNo'] = $this->input->post('houseno'); //m
					$req_log['CustomerCity_ID'] = $this->input->post('city'); //m
					$req_log['MDG_PostalCode'] = $this->input->post('postal');
					$req_log['CustomerProvince_ID'] = $this->input->post('province'); //m
					$req_log['MDG_Country'] = $this->input->post('country'); //m
					$req_log['MDG_Phone'] = $this->input->post('phone');
					$req_log['MDG_Mobile'] = $this->input->post('mobile');
					$req_log['MDG_NPWP'] = $this->input->post('npwp'); //m
					$req_log['MDG_PPN'] = $this->input->post('ppn'); //m
					$req_log['MDG_BankKey'] = $this->input->post('bankkey');
					$req_log['MDG_AccountNo'] = $this->input->post('accountno');
					$req_log['MDG_AccountName'] = $this->input->post('accountname');
					$req_log['MDG_SameBill'] = $this->input->post('sambill');
					$req_log['PaymentTerm_ID'] = $this->input->post('paymentterm');
					$req_log['LOG_ID'] = $this->model_app->getMaxKode('Ms_Customer_MDG_Log', 'LOG_ID', 'LOG-CST');
					$req_log['MDG_Customer_ID'] = $data['MDG_Customer_ID'];
					$req_log['MDG_CreateDt'] = date('Y-m-d H:i:s');
					$req_log['MDG_Status'] = 1;
					$req_log['Account_ID'] = $this->session->userdata('account_id');

					$query = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
					foreach($query->result() as $acc){
						$data1['Account_Name'] = $acc->Account_First_Name.' '.$acc->Account_Last_Name;
					}

					$data1['MDG_Type'] = 'Customer';
					$data1['MDG_Category'] = 'Request';
					$data1['MDG_ID'] = $data['MDG_Customer_ID'];
					$data1['Information'] = 'Request Data Customer (Send for approval)';
					$data1['Posting_Date'] = date('Y-m-d H:i:s');
					$data1['Account_ID'] = $this->session->userdata('account_id');
					$data1['Log_Status'] = 'Created (to Send)';

					$insert = $this->model_app->insert_data('Ms_Customer_MDG', $data);
					$insert1 = $this->model_app->insert_data('MDG_Log', $data1);
					$insert_req_log = $this->model_app->insert_data('Ms_Customer_MDG_Log', $req_log);
					if(!$insert){
						$data = array(
							'status' => 'fail'
						);
						echo json_encode($data);
					}else{
						if($insert1){
							//send approval to approver
							$query_mapping = $this->db->query("select * from Ms_Mapping AS m inner join Ms_Account as a on m.Mapping_approval_person = a.Account_ID inner join Ms_Structure_Organization as o on a.SO_ID = o.SO_ID where m.Account_ID = '".$this->session->userdata('account_id')."'");
							foreach($query_mapping->result() as $map){
								$username = 'mailer.goc';
								$sender_email = 'mailer.goc@gmail.com';
								$user_password = 'gl0ria0rigitac0smetic';
								$subject = 'MDG Application | Approval Master Data Customer';

								$message = '<div style="background-color:#f9f9f9;font-family:Helvetica,Arial,sans-serif;">
														<table style="margin:1% 5%;background-color:#fff;border-collapse:collapse;width:90%;border:none;">
															<tbody>
																<tr style="background-image:url(http://purbasari.com/assets/background-flat.jpg);background-size:cover;">
																	<td style="width:100%;padding:0px;" colspan="2">
																		<table style="width:100%;height:300px;background-color:#000;opacity:0.5">
																			<tr>
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
																			<tr>
																				<td>
																					<div style="margin-left:10px;color:#999;">
																					<p>Hi, '.$map->Account_First_Name.' '.$map->Account_Last_Name.',</p>
																					<p>We have received approval form (Master Data Customer).<br/>Now you can look at the bottom for link form master data customer, Please visit here.</p>
																						<p>
																							Link (Approve):	'.base_url().'index.php/request/approval_master_customer/'.$cus.'/'.$map->Mapping_approval_person.'<br/>
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
																	<td style="width:100%;padding:10px 0px;" colspan="2">
																		<table>
																			<tr>
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
																			<tr style="text-align:center;">
																				<td style="width:95%;font-family:arial;padding-top:0px;padding-bottom:10px;padding-right:10px;border-collapse:collapse;text-align:justify">
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
														</div>';

								//$message = 'test';
								// Configure email library
								$config['protocol'] = 'smtp';
								$config['smtp_host'] = 'ssl://smtp.googlemail.com';
								$config['smtp_port'] = 465;
								$config['smtp_user'] = $sender_email;
								$config['smtp_pass'] = $user_password;
								$config['mailtype'] = 'html';
								$config['charset'] = 'iso-8859-1';


								// Load email library and passing configured values to email library
								$this->load->library('email', $config);
								$this->email->set_newline("\r\n");
								// Sender email address
								$this->email->from($sender_email, $username);
								// Receiver email address
								$this->email->to($map->Account_Email);
								$this->email->cc('it.mis@goc.co.id');
								// Subject of email
								$this->email->subject($subject);
								// Message in email
								$this->email->message($message);
								// Action Sending Mesage
								$send_user = $this->email->send();
								if($send_user == true){
									//update status menjadi 2 jika berhasil terkirim
									$id_status2 = $cus;
									$update_status2['MDG_Status'] = '2';

									$update_stts2 = $this->model_app->update_data('Ms_Customer_MDG', 'MDG_Customer_ID', $id_status2, $update_status2);
									if($update_stts2){
										$query_log = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
										foreach($query_log->result() as $acc1){
											$update_data_log['Account_Name'] = $acc1->Account_First_Name.' '.$acc1->Account_Last_Name;
										}

										$update_data_log['MDG_Type'] = 'Customer';
										$update_data_log['MDG_Category'] = 'Request';
										$update_data_log['MDG_ID'] = $cus;
										$update_data_log['Information'] = 'Request Data Customer send to mail '.$map->Account_Email;
										$update_data_log['Posting_Date'] = date('Y-m-d H:i:s');
										$update_data_log['Account_ID'] = $this->session->userdata('account_id');
										$update_data_log['Log_Status'] = 'Send Mail';

										$insert_send_mail = $this->model_app->insert_data('MDG_Log', $update_data_log);
										if($insert_send_mail){
											$outbox['OutboxMDG_ID'] = $this->model_app->getMaxKode('NewOutbox', 'OutboxMDG_ID', 'OTBX');
											$outbox['OutboxMDG_To'] = $map->Account_Email;
											$outbox['OutboxMDG_From_Account'] = $this->session->userdata('account_id');
											$outbox['OutboxMDG_To_Account'] = $map->Mapping_approval_person;
											$outbox['OutboxMDG_Subject'] = $subject;
											$outbox['OutboxMDG_ShortText'] = substr("Hi, ".$map->Account_First_Name.' '.$map->Account_Last_Name." We have received request form (Master Data Customer). Now you can look at the bottom for link form master data customer, Please visit here.",0,90);
											$outbox['OutboxMDG_Send'] = $update_data_log['Posting_Date'];
											$outbox['OutboxMDG_Link'] = 'index.php/request/outbox/customer/'.$cus;
											$outbox['OutboxType'] = 'Request';
											$outbox['MDG_ID'] = $cus;
											$outbox['LOG_ID'] = $req_log['LOG_ID'];
											$outbox['OutboxMDG_Status'] = 0;
											$insert_outbox = $this->model_app->insert_data('NewOutbox', $outbox);


											$inbox['InboxMDG_ID'] = $this->model_app->getMaxKode('NewInbox', 'InboxMDG_ID', 'INBX');
											$inbox['InboxMDG_From'] = $map->Account_Email;
											$inbox['InboxMDG_From_Account'] = $this->session->userdata('account_id');
											$inbox['InboxMDG_To_Account'] = $map->Mapping_approval_person;
											$inbox['InboxMDG_Subject'] = $subject;
											$inbox['InboxMDG_ShortText'] = substr("Hi, ".$map->Account_First_Name.' '.$map->Account_Last_Name." We have received request form (Master Data Customer). Now you can look at the bottom for link form master data customer, Please visit here.",0,90);
											$inbox['InboxMDG_Arrived'] = $update_data_log['Posting_Date'];
											$inbox['InboxMDG_Link'] = 'index.php/request/inbox/customer/'.$cus;
											$inbox['InboxType'] = 'Request';
											$inbox['MDG_ID'] = $cus;
											$inbox['LOG_ID'] = $req_log['LOG_ID'];
											$inbox['InboxMDG_Status'] = 0;
											$insert_inbox = $this->model_app->insert_data('NewInbox', $inbox);


											$newupdate['Account_ID'] = $this->session->userdata('account_id');
											$newupdate['Account_To'] = $map->Mapping_approval_person;
											$newupdate['New_ActyDt'] = date('Y-m-d H:i:s');
											$newupdate['New_Type'] = 'Request';
											$newupdate['MDG_ID'] = $cus;
											$newupdate['LOG_ID'] = $req_log['LOG_ID'];
											$newupdate['New_Description'] = "Request Master Customer ".$cus;
											$newupdate['New_Link'] = 'index.php/request/new/customer/'.$cus;
											$newupdate['New_Status'] = 0;
											$insert_newupdate = $this->model_app->insert_data('NewUpdate', $newupdate);

											if($insert_outbox){
												if($insert_inbox){
													if($insert_newupdate){
														$data = array(
															'status' => 'success',
															'id' => $cus
														);
														//echo json_encode($data);
													}

													else{
														$data = array(
															'status' => 'gagal',
															'id' => $data['MDG_Customer_ID']
														);
														//echo json_encode($data);
													}
												}

												else{
													$data = array(
														'status' => 'gagal2',
														'id' => $data['MDG_Customer_ID']
													);
													//echo json_encode($data);
												}
											}

											else{
												$data = array(
													'status' => 'gagal3',
													'id' => $data['MDG_Customer_ID']
												);
												//echo json_encode($data);
											}

										}else{
											$data = array(
												'status' => 'faillogsend',
												'id' => $cus
											);
											//echo json_encode($data);
										}
									}else{
										$data = array(
											'status' => 'failstatus2',
											'id' => $cus
										);
										//echo json_encode($data);
									}
								}else{
									$data = array(
										'status' => 'failsend',
										'id' => $cus
									);
									//echo json_encode($data);
								}
							}
							echo json_encode($data);
						}else{
							$data = array(
								'status' => 'faillogupdate',
								'id' => $cus
							);
							echo json_encode($data);
						}
					}
				}else{
					$data = array(
						'status' => 'refresh'
					);
					echo json_encode($data);
				}
			}
		}


		//tolong periksa
		function get_send_again_vendor(){
			date_default_timezone_set('Asia/Jakarta');
			if($this->input->post('title') == '' or $this->input->post('name') == '' or $this->input->post('type') == '' or $this->input->post('address1') == '' or $this->input->post('houseno') == '' or
			$this->input->post('city') == '' or $this->input->post('province') == '' or $this->input->post('country') == '' or $this->input->post('npwp') == '' or $this->input->post('ppn') == '' or
			$this->input->post('paymentterm') == ''){
				$data = array(
					'status' => 'require'
				);
				echo json_encode($data);
			}else{
				if($this->input->post('id') != ''){
					$ven = '';
					$data['MDG_Title'] = $this->input->post('title'); //m
					$data['MDG_VendorName'] = $this->input->post('name'); //m
					$data['MDG_VendorType_ID'] = $this->input->post('type'); //m
					$data['MDG_SearchTerm'] = $this->input->post('searchterm');
					$data['MDG_Address1'] = $this->input->post('address1'); //m
					$data['MDG_Address2'] = $this->input->post('address2');
					$data['MDG_Address3'] = $this->input->post('address3');
					$data['MDG_HouseNo'] = $this->input->post('houseno'); //m
					$data['MDG_City'] = $this->input->post('city'); //m
					$data['MDG_PostalCode'] = $this->input->post('postal');
					$data['VendorProvince_ID'] = $this->input->post('province'); //m
					$data['MDG_Country'] = $this->input->post('country'); //m
					$data['MDG_Phone'] = $this->input->post('phone');
					$data['MDG_Mobile'] = $this->input->post('mobile');
					$data['MDG_NPWP'] = $this->input->post('npwp'); //m
					$data['MDG_PPN'] = $this->input->post('ppn'); //m
					$data['MDG_BankKey'] = $this->input->post('bankkey');
					$data['MDG_AccountNo'] = $this->input->post('accountno');
					$data['MDG_AccountName'] = $this->input->post('accountname');
					$data['MDG_PaymentTerm'] = $this->input->post('paymentterm'); //m

					$id_mdg_vendor = $this->input->post('id');
					$ven = $id_mdg_vendor;
					$data['MDG_UpdateDt'] = date('Y-m-d H:i:s');
					$data['MDG_Status'] = 1;
					$data['Account_ID'] = $this->session->userdata('account_id');

					//-------------------------------------------------------------------------------------
					// LOG MDG VENDOR Request
					//-------------------------------------------------------------------------------------

					$req_log['MDG_Title'] = $this->input->post('title'); //m
					$req_log['MDG_VendorName'] = $this->input->post('name'); //m
					$req_log['MDG_VendorType_ID'] = $this->input->post('type'); //m
					$req_log['MDG_SearchTerm'] = $this->input->post('searchterm');
					$req_log['MDG_Address1'] = $this->input->post('address1'); //m
					$req_log['MDG_Address2'] = $this->input->post('address2');
					$req_log['MDG_Address3'] = $this->input->post('address3');
					$req_log['MDG_HouseNo'] = $this->input->post('houseno'); //m
					$req_log['MDG_City'] = $this->input->post('city'); //m
					$req_log['MDG_PostalCode'] = $this->input->post('postal');
					$req_log['VendorProvince_ID'] = $this->input->post('province'); //m
					$req_log['MDG_Country'] = $this->input->post('country'); //m
					$req_log['MDG_Phone'] = $this->input->post('phone');
					$req_log['MDG_Mobile'] = $this->input->post('mobile');
					$req_log['MDG_NPWP'] = $this->input->post('npwp'); //m
					$req_log['MDG_PPN'] = $this->input->post('ppn'); //m
					$req_log['MDG_BankKey'] = $this->input->post('bankkey');
					$req_log['MDG_AccountNo'] = $this->input->post('accountno');
					$req_log['MDG_AccountName'] = $this->input->post('accountname');
					$req_log['MDG_PaymentTerm'] = $this->input->post('paymentterm'); //m
					$req_log['LOG_ID'] = $this->model_app->getMaxKode('Ms_Vendor_MDG_Log', 'LOG_ID', 'LOG-VNR');
					$req_log['MDG_Vendor_ID'] = $this->input->post('id');
					$req_log['MDG_UpdateDt'] = date('Y-m-d H:i:s');
					$req_log['MDG_Status'] = 1;
					$req_log['Account_ID'] = $this->session->userdata('account_id');

					$query = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
					foreach($query->result() as $acc){
						$data1['Account_Name'] = $acc->Account_First_Name.' '.$acc->Account_Last_Name;
					}

					$data1['MDG_Type'] = 'Vendor';
					$data1['MDG_Category'] = 'Request';
					$data1['MDG_ID'] = $ven;
					$data1['Information'] = 'Request Data Vendor (Send for approval)';
					$data1['Posting_Date'] = date('Y-m-d H:i:s');
					$data1['Account_ID'] = $this->session->userdata('account_id');
					$data1['Log_Status'] = 'Created (to Send)';

					$cek_approval = $this->db->query("select * from Ms_Vendor_MDG where MDG_Vendor_ID = '".$ven."' and (MDG_Status > 3 or MDG_Status = 1)");
					if($cek_approval->num_rows() == 0){
						$data = array(
							'status' => 'tryagain'
						);
						echo json_encode($data);
					}else{
						$cek_account_same = $this->db->query("select * from Ms_Vendor_MDG where MDG_Vendor_ID='".$ven."' and Account_ID='".$this->session->userdata('account_id')."'");
						if($cek_account_same->num_rows() == 0){
							$data = array(
								'status' => 'accountnot'
							);
							echo json_encode($data);
						}else{
							$update = $this->model_app->update_data('Ms_Vendor_MDG', 'MDG_Vendor_ID', $id_mdg_vendor, $data);
							$insert1 = $this->model_app->insert_data('MDG_Log', $data1);
							$insert_req_log = $this->model_app->insert_data('Ms_Vendor_MDG_Log', $req_log);
							if(!$update){
								$data = array(
									'status' => 'fail'
								);
								echo json_encode($data);
							}else{
								if($insert1){
									//send approval to approver
									$query_mapping = $this->db->query("select * from Ms_Mapping AS m inner join Ms_Account as a on m.Mapping_approval_person = a.Account_ID inner join Ms_Structure_Organization as o on a.SO_ID = o.SO_ID where m.Account_ID = '".$this->session->userdata('account_id')."'");
									foreach($query_mapping->result() as $map){
										$username = 'mailer.goc';
										$sender_email = 'mailer.goc@gmail.com';
										$user_password = 'gl0ria0rigitac0smetic';
										$subject = 'MDG Application | Approval Master Data Vendor';

										$message = '<div style="background-color:#f9f9f9;font-family:Helvetica,Arial,sans-serif;">
																<table style="margin:1% 5%;background-color:#fff;border-collapse:collapse;width:90%;border:none;">
																	<tbody>
																		<tr style="background-image:url(http://purbasari.com/assets/background-flat.jpg);background-size:cover;">
																			<td style="width:100%;padding:0px;" colspan="2">
																				<table style="width:100%;height:300px;background-color:#000;opacity:0.5">
																					<tr>
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
																					<tr>
																						<td>
																							<div style="margin-left:10px;color:#999;">
																							<p>Hi, '.$map->Account_First_Name.' '.$map->Account_Last_Name.',</p>
																							<p>We have received approval form (Master Data Vendor).<br/>Now you can look at the bottom for link form master data vendor, Please visit here.</p>
																								<p>
																									Link (Approve):	'.base_url().'index.php/request/approval_master_vendor/'.$ven.'/'.$map->Mapping_approval_person.'<br/>
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
																			<td style="width:100%;padding:10px 0px;" colspan="2">
																				<table>
																					<tr>
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
																					<tr style="text-align:center;">
																						<td style="width:95%;font-family:arial;padding-top:0px;padding-bottom:10px;padding-right:10px;border-collapse:collapse;text-align:justify">
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
																</div>';

										//$message = 'test';
										// Configure email library
										$config['protocol'] = 'smtp';
										$config['smtp_host'] = 'ssl://smtp.googlemail.com';
										$config['smtp_port'] = 465;
										$config['smtp_user'] = $sender_email;
										$config['smtp_pass'] = $user_password;
										$config['mailtype'] = 'html';
										$config['charset'] = 'iso-8859-1';


										// Load email library and passing configured values to email library
										$this->load->library('email', $config);
										$this->email->set_newline("\r\n");
										// Sender email address
										$this->email->from($sender_email, $username);
										// Receiver email address
										$this->email->to($map->Account_Email);
										$this->email->cc('it.mis@goc.co.id');
										// Subject of email
										$this->email->subject($subject);
										// Message in email
										$this->email->message($message);
										// Action Sending Mesage
										$send_user = $this->email->send();
										if($send_user == true){

											$id_status2 = $ven;
											$update_status2['MDG_Status'] = '2';

											$update_stts2 = $this->model_app->update_data('Ms_Vendor_MDG', 'MDG_Vendor_ID', $id_status2, $update_status2);

											if($update_stts2){
												$query_log = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
												foreach($query_log->result() as $acc1){
													$update_data_log['Account_Name'] = $acc1->Account_First_Name.' '.$acc1->Account_Last_Name;
												}

												$update_data_log['MDG_Type'] = 'Vendor';
												$update_data_log['MDG_Category'] = 'Request';
												$update_data_log['MDG_ID'] = $ven;
												$update_data_log['Information'] = 'Request Data Vendor send to mail '.$map->Account_Email;
												$update_data_log['Posting_Date'] = date('Y-m-d H:i:s');
												$update_data_log['Account_ID'] = $this->session->userdata('account_id');
												$update_data_log['Log_Status'] = 'Send Mail';

												$insert_send_mail = $this->model_app->insert_data('MDG_Log', $update_data_log);
												if($insert_send_mail){
													$outbox['OutboxMDG_ID'] = $this->model_app->getMaxKode('NewOutbox', 'OutboxMDG_ID', 'OTBX');
													$outbox['OutboxMDG_To'] = $map->Account_Email;
													$outbox['OutboxMDG_From_Account'] = $this->session->userdata('account_id');
													$outbox['OutboxMDG_To_Account'] = $map->Mapping_approval_person;
													$outbox['OutboxMDG_Subject'] = $subject;
													$outbox['OutboxMDG_ShortText'] = "Hi, ".$map->Account_First_Name.' '.$map->Account_Last_Name." We have received request form (Master Data Vendor). Now you can look at the bottom for link form master data vendor, Please visit here.";
													$outbox['OutboxMDG_Send'] = $update_data_log['Posting_Date'];
													$outbox['OutboxMDG_Link'] = 'index.php/request/outbox/vendor/'.$ven;
													$outbox['OutboxType'] = 'Request';
													$outbox['MDG_ID'] = $ven;
													$outbox['LOG_ID'] = $req_log['LOG_ID'];
													$outbox['OutboxMDG_Status'] = 0;
													$insert_outbox = $this->model_app->insert_data('NewOutbox', $outbox);


													$inbox['InboxMDG_ID'] = $this->model_app->getMaxKode('NewInbox', 'InboxMDG_ID', 'INBX');
													$inbox['InboxMDG_From'] = $map->Account_Email;
													$inbox['InboxMDG_From_Account'] = $this->session->userdata('account_id');
													$inbox['InboxMDG_To_Account'] = $map->Mapping_approval_person;
													$inbox['InboxMDG_Subject'] = $subject;
													$inbox['InboxMDG_ShortText'] = "Hi, ".$map->Account_First_Name.' '.$map->Account_Last_Name." We have received request form (Master Data Vendor). Now you can look at the bottom for link form master data vendor, Please visit here.";
													$inbox['InboxMDG_Arrived'] = $update_data_log['Posting_Date'];
													$inbox['InboxMDG_Link'] = 'index.php/request/inbox/vendor/'.$ven;
													$inbox['InboxType'] = 'Request';
													$inbox['MDG_ID'] = $ven;
													$inbox['LOG_ID'] = $req_log['LOG_ID'];
													$inbox['InboxMDG_Status'] = 0;
													$insert_inbox = $this->model_app->insert_data('NewInbox', $inbox);


													$newupdate['Account_ID'] = $this->session->userdata('account_id');
													$newupdate['Account_To'] = $map->Mapping_approval_person;
													$newupdate['New_ActyDt'] = date('Y-m-d H:i:s');
													$newupdate['New_Type'] = 'Request';
													$newupdate['MDG_ID'] = $ven;
													$newupdate['LOG_ID'] = $req_log['LOG_ID'];
													$newupdate['New_Description'] = "Request Master Vendor ".$ven;
													$newupdate['New_Link'] = 'index.php/request/new/vendor/'.$ven;
													$newupdate['New_Status'] = 0;
													$insert_newupdate = $this->model_app->insert_data('NewUpdate', $newupdate);

													if($insert_outbox){
														if($insert_inbox){
															if($insert_newupdate){
																$data = array(
																	'status' => 'success',
																	'id' => $ven
																);
																//echo json_encode($data);
															}

															else{
																$data = array(
																	'status' => 'gagal',
																	'id' => $ven
																);
																//echo json_encode($data);
															}
														}

														else{
															$data = array(
																'status' => 'gagal2',
																'id' => $ven
															);
															//echo json_encode($data);
														}
													}

													else{
														$data = array(
															'status' => 'gagal3',
															'id' => $ven
														);
														//echo json_encode($data);
													}

												}else{
													$data = array(
														'status' => 'faillogsend',
														'id' => $ven
													);
													//echo json_encode($data);
												}
											}else{
												$data = array(
													'status' => 'failstatus2',
													'id' => $ven
												);
												//echo json_encode($data);
											}
										}else{
											$data = array(
												'status' => 'failsend',
												'id' => $ven
											);
											//echo json_encode($data);
										}
									}
									echo json_encode($data);
								}else{
									$data = array(
										'status' => 'faillogupdate',
										'id' => $ven
									);
									echo json_encode($data);
								}
							}
						}
					}
				}else{
					$data = array(
						'status' => 'refresh'
					);
					echo json_encode($data);
				}
			}
		}

		function get_send_again_customer(){
			date_default_timezone_set('Asia/Jakarta');
			if($this->input->post('title') == '' or $this->input->post('name') == '' or $this->input->post('type') == '' or $this->input->post('address1') == '' or $this->input->post('houseno') == '' or
			$this->input->post('city') == '' or $this->input->post('province') == '' or $this->input->post('country') == '' or $this->input->post('npwp') == '' or $this->input->post('ppn') == '' or
			$this->input->post('paymentterm') == '' or $this->input->post('sambill') == ''){
				$data = array(
					'status' => 'require'
				);
				echo json_encode($data);
			}else{
				if($this->input->post('sambill') == 'No'){
					if($this->input->post('billtoparty') == ''){
						$data = array(
							'status' => 'require'
						);
						echo json_encode($data);
					}else{
						if($this->input->post('id') != ''){
							$cus = '';
							$data['MDG_Title'] = $this->input->post('title'); //m
							$data['MDG_CustomerName'] = $this->input->post('name'); //m
							$data['MDG_CustomerType_ID'] = $this->input->post('type'); //m
							$data['MDG_SearchTerm'] = $this->input->post('searchterm');
							$data['MDG_Address1'] = $this->input->post('address1'); //m
							$data['MDG_Address2'] = $this->input->post('address2');
							$data['MDG_Address3'] = $this->input->post('address3');
							$data['MDG_HouseNo'] = $this->input->post('houseno'); //m
							$data['CustomerCity_ID'] = $this->input->post('city');
							$data['MDG_PostalCode'] = $this->input->post('postal');
							$data['CustomerProvince_ID'] = $this->input->post('province'); //m
							$data['MDG_Country'] = $this->input->post('country'); //m
							$data['MDG_Phone'] = $this->input->post('phone');
							$data['MDG_Mobile'] = $this->input->post('mobile');
							$data['MDG_NPWP'] = $this->input->post('npwp'); //m
							$data['MDG_PPN'] = $this->input->post('ppn'); //m
							$data['MDG_BankKey'] = $this->input->post('bankkey');
							$data['MDG_AccountNo'] = $this->input->post('accountno');
							$data['MDG_AccountName'] = $this->input->post('accountname');
							$data['MDG_SameBill'] = $this->input->post('sambill');
							$data['PaymentTerm_ID'] = $this->input->post('paymentterm');

							$id_mdg_customer = $this->input->post('id');
							$cus = $id_mdg_customer;
							$data['MDG_UpdateDt'] = date('Y-m-d H:i:s');
							$data['MDG_Status'] = 1;
							$data['Account_ID'] = $this->session->userdata('account_id');

							//-------------------------------------------------------------------------------------
							// LOG MDG VENDOR Request
							//-------------------------------------------------------------------------------------

							$req_log['MDG_Title'] = $this->input->post('title'); //m
							$req_log['MDG_CustomerName'] = $this->input->post('name'); //m
							$req_log['MDG_CustomerType_ID'] = $this->input->post('type'); //m
							$req_log['MDG_SearchTerm'] = $this->input->post('searchterm');
							$req_log['MDG_Address1'] = $this->input->post('address1'); //m
							$req_log['MDG_Address2'] = $this->input->post('address2');
							$req_log['MDG_Address3'] = $this->input->post('address3');
							$req_log['MDG_HouseNo'] = $this->input->post('houseno'); //m
							$req_log['CustomerCity_ID'] = $this->input->post('city'); //m
							$req_log['MDG_PostalCode'] = $this->input->post('postal');
							$req_log['CustomerProvince_ID'] = $this->input->post('province'); //m
							$req_log['MDG_Country'] = $this->input->post('country'); //m
							$req_log['MDG_Phone'] = $this->input->post('phone');
							$req_log['MDG_Mobile'] = $this->input->post('mobile');
							$req_log['MDG_NPWP'] = $this->input->post('npwp'); //m
							$req_log['MDG_PPN'] = $this->input->post('ppn'); //m
							$req_log['MDG_BankKey'] = $this->input->post('bankkey');
							$req_log['MDG_AccountNo'] = $this->input->post('accountno');
							$req_log['MDG_AccountName'] = $this->input->post('accountname');
							$req_log['PaymentTerm_ID'] = $this->input->post('paymentterm');
							$req_log['LOG_ID'] = $this->model_app->getMaxKode('Ms_Customer_MDG_Log', 'LOG_ID', 'LOG-CST');
							$req_log['MDG_Customer_ID'] = $this->input->post('id');
							$req_log['MDG_UpdateDt'] = date('Y-m-d H:i:s');
							$req_log['MDG_Status'] = 1;
							$req_log['MDG_SameBill'] = $this->input->post('sambill');
							$req_log['Account_ID'] = $this->session->userdata('account_id');

							$query = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
							foreach($query->result() as $acc){
								$data1['Account_Name'] = $acc->Account_First_Name.' '.$acc->Account_Last_Name;
							}

							$data1['MDG_Type'] = 'Customer';
							$data1['MDG_Category'] = 'Request';
							$data1['MDG_ID'] = $cus;
							$data1['Information'] = 'Request Data Customer (Send for approval)';
							$data1['Posting_Date'] = date('Y-m-d H:i:s');
							$data1['Account_ID'] = $this->session->userdata('account_id');
							$data1['Log_Status'] = 'Created (to Send)';

							$cek_approval = $this->db->query("select * from Ms_Customer_MDG where MDG_Customer_ID = '".$cus."' and (MDG_Status > 3 or MDG_Status = 1)");
							if($cek_approval->num_rows() == 0){
								$data = array(
									'status' => 'tryagain'
								);
								echo json_encode($data);
							}else{
								$cek_account_same = $this->db->query("select * from Ms_Customer_MDG where MDG_Customer_ID='".$cus."' and Account_ID='".$this->session->userdata('account_id')."'");
								if($cek_account_same->num_rows() == 0){
									$data = array(
										'status' => 'accountnot'
									);
									echo json_encode($data);
								}else{
									$update = $this->model_app->update_data('Ms_Customer_MDG', 'MDG_Customer_ID', $id_mdg_customer, $data);
									$insert1 = $this->model_app->insert_data('MDG_Log', $data1);
									$insert_req_log = $this->model_app->insert_data('Ms_Customer_MDG_Log', $req_log);
									if(!$update){
										$data = array(
											'status' => 'fail'
										);
										echo json_encode($data);
									}else{
										if($insert1){
											//send approval to approver
											$query_mapping = $this->db->query("select * from Ms_Mapping AS m inner join Ms_Account as a on m.Mapping_approval_person = a.Account_ID inner join Ms_Structure_Organization as o on a.SO_ID = o.SO_ID where m.Account_ID = '".$this->session->userdata('account_id')."'");
											foreach($query_mapping->result() as $map){
												$username = 'mailer.goc';
												$sender_email = 'mailer.goc@gmail.com';
												$user_password = 'gl0ria0rigitac0smetic';
												$subject = 'MDG Application | Approval Master Data Customer';

												$message = '<div style="background-color:#f9f9f9;font-family:Helvetica,Arial,sans-serif;">
																		<table style="margin:1% 5%;background-color:#fff;border-collapse:collapse;width:90%;border:none;">
																			<tbody>
																				<tr style="background-image:url(http://purbasari.com/assets/background-flat.jpg);background-size:cover;">
																					<td style="width:100%;padding:0px;" colspan="2">
																						<table style="width:100%;height:300px;background-color:#000;opacity:0.5">
																							<tr>
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
																							<tr>
																								<td>
																									<div style="margin-left:10px;color:#999;">
																									<p>Hi, '.$map->Account_First_Name.' '.$map->Account_Last_Name.',</p>
																									<p>We have received approval form (Master Data Customer).<br/>Now you can look at the bottom for link form master data customer, Please visit here.</p>
																										<p>
																											Link (Approve):	'.base_url().'index.php/request/approval_master_customer/'.$cus.'/'.$map->Mapping_approval_person.'<br/>
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
																					<td style="width:100%;padding:10px 0px;" colspan="2">
																						<table>
																							<tr>
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
																							<tr style="text-align:center;">
																								<td style="width:95%;font-family:arial;padding-top:0px;padding-bottom:10px;padding-right:10px;border-collapse:collapse;text-align:justify">
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
																		</div>';

												//$message = 'test';
												// Configure email library
												$config['protocol'] = 'smtp';
												$config['smtp_host'] = 'ssl://smtp.googlemail.com';
												$config['smtp_port'] = 465;
												$config['smtp_user'] = $sender_email;
												$config['smtp_pass'] = $user_password;
												$config['mailtype'] = 'html';
												$config['charset'] = 'iso-8859-1';


												// Load email library and passing configured values to email library
												$this->load->library('email', $config);
												$this->email->set_newline("\r\n");
												// Sender email address
												$this->email->from($sender_email, $username);
												// Receiver email address
												$this->email->to($map->Account_Email);
												$this->email->cc('it.mis@goc.co.id');
												// Subject of email
												$this->email->subject($subject);
												// Message in email
												$this->email->message($message);
												// Action Sending Mesage
												$send_user = $this->email->send();
												if($send_user == true){

													$id_status2 = $cus;
													$update_status2['MDG_Status'] = '2';

													$update_stts2 = $this->model_app->update_data('Ms_Customer_MDG', 'MDG_Customer_ID', $id_status2, $update_status2);

													if($update_stts2){
														$query_log = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
														foreach($query_log->result() as $acc1){
															$update_data_log['Account_Name'] = $acc1->Account_First_Name.' '.$acc1->Account_Last_Name;
														}

														$update_data_log['MDG_Type'] = 'Customer';
														$update_data_log['MDG_Category'] = 'Request';
														$update_data_log['MDG_ID'] = $cus;
														$update_data_log['Information'] = 'Request Data Customer send to mail '.$map->Account_Email;
														$update_data_log['Posting_Date'] = date('Y-m-d H:i:s');
														$update_data_log['Account_ID'] = $this->session->userdata('account_id');
														$update_data_log['Log_Status'] = 'Send Mail';

														$insert_send_mail = $this->model_app->insert_data('MDG_Log', $update_data_log);
														if($insert_send_mail){
															$outbox['OutboxMDG_ID'] = $this->model_app->getMaxKode('NewOutbox', 'OutboxMDG_ID', 'OTBX');
															$outbox['OutboxMDG_To'] = $map->Account_Email;
															$outbox['OutboxMDG_From_Account'] = $this->session->userdata('account_id');
															$outbox['OutboxMDG_To_Account'] = $map->Mapping_approval_person;
															$outbox['OutboxMDG_Subject'] = $subject;
															$outbox['OutboxMDG_ShortText'] = "Hi, ".$map->Account_First_Name.' '.$map->Account_Last_Name." We have received request form (Master Data Customer). Now you can look at the bottom for link form master data customer, Please visit here.";
															$outbox['OutboxMDG_Send'] = $update_data_log['Posting_Date'];
															$outbox['OutboxMDG_Link'] = 'index.php/request/outbox/customer/'.$cus;
															$outbox['OutboxType'] = 'Request';
															$outbox['MDG_ID'] = $cus;
															$outbox['LOG_ID'] = $req_log['LOG_ID'];
															$outbox['OutboxMDG_Status'] = 0;
															$insert_outbox = $this->model_app->insert_data('NewOutbox', $outbox);


															$inbox['InboxMDG_ID'] = $this->model_app->getMaxKode('NewInbox', 'InboxMDG_ID', 'INBX');
															$inbox['InboxMDG_From'] = $map->Account_Email;
															$inbox['InboxMDG_From_Account'] = $this->session->userdata('account_id');
															$inbox['InboxMDG_To_Account'] = $map->Mapping_approval_person;
															$inbox['InboxMDG_Subject'] = $subject;
															$inbox['InboxMDG_ShortText'] = "Hi, ".$map->Account_First_Name.' '.$map->Account_Last_Name." We have received request form (Master Data Customer). Now you can look at the bottom for link form master data customer, Please visit here.";
															$inbox['InboxMDG_Arrived'] = $update_data_log['Posting_Date'];
															$inbox['InboxMDG_Link'] = 'index.php/request/inbox/customer/'.$cus;
															$inbox['InboxType'] = 'Request';
															$inbox['MDG_ID'] = $cus;
															$inbox['LOG_ID'] = $req_log['LOG_ID'];
															$inbox['InboxMDG_Status'] = 0;
															$insert_inbox = $this->model_app->insert_data('NewInbox', $inbox);


															$newupdate['Account_ID'] = $this->session->userdata('account_id');
															$newupdate['Account_To'] = $map->Mapping_approval_person;
															$newupdate['New_ActyDt'] = date('Y-m-d H:i:s');
															$newupdate['New_Type'] = 'Request';
															$newupdate['MDG_ID'] = $cus;
															$newupdate['LOG_ID'] = $req_log['LOG_ID'];
															$newupdate['New_Description'] = "Request Master Customer ".$cus;
															$newupdate['New_Link'] = 'index.php/request/new/customer/'.$cus;
															$newupdate['New_Status'] = 0;
															$insert_newupdate = $this->model_app->insert_data('NewUpdate', $newupdate);

															if($insert_outbox){
																if($insert_inbox){
																	if($insert_newupdate){
																		$data = array(
																			'status' => 'success',
																			'id' => $cus
																		);
																		//echo json_encode($data);
																	}

																	else{
																		$data = array(
																			'status' => 'gagal',
																			'id' => $cus
																		);
																		//echo json_encode($data);
																	}
																}

																else{
																	$data = array(
																		'status' => 'gagal2',
																		'id' => $cus
																	);
																	//echo json_encode($data);
																}
															}

															else{
																$data = array(
																	'status' => 'gagal3',
																	'id' => $cus
																);
																//echo json_encode($data);
															}

														}else{
															$data = array(
																'status' => 'faillogsend',
																'id' => $cus
															);
															//echo json_encode($data);
														}
													}else{
														$data = array(
															'status' => 'failstatus2',
															'id' => $cus
														);
														//echo json_encode($data);
													}
												}else{
													$data = array(
														'status' => 'failsend',
														'id' => $cus
													);
													//echo json_encode($data);
												}
											}
											echo json_encode($data);
										}else{
											$data = array(
												'status' => 'faillogupdate',
												'id' => $cus
											);
											echo json_encode($data);
										}
									}
								}
							}
						}else{
							$data = array(
								'status' => 'refresh'
							);
							echo json_encode($data);
						}
					}
				}else{
					if($this->input->post('id') != ''){
						$cus = '';
						$data['MDG_Title'] = $this->input->post('title'); //m
						$data['MDG_CustomerName'] = $this->input->post('name'); //m
						$data['MDG_CustomerType_ID'] = $this->input->post('type'); //m
						$data['MDG_SearchTerm'] = $this->input->post('searchterm');
						$data['MDG_Address1'] = $this->input->post('address1'); //m
						$data['MDG_Address2'] = $this->input->post('address2');
						$data['MDG_Address3'] = $this->input->post('address3');
						$data['MDG_HouseNo'] = $this->input->post('houseno'); //m
						$data['CustomerCity_ID'] = $this->input->post('city');
						$data['MDG_PostalCode'] = $this->input->post('postal');
						$data['CustomerProvince_ID'] = $this->input->post('province'); //m
						$data['MDG_Country'] = $this->input->post('country'); //m
						$data['MDG_Phone'] = $this->input->post('phone');
						$data['MDG_Mobile'] = $this->input->post('mobile');
						$data['MDG_NPWP'] = $this->input->post('npwp'); //m
						$data['MDG_PPN'] = $this->input->post('ppn'); //m
						$data['MDG_BankKey'] = $this->input->post('bankkey');
						$data['MDG_AccountNo'] = $this->input->post('accountno');
						$data['MDG_AccountName'] = $this->input->post('accountname');
						$data['MDG_SameBill'] = $this->input->post('sambill');
						$data['MDG_Billtoparty'] = $this->input->post('billtoparty');
						$data['PaymentTerm_ID'] = $this->input->post('paymentterm');

						$id_mdg_customer = $this->input->post('id');
						$cus = $id_mdg_customer;
						$data['MDG_CreateDt'] = date('Y-m-d H:i:s');
						$data['MDG_Status'] = 1;
						$data['Account_ID'] = $this->session->userdata('account_id');

						//-------------------------------------------------------------------------------------
						// LOG MDG VENDOR Request
						//-------------------------------------------------------------------------------------

						$req_log['MDG_Title'] = $this->input->post('title'); //m
						$req_log['MDG_CustomerName'] = $this->input->post('name'); //m
						$req_log['MDG_CustomerType_ID'] = $this->input->post('type'); //m
						$req_log['MDG_SearchTerm'] = $this->input->post('searchterm');
						$req_log['MDG_Address1'] = $this->input->post('address1'); //m
						$req_log['MDG_Address2'] = $this->input->post('address2');
						$req_log['MDG_Address3'] = $this->input->post('address3');
						$req_log['MDG_HouseNo'] = $this->input->post('houseno'); //m
						$req_log['CustomerCity_ID'] = $this->input->post('city');
						$req_log['MDG_PostalCode'] = $this->input->post('postal');
						$req_log['CustomerProvince_ID'] = $this->input->post('province'); //m
						$req_log['MDG_Country'] = $this->input->post('country'); //m
						$req_log['MDG_Phone'] = $this->input->post('phone');
						$req_log['MDG_Mobile'] = $this->input->post('mobile');
						$req_log['MDG_NPWP'] = $this->input->post('npwp'); //m
						$req_log['MDG_PPN'] = $this->input->post('ppn'); //m
						$req_log['MDG_BankKey'] = $this->input->post('bankkey');
						$req_log['MDG_AccountNo'] = $this->input->post('accountno');
						$req_log['MDG_AccountName'] = $this->input->post('accountname');
						$req_log['PaymentTerm_ID'] = $this->input->post('paymentterm');
						$req_log['LOG_ID'] = $this->model_app->getMaxKode('Ms_Customer_MDG_Log', 'LOG_ID', 'LOG-CST');
						$req_log['MDG_Customer_ID'] = $this->input->post('id');
						$req_log['MDG_CreateDt'] = date('Y-m-d H:i:s');
						$req_log['MDG_Status'] = 1;
						$req_log['MDG_SameBill'] = $this->input->post('sambill');
						$req_log['MDG_Billtoparty'] = $this->input->post('billtoparty');
						$req_log['Account_ID'] = $this->session->userdata('account_id');

						$query = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
						foreach($query->result() as $acc){
							$data1['Account_Name'] = $acc->Account_First_Name.' '.$acc->Account_Last_Name;
						}

						$data1['MDG_Type'] = 'Customer';
						$data1['MDG_Category'] = 'Request';
						$data1['MDG_ID'] = $cus;
						$data1['Information'] = 'Request Data Customer (Send for approval)';
						$data1['Posting_Date'] = date('Y-m-d H:i:s');
						$data1['Account_ID'] = $this->session->userdata('account_id');
						$data1['Log_Status'] = 'Created (to Send)';

						$cek_approval = $this->db->query("select * from Ms_Customer_MDG where MDG_Customer_ID = '".$cus."' and (MDG_Status > 3 or MDG_Status = 1)");
						if($cek_approval->num_rows() == 0){
							$data = array(
								'status' => 'tryagain'
							);
							echo json_encode($data);
						}else{
							$cek_account_same = $this->db->query("select * from Ms_Customer_MDG where MDG_Customer_ID='".$cus."' and Account_ID='".$this->session->userdata('account_id')."'");
							if($cek_account_same->num_rows() == 0){
								$data = array(
									'status' => 'accountnot'
								);
								echo json_encode($data);
							}else{
								$update = $this->model_app->update_data('Ms_Customer_MDG', 'MDG_Customer_ID', $id_mdg_customer, $data);
								$insert1 = $this->model_app->insert_data('MDG_Log', $data1);
								$insert_req_log = $this->model_app->insert_data('Ms_Customer_MDG_Log', $req_log);
								if(!$update){
									$data = array(
										'status' => 'fail'
									);
									echo json_encode($data);
								}else{
									if($insert1){
										//send approval to approver
										$query_mapping = $this->db->query("select * from Ms_Mapping AS m inner join Ms_Account as a on m.Mapping_approval_person = a.Account_ID inner join Ms_Structure_Organization as o on a.SO_ID = o.SO_ID where m.Account_ID = '".$this->session->userdata('account_id')."'");
										foreach($query_mapping->result() as $map){
											$username = 'mailer.goc';
											$sender_email = 'mailer.goc@gmail.com';
											$user_password = 'gl0ria0rigitac0smetic';
											$subject = 'MDG Application | Approval Master Data Customer';

											$message = '<div style="background-color:#f9f9f9;font-family:Helvetica,Arial,sans-serif;">
																	<table style="margin:1% 5%;background-color:#fff;border-collapse:collapse;width:90%;border:none;">
																		<tbody>
																			<tr style="background-image:url(http://purbasari.com/assets/background-flat.jpg);background-size:cover;">
																				<td style="width:100%;padding:0px;" colspan="2">
																					<table style="width:100%;height:300px;background-color:#000;opacity:0.5">
																						<tr>
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
																						<tr>
																							<td>
																								<div style="margin-left:10px;color:#999;">
																								<p>Hi, '.$map->Account_First_Name.' '.$map->Account_Last_Name.',</p>
																								<p>We have received approval form (Master Data Customer).<br/>Now you can look at the bottom for link form master data customer, Please visit here.</p>
																									<p>
																										Link (Approve):	'.base_url().'index.php/request/approval_master_customer/'.$cus.'/'.$map->Mapping_approval_person.'<br/>
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
																				<td style="width:100%;padding:10px 0px;" colspan="2">
																					<table>
																						<tr>
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
																						<tr style="text-align:center;">
																							<td style="width:95%;font-family:arial;padding-top:0px;padding-bottom:10px;padding-right:10px;border-collapse:collapse;text-align:justify">
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
																	</div>';

											//$message = 'test';
											// Configure email library
											$config['protocol'] = 'smtp';
											$config['smtp_host'] = 'ssl://smtp.googlemail.com';
											$config['smtp_port'] = 465;
											$config['smtp_user'] = $sender_email;
											$config['smtp_pass'] = $user_password;
											$config['mailtype'] = 'html';
											$config['charset'] = 'iso-8859-1';


											// Load email library and passing configured values to email library
											$this->load->library('email', $config);
											$this->email->set_newline("\r\n");
											// Sender email address
											$this->email->from($sender_email, $username);
											// Receiver email address
											$this->email->to($map->Account_Email);
											$this->email->cc('it.mis@goc.co.id');
											// Subject of email
											$this->email->subject($subject);
											// Message in email
											$this->email->message($message);
											// Action Sending Mesage
											$send_user = $this->email->send();
											if($send_user == true){

												$id_status2 = $cus;
												$update_status2['MDG_Status'] = '2';

												$update_stts2 = $this->model_app->update_data('Ms_Customer_MDG', 'MDG_Customer_ID', $id_status2, $update_status2);

												if($update_stts2){
													$query_log = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
													foreach($query_log->result() as $acc1){
														$update_data_log['Account_Name'] = $acc1->Account_First_Name.' '.$acc1->Account_Last_Name;
													}

													$update_data_log['MDG_Type'] = 'Customer';
													$update_data_log['MDG_Category'] = 'Request';
													$update_data_log['MDG_ID'] = $cus;
													$update_data_log['Information'] = 'Request Data Customer send to mail '.$map->Account_Email;
													$update_data_log['Posting_Date'] = date('Y-m-d H:i:s');
													$update_data_log['Account_ID'] = $this->session->userdata('account_id');
													$update_data_log['Log_Status'] = 'Send Mail';

													$insert_send_mail = $this->model_app->insert_data('MDG_Log', $update_data_log);
													if($insert_send_mail){
														$outbox['OutboxMDG_ID'] = $this->model_app->getMaxKode('NewOutbox', 'OutboxMDG_ID', 'OTBX');
														$outbox['OutboxMDG_To'] = $map->Account_Email;
														$outbox['OutboxMDG_From_Account'] = $this->session->userdata('account_id');
														$outbox['OutboxMDG_To_Account'] = $map->Mapping_approval_person;
														$outbox['OutboxMDG_Subject'] = $subject;
														$outbox['OutboxMDG_ShortText'] = "Hi, ".$map->Account_First_Name.' '.$map->Account_Last_Name." We have received request form (Master Data Customer). Now you can look at the bottom for link form master data customer, Please visit here.";
														$outbox['OutboxMDG_Send'] = $update_data_log['Posting_Date'];
														$outbox['OutboxMDG_Link'] = 'index.php/request/outbox/customer/'.$cus;
														$outbox['OutboxType'] = 'Request';
														$outbox['MDG_ID'] = $cus;
														$outbox['LOG_ID'] = $req_log['LOG_ID'];
														$outbox['OutboxMDG_Status'] = 0;
														$insert_outbox = $this->model_app->insert_data('NewOutbox', $outbox);


														$inbox['InboxMDG_ID'] = $this->model_app->getMaxKode('NewInbox', 'InboxMDG_ID', 'INBX');
														$inbox['InboxMDG_From'] = $map->Account_Email;
														$inbox['InboxMDG_From_Account'] = $this->session->userdata('account_id');
														$inbox['InboxMDG_To_Account'] = $map->Mapping_approval_person;
														$inbox['InboxMDG_Subject'] = $subject;
														$inbox['InboxMDG_ShortText'] = "Hi, ".$map->Account_First_Name.' '.$map->Account_Last_Name." We have received request form (Master Data Customer). Now you can look at the bottom for link form master data customer, Please visit here.";
														$inbox['InboxMDG_Arrived'] = $update_data_log['Posting_Date'];
														$inbox['InboxMDG_Link'] = 'index.php/request/inbox/customer/'.$cus;
														$inbox['InboxType'] = 'Request';
														$inbox['MDG_ID'] = $cus;
														$inbox['LOG_ID'] = $req_log['LOG_ID'];
														$inbox['InboxMDG_Status'] = 0;
														$insert_inbox = $this->model_app->insert_data('NewInbox', $inbox);


														$newupdate['Account_ID'] = $this->session->userdata('account_id');
														$newupdate['Account_To'] = $map->Mapping_approval_person;
														$newupdate['New_ActyDt'] = date('Y-m-d H:i:s');
														$newupdate['New_Type'] = 'Request';
														$newupdate['MDG_ID'] = $cus;
														$newupdate['LOG_ID'] = $req_log['LOG_ID'];
														$newupdate['New_Description'] = "Request Master Customer ".$cus;
														$newupdate['New_Link'] = 'index.php/request/new/customer/'.$cus;
														$newupdate['New_Status'] = 0;
														$insert_newupdate = $this->model_app->insert_data('NewUpdate', $newupdate);

														if($insert_outbox){
															if($insert_inbox){
																if($insert_newupdate){
																	$data = array(
																		'status' => 'success',
																		'id' => $cus
																	);
																	//echo json_encode($data);
																}

																else{
																	$data = array(
																		'status' => 'gagal',
																		'id' => $cus
																	);
																	//echo json_encode($data);
																}
															}

															else{
																$data = array(
																	'status' => 'gagal2',
																	'id' => $cus
																);
																//echo json_encode($data);
															}
														}

														else{
															$data = array(
																'status' => 'gagal3',
																'id' => $cus
															);
															//echo json_encode($data);
														}

													}else{
														$data = array(
															'status' => 'faillogsend',
															'id' => $cus
														);
														//echo json_encode($data);
													}
												}else{
													$data = array(
														'status' => 'failstatus2',
														'id' => $cus
													);
													//echo json_encode($data);
												}
											}else{
												$data = array(
													'status' => 'failsend',
													'id' => $cus
												);
												//echo json_encode($data);
											}
										}
										echo json_encode($data);
									}else{
										$data = array(
											'status' => 'faillogupdate',
											'id' => $cus
										);
										echo json_encode($data);
									}
								}
							}
						}
					}else{
						$data = array(
							'status' => 'refresh'
						);
						echo json_encode($data);
					}
				}
			}
		}


		//-----------------act send after draft status in display_draft_view---------------------------//
		function get_send_draft(){
			date_default_timezone_set('Asia/Jakarta');
			if($this->input->post('title') == '' or $this->input->post('name') == '' or $this->input->post('type') == '' or $this->input->post('address1') == '' or $this->input->post('houseno') == '' or
			$this->input->post('city') == '' or $this->input->post('province') == '' or $this->input->post('country') == '' or $this->input->post('npwp') == '' or $this->input->post('ppn') == '' or
			$this->input->post('paymentterm') == ''){
				$data = array(
					'status' => 'require'
				);
				echo json_encode($data);
			}else{
				if($this->input->post('id') != ''){
					$ven = '';
					$data_input['MDG_Title'] = $this->input->post('title'); //m
					$data_input['MDG_VendorName'] = $this->input->post('name'); //m
					$data_input['MDG_VendorType_ID'] = $this->input->post('type'); //m
					$data_input['MDG_SearchTerm'] = $this->input->post('searchterm');
					$data_input['MDG_Address1'] = $this->input->post('address1'); //m
					$data_input['MDG_Address2'] = $this->input->post('address2');
					$data_input['MDG_Address3'] = $this->input->post('address3');
					$data_input['MDG_HouseNo'] = $this->input->post('houseno'); //m
					$data_input['MDG_City'] = $this->input->post('city'); //m
					$data_input['MDG_PostalCode'] = $this->input->post('postal');
					$data_input['VendorProvince_ID'] = $this->input->post('province'); //m
					$data_input['MDG_Country'] = $this->input->post('country'); //m
					$data_input['MDG_Phone'] = $this->input->post('phone');
					$data_input['MDG_Mobile'] = $this->input->post('mobile');
					$data_input['MDG_NPWP'] = $this->input->post('npwp'); //m
					$data_input['MDG_PPN'] = $this->input->post('ppn'); //m
					$data_input['MDG_BankKey'] = $this->input->post('bankkey');
					$data_input['MDG_AccountNo'] = $this->input->post('accountno');
					$data_input['MDG_AccountName'] = $this->input->post('accountname');
					$data_input['MDG_PaymentTerm'] = $this->input->post('paymentterm'); //m

					$id_vendor = $this->input->post('id');
					$ven = $id_vendor;
					$data_input['MDG_UpdateDt'] = date('Y-m-d H:i:s');
					$data_input['MDG_Status'] = 1;
					$data_input['Account_ID'] = $this->session->userdata('account_id');

					//-----------------------------------------------------------------------------------
					//LOG MDG VENDOR Request
					//-----------------------------------------------------------------------------------
					$req_log['MDG_Title'] = $this->input->post('title'); //m
					$req_log['MDG_VendorName'] = $this->input->post('name'); //m
					$req_log['MDG_VendorType_ID'] = $this->input->post('type'); //m
					$req_log['MDG_SearchTerm'] = $this->input->post('searchterm');
					$req_log['MDG_Address1'] = $this->input->post('address1'); //m
					$req_log['MDG_Address2'] = $this->input->post('address2');
					$req_log['MDG_Address3'] = $this->input->post('address3');
					$req_log['MDG_HouseNo'] = $this->input->post('houseno'); //m
					$req_log['MDG_City'] = $this->input->post('city'); //m
					$req_log['MDG_PostalCode'] = $this->input->post('postal');
					$req_log['VendorProvince_ID'] = $this->input->post('province'); //m
					$req_log['MDG_Country'] = $this->input->post('country'); //m
					$req_log['MDG_Phone'] = $this->input->post('phone');
					$req_log['MDG_Mobile'] = $this->input->post('mobile');
					$req_log['MDG_NPWP'] = $this->input->post('npwp'); //m
					$req_log['MDG_PPN'] = $this->input->post('ppn'); //m
					$req_log['MDG_BankKey'] = $this->input->post('bankkey');
					$req_log['MDG_AccountNo'] = $this->input->post('accountno');
					$req_log['MDG_AccountName'] = $this->input->post('accountname');
					$req_log['MDG_PaymentTerm'] = $this->input->post('paymentterm'); //m
					$req_log['LOG_ID'] = $this->model_app->getMaxKode('Ms_Vendor_MDG_Log', 'LOG_ID', 'LOG-VNR');
					$req_log['MDG_Vendor_ID'] = $this->input->post('id');
					$req_log['MDG_UpdateDt'] = date('Y-m-d H:i:s');
					$req_log['MDG_Status'] = 1;
					$req_log['Account_ID'] = $this->session->userdata('account_id');

					$query = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
					foreach($query->result() as $acc){
						$data1['Account_Name'] = $acc->Account_First_Name.' '.$acc->Account_Last_Name;
					}

					$data1['MDG_Type'] = 'Vendor';
					$data1['MDG_Category'] = 'Request';
					$data1['MDG_ID'] = $ven;
					$data1['Information'] = 'Request Data Vendor (Send for approval)';
					$data1['Posting_Date'] = date('Y-m-d H:i:s');
					$data1['Account_ID'] = $this->session->userdata('account_id');
					$data1['Log_Status'] = 'Status Update Draft to Send';

					$update = $this->model_app->update_data('Ms_Vendor_MDG', 'MDG_Vendor_ID', $id_vendor, $data_input);
					$insert1 = $this->model_app->insert_data('MDG_Log', $data1);
					$insert_req_log = $this->model_app->insert_data('Ms_Vendor_MDG_Log', $req_log);
					if(!$update){
						$data = array(
							'status' => 'fail'
						);
						echo json_encode($data);
					}else{
						if($insert1){
							//send approval to approver
							$query_mapping = $this->db->query("select * from Ms_Mapping AS m inner join Ms_Account as a on m.Mapping_approval_person = a.Account_ID inner join Ms_Structure_Organization as o on a.SO_ID = o.SO_ID where m.Account_ID = '".$this->session->userdata('account_id')."'");
							foreach($query_mapping->result() as $map){
								$username = 'mailer.goc';
								$sender_email = 'mailer.goc@gmail.com';
								$user_password = 'gl0ria0rigitac0smetic';
								$subject = 'MDG Application | Requesst Master Data Vendor ('.$data_input['MDG_VendorName'].')';

								$message = '<div style="background-color:#f9f9f9;font-family:Helvetica,Arial,sans-serif;">
														<table style="margin:1% 5%;background-color:#fff;border-collapse:collapse;width:90%;border:none;">
															<tbody>
																<tr style="background-image:url(http://purbasari.com/assets/background-flat.jpg);background-size:cover;">
																	<td style="width:100%;padding:0px;" colspan="2">
																		<table style="width:100%;height:300px;background-color:#000;opacity:0.5">
																			<tr>
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
																			<tr>
																				<td>
																					<div style="margin-left:10px;color:#999;">
																					<p>Hi, '.$map->Account_First_Name.' '.$map->Account_Last_Name.',</p>
																					<p>We have received approval form (Master Data Vendor).<br/>Now you can look at the bottom for link form master data vendor, Please visit here.</p>
																						<p>
																							Link (Approve):	'.base_url().'index.php/request/approval_master_vendor/'.$ven.'/'.$map->Mapping_approval_person.'<br/>
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
																	<td style="width:100%;padding:10px 0px;" colspan="2">
																		<table>
																			<tr>
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
																			<tr style="text-align:center;">
																				<td style="width:95%;font-family:arial;padding-top:0px;padding-bottom:10px;padding-right:10px;border-collapse:collapse;text-align:justify">
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
														</div>';

								//$message = 'test';
								// Configure email library
								$config['protocol'] = 'smtp';
								$config['smtp_host'] = 'ssl://smtp.googlemail.com';
								$config['smtp_port'] = 465;
								$config['smtp_user'] = $sender_email;
								$config['smtp_pass'] = $user_password;
								$config['mailtype'] = 'html';
								$config['charset'] = 'iso-8859-1';


								// Load email library and passing configured values to email library
								$this->load->library('email', $config);
								$this->email->set_newline("\r\n");
								// Sender email address
								$this->email->from($sender_email, $username);
								// Receiver email address
								$this->email->to($map->Account_Email);
								$this->email->cc('it.mis@goc.co.id');
								// Subject of email
								$this->email->subject($subject);
								// Message in email
								$this->email->message($message);
								// Action Sending Mesage
								$send_user = $this->email->send();
								if($send_user == true){
									//update status menjadi 2 jika berhasil terkirim
									$id_status2 = $ven;
									$update_status2['MDG_Status'] = '2';

									$update_stts2 = $this->model_app->update_data('Ms_Vendor_MDG', 'MDG_Vendor_ID', $id_status2, $update_status2);

									if($update_stts2){
										$query_log = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
										foreach($query_log->result() as $acc1){
											$update_data_log['Account_Name'] = $acc1->Account_First_Name.' '.$acc1->Account_Last_Name;
										}

										$update_data_log['MDG_Type'] = 'Vendor';
										$update_data_log['MDG_Category'] = 'Request';
										$update_data_log['MDG_ID'] = $ven;
										$update_data_log['Information'] = 'Request Data Vendor send to mail '.$map->Account_Email;
										$update_data_log['Posting_Date'] = date('Y-m-d H:i:s');
										$update_data_log['Account_ID'] = $this->session->userdata('account_id');
										$update_data_log['Log_Status'] = 'Send Mail';

										$insert_send_mail = $this->model_app->insert_data('MDG_Log', $update_data_log);
										if($insert_send_mail){
											$outbox['OutboxMDG_ID'] = $this->model_app->getMaxKode('NewOutbox', 'OutboxMDG_ID', 'OTBX');
											$outbox['OutboxMDG_To'] = $map->Account_Email;
											$outbox['OutboxMDG_From_Account'] = $this->session->userdata('account_id');
											$outbox['OutboxMDG_To_Account'] = $map->Mapping_approval_person;
											$outbox['OutboxMDG_Subject'] = $subject;
											$outbox['OutboxMDG_ShortText'] = "Hi, ".$map->Account_First_Name.' '.$map->Account_Last_Name." We have received request form (Master Data Vendor). Now you can look at the bottom for link form master data vendor, Please visit here.";
											$outbox['OutboxMDG_Send'] = $update_data_log['Posting_Date'];
											$outbox['OutboxMDG_Link'] = 'index.php/request/outbox/vendor/'.$ven;
											$outbox['OutboxType'] = 'Request';
											$outbox['LOG_ID'] = $req_log['LOG_ID'];
											$outbox['MDG_ID'] = $ven;
											$outbox['OutboxMDG_Status'] = 0;
											$insert_outbox = $this->model_app->insert_data('NewOutbox', $outbox);


											$inbox['InboxMDG_ID'] = $this->model_app->getMaxKode('NewInbox', 'InboxMDG_ID', 'INBX');
											$inbox['InboxMDG_From'] = $map->Account_Email;
											$inbox['InboxMDG_From_Account'] = $this->session->userdata('account_id');
											$inbox['InboxMDG_To_Account'] = $map->Mapping_approval_person;
											$inbox['InboxMDG_Subject'] = $subject;
											$inbox['InboxMDG_ShortText'] = "Hi, ".$map->Account_First_Name.' '.$map->Account_Last_Name." We have received request form (Master Data Vendor). Now you can look at the bottom for link form master data vendor, Please visit here.";
											$inbox['InboxMDG_Arrived'] = $update_data_log['Posting_Date'];
											$inbox['InboxMDG_Link'] = 'index.php/request/inbox/vendor/'.$ven;
											$inbox['InboxType'] = 'Request';
											$inbox['LOG_ID'] = $req_log['LOG_ID'];
											$inbox['MDG_ID'] = $ven;
											$inbox['InboxMDG_Status'] = 0;
											$insert_inbox = $this->model_app->insert_data('NewInbox', $inbox);


											$newupdate['Account_ID'] = $this->session->userdata('account_id');
											$newupdate['Account_To'] = $map->Mapping_approval_person;
											$newupdate['New_ActyDt'] = date('Y-m-d H:i:s');
											$newupdate['New_Type'] = 'Request';
											$newupdate['New_Description'] = "Request Master Vendor ".$ven;
											$newupdate['MDG_ID'] = $ven;
											$newupdate['LOG_ID'] = $req_log['LOG_ID'];
											$newupdate['New_Link'] = 'index.php/request/new/vendor/'.$ven;
											$newupdate['New_Status'] = 0;
											$insert_newupdate = $this->model_app->insert_data('NewUpdate', $newupdate);

											if($insert_outbox){
												if($insert_inbox){
													if($insert_newupdate){
														$data = array(
															'status' => 'success',
															'id' => $ven
														);
														//echo json_encode($data);
													}

													else{
														$data = array(
															'status' => 'gagal',
															'id' => $ven
														);
														//echo json_encode($data);
													}
												}

												else{
													$data = array(
														'status' => 'gagal2',
														'id' => $ven
													);
													//echo json_encode($data);
												}
											}

											else{
												$data = array(
													'status' => 'gagal3',
													'id' => $ven
												);
												//echo json_encode($data);
											}

										}else{
											$data = array(
												'status' => 'faillogsend',
												'id' => $ven
											);
											//echo json_encode($data);
										}
									}else{
										$data = array(
											'status' => 'failstatus2',
											'id' => $ven
										);
										//echo json_encode($data);
									}
								}else{
									$data = array(
										'status' => 'failsend',
										'id' => $ven
									);
									//echo json_encode($data);
								}
							}
							echo json_encode($data);
							//-----------send item
						}else{
							$data = array(
								'status' => 'faillogupdate',
								'id' => $id_vendor
							);
							echo json_encode($data);
						}
					}
				}else{
					$data = array(
						'status' => 'refresh',
						'id' => $id_vendor
					);
					echo json_encode($data);
				}
			}
		}

		function get_send_customer_draft(){
			date_default_timezone_set('Asia/Jakarta');
			if($this->input->post('title') == '' or $this->input->post('name') == '' or $this->input->post('type') == '' or $this->input->post('address1') == '' or $this->input->post('houseno') == '' or
			$this->input->post('city') == '' or $this->input->post('province') == '' or $this->input->post('country') == '' or $this->input->post('npwp') == '' or $this->input->post('ppn') == '' or
			$this->input->post('paymentterm') == '' or $this->input->post("sambill") == ''){
				$data = array(
					'status' => 'require'
				);
				echo json_encode($data);
			}else{
				if($this->input->post("sambill") == 'No'){
					if($this->input->post("billtoparty") == ''){
						$data = array(
							'status' => 'require'
						);
						echo json_encode($data);
					}else{
						if($this->input->post('id') != ''){
							$cus = '';
							$data_input['MDG_Title'] = $this->input->post('title'); //m
							$data_input['MDG_CustomerName'] = $this->input->post('name'); //m
							$data_input['MDG_CustomerType_ID'] = $this->input->post('type'); //m
							$data_input['MDG_SearchTerm'] = $this->input->post('searchterm');
							$data_input['MDG_Address1'] = $this->input->post('address1'); //m
							$data_input['MDG_Address2'] = $this->input->post('address2');
							$data_input['MDG_Address3'] = $this->input->post('address3');
							$data_input['MDG_HouseNo'] = $this->input->post('houseno'); //m
							$data_input['CustomerCity_ID'] = $this->input->post('city'); //m
							$data_input['MDG_PostalCode'] = $this->input->post('postal');
							$data_input['CustomerProvince_ID'] = $this->input->post('province'); //m
							$data_input['MDG_Country'] = $this->input->post('country'); //m
							$data_input['MDG_Phone'] = $this->input->post('phone');
							$data_input['MDG_Mobile'] = $this->input->post('mobile');
							$data_input['MDG_NPWP'] = $this->input->post('npwp'); //m
							$data_input['MDG_PPN'] = $this->input->post('ppn'); //m
							$data_input['MDG_BankKey'] = $this->input->post('bankkey');
							$data_input['MDG_AccountNo'] = $this->input->post('accountno');
							$data_input['MDG_AccountName'] = $this->input->post('accountname');
							$data_input['PaymentTerm_ID'] = $this->input->post('paymentterm'); //m
							$data_input['MDG_SameBill'] = $this->input->post('sambill');
							$data_input['MDG_Billtoparty'] = $this->input->post('billtoparty');

							$id_customer = $this->input->post('id');
							$cus = $id_customer;
							$data_input['MDG_UpdateDt'] = date('Y-m-d H:i:s');
							$data_input['MDG_Status'] = 1;
							$data_input['Account_ID'] = $this->session->userdata('account_id');

							//-----------------------------------------------------------------------------------
							//LOG MDG CUSTOMER Request
							//-----------------------------------------------------------------------------------
							$req_log['MDG_Title'] = $this->input->post('title'); //m
							$req_log['MDG_CustomerName'] = $this->input->post('name'); //m
							$req_log['MDG_CustomerType_ID'] = $this->input->post('type'); //m
							$req_log['MDG_SearchTerm'] = $this->input->post('searchterm');
							$req_log['MDG_Address1'] = $this->input->post('address1'); //m
							$req_log['MDG_Address2'] = $this->input->post('address2');
							$req_log['MDG_Address3'] = $this->input->post('address3');
							$req_log['MDG_HouseNo'] = $this->input->post('houseno'); //m
							$req_log['CustomerCity_ID'] = $this->input->post('city'); //m
							$req_log['MDG_PostalCode'] = $this->input->post('postal');
							$req_log['CustomerProvince_ID'] = $this->input->post('province'); //m
							$req_log['MDG_Country'] = $this->input->post('country'); //m
							$req_log['MDG_Phone'] = $this->input->post('phone');
							$req_log['MDG_Mobile'] = $this->input->post('mobile');
							$req_log['MDG_NPWP'] = $this->input->post('npwp'); //m
							$req_log['MDG_PPN'] = $this->input->post('ppn'); //m
							$req_log['MDG_BankKey'] = $this->input->post('bankkey');
							$req_log['MDG_AccountNo'] = $this->input->post('accountno');
							$req_log['MDG_AccountName'] = $this->input->post('accountname');
							$req_log['PaymentTerm_ID'] = $this->input->post('paymentterm'); //m
							$req_log['LOG_ID'] = $this->model_app->getMaxKode('Ms_Customer_MDG_Log', 'LOG_ID', 'LOG-CST');
							$req_log['MDG_Customer_ID'] = $this->input->post('id');
							$req_log['MDG_UpdateDt'] = date('Y-m-d H:i:s');
							$req_log['MDG_Status'] = 1;
							$req_log['MDG_SameBill'] = $this->input->post('sambill');
							$req_log['MDG_Billtoparty'] = $this->input->post('billtoparty');
							$req_log['Account_ID'] = $this->session->userdata('account_id');

							$query = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
							foreach($query->result() as $acc){
								$data1['Account_Name'] = $acc->Account_First_Name.' '.$acc->Account_Last_Name;
							}

							$data1['MDG_Type'] = 'Customer';
							$data1['MDG_Category'] = 'Request';
							$data1['MDG_ID'] = $cus;
							$data1['Information'] = 'Request Data Customer (Send for approval)';
							$data1['Posting_Date'] = date('Y-m-d H:i:s');
							$data1['Account_ID'] = $this->session->userdata('account_id');
							$data1['Log_Status'] = 'Status Update Draft to Send';

							$update = $this->model_app->update_data('Ms_Customer_MDG', 'MDG_Customer_ID', $id_customer, $data_input);
							$insert1 = $this->model_app->insert_data('MDG_Log', $data1);
							$insert_req_log = $this->model_app->insert_data('Ms_Customer_MDG_Log', $req_log);
							if(!$update){
								$data = array(
									'status' => 'fail'
								);
								echo json_encode($data);
							}else{
								if($insert1){
									//send approval to approver
									$query_mapping = $this->db->query("select * from Ms_Mapping AS m inner join Ms_Account as a on m.Mapping_approval_person = a.Account_ID inner join Ms_Structure_Organization as o on a.SO_ID = o.SO_ID where m.Account_ID = '".$this->session->userdata('account_id')."'");
									foreach($query_mapping->result() as $map){
										$username = 'mailer.goc';
										$sender_email = 'mailer.goc@gmail.com';
										$user_password = 'gl0ria0rigitac0smetic';
										$subject = 'MDG Application | Request Master Data Customer ('.$data_input['MDG_CustomerName'].')';

										$message = '<div style="background-color:#f9f9f9;font-family:Helvetica,Arial,sans-serif;">
																<table style="margin:1% 5%;background-color:#fff;border-collapse:collapse;width:90%;border:none;">
																	<tbody>
																		<tr style="background-image:url(http://purbasari.com/assets/background-flat.jpg);background-size:cover;">
																			<td style="width:100%;padding:0px;" colspan="2">
																				<table style="width:100%;height:300px;background-color:#000;opacity:0.5">
																					<tr>
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
																					<tr>
																						<td>
																							<div style="margin-left:10px;color:#999;">
																							<p>Hi, '.$map->Account_First_Name.' '.$map->Account_Last_Name.',</p>
																							<p>We have received approval form (Master Data Customer).<br/>Now you can look at the bottom for link form master data customer, Please visit here.</p>
																								<p>
																									Link (Approve):	'.base_url().'index.php/request/approval_master_customer/'.$cus.'/'.$map->Mapping_approval_person.'<br/>
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
																			<td style="width:100%;padding:10px 0px;" colspan="2">
																				<table>
																					<tr>
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
																					<tr style="text-align:center;">
																						<td style="width:95%;font-family:arial;padding-top:0px;padding-bottom:10px;padding-right:10px;border-collapse:collapse;text-align:justify">
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
																</div>';

										//$message = 'test';
										// Configure email library
										$config['protocol'] = 'smtp';
										$config['smtp_host'] = 'ssl://smtp.googlemail.com';
										$config['smtp_port'] = 465;
										$config['smtp_user'] = $sender_email;
										$config['smtp_pass'] = $user_password;
										$config['mailtype'] = 'html';
										$config['charset'] = 'iso-8859-1';


										// Load email library and passing configured values to email library
										$this->load->library('email', $config);
										$this->email->set_newline("\r\n");
										// Sender email address
										$this->email->from($sender_email, $username);
										// Receiver email address
										$this->email->to($map->Account_Email);
										$this->email->cc('it.mis@goc.co.id');
										// Subject of email
										$this->email->subject($subject);
										// Message in email
										$this->email->message($message);
										// Action Sending Mesage
										$send_user = $this->email->send();
										if($send_user == true){
											//update status menjadi 2 jika berhasil terkirim
											$id_status2 = $cus;
											$update_status2['MDG_Status'] = '2';

											$update_stts2 = $this->model_app->update_data('Ms_Customer_MDG', 'MDG_Customer_ID', $id_status2, $update_status2);

											if($update_stts2){
												$query_log = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
												foreach($query_log->result() as $acc1){
													$update_data_log['Account_Name'] = $acc1->Account_First_Name.' '.$acc1->Account_Last_Name;
												}

												$update_data_log['MDG_Type'] = 'Customer';
												$update_data_log['MDG_Category'] = 'Request';
												$update_data_log['MDG_ID'] = $cus;
												$update_data_log['Information'] = 'Request Data Customer send to mail '.$map->Account_Email;
												$update_data_log['Posting_Date'] = date('Y-m-d H:i:s');
												$update_data_log['Account_ID'] = $this->session->userdata('account_id');
												$update_data_log['Log_Status'] = 'Send Mail';

												$insert_send_mail = $this->model_app->insert_data('MDG_Log', $update_data_log);
												if($insert_send_mail){
													$outbox['OutboxMDG_ID'] = $this->model_app->getMaxKode('NewOutbox', 'OutboxMDG_ID', 'OTBX');
													$outbox['OutboxMDG_To'] = $map->Account_Email;
													$outbox['OutboxMDG_From_Account'] = $this->session->userdata('account_id');
													$outbox['OutboxMDG_To_Account'] = $map->Mapping_approval_person;
													$outbox['OutboxMDG_Subject'] = $subject;
													$outbox['OutboxMDG_ShortText'] = "Hi, ".$map->Account_First_Name.' '.$map->Account_Last_Name." We have received request form (Master Data Customer). Now you can look at the bottom for link form master data customer, Please visit here.";
													$outbox['OutboxMDG_Send'] = $update_data_log['Posting_Date'];
													$outbox['OutboxMDG_Link'] = 'index.php/request/outbox/customer/'.$cus;
													$outbox['OutboxType'] = 'Request';
													$outbox['LOG_ID'] = $req_log['LOG_ID'];
													$outbox['MDG_ID'] = $cus;
													$outbox['OutboxMDG_Status'] = 0;
													$insert_outbox = $this->model_app->insert_data('NewOutbox', $outbox);


													$inbox['InboxMDG_ID'] = $this->model_app->getMaxKode('NewInbox', 'InboxMDG_ID', 'INBX');
													$inbox['InboxMDG_From'] = $map->Account_Email;
													$inbox['InboxMDG_From_Account'] = $this->session->userdata('account_id');
													$inbox['InboxMDG_To_Account'] = $map->Mapping_approval_person;
													$inbox['InboxMDG_Subject'] = $subject;
													$inbox['InboxMDG_ShortText'] = "Hi, ".$map->Account_First_Name.' '.$map->Account_Last_Name." We have received request form (Master Data Customer). Now you can look at the bottom for link form master data customer, Please visit here.";
													$inbox['InboxMDG_Arrived'] = $update_data_log['Posting_Date'];
													$inbox['InboxMDG_Link'] = 'index.php/request/inbox/customer/'.$cus;
													$inbox['InboxType'] = 'Request';
													$inbox['LOG_ID'] = $req_log['LOG_ID'];
													$inbox['MDG_ID'] = $cus;
													$inbox['InboxMDG_Status'] = 0;
													$insert_inbox = $this->model_app->insert_data('NewInbox', $inbox);


													$newupdate['Account_ID'] = $this->session->userdata('account_id');
													$newupdate['Account_To'] = $map->Mapping_approval_person;
													$newupdate['New_ActyDt'] = date('Y-m-d H:i:s');
													$newupdate['New_Type'] = 'Request';
													$newupdate['New_Description'] = "Request Master Customer ".$cus;
													$newupdate['MDG_ID'] = $cus;
													$newupdate['LOG_ID'] = $req_log['LOG_ID'];
													$newupdate['New_Link'] = 'index.php/request/new/customer/'.$cus;
													$newupdate['New_Status'] = 0;
													$insert_newupdate = $this->model_app->insert_data('NewUpdate', $newupdate);

													if($insert_outbox){
														if($insert_inbox){
															if($insert_newupdate){
																$data = array(
																	'status' => 'success',
																	'id' => $cus
																);
																//echo json_encode($data);
															}

															else{
																$data = array(
																	'status' => 'gagal',
																	'id' => $cus
																);
																//echo json_encode($data);
															}
														}

														else{
															$data = array(
																'status' => 'gagal2',
																'id' => $cus
															);
															//echo json_encode($data);
														}
													}

													else{
														$data = array(
															'status' => 'gagal3',
															'id' => $cus
														);
														//echo json_encode($data);
													}

												}else{
													$data = array(
														'status' => 'faillogsend',
														'id' => $cus
													);
													//echo json_encode($data);
												}
											}else{
												$data = array(
													'status' => 'failstatus2',
													'id' => $cus
												);
												//echo json_encode($data);
											}
										}else{
											$data = array(
												'status' => 'failsend',
												'id' => $cus
											);
											//echo json_encode($data);
										}
									}
									echo json_encode($data);
									//-----------send item
								}else{
									$data = array(
										'status' => 'faillogupdate',
										'id' => $id_customer
									);
									echo json_encode($data);
								}
							}
						}else{
							$data = array(
								'status' => 'refresh',
								'id' => $id_customer
							);
							echo json_encode($data);
						}
					}
				}else{
					if($this->input->post('id') != ''){
						$cus = '';
						$data_input['MDG_Title'] = $this->input->post('title'); //m
						$data_input['MDG_CustomerName'] = $this->input->post('name'); //m
						$data_input['MDG_CustomerType_ID'] = $this->input->post('type'); //m
						$data_input['MDG_SearchTerm'] = $this->input->post('searchterm');
						$data_input['MDG_Address1'] = $this->input->post('address1'); //m
						$data_input['MDG_Address2'] = $this->input->post('address2');
						$data_input['MDG_Address3'] = $this->input->post('address3');
						$data_input['MDG_HouseNo'] = $this->input->post('houseno'); //m
						$data_input['CustomerCity_ID'] = $this->input->post('city'); //m
						$data_input['MDG_PostalCode'] = $this->input->post('postal');
						$data_input['CustomerProvince_ID'] = $this->input->post('province'); //m
						$data_input['MDG_Country'] = $this->input->post('country'); //m
						$data_input['MDG_Phone'] = $this->input->post('phone');
						$data_input['MDG_Mobile'] = $this->input->post('mobile');
						$data_input['MDG_NPWP'] = $this->input->post('npwp'); //m
						$data_input['MDG_PPN'] = $this->input->post('ppn'); //m
						$data_input['MDG_BankKey'] = $this->input->post('bankkey');
						$data_input['MDG_AccountNo'] = $this->input->post('accountno');
						$data_input['MDG_AccountName'] = $this->input->post('accountname');
						$data_input['PaymentTerm_ID'] = $this->input->post('paymentterm'); //m
						$data_input['same_bill_toparty_desktop'] = $this->input->post('sambill');

						$id_customer = $this->input->post('id');
						$cus = $id_customer;
						$data_input['MDG_CreateDt'] = date('Y-m-d H:i:s');
						$data_input['MDG_Status'] = 1;
						$data_input['Account_ID'] = $this->session->userdata('account_id');

						//-----------------------------------------------------------------------------------
						//LOG MDG CUSTOMER Request
						//-----------------------------------------------------------------------------------
						$req_log['MDG_Title'] = $this->input->post('title'); //m
						$req_log['MDG_CustomerName'] = $this->input->post('name'); //m
						$req_log['MDG_CustomerType_ID'] = $this->input->post('type'); //m
						$req_log['MDG_SearchTerm'] = $this->input->post('searchterm');
						$req_log['MDG_Address1'] = $this->input->post('address1'); //m
						$req_log['MDG_Address2'] = $this->input->post('address2');
						$req_log['MDG_Address3'] = $this->input->post('address3');
						$req_log['MDG_HouseNo'] = $this->input->post('houseno'); //m
						$req_log['CustomerCity_ID'] = $this->input->post('city'); //m
						$req_log['MDG_PostalCode'] = $this->input->post('postal');
						$req_log['CustomerProvince_ID'] = $this->input->post('province'); //m
						$req_log['MDG_Country'] = $this->input->post('country'); //m
						$req_log['MDG_Phone'] = $this->input->post('phone');
						$req_log['MDG_Mobile'] = $this->input->post('mobile');
						$req_log['MDG_NPWP'] = $this->input->post('npwp'); //m
						$req_log['MDG_PPN'] = $this->input->post('ppn'); //m
						$req_log['MDG_BankKey'] = $this->input->post('bankkey');
						$req_log['MDG_AccountNo'] = $this->input->post('accountno');
						$req_log['MDG_AccountName'] = $this->input->post('accountname');
						$req_log['PaymentTerm_ID'] = $this->input->post('paymentterm'); //m
						$req_log['LOG_ID'] = $this->model_app->getMaxKode('Ms_Customer_MDG_Log', 'LOG_ID', 'LOG-CST');
						$req_log['MDG_Customer_ID'] = $this->input->post('id');
						$req_log['MDG_CreateDt'] = date('Y-m-d H:i:s');
						$req_log['MDG_Status'] = 1;
						$req_log['same_bill_toparty_desktop'] = $this->input->post('sambill');
						$req_log['Account_ID'] = $this->session->userdata('account_id');

						$query = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
						foreach($query->result() as $acc){
							$data1['Account_Name'] = $acc->Account_First_Name.' '.$acc->Account_Last_Name;
						}

						$data1['MDG_Type'] = 'Customer';
						$data1['MDG_Category'] = 'Request';
						$data1['MDG_ID'] = $cus;
						$data1['Information'] = 'Request Data Customer (Send for approval)';
						$data1['Posting_Date'] = date('Y-m-d H:i:s');
						$data1['Account_ID'] = $this->session->userdata('account_id');
						$data1['Log_Status'] = 'Status Update Draft to Send';

						$update = $this->model_app->update_data('Ms_Customer_MDG', 'MDG_Customer_ID', $id_customer, $data_input);
						$insert1 = $this->model_app->insert_data('MDG_Log', $data1);
						$insert_req_log = $this->model_app->insert_data('Ms_Customer_MDG_Log', $req_log);
						if(!$update){
							$data = array(
								'status' => 'fail'
							);
							echo json_encode($data);
						}else{
							if($insert1){
								//send approval to approver
								$query_mapping = $this->db->query("select * from Ms_Mapping AS m inner join Ms_Account as a on m.Mapping_approval_person = a.Account_ID inner join Ms_Structure_Organization as o on a.SO_ID = o.SO_ID where m.Account_ID = '".$this->session->userdata('account_id')."'");
								foreach($query_mapping->result() as $map){
									$username = 'mailer.goc';
									$sender_email = 'mailer.goc@gmail.com';
									$user_password = 'gl0ria0rigitac0smetic';
									$subject = 'MDG Application | Requesst Master Data Customer ('.$data_input['MDG_CustomerName'].')';

									$message = '<div style="background-color:#f9f9f9;font-family:Helvetica,Arial,sans-serif;">
															<table style="margin:1% 5%;background-color:#fff;border-collapse:collapse;width:90%;border:none;">
																<tbody>
																	<tr style="background-image:url(http://purbasari.com/assets/background-flat.jpg);background-size:cover;">
																		<td style="width:100%;padding:0px;" colspan="2">
																			<table style="width:100%;height:300px;background-color:#000;opacity:0.5">
																				<tr>
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
																				<tr>
																					<td>
																						<div style="margin-left:10px;color:#999;">
																						<p>Hi, '.$map->Account_First_Name.' '.$map->Account_Last_Name.',</p>
																						<p>We have received approval form (Master Data Customer).<br/>Now you can look at the bottom for link form master data customer, Please visit here.</p>
																							<p>
																								Link (Approve):	'.base_url().'index.php/request/approval_master_customer/'.$cus.'/'.$map->Mapping_approval_person.'<br/>
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
																		<td style="width:100%;padding:10px 0px;" colspan="2">
																			<table>
																				<tr>
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
																				<tr style="text-align:center;">
																					<td style="width:95%;font-family:arial;padding-top:0px;padding-bottom:10px;padding-right:10px;border-collapse:collapse;text-align:justify">
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
															</div>';

									//$message = 'test';
									// Configure email library
									$config['protocol'] = 'smtp';
									$config['smtp_host'] = 'ssl://smtp.googlemail.com';
									$config['smtp_port'] = 465;
									$config['smtp_user'] = $sender_email;
									$config['smtp_pass'] = $user_password;
									$config['mailtype'] = 'html';
									$config['charset'] = 'iso-8859-1';


									// Load email library and passing configured values to email library
									$this->load->library('email', $config);
									$this->email->set_newline("\r\n");
									// Sender email address
									$this->email->from($sender_email, $username);
									// Receiver email address
									$this->email->to($map->Account_Email);
									$this->email->cc('it.mis@goc.co.id');
									// Subject of email
									$this->email->subject($subject);
									// Message in email
									$this->email->message($message);
									// Action Sending Mesage
									$send_user = $this->email->send();
									if($send_user == true){
										//update status menjadi 2 jika berhasil terkirim
										$id_status2 = $cus;
										$update_status2['MDG_Status'] = '2';

										$update_stts2 = $this->model_app->update_data('Ms_Customer_MDG', 'MDG_Customer_ID', $id_status2, $update_status2);

										if($update_stts2){
											$query_log = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
											foreach($query_log->result() as $acc1){
												$update_data_log['Account_Name'] = $acc1->Account_First_Name.' '.$acc1->Account_Last_Name;
											}

											$update_data_log['MDG_Type'] = 'Customer';
											$update_data_log['MDG_Category'] = 'Request';
											$update_data_log['MDG_ID'] = $cus;
											$update_data_log['Information'] = 'Request Data Customer send to mail '.$map->Account_Email;
											$update_data_log['Posting_Date'] = date('Y-m-d H:i:s');
											$update_data_log['Account_ID'] = $this->session->userdata('account_id');
											$update_data_log['Log_Status'] = 'Send Mail';

											$insert_send_mail = $this->model_app->insert_data('MDG_Log', $update_data_log);
											if($insert_send_mail){
												$outbox['OutboxMDG_ID'] = $this->model_app->getMaxKode('NewOutbox', 'OutboxMDG_ID', 'OTBX');
												$outbox['OutboxMDG_To'] = $map->Account_Email;
												$outbox['OutboxMDG_From_Account'] = $this->session->userdata('account_id');
												$outbox['OutboxMDG_To_Account'] = $map->Mapping_approval_person;
												$outbox['OutboxMDG_Subject'] = $subject;
												$outbox['OutboxMDG_ShortText'] = "Hi, ".$map->Account_First_Name.' '.$map->Account_Last_Name." We have received request form (Master Data Customer). Now you can look at the bottom for link form master data customer, Please visit here.";
												$outbox['OutboxMDG_Send'] = $update_data_log['Posting_Date'];
												$outbox['OutboxMDG_Link'] = 'index.php/request/outbox/customer/'.$ven;
												$outbox['OutboxType'] = 'Request';
												$outbox['LOG_ID'] = $req_log['LOG_ID'];
												$outbox['MDG_ID'] = $cus;
												$outbox['OutboxMDG_Status'] = 0;
												$insert_outbox = $this->model_app->insert_data('NewOutbox', $outbox);


												$inbox['InboxMDG_ID'] = $this->model_app->getMaxKode('NewInbox', 'InboxMDG_ID', 'INBX');
												$inbox['InboxMDG_From'] = $map->Account_Email;
												$inbox['InboxMDG_From_Account'] = $this->session->userdata('account_id');
												$inbox['InboxMDG_To_Account'] = $map->Mapping_approval_person;
												$inbox['InboxMDG_Subject'] = $subject;
												$inbox['InboxMDG_ShortText'] = "Hi, ".$map->Account_First_Name.' '.$map->Account_Last_Name." We have received request form (Master Data Customer). Now you can look at the bottom for link form master data customer, Please visit here.";
												$inbox['InboxMDG_Arrived'] = $update_data_log['Posting_Date'];
												$inbox['InboxMDG_Link'] = 'index.php/request/inbox/customer/'.$cus;
												$inbox['InboxType'] = 'Request';
												$inbox['LOG_ID'] = $req_log['LOG_ID'];
												$inbox['MDG_ID'] = $cus;
												$inbox['InboxMDG_Status'] = 0;
												$insert_inbox = $this->model_app->insert_data('NewInbox', $inbox);


												$newupdate['Account_ID'] = $this->session->userdata('account_id');
												$newupdate['Account_To'] = $map->Mapping_approval_person;
												$newupdate['New_ActyDt'] = date('Y-m-d H:i:s');
												$newupdate['New_Type'] = 'Request';
												$newupdate['New_Description'] = "Request Master Customer ".$ven;
												$newupdate['MDG_ID'] = $cus;
												$newupdate['LOG_ID'] = $req_log['LOG_ID'];
												$newupdate['New_Link'] = 'index.php/request/new/customer/'.$ven;
												$newupdate['New_Status'] = 0;
												$insert_newupdate = $this->model_app->insert_data('NewUpdate', $newupdate);

												if($insert_outbox){
													if($insert_inbox){
														if($insert_newupdate){
															$data = array(
																'status' => 'success',
																'id' => $cus
															);
															//echo json_encode($data);
														}

														else{
															$data = array(
																'status' => 'gagal',
																'id' => $cus
															);
															//echo json_encode($data);
														}
													}

													else{
														$data = array(
															'status' => 'gagal2',
															'id' => $cus
														);
														//echo json_encode($data);
													}
												}

												else{
													$data = array(
														'status' => 'gagal3',
														'id' => $cus
													);
													//echo json_encode($data);
												}

											}else{
												$data = array(
													'status' => 'faillogsend',
													'id' => $cus
												);
												//echo json_encode($data);
											}
										}else{
											$data = array(
												'status' => 'failstatus2',
												'id' => $cus
											);
											//echo json_encode($data);
										}
									}else{
										$data = array(
											'status' => 'failsend',
											'id' => $cus
										);
										//echo json_encode($data);
									}
								}
								echo json_encode($data);
								//-----------send item
							}else{
								$data = array(
									'status' => 'faillogupdate',
									'id' => $id_customer
								);
								echo json_encode($data);
							}
						}
					}else{
						$data = array(
							'status' => 'refresh',
							'id' => $id_customer
						);
						echo json_encode($data);
					}
				}
			}
		}

		//-----------------act save request in display_draft_view and create_vendor_view--------------------------------------//

		function get_save_vendor(){
			date_default_timezone_set('Asia/Jakarta');
			if($this->input->post('title') == '' or $this->input->post('name') == '' or $this->input->post('type') == '' or $this->input->post('address1') == '' or $this->input->post('houseno') == '' or
			$this->input->post('city') == '' or $this->input->post('province') == '' or $this->input->post('country') == '' or $this->input->post('npwp') == '' or $this->input->post('ppn') == '' or
			$this->input->post('paymentterm') == ''){
				$data = array(
					'status' => 'require'
				);
				echo json_encode($data);
			}else{
				if($this->input->post('id') == ''){
					$data['MDG_Title'] = $this->input->post('title'); //m
					$data['MDG_VendorName'] = $this->input->post('name'); //m
					$data['MDG_VendorType_ID'] = $this->input->post('type'); //m
					$data['MDG_SearchTerm'] = $this->input->post('searchterm');
					$data['MDG_Address1'] = $this->input->post('address1'); //m
					$data['MDG_Address2'] = $this->input->post('address2');
					$data['MDG_Address3'] = $this->input->post('address3');
					$data['MDG_HouseNo'] = $this->input->post('houseno'); //m
					$data['MDG_City'] = $this->input->post('city'); //m
					$data['MDG_PostalCode'] = $this->input->post('postal');
					$data['VendorProvince_ID'] = $this->input->post('province'); //m
					$data['MDG_Country'] = $this->input->post('country'); //m
					$data['MDG_Phone'] = $this->input->post('phone');
					$data['MDG_Mobile'] = $this->input->post('mobile');
					$data['MDG_NPWP'] = $this->input->post('npwp'); //m
					$data['MDG_PPN'] = $this->input->post('ppn'); //m
					$data['MDG_BankKey'] = $this->input->post('bankkey');
					$data['MDG_AccountNo'] = $this->input->post('accountno');
					$data['MDG_AccountName'] = $this->input->post('accountname');
					$data['MDG_PaymentTerm'] = $this->input->post('paymentterm'); //m

					$data['MDG_Vendor_ID'] = $this->model_app->getMaxKode('Ms_Vendor_MDG', 'MDG_Vendor_ID', 'MDG-VNR');
					$data['MDG_CreateDt'] = date('Y-m-d H:i:s');
					$data['MDG_Status'] = 1;
					$data['Account_ID'] = $this->session->userdata('account_id');

					$query = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
					foreach($query->result() as $acc){
						$data1['Account_Name'] = $acc->Account_First_Name.' '.$acc->Account_Last_Name;
					}

					$data1['MDG_Type'] = 'Vendor';
					$data1['MDG_Category'] = 'Request';
					$data1['MDG_ID'] = $data['MDG_Vendor_ID'];
					$data1['Information'] = 'Request Data Vendor (Draft)';
					$data1['Posting_Date'] = date('Y-m-d H:i:s');
					$data1['Account_ID'] = $this->session->userdata('account_id');
					$data1['Log_Status'] = 'Created (Draft)';

					$insert = $this->model_app->insert_data('Ms_Vendor_MDG', $data);
					$insert1 = $this->model_app->insert_data('MDG_Log', $data1);
					if(!$insert){
						$data = array(
							'status' => 'fail',
							'id' => $data['MDG_Vendor_ID']
						);
						echo json_encode($data);
					}else{
						if($insert1){
							$data = array(
								'status' => 'success',
								'id' => $data['MDG_Vendor_ID']
							);
							echo json_encode($data);
						}else{
							$data = array(
								'status' => 'notlog',
								'id' => $data['MDG_Vendor_ID']
							);
							echo json_encode($data);
						}
					}
				}else{
					$data = array(
						'status' => 'refresh'
					);
					echo json_encode($data);
				}
			}
		}

		function get_save_customer(){
			date_default_timezone_set('Asia/Jakarta');
			if($this->input->post('title') == '' or $this->input->post('name') == '' or $this->input->post('type') == '' or $this->input->post('address1') == '' or $this->input->post('houseno') == '' or
			$this->input->post('city') == '' or $this->input->post('province') == '' or $this->input->post('country') == '' or $this->input->post('npwp') == '' or $this->input->post('ppn') == '' or
			$this->input->post('paymentterm') == '' or $this->input->post('sambill') == ''){
				$data = array(
					'status' => 'require'
				);
				echo json_encode($data);
			}else{
				if($this->input->post('sambill') == 'No'){
					if($this->input->post('billtoparty') == ''){
						$data = array(
							'status' => 'require'
						);
						echo json_encode($data);
					}else{
						//--------------------------------------------------------------------
						if($this->input->post('id') == ''){
							$data['MDG_Title'] = $this->input->post('title'); //m
							$data['MDG_CustomerName'] = $this->input->post('name'); //m
							$data['MDG_CustomerType_ID'] = $this->input->post('type'); //m
							$data['MDG_SearchTerm'] = $this->input->post('searchterm');
							$data['MDG_Address1'] = $this->input->post('address1'); //m
							$data['MDG_Address2'] = $this->input->post('address2');
							$data['MDG_Address3'] = $this->input->post('address3');
							$data['MDG_HouseNo'] = $this->input->post('houseno'); //m
							$data['CustomerCity_ID'] = $this->input->post('city'); //m
							$data['MDG_PostalCode'] = $this->input->post('postal');
							$data['CustomerProvince_ID'] = $this->input->post('province'); //m
							$data['MDG_Country'] = $this->input->post('country'); //m
							$data['MDG_Phone'] = $this->input->post('phone');
							$data['MDG_Mobile'] = $this->input->post('mobile');
							$data['MDG_NPWP'] = $this->input->post('npwp'); //m
							$data['MDG_PPN'] = $this->input->post('ppn'); //m
							$data['MDG_BankKey'] = $this->input->post('bankkey');
							$data['MDG_AccountNo'] = $this->input->post('accountno');
							$data['MDG_AccountName'] = $this->input->post('accountname');
							$data['MDG_SameBill'] = $this->input->post('sambill'); //m
							$data['MDG_Billtoparty'] = $this->input->post('billtoparty');
							$data['PaymentTerm_ID'] = $this->input->post('paymentterm'); //m

							$data['MDG_Customer_ID'] = $this->model_app->getMaxKode('Ms_Customer_MDG', 'MDG_Customer_ID', 'MDG-CST');
							$data['MDG_CreateDt'] = date('Y-m-d H:i:s');
							$data['MDG_Status'] = 1;
							$data['Account_ID'] = $this->session->userdata('account_id');

							$query = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
							foreach($query->result() as $acc){
								$data1['Account_Name'] = $acc->Account_First_Name.' '.$acc->Account_Last_Name;
							}

							$data1['MDG_Type'] = 'Customer';
							$data1['MDG_Category'] = 'Request';
							$data1['MDG_ID'] = $data['MDG_Customer_ID'];
							$data1['Information'] = 'Request Data Customer (Draft)';
							$data1['Posting_Date'] = date('Y-m-d H:i:s');
							$data1['Account_ID'] = $this->session->userdata('account_id');
							$data1['Log_Status'] = 'Created (Draft)';

							$insert = $this->model_app->insert_data('Ms_Customer_MDG', $data);
							$insert1 = $this->model_app->insert_data('MDG_Log', $data1);
							if(!$insert){
								$data = array(
									'status' => 'fail',
									'id' => $data['MDG_Customer_ID']
								);
								echo json_encode($data);
							}else{
								if($insert1){
									$data = array(
										'status' => 'success',
										'id' => $data['MDG_Customer_ID']
									);
									echo json_encode($data);
								}else{
									$data = array(
										'status' => 'notlog',
										'id' => $data['MDG_Customer_ID']
									);
									echo json_encode($data);
								}
							}
						}else{
							$data = array(
								'status' => 'refresh'
							);
							echo json_encode($data);
						}
						//--------------------------------------------------------------------
					}
				}else{
					if($this->input->post('id') == ''){
						$data['MDG_Title'] = $this->input->post('title'); //m
						$data['MDG_CustomerName'] = $this->input->post('name'); //m
						$data['MDG_CustomerType_ID'] = $this->input->post('type'); //m
						$data['MDG_SearchTerm'] = $this->input->post('searchterm');
						$data['MDG_Address1'] = $this->input->post('address1'); //m
						$data['MDG_Address2'] = $this->input->post('address2');
						$data['MDG_Address3'] = $this->input->post('address3');
						$data['MDG_HouseNo'] = $this->input->post('houseno'); //m
						$data['CustomerCity_ID'] = $this->input->post('city'); //m
						$data['MDG_PostalCode'] = $this->input->post('postal');
						$data['CustomerProvince_ID'] = $this->input->post('province'); //m
						$data['MDG_Country'] = $this->input->post('country'); //m
						$data['MDG_Phone'] = $this->input->post('phone');
						$data['MDG_Mobile'] = $this->input->post('mobile');
						$data['MDG_NPWP'] = $this->input->post('npwp'); //m
						$data['MDG_PPN'] = $this->input->post('ppn'); //m
						$data['MDG_BankKey'] = $this->input->post('bankkey');
						$data['MDG_AccountNo'] = $this->input->post('accountno');
						$data['MDG_AccountName'] = $this->input->post('accountname');
						$data['MDG_SameBill'] = $this->input->post('sambill'); //m
						$data['PaymentTerm_ID'] = $this->input->post('paymentterm'); //m

						$data['MDG_Customer_ID'] = $this->model_app->getMaxKode('Ms_Customer_MDG', 'MDG_Customer_ID', 'MDG-CST');
						$data['MDG_CreateDt'] = date('Y-m-d H:i:s');
						$data['MDG_Status'] = 1;
						$data['Account_ID'] = $this->session->userdata('account_id');

						$query = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
						foreach($query->result() as $acc){
							$data1['Account_Name'] = $acc->Account_First_Name.' '.$acc->Account_Last_Name;
						}

						$data1['MDG_Type'] = 'Customer';
						$data1['MDG_Category'] = 'Request';
						$data1['MDG_ID'] = $data['MDG_Customer_ID'];
						$data1['Information'] = 'Request Data Customer (Draft)';
						$data1['Posting_Date'] = date('Y-m-d H:i:s');
						$data1['Account_ID'] = $this->session->userdata('account_id');
						$data1['Log_Status'] = 'Created (Draft)';

						$insert = $this->model_app->insert_data('Ms_Customer_MDG', $data);
						$insert1 = $this->model_app->insert_data('MDG_Log', $data1);
						if(!$insert){
							$data = array(
								'status' => 'fail',
								'id' => $data['MDG_Customer_ID']
							);
							echo json_encode($data);
						}else{
							if($insert1){
								$data = array(
									'status' => 'success',
									'id' => $data['MDG_Customer_ID']
								);
								echo json_encode($data);
							}else{
								$data = array(
									'status' => 'notlog',
									'id' => $data['MDG_Customer_ID']
								);
								echo json_encode($data);
							}
						}
					}else{
						$data = array(
							'status' => 'refresh'
						);
						echo json_encode($data);
					}
				}
			}
		}

		function get_save_edit_vendor(){
			date_default_timezone_set('Asia/Jakarta');
			if($this->input->post('title') == '' or $this->input->post('name') == '' or $this->input->post('type') == '' or $this->input->post('address1') == '' or $this->input->post('houseno') == '' or
			$this->input->post('city') == '' or $this->input->post('province') == '' or $this->input->post('country') == '' or $this->input->post('npwp') == '' or $this->input->post('ppn') == '' or
			$this->input->post('paymentterm') == ''){
				$data = array(
					'status' => 'require'
				);
				echo json_encode($data);
			}else{
				if($this->input->post('id') == ''){
					$data['MDG_Title'] = $this->input->post('title'); //m
					$data['MDG_VendorName'] = $this->input->post('name'); //m
					$data['MDG_VendorType_ID'] = $this->input->post('type'); //m
					$data['MDG_SearchTerm'] = $this->input->post('searchterm');
					$data['MDG_Address1'] = $this->input->post('address1'); //m
					$data['MDG_Address2'] = $this->input->post('address2');
					$data['MDG_Address3'] = $this->input->post('address3');
					$data['MDG_HouseNo'] = $this->input->post('houseno'); //m
					$data['MDG_City'] = $this->input->post('city'); //m
					$data['MDG_PostalCode'] = $this->input->post('postal');
					$data['VendorProvince_ID'] = $this->input->post('province'); //m
					$data['MDG_Country'] = $this->input->post('country'); //m
					$data['MDG_Phone'] = $this->input->post('phone');
					$data['MDG_Mobile'] = $this->input->post('mobile');
					$data['MDG_NPWP'] = $this->input->post('npwp'); //m
					$data['MDG_PPN'] = $this->input->post('ppn'); //m
					$data['MDG_BankKey'] = $this->input->post('bankkey');
					$data['MDG_AccountNo'] = $this->input->post('accountno');
					$data['MDG_AccountName'] = $this->input->post('accountname');
					$data['MDG_PaymentTerm'] = $this->input->post('paymentterm'); //m

					$data['MDG_Vendor_ID'] = $this->model_app->getMaxKode('Ms_Vendor_MDG', 'MDG_Vendor_ID', 'MDG-VNR');
					$data['MDG_UpdateDt'] = date('Y-m-d H:i:s');
					$data['MDG_Status'] = 1;
					$data['Account_ID'] = $this->session->userdata('account_id');

					$query = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
					foreach($query->result() as $acc){
						$data1['Account_Name'] = $acc->Account_First_Name.' '.$acc->Account_Last_Name;
					}

					$data1['MDG_Type'] = 'Vendor';
					$data1['MDG_Category'] = 'Request';
					$data1['MDG_ID'] = $data['MDG_Vendor_ID'];
					$data1['Information'] = 'Request Data Vendor (Draft)';
					$data1['Posting_Date'] = date('Y-m-d H:i:s');
					$data1['Account_ID'] = $this->session->userdata('account_id');
					$data1['Log_Status'] = 'Created (Draft)';

					$insert = $this->model_app->insert_data('Ms_Vendor_MDG', $data);
					$insert1 = $this->model_app->insert_data('MDG_Log', $data1);
					if(!$insert){
						$data = array(
							'status' => 'fail',
							'id' => $data['MDG_Vendor_ID']
						);
						echo json_encode($data);
					}else{
						if($insert1){
							$data = array(
								'status' => 'success',
								'id' => $data['MDG_Vendor_ID']
							);
							echo json_encode($data);
						}else{
							$data = array(
								'status' => 'notlog',
								'id' => $data['MDG_Vendor_ID']
							);
							echo json_encode($data);
						}
					}
				}else{
					$data = array(
						'status' => 'refresh'
					);
					echo json_encode($data);
				}
			}
		}

		function get_save_edit_customer(){
			date_default_timezone_set('Asia/Jakarta');
			if($this->input->post('title') == '' or $this->input->post('name') == '' or $this->input->post('type') == '' or $this->input->post('address1') == '' or $this->input->post('houseno') == '' or
			$this->input->post('city') == '' or $this->input->post('province') == '' or $this->input->post('country') == '' or $this->input->post('npwp') == '' or $this->input->post('ppn') == '' or
			$this->input->post('paymentterm') == '' or $this->input->post('sambill') == ''){
				$data = array(
					'status' => 'require'
				);
				echo json_encode($data);
			}else{
				if($this->input->post('sambill') == 'No'){
					if($this->input->post('billtoparty') == ''){
						$data = array(
							'status' => 'require'
						);
						echo json_encode($data);
					}else{
						//--------------------------------------------------------------------
						if($this->input->post('id') == ''){
							$data['MDG_Title'] = $this->input->post('title'); //m
							$data['MDG_CustomerName'] = $this->input->post('name'); //m
							$data['MDG_CustomerType_ID'] = $this->input->post('type'); //m
							$data['MDG_SearchTerm'] = $this->input->post('searchterm');
							$data['MDG_Address1'] = $this->input->post('address1'); //m
							$data['MDG_Address2'] = $this->input->post('address2');
							$data['MDG_Address3'] = $this->input->post('address3');
							$data['MDG_HouseNo'] = $this->input->post('houseno'); //m
							$data['CustomerCity_ID'] = $this->input->post('city'); //m
							$data['MDG_PostalCode'] = $this->input->post('postal');
							$data['CustomerProvince_ID'] = $this->input->post('province'); //m
							$data['MDG_Country'] = $this->input->post('country'); //m
							$data['MDG_Phone'] = $this->input->post('phone');
							$data['MDG_Mobile'] = $this->input->post('mobile');
							$data['MDG_NPWP'] = $this->input->post('npwp'); //m
							$data['MDG_PPN'] = $this->input->post('ppn'); //m
							$data['MDG_BankKey'] = $this->input->post('bankkey');
							$data['MDG_AccountNo'] = $this->input->post('accountno');
							$data['MDG_AccountName'] = $this->input->post('accountname');
							$data['MDG_SameBill'] = $this->input->post('sambill'); //m
							$data['MDG_Billtoparty'] = $this->input->post('billtoparty');
							$data['PaymentTerm_ID'] = $this->input->post('paymentterm'); //m

							$data['MDG_Customer_ID'] = $this->model_app->getMaxKode('Ms_Customer_MDG', 'MDG_Customer_ID', 'MDG-CST');
							$data['MDG_UpdateDt'] = date('Y-m-d H:i:s');
							$data['MDG_Status'] = 1;
							$data['Account_ID'] = $this->session->userdata('account_id');

							$query = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
							foreach($query->result() as $acc){
								$data1['Account_Name'] = $acc->Account_First_Name.' '.$acc->Account_Last_Name;
							}

							$data1['MDG_Type'] = 'Customer';
							$data1['MDG_Category'] = 'Request';
							$data1['MDG_ID'] = $data['MDG_Customer_ID'];
							$data1['Information'] = 'Request Data Customer (Draft)';
							$data1['Posting_Date'] = date('Y-m-d H:i:s');
							$data1['Account_ID'] = $this->session->userdata('account_id');
							$data1['Log_Status'] = 'Created (Draft)';

							$insert = $this->model_app->insert_data('Ms_Customer_MDG', $data);
							$insert1 = $this->model_app->insert_data('MDG_Log', $data1);
							if(!$insert){
								$data = array(
									'status' => 'fail',
									'id' => $data['MDG_Customer_ID']
								);
								echo json_encode($data);
							}else{
								if($insert1){
									$data = array(
										'status' => 'success',
										'id' => $data['MDG_Customer_ID']
									);
									echo json_encode($data);
								}else{
									$data = array(
										'status' => 'notlog',
										'id' => $data['MDG_Customer_ID']
									);
									echo json_encode($data);
								}
							}
						}else{
							$data = array(
								'status' => 'refresh'
							);
							echo json_encode($data);
						}
						//--------------------------------------------------------------------
					}
				}else{
					if($this->input->post('id') == ''){
						$data['MDG_Title'] = $this->input->post('title'); //m
						$data['MDG_CustomerName'] = $this->input->post('name'); //m
						$data['MDG_CustomerType_ID'] = $this->input->post('type'); //m
						$data['MDG_SearchTerm'] = $this->input->post('searchterm');
						$data['MDG_Address1'] = $this->input->post('address1'); //m
						$data['MDG_Address2'] = $this->input->post('address2');
						$data['MDG_Address3'] = $this->input->post('address3');
						$data['MDG_HouseNo'] = $this->input->post('houseno'); //m
						$data['CustomerCity_ID'] = $this->input->post('city'); //m
						$data['MDG_PostalCode'] = $this->input->post('postal');
						$data['CustomerProvince_ID'] = $this->input->post('province'); //m
						$data['MDG_Country'] = $this->input->post('country'); //m
						$data['MDG_Phone'] = $this->input->post('phone');
						$data['MDG_Mobile'] = $this->input->post('mobile');
						$data['MDG_NPWP'] = $this->input->post('npwp'); //m
						$data['MDG_PPN'] = $this->input->post('ppn'); //m
						$data['MDG_BankKey'] = $this->input->post('bankkey');
						$data['MDG_AccountNo'] = $this->input->post('accountno');
						$data['MDG_AccountName'] = $this->input->post('accountname');
						$data['MDG_SameBill'] = $this->input->post('sambill'); //m
						$data['PaymentTerm_ID'] = $this->input->post('paymentterm'); //m

						$data['MDG_Customer_ID'] = $this->model_app->getMaxKode('Ms_Customer_MDG', 'MDG_Customer_ID', 'MDG-CST');
						$data['MDG_CreateDt'] = date('Y-m-d H:i:s');
						$data['MDG_Status'] = 1;
						$data['Account_ID'] = $this->session->userdata('account_id');

						$query = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
						foreach($query->result() as $acc){
							$data1['Account_Name'] = $acc->Account_First_Name.' '.$acc->Account_Last_Name;
						}

						$data1['MDG_Type'] = 'Customer';
						$data1['MDG_Category'] = 'Request';
						$data1['MDG_ID'] = $data['MDG_Customer_ID'];
						$data1['Information'] = 'Request Data Customer (Draft)';
						$data1['Posting_Date'] = date('Y-m-d H:i:s');
						$data1['Account_ID'] = $this->session->userdata('account_id');
						$data1['Log_Status'] = 'Created (Draft)';

						$insert = $this->model_app->insert_data('Ms_Customer_MDG', $data);
						$insert1 = $this->model_app->insert_data('MDG_Log', $data1);
						if(!$insert){
							$data = array(
								'status' => 'fail',
								'id' => $data['MDG_Customer_ID']
							);
							echo json_encode($data);
						}else{
							if($insert1){
								$data = array(
									'status' => 'success',
									'id' => $data['MDG_Customer_ID']
								);
								echo json_encode($data);
							}else{
								$data = array(
									'status' => 'notlog',
									'id' => $data['MDG_Customer_ID']
								);
								echo json_encode($data);
							}
						}
					}else{
						$data = array(
							'status' => 'refresh'
						);
						echo json_encode($data);
					}
				}
			}
		}

		//------------------act update in master_vendor_view-------------------------------------------//
		function get_update_vendor(){
			date_default_timezone_set('Asia/Jakarta');
			if($this->input->post('title') == '' or $this->input->post('name') == '' or $this->input->post('type') == '' or $this->input->post('address1') == '' or $this->input->post('houseno') == '' or
			$this->input->post('city') == '' or $this->input->post('province') == '' or $this->input->post('country') == '' or $this->input->post('npwp') == '' or $this->input->post('ppn') == '' or
			$this->input->post('paymentterm') == ''){
				$data = array(
					'status' => 'require'
				);
				echo json_encode($data);
			}else{
				if($this->input->post('id') != ''){
					$cek_status_vendor = $this->db->query("select * from Ms_Vendor_MDG where MDG_Vendor_ID='".$this->input->post('id')."' and (MDG_Status > 3 or MDG_Status = 1)");
					if($cek_status_vendor->num_rows() == 0){
						$data = array(
							'status' => 'tryagain'
						);
						echo json_encode($data);
					}else{
						$cek_account_same = $this->db->query("select * from Ms_Vendor_MDG where MDG_Vendor_ID='".$this->input->post('id')."' and Account_ID='".$this->session->userdata('account_id')."'");
						if($cek_account_same->num_rows() == 0){
							$data = array(
								'status' => 'accountnot'
							);
							echo json_encode($data);
						}else{
							$data['MDG_Title'] = $this->input->post('title'); //m
							$data['MDG_VendorName'] = $this->input->post('name'); //m
							$data['MDG_VendorType_ID'] = $this->input->post('type'); //m
							$data['MDG_SearchTerm'] = $this->input->post('searchterm');
							$data['MDG_Address1'] = $this->input->post('address1'); //m
							$data['MDG_Address2'] = $this->input->post('address2');
							$data['MDG_Address3'] = $this->input->post('address3');
							$data['MDG_HouseNo'] = $this->input->post('houseno'); //m
							$data['MDG_City'] = $this->input->post('city'); //m
							$data['MDG_PostalCode'] = $this->input->post('postal');
							$data['VendorProvince_ID'] = $this->input->post('province'); //m
							$data['MDG_Country'] = $this->input->post('country'); //m
							$data['MDG_Phone'] = $this->input->post('phone');
							$data['MDG_Mobile'] = $this->input->post('mobile');
							$data['MDG_NPWP'] = $this->input->post('npwp'); //m
							$data['MDG_PPN'] = $this->input->post('ppn'); //m
							$data['MDG_BankKey'] = $this->input->post('bankkey');
							$data['MDG_AccountNo'] = $this->input->post('accountno');
							$data['MDG_AccountName'] = $this->input->post('accountname');
							$data['MDG_PaymentTerm'] = $this->input->post('paymentterm'); //m

							$id_mdg_vendor = $this->input->post('id');
							$data['MDG_UpdateDt'] = date('Y-m-d H:i:s');
							$data['MDG_Status'] = 1;
							$data['Account_ID'] = $this->session->userdata('account_id');

							$query = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
							foreach($query->result() as $acc){
								$data1['Account_Name'] = $acc->Account_First_Name.' '.$acc->Account_Last_Name;
							}

							$data1['MDG_Type'] = 'Vendor';
							$data1['MDG_Category'] = 'Request';
							$data1['MDG_ID'] = $id_mdg_vendor;
							$data1['Information'] = 'Request Data Vendor (Draft)';
							$data1['Posting_Date'] = date('Y-m-d H:i:s');
							$data1['Account_ID'] = $this->session->userdata('account_id');
							$data1['Log_Status'] = 'Update (Draft)';

							$update = $this->model_app->update_data('Ms_Vendor_MDG', 'MDG_Vendor_ID', $id_mdg_vendor, $data);
							$insert1 = $this->model_app->insert_data('MDG_Log', $data1);
							if(!$update){
								$data = array(
									'status' => 'fail',
									'id' => $id_mdg_vendor
								);
								echo json_encode($data);
							}else{
								if($insert1){
									$data = array(
										'status' => 'success',
										'id' => $id_mdg_vendor
									);
									echo json_encode($data);
								}else{
									$data = array(
										'status' => 'notlog',
										'id' => $id_mdg_vendor
									);
									echo json_encode($data);
								}
							}
						}
					}
				}else{
					$data = array(
						'status' => 'refresh'
					);
					echo json_encode($data);
				}
			}
		}

		function get_update_customer(){
			date_default_timezone_set('Asia/Jakarta');
			if($this->input->post('title') == '' or $this->input->post('name') == '' or $this->input->post('type') == '' or $this->input->post('address1') == '' or $this->input->post('houseno') == '' or
			$this->input->post('city') == '' or $this->input->post('province') == '' or $this->input->post('country') == '' or $this->input->post('npwp') == '' or $this->input->post('ppn') == '' or
			$this->input->post('paymentterm') == '' or $this->input->post('sambill') == ''){
				$data = array(
					'status' => 'require'
				);
				echo json_encode($data);
			}else{
				if($this->input->post('sambill') == 'No'){
					if($this->input->post('billtoparty') == ''){
						$data = array(
							'status' => 'require'
						);
						echo json_encode($data);
					}else{
						if($this->input->post('id') != ''){
							$cek_status_customer = $this->db->query("select * from Ms_Customer_MDG where MDG_Customer_ID='".$this->input->post('id')."' and (MDG_Status > 3 or MDG_Status = 1)");
							if($cek_status_customer->num_rows() == 0){
								$data = array(
									'status' => 'tryagain'
								);
								echo json_encode($data);
							}else{
								$cek_account_same = $this->db->query("select * from Ms_Customer_MDG where MDG_Customer_ID='".$this->input->post('id')."' and Account_ID='".$this->session->userdata('account_id')."'");
								if($cek_account_same->num_rows() == 0){
									$data = array(
										'status' => 'accountnot'
									);
									echo json_encode($data);
								}else{
									$data['MDG_Title'] = $this->input->post('title'); //m
									$data['MDG_CustomerName'] = $this->input->post('name'); //m
									$data['MDG_CustomerType_ID'] = $this->input->post('type'); //m
									$data['MDG_SearchTerm'] = $this->input->post('searchterm');
									$data['MDG_Address1'] = $this->input->post('address1'); //m
									$data['MDG_Address2'] = $this->input->post('address2');
									$data['MDG_Address3'] = $this->input->post('address3');
									$data['MDG_HouseNo'] = $this->input->post('houseno'); //m
									$data['CustomerCity_ID'] = $this->input->post('city'); //m
									$data['MDG_PostalCode'] = $this->input->post('postal');
									$data['CustomerProvince_ID'] = $this->input->post('province'); //m
									$data['MDG_Country'] = $this->input->post('country'); //m
									$data['MDG_Phone'] = $this->input->post('phone');
									$data['MDG_Mobile'] = $this->input->post('mobile');
									$data['MDG_NPWP'] = $this->input->post('npwp'); //m
									$data['MDG_PPN'] = $this->input->post('ppn'); //m
									$data['MDG_BankKey'] = $this->input->post('bankkey');
									$data['MDG_AccountNo'] = $this->input->post('accountno');
									$data['MDG_AccountName'] = $this->input->post('accountname');
									//$data['MDG_PaymentTerm'] = $this->input->post('paymentterm'); //m
									$data['MDG_SameBill'] = $this->input->post('sambill'); //m
									$data['MDG_Billtoparty'] = $this->input->post('billtoparty');
									$data['PaymentTerm_ID'] = $this->input->post('paymentterm'); //m

									$id_mdg_customer = $this->input->post('id');
									$data['MDG_UpdateDt'] = date('Y-m-d H:i:s');
									$data['MDG_Status'] = 1;
									$data['Account_ID'] = $this->session->userdata('account_id');

									$query = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
									foreach($query->result() as $acc){
										$data1['Account_Name'] = $acc->Account_First_Name.' '.$acc->Account_Last_Name;
									}

									$data1['MDG_Type'] = 'Customer';
									$data1['MDG_Category'] = 'Request';
									$data1['MDG_ID'] = $id_mdg_customer;
									$data1['Information'] = 'Request Data Customer (Draft)';
									$data1['Posting_Date'] = date('Y-m-d H:i:s');
									$data1['Account_ID'] = $this->session->userdata('account_id');
									$data1['Log_Status'] = 'Update (Draft)';

									$update = $this->model_app->update_data('Ms_Customer_MDG', 'MDG_Customer_ID', $id_mdg_customer, $data);
									$insert1 = $this->model_app->insert_data('MDG_Log', $data1);
									if(!$update){
										$data = array(
											'status' => 'fail',
											'id' => $id_mdg_customer
										);
										echo json_encode($data);
									}else{
										if($insert1){
											$data = array(
												'status' => 'success',
												'id' => $id_mdg_customer
											);
											echo json_encode($data);
										}else{
											$data = array(
												'status' => 'notlog',
												'id' => $id_mdg_customer
											);
											echo json_encode($data);
										}
									}
								}
							}
						}else{
							$data = array(
								'status' => 'refresh'
							);
							echo json_encode($data);
						}
					}
				}else{
					if($this->input->post('id') != ''){
						$cek_status_customer = $this->db->query("select * from Ms_Customer_MDG where MDG_Customer_ID='".$this->input->post('id')."' and (MDG_Status > 3 or MDG_Status = 1)");
						if($cek_status_customer->num_rows() == 0){
							$data = array(
								'status' => 'tryagain'
							);
							echo json_encode($data);
						}else{
							$cek_account_same = $this->db->query("select * from Ms_Customer_MDG where MDG_Customer_ID='".$this->input->post('id')."' and Account_ID='".$this->session->userdata('account_id')."'");
							if($cek_account_same->num_rows() == 0){
								$data = array(
									'status' => 'accountnot'
								);
								echo json_encode($data);
							}else{
								$data['MDG_Title'] = $this->input->post('title'); //m
								$data['MDG_CustomerName'] = $this->input->post('name'); //m
								$data['MDG_CustomerType_ID'] = $this->input->post('type'); //m
								$data['MDG_SearchTerm'] = $this->input->post('searchterm');
								$data['MDG_Address1'] = $this->input->post('address1'); //m
								$data['MDG_Address2'] = $this->input->post('address2');
								$data['MDG_Address3'] = $this->input->post('address3');
								$data['MDG_HouseNo'] = $this->input->post('houseno'); //m
								$data['CustomerCity_ID'] = $this->input->post('city'); //m
								$data['MDG_PostalCode'] = $this->input->post('postal');
								$data['CustomerProvince_ID'] = $this->input->post('province'); //m
								$data['MDG_Country'] = $this->input->post('country'); //m
								$data['MDG_Phone'] = $this->input->post('phone');
								$data['MDG_Mobile'] = $this->input->post('mobile');
								$data['MDG_NPWP'] = $this->input->post('npwp'); //m
								$data['MDG_PPN'] = $this->input->post('ppn'); //m
								$data['MDG_BankKey'] = $this->input->post('bankkey');
								$data['MDG_AccountNo'] = $this->input->post('accountno');
								$data['MDG_AccountName'] = $this->input->post('accountname');
								//$data['MDG_PaymentTerm'] = $this->input->post('paymentterm'); //m
								$data['MDG_SameBill'] = $this->input->post('sambill'); //m
								$data['PaymentTerm_ID'] = $this->input->post('paymentterm'); //m

								$id_mdg_customer = $this->input->post('id');
								$data['MDG_UpdateDt'] = date('Y-m-d H:i:s');
								$data['MDG_Status'] = 1;
								$data['Account_ID'] = $this->session->userdata('account_id');

								$query = $this->db->query("select * from Ms_Account where Account_ID = '".$this->session->userdata('account_id')."'");
								foreach($query->result() as $acc){
									$data1['Account_Name'] = $acc->Account_First_Name.' '.$acc->Account_Last_Name;
								}

								$data1['MDG_Type'] = 'Customer';
								$data1['MDG_Category'] = 'Request';
								$data1['MDG_ID'] = $id_mdg_customer;
								$data1['Information'] = 'Request Data Customer (Draft)';
								$data1['Posting_Date'] = date('Y-m-d H:i:s');
								$data1['Account_ID'] = $this->session->userdata('account_id');
								$data1['Log_Status'] = 'Update (Draft)';

								$update = $this->model_app->update_data('Ms_Customer_MDG', 'MDG_Customer_ID', $id_mdg_customer, $data);
								$insert1 = $this->model_app->insert_data('MDG_Log', $data1);
								if(!$update){
									$data = array(
										'status' => 'fail',
										'id' => $id_mdg_customer
									);
									echo json_encode($data);
								}else{
									if($insert1){
										$data = array(
											'status' => 'success',
											'id' => $id_mdg_customer
										);
										echo json_encode($data);
									}else{
										$data = array(
											'status' => 'notlog',
											'id' => $id_mdg_customer
										);
										echo json_encode($data);
									}
								}
							}
						}
					}else{
						$data = array(
							'status' => 'refresh'
						);
						echo json_encode($data);
					}
				}
			}
		}


	//--------------------------------------------------------MASTER VENDOR LIST------------------------------------------------------------------------//
	function get_ms_vendor(){
		$cek_status = $this->session->userdata('success_data');
		if(!$cek_status){
		?>
		<script>
			window.location.href = '<?php echo base_url();?>';
		</script>
		<?php
		}else{
			$query = $this->db->query("select * from Ms_Account as a inner join Ms_Account_Privacy as p on a.User_ID = p.User_ID where Account_ID = '".$this->session->userdata('account_id')."'");
			$query_c_update = $this->db->query("select * from NewUpdate where New_Status = 0 and Account_To = '".$this->session->userdata('account_id')."'");
			foreach($query->result() as $acc){
				$data['first_name'] = $acc->Account_First_Name;
				$data['last_name'] = $acc->Account_Last_Name;
				$data['username'] = $acc->Username;
			}

			$data['c_update'] = $query_c_update->num_rows();

			$this->load->view('top_view');
			$this->load->view('master_vendor_view',$data);
			$this->load->view('bottom_view');
		}
	}

	function get_vendor(){
			$this->load->view('top_view');
			$this->load->view('vendor_view');
			$this->load->view('bottom_view');
	}

	function get_customer(){
			$this->load->view('top_view');
			$this->load->view('customer_view');
			$this->load->view('bottom_view');
	}

	function get_ms_customer(){
		$cek_status = $this->session->userdata('success_data');
		if(!$cek_status){
		?>
		<script>
			window.location.href = '<?php echo base_url();?>';
		</script>
		<?php
		}else{
			$query = $this->db->query("select * from Ms_Account as a inner join Ms_Account_Privacy as p on a.User_ID = p.User_ID where Account_ID = '".$this->session->userdata('account_id')."'");
			$query_c_update = $this->db->query("select * from NewUpdate where New_Status = 0 and Account_To = '".$this->session->userdata('account_id')."'");
			foreach($query->result() as $acc){
				$data['first_name'] = $acc->Account_First_Name;
				$data['last_name'] = $acc->Account_Last_Name;
				$data['username'] = $acc->Username;
			}

			$data['c_update'] = $query_c_update->num_rows();

			$this->load->view('top_view');
			$this->load->view('master_customer_view',$data);
			$this->load->view('bottom_view');
		}
	}

	function get_list_ms_vendor(){
		$query_get_vendor = $this->db->query("select *, case when m.MDG_UpdateDt is null then m.MDG_CreateDt else m.MDG_UpdateDt end as EffDate from Ms_Vendor_MDG as m inner join Ms_Vendor_Province as p on m.VendorProvince_ID = p.VendorProvince_ID inner join Ms_Vendor_Type as t on m.MDG_VendorType_ID = t.VendorType_ID inner join Ms_Account as a on m.Account_ID = a.Account_ID order by EffDate desc");
		foreach($query_get_vendor->result() as $grid5){
			$data[] = $grid5;
		}
		echo json_encode($data);
	}

	function get_list_ms_customer(){
		$query_get_customer = $this->db->query("select *, case when m.MDG_UpdateDt is null then m.MDG_CreateDt else m.MDG_UpdateDt end as EffDate from Ms_Customer_MDG as m inner join Ms_Customer_Province as p on m.CustomerProvince_ID = p.CustomerProvince_ID inner join Ms_Customer_Type as t on m.MDG_CustomerType_ID = t.CustomerType_ID inner join Ms_Account as a on m.Account_ID = a.Account_ID
		inner join Ms_Customer_City as c on m.CustomerCity_ID = c.ObjectID inner join Ms_Customer_Term as tr on m.PaymentTerm_ID = tr.ObjectID order by EffDate desc");
		foreach($query_get_customer->result() as $grid5){
			$data[] = $grid5;
		}
		echo json_encode($data);
	}

	function get_log_vendor(){
		$id = $this->input->post('id');

		$query_get_log = $this->db->query("select * from MDG_Log where MDG_ID = '".$id."' order by Posting_Date desc");
		foreach($query_get_log->result() as $grid5){
			$data[] = $grid5;
		}
		echo json_encode($data);
	}

	function get_log_customer(){
		$id = $this->input->post('id');

		$query_get_log = $this->db->query("select * from MDG_Log where MDG_ID = '".$id."' order by Posting_Date desc");
		foreach($query_get_log->result() as $grid5){
			$data[] = $grid5;
		}
		echo json_encode($data);
	}


	//-------------------------------------------------------APPROVAL REQUEST--------------------------------------------------------------------------//
	function approval_master_vendor($id, $acc){
		date_default_timezone_set('Asia/Jakarta');
		$id = $this->uri->segment(3);
		$acc = $this->uri->segment(4);

		$this->load->view('top_app_view');
		$this->load->view('master_app_vendor_view');
		$this->load->view('bottom_app_view');
	}

	function approval_master_customer($id, $acc){
		date_default_timezone_set('Asia/Jakarta');
		$id = $this->uri->segment(3);
		$acc = $this->uri->segment(4);

		$this->load->view('top_app_view');
		$this->load->view('master_app_customer_view');
		$this->load->view('bottom_app_view');
	}

	function get_approval_vendor(){
		date_default_timezone_set('Asia/Jakarta');
		if($this->input->post('app') == '' or $this->input->post('acc') == '' or $this->input->post('id') == ''){
			$data = array(
				'status' => 'require'
			);
			echo json_encode($data);
		}else{
			$cek_acc = $this->db->query("select * from Ms_Account where Account_ID = '".$this->input->post('acc')."'");
			if($cek_acc->num_rows() > 0){
				$cek_id = $this->db->query("select v.Account_ID as vaccount, v.*, a.* from Ms_Vendor_MDG as v inner join Ms_Account as a on v.Account_ID = a.Account_ID  where MDG_Vendor_ID = '".$this->input->post('id')."' and (MDG_Status = 2 or MDG_Status = 3)");
				if($cek_id->num_rows() > 0){
					$query_cek_squel = $this->db->query("select top 1 Squel from Ms_Vendor_MDG_Approval where ParentObjectID = '".$this->input->post('id')."' and Account_ID = '".$this->input->post('acc')."' order by ObjectID desc");
					if($query_cek_squel->num_rows() == 0){
						$data['Squel'] = 1;
					}else{
						foreach($query_cek_squel->result() as $sq){
							$data['Squel'] = $sq->Squel + 1;
						}
					}
					$data['ParentObjectID'] = $this->input->post('id');
					$data['MDG_Approval'] = $this->input->post('app');
					$data['MDG_Remark'] = $this->input->post('remark');
					$data['Account_ID'] = $this->input->post('acc');

					$query_log = $this->db->query("select * from Ms_Account where Account_ID = '".$data['Account_ID']."'");
					foreach($query_log->result() as $acca){
						$data1['Account_Name'] = $acca->Account_First_Name.' '.$acca->Account_Last_Name;
					}

					$data1['MDG_Type'] = 'Vendor';
					$data1['MDG_Category'] = 'Approval';
					$data1['MDG_ID'] = $data['ParentObjectID'];
					if($this->input->post('app') == 0){
						$data1['Information'] = 'Request Data Vendor (Not Approval) | '.$data['MDG_Remark'];
					}else{
						$data1['Information'] = 'Request Data Vendor (Approval) | '.$data['MDG_Remark'];
					}
					$data1['Posting_Date'] = date('Y-m-d H:i:s');
					$data1['Account_ID'] = $data['Account_ID'];
					if($this->input->post('app') == 0){
						$data1['Log_Status'] = 'Not Approve';
					}else{
						$data1['Log_Status'] = 'Approve';
					}

					$insert = $this->model_app->insert_data('Ms_Vendor_MDG_Approval', $data);
					$insert1 = $this->model_app->insert_data('MDG_Log', $data1);

					$acd = '';
					foreach($cek_id->result() as $cd){
						$acd = $cd->vaccount;
					}
					$cek_mapping_approval = $this->db->query("select * from Ms_Mapping where Account_ID = '".$acd."'");
					$cek_approval = $this->db->query("select m.*,t.*,p.*,ap.ObjectID as Approval_ID, ap.Squel as Squel, ap.ParentObjectID as MDG_Approval, ap.MDG_Approval as Approval, ap.MDG_Remark as remark, ap.Account_ID as ID_approver from Ms_Vendor_MDG as m inner join Ms_Vendor_Type as t on m.MDG_VendorType_ID = t.VendorType_ID inner join Ms_Vendor_Province as p on m.VendorProvince_ID = p.VendorProvince_ID inner join Ms_Vendor_MDG_Approval as ap on ap.ParentObjectID = m.MDG_Vendor_ID where MDG_Vendor_ID = '".$data['ParentObjectID']."' and ap.Squel = '".$data['Squel']."'");
					if($cek_mapping_approval->num_rows() == $cek_approval->num_rows()){
						$data_change_status['MDG_Status'] = 4;
					}else{
						$data_change_status['MDG_Status'] = 3;
					}

					$iupdate = $this->model_app->update_data('Ms_Vendor_MDG', 'MDG_Vendor_ID', $data['ParentObjectID'], $data_change_status);

					if(!$insert){
						$data = array(
							'status' => 'fail'
						);
						echo json_encode($data);
					}else{
						if($insert1){
							$get_administrator = $this->db->query("select * from Ms_Account where SO_Level = '1'");
							foreach($get_administrator->result() as $adm){
								//send to mailer
								$username = 'mailer.goc';
								$sender_email = 'mailer.goc@gmail.com';
								$user_password = 'gl0ria0rigitac0smetic';
								$subject = 'MDG Application | Approval Master Data Vendor';

								$message = '<div style="background-color:#f9f9f9;font-family:Helvetica,Arial,sans-serif;">
														<table style="margin:1% 5%;background-color:#fff;border-collapse:collapse;width:90%;border:none;">
															<tbody>
																<tr style="background-image:url(http://purbasari.com/assets/background-flat.jpg);background-size:cover;">
																	<td style="width:100%;padding:0px;" colspan="2">
																		<table style="width:100%;height:300px;background-color:#000;opacity:0.5">
																			<tr>
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
																			<tr>
																				<td>
																					<div style="margin-left:10px;color:#999;">
																					<p>Hi, '.$adm->Account_First_Name.' '.$adm->Account_Last_Name.',</p>
																					<p>We have received approval form (Master Data Vendor).<br/>Now you can look at the bottom for link form master data vendor, Please visit here.</p>
																						<p>
																							Link (Approve):	'.base_url().'index.php/request/get_vendor/'.$data['ParentObjectID'].'<br/>
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
																	<td style="width:100%;padding:10px 0px;" colspan="2">
																		<table>
																			<tr>
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
																			<tr style="text-align:center;">
																				<td style="width:95%;font-family:arial;padding-top:0px;padding-bottom:10px;padding-right:10px;border-collapse:collapse;text-align:justify">
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
														</div>';

								//$message = 'test';
								// Configure email library
								$config['protocol'] = 'smtp';
								$config['smtp_host'] = 'ssl://smtp.googlemail.com';
								$config['smtp_port'] = 465;
								$config['smtp_user'] = $sender_email;
								$config['smtp_pass'] = $user_password;
								$config['mailtype'] = 'html';
								$config['charset'] = 'iso-8859-1';

								// Load email library and passing configured values to email library
								$this->load->library('email', $config);
								$this->email->set_newline("\r\n");
								// Sender email address
								$this->email->from($sender_email, $username);
								// Receiver email address
								$this->email->to($adm->Account_Email);
								$this->email->cc('it.mis@goc.co.id');
								// Subject of email
								$this->email->subject($subject);
								// Message in email
								$this->email->message($message);
								// Action Sending Mesage
								$send_user = $this->email->send();
								//end of function send to mailer
							}

							foreach($cek_id->result() as $cd){
								$to = $cd->Account_ID;
								$mail = $cd->Account_Email;
								$nm = $cd->Account_First_Name.' '.$cd->Account_Last_Name;
							}
							$id_log_req_save = '';
							$cek_log_req = $this->db->query("select top 1 LOG_ID from Ms_Vendor_MDG_Log where MDG_Vendor_ID = '".$data['ParentObjectID']."' order by LOG_ID desc");
							foreach($cek_log_req->result() as $log_d){
								$id_log_req_save = $log_d->LOG_ID;
							}
							$outbox['OutboxMDG_ID'] = $this->model_app->getMaxKode('NewOutbox', 'OutboxMDG_ID', 'OTBX');
							$outbox['OutboxMDG_To'] = $mail;
							$outbox['OutboxMDG_From_Account'] = $data['Account_ID'];
							$outbox['OutboxMDG_To_Account'] = $to;
							$outbox['OutboxMDG_Subject'] = 'Approval '.$data['ParentObjectID'];
							$outbox['OutboxMDG_ShortText'] = substr("Hi, ".$nm." We have received approval form (Master Data Vendor). Now you can look at the bottom for link form master data vendor, Please visit here.",0,90);
							$outbox['OutboxMDG_Send'] = date('Y-m-d H:i:s');
							$outbox['OutboxMDG_Link'] = 'index.php/request/outbox/vendor/'.$data['ParentObjectID'];
							$outbox['OutboxType'] = 'Approval';
							$outbox['MDG_ID'] = $data['ParentObjectID'];
							$outbox['LOG_ID'] = $id_log_req_save;
							$outbox['OutboxMDG_Status'] = 0;
							$insert_outbox = $this->model_app->insert_data('NewOutbox', $outbox);


							$inbox['InboxMDG_ID'] = $this->model_app->getMaxKode('NewInbox', 'InboxMDG_ID', 'INBX');
							$inbox['InboxMDG_From'] = $mail;
							$inbox['InboxMDG_From_Account'] = $data['Account_ID'];
							$inbox['InboxMDG_To_Account'] = $to;
							$inbox['InboxMDG_Subject'] = 'Approval '.$data['ParentObjectID'];
							$inbox['InboxMDG_ShortText'] = substr("Hi, ".$nm." We have received approval form (Master Data Vendor). Now you can look at the bottom for link form master data vendor, Please visit here.",0,90);
							$inbox['InboxMDG_Arrived'] = date('Y-m-d H:i:s');
							$inbox['InboxMDG_Link'] = 'index.php/request/inbox/vendor/'.$data['ParentObjectID'];
							$inbox['InboxType'] = 'Approval';
							$inbox['MDG_ID'] = $data['ParentObjectID'];
							$inbox['LOG_ID'] = $id_log_req_save;
							$inbox['InboxMDG_Status'] = 0;
							$insert_inbox = $this->model_app->insert_data('NewInbox', $inbox);


							$newupdate['Account_ID'] = $data['Account_ID'];
							$newupdate['Account_To'] = $to;
							$newupdate['New_ActyDt'] = date('Y-m-d H:i:s');
							$newupdate['New_Type'] = 'Approval';
							$newupdate['New_Description'] = "Request Master Vendor ".$data['ParentObjectID'];
							$newupdate['MDG_ID'] = $data['ParentObjectID'];
							$newupdate['LOG_ID'] = $id_log_req_save;
							$newupdate['New_Link'] = 'index.php/request/new/vendor/'.$data['ParentObjectID'];
							$newupdate['New_Status'] = 0;
							$insert_newupdate = $this->model_app->insert_data('NewUpdate', $newupdate);

							if($insert_outbox){
								if($insert_inbox){
									if($insert_newupdate){
										$data = array(
											'status' => 'success'
										);
										echo json_encode($data);
									}

									else{
										$data = array(
											'status' => 'gagal'
										);
										echo json_encode($data);
									}
								}

								else{
									$data = array(
										'status' => 'gagal2'
									);
									echo json_encode($data);
								}
							}

							else{
								$data = array(
									'status' => 'gagal3'
								);
								echo json_encode($data);
							}
						}else{
							$data = array(
								'status' => 'notlog',
								'id' => $data['MDG_Vendor_ID']
							);
							echo json_encode($data);
						}
					}
				}else{
					$data = array(
						'status' => 'id_invalid'
					);
				}
			}else{
				$data = array(
					'status' => 'acc_invalid'
				);
			}
		}
	}

	function get_approval_customer(){
		date_default_timezone_set('Asia/Jakarta');
		if($this->input->post('app') == '' or $this->input->post('acc') == '' or $this->input->post('id') == ''){
			$data = array(
				'status' => 'require'
			);
			echo json_encode($data);
		}else{
			$cek_acc = $this->db->query("select * from Ms_Account where Account_ID = '".$this->input->post('acc')."'");
			if($cek_acc->num_rows() > 0){
				$cek_id = $this->db->query("select v.Account_ID as vaccount, v.*, a.* from Ms_Customer_MDG as v inner join Ms_Account as a on v.Account_ID = a.Account_ID  where MDG_Customer_ID = '".$this->input->post('id')."' and (MDG_Status = 2 or MDG_Status = 3)");
				if($cek_id->num_rows() > 0){
					$query_cek_squel = $this->db->query("select top 1 Squel from Ms_Customer_MDG_Approval where ParentObjectID = '".$this->input->post('id')."' and Account_ID = '".$this->input->post('acc')."' order by ObjectID desc");
					if($query_cek_squel->num_rows() == 0){
						$data['Squel'] = 1;
					}else{
						foreach($query_cek_squel->result() as $sq){
							$data['Squel'] = $sq->Squel + 1;
						}
					}
					$data['ParentObjectID'] = $this->input->post('id');
					$data['MDG_Approval'] = $this->input->post('app');
					$data['MDG_Remark'] = $this->input->post('remark');
					$data['Account_ID'] = $this->input->post('acc');

					$query_log = $this->db->query("select * from Ms_Account where Account_ID = '".$data['Account_ID']."'");
					foreach($query_log->result() as $acca){
						$data1['Account_Name'] = $acca->Account_First_Name.' '.$acca->Account_Last_Name;
					}

					$data1['MDG_Type'] = 'Customer';
					$data1['MDG_Category'] = 'Approval';
					$data1['MDG_ID'] = $data['ParentObjectID'];
					if($this->input->post('app') == 0){
						$data1['Information'] = 'Request Data Customer (Not Approval) | '.$data['MDG_Remark'];
					}else{
						$data1['Information'] = 'Request Data Customer (Approval) | '.$data['MDG_Remark'];
					}
					$data1['Posting_Date'] = date('Y-m-d H:i:s');
					$data1['Account_ID'] = $data['Account_ID'];
					if($this->input->post('app') == 0){
						$data1['Log_Status'] = 'Not Approve';
					}else{
						$data1['Log_Status'] = 'Approve';
					}

					$insert = $this->model_app->insert_data('Ms_Customer_MDG_Approval', $data);
					$insert1 = $this->model_app->insert_data('MDG_Log', $data1);

					$acd = '';
					foreach($cek_id->result() as $cd){
						$acd = $cd->vaccount;
					}
					$cek_mapping_approval = $this->db->query("select * from Ms_Mapping where Account_ID = '".$acd."'");
					$cek_approval = $this->db->query("select m.*,t.*,p.*,ap.ObjectID as Approval_ID, ap.Squel as Squel, ap.ParentObjectID as MDG_Approval, ap.MDG_Approval as Approval, ap.MDG_Remark as remark, ap.Account_ID as ID_approver from Ms_Customer_MDG as m inner join Ms_Customer_Type as t on m.MDG_CustomerType_ID = t.CustomerType_ID inner join Ms_Customer_Province as p on m.CustomerProvince_ID = p.CustomerProvince_ID inner join Ms_Customer_MDG_Approval as ap on ap.ParentObjectID = m.MDG_Customer_ID where MDG_Customer_ID = '".$data['ParentObjectID']."' and ap.Squel = '".$data['Squel']."'");
					if($cek_mapping_approval->num_rows() == $cek_approval->num_rows()){
						$data_change_status['MDG_Status'] = 4;
					}else{
						$data_change_status['MDG_Status'] = 3;
					}

					$iupdate = $this->model_app->update_data('Ms_Customer_MDG', 'MDG_Customer_ID', $data['ParentObjectID'], $data_change_status);

					if(!$insert){
						$data = array(
							'status' => 'fail'
						);
						echo json_encode($data);
					}else{
						if($insert1){
							$get_administrator = $this->db->query("select * from Ms_Account where SO_Level = '1'");
							foreach($get_administrator->result() as $adm){
								//send to mailer
								$username = 'mailer.goc';
								$sender_email = 'mailer.goc@gmail.com';
								$user_password = 'gl0ria0rigitac0smetic';
								$subject = 'MDG Application | Approval Master Data Customer';

								$message = '<div style="background-color:#f9f9f9;font-family:Helvetica,Arial,sans-serif;">
														<table style="margin:1% 5%;background-color:#fff;border-collapse:collapse;width:90%;border:none;">
															<tbody>
																<tr style="background-image:url(http://purbasari.com/assets/background-flat.jpg);background-size:cover;">
																	<td style="width:100%;padding:0px;" colspan="2">
																		<table style="width:100%;height:300px;background-color:#000;opacity:0.5">
																			<tr>
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
																			<tr>
																				<td>
																					<div style="margin-left:10px;color:#999;">
																					<p>Hi, '.$adm->Account_First_Name.' '.$adm->Account_Last_Name.',</p>
																					<p>We have received approval form (Master Data Customer).<br/>Now you can look at the bottom for link form master data customer, Please visit here.</p>
																						<p>
																							Link (Approve):	'.base_url().'index.php/request/get_customer/'.$data['ParentObjectID'].'<br/>
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
																	<td style="width:100%;padding:10px 0px;" colspan="2">
																		<table>
																			<tr>
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
																			<tr style="text-align:center;">
																				<td style="width:95%;font-family:arial;padding-top:0px;padding-bottom:10px;padding-right:10px;border-collapse:collapse;text-align:justify">
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
														</div>';

								//$message = 'test';
								// Configure email library
								$config['protocol'] = 'smtp';
								$config['smtp_host'] = 'ssl://smtp.googlemail.com';
								$config['smtp_port'] = 465;
								$config['smtp_user'] = $sender_email;
								$config['smtp_pass'] = $user_password;
								$config['mailtype'] = 'html';
								$config['charset'] = 'iso-8859-1';

								// Load email library and passing configured values to email library
								$this->load->library('email', $config);
								$this->email->set_newline("\r\n");
								// Sender email address
								$this->email->from($sender_email, $username);
								// Receiver email address
								$this->email->to($adm->Account_Email);
								$this->email->cc('it.mis@goc.co.id');
								// Subject of email
								$this->email->subject($subject);
								// Message in email
								$this->email->message($message);
								// Action Sending Mesage
								$send_user = $this->email->send();
								//end of function send to mailer
							}

							foreach($cek_id->result() as $cd){
								$to = $cd->Account_ID;
								$mail = $cd->Account_Email;
								$nm = $cd->Account_First_Name.' '.$cd->Account_Last_Name;
							}
							$id_log_req_save = '';
							$cek_log_req = $this->db->query("select top 1 LOG_ID from Ms_Customer_MDG_Log where MDG_Customer_ID = '".$data['ParentObjectID']."' order by LOG_ID desc");
							foreach($cek_log_req->result() as $log_d){
								$id_log_req_save = $log_d->LOG_ID;
							}
							$outbox['OutboxMDG_ID'] = $this->model_app->getMaxKode('NewOutbox', 'OutboxMDG_ID', 'OTBX');
							$outbox['OutboxMDG_To'] = $mail;
							$outbox['OutboxMDG_From_Account'] = $data['Account_ID'];
							$outbox['OutboxMDG_To_Account'] = $to;
							$outbox['OutboxMDG_Subject'] = 'Approval '.$data['ParentObjectID'];
							$outbox['OutboxMDG_ShortText'] = substr("Hi, ".$nm." We have received approval form (Master Data Customer). Now you can look at the bottom for link form master data customer, Please visit here.",0,90);
							$outbox['OutboxMDG_Send'] = date('Y-m-d H:i:s');
							$outbox['OutboxMDG_Link'] = 'index.php/request/outbox/customer/'.$data['ParentObjectID'];
							$outbox['OutboxType'] = 'Approval';
							$outbox['MDG_ID'] = $data['ParentObjectID'];
							$outbox['LOG_ID'] = $id_log_req_save;
							$outbox['OutboxMDG_Status'] = 0;
							$insert_outbox = $this->model_app->insert_data('NewOutbox', $outbox);


							$inbox['InboxMDG_ID'] = $this->model_app->getMaxKode('NewInbox', 'InboxMDG_ID', 'INBX');
							$inbox['InboxMDG_From'] = $mail;
							$inbox['InboxMDG_From_Account'] = $data['Account_ID'];
							$inbox['InboxMDG_To_Account'] = $to;
							$inbox['InboxMDG_Subject'] = 'Approval '.$data['ParentObjectID'];
							$inbox['InboxMDG_ShortText'] = substr("Hi, ".$nm." We have received approval form (Master Data Customer). Now you can look at the bottom for link form master data customer, Please visit here.",0,90);
							$inbox['InboxMDG_Arrived'] = date('Y-m-d H:i:s');
							$inbox['InboxMDG_Link'] = 'index.php/request/inbox/customer/'.$data['ParentObjectID'];
							$inbox['InboxType'] = 'Approval';
							$inbox['MDG_ID'] = $data['ParentObjectID'];
							$inbox['LOG_ID'] = $id_log_req_save;
							$inbox['InboxMDG_Status'] = 0;
							$insert_inbox = $this->model_app->insert_data('NewInbox', $inbox);


							$newupdate['Account_ID'] = $data['Account_ID'];
							$newupdate['Account_To'] = $to;
							$newupdate['New_ActyDt'] = date('Y-m-d H:i:s');
							$newupdate['New_Type'] = 'Approval';
							$newupdate['New_Description'] = "Request Master Customer ".$data['ParentObjectID'];
							$newupdate['MDG_ID'] = $data['ParentObjectID'];
							$newupdate['LOG_ID'] = $id_log_req_save;
							$newupdate['New_Link'] = 'index.php/request/new/customer/'.$data['ParentObjectID'];
							$newupdate['New_Status'] = 0;
							$insert_newupdate = $this->model_app->insert_data('NewUpdate', $newupdate);

							if($insert_outbox){
								if($insert_inbox){
									if($insert_newupdate){
										$data = array(
											'status' => 'success'
										);
										echo json_encode($data);
									}

									else{
										$data = array(
											'status' => 'gagal'
										);
										echo json_encode($data);
									}
								}

								else{
									$data = array(
										'status' => 'gagal2'
									);
									echo json_encode($data);
								}
							}

							else{
								$data = array(
									'status' => 'gagal3'
								);
								echo json_encode($data);
							}
						}else{
							$data = array(
								'status' => 'notlog',
								'id' => $data['MDG_Customer_ID']
							);
							echo json_encode($data);
						}
					}
				}else{
					$data = array(
						'status' => 'id_invalid'
					);
				}
			}else{
				$data = array(
					'status' => 'acc_invalid'
				);
			}
		}
	}


	function cek_approval_next_ver($id, $ac){
		$id = $this->uri->segment(3);
		$ac = $this->uri->segment(4);
		//$acc = $this->uri->segment(4);
		//$query_cek = $this->db->query("selecT top 1 * from Ms_Vendor_MDG_Approval where ParentObjectID = '".$id."' and Account_ID = '".$acc."' order by ObjectID desc");
		$query_cek_MDG = $this->db->query("select * from Ms_Vendor_MDG where MDG_Vendor_ID = '".$id."' and (MDG_Status = '2' or MDG_Status ='3')");
		if($query_cek_MDG->num_rows() > 0){
			foreach($query_cek_MDG->result() as $c){
				if($c->MDG_Status == 2){
					$data = array(
						'status' => 'ada'
					);
					echo json_encode($data);
				}else if($c->MDG_Status == 3){
					$query_cek_squel_a = $this->db->query("select top 1 ObjectID, Squel from Ms_Vendor_MDG_Approval where ParentObjectID = '".$id."' order by ObjectID desc");
					foreach($query_cek_squel_a->result() as $sql){
						$query_cek_inputan = $this->db->query("select * from Ms_Vendor_MDG as h inner join Ms_Vendor_MDG_Approval as d on h.MDG_Vendor_ID = d.ParentObjectID where d.Squel = '".$sql->Squel."' and h.MDG_Vendor_ID = '".$id."' and d.Account_ID = '".$ac."'");
					}

					if($query_cek_inputan->num_rows() > 0){
						$data = array(
							'status' => 'gak'
						);
						echo json_encode($data);
					}else{
						$data = array(
							'status' => 'ada'
						);
						echo json_encode($data);
					}
				}
			}
		}else{
			$data = array(
				'status' => 'gak'
			);
			echo json_encode($data);
		}

	}

	function cek_approval_customer_next_ver($id, $ac){
		$id = $this->uri->segment(3);
		$ac = $this->uri->segment(4);
		//$acc = $this->uri->segment(4);
		//$query_cek = $this->db->query("selecT top 1 * from Ms_Vendor_MDG_Approval where ParentObjectID = '".$id."' and Account_ID = '".$acc."' order by ObjectID desc");
		$query_cek_MDG = $this->db->query("select * from Ms_Customer_MDG where MDG_Customer_ID = '".$id."' and (MDG_Status = '2' or MDG_Status ='3')");
		if($query_cek_MDG->num_rows() > 0){
			foreach($query_cek_MDG->result() as $c){
				if($c->MDG_Status == 2){
					$data = array(
						'status' => 'ada'
					);
					echo json_encode($data);
				}else if($c->MDG_Status == 3){
					$query_cek_squel_a = $this->db->query("select top 1 ObjectID, Squel from Ms_Customer_MDG_Approval where ParentObjectID = '".$id."' order by ObjectID desc");
					foreach($query_cek_squel_a->result() as $sql){
						$query_cek_inputan = $this->db->query("select * from Ms_Customer_MDG as h inner join Ms_Customer_MDG_Approval as d on h.MDG_Customer_ID = d.ParentObjectID where d.Squel = '".$sql->Squel."' and h.MDG_Customer_ID = '".$id."' and d.Account_ID = '".$ac."'");
					}

					if($query_cek_inputan->num_rows() > 0){
						$data = array(
							'status' => 'gak'
						);
						echo json_encode($data);
					}else{
						$data = array(
							'status' => 'ada'
						);
						echo json_encode($data);
					}
				}
			}
		}else{
			$data = array(
				'status' => 'gak'
			);
			echo json_encode($data);
		}

	}

	function click_approval(){
		//$ap = $this->input->post('ap');
		$ap = $this->uri->segment(3);
		$ap3 = $ap;

		$data1 = array();
		$data2 = array();
		$a = '';

		$cek_squel = $this->db->query("select top 1 Squel from Ms_Vendor_MDG_Approval where ParentObjectID = '".$ap."' order by ObjectID desc");
		foreach($cek_squel->result() as $sq){
			$cek_c_app = $this->db->query("select v.Account_ID as Requester, a.Account_ID as Approval_Act from Ms_Vendor_MDG_Approval as a inner join Ms_Vendor_MDG as v on a.ParentObjectID = v.MDG_Vendor_ID where a.Squel = ".$sq->Squel." and a.ParentObjectID = '".$ap."'");
			foreach($cek_c_app->result() as $c_app){
				$data1[] = $c_app->Approval_Act;
				$a = $c_app->Requester;
			}
		}

		$cek_m_app = $this->db->query("select * from Ms_Mapping where Account_ID = '".$a."'");
		foreach($cek_m_app->result() as $m_app){
			$data2[] = $m_app->Mapping_approval_person;
		}

		$result = array_intersect($data1, $data2);

		foreach($cek_squel->result() as $sq){
			$sql = $sq->Squel;
		}

		for($i=0;$i<count($result);$i++){
			$query_aa = $this->db->query("select * from Ms_Vendor_MDG_Approval where Squel = '".$sql."' and Account_ID = '".$result[$i]."' and ParentObjectID = '".$ap3."'");
			foreach($query_aa->result() as $aa){
				$data111[] = array(
					'status' => $aa->MDG_Approval,
					'account' => $aa->Account_ID,
				);
				//echo json_encode($data1);
			}
		}

		echo json_encode($data111);
	}

	function click_approval_customer(){
		//$ap = $this->input->post('ap');
		$ap = $this->uri->segment(3);
		$ap3 = $ap;

		$data1 = array();
		$data2 = array();
		$a = '';

		$cek_squel = $this->db->query("select top 1 Squel from Ms_Customer_MDG_Approval where ParentObjectID = '".$ap."' order by ObjectID desc");
		foreach($cek_squel->result() as $sq){
			$cek_c_app = $this->db->query("select v.Account_ID as Requester, a.Account_ID as Approval_Act from Ms_Customer_MDG_Approval as a inner join Ms_Customer_MDG as v on a.ParentObjectID = v.MDG_Customer_ID where a.Squel = ".$sq->Squel." and a.ParentObjectID = '".$ap."'");
			foreach($cek_c_app->result() as $c_app){
				$data1[] = $c_app->Approval_Act;
				$a = $c_app->Requester;
			}
		}

		$cek_m_app = $this->db->query("select * from Ms_Mapping where Account_ID = '".$a."'");
		foreach($cek_m_app->result() as $m_app){
			$data2[] = $m_app->Mapping_approval_person;
		}

		$result = array_intersect($data1, $data2);

		foreach($cek_squel->result() as $sq){
			$sql = $sq->Squel;
		}

		for($i=0;$i<count($result);$i++){
			$query_aa = $this->db->query("select * from Ms_Customer_MDG_Approval where Squel = '".$sql."' and Account_ID = '".$result[$i]."' and ParentObjectID = '".$ap3."'");
			foreach($query_aa->result() as $aa){
				$data111[] = array(
					'status' => $aa->MDG_Approval,
					'account' => $aa->Account_ID,
				);
				//echo json_encode($data1);
			}
		}

		echo json_encode($data111);
	}

	function all_approval(){
		$ap = $this->uri->segment(3);

		$query_a = $this->db->query("select * from Ms_Vendor_MDG where MDG_Vendor_ID = '".$ap."'");
		foreach($query_a->result() as $a){
			$key = $a->Account_ID;
		}

		$query = $this->db->query("select * from Ms_Mapping as m inner join Ms_Account as a on m.Mapping_approval_person = a.Account_ID where m.Account_ID = '".$key."'");
		foreach($query->result() as $grid5){
			$data[] = $grid5;
		}
		echo json_encode($data);
	}

	function all_approval_customer(){
		$ap = $this->uri->segment(3);

		$query_a = $this->db->query("select * from Ms_Customer_MDG where MDG_Customer_ID = '".$ap."'");
		foreach($query_a->result() as $a){
			$key = $a->Account_ID;
		}

		$query = $this->db->query("select * from Ms_Mapping as m inner join Ms_Account as a on m.Mapping_approval_person = a.Account_ID where m.Account_ID = '".$key."'");
		foreach($query->result() as $grid5){
			$data[] = $grid5;
		}
		echo json_encode($data);
	}

	//-------------------------------------------------------inbox outbox------------------------------------------------------------------------------//

	function inbox($ct, $id, $ty, $ac, $id_inbox){
		$ct = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$ty = $this->uri->segment(5);
		$ac = $this->uri->segment(6);
		$id_inbox = $this->uri->segment(7);

		$cek_status = $this->session->userdata('success_data');
		if(!$cek_status){
			$this->load->view('top_view');
			$this->load->view('welcome_view');
			$this->load->view('bottom_view');
		}else{
			$query = $this->db->query("select * from Ms_Account as a inner join Ms_Account_Privacy as p on a.User_ID = p.User_ID where Account_ID = '".$this->session->userdata('account_id')."'");
			$query_c_update = $this->db->query("select * from NewUpdate where New_Status = 0 and Account_To = '".$this->session->userdata('account_id')."'");
			foreach($query->result() as $acc){
				$data['first_name'] = $acc->Account_First_Name;
				$data['last_name'] = $acc->Account_Last_Name;
				$data['username'] = $acc->Username;
			}

			$data['c_update'] = $query_c_update->num_rows();
			if($ct == 'vendor'){
				if($ty == 'request' or $ty == 'Request'){
					$data['id_mdg'] = $id;
					$data['id_acc'] = $ac;

					$query = $this->db->query("select * from Ms_Account where Account_ID = '".$ac."'");
					foreach($query->result() as $db){
						$data['first'] = $db->Account_First_Name;
						$data['last'] = $db->Account_Last_Name;
					}

					$this->load->view('top_view');
					$this->load->view('inbox_detail_request_view',$data);
					$this->load->view('bottom_view');
				}else if($ty == 'approval' or $ty == 'Approval'){
					$this->load->view('top_view');
					$this->load->view('inbox_detail_approval_view',$data);
					$this->load->view('bottom_view');
				}
			}else if($ct == 'customer'){
				if($ty == 'request' or $ty == 'Request'){
					$data['id_mdg'] = $id;
					$data['id_acc'] = $ac;

					$query = $this->db->query("select * from Ms_Account where Account_ID = '".$ac."'");
					foreach($query->result() as $db){
						$data['first'] = $db->Account_First_Name;
						$data['last'] = $db->Account_Last_Name;
					}

					$this->load->view('top_view');
					$this->load->view('inbox_detail_customer_request_view',$data);
					$this->load->view('bottom_view');
				}else if($ty == 'approval' or $ty == 'Approval'){
					$this->load->view('top_view');
					$this->load->view('inbox_detail_customer_approval_view',$data);
					$this->load->view('bottom_view');
				}
			}
		}
	}

	function new($ct, $id, $ty, $ac, $id_new, $id_log){
		$ct = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$ty = $this->uri->segment(5);
		$ac = $this->uri->segment(6);
		$id_new = $this->uri->segment(7);
		$id_log = $this->uri->segment(8);

		$cek_status = $this->session->userdata('success_data');
		if(!$cek_status){
			$this->load->view('top_view');
			$this->load->view('welcome_view');
			$this->load->view('bottom_view');
		}else{
			$query = $this->db->query("select * from Ms_Account as a inner join Ms_Account_Privacy as p on a.User_ID = p.User_ID where Account_ID = '".$this->session->userdata('account_id')."'");
			$query_c_update = $this->db->query("select * from NewUpdate where New_Status = 0 and Account_To = '".$this->session->userdata('account_id')."'");
			foreach($query->result() as $acc){
				$data['first_name'] = $acc->Account_First_Name;
				$data['last_name'] = $acc->Account_Last_Name;
				$data['username'] = $acc->Username;
			}

			$data['c_update'] = $query_c_update->num_rows();
			if($ct == 'vendor'){
				if($ty == 'request' or $ty == 'Request'){
					$data['id_mdg'] = $id;
					$data['id_acc'] = $ac;

					$query = $this->db->query("select * from Ms_Account where Account_ID = '".$ac."'");
					foreach($query->result() as $db){
						$data['first'] = $db->Account_First_Name;
						$data['last'] = $db->Account_Last_Name;
					}

					$this->load->view('top_view');
					$this->load->view('inbox_detail_request_view',$data);
					$this->load->view('bottom_view');
				}else if($ty == 'approval' or $ty == 'Approval'){
					$this->load->view('top_view');
					$this->load->view('inbox_detail_approval_view',$data);
					$this->load->view('bottom_view');
				}
			}else if($ct == 'customer'){
				if($ty == 'request' or $ty == 'Request'){
					$data['id_mdg'] = $id;
					$data['id_acc'] = $ac;

					$query = $this->db->query("select * from Ms_Account where Account_ID = '".$ac."'");
					foreach($query->result() as $db){
						$data['first'] = $db->Account_First_Name;
						$data['last'] = $db->Account_Last_Name;
					}

					$this->load->view('top_view');
					$this->load->view('inbox_detail_customer_request_view',$data);
					$this->load->view('bottom_view');
				}else if($ty == 'approval' or $ty == 'Approval'){
					$this->load->view('top_view');
					$this->load->view('inbox_detail_customer_approval_view',$data);
					$this->load->view('bottom_view');
				}
			}
		}
	}

	function outbox($ct, $id, $ty, $ac, $id_outbox){
		$ct = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$ty = $this->uri->segment(5);
		$ac = $this->uri->segment(6);
		$id_outbox = $this->uri->segment(7);

		$cek_status = $this->session->userdata('success_data');
		if(!$cek_status){
			$this->load->view('top_view');
			$this->load->view('welcome_view');
			$this->load->view('bottom_view');
		}else{
			$query = $this->db->query("select * from Ms_Account as a inner join Ms_Account_Privacy as p on a.User_ID = p.User_ID where Account_ID = '".$this->session->userdata('account_id')."'");
			$query_c_update = $this->db->query("select * from NewUpdate where New_Status = 0 and Account_To = '".$this->session->userdata('account_id')."'");
			foreach($query->result() as $acc){
				$data['first_name'] = $acc->Account_First_Name;
				$data['last_name'] = $acc->Account_Last_Name;
				$data['username'] = $acc->Username;
			}

			$data['c_update'] = $query_c_update->num_rows();
			if($ct == 'vendor'){
				if($ty == 'request' or $ty == 'Request'){
					$data['id_mdg'] = $id;
					$data['id_acc'] = $ac;

					$query = $this->db->query("select * from Ms_Account where Account_ID = '".$ac."'");
					foreach($query->result() as $db){
						$data['first'] = $db->Account_First_Name;
						$data['last'] = $db->Account_Last_Name;
					}

					$this->load->view('top_view');
					$this->load->view('inbox_detail_request_view',$data);
					$this->load->view('bottom_view');
				}else if($ty == 'approval' or $ty == 'Approval'){
					$this->load->view('top_view');
					$this->load->view('inbox_detail_approval_view',$data);
					$this->load->view('bottom_view');
				}
			}else if($ct == 'customer'){
				if($ty == 'request' or $ty == 'Request'){
					$data['id_mdg'] = $id;
					$data['id_acc'] = $ac;

					$query = $this->db->query("select * from Ms_Account where Account_ID = '".$ac."'");
					foreach($query->result() as $db){
						$data['first'] = $db->Account_First_Name;
						$data['last'] = $db->Account_Last_Name;
					}

					$this->load->view('top_view');
					$this->load->view('inbox_detail_customer_request_view',$data);
					$this->load->view('bottom_view');
				}else if($ty == 'approval' or $ty == 'Approval'){
					$this->load->view('top_view');
					$this->load->view('inbox_detail_customer_approval_view',$data);
					$this->load->view('bottom_view');
				}
			}
		}
	}

	function read_request($io, $id_outbox){
		$io = $this->uri->segment(3);
		$id_outbox = $this->uri->segment(4);

		if($io == 'inbox'){
			$query = $this->db->query("select * from NewInbox where InboxMDG_ID = '".$id_outbox."' and InboxMDG_Status = 0");
			if($query->num_rows() > 0){
					$update = $this->db->query("update NewInbox set InboxMDG_Status = 1 where InboxMDG_ID = '".$id_outbox."'");

					foreach($query->result() as $qu){
						$query_update = $this->db->query("update NewUpdate set New_Status = '1' where Account_ID = '".$qu->InboxMDG_From_Account."' and Account_To = '".$qu->InboxMDG_To_Account."' and MDG_ID = '".$qu->MDG_ID."' and LOG_ID = '".$qu->LOG_ID."' and New_Type = '".$qu->InboxType."'");
					}
			}
		}else if($io == 'new'){
			$query = $this->db->query("select * from NewUpdate where ObjectID = '".$id_outbox."' and New_Status = 0");
			if($query->num_rows() > 0){
					$update = $this->db->query("update NewUpdate set New_Status = 1 where ObjectID = '".$id_outbox."'");

					foreach($query->result() as $qu){
						$query_update = $this->db->query("update NewInbox set InboxMDG_Status = '1' where InboxMDG_From_Account = '".$qu->Account_ID."' and InboxMDG_To_Account = '".$qu->Account_To."' and MDG_ID = '".$qu->MDG_ID."' and LOG_ID = '".$qu->LOG_ID."' and InboxType = '".$qu->New_Type."'");
					}
			}
		}
		else if($io == 'outbox'){
			$query = $this->db->query("select * from NewOutbox where OutboxMDG_ID = '".$id_outbox."' and OutboxMDG_Status = 0");
			if($query->num_rows() > 0){
					$update = $this->db->query("update NewOutbox set OutboxMDG_Status = 1 where OutboxMDG_ID = '".$id_outbox."'");
			}
		}
	}

	function get_data_detail_draft_log($id,$log){
		$id = $this->uri->segment(3);
		$log = $this->uri->segment(4);
		$query = $this->db->query("select * from Ms_Vendor_MDG_Log as m inner join Ms_Vendor_Type as t on m.MDG_VendorType_ID = t.VendorType_ID inner join Ms_Vendor_Province as p on m.VendorProvince_ID = p.VendorProvince_ID where MDG_Vendor_ID = '".$id."' and m.LOG_ID = '".$log."'");
		foreach($query->result() as $grid5){
			$data[] = $grid5;
		}
		echo json_encode($data);
	}

	function get_data_detail_draft_customer_log($id,$log){
		$id = $this->uri->segment(3);
		$log = $this->uri->segment(4);
		$query = $this->db->query("select * from Ms_Customer_MDG_Log as m inner join Ms_Customer_Type as t on m.MDG_CustomerType_ID = t.CustomerType_ID inner join Ms_Customer_Province as p on m.CustomerProvince_ID = p.CustomerProvince_ID
		inner join Ms_Customer_City as c on m.CustomerCity_ID = c.ObjectID inner join Ms_Customer_Term as tr on m.PaymentTerm_ID = tr.ObjectID
		where MDG_Customer_ID = '".$id."' and m.LOG_ID = '".$log."'");
		foreach($query->result() as $grid5){
			$data[] = $grid5;
		}
		echo json_encode($data);
	}

	function get_data_detail_approval($id,$log,$idac,$ct){
		$id = $this->uri->segment(3);
		$log = $this->uri->segment(4);
		$idac = $this->uri->segment(5);
		$ct = $this->uri->segment(6);

		$query = $this->db->query("select LOG_ID from Ms_Vendor_MDG_Log WHERE MDG_Vendor_ID = '".$id."' order by ObjectID");
		foreach($query->result() as $db){
			$log_data[] = $db->LOG_ID;
		}

		$key = array_search($log, $log_data) + 1;

		if($ct == 'new'){
			$query_data = $this->db->query("select * from Ms_Vendor_MDG_Approval as a inner join NewUpdate as u on a.ParentObjectID = u.MDG_ID
where u.MDG_ID = '".$id."' and New_Type = 'Approval' and u.ObjectID = '".$idac."' and a.Account_ID = u.Account_ID and Squel = '".$key."'");
			foreach($query_data->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
		}else if($ct == 'inbox'){
			$query_data = $this->db->query("select * from Ms_Vendor_MDG_Approval as a inner join NewInbox as u on a.ParentObjectID = u.MDG_ID
where u.MDG_ID = '".$id."' and u.InboxType = 'Approval' and u.InboxMDG_ID = '".$idac."' and a.Account_ID = u.InboxMDG_From_Account and Squel = '".$key."'");
			foreach($query_data->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
		}else if($ct == 'outbox'){
			$query_data = $this->db->query("select * from Ms_Vendor_MDG_Approval as a inner join NewOutbox as u on a.ParentObjectID = u.MDG_ID
where u.MDG_ID = '".$id."' and u.OutboxType = 'Approval' and u.OutboxMDG_ID = '".$idac."' and a.Account_ID = u.OutboxMDG_From_Account and Squel = '".$key."'");
			foreach($query_data->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
		}
	}

	function get_data_detail_customer_approval($id,$log,$idac,$ct){
		$id = $this->uri->segment(3);
		$log = $this->uri->segment(4);
		$idac = $this->uri->segment(5);
		$ct = $this->uri->segment(6);

		$query = $this->db->query("select LOG_ID from Ms_Customer_MDG_Log WHERE MDG_Customer_ID = '".$id."' order by ObjectID");
		foreach($query->result() as $db){
			$log_data[] = $db->LOG_ID;
		}

		$key = array_search($log, $log_data) + 1;

		if($ct == 'new'){
			$query_data = $this->db->query("select * from Ms_Customer_MDG_Approval as a inner join NewUpdate as u on a.ParentObjectID = u.MDG_ID
where u.MDG_ID = '".$id."' and New_Type = 'Approval' and u.ObjectID = '".$idac."' and a.Account_ID = u.Account_ID and Squel = '".$key."'");
			foreach($query_data->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
		}else if($ct == 'inbox'){
			$query_data = $this->db->query("select * from Ms_Customer_MDG_Approval as a inner join NewInbox as u on a.ParentObjectID = u.MDG_ID
where u.MDG_ID = '".$id."' and u.InboxType = 'Approval' and u.InboxMDG_ID = '".$idac."' and a.Account_ID = u.InboxMDG_From_Account and Squel = '".$key."'");
			foreach($query_data->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
		}else if($ct == 'outbox'){
			$query_data = $this->db->query("select * from Ms_Customer_MDG_Approval as a inner join NewOutbox as u on a.ParentObjectID = u.MDG_ID
where u.MDG_ID = '".$id."' and u.OutboxType = 'Approval' and u.OutboxMDG_ID = '".$idac."' and a.Account_ID = u.OutboxMDG_From_Account and Squel = '".$key."'");
			foreach($query_data->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
		}
	}

	function deleteMapping(){
		$id = $this->input->post('id');
		$pa = $this->input->post('pa');

		$delete = $this->db->query("delete from Ms_Mapping where Account_ID = '".$id."' and Mapping_approval_person = '".$pa."'");
		if($delete){
			$data = array(
				'status' => 'success'
			);
			echo json_encode($data);
		}else{
			$data = array(
				'status' => 'fail'
			);
			echo json_encode($data);
		}
	}
}
	/*End of file Request.php*/
	/*Location:.Application/controllers/request.php*/
