<?php
	class Api extends MX_Controller{
		protected $sysdate;
		protected $kms_year;
		public function __construct(){
		parent::__construct();	
		$this->load->model('SaleModel');
        $this->load->model('irncancelmodel');
        $this->set_cors_headers();
        }
		private function set_cors_headers() {
            // Allow all domains (for development, you can restrict it to specific domains later)
            header("Access-Control-Allow-Origin: *"); // or specify domain like 'http://localhost:3000'
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    
            // Allow credentials (for cookies or authorization headers)
            header("Access-Control-Allow-Credentials: true");
    
            // Handle preflight requests (OPTIONS)
            if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
                http_response_code(200);
                exit();
            }
        }
    
		// }
        public function f_getvendor(){
		    // $auth_key = $this->input->post('auth_key');
            $sql = $this->db->query("select sum(tot_vendor)tot_vendor,sum(tot_branch)tot_branch,sum(tot_soc)tot_soc
            from(SELECT count(*)tot_vendor,0 tot_branch,0 tot_soc
            from v_company
            union 
            select 0,count(district_code) tot_banch,0  tot_soc
             from v_district
             UNION 
             select 0,0,count(soc_id)
             from  V_SOC)a");
			
            $data['value'] =$sql->result();
            echo json_encode($data);
        }
        public function f_stock_api(){
         $curr_dt=date("Y-m-d");
        // $curr_mnth=date('n',strtotime($curr_dt));
         $curr_yr=date('Y',strtotime($curr_dt));
        // echo $curr_dt;
        // echo  $curr_mnth;
        // echo  $curr_yr;
        // die();
       
        // if($curr_yr > 3){

        //     $year = $curr_yr;

        // }else{

        //  $year = $curr_yr - 1;
        // }

         //$opndt      =  date($curr_yr.'-04-01');
            $sql = $this->db->query("select district_name,comp_name,prod_desc,stock_qty
            from(select ''  district_name, e.prod_desc prod_desc,d.comp_name comp_name, d.comp_id,e.prod_id,0 stock_qty
            from mm_company_dtls d,mm_product e
            where  d.comp_id=e.company
                 group by d.comp_id,e.prod_id ,d.comp_name,e.prod_desc
            )x");
            
            $data['value'] =$sql->result();
            echo json_encode($data);
        }
        public function f_dist_api(){
            $json_data = file_get_contents("php://input");
            $data = json_decode($json_data, true);
            $sql = $this->db->query("select district_code,district_name 
            from md_district");
            $data['value'] =$sql->result();
               echo json_encode($data);
        }
        public function f_godown_api(){
            $json_data = file_get_contents("php://input");
           $data = json_decode($json_data, true);
           $dist_id = $data['dist_id'];
                       
            //    $sql = $this->db->query("select  distinct a.w_name,a.w_addrs,b.branch_name district_name,c.pres_status ,a.capacity,b.br_manager,b.contact_no,,e.purpose details
               $sql = $this->db->query("select distinct a.w_name,a.w_addrs,b.branch_name district_name,c.pres_status,a.capacity,b.br_manager,b.contact_no
               from md_wearhouse a ,md_branch b ,md_present_status c 
               where a.br_id=b.id and a.present_status=c.pres_status_id 
               and br_id=$dist_id");
            //    $sql = $this->db->query("select  distinct a.w_name,a.w_addrs,b.branch_name district_name,c.pres_status ,a.capacity,b.br_manager,b.contact_no,,e.purpose details
            //    from md_wearhouse a ,md_branch b ,md_present_status c,md_purpose e
            //    where a.br_id=b.id 
            //    and a.purpose=e.id
            //    and a.present_status=c.pres_status_id 
            //    and b.id=$dist_id");

               $data['value'] =$sql->result();
               echo json_encode($data);
           }
        function get_api_cancel(){
            $irn = $this->input->post('irn');
            $CnlRsn = $this->input->post('CnlRsn');
            $CnlRem = $this->input->post('remarks');
            // echo $this->db->last_query();
            // exit;
            //var_dump($_POST);exit;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            curl_setopt_array($curl, array(
                /************************for test server*********** */
            //CURLOPT_URL => 'https://einvoicing.internal.cleartax.co/v1/govt/api/Cancel',
            CURLOPT_URL => 'https://api-einv.cleartax.in/v1/govt/api/Cancel',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
            "irn": "' . $irn . '",
            "CnlRsn": "'. $CnlRsn .'" ,
            "CnlRem": "'. $CnlRem .'"
            }',
            /*************for test server******************* */
            /*CURLOPT_HTTPHEADER => array(
                'x-cleartax-auth-token: 1.d88fc2d8-64eb-40a2-96f0-16f6e7cdd286_8d583da35687c440a8ebb2f67591923df276a8b9df462fc6eb0b033c51fbe385',
                'x-cleartax-product: EInvoice',
                'owner_id: d5c19ef6-b179-45a9-b661-f15c507a1aa9',
                'gstin: 19AABAT0010H2ZY',
                'Content-Type: application/json'
            ),*/
            CURLOPT_HTTPHEADER => array(
                'x-cleartax-auth-token: ' . AUTHKOKEN,
                'x-cleartax-product: ' . PRODUCT,
                'owner_id: ' . OWNERID,
                'gstin: ' . SALLERGSTIN,
                'Content-Type: application/json'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $data = json_decode($response);
            $success = $data->Success;
            $msg = '';
            if($success != 'Y'){
                $msg = $data->ErrorDetails[0]->error_message;
                $this->session->set_flashdata('msg', $msg);
                echo $response;
                redirect('irncan');
            }else{
                $this->irncancelmodel->get_irn_details($irn);
                redirect('irncan'); 
            }
            // var_dump($msg);exit;
            // echo $response;
        }

        /*****************IRN Generate*********** */
        public function api_call($trans_do)
		{
			// $trans_do = $this->input->get('trans_do');
			$api_query= $this->SaleModel->f_get_api_data($trans_do);
			//echo $this->db->last_query();
			//exit;
			return $api_query;
		}

        function get_api_res(){
            $trans_do = $this->input->get('trans_do');
            $data = $this->api_call($trans_do);
            $dt = $data ? $data[0] : $data;
            $HsnCd = strlen($dt->HsnCd)==4 ? $dt->HsnCd . '00' : $dt->HsnCd;
            // echo '<pre>';
            $str_arr = explode('/', $dt->No);
            $suf = substr($str_arr[1], 0, 4);
            $send_str = str_replace('-', '',substr($str_arr[4], 0,5));
            $send_str1 = str_replace('_', '-',substr($str_arr[5], 0,10));
            // $doc_no = $suf . '/' . substr(str_replace('_', '-', $->No), 15, 11);
            // $doc_no = $suf . '/' .$send_str. substr(str_replace('_', '-', $dt->No), 20,6);
            $doc_no = $suf . '/' .$send_str. 'I'  .$send_str1 ;

         //     $result = '{
        //         "Version": "'.$dt->Version.'",
        //         "TranDtls": {
        //             "TaxSch": "'.$dt->TaxSch.'",
        //             "SupTyp": "'.$dt->SupTyp.'",
        //             "RegRev": "'.$dt->RegRev.'",
        //             "EcmGstin": null,
        //             "IgstOnIntra": "N"
        //         },
        //         "DocDtls": {
        //             "Typ": "'.$dt->Typ.'",
        //             "No": "'.$doc_no.'",
        //             "Dt": "'.CURRDT.'"
        //         },
        //         "SellerDtls": {
        //             "Gstin": "'.SALLERGSTIN.'",
        //             "LglNm": "'.$dt->LglNm.'",
        //             "TrdNm": "'.$dt->TrdNm.'",
        //             "Addr1": "'.$dt->Addr1.'",
        //             "Addr2": "'.$dt->Addr2.'",
        //             "Loc": "'.$dt->Loc.'",
        //             "Pin": '.SALLERPIN.',
        //             "Stcd": "'.SALLERSTCD.'",
        //             "Ph": "'.SALLERPH.'",
        //             "Em": "'.SALLEREM.'"
        //         },
        //         "BuyerDtls": {
        //             "Gstin": "'.$dt->Gstin1.'",
        //             "LglNm": "'.$dt->LglNm1.'",
        //             "TrdNm": "'.$dt->TrdNm1.'",
        //             "Pos": "'.$dt->Pos.'",
        //             "Addr1": "'.$dt->Addr1_1.'",
        //             "Addr2": "'.$dt->Addr2_1.'",
        //             "Loc": "'.$dt->Loc1.'",
        //             "Pin": '.$dt->Pin1.',
        //             "Stcd": "'.$dt->Stcd1.'",
        //             "Ph": "'.$dt->Ph1.'",
        //             "Em": "'.$dt->Em1.'"
        //         },
        //         "DispDtls": {
        //             "Nm": "'.$dt->Nm2.'",
        //             "Addr1": "'.$dt->Addr1_2.'",
        //             "Addr2": "'.$dt->Addr2_2.'",
        //             "Loc": "'.$dt->Loc2.'",
        //             "Pin": '.$dt->Pin2.',
        //             "Stcd": "'.$dt->Stcd2.'"
        //         },
        //         "ShipDtls": {
        //             "Gstin": "'.$dt->Gstin2.'",
        //             "LglNm": "'.$dt->LglNm2.'",
        //             "TrdNm": "'.$dt->TrdNm2.'",
        //             "Addr1": "'.$dt->Addr1_3.'",
        //             "Addr2": "'.$dt->Addr2_3.'",
        //             "Loc": "'.$dt->Loc3.'",
        //             "Pin": '.$dt->Pin3.',
        //             "Stcd": "'.$dt->Stcd3.'"
        //         },
        //         "ItemList": [
        //             {
        //             "SlNo": "1",
        //             "PrdDesc": "'.$dt->PrdDesc.'",
        //             "IsServc": "'.$dt->IsServc.'",
        //             "HsnCd": "'.$HsnCd.'",
        //             "Barcde": "'.$dt->Barcde.'",
        //             "Qty": '.$dt->Qty.',
        //             "FreeQty": '.$dt->FreeQty.',
        //             "Unit": "'.$dt->Unit.'",
        //             "UnitPrice": '.$dt->UnitPrice.',
        //             "TotAmt": '.$dt->TotAmt.',
        //             "Discount": '.$dt->Discount.',
        //             "PreTaxVal": '.$dt->PreTaxVal.',
        //             "AssAmt": '.$dt->AssAmt.',
        //             "GstRt": '.$dt->GstRt.',
        //             "IgstAmt": '.$dt->IgstAmt.',
        //             "CgstAmt":'.$dt->CgstAmt.',
        //             "SgstAmt":'.$dt->SgstAmt.',
        //             "CesRt": '.$dt->CesRt.',
        //             "CesAmt": '.$dt->CesAmt.',
        //             "CesNonAdvlAmt": '.$dt->CesNonAdvlAmt.',
        //             "StateCesRt": '.$dt->StateCesRt.',
        //             "StateCesAmt": '.$dt->StateCesAmt.',
        //             "StateCesNonAdvlAmt":'.$dt->StateCesNonAdvlAmt.',
        //             "OthChrg": '.$dt->OthChrg.',
        //             "TotItemVal": '.$dt->TotItemVal.',
        //             "OrdLineRef": "'.$dt->OrdLineRef.'",
        //             "OrgCntry": "'.$dt->OrgCntry.'",
        //             "PrdSlNo": "'.$dt->PrdSlNo.'",
        //             "BchDtls": {
        //                 "Nm": "",
        //                 "ExpDt": null,
        //                 "WrDt": null
        //             },
        //             "AttribDtls": [
        //                 {
        //                 "Nm": "'.$dt->Nm5.'",
        //                 "Val": "'.$dt->Val.'"
        //                 }
        //             ]
        //             }
        //         ],
        //         "ValDtls": {
        //             "AssVal": '.$dt->AssVal.',
        //             "CgstVal": '.$dt->CgstVal.',
        //             "SgstVal": '.$dt->SgstVal.',
        //             "IgstVal": 0,
        //             "CesVal": '.$dt->CesVal.',
        //             "StCesVal": '.$dt->StCesVal.',
        //             "Discount": '.$dt->Discount.',
        //             "OthChrg": '.$dt->OthChrg.',
        //             "RndOffAmt": '.$dt->RndOffAmt.',
        //             "TotInvVal": '.$dt->TotInvVal.',
        //             "TotInvValFc": '.$dt->TotInvValFc.'
        //         },
        //         "PayDtls": {
        //             "Nm": "",
        //             "AccDet": "",
        //             "Mode": "",
        //             "FinInsBr": "",
        //             "PayTerm": "",
        //             "PayInstr": "",
        //             "CrTrn": "",
        //             "DirDr": "",
        //             "CrDay": 0,
        //             "PaidAmt": 0,
        //             "PaymtDue": 0
        //         },
        //         "RefDtls": {
        //             "InvRm": "",
        //             "DocPerdDtls": {
        //             "InvStDt": null,
        //             "InvEndDt": null
        //             },
        //             "PrecDocDtls": [
        //             {
        //                 "InvNo": "",
        //                 "InvDt": null,
        //                 "OthRefNo": ""
        //             }
        //             ],
        //             "ContrDtls": [
        //             {
        //                 "RecAdvRef": "",
        //                 "RecAdvDt": null,
        //                 "TendRefr": "",
        //                 "ContrRefr": "",
        //                 "ExtRefr": "",
        //                 "ProjRefr": "",
        //                 "PORefr": "",
        //                 "PORefDt": null
        //             }
        //             ]
        //         },
        //         "AddlDocDtls": [
        //             {
        //             "Url": "",
        //             "Docs": "",
        //             "Info": ""
        //             }
        //         ],
        //         "ExpDtls": {
        //             "ShipBNo": "",
        //             "ShipBDt": null,
        //             "Port": null,
        //             "RefClm": "",
        //             "ForCur":null,
        //             "CntCode": null
        //         },
        //         "EwbDtls": {
        //             "TransId": "",
        //             "TransName": "",
        //             "Distance": 0,
        //             "TransDocNo": "",
        //             "TransDocDt": null,
        //             "VehNo": "",
        //             "VehType": "",
        //             "TransMode": ""
        //         }
        //         }';
        //         echo $result;exit;
        //     var_dump($data); exit;
        //      echo ( $doc_no);exit;
        //    echo ( $doc_no);exit;         

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api-einv.cleartax.in/v1/govt/api/Invoice",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => '{
            "Version": "'.$dt->Version.'",
            "TranDtls": {
                "TaxSch": "'.$dt->TaxSch.'",
                "SupTyp": "'.$dt->SupTyp.'",
                "RegRev": "'.$dt->RegRev.'",
                "EcmGstin": null,
                "IgstOnIntra": "N"
            },
            "DocDtls": {
                "Typ": "'.$dt->Typ.'",
                "No": "'.$doc_no.'",
                "Dt": "'.CURRDT.'"
            },
            "SellerDtls": {
                "Gstin": "'.SALLERGSTIN.'",
                "LglNm": "'.$dt->LglNm.'",
                "TrdNm": "'.$dt->TrdNm.'",
                "Addr1": "'.$dt->Addr1.'",
                "Addr2": "'.$dt->Addr2.'",
                "Loc": "'.$dt->Loc.'",
                "Pin": '.$dt->Pin2.',
                "Stcd": "'.SALLERSTCD.'",
                "Ph": "'.SALLERPH.'",
                "Em": "'.SALLEREM.'"
            },
            "BuyerDtls": {
                "Gstin": "'.$dt->Gstin1.'",
                "LglNm": "'.$dt->LglNm1.'",
                "TrdNm": "'.$dt->TrdNm1.'",
                "Pos": "'.$dt->Pos.'",
                "Addr1": "'.$dt->Addr1_1.'",
                "Addr2": "'.$dt->Addr2_1.'",
                "Loc": "'.$dt->Loc1.'",
                "Pin": '.$dt->Pin1.',
                "Stcd": "'.$dt->Stcd1.'",
                "Ph": "'.$dt->Ph1.'",
                "Em": "'.$dt->Em1.'"
            },
            "DispDtls": {
                "Nm": "'.$dt->Nm2.'",
                "Addr1": "'.$dt->Addr1_2.'",
                "Addr2": "'.$dt->Addr2_2.'",
                "Loc": "'.$dt->Loc2.'",
                "Pin": '.$dt->Pin2.',
                "Stcd": "'.$dt->Stcd2.'"
            },
            "ShipDtls": {
                "Gstin": "'.$dt->Gstin2.'",
                "LglNm": "'.$dt->LglNm2.'",
                "TrdNm": "'.$dt->TrdNm2.'",
                "Addr1": "'.$dt->Addr1_3.'",
                "Addr2": "'.$dt->Addr2_3.'",
                "Loc": "'.$dt->Loc3.'",
                "Pin": '.$dt->Pin3.',
                "Stcd": "'.$dt->Stcd3.'"
            },
            "ItemList": [
                {
                "SlNo": "1",
                "PrdDesc": "'.$dt->PrdDesc.'",
                "IsServc": "'.$dt->IsServc.'",
                "HsnCd": "'.$HsnCd.'",
                "Barcde": "'.$dt->Barcde.'",
                "Qty": '.$dt->Qty.',
                "FreeQty": '.$dt->FreeQty.',
                "Unit": "'.$dt->Unit.'",
                "UnitPrice": '.$dt->UnitPrice.',
                "TotAmt": '.$dt->TotAmt.',
                "Discount": '.$dt->Discount.',
                "PreTaxVal": '.$dt->PreTaxVal.',
                "AssAmt": '.$dt->AssAmt.',
                "GstRt": '.$dt->GstRt.',
                "IgstAmt": '.$dt->IgstAmt.',
                "CgstAmt":'.$dt->CgstAmt.',
                "SgstAmt":'.$dt->SgstAmt.',
                "CesRt": '.$dt->CesRt.',
                "CesAmt": '.$dt->CesAmt.',
                "CesNonAdvlAmt": '.$dt->CesNonAdvlAmt.',
                "StateCesRt": '.$dt->StateCesRt.',
                "StateCesAmt": '.$dt->StateCesAmt.',
                "StateCesNonAdvlAmt":'.$dt->StateCesNonAdvlAmt.',
                "OthChrg": '.$dt->OthChrg.',
                "TotItemVal": '.$dt->TotItemVal.',
                "OrdLineRef": "'.$dt->OrdLineRef.'",
                "OrgCntry": "'.$dt->OrgCntry.'",
                "PrdSlNo": "'.$dt->PrdSlNo.'",
                "BchDtls": {
                    "Nm": "",
                    "ExpDt": null,
                    "WrDt": null
                },
                "AttribDtls": [
                    {
                    "Nm": "'.$dt->Nm5.'",
                    "Val": "'.$dt->Val.'"
                    }
                ]
                }
            ],
            "ValDtls": {
                "AssVal": '.$dt->AssVal.',
                "CgstVal": '.$dt->CgstVal.',
                "SgstVal": '.$dt->SgstVal.',
                "IgstVal": 0,
                "CesVal": '.$dt->CesVal.',
                "StCesVal": '.$dt->StCesVal.',
                "Discount": '.$dt->Discount.',
                "OthChrg": '.$dt->OthChrg.',
                "RndOffAmt": '.$dt->RndOffAmt.',
                "TotInvVal": '.$dt->TotInvVal.',
                "TotInvValFc": '.$dt->TotInvValFc.'
            },
            "PayDtls": {
                "Nm": "",
                "AccDet": "",
                "Mode": "",
                "FinInsBr": "",
                "PayTerm": "",
                "PayInstr": "",
                "CrTrn": "",
                "DirDr": "",
                "CrDay": 0,
                "PaidAmt": 0,
                "PaymtDue": 0
            },
            "RefDtls": {
                "InvRm": "",
                "DocPerdDtls": {
                "InvStDt": null,
                "InvEndDt": null
                },
                "PrecDocDtls": [
                {
                    "InvNo": "",
                    "InvDt": null,
                    "OthRefNo": ""
                }
                ],
                "ContrDtls": [
                {
                    "RecAdvRef": "",
                    "RecAdvDt": null,
                    "TendRefr": "",
                    "ContrRefr": "",
                    "ExtRefr": "",
                    "ProjRefr": "",
                      "PORefr": "'.$dt->PORefr.'",
                    "PORefDt": "'.$dt->PORefDt.'"
                }
                ]
            },
            "AddlDocDtls": [
                {
                "Url": "",
                "Docs": "",
                "Info": ""
                }
            ],
            "ExpDtls": {
                "ShipBNo": "",
                "ShipBDt": null,
                "Port": null,
                "RefClm": "",
                "ForCur":null,
                "CntCode": null
            }
            }',
          CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json",
            "gstin: 19AABAT0010H2ZY",
            "owner_id: fded77f8-4880-4dc6-8b6c-9d23f3374517",
            "postman-token: b441a2d7-221d-ebf8-c508-305003af1de7",
            "x-cleartax-auth-token: 1.249874fd-e3cd-402c-a503-b0a47cb0711f_3d64af076bfe30480c2e74d59d4d5017d2fd57d429bc3364908b5f0ae91a7a51",
            "x-cleartax-product: EInvoice"
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          echo $response;
        }
        }

        function save_irn(){
            $data = $this->input->get();
            $res = $this->SaleModel->save_irn($data);
            echo $res;
        }

        function print_irn(){
            $this->load->helper('download');
            $irns = $this->input->get('irn');
            // echo $irns;
            // exit;
            $file_name = $irns . '.pdf';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                /*****************for test server ******************* */
            // CURLOPT_URL => 'https://einvoicing.internal.cleartax.co/v2/eInvoice/download?template=62cfd0a9-d1ed-47b0-b260-fe21f57e9c5e&format=PDF&irns=' . $irns,
            
            CURLOPT_URL => 'https://api-einv.cleartax.in/v2/eInvoice/download?template=62cfd0a9-d1ed-47b0-b260-fe21f57e9c5e&format=PDF&irns=' . $irns,
            
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'x-cleartax-auth-token: ' . AUTHKOKEN,
                'x-cleartax-product: ' . PRODUCT,
                'owner_id: ' . OWNERID,
                'gstin: ' . SALLERGSTIN
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            force_download($file_name, $response);
            // echo $response;
        }
	public function api_callcr($trans_do)
		{
			// $trans_do = $this->input->get('trans_do');
			$api_query= $this->SaleModel->f_get_api_datacr($trans_do);
			return $api_query;
		}
function get_api_res_cr(){
    // echo 'hi';
    // exit;
    $trans_do = $this->input->post('trans_do');
    $query = $this->db->get_where('tdf_dr_cr_note', array('invoice_no =' => $this->input->post('trans_do')));
	if($query->num_rows() == 0){	
	
    $data = $this->api_callcr($trans_do);
    // echo '<pre>';
    $dt = $data ? $data[0] : $data;
    
    $HsnCd = strlen($dt->HsnCd)==4 ? $dt->HsnCd . '00' : $dt->HsnCd;
    // echo '<pre>';
    $str_arr = explode('/', $dt->No);
    $suf = substr($str_arr[1], 0, 4);
    $send_str = str_replace('-', '',substr($str_arr[4], 0,5));
    $send_str1 = str_replace('_', '-',substr($str_arr[5], 0,10));
    // $doc_no = $suf . '/' . substr(str_replace('_', '-', $->No), 15, 11);
    // $doc_no = $suf . '/' .$send_str. substr(str_replace('_', '-', $dt->No), 20,6);
    $doc_no = $suf . '/' .$send_str. '/'  .$send_str1 ;

//     $result = '{
//         "Version": "'.$dt->Version.'",
//         "TranDtls": {
//             "TaxSch": "'.$dt->TaxSch.'",
//             "SupTyp": "'.$dt->SupTyp.'",
//             "RegRev": "'.$dt->RegRev.'",
//             "EcmGstin": null,
//             "IgstOnIntra": "N"
//         },
//         "DocDtls": {
//             "Typ": "'.$dt->Typ.'",
//             "No": "'.$doc_no.'",
//             "Dt": "'.CURRDT.'"
//         },
//         "SellerDtls": {
//             "Gstin": "'.SALLERGSTIN.'",
//             "LglNm": "'.$dt->LglNm.'",
//             "TrdNm": "'.$dt->TrdNm.'",
//             "Addr1": "'.$dt->Addr1.'",
//             "Addr2": "'.$dt->Addr2.'",
//             "Loc": "'.$dt->Loc.'",
//             "Pin": '.$dt->Pin.',
//             "Stcd": "'.SALLERSTCD.'",
//             "Ph": "'.SALLERPH.'",
//             "Em": "'.SALLEREM.'"
//         },
//         "BuyerDtls": {
//             "Gstin": "'.$dt->Gstin1.'",
//             "LglNm": "'.$dt->LglNm1.'",
//             "TrdNm": "'.$dt->TrdNm1.'",
//             "Pos": "'.$dt->Pos.'",
//             "Addr1": "'.$dt->Addr1_1.'",
//             "Addr2": "'.$dt->Addr2_1.'",
//             "Loc": "'.$dt->Loc1.'",
//             "Pin": '.$dt->Pin1.',
//             "Stcd": "'.$dt->Stcd1.'",
//             "Ph": "'.$dt->Ph1.'",
//             "Em": "'.$dt->Em1.'"
//         },
//         "DispDtls": {
//             "Nm": "'.$dt->Nm2.'",
//             "Addr1": "'.$dt->Addr1_2.'",
//             "Addr2": "'.$dt->Addr2_2.'",
//             "Loc": "'.$dt->Loc2.'",
//             "Pin": '.$dt->Pin2.',
//             "Stcd": "'.$dt->Stcd2.'"
//         },
//         "ShipDtls": {
//             "Gstin": "'.$dt->Gstin2.'",
//             "LglNm": "'.$dt->LglNm2.'",
//             "TrdNm": "'.$dt->TrdNm2.'",
//             "Addr1": "'.$dt->Addr1_3.'",
//             "Addr2": "'.$dt->Addr2_3.'",
//             "Loc": "'.$dt->Loc3.'",
//             "Pin": '.$dt->Pin3.',
//             "Stcd": "'.$dt->Stcd3.'"
//         },
//         "ItemList": [
//             {
//             "SlNo": "1",
//             "PrdDesc": "'.$dt->PrdDesc.'",
//             "IsServc": "'.$dt->IsServc.'",
//             "HsnCd": "'.$HsnCd.'",
//             "Barcde": "'.$dt->Barcde.'",
//             "Qty": '.$dt->Qty.',
//             "FreeQty": '.$dt->FreeQty.',
//             "Unit": "'.$dt->Unit.'",
//             "UnitPrice": '.$dt->UnitPrice.',
//             "TotAmt": '.$dt->TotAmt.',
//             "Discount": '.$dt->Discount.',
//             "PreTaxVal": '.$dt->PreTaxVal.',
//             "AssAmt": '.$dt->AssAmt.',
//             "GstRt": '.$dt->GstRt.',
//             "IgstAmt": '.$dt->IgstAmt.',
//             "CgstAmt":'.$dt->CgstAmt.',
//             "SgstAmt":'.$dt->SgstAmt.',
//             "CesRt": '.$dt->CesRt.',
//             "CesAmt": '.$dt->CesAmt.',
//             "CesNonAdvlAmt": '.$dt->CesNonAdvlAmt.',
//             "StateCesRt": '.$dt->StateCesRt.',
//             "StateCesAmt": '.$dt->StateCesAmt.',
//             "StateCesNonAdvlAmt":'.$dt->StateCesNonAdvlAmt.',
//             "OthChrg": '.$dt->OthChrg.',
//             "TotItemVal": '.$dt->TotItemVal.',
//             "OrdLineRef": "'.$dt->OrdLineRef.'",
//             "OrgCntry": "'.$dt->OrgCntry.'",
//             "PrdSlNo": "'.$dt->PrdSlNo.'",
//             "BchDtls": {
//                 "Nm": "",
//                 "ExpDt": null,
//                 "WrDt": null
//             },
//             "AttribDtls": [
//                 {
//                 "Nm": "'.$dt->Nm5.'",
//                 "Val": "'.$dt->Val.'"
//                 }
//             ]
//             }
//         ],
//         "ValDtls": {
//             "AssVal": '.$dt->AssVal.',
//             "CgstVal": '.$dt->CgstVal.',
//             "SgstVal": '.$dt->SgstVal.',
//             "IgstVal": 0,
//             "CesVal": '.$dt->CesVal.',
//             "StCesVal": '.$dt->StCesVal.',
//             "Discount": '.$dt->Discount.',
//             "OthChrg": '.$dt->OthChrg.',
//             "RndOffAmt": '.$dt->RndOffAmt.',
//             "TotInvVal": '.$dt->TotInvVal.',
//             "TotInvValFc": '.$dt->TotInvValFc.'
//         },
//         "PayDtls": {
//             "Nm": "",
//             "AccDet": "",
//             "Mode": "",
//             "FinInsBr": "",
//             "PayTerm": "",
//             "PayInstr": "",
//             "CrTrn": "",
//             "DirDr": "",
//             "CrDay": 0,
//             "PaidAmt": 0,
//             "PaymtDue": 0
//         },
//         "RefDtls": {
//             "InvRm": "",
//             "DocPerdDtls": {
//             "InvStDt": null,
//             "InvEndDt": null
//             },
//             "PrecDocDtls": [
//             {
//                 "InvNo": "",
//                 "InvDt": null,
//                 "OthRefNo": ""
//             }
//             ],
//             "ContrDtls": [
//             {
//                 "RecAdvRef": "",
//                 "RecAdvDt": null,
//                 "TendRefr": "",
//                 "ContrRefr": "",
//                 "ExtRefr": "",
//                 "ProjRefr": "",
//                 "PORefr": "",
//                 "PORefDt": null
//             }
//             ]
//         },
//         "AddlDocDtls": [
//             {
//             "Url": "",
//             "Docs": "",
//             "Info": ""
//             }
//         ],
//         "ExpDtls": {
//             "ShipBNo": "",
//             "ShipBDt": null,
//             "Port": null,
//             "RefClm": "",
//             "ForCur":null,
//             "CntCode": null
//         },
//         "EwbDtls": {
//             "TransId": "",
//             "TransName": "",
//             "Distance": 0,
//             "TransDocNo": "",
//             "TransDocDt": null,
//             "VehNo": "",
//             "VehType": "",
//             "TransMode": ""
//         }
//         }';
//         echo $result;exit;
//     var_dump($data); exit;
//      echo ( $doc_no);exit;
//    echo ( $doc_no);exit;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
        //CURLOPT_URL => 'https://einvoicing.internal.cleartax.co/v1/govt/api/Invoice',
        /****************for production server */
        CURLOPT_URL => 'https://api-einv.cleartax.in/v1/govt/api/Invoice',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
        "Version": "'.$dt->Version.'",
        "TranDtls": {
            "TaxSch": "'.$dt->TaxSch.'",
            "SupTyp": "'.$dt->SupTyp.'",
            "RegRev": "",
            "EcmGstin": null,
            "IgstOnIntra": "N"
        },
        "DocDtls": {
            "Typ": "CRN",
            "No": "'.$doc_no.'",
            "Dt": "'.CURRDT.'"
        },
        "SellerDtls": {
            "Gstin": "'.SALLERGSTIN.'",
            "LglNm": "'.$dt->LglNm.'",
            "TrdNm": "'.$dt->TrdNm.'",
            "Addr1": "'.$dt->Addr1.'",
            "Addr2": "'.$dt->Addr2.'",
            "Loc": "'.$dt->Loc.'",
            "Pin": '.$dt->Pin2.',
            "Stcd": "'.SALLERSTCD.'",
            "Ph": "'.SALLERPH.'",
            "Em": "'.SALLEREM.'"
        },
        "BuyerDtls": {
            "Gstin": "'.$dt->Gstin1.'",
            "LglNm": "'.$dt->LglNm1.'",
            "TrdNm": "'.$dt->TrdNm1.'",
            "Pos": "'.$dt->Pos.'",
            "Addr1": "'.$dt->Addr1_1.'",
            "Addr2": "'.$dt->Addr2_1.'",
            "Loc": "'.$dt->Loc1.'",
            "Pin": '.$dt->Pin1.',
            "Stcd": "'.$dt->Stcd1.'",
            "Ph": "'.$dt->Ph1.'",
            "Em": "'.$dt->Em1.'"
        },
        "DispDtls": {
            "Nm": "'.$dt->Nm2.'",
            "Addr1": "'.$dt->Addr1_2.'",
            "Addr2": "'.$dt->Addr2_2.'",
            "Loc": "'.$dt->Loc2.'",
            "Pin": '.$dt->Pin2.',
            "Stcd": "'.$dt->Stcd2.'"
        },
        "ShipDtls": {
            "Gstin": "'.$dt->Gstin2.'",
            "LglNm": "'.$dt->LglNm2.'",
            "TrdNm": "'.$dt->TrdNm2.'",
            "Addr1": "'.$dt->Addr1_3.'",
            "Addr2": "'.$dt->Addr2_3.'",
            "Loc": "'.$dt->Loc3.'",
            "Pin": '.$dt->Pin3.',
            "Stcd": "'.$dt->Stcd3.'"
        },
        "ItemList": [
            {
            "SlNo": "1",
            "PrdDesc": "'.$dt->PrdDesc.'",
            "IsServc": "'.$dt->IsServc.'",
            "HsnCd": "'.$HsnCd.'",
            "Barcde": "'.$dt->Barcde.'",
            "Qty": '.$dt->Qty.',
            "FreeQty": '.$dt->FreeQty.',
            "Unit": "'.$dt->Unit.'",
            "UnitPrice": '.$dt->UnitPrice.',
            "TotAmt": '.$dt->TotAmt.',
            "Discount": '.$dt->Discount.',
            "PreTaxVal": '.$dt->PreTaxVal.',
            "AssAmt": '.$dt->AssAmt.',
            "GstRt": '.$dt->GstRt.',
            "IgstAmt": '.$dt->IgstAmt.',
            "CgstAmt":'.$dt->CgstAmt.',
            "SgstAmt":'.$dt->SgstAmt.',
            "CesRt": '.$dt->CesRt.',
            "CesAmt": '.$dt->CesAmt.',
            "CesNonAdvlAmt": '.$dt->CesNonAdvlAmt.',
            "StateCesRt": '.$dt->StateCesRt.',
            "StateCesAmt": '.$dt->StateCesAmt.',
            "StateCesNonAdvlAmt":'.$dt->StateCesNonAdvlAmt.',
            "OthChrg": '.$dt->OthChrg.',
            "TotItemVal": '.$dt->TotItemVal.',
            "OrdLineRef": "'.$dt->OrdLineRef.'",
            "OrgCntry": "'.$dt->OrgCntry.'",
            "PrdSlNo": "'.$dt->PrdSlNo.'",
            "BchDtls": {
                "Nm": "",
                "ExpDt": null,
                "WrDt": null
            },
            "AttribDtls": [
                {
                "Nm": "'.$dt->Nm5.'",
                "Val": "'.$dt->Val.'"
                }
            ]
            }
        ],
        "ValDtls": {
            "AssVal": '.$dt->AssVal.',
            "CgstVal": '.$dt->CgstVal.',
            "SgstVal": '.$dt->SgstVal.',
            "IgstVal": 0,
            "CesVal": '.$dt->CesVal.',
            "StCesVal": '.$dt->StCesVal.',
            "Discount": '.$dt->Discount.',
            "OthChrg": '.$dt->OthChrg.',
            "RndOffAmt": '.$dt->RndOffAmt.',
            "TotInvVal": '.$dt->TotInvVal.',
            "TotInvValFc": '.$dt->TotInvValFc.'
        },
        "PayDtls": {
            "Nm": "",
            "AccDet": "",
            "Mode": "",
            "FinInsBr": "",
            "PayTerm": "",
            "PayInstr": "",
            "CrTrn": "",
            "DirDr": "",
            "CrDay": 0,
            "PaidAmt": 0,
            "PaymtDue": 0
        },
        "RefDtls": {
            "InvRm": "",
            "DocPerdDtls": {
            "InvStDt": null,
            "InvEndDt": null
            },
            "PrecDocDtls": [
            {
                "InvNo": "",
                "InvDt": null,
                "OthRefNo": ""
            }
            ],
            "ContrDtls": [
            {
                "RecAdvRef": "",
                "RecAdvDt": null,
                "TendRefr": "",
                "ContrRefr": "",
                "ExtRefr": "",
                "ProjRefr": "",
                 "PORefr": "'.$dt->PORefr.'",
                 "PORefDt": "'.$dt->PORefDt.'"
            }
            ]
        },
        "AddlDocDtls": [
            {
            "Url": "",
            "Docs": "",
            "Info": ""
            }
        ],
        "ExpDtls": {
            "ShipBNo": "",
            "ShipBDt": null,
            "Port": null,
            "RefClm": "",
            "ForCur":null,
            "CntCode": null
        }
        
        }',
        CURLOPT_HTTPHEADER => array(
            'x-cleartax-auth-token: ' . AUTHKOKEN,
            'x-cleartax-product: ' . PRODUCT,
            'Content-Type: application/json',
            'owner_id: ' . OWNERID,
            'gstin: ' . SALLERGSTIN
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;
        $res = json_decode($response);
        if($res->Success == 'Y'){
            $this->save_irncr($this->input->post(), $res->Irn, $res->AckNo,$res->AckDt);
        }else{
            echo $response;
        }
    }else{
        $this->session->set_flashdata('error', 'There are some credit note found kindly delete it first');
        redirect('irncancr');
    }
}


function save_irncr($data, $irn, $ackno ,$AckDt){
// var_dump($data);
    // $data = $this->input->post();
    $res = $this->SaleModel->save_irncr($data, $irn,$ackno,$AckDt);
    echo $res;
}


	
	}
?>
