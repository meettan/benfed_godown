<?php
	class godown extends MX_Controller{

		protected $sysdate;
		protected $kms_year;
		public function __construct(){

			parent::__construct();	
			// $this->db2 = $this->load->database('findb', TRUE);
			$this->load->model('FertilizerModel');
			// $this->load->library('csvimport');
			$this->session->userdata('fin_yr');
		
			if(!isset($this->session->userdata['loggedin']['user_id'])){
            
            redirect('User_Login/login');

            }
		}
	public function index(){
		$branch_id  = $this->session->userdata['loggedin']['branch_id'];
		$where               = array("br_id"=>$branch_id);
			if($branch_id==342){
				$data['data']   = $this->FertilizerModel->f_select('md_wearhouse',NULL,NULL,0);
			}else{
				$data['data']   = $this->FertilizerModel->f_select('md_wearhouse',NULL,$where,0);
			}
		
		$this->load->view('post_login/fertilizer_main');
		$this->load->view("transaction/dashboard",$data);
		$this->load->view('post_login/footer');

	}	
	public 	function godowndtls()
    {
      
        $fin_id              = $this->session->userdata['loggedin']['fin_id'];
        $where               = array("sl_no"=>$fin_id);
        $data['finyrdtls']   = $this->FertilizerModel->f_select('md_fin_year',NULL,$where,1);
       
        $select              = array("district_code","district_name");
		$selectp             = array("id","purpose");
		$selectst             = array("id","gd_status");
		$selecloc = array("id","loc_name");
		$selecrtye = array("sl_no","road_type");
		$data['goodowntype'] = $this->FertilizerModel->f_select('md_godown_type',NULL,NULL,0);
		$data['conditions'] = $this->FertilizerModel->f_select('md_condition',NULL,NULL,0);
		$data['pstatus'] = $this->FertilizerModel->f_select('md_present_status',NULL,NULL,0);
        $data['distDtls']    = $this->FertilizerModel->f_select('md_district',$select,NULL,0);
		$data['purpdtls']    = $this->FertilizerModel->f_select('md_purpose',$selectp,NULL,0);
		$data['gdstat']    = $this->FertilizerModel->f_select(' md_godownstatus',$selectst,NULL,0);
		$data['locdtls']    = $this->FertilizerModel->f_select('md_location',$selecloc,NULL,0);
		$data['rdtype']    = $this->FertilizerModel->f_select('md_road_type',$selecrtye,NULL,0);
        $select_lastend      = array("ifnull(max(id),0)+1 as sl");
        // $where_lastend       = array("end_yr"=>$fin_id);
        $data['lastend']     = $this->FertilizerModel->f_select('md_wearhouse',$select_lastend,NULL,0);
          
        $where_mn            = array('id'=>$data['lastend'][0] ->sl);
        $data['monthdtls']   = $this->FertilizerModel->f_select('md_month',NULL,$where_mn,1);
       

        $data['row']         = $this->FertilizerModel->f_select("md_wearhouse", NULL, NULL, 0);

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            
            $data_array = array(
                "w_name"         =>  $this->input->post('w_name'),
				"type"           =>  $this->input->post('type'),
				"conditions"     =>  $this->input->post('conditions'),
				"present_status" =>  $this->input->post('present_status'),
                "w_addrs"        =>  $this->input->post('w_addrs'),
                "status"         =>  $this->input->post('status'),
                "purpose"        =>  $this->input->post('purpose'),
				"capacity"       =>  $this->input->post('capacity'),
                "location"       =>  $this->input->post('location'),
				"rent_st_dt"     =>  $this->input->post('rent_st_dt'),
				"rent_end_dt"     =>  $this->input->post('rent_end_dt'),
				"rent_duration"   =>  $this->input->post('rent_duration'),
				"rate"            =>  $this->input->post('rate'),
				"monthly_remt_amt"=>  $this->input->post('monthly_remt_amt'),
				"to_whome"        =>  $this->input->post('to_whome'),
				"from_whome"      =>  $this->input->post('to_whome'),
				"monthly_rent_amth"=>  $this->input->post('to_whome'),
				"ratesqh"		  =>  $this->input->post('to_whome'),
				"rateh"			  =>  $this->input->post('to_whome'),
				"rent_durationh"  =>  $this->input->post('to_whome'),
				"statush"         =>  $this->input->post('to_whome'),
				"rent_end_dth"    =>  $this->input->post('to_whome'),
				"rent_st_dth"     =>  $this->input->post('to_whome'),
				"remarks"         =>  $this->input->post('remarks'),
				"floorarea"       =>  $this->input->post('floorarea'),
				"touzi"			  =>  $this->input->post('touzi'),
				"areapr"		  =>  $this->input->post('areapr'),
				"khotian"		  =>  $this->input->post('khotian'),
				"dag"			  =>  $this->input->post('dag'),
				"jlno"			  =>  $this->input->post('jlno'),
				"mouza"			  =>  $this->input->post('mouza'),
				"dagty"			  =>  $this->input->post('dagty'),
				"porcha"	      =>  $this->input->post('porcha'),
				"ps"			  =>  $this->input->post('ps'),
				"obm"			  =>  $this->input->post('obm'),
				"iew"			  =>  $this->input->post('iew'),
				"eleccon"		  =>  $this->input->post('eleccon'),
				"ph"			  =>  $this->input->post('ph'),
				"venti"			  =>  $this->input->post('venti'),
				"eg"			  =>  $this->input->post('eg'),
				"phc"			  =>  $this->input->post('phc'),
				"tar"			  =>  $this->input->post('tar'),
				"bar"	          =>  $this->input->post('bar'),
				"disnrp"		  =>  $this->input->post('disnrp'),
				"disfr"			  =>  $this->input->post('disfr'),
				"fireext"		  =>  $this->input->post('fireext'),
				"br_id"           =>  $this->session->userdata['loggedin']['branch_id'],
                "created_by"      =>  $this->session->userdata['loggedin']['user_id'],
                "created_at"      =>  date('Y-m-d H:i:s')
            );
           // $dist_id=$this->input->post('dist');
            //$this->load->model('Api_voucher');

    
        $wearhouse_id =  $this->FertilizerModel->f_insert('md_wearhouse', $data_array);
		$name = $this->input->post('name');
		$file      = $_FILES["fileToUpload"]["name"];
		$error = '';
		$error_count = 0 ;
		$success_count = 0;
		//$old = umask(0);
		$target_dir = './uploads/godown_doc/';
		// to mkdir() must be specified.
		// if(!file_exists($target_dir)){
		// 	if (!mkdir($target_dir, 0777, true)) {
		// 		$error = 'Failed to create directories...';
		// 	}
		// }
        if(count($_FILES["fileToUpload"])>0){
		    for($key=0;$key<sizeof($file);$key++){
				$filename=$_FILES["fileToUpload"]["name"][$key];
				//$extension=end(explode(".", $filename));
				$tmp = explode('.', $filename);
				$extension = end($tmp);
				$newfilename=$wearhouse_id.$key.time().".".$extension;
				//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$key]);
				$target_file = $target_dir . $newfilename;
				$uploadOk = 1;
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			
				// Check if image file is a actual image or fake image
				// if($check == false) {
				//echo (mime_content_type($_FILES["fileToUpload"]["tmp_name"][$key]));
				// 	$uploadOk = 0;
				// 	//$error .= "File is an image - " . $check["mime"] . ".";
				// }
						// 1000000 => 1MB
				if ($_FILES["fileToUpload"]["size"][$key] > 2000000) {
				$error .= "Sorry, your file is too large.";
				$uploadOk = 0;
				}
				//Allow certain file formats
				if( $imageFileType != "pdf"){
				//&& $imageFileType != "xlsx" && $imageFileType != "txt" && $imageFileType != "docx"
				//echo "Sorry, only JPG, JPEG, PNG  files are allowed.";
				$error .= "PDF  files are allowed.";
				$uploadOk = 0;
				}
           
			    // Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 1) {
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$key], $target_file)) {
						$data_array = array(
							'wearhouse_id'  => $wearhouse_id,
							'file_name'     => $name[$key],
							'document'   => $newfilename,
							'created_by'    => $this->session->userdata('loggedin')['user_id'],
							'created_at'    => date("Y-m-d h:i:s")
						);
						$id = $this->FertilizerModel->f_insert('td_wearhouse_file',$data_array);
						$success_count++;

					}else{
						$error_count++;
					}
				}
		
		    }
	    }

            // $this->inser_mntEnd($data_array);
            return redirect('godown/godown/');
    
        }else{
        
		$this->load->view('post_login/fertilizer_main');

		$this->load->view("transaction/gdtls",$data);

		$this->load->view('post_login/footer');
        }
    
    }
	public function editgodown(){

		if($_SERVER['REQUEST_METHOD'] == "POST") {
	
			$data_array = array(
				"w_name"         =>  $this->input->post('w_name'),
				"type"           =>  $this->input->post('type'),
				"conditions"     =>  $this->input->post('conditions'),
				"present_status" =>  $this->input->post('present_status'),
                "w_addrs"        =>  $this->input->post('w_addrs'),
                "status"         =>  $this->input->post('status'),
                "purpose"        =>  $this->input->post('purpose'),
				"capacity"       =>  $this->input->post('capacity'),
                "location"       =>  $this->input->post('location'),
				"rent_st_dt"     =>  $this->input->post('rent_st_dt'),
				"rent_end_dt"     =>  $this->input->post('rent_end_dt'),
				"rent_duration"   =>  $this->input->post('rent_duration'),
				"rate"            =>  $this->input->post('rate'),
				"monthly_remt_amt"=>  $this->input->post('monthly_remt_amt'),
				"to_whome"        =>  $this->input->post('to_whome'),
				"from_whome"      =>  $this->input->post('to_whome'),
				"monthly_rent_amth"=>  $this->input->post('to_whome'),
				"ratesqh"		  =>  $this->input->post('to_whome'),
				"rateh"			  =>  $this->input->post('to_whome'),
				"rent_durationh"  =>  $this->input->post('to_whome'),
				"statush"         =>  $this->input->post('to_whome'),
				"rent_end_dth"    =>  $this->input->post('to_whome'),
				"rent_st_dth"     =>  $this->input->post('to_whome'),
				"remarks"         =>  $this->input->post('remarks'),
				"floorarea"       =>  $this->input->post('floorarea'),
				"touzi"			  =>  $this->input->post('touzi'),
				"areapr"		  =>  $this->input->post('areapr'),
				"khotian"		  =>  $this->input->post('khotian'),
				"dag"			  =>  $this->input->post('dag'),
				"jlno"			  =>  $this->input->post('jlno'),
				"mouza"			  =>  $this->input->post('mouza'),
				"dagty"			  =>  $this->input->post('dagty'),
				"porcha"	      =>  $this->input->post('porcha'),
				"ps"			  =>  $this->input->post('ps'),
				"obm"			  =>  $this->input->post('obm'),
				"iew"			  =>  $this->input->post('iew'),
				"eleccon"		  =>  $this->input->post('eleccon'),
				"ph"			  =>  $this->input->post('ph'),
				"venti"			  =>  $this->input->post('venti'),
				"eg"			  =>  $this->input->post('eg'),
				"phc"			  =>  $this->input->post('phc'),
				"tar"			  =>  $this->input->post('tar'),
				"bar"	          =>  $this->input->post('bar'),
				"disnrp"		  =>  $this->input->post('disnrp'),
				"disfr"			  =>  $this->input->post('disfr'),
				"fireext"		  =>  $this->input->post('fireext'),
				"br_id"           =>  $this->session->userdata['loggedin']['branch_id'],
                "modified_by"     =>  $this->session->userdata['loggedin']['user_id'],
                "modified_at"     =>  date('Y-m-d H:i:s')
				);
	
			$where = array(
					"id" => $this->input->post('id')
			);
			$this->FertilizerModel->f_edit('md_wearhouse', $data_array, $where);
			$wearhouse_id = $this->input->post('id');
			$name = $this->input->post('name');
		$file      = $_FILES["fileToUpload"]["name"];
		$error = '';
		$error_count = 0 ;
		$success_count = 0;
		$target_dir = './uploads/godown_doc/';
		
        if(count($_FILES["fileToUpload"])>0){
		    for($key=0;$key<sizeof($file);$key++){
				$filename=$_FILES["fileToUpload"]["name"][$key];
				//$extension=end(explode(".", $filename));
				$tmp = explode('.', $filename);
				$extension = end($tmp);
				$newfilename=$wearhouse_id.$key.time().".".$extension;
				//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$key]);
				$target_file = $target_dir . $newfilename;
				$uploadOk = 1;
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			
						// 1000000 => 1MB
				if ($_FILES["fileToUpload"]["size"][$key] > 2000000) {
				$error .= "Sorry, your file is too large.";
				$uploadOk = 0;
				}
				//Allow certain file formats
				if( $imageFileType != "pdf"){
				//&& $imageFileType != "xlsx" && $imageFileType != "txt" && $imageFileType != "docx"
				//echo "Sorry, only JPG, JPEG, PNG  files are allowed.";
				$error .= "PDF  files are allowed.";
				$uploadOk = 0;
				}
           
			    // Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 1) {
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$key], $target_file)) {
						$data_array = array(
							'wearhouse_id'  => $this->input->post('id'),
							'file_name'     => $name[$key],
							'document'   => $newfilename,
							'created_by'    => $this->session->userdata('loggedin')['user_id'],
							'created_at'    => date("Y-m-d h:i:s")
						);
						$id = $this->FertilizerModel->f_insert('td_wearhouse_file',$data_array);
						$success_count++;

					}else{
						$error_count++;
					}
				}
		
		    }
	    }
			 
	        
			$this->session->set_flashdata('msg', 'Successfully Updated');
			redirect('godown/godown/');
	
		}else{
			$selectp             = array("id","purpose");
			$selectst             = array("id","gd_status");
			$selecloc = array("id","loc_name");
			$data['purpdtls']    = $this->FertilizerModel->f_select('md_purpose',$selectp,NULL,0);
		    $data['gdstat']    = $this->FertilizerModel->f_select('md_godownstatus',$selectst,NULL,0);
		    $data['locdtls']    = $this->FertilizerModel->f_select('md_location',$selecloc,NULL,0);
			$data['goodowntype'] = $this->FertilizerModel->f_select('md_godown_type',NULL,NULL,0);
			$data['conditions'] = $this->FertilizerModel->f_select('md_condition',NULL,NULL,0);
			$data['pstatus'] = $this->FertilizerModel->f_select('md_present_status',NULL,NULL,0);
			$select = array("*");
			$where = array("id" => $this->input->get('id'));
			$data['wearhouse'] = $this->FertilizerModel->f_select("md_wearhouse",$select,$where,1);
			$data['docs']   = $this->FertilizerModel->f_select('td_wearhouse_file',$select,array("wearhouse_id" => $this->input->get('id')),0);
			$this->load->view('post_login/fertilizer_main');
			$this->load->view("transaction/gdtls_edit",$data);
			$this->load->view("post_login/footer");
		}
	}

		public function stock_report(){

			if($_SERVER['REQUEST_METHOD']=="POST"){
				
				$to_date	= $_POST['to_date'];
				$br_cd               = $this->session->userdata['loggedin']['branch_id'];
				$row['stocks']=$this->FertilizerModel->stockreport($to_date,$br_cd);

				$this->load->view('post_login/fertilizer_main');
				$this->load->view('report/stock',$row);
				$this->load->view('post_login/footer');
						
			}else{
				$this->load->view('post_login/fertilizer_main');
				$this->load->view('report/stock');
				$this->load->view('post_login/footer');
			}	
		}

		public function stock_ledg_report(){

			if($_SERVER['REQUEST_METHOD']=="POST"){
				
				$to_date	= $_POST['to_date'];
				$br_cd               = $this->session->userdata['loggedin']['branch_id'];
				$row['stocks']=$this->FertilizerModel->stockledgreport($to_date,$br_cd);

				$this->load->view('post_login/fertilizer_main');
				$this->load->view('report/stock_ledg',$row);
				$this->load->view('post_login/footer');
						
			}else{
				$this->load->view('post_login/fertilizer_main');
				$this->load->view('report/stock_ledg');
				$this->load->view('post_login/footer');
			}	
		}
/****************************************************Society Master************************************ */

//Dashboard
public function soceity(){

	$select	=	array("soc_id","soc_name");

	$where  =	array("district" => $this->session->userdata['loggedin']['branch_id']);

	$bank['data']    = $this->FertilizerModel->f_select('mm_ferti_soc',$select,$where,0);

	$this->load->view("post_login/fertilizer_main");

	$this->load->view("soceity/dashboard",$bank);

	$this->load->view('search/search');

	$this->load->view('post_login/footer');
}



public function f_get_pan_cnt(){

	$select          = array("count(*)cnt");
	
   $where=array(
	   "pan" =>$this->input->get("pan")
	   ) ;
	   
	$pan    = $this->FertilizerModel->f_select(' mm_ferti_soc',$select,$where,0);
	// echo $this->db->last_query();
	// die();
	echo json_encode($pan);

}

// Add Soceity

public function soceityAdd(){
	if($_SERVER['REQUEST_METHOD'] == "POST") {

		$soc= $this->FertilizerModel->f_get_acc();
			// $acc_cd      = $this->FertilizerModel->f_get_acc()
			
			$soc_id 	 = $this->FertilizerModel->get_soceity_code();
		   // echo $this->db->last_query();
		//die();
			$stock_point = $this->input->post('stock_point_flag');

			$buffer		 = $this->input->post('buffer_flag');

			$data_array = array (

					"soc_id" 			=> $soc_id,
			
					"soc_name" 			=> $this->input->post('soc_name'),

					"soc_add"   		=> $this->input->post('soc_add'),

					"gstin"				=> $this->input->post('gstin'),

					"mfms" 				=> $this->input->post('mfms'),
					"retailmfms" 				=> $this->input->post('retailmfms'),
                 
					"district"  		=> $this->session->userdata['loggedin']['branch_id'],
					
					"ph_no"    			=> $this->input->post('ph_no'),

					"email" 			=> $this->input->post('email'),

					"pan"               =>  $this->input->post('pan'),
				
					"stock_point_flag"  => $this->input->post('stock_point_flag'),

					"buffer_flag"    	=> $this->input->post('buffer_flag'),
		   
					"status"          	=> $this->input->post('status'),

					"acc_cd"            => $soc->acc_cd,

					"adv_acc"           => $soc->adv_cd,

					"created_by"    	=> $this->session->userdata['loggedin']['user_name'],    

					"created_dt"    	=>  date('Y-m-d h:i:s'),

					"soc_block"			=>$this->input->post('block'),
					"panc_mun"			=>$this->input->post('gpm'),
					"pin"				=>$this->input->post('pin'),
					"ph_no2"			=>$this->input->post('sph_nos'),
					"license_no"		=>$this->input->post('license_no'),
					"license_from_dt"	=>$this->input->post('licenFdate'),
					"license_to_dt"		=>$this->input->post('licenTdate'),
					"retail_license_no" =>$this->input->post('retail_license_no'),
					"retail_license_from_dt" =>$this->input->post('retail_license_from_dt'),
					"reatil_license_to_dt"	=>$this->input->post('reatil_license_to_dt'),
					"created_by"    	=>  $this->session->userdata['loggedin']['user_name'],
					"created_dt"    	=>  date('Y-m-d h:i:s')
				);

				$this->FertilizerModel->f_insert('mm_ferti_soc', $data_array);
				// $soc_id=$this->db->insert_id();
				
				$data_array2=array(
					'br_cd'=>$this->session->userdata('loggedin')['branch_id'],
					'op_dt'=>explode('-',$this->session->userdata('loggedin')['fin_yr'])[0].'-04-01',
					'soc_id'=>$soc_id,
					'soc_name'=>$this->input->post('soc_name'),
					'balance'=>0
				);
				$this->FertilizerModel->f_insert('td_soc_opening', $data_array2);
	
				$this->session->set_flashdata('msg', 'Successfully Added');

				redirect('customer');

			}else {

				$select          		= array("district_code","district_name");

				$district['distdtls']   = $this->FertilizerModel->f_select('md_district',$select,NULL,0);



				$select2          		= array("branch_id","blockcode","block_name");
				$where = array("branch_id" => $this->session->userdata('loggedin')['branch_id'] );

				$district['block']   = $this->FertilizerModel->f_select('md_block',$select2,$where,0);
					
				$this->load->view('post_login/fertilizer_main');

				$this->load->view("soceity/add",$district);

				$this->load->view('post_login/footer');
			}
}



//Edit Soceity
public function editsoceity(){

	if($_SERVER['REQUEST_METHOD'] == "POST") {

		$data_array = array(

				"soc_id"     			=>  $this->input->post('soc_id'),

				"soc_name"   			=>  $this->input->post('soc_name'),

				"soc_add"    			=>  $this->input->post('soc_add'),

				"gstin"					=> $this->input->post('gstin'),

				"mfms" 					=> $this->input->post('mfms'),
				"retailmfms" 				=> $this->input->post('retailmfms'),
				
				"email"         		=>  $this->input->post('email'),

				"pan"                   => $this->input->post('pan'),

				"ph_no"        			=>  $this->input->post('ph_no'),
				 
				"stock_point_flag"      =>  $this->input->post('stock_point_flag'),
 
				"buffer_flag"      		=>  $this->input->post('buffer_flag'),

				"status"   				=>  $this->input->post('status'),

				"modified_by"  			=>  $this->session->userdata['loggedin']['user_name'],

				"modified_dt"  			=>  date('Y-m-d h:i:s')	,
				"soc_block"			=>$this->input->post('block'),
				"panc_mun"			=>$this->input->post('gpm'),
				"pin"				=>$this->input->post('pin'),
				"ph_no2"			=>$this->input->post('sph_nos'),
				"license_no"		=>$this->input->post('license_no'),
				"license_from_dt"	=>$this->input->post('licenFdate'),
				"license_to_dt"		=>$this->input->post('licenTdate'),
				"retail_license_no" =>$this->input->post('retail_license_no'),
				"retail_license_from_dt" =>$this->input->post('retail_license_from_dt'),
				"reatil_license_to_dt"	=>$this->input->post('reatil_license_to_dt'),
				"modified_by"    	=>  $this->session->userdata['loggedin']['user_name'],
				"modified_dt"    	=>  date('Y-m-d h:i:s')
			);

		$where = array(
				"soc_id" => $this->input->post('soc_id')
		);
		 

		$this->FertilizerModel->f_edit('mm_ferti_soc', $data_array, $where);

		$this->session->set_flashdata('msg', 'Successfully Updated');

		redirect('customer');

	}else{
			$select = array(
						"*"
						                                 
				);

			$where = array(

				"soc_id" => $this->input->get('soc_id')
				
				);

		$sch['schdtls'] = $this->FertilizerModel->f_select("mm_ferti_soc",$select,$where,1);


		$select2          		= array("branch_id","blockcode","block_name");
				$where = array("branch_id" => $this->session->userdata('loggedin')['branch_id'] );

				$sch['block']   = $this->FertilizerModel->f_select('md_block',$select2,$where,0);
																															
		$this->load->view('post_login/fertilizer_main');

		$this->load->view("soceity/edit",$sch);

		$this->load->view("post_login/footer");
	}
}

public function status(){
	$select         = array("id","gd_status");

	$bank['data']   = $this->FertilizerModel->f_select('md_godownstatus',$select,NULL,0);

	$this->load->view("post_login/fertilizer_main");

	$this->load->view("status/dashboard",$bank);

	$this->load->view('search/search');

	$this->load->view('post_login/footer');
}
public function statusAdd(){

	if($_SERVER['REQUEST_METHOD'] == "POST") {

		$data_array = array (

				"gd_status" 	=> $this->input->post('gd_status'),
			
				"created_by"    =>  $this->session->userdata['loggedin']['user_name'],

				"created_dt"    =>  date('Y-m-d h:i:s')
			);
			
			$this->FertilizerModel->f_insert('md_godownstatus', $data_array);
			// echo $this->db->last_query();
			// 	die();
			$this->session->set_flashdata('msg', 'Successfully Added');

			redirect('gtstaus');
	}else 
	
		{
					
			$this->load->view('post_login/fertilizer_main');

			$this->load->view("status/add");

			$this->load->view('post_login/footer');
	}
}

public function purpose(){
	$select         = array("id","purpose");

	$bank['data']   = $this->FertilizerModel->f_select('md_purpose',$select,NULL,0);

	$this->load->view("post_login/fertilizer_main");

	$this->load->view("purpose/dashboard",$bank);

	$this->load->view('search/search');

	$this->load->view('post_login/footer');
}
public function purposeAdd(){

	if($_SERVER['REQUEST_METHOD'] == "POST") {

		$data_array = array (

				"purpose" 	=> $this->input->post('purpose'),
			
				"created_by"    =>  $this->session->userdata['loggedin']['user_name'],

				"created_dt"    =>  date('Y-m-d h:i:s')
			);
			
			$this->FertilizerModel->f_insert('md_purpose', $data_array);
			// echo $this->db->last_query();
			// 	die();
			$this->session->set_flashdata('msg', 'Successfully Added');

			redirect('purp');
	}else 
	
		{
					
			$this->load->view('post_login/fertilizer_main');

			$this->load->view("purpose/add");

			$this->load->view('post_login/footer');
	}
}
public function godowntype(){
	$select         = array("id","category");

	$bank['data']   = $this->FertilizerModel->f_select('md_godown_type',$select,NULL,0);

	$this->load->view("post_login/fertilizer_main");

	$this->load->view("godowntype/dashboard",$bank);

	$this->load->view('search/search');

	$this->load->view('post_login/footer');
}

public function godowntypeAdd(){

	if($_SERVER['REQUEST_METHOD'] == "POST") {

		$data_array = array (

				"category" 	=> $this->input->post('category'),
			
				"created_by"    =>  $this->session->userdata['loggedin']['user_name'],

				"created_dt"    =>  date('Y-m-d h:i:s')
			);
			
			$this->FertilizerModel->f_insert('md_godown_type', $data_array);
				
			$this->session->set_flashdata('msg', 'Successfully Added');

			redirect('gtype');
	}else 
	
		{
					
			$this->load->view('post_login/fertilizer_main');

			$this->load->view("godowntype/add");

			$this->load->view('post_login/footer');
	}
}

public function editgodowntype(){

	if($_SERVER['REQUEST_METHOD'] == "POST") {

		$data_array = array(

				"id"     		=>  $this->input->post('id'),

				"category"    =>  $this->input->post('category'),

				"modified_by"  =>  $this->session->userdata['loggedin']['user_name'],

				"modified_dt"  =>  date('Y-m-d h:i:s')
		);

		$where = array(
				"id" => $this->input->post('id')
		);
			

		$this->FertilizerModel->f_edit('md_godown_type', $data_array, $where);

		$this->session->set_flashdata('msg', 'Successfully Updated');

		redirect('gtype');

	}else

	{
			$select = array(
					"id",

					"category"                           
			);

			$where = array(

				"id" => $this->input->get('id')

				);

			$sch['schdtls'] = $this->FertilizerModel->f_select("md_godown_type",$select,$where,1);
																															
			$this->load->view('post_login/fertilizer_main');

			$this->load->view("godowntype/edit",$sch);

			$this->load->view("post_login/footer");
	}
}

//*********************************************Zone Master*********************************************************/

public function zone(){
	$select         = array("id","zone_name");

	$bank['data']   = $this->FertilizerModel->f_select('md_zone',$select,NULL,0);

	$this->load->view("post_login/fertilizer_main");

	$this->load->view("zone/dashboard",$bank);

	$this->load->view('search/search');

	$this->load->view('post_login/footer');
}


public function zoneAdd(){

	if($_SERVER['REQUEST_METHOD'] == "POST") {

		$data_array = array (

				"zone_name" 	=> $this->input->post('zone_name'),
			
				"created_by"    =>  $this->session->userdata['loggedin']['user_name'],

				"created_dt"    =>  date('Y-m-d h:i:s')
			);
			
			$this->FertilizerModel->f_insert('md_zone', $data_array);
				
			$this->session->set_flashdata('msg', 'Successfully Added');

			redirect('zon');
	}else 
	
		{
					
			$this->load->view('post_login/fertilizer_main');

			$this->load->view("zone/add");

			$this->load->view('post_login/footer');
	}
}
public function editzone(){

	if($_SERVER['REQUEST_METHOD'] == "POST") {

		$data_array = array(

				"id"     		=>  $this->input->post('id'),

				"zone_name"    =>  $this->input->post('zone_name'),

				"modified_by"  =>  $this->session->userdata['loggedin']['user_name'],

				"modified_dt"  =>  date('Y-m-d h:i:s')
		);

		$where = array(
				"id" => $this->input->post('id')
		);
			

		$this->FertilizerModel->f_edit('md_zone', $data_array, $where);

		$this->session->set_flashdata('msg', 'Successfully Updated');

		redirect('zon');

	}else

	{
			$select = array(
					"id",

					"zone_name"                           
			);

			$where = array(

				"id" => $this->input->get('id')

				);

			$sch['schdtls'] = $this->FertilizerModel->f_select("md_zone",$select,$where,1);
																															
			$this->load->view('post_login/fertilizer_main');

			$this->load->view("zone/edit",$sch);

			$this->load->view("post_login/footer");
	}
}


//Dashboard
public function location(){
	$select         = array("id","loc_name");

	$bank['data']   = $this->FertilizerModel->f_select('md_location',$select,NULL,0);

	$this->load->view("post_login/fertilizer_main");

	$this->load->view("location/dashboard",$bank);

	$this->load->view('search/search');

	$this->load->view('post_login/footer');
}

//Add Location
public function locationAdd(){

	if($_SERVER['REQUEST_METHOD'] == "POST") {

		$data_array = array (

				"loc_name" 	=> $this->input->post('loc_name'),
			
				"created_by"    =>  $this->session->userdata['loggedin']['user_name'],

				"created_dt"    =>  date('Y-m-d h:i:s')
			);
			
			$this->FertilizerModel->f_insert('md_location', $data_array);
				
			$this->session->set_flashdata('msg', 'Successfully Added');

			redirect('loc');
	}else 
	
		{
					
			$this->load->view('post_login/fertilizer_main');

			$this->load->view("location/add");

			$this->load->view('post_login/footer');
	}
}
		
//Edit location		
public function editlocation(){

	if($_SERVER['REQUEST_METHOD'] == "POST") {

		$data_array = array(

				"id"     		=>  $this->input->post('id'),

				"loc_name"    =>  $this->input->post('loc_name'),

				"modified_by"  =>  $this->session->userdata['loggedin']['user_name'],

				"modified_dt"  =>  date('Y-m-d h:i:s')
		);

		$where = array(
				"id" => $this->input->post('id')
		);
			

		$this->FertilizerModel->f_edit('md_location', $data_array, $where);

		$this->session->set_flashdata('msg', 'Successfully Updated');

		redirect('measurement');

	}else

	{
			$select = array(
					"id",

					"loc_name"                           
			);

			$where = array(

				"id" => $this->input->get('id')

				);

			$sch['schdtls'] = $this->FertilizerModel->f_select("md_location",$select,$where,1);
																															
			$this->load->view('post_login/fertilizer_main');

			$this->load->view("location/edit",$sch);

			$this->load->view("post_login/footer");
	}
}
		
/***********************Company Master***************************************/

//Dashboard
public function company(){

	$select         = array("comp_id","comp_name","comp_add","gst_no");

	$bank['data']   = $this->FertilizerModel->f_select('mm_company_dtls',$select,NULL,0);

	$this->load->view("post_login/fertilizer_main");

	$this->load->view("company/dashboard",$bank);

	$this->load->view('search/search');

	$this->load->view('post_login/footer');
}

//Add New Company
public function companyAdd(){

	if($_SERVER['REQUEST_METHOD'] == "POST") {

		    $comp_id 	= $this->FertilizerModel->get_company_code();
			
			$data_array = array (

					"comp_id" 			=> $comp_id,
			
					"comp_name" 		=> $this->input->post('comp_name'),

					"short_name" 		=> $this->input->post('short_name'),
					
					"comp_add"   		=> $this->input->post('comp_add'),

					"comp_email_id" 	=> $this->input->post('comp_email_id'),

					"comp_pn_no"    	=> $this->input->post('comp_pn_no'),
					
					"pan_no"    		=> $this->input->post('pan_no'),

					"gst_no" 			=> $this->input->post('gst_no'),

					"mfms"				=> $this->input->post('mfms'),

					"cin"				=> $this->input->post('cin'),

					"bank_name"         =>  $this->input->post('bank_name'),

					"bnk_branch_name" 	=>  $this->input->post('bnk_branch_name'),

					"ac_no"    		    =>  $this->input->post('ac_no'),

					"ifsc" 				=>  $this->input->post('ifsc'),
				
					"created_by"    	=>  $this->session->userdata['loggedin']['user_name'],

					"created_dt"    	=>  date('Y-m-d h:i:s')
				);
			 
				$this->FertilizerModel->f_insert('mm_company_dtls', $data_array);
				 
				$this->session->set_flashdata('msg', 'Successfully Added');

				redirect('source');
	}else 
		{
					
			$this->load->view('post_login/fertilizer_main');

			$this->load->view("company/add");

			$this->load->view('post_login/footer');
	}
}

//Edit Company
public function editcompany(){

	if($_SERVER['REQUEST_METHOD'] == "POST") {

		$data_array = array(

				"comp_id"     		=>  $this->input->post('comp_id'),

				"comp_name"   		=>  $this->input->post('comp_name'),

				"short_name"  		=>  $this->input->post('short_name'),

				"comp_add"    		=>  $this->input->post('comp_add'),

				"comp_email_id" 	=>  $this->input->post('comp_email_id'),

				"comp_pn_no"  	 	=>  $this->input->post('comp_pn_no'),
				 
				"gst_no"      		=>  $this->input->post('gst_no'),

				"mfms" 				=>  $this->input->post('mfms'),

				"pan_no"    		=>  $this->input->post('pan_no'),

				"cin" 				=>  $this->input->post('cin'),

				"bank_name"         =>  $this->input->post('bank_name'),

				"bnk_branch_name" 	=>  $this->input->post('bnk_branch_name'),

				"ac_no"    		    =>  $this->input->post('ac_no'),

				"ifsc" 				=>  $this->input->post('ifsc'),

				"modified_by"  		=>  $this->session->userdata['loggedin']['user_name'],

				"modified_dt"  		=>  date('Y-m-d h:i:s')
		);

		$where = array(
				"comp_id" => $this->input->post('comp_id')
		);
		 

		$this->FertilizerModel->f_edit('mm_company_dtls', $data_array, $where);

		$this->session->set_flashdata('msg', 'Successfully Updated');

		redirect('source');

	}else{
			$select = array(
					"comp_id","comp_name",
					"short_name","comp_add","comp_email_id","comp_pn_no",
					"gst_no","mfms","pan_no","cin",'bnk_branch_name','bank_name','ac_no','ifsc'                                
				);

			$where = array(
				"comp_id" => $this->input->get('comp_id')
				);

		$sch['schdtls'] = $this->FertilizerModel->f_select("mm_company_dtls",$select,$where,1);
																															
		$this->load->view('post_login/fertilizer_main');

		$this->load->view("company/edit",$sch);

		$this->load->view("post_login/footer");
	}
}

/*************************************************Product Master*********************************************** */

//Dashboard
public function product(){
	$select 		= array("a.prod_id","a.prod_desc","a.prod_type","a.gst_rt","a.qty_per_bag","b.short_name");
	$where = array(
		
		"a.COMPANY=b.COMP_ID
				 
				ORDER BY  a.prod_desc " => NULL
		
);
	$bank['data']   = $this->FertilizerModel->f_select('mm_product a,mm_company_dtls b',$select,$where,0);

	$this->load->view("post_login/fertilizer_main");

	$this->load->view("product/dashboard",$bank);

	$this->load->view('search/search');

	$this->load->view('post_login/footer');
}

    //*** Code start for Add New Product  ***//		
	public function productAdd(){

		if($_SERVER['REQUEST_METHOD'] == "POST") 
		{
			$prod_id   = $this->FertilizerModel->get_product_code();
			$this->form_validation->set_rules('comp_id', 'Company Name', 'required');
			$this->form_validation->set_rules('prod_desc', 'Product Name', 'required');
			if($this->form_validation->run() == TRUE)
			{
					$data_array = array (
							"prod_id"    			=> $prod_id,
							"prod_desc"   			=> $this->input->post('prod_desc'),
							"generic_name"   	    => $this->input->post('generic_name'),
							"prod_group"   			=> $this->input->post('prod_group'),
							"prod_type"   			=> $this->input->post('prod_type'),
							"mat_state"   			=> $this->input->post('mat_state'),
							'company'     			=> $this->input->post('comp_id'),
							"gst_rt"       			=> $this->input->post('gst_rt'),
							"hsn_code"     			=> $this->input->post('hsn_code'),
							"qty_per_bag"  			=> $this->input->post('bag'),
							"unit"  				=> $this->input->post('unit'),
							"storage"  				=> $this->input->post('storage'),
							"created_by"   	 		=>  $this->session->userdata['loggedin']['user_name'],
							"created_dt"    		=>  date('Y-m-d h:i:s')
					);
					
					$this->FertilizerModel->f_insert('mm_product', $data_array);
					$this->session->set_flashdata('msg', 'Successfully Added');
					redirect('material');
			}else
			{
				$this->session->set_flashdata('type','danger');
				$this->session->set_flashdata('msg',validation_errors());
				redirect('key/productAdd');
				
			}		
		}else
		{

			$select          		= array("comp_id","comp_name");
			$product['compdtls']    = $this->FertilizerModel->f_select('mm_company_dtls',$select,NULL,0);

			$select1          		= array("id","unit_name");
			$product['unitdtls']    = $this->FertilizerModel->f_select('mm_unit',$select1,NULL,0);
			
			$this->load->view('post_login/fertilizer_main');
			$this->load->view("product/add",$product);
			$this->load->view('post_login/footer');
		}
	}
    //*** Code End for Add New Product  ***//

	public function checkHsn(){
		$hsn=$this->input->post('hsn');
		$hsndata=$this->FertilizerModel->checkhsn_select('mm_product',null,array('HSN_CODE'=>$hsn),1);
		if($hsndata>0)
		{
			echo json_encode(true);
		} 
		else
		{
			echo json_encode(false);
		} 
		
	}

//***  Code start for Edit Product     ***//
	public function editproduct(){

		if($_SERVER['REQUEST_METHOD'] == "POST") {

			$data_array = array(

					"prod_id"     =>  $this->input->post('prod_id'),

					"prod_desc"   =>  $this->input->post('prod_desc'),

					"prod_group"   => $this->input->post('prod_group'),
					
					"prod_type"   =>  $this->input->post('prod_type'),

					"mat_state"   =>  $this->input->post('mat_state'),

					"generic_name"    => $this->input->post('generic_name'),

					"gst_rt"      =>  $this->input->post('gst_rt'),

					"hsn_code"    =>  $this->input->post('hsn_code'),

					"qty_per_bag" =>  $this->input->post('bag'),

					"unit"  	  => $this->input->post('unit'),

					"storage"  	  => $this->input->post('storage'),
				
					"modified_by"  =>  $this->session->userdata['loggedin']['user_name'],

					"modified_dt"  =>  date('Y-m-d h:i:s')
			);

			$where = array(
					"prod_id" => $this->input->post('prod_id')
			);
			

			$this->FertilizerModel->f_edit('mm_product', $data_array, $where);

			$this->session->set_flashdata('msg', 'Successfully Updated');

			redirect('material');

		}else{
				$select = array(

						"a.prod_id","a.company",
						"a.prod_desc",'prod_group',
						"a.prod_type","a.mat_state" ,"a.generic_name" ,"a.mfg_date" ,"a.exp_date",
						"a.gst_rt","a.hsn_code","a.qty_per_bag","b.comp_name","a.storage",
						"a.unit"
					);

				$where = array(
					"a.prod_id" => $this->input->get('prod_id'),

					"a.company=b.comp_id"=>NULL

					);

				$product['schdtls'] = $this->FertilizerModel->f_select("mm_product a,mm_company_dtls b",$select,$where,1);

				// echo $this->db->last_query();
				// exit;

				$select          		= array("comp_id","comp_name");

				$product['compdtls']    = $this->FertilizerModel->f_select('mm_company_dtls',$select,NULL,0);

				$select1          		= array("id","unit_name");

				$product['unitdtls']    = $this->FertilizerModel->f_select('mm_unit',$select1,NULL,0);

			
				$this->load->view('post_login/fertilizer_main');

				$this->load->view("product/edit",$product);

				$this->load->view("post_login/footer");
		}
	}
    //***  Code End for Edit Product     ***//



	/*************************************************Category Master*********************************************** */

	//Dashboard
	public function category(){


		$select = array(

						"a.*",

						"b.COMP_NAME"
					);

				$where = array(

					"a.comp_id=b.COMP_ID"=>NULL

					);

		$cate['data'] = $this->FertilizerModel->f_select("mm_category a,mm_company_dtls b",$select,$where,0);

		//$cate['data']   = $this->FertilizerModel->f_select('mm_category',NULL,NULL,0);

		$this->load->view("post_login/fertilizer_main");

		$this->load->view("category/dashboard",$cate);

		$this->load->view('search/search');

		$this->load->view('post_login/footer');
	}

	//Add New Product		
	public function categoryAdd(){

			if($_SERVER['REQUEST_METHOD'] == "POST") {

					$prod_id   = $this->FertilizerModel->get_product_code();

					$data_array = array (
					
							"comp_id"   			=> $this->input->post('comp_id'),

							"cate_desc"   			=> $this->input->post('cate_desc'),

							"created_by"   	 		=>  $this->session->userdata['loggedin']['user_name'],

							"created_dt"    		=>  date('Y-m-d h:i:s')
						);
					
					$this->FertilizerModel->f_insert('mm_category', $data_array);
					
					$this->session->set_flashdata('msg', 'Successfully Added');

					redirect('category');
			}else {

					$select          		= array("comp_id","comp_name");

					$product['compdtls']    = $this->FertilizerModel->f_select('mm_company_dtls',$select,NULL,0);
					
					$this->load->view('post_login/fertilizer_main');

					$this->load->view("category/add",$product);

					$this->load->view('post_login/footer');
			}
	}

	//Edit Product
	public function categoryedit(){

		if($_SERVER['REQUEST_METHOD'] == "POST") {

			$data_array = array(

					"comp_id"   			=> $this->input->post('comp_id'),

					"cate_desc"   			=> $this->input->post('cate_desc'),
				
					"modified_by"  =>  $this->session->userdata['loggedin']['user_name'],

					"modified_dt"  =>  date('Y-m-d h:i:s')
			);

			$where = array(
					"sl_no" => $this->input->post('sl_no')
			);
			

			$this->FertilizerModel->f_edit('mm_category', $data_array, $where);

			$this->session->set_flashdata('msg', 'Successfully Updated');

			redirect('category');

		}else{
				

				$where = array(
					"sl_no" => $this->input->get('sl_no')
					);

				$sch['schdtls'] = $this->FertilizerModel->f_select("mm_category",NULL,$where,1);

				$select          		= array("comp_id","comp_name");

				$sch['compdtls']    = $this->FertilizerModel->f_select('mm_company_dtls',$select,NULL,0);
				$this->load->view('post_login/fertilizer_main');

				$this->load->view("category/edit",$sch);

				$this->load->view("post_login/footer");
		}
	}

	/*************************************************Sale Rate Master*********************************************** */

	//Dashboard
	public function sale_rate(){

		$select     = array("a.bulk_id","a.fin_id","a.frm_dt","a.to_dt","a.comp_id","b.comp_name","a.catg_id","c.cate_desc","a.prod_id","d.prod_desc","a.mrp_gst","a.sale_rtgst","a.sp_bag_gst");
		
		$where 		= array(

			"a.comp_id = b.COMP_ID" =>  NULL,

			"a.catg_id = c.sl_no"   =>  NULL,

			"a.prod_id = d.PROD_ID" =>  NULL,

			"a.fin_id"	            => $this->session->userdata['loggedin']['fin_id']
		
		);
		
		$data['ratedtls']   = $this->FertilizerModel->f_select_distinct('mm_sale_rate a,mm_company_dtls b,mm_category c,mm_product d',$select,$where,0);
	
		$this->load->view("post_login/fertilizer_main");

		$this->load->view("sale_rate/dashboard",$data);

		$this->load->view('search/search');

		$this->load->view('post_login/footer');

	}


	public function f_get_prod_per_bag(){
		$select = array("qty_per_bag");
		$where = array(
			"prod_id" => $this->input->get('prod_id')
			);

		$result = $this->FertilizerModel->f_select('mm_product',$select,$where,0);	
		
		echo json_encode($result);

	} 

	public function f_get_product(){

				$where = array(
					"COMPANY" => $this->input->get('comp_id')
					);
			
				$result = $this->FertilizerModel->f_select('mm_product',NULL,$where,0);	
				
				echo json_encode($result);

	} 
	public function f_get_category(){

				$where = array(
					"comp_id" => $this->input->get('comp_id')
					);
			
				$result = $this->FertilizerModel->f_select('mm_category',NULL,$where,0);	
				// echo $this->db->last_query();
				// die();
				
				echo json_encode($result);

	} 

	public function f_get_unit(){

		$where = array(
			"a.unit = b.id" => NULL,
			"a.prod_id" => $this->input->get('prod_id')
			);

		$select = array(
			"a.unit","b.unit_name","a.storage"
		);   

		$result = $this->FertilizerModel->f_select('mm_product a,mm_unit b',$select,$where,0);	
		// echo $this->db->last_query();
		// 		die();
		echo json_encode($result);

	} 

	//Add sale rate
	public function salerateAdd(){

		if($_SERVER['REQUEST_METHOD'] == "POST") {

			$prod_id    = $this->input->post('prod_id');
			$comp_id    = $this->input->post('comp_id');
			$district   = $this->input->post('district');
			$unit       = $this->input->post('unit');
			$catg_id    = $this->input->post('catg_id');
			$sp_mt      = $this->input->post('sp_mt');
			$sp_bag     = $this->input->post('sp_bag');
			$sp_govt    = $this->input->post('sp_govt');
			$mrp_gst    = $this->input->post('mrp_gst');
			$sale_rtgst = $this->input->post('sale_rtgst');
			$sp_bag_gst = $this->input->post('sp_bag_gst');
			$frm_dt     = $this->input->post('frm_dt');
			$to_dt      = $this->input->post('to_dt');

			$fin_id	   = $this->session->userdata['loggedin']['fin_id'];

			$bulk_id    = $this->FertilizerModel->f_max_id($fin_id);
			
			for ($i = 0;$i < count($district); $i++){
				
				$data_array = array (
						"bulk_id" => $bulk_id,
						
						"fin_id"  => $fin_id,

						"prod_id" => $prod_id,
				
						"comp_id" => $comp_id,
					
						"catg_id" => $catg_id,

						"district" => $district[$i],

						"unit"     => $unit,

						"sp_mt"    =>  $sp_mt,

						"sp_bag"   =>  $sp_bag,

						"sp_govt"  =>  $sp_govt,

						"mrp_gst"  =>  $mrp_gst ,

						"sale_rtgst"=> $sale_rtgst,

						"sp_bag_gst"=>$sp_bag_gst ,

						"frm_dt"   =>  $frm_dt,

						"to_dt"     =>  $to_dt,

						"created_by" =>  $this->session->userdata['loggedin']['user_name'],

						"created_dt" =>  date('Y-m-d h:i:s'));
				
					$this->FertilizerModel->f_insert('mm_sale_rate', $data_array);
					
					}
					$this->session->set_flashdata('msg', 'Successfully Added');

						redirect('godown/godown/sale_rate');
		}else 
		{
				$select1               = array("comp_id","comp_name");
				$product['compdtls']   = $this->FertilizerModel->f_select('mm_company_dtls',$select1,NULL,0);
				
				$select2               = array("prod_id","prod_desc");
				$product['proddtls']   = $this->FertilizerModel->f_select('mm_product',$select2,NULL,0);
				
			
				$product['distdtls']   = $this->FertilizerModel->f_select('md_district',NULL,NULL,0);
				$product['unit']   = $this->FertilizerModel->f_select('mm_unit',NULL,NULL,0);

				$this->load->view('post_login/fertilizer_main');
				$this->load->view("sale_rate/add",$product);
				$this->load->view('post_login/footer');
	     }
	}

	public function editsalerate(){

		$fin_id	   = $this->session->userdata['loggedin']['fin_id'];

		
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			
			$data_array = array(

					//"bulk_id"    =>  $this->input->post('bulk_id'),

					//"prod_id"  =>  $this->input->post('prod_id'),			/**Changed By Tan 18.03.21 */

					//"comp_id"  =>  $this->input->post('comp_id'),

					"unit"        =>  $this->input->post('unit'),
					
					"sp_mt"      =>  $this->input->post('sp_mt'),

					"sp_bag"     =>  $this->input->post('sp_bag'),

					"sp_govt"    =>  $this->input->post('sp_govt'),

					"mrp_gst"    =>  $this->input->post('mrp_gst'),

					"sale_rtgst" =>  $this->input->post('sale_rtgst'),

					"sp_bag_gst" =>  $this->input->post('sp_bag_gst'),

					"fin_id"      =>  $fin_id,

					"frm_dt"      =>  $this->input->post('frm_dt'),

					"to_dt"       =>  $this->input->post('to_dt'),
				
					"modified_by"  =>  $this->session->userdata['loggedin']['user_name'],

					"modified_dt"  =>  date('Y-m-d h:i:s')
			);

			$where = array("fin_id" => $fin_id,

						"bulk_id"   => $this->input->post('bulk_id')		
			);
			

			$this->FertilizerModel->f_edit('mm_sale_rate', $data_array, $where);
			$this->session->set_flashdata('msg', 'Successfully Updated');

			redirect('rateslab');

		}else{
				$select = array("a.bulk_id",
				
								"a.prod_id",

								"a.comp_id",

								"a.fin_id",

								"a.catg_id",

								"a.unit" ,
							
								"a.frm_dt",

								"a.to_dt"  ,

								"a.sp_mt",
								
								"a.sp_bag",
								
								"a.sp_govt",

								"a.mrp_gst",

								"a.sale_rtgst",

								"a.sp_bag_gst",

								"b.prod_desc",

								"c.comp_name" ,

								"e.cate_desc" );

				$where = array("a.bulk_id"            => $this->input->get('bulk_id'),

								"a.fin_id"            => $fin_id,

								"a.prod_id=b.prod_id"  => NULL,

								"a.comp_id=c.comp_id"  => NULL,

								"a.catg_id=e.sl_no"     => NULL,

								"a.unit=f.id"           =>NULL);
			
				
			$wheres = array("comp_id"=> $this->input->get('comp_id')	);

			$sch['schdtls']   = $this->FertilizerModel->f_select_distinct("mm_sale_rate a,mm_product b,mm_company_dtls c,md_district d,mm_category e, mm_unit f",$select,$where,1);

			// echo $this->db->last_query();
			// die();
			$sch['dist']      = $this->FertilizerModel->f_district($this->input->get('bulk_id'),$fin_id);

			$select_cat          = array("sl_no","cate_desc");

			$sch['cat_names'] = $this->FertilizerModel->f_select("mm_category",$select_cat,$wheres,0);


			$sch['distdtls']  = $this->FertilizerModel->f_select('md_district',NULL,NULL,0);
			$sch['unit']  = $this->FertilizerModel->f_select('mm_unit',NULL,NULL,0);
			$select1          = array("comp_id","comp_name");
			$sch['compdtls']  = $this->FertilizerModel->f_select('mm_company_dtls',$select1,NULL,0);

			// $sch['catg']  = $this->FertilizerModel->f_select('mm_category',$select1,NULL,0);
			$this->load->view('post_login/fertilizer_main');

			$this->load->view("sale_rate/edit",$sch);

			$this->load->view("post_login/footer");
		}
	}

    public function deletesalerate(){
		$fin_id	   = $this->session->userdata['loggedin']['fin_id'];
	
	 	$where    = array(  "bulk_id"  =>  $this->input->get('bulk_id'),
                     "fin_id"    => $fin_id	 );
		$data= $this->FertilizerModel->f_select('mm_sale_rate',null,$where,0);

		foreach ($data as $keydata) {
			$keydata->delete_by = $this->session->userdata['loggedin']['user_name'];
			$keydata->delete_at = date('Y-m-d H:m:s');
			// print_r($keydata);
			$this->FertilizerModel->f_insert('mm_sale_rate_delete', $keydata);

		}
	
        $this->FertilizerModel->f_delete('mm_sale_rate', $where);        
        $this->session->set_flashdata('msg', 'Successfully Deleted!');
        redirect('godown/godown/sale_rate');

	}

//*********************************************Credit Note Category Master*********************************************************/

//Dashboard
	public function cr_note_catg(){
		$select         = array("sl_no","cat_desc");

		$bank['data']   = $this->FertilizerModel->f_select('mm_cr_note_category',$select,NULL,0);

		$this->load->view("post_login/fertilizer_main");

		$this->load->view("credit_note_catg/dashboard",$bank);

		$this->load->view('search/search');

		$this->load->view('post_login/footer');
	}

	//Add Unit
	public function crNoteCatgAdd(){

		if($_SERVER['REQUEST_METHOD'] == "POST") {

			$data_array = array (

					"cat_desc" 		=> $this->input->post('catg_name'),
				
					"created_by"    =>  $this->session->userdata['loggedin']['user_name'],

					"created_dt"    =>  date('Y-m-d h:i:s')
				);
				
				$this->FertilizerModel->f_insert('mm_cr_note_category', $data_array);
					
				$this->session->set_flashdata('msg', 'Successfully Added');

				redirect('crCatg');
		}else 
		
			{
						
				$this->load->view('post_login/fertilizer_main');

				$this->load->view("credit_note_catg/add");

				$this->load->view('post_login/footer');
		}
	}
			
	//Edit Unit		
	public function editcrNoteCatg(){

		if($_SERVER['REQUEST_METHOD'] == "POST") {

			$data_array = array(

					"sl_no"        =>  $this->input->post('sl_no'),

					"cat_desc"     =>  $this->input->post('cat_desc'),

					"modified_by"  =>  $this->session->userdata['loggedin']['user_name'],

					"modified_dt"  =>  date('Y-m-d h:i:s')
			);

			$where = array(
					"sl_no" => $this->input->post('sl_no')
			);
				

			$this->FertilizerModel->f_edit('mm_cr_note_category', $data_array, $where);

			$this->session->set_flashdata('msg', 'Successfully Updated');

			redirect('crCatg');

		}else

		{
				$select = array(
						"sl_no",

						"cat_desc"                           
				);

				$where = array(

					"sl_no" => $this->input->get('id')

					);

				$sch['schdtls'] = $this->FertilizerModel->f_select("mm_cr_note_category",$select,$where,1);
																																
				$this->load->view('post_login/fertilizer_main');

				$this->load->view("credit_note_catg/edit",$sch);

				$this->load->view("post_login/footer");
		}
	}

	/****************************************************Society Master************************************ */

	//Dashboard
	public function bank(){

		$select	=	array("sl_no","bank_name","ac_no","ifsc");

		$where  =	array("dist_cd" => $this->session->userdata['loggedin']['branch_id']);

		$bank['data']    = $this->FertilizerModel->f_select('mm_feri_bank',$select,$where,0);

		$this->load->view("post_login/fertilizer_main");

		$this->load->view("bank/dashboard",$bank);

		$this->load->view('search/search');

		$this->load->view('post_login/footer');
	}



// Add bank

	public function bankAdd(){

		if($_SERVER['REQUEST_METHOD'] == "POST") {

				$data_array = array (
				
						"bank_name" 		=> $this->input->post('bank_name'),

						"branch_name"   	=> $this->input->post('branch_name'),

						"ac_no"				=> $this->input->post('bank_ac'),

						"ifsc" 				=> $this->input->post('ifs'),

						"dist_cd"  			=> $this->session->userdata['loggedin']['branch_id'],
						
						"created_by"    	=> $this->session->userdata['loggedin']['user_name'],    

						"created_dt"    	=>  date('Y-m-d h:i:s')
					);

					$this->FertilizerModel->f_insert('mm_feri_bank', $data_array);
		
					$this->session->set_flashdata('msg', 'Successfully Added');

					redirect('BNK');

				}else {
						
					$this->load->view('post_login/fertilizer_main');

					$this->load->view("bank/add");

					$this->load->view('post_login/footer');
				}
	}

	function load_data()
	{
		// console.log('raja');
		$result = $this->csv_import_model->select();
		$output = '
		 <h4 align="center">Imported Details Of CSV File</h4>
        <div class="table-responsive">
		<font face="Courier New" ><table class="table table-bordered table-striped">
        		<tr>
        			
        			<th>dist</th>
        			<th>soc</th>
        			<th>ro_no</th>
					<th>inv_no</th>
					<th>inv_dt</th>
					<th>prod</th>
					<th>qty</th>
					<th>amt</th>
					
					

        		</tr>
		';
		$count = 0;
		if($result->num_rows() > 0)
		{
			foreach($result->result() as $row)
			{
				$count = $count + 1;
				$output .= '
				<tr>
					
					<td>'.$row->dist.'</td>
        			<td>'.$row->soc.'</td>
        			<td>'.$row->ro_no.'</td>
					<td>'.$row->inv_no.'</td>
					<td>'.$row->inv_dt.'</td>
					<td>'.$row->prod.'</td>
					<td>'.$row->qty.'</td>
					<td>'.$row->amt.'</td>

				</tr>
				';
			}
		}
		else
		{
			$output .= '
			<tr>
	    		<td colspan="18" align="left">Data not Available</td>
	    	</tr>
			';
		}
		$output .= '</table></font></div>';
		echo $output;
	}
		

	//Edit Bank
	public function editbank(){

		if($_SERVER['REQUEST_METHOD'] == "POST") {

			$data_array = array(

					"bank_name"   			=>  $this->input->post('bank_name'),

					"branch_name"    		=>  $this->input->post('branch_name'),

					"ac_no"					=> $this->input->post('bank_ac'),

					"ifsc" 					=> $this->input->post('ifs'),

					"modified_by"  			=>  $this->session->userdata['loggedin']['user_name'],

					"modified_dt"  			=>  date('Y-m-d h:i:s')	
				);

			$where = array(
					"sl_no" => $this->input->post('bank_id')
			);
			

			$this->FertilizerModel->f_edit('mm_feri_bank', $data_array, $where);

			$this->session->set_flashdata('msg', 'Successfully Updated');

			redirect('BNK');

		}else{
				$select = array(
							"sl_no",

							"bank_name",

							"branch_name",
						
							"ac_no",
						
							"ifsc"                             
					);

				$where = array(

					"sl_no" => $this->input->get('id')
					
					);

			$sch['schdtls'] = $this->FertilizerModel->f_select("mm_feri_bank",$select,$where,1);
																																
			$this->load->view('post_login/fertilizer_main');

			$this->load->view("bank/edit",$sch);

			$this->load->view("post_login/footer");
		}
	}
	public function fomasteradd(){
		if($this->input->post()){

			$fono=$this->input->post('fono');
			$foname=$this->input->post('foname');
			$virtualno=$this->input->post('virtualno');
			if(!empty($this->input->post('branchId'))){
				$data=array(
					'fo_number'=>$fono,
					'fo_name '=>$foname,
					'fo_virtual_no'=>$virtualno,
					'dist_id'=>$this->input->post('branchId'),
					'create_by'=>$this->session->userdata('loggedin')['user_name'],
					'ctrate_dt'=>date('Y-m-d H:i:s')
				);
			}else{
				$data=array(
					'fo_number'=>$fono,
					'fo_name '=>$foname,
					'fo_virtual_no'=>$virtualno,
					'dist_id'=>$this->session->userdata('loggedin')['branch_id'],
					'create_by'=>$this->session->userdata('loggedin')['user_name'],
					'ctrate_dt'=>date('Y-m-d H:i:s')
				);
			}
			$this->FertilizerModel->f_insert('mm_fo_master', $data);
			redirect('fomaster');
		}else{
			$select_dist           = array("district_code","district_name");	
				$society['distDtls']   = $this->FertilizerModel->f_select('md_district',$select_dist,NULL,0);
				$this->load->view('post_login/fertilizer_main');
				$this->load->view("fomaster/add",$society);
				$this->load->view('post_login/footer');
		}
	}
	public function fomaster(){

		if($this->session->userdata('loggedin')['branch_id']!=342){
			redirect(site_url('Fertilizer_Login/main'));
	
		$where  =	array("dist_id" => $this->session->userdata['loggedin']['branch_id']);
		$fomaster['data']    = $this->FertilizerModel->f_select('mm_fo_master',$select=NULL,$where,0);
		redirect(site_url('Fertilizer_Login/main'));
		}else{
			$where=array(
				'a.dist_id=b.district_code'=>null
			);
			$fomaster['data']    = $this->FertilizerModel->f_select('mm_fo_master a ,md_district b',$select=NULL,$where,0);
		}
	
		
	
		$this->load->view("post_login/fertilizer_main");
	
		$this->load->view("fomaster/dashboard",$fomaster);
	
		$this->load->view('search/search');
	
		$this->load->view('post_login/footer');
	}
	public function fomasteredit($id){
		if($this->input->post()){
			
			$foname=$this->input->post('foname');
			
				$data=array(
					'fo_name '=>$foname,
					'create_by'=>$this->session->userdata('loggedin')['user_name'],
					'ctrate_dt'=>date('Y-m-d H:i:s')
				);
			
			$where = array( "fi_id" => $id );
		

		$this->FertilizerModel->f_edit('mm_fo_master', $data, $where);
			redirect('fomaster');
		}else{
			if($this->session->userdata('loggedin')['branch_id']!=342){
				redirect(site_url('Fertilizer_Login/main'));
			
						}else{
							$where  =	array('fi_id' =>$id);
						}

							$select_dist           = array("district_code","district_name");	
				$fomaster['distDtls']   = $this->FertilizerModel->f_select('md_district',$select_dist,NULL,0);
	
			$fomaster['data']    = $this->FertilizerModel->f_select('mm_fo_master',$select=NULL,$where,1);
				$this->load->view('post_login/fertilizer_main');
				$this->load->view("fomaster/add_edit",$fomaster);
				$this->load->view('post_login/footer');
		}
	}

}
?>
