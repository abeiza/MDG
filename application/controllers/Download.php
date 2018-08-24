<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Download extends CI_Controller{
	
			function index(){
				if(isset($_REQUEST["file"])){
				// Get parameters
				$file1 = urldecode($_REQUEST["file"]); // Decode URL-encoded string
				$vowels = array(" ");
				$file = str_replace($vowels, "_", $file1);
				$filepath = "./temp_upload/" . $file;
				
				// Process download
				if(file_exists($filepath)) {
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($filepath));
					flush(); // Flush system output buffer
					readfile($filepath);
					exit;
				}
			}
		}
	}
