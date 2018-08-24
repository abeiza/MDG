<?php if(!defined('BASEPATH'))exit('No direct script access allowed');
	class Model_App extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_data($table){
			//$this->load->database('default',FALSE,TRUE);
			return $this->db->get($table);
		}

		function get_data_limit($table,$limit,$offset){
			//$this->load->database('default',FALSE,TRUE);
			return $this->db->get($table, $limit, $offset);
		}

		function get_query($data){
			//$this->load->database('default',FALSE,TRUE);
			return $this->db->query($data);
		}

		function get_where($table,$pk,$id){
			//$this->load->database('default',FALSE,TRUE);
			$this->db->where($pk,$id);
			return $this->db->get($table);
		}

		function get_where_limit($table,$pk,$id,$limit,$offset){
			//$this->load->database('default',FALSE,TRUE);
			$this->db->where($pk,$id);
			return $this->db->get($table,$limit,$offset);
		}

		function get_data_multi_join($table1, $table2, $table3, $table4, $pk2, $pk3, $pk4){
			//$this->load->database('default',FALSE,TRUE);
			$this->db->select('*');
			$this->db->from($table1);
			$this->db->join($table2, $pk2);
			$this->db->join($table3, $pk3);
			$this->db->join($table4, $pk4);
			return $this->db->get();
		}

		function get_data_multi_join_where($table1, $table2, $table3, $table4, $pk2, $pk3, $pk4, $pk5, $pk6){
			//$this->load->database('default',FALSE,TRUE);
			$this->db->select('*');
			$this->db->from($table1);
			$this->db->where($pk5,$pk6);
			$this->db->join($table2, $pk2);
			$this->db->join($table3, $pk3);
			$this->db->join($table4, $pk4);
			return $this->db->get();
		}

		function get_data_multi_join_limit($table1, $table2, $table3, $table4, $pk2, $pk3, $pk4, $limit, $offset){
			//$this->load->database('default',FALSE,TRUE);
			$this->db->select('*');
			$this->db->from($table1);
			$this->db->join($table2, $pk2);
			$this->db->join($table3, $pk3);
			$this->db->join($table4, $pk4);
			$this->db->limit($limit,$offset);
			return $this->db->get();
		}

		function get_two_multi_join_limit($table1, $table3, $table4, $pk3, $pk4, $limit, $offset){
			//$this->load->database('default',FALSE,TRUE);
			$this->db->select('*');
			$this->db->from($table1);
			$this->db->join($table3, $pk3);
			$this->db->join($table4, $pk4);
			$this->db->limit($limit,$offset);
			return $this->db->get();
		}

		function get_two_multi_join_where($table1, $table2, $table4, $pk2, $pk4, $pk5, $pk6){
			//$this->load->database('default',FALSE,TRUE);
			$this->db->select('*');
			$this->db->from($table1);
			$this->db->where($pk5,$pk6);
			$this->db->join($table2, $pk2);
			$this->db->join($table4, $pk4);
			return $this->db->get();
		}

		function update_data($table, $pk, $id, $data){
			//$this->load->database('default',FALSE,TRUE);
			$this->db->where($pk,$id);
			return $this->db->update($table,$data);
		}

		function delete_data($table, $pk, $id){
			//$this->load->database('default',FALSE,TRUE);
			$this->db->where($pk,$id);
			return $this->db->delete($table);
		}

		function login_data($pwd,$user,$role){
			//$this->load->database('default',FALSE,TRUE);
			$data = $this->db->query("SELECT p.User_ID, p.Username, a.Account_ID, p.Status, l.Level_ID FROM Ms_Account_Privacy as p inner join Ms_Account as a on p.User_ID = a.User_ID inner join Ms_Role_Level as l on a.SO_Level = l.Level_ID WHERE Username='".$user."' AND Password='".$pwd."' AND p.Status = '1' AND Level_ID='".$role."'");
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					if($db->Status == 1){
						$sess_data['success_data'] = 'statusloginsuccess';
						$sess_data['user_id'] = $db->User_ID;
						$sess_data['account_id'] = $db->Account_ID;
						$sess_data['username'] = $db->Username;
						$sess_data['status'] = $db->Status;
						$sess_data['role'] = $db->Level_ID;
						//$sess_data['key'] = $db->key_access;
						$this->session->set_userdata($sess_data);
						return 'success';
					}else{
						return 'inactive';
					}
				}
			}else{
				return 'invalid';
			}
		}

		function getMaxKode($table, $pk, $kode)
		{
			//$this->load->database('default',FALSE,TRUE);
			$q = $this->db->query("select MAX(RIGHT(".$pk.",8)) as kd_max from ".$table."");
			$kd = "";
			if($q->num_rows()>0)
			{
				foreach($q->result() as $k)
				{
					$tmp = ((int)$k->kd_max)+1;
					$kd = sprintf("%08s", $tmp);
				}
			}
			else
			{
				$kd = "000000001";
			}
			return $kode.$kd;
		}

		function getQueryMy($data){
			$this->load->database('mysql_dbs',FALSE,TRUE);
			return $this->db->query($data);
		}

		function getQuerySrvLive($data){
			$this->load->database('sql_live',FALSE,TRUE);
			return $this->db->query($data);
		}

		function getQuerySrv($data){
			$this->load->database('default',FALSE,TRUE);
			return $this->db->query($data);
		}

		function insert_data($table, $data){
			return $this->db->insert($table,$data);
		}
	}
/*End of file model_app.php*/
/*Location:.application/models/model_app.php*/
