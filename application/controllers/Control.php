<?php if(!defIned('BASEPATH'))exit('No Direct Script Access Allowed');
  class Control extends CI_Controller{
    function __construct(){
      parent::__construct();
      date_default_timezone_set('Asia/Jakarta');
    }

    function get_export_excel_customer(){
      $this->load->library("Excel/PHPExcel");
            $objPHPExcel = new PHPExcel();

            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->setActiveSheetIndex(0)
                          //mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya
                          //Hello merupakan isinya
                          ->setCellValue('A1', 'DATA CUSTOMER')
                          ->setCellValue('A2', 'MDG Applications')
                          ->setCellValue('A4', 'CUSTOMER ID')
                          ->setCellValue('B4', 'TYPE ID')
                          ->setCellValue('C4', 'TYPE NAME')
                          ->setCellValue('D4', 'TITLE CODE')
                          ->setCellValue('E4', 'CUSTOMER NAME')
                          ->setCellValue('F4', 'SEARCH TERM')
                          ->setCellValue('G4', 'ADDRESS 1')
                          ->setCellValue('H4', 'ADDRESS 2')
                          ->setCellValue('I4', 'ADDRESS 3')
                          ->setCellValue('J4', 'NO')
                          ->setCellValue('K4', 'CITY CODE')
                          ->setCellValue('L4', 'CITY NAME')
                          ->setCellValue('M4', 'POSTAL CODE')
                          ->setCellValue('N4', 'PROVINCE CODE')
                          ->setCellValue('O4', 'PROVINCE NAME')
                          ->setCellValue('P4', 'COUNTRY')
                          ->setCellValue('Q4', 'PHONE')
                          ->setCellValue('R4', 'MOBILE')
                          ->setCellValue('S4', 'NPWP')
                          ->setCellValue('T4', 'PPN')
                          ->setCellValue('U4', 'BANK KEY')
                          ->setCellValue('V4', 'ACCOUNT NO')
                          ->setCellValue('W4', 'ACCOUNT NAME')
                          ->setCellValue('X4', 'SAME BILL')
                          ->setCellValue('Y4', 'BILL TO PARTY')
                          ->setCellValue('Z4', 'PAYMENT TERM ID')
                          ->setCellValue('AA4', 'PAYMENT TERM')
                          ->setCellValue('AB4', 'CREATE DATE')
                          ->setCellValue('AC4', 'UPDATE DATE')
                          ->setCellValue('AD4', 'STATUS')
                          ->setCellValue('AE4', 'ACCOUNT ID')
                          ->setCellValue('AF4', 'ACCOUNT NAME');


                          //mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya
                          //Hello merupakan isinya
            $objPHPExcel->getActiveSheet()->mergeCells('A1:AF1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:AF2');
            $link_style_array = [
      			  'font'  => [
      				'color' => ['rgb' => '555555'],
              'size'  => '14px',
      				'bold' => true
      			  ]
      			];

            $link_style_array2 = [
      			  'font'  => [
      				'color' => ['rgb' => '555555'],
              'size'  => '12px',
      				'bold' => true
      			  ]
            ];
            $objPHPExcel->getActiveSheet()->getStyle('A4:AF4')->applyFromArray($link_style_array2);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($link_style_array);
      			$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($link_style_array);

            $query = $this->db->query("select * from VIEW_MDG_CUSTOMER_DETAIL order by ObjectID");
            $i=5;
            foreach($query->result() as $qr){
              $objPHPExcel->setActiveSheetIndex(0)
                            //mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya
                            //Hello merupakan isinya
                            ->setCellValue('A'.$i, $qr->MDG_Customer_ID)
                            ->setCellValue('B'.$i, $qr->MDG_CustomerType_ID)
                            ->setCellValue('C'.$i, $qr->CustomerType_Name)
                            ->setCellValue('D'.$i, $qr->MDG_Title)
                            ->setCellValue('E'.$i, $qr->MDG_CustomerName)
                            ->setCellValue('F'.$i, $qr->MDG_SearchTerm)
                            ->setCellValue('G'.$i, $qr->MDG_Address1)
                            ->setCellValue('H'.$i, $qr->MDG_Address2)
                            ->setCellValue('I'.$i, $qr->MDG_Address3)
                            ->setCellValue('J'.$i, $qr->MDG_HouseNo)
                            ->setCellValue('K'.$i, $qr->CustomerCity_ID)
                            ->setCellValue('L'.$i, $qr->CustomerCity_Name)
                            ->setCellValue('M'.$i, $qr->MDG_PostalCode)
                            ->setCellValue('N'.$i, $qr->CustomerProvince_ID)
                            ->setCellValue('O'.$i, $qr->CustomerProvince_Name)
                            ->setCellValue('P'.$i, $qr->MDG_Country)
                            ->setCellValue('Q'.$i, $qr->MDG_Phone)
                            ->setCellValue('R'.$i, $qr->MDG_Mobile)
                            ->setCellValue('S'.$i, $qr->MDG_NPWP)
                            ->setCellValue('T'.$i, $qr->MDG_PPN)
                            ->setCellValue('U'.$i, $qr->MDG_BankKey)
                            ->setCellValue('V'.$i, $qr->MDG_AccountNo)
                            ->setCellValue('W'.$i, $qr->MDG_AccountName)
                            ->setCellValue('X'.$i, $qr->MDG_SameBill)
                            ->setCellValue('Y'.$i, $qr->MDG_Billtoparty)
                            ->setCellValue('Z'.$i, $qr->PaymentTerm_ID)
                            ->setCellValue('AA'.$i, $qr->MDG_TermName)
                            ->setCellValue('AB'.$i, $qr->MDG_CreateDt)
                            ->setCellValue('AC'.$i, $qr->MDG_UpdateDt)
                            ->setCellValue('AD'.$i, $qr->MDG_Status)
                            ->setCellValue('AE'.$i, $qr->Account_ID)
                            ->setCellValue('AF'.$i, $qr->Account_First_Name.' '.$qr->Account_Last_Name );

                            $i++;
            }

            //set title pada sheet (me rename nama sheet)
            $objPHPExcel->getActiveSheet()->setTitle('DATA CUSTOMER');

            //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

            //sesuaikan headernya
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            //ubah nama file saat diunduh
            header('Content-Disposition: attachment;filename="DATA_CUSTOMER'.date('YmdHsi').'.xls"');
            //unduh file
      $objWriter->save("php://output");
    }

    function get_export_excel_vendor(){
      $this->load->library("Excel/PHPExcel");
            $objPHPExcel = new PHPExcel();

            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->setActiveSheetIndex(0)
                          //mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya
                          //Hello merupakan isinya
                          ->setCellValue('A1', 'DATA VENDOR')
                          ->setCellValue('A2', 'MDG Applications')
                          ->setCellValue('A4', 'VENDOR ID')
                          ->setCellValue('B4', 'TYPE ID')
                          ->setCellValue('C4', 'TYPE NAME')
                          ->setCellValue('D4', 'TITLE CODE')
                          ->setCellValue('E4', 'CUSTOMER NAME')
                          ->setCellValue('F4', 'SEARCH TERM')
                          ->setCellValue('G4', 'ADDRESS 1')
                          ->setCellValue('H4', 'ADDRESS 2')
                          ->setCellValue('I4', 'ADDRESS 3')
                          ->setCellValue('J4', 'NO')
                          ->setCellValue('K4', 'CITY NAME')
                          ->setCellValue('L4', 'POSTAL CODE')
                          ->setCellValue('M4', 'PROVINCE CODE')
                          ->setCellValue('N4', 'PROVINCE NAME')
                          ->setCellValue('O4', 'COUNTRY')
                          ->setCellValue('P4', 'PHONE')
                          ->setCellValue('Q4', 'MOBILE')
                          ->setCellValue('R4', 'NPWP')
                          ->setCellValue('S4', 'PPN')
                          ->setCellValue('T4', 'BANK KEY')
                          ->setCellValue('U4', 'ACCOUNT NO')
                          ->setCellValue('V4', 'ACCOUNT NAME')
                          ->setCellValue('W4', 'PAYMENT TERM')
                          ->setCellValue('X4', 'CREATE DATE')
                          ->setCellValue('Y4', 'UPDATE DATE')
                          ->setCellValue('Z4', 'STATUS')
                          ->setCellValue('AA4', 'ACCOUNT ID')
                          ->setCellValue('AB4', 'ACCOUNT NAME');


                          //mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya
                          //Hello merupakan isinya
            $objPHPExcel->getActiveSheet()->mergeCells('A1:AF1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:AF2');
            $link_style_array = [
      			  'font'  => [
      				'color' => ['rgb' => '555555'],
              'size'  => '14px',
      				'bold' => true
      			  ]
      			];

            $link_style_array2 = [
      			  'font'  => [
      				'color' => ['rgb' => '555555'],
              'size'  => '12px',
      				'bold' => true
      			  ]
            ];
            $objPHPExcel->getActiveSheet()->getStyle('A4:AF4')->applyFromArray($link_style_array2);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($link_style_array);
      			$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($link_style_array);

            $query = $this->db->query("select * from VIEW_MDG_VENDOR_DETAIL order by MDG_Vendor_ID");
            $i=5;
            foreach($query->result() as $qr){
              $objPHPExcel->setActiveSheetIndex(0)
                            //mengisikan value pada tiap-tiap cell, A1 itu alamat cellnya
                            //Hello merupakan isinya
                            ->setCellValue('A'.$i, $qr->MDG_Vendor_ID)
                            ->setCellValue('B'.$i, $qr->MDG_VendorType_ID)
                            ->setCellValue('C'.$i, $qr->VendorType_Name)
                            ->setCellValue('D'.$i, $qr->MDG_Title)
                            ->setCellValue('E'.$i, $qr->MDG_VendorName)
                            ->setCellValue('F'.$i, $qr->MDG_SearchTerm)
                            ->setCellValue('G'.$i, $qr->MDG_Address1)
                            ->setCellValue('H'.$i, $qr->MDG_Address2)
                            ->setCellValue('I'.$i, $qr->MDG_Address3)
                            ->setCellValue('J'.$i, $qr->MDG_HouseNo)
                            ->setCellValue('K'.$i, $qr->MDG_City)
                            ->setCellValue('L'.$i, $qr->MDG_PostalCode)
                            ->setCellValue('M'.$i, $qr->VendorProvince_ID)
                            ->setCellValue('N'.$i, $qr->VendorProvince_Name)
                            ->setCellValue('O'.$i, $qr->MDG_Country)
                            ->setCellValue('P'.$i, $qr->MDG_Phone)
                            ->setCellValue('Q'.$i, $qr->MDG_Mobile)
                            ->setCellValue('R'.$i, $qr->MDG_NPWP)
                            ->setCellValue('S'.$i, $qr->MDG_PPN)
                            ->setCellValue('T'.$i, $qr->MDG_BankKey)
                            ->setCellValue('U'.$i, $qr->MDG_AccountNo)
                            ->setCellValue('V'.$i, $qr->MDG_AccountName)
                            ->setCellValue('W'.$i, $qr->MDG_PaymentTerm)
                            ->setCellValue('X'.$i, $qr->MDG_CreateDt)
                            ->setCellValue('Y'.$i, $qr->MDG_UpdateDt)
                            ->setCellValue('Z'.$i, $qr->MDG_Status)
                            ->setCellValue('AA'.$i, $qr->Account_ID)
                            ->setCellValue('AB'.$i, $qr->Account_First_Name.' '.$qr->Account_Last_Name );

                            $i++;
            }

            //set title pada sheet (me rename nama sheet)
            $objPHPExcel->getActiveSheet()->setTitle('DATA VENDOR');

            //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

            //sesuaikan headernya
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            //ubah nama file saat diunduh
            header('Content-Disposition: attachment;filename="DATA_VENDOR'.date('YmdHsi').'.xls"');
            //unduh file
      $objWriter->save("php://output");
    }

    function get_export_excel_confirm(){

    }

    function get_deleteUsers($id){
      $id = $this->uri->segment(3);
      $query_cek = $this->db->query("select * from Ms_Account where Account_ID = '".$id."'");
      foreach($query_cek->result() as $qck){
        $usr = $qck->User_ID;
      }
      $query_stts_del = $this->db->query("update Ms_Account_Privacy set Status = 2 where User_ID = '".$usr."'");
      if($query_stts_del){
        header('Location: '.base_url().'index.php/control/get_ms_users/');
      }else{
        header('Location: '.base_url().'index.php/control/update_users/'.$id);
      }
    }

    function get_ms_users(){
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
        $this->load->view('users_list_view',$data);
        $this->load->view('bottom_view');
      }
    }

    function get_list_users_all(){
      $query_list_confirm = $this->db->query("select * from VIEW_MDG_USERS where Status < 2");

			foreach($query_list_confirm->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
    }

    function create_users(){
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
        $this->load->view('create_users_view',$data);
        $this->load->view('bottom_view');
      }
    }

    function update_users($ac){
      $cek_status = $this->session->userdata('success_data');
      $ac = $this->uri->segment(3);
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
        $this->load->view('create_users_view',$data);
        $this->load->view('bottom_view');
      }
    }

    function get_users_detail(){
      $ac = $this->input->post('ac');
      $query_list_confirm = $this->db->query("select * from VIEW_MDG_USERS where Account_ID = '".$ac."'");

			foreach($query_list_confirm->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
    }

    function get_approver_list(){
      $ac = $this->input->post('id');
			$query = $this->db->query("select * from Ms_Mapping as m inner join Ms_Account as a on m.Mapping_approval_person = a.Account_ID
			inner join Ms_Structure_Organization as s on a.SO_ID = s.SO_ID inner join Ms_Department as d on s.Department_ID = d.Department_ID inner join Ms_Position as p on s.Position_ID = p.Position_ID
		 	where m.Account_ID = '".$ac."'");
			foreach($query->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
		}

    function get_save_users(){
      $cd = $this->input->post('cd');
      date_default_timezone_set('Asia/Jakarta');
      if($cd == 'create_users'){
        /*id:$('#user_id_desktop').val(),
        first:$('#first_name').val(),
        last:$('#last_name').val(),
        email:$('#email').val(),
        phone:$('#phone').val(),
        dep:$('#department_self').val(),
        pos:$('#position_self').val(),
        username:$('#username').val(),
        password:$('#password').val(),
        conf:$('#conf').val(),
        level:$('#level').val(),
        */
        $pos = $this->input->post('pos');
        $dep = $this->input->post('dep');
        $query_so = $this->db->query("select * from Ms_Structure_Organization where Position_ID = '".$pos."' and Department_ID='".$dep."'");
        foreach($query_so->result() as $so){
          $data['SO_ID'] = $so->SO_ID;
        }

        $id_user = $this->model_app->getMaxKode('Ms_Account_Privacy', 'User_ID', 'USR');
  			$id_account = $this->model_app->getMaxKode('Ms_Account', 'User_ID', 'ACO');

        $data['Account_ID'] = $id_account;
        $data['User_ID'] = $id_user;
        $data['Account_First_Name'] = $this->input->post('first');
        $data['Account_Last_Name'] = $this->input->post('last');
        $data['Account_Email'] = $this->input->post('email');
        $data['Account_Phone'] = $this->input->post('phone');
        $data['SO_Level'] = $this->input->post('level');
        $data['Account_CreateDt'] = date('Y-m-d H:i:s');

        $data1['User_ID'] = $data['User_ID'];
        $data1['Username'] = $this->input->post('username');
        $data1['Password'] = $this->input->post('password');
        $data1['Status'] = 1;

        $cek_privacy = $this->db->query("select * from Ms_Account_Privacy where username = '".$data1['Username']."' and password = '".$data1['Password']."'");
        $cek_email = $this->db->query("select * from Ms_Account where Account_Email = '".$data['Account_Email']."'");
        if($cek_privacy->num_rows() == 0 and $cek_email->num_rows() == 0){
  				$result_p = $this->model_app->insert_data('Ms_Account_Privacy', $data1);
  				$result_a = $this->model_app->insert_data('Ms_Account', $data);
          if($result_p and $result_a){
  						$data = array(
  							'status' => 'success create',
                'ids' => $data['Account_ID']
  						);
  						echo json_encode($data);
  				}else{
  					$data = array(
  						'status' => 'satu'
  					);
  					echo json_encode($data);
  				}
        }else{
          $data = array(
            'status' => 'sudah ada'
          );
          echo json_encode($data);
        }
      }else if($cd == 'update_users'){
        $pos = $this->input->post('pos');
        $dep = $this->input->post('dep');
        $query_so = $this->db->query("select * from Ms_Structure_Organization where Position_ID = '".$pos."' and Department_ID='".$dep."'");
        foreach($query_so->result() as $so){
          $data['SO_ID'] = $so->SO_ID;
        }

        //$id_user = $this->model_app->getMaxKode('Ms_Account_Privacy', 'User_ID', 'USR');
        //$id_account = $this->model_app->getMaxKode('Ms_Account', 'User_ID', 'ACO');

        $id = $this->input->post('id');
        $data['Account_First_Name'] = $this->input->post('first');
        $data['Account_Last_Name'] = $this->input->post('last');
        $data['Account_Email'] = $this->input->post('email');
        $data['Account_Phone'] = $this->input->post('phone');
        $data['SO_Level'] = $this->input->post('level');
        $data['Account_UpdateDt'] = date('Y-m-d H:i:s');

        $query_p = $this->db->query("select p.User_ID from Ms_Account_Privacy as p inner join Ms_Account as a on p.User_ID = a.User_ID where a.Account_ID = '".$id."'");
        foreach($query_p->result() as $p){
          $id2 = $p->User_ID;
        }

        //$data1['User_ID'] = $data['User_ID'];
        $data1['Username'] = $this->input->post('username');
        $data1['Password'] = $this->input->post('password');
        $data1['Status'] = 1;

        //$cek_privacy = $this->db->query("select * from Ms_Account_Privacy where username = '".$data1['Username']."' and password = '".$data1['Password']."'");
        //$cek_email = $this->db->query("select * from Ms_Account where Account_Email = '".$data['Account_Email']."'");
        //if($cek_privacy->num_rows() == 0 and $cek_email->num_rows() == 0){
        $result_p = $this->model_app->update_data('Ms_Account_Privacy', 'User_ID', $id2, $data1);
        $result_a = $this->model_app->update_data('Ms_Account', 'Account_ID', $id, $data);
        if($result_p and $result_a){
            $data = array(
              'status' => 'success update',
              'ids' => $id
            );
            echo json_encode($data);
        }else{
          $data = array(
            'status' => 'satu'
          );
          echo json_encode($data);
        }
      }
    }

    function get_ms_confirm(){
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
        $this->load->view('confirm_list_view',$data);
        $this->load->view('bottom_view');
      }
    }

    function get_list_confirm_all(){
			$query_list_confirm = $this->db->query("select * from VIEW_MDG_ALL where status in (2,3,4)");

			foreach($query_list_confirm->result() as $grid5){
				$data[] = $grid5;
			}
			echo json_encode($data);
		}

    function get_detail_confirm($id){
      $cek_status = $this->session->userdata('success_data');
      $id = $this->uri->segment(3);
      if(!$cek_status){
        ?>
        <script>
          window.location.href = '<?php echo base_url();?>';
        </script>
        <?php
      }else{
        if(substr($id,4,3) == 'VNR'){
          $query = $this->db->query("select * from Ms_Account as a inner join Ms_Account_Privacy as p on a.User_ID = p.User_ID where Account_ID = '".$this->session->userdata('account_id')."'");
          $query_c_update = $this->db->query("select * from NewUpdate where New_Status = 0 and Account_To = '".$this->session->userdata('account_id')."'");
          foreach($query->result() as $acc){
            $data['first_name'] = $acc->Account_First_Name;
            $data['last_name'] = $acc->Account_Last_Name;
            $data['username'] = $acc->Username;
          }

          $data['c_update'] = $query_c_update->num_rows();

          $this->load->view('top_view');
          $this->load->view('display_confirm_vendor_view',$data);
          $this->load->view('bottom_view');
        }else if(substr($id,4,3) == 'CST'){
          $query = $this->db->query("select * from Ms_Account as a inner join Ms_Account_Privacy as p on a.User_ID = p.User_ID where Account_ID = '".$this->session->userdata('account_id')."'");
          $query_c_update = $this->db->query("select * from NewUpdate where New_Status = 0 and Account_To = '".$this->session->userdata('account_id')."'");
          foreach($query->result() as $acc){
            $data['first_name'] = $acc->Account_First_Name;
            $data['last_name'] = $acc->Account_Last_Name;
            $data['username'] = $acc->Username;
          }

          $data['c_update'] = $query_c_update->num_rows();

          $this->load->view('top_view');
          $this->load->view('display_confirm_customer_view',$data);
          $this->load->view('bottom_view');
        }
      }
    }

    function get_confirm_app_customer(){
      $id = $this->input->post('id');

      $query = $this->db->query("update Ms_Customer_MDG set MDG_Status = '5' where MDG_Customer_ID = '".$id."'");
      if($query){
        $data = array(
          'status' => 'success'
        );
        echo json_encode($data);
      }else{
        $data = array(
          'status' => 'fail',
          'ids' => $id
        );
        echo json_encode($data);
      }
    }

    function get_confirm_app_vendor(){
      $id = $this->input->post('id');

      $query = $this->db->query("update Ms_Vendor_MDG set MDG_Status = '5' where MDG_Vendor_ID = '".$id."'");
      if($query){
        $data = array(
          'status' => 'success'
        );
        echo json_encode($data);
      }else{
        $data = array(
          'status' => 'fail',
          'ids' => $id
        );
        echo json_encode($data);
      }
    }
}
/*End of file control.php*/
/*Location:.application/controllers/control.php*/
