<?php
    class Transfer extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $access = $this->session->userdata('userId');
            if($access == '' ){
                redirect("Login");
            }
            $this->load->model('Model_table', "mt", TRUE);
        }

        public function productTransfer(){
            $access = $this->mt->userAccess();
            if(!$access){
                redirect(base_url());
            }

            $data['transferId'] = 0;
            $data['title'] = "Product Transfer";
            $data['content'] = $this->load->view('Administrator/transfer/product_transfer', $data, TRUE);
            $this->load->view('Administrator/index', $data);
        }

        public function transferEdit($transferId){
            $access = $this->mt->userAccess();
            if(!$access){
                redirect(base_url());
            }

            $data['transferId'] = $transferId;
            $data['title'] = "Product Transfer";
            $data['content'] = $this->load->view('Administrator/transfer/product_transfer', $data, TRUE);
            $this->load->view('Administrator/index', $data);
        }

        public function pendingList()
        {
            $access = $this->mt->userAccess();
            if(!$access){
                redirect(base_url());
            }
            $data['title'] = "Pending List";
            $data['content'] = $this->load->view('Administrator/transfer/transfer_pending_list', $data, true);
            $this->load->view('Administrator/index', $data);
        }

        public function addProductTransfer(){
            $res = ['success'=>false, 'message'=>''];
            try{

                $this->db->trans_begin();
                $data = json_decode($this->input->raw_input_stream);
                $transfer = array(
                    'transfer_date' => $data->transfer->transfer_date,
                    'transfer_by' => $data->transfer->transfer_by,
                    'transfer_from' => $this->session->userdata('BRANCHid'),
                    'transfer_to' => $data->transfer->transfer_to,
                    'note' => $data->transfer->note,
                    'total_amount' => $data->transfer->total_amount,
                    'status' => 'p'
                );

                $this->db->insert('tbl_transfermaster', $transfer);
                $transferId = $this->db->insert_id();

                foreach($data->cart as $cartProduct){
                    $transferDetails = array(
                        'transfer_id' => $transferId,
                        'product_id' => $cartProduct->product_id,
                        'quantity' => $cartProduct->quantity,
                        'purchase_rate' => $cartProduct->purchaseRate,
                        'total' => $cartProduct->total
                    );

                    $this->db->insert('tbl_transferdetails', $transferDetails);
                    $transferDetails_id = $this->db->insert_id();

                    $currentBranchInventoryCount = $this->db->query("select * from tbl_currentinventory where product_id = ? and branch_id = ?", [$cartProduct->product_id, $this->session->userdata('BRANCHid')])->num_rows();
                    if($currentBranchInventoryCount == 0){
                        $currentBranchInventory = array(
                            'product_id' => $cartProduct->product_id,
                            'transfer_from_quantity' => $cartProduct->quantity,
                            'branch_id' => $this->session->userdata('BRANCHid')
                        );

                        $this->db->insert('tbl_currentinventory', $currentBranchInventory);
                    } else {
                        $this->db->query("
                            update tbl_currentinventory 
                            set transfer_from_quantity = transfer_from_quantity + ? 
                            where product_id = ? 
                            and branch_id = ?
                        ", [$cartProduct->quantity, $cartProduct->product_id, $this->session->userdata('BRANCHid')]);
                    }

                    // $transferToBranchInventoryCount = $this->db->query("select * from tbl_currentinventory where product_id = ? and branch_id = ?", [$cartProduct->product_id, $data->transfer->transfer_to])->num_rows();
                    // if($transferToBranchInventoryCount == 0){
                    //     $transferToBranchInventory = array(
                    //         'product_id' => $cartProduct->product_id,
                    //         'transfer_to_quantity' => $cartProduct->quantity,
                    //         'branch_id' => $data->transfer->transfer_to
                    //     );

                    //     $this->db->insert('tbl_currentinventory', $transferToBranchInventory);
                    // } else {
                    //     $this->db->query("
                    //         update tbl_currentinventory
                    //         set transfer_to_quantity = transfer_to_quantity + ?
                    //         where product_id = ?
                    //         and branch_id = ?
                    //     ", [$cartProduct->quantity, $cartProduct->product_id, $data->transfer->transfer_to]);
                    // }

                    //update serial number
                    foreach($cartProduct->SerialStore as $value) {
                        
                        $serial = array( 
                            'ps_brunch_id'=> $data->transfer->transfer_to,
                            'ps_transfer_from'=> $this->session->userdata('BRANCHid'),
                            'ps_transfer_to'=> $data->transfer->transfer_to,
                            'ps_transferDetails_id' => $transferDetails_id
                        );

                        $this->db->where('ps_id', $value->ps_id)->update('tbl_product_serial_numbers', $serial);

                    }
                }
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                    $res = ['success'=>true, 'message'=>'Transfer success'];
                }
            } catch (Exception $ex){
                $this->db->trans_rollback();
                $res = ['success'=>false, 'message'=>$ex->getMessage];
            }

            echo json_encode($res);
        }

        public function approveTransfer()
        {
            $res = ['success'=>false, 'message'=>''];
            $data = json_decode($this->input->raw_input_stream);

            /*approve Sale Master Data*/
            try{
                $this->db->set('status', 'a')->where('transfer_id', $data->transfer->transfer_id)->update('tbl_transfermaster');
                //$this->db->set('status', 'a')->where('transfer_id', $data->transfer->transfer_id)->update('tbl_transferdetails');
                
                /*approve Sale Details*/
                //$this->db->set('Status', 'a')->where('SaleMaster_IDNo', $data->saleId)->update('tbl_saledetails');
    
                /*Get Sale Details Data*/
                $transferDetails = $this->db->select('*')->where('transfer_id', $data->transfer->transfer_id)->get('tbl_transferdetails')->result();
    
                foreach ($transferDetails as $key => $product) {
                    // //update stock
                    // $this->db->query("
                    //     update tbl_currentinventory 
                    //     set transfer_to_quantity = transfer_to_quantity + ? 
                    //     where product_id = ?
                    //     and size_id = ?
                    //     and color_id = ?
                    //     and branch_id = ?
                    // ", [$product->quantity, $product->product_id, $product->size_id, $product->color_id, $this->session->userdata('BRANCHid')]);
                    

                     $transferToBranchInventoryCount = $this->db->query("select * from tbl_currentinventory where product_id = ? and branch_id = ?", [$product->product_id, $data->transfer->transfer_to])->num_rows();
                    if($transferToBranchInventoryCount == 0){
                        $transferToBranchInventory = array(
                            'product_id' => $product->product_id,
                            'transfer_to_quantity' => $product->quantity,
                            'branch_id' => $data->transfer->transfer_to
                        );

                        $this->db->insert('tbl_currentinventory', $transferToBranchInventory);
                    } else {
                        $this->db->query("
                            update tbl_currentinventory
                            set transfer_to_quantity = transfer_to_quantity + ?
                            where product_id = ?
                            and branch_id = ?
                        ", [$product->quantity, $product->product_id, $data->transfer->transfer_to]);
                    }
                }
                $res = ['success'=>true, 'message'=>'Transfer Approved'];
            } catch(Exception $ex){
                $res = ['success'=>false, 'message'=>$ex->getMessage];
            }

            echo json_encode($res);
        }


        public function updateProductTransfer(){
            $res = ['success'=>false, 'message'=>''];
            try{
                $this->db->trans_begin();
                $data           = json_decode($this->input->raw_input_stream);
                $transferId     =   $data->transfer->transfer_id;

                $oldTransfer    =   $this->db->query("select * from tbl_transfermaster where transfer_id = ?", $transferId)->row();

                $transfer = array(
                    'transfer_date' => $data->transfer->transfer_date,
                    'transfer_by' => $data->transfer->transfer_by,
                    'transfer_from' => $this->session->userdata('BRANCHid'),
                    'transfer_to' => $data->transfer->transfer_to,
                    'note' => $data->transfer->note
                );

                $this->db->where('transfer_id', $transferId)->update('tbl_transfermaster', $transfer);

                $oldTransferDetails = $this->db->query("select * from tbl_transferdetails where transfer_id = ?", $transferId)->result();
                $this->db->query("delete from tbl_transferdetails where transfer_id = ?", $transferId);
                foreach($oldTransferDetails as $oldDetails) {
                    $this->db->query("
                        update tbl_currentinventory 
                        set transfer_from_quantity = transfer_from_quantity - ? 
                        where product_id = ?
                        and branch_id = ?
                    ", [$oldDetails->quantity, $oldDetails->product_id, $this->session->userdata('BRANCHid')]);

                    // $this->db->query("
                    //     update tbl_currentinventory 
                    //     set transfer_to_quantity = transfer_to_quantity - ? 
                    //     where product_id = ?
                    //     and branch_id = ?
                    // ", [$oldDetails->quantity, $oldDetails->product_id, $oldTransfer->transfer_to]);
                }

                foreach($data->cart as $cartProduct){
                    $transferDetails = array(
                        'transfer_id' => $transferId,
                        'product_id' => $cartProduct->product_id,
                        'quantity' => $cartProduct->quantity,
                        'purchase_rate' => $cartProduct->purchaseRate ?? 0,
                    );

                    $this->db->insert('tbl_transferdetails', $transferDetails);
                    
                    $transferDetails_id = $this->db->insert_id();


                    $currentBranchInventoryCount = $this->db->query("select * from tbl_currentinventory where product_id = ? and branch_id = ?", [$cartProduct->product_id, $this->session->userdata('BRANCHid')])->num_rows();

                    if($currentBranchInventoryCount == 0){

                        $currentBranchInventory = array(
                            'product_id' => $cartProduct->product_id,
                            'transfer_from_quantity' => $cartProduct->quantity,
                            'branch_id' => $this->session->userdata('BRANCHid')
                        );

                        $this->db->insert('tbl_currentinventory', $currentBranchInventory);
                        
                    } else {
                        $this->db->query("
                            update tbl_currentinventory 
                            set transfer_from_quantity = transfer_from_quantity + ? 
                            where product_id = ? 
                            and branch_id = ?
                        ", [$cartProduct->quantity, $cartProduct->product_id, $this->session->userdata('BRANCHid')]);
                    }

                    // $transferToBranchInventoryCount = $this->db->query("select * from tbl_currentinventory where product_id = ? and branch_id = ?", [$cartProduct->product_id, $data->transfer->transfer_to])->num_rows();
                    // if($transferToBranchInventoryCount == 0){
                    //     $transferToBranchInventory = array(
                    //         'product_id' => $cartProduct->product_id,
                    //         'transfer_to_quantity' => $cartProduct->quantity,
                    //         'branch_id' => $data->transfer->transfer_to
                    //     );

                    //     $this->db->insert('tbl_currentinventory', $transferToBranchInventory);
                    // } else {
                    //     $this->db->query("
                    //         update tbl_currentinventory
                    //         set transfer_to_quantity = transfer_to_quantity + ?
                    //         where product_id = ?
                    //         and branch_id = ?
                    //     ", [$cartProduct->quantity, $cartProduct->product_id, $data->transfer->transfer_to]);
                    // }

                    //update serial number
                    foreach($cartProduct->SerialStore as $value) {
                        $serial = array( 
                            'ps_brunch_id'=> $data->transfer->transfer_to,
                            'ps_transfer_from'=> $this->session->userdata('BRANCHid'),
                            'ps_transfer_to'=> $data->transfer->transfer_to,
                            'ps_transferDetails_id' => $transferDetails_id
                        );
                        $this->db->where('ps_id', $value->ps_id)->update('tbl_product_serial_numbers', $serial);
                    }
                }

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                    $res = ['success'=>true, 'message'=>'Transfer updated'];
                }
            } catch (Exception $ex){
                $this->db->trans_rollback();
                $res = ['success'=>false, 'message'=>$ex->getMessage];
            }

            echo json_encode($res);
        }

        public function transferList(){
            $access = $this->mt->userAccess();
            if(!$access){
                redirect(base_url());
            }
            $data['title'] = "Transfer List";
            $data['content'] = $this->load->view('Administrator/transfer/transfer_list', $data, true);
            $this->load->view('Administrator/index', $data);
        }

        public function receivedList(){
            $access = $this->mt->userAccess();
            if(!$access){
                redirect(base_url());
            }
            $data['title'] = "Received List";
            $data['content'] = $this->load->view('Administrator/transfer/received_list', $data, true);
            $this->load->view('Administrator/index', $data);
        }

        public function getTransfers(){
            $data = json_decode($this->input->raw_input_stream);

            $clauses = "";
            if(isset($data->branch) && $data->branch != ''){
                $clauses .= " and tm.transfer_to = '$data->branch'";
            }

            if((isset($data->dateFrom) && $data->dateFrom != '') && (isset($data->dateTo) && $data->dateTo != '')){
                $clauses .= " and tm.transfer_date between '$data->dateFrom' and '$data->dateTo'";
            }

            if(isset($data->transferId) && $data->transferId != ''){
                $clauses .= " and tm.transfer_id = '$data->transferId'";
            }

            $transfers = $this->db->query("
                select
                    tm.*,
                    b.Brunch_name as transfer_to_name,
                    e.Employee_Name as transfer_by_name
                from tbl_transfermaster tm
                join tbl_brunch b on b.brunch_id = tm.transfer_to
                join tbl_employee e on e.Employee_SlNo = tm.transfer_by
                where tm.transfer_from = ? $clauses
            ", $this->session->userdata('BRANCHid'))->result();

            echo json_encode($transfers);
        }

        public function getTransferDetails() {
            $data = json_decode($this->input->raw_input_stream);
            $transferDetails = $this->db->query("
                select 
                    td.*,
                    tm.transfer_to,
                    p.Product_Code,
                    p.Product_Name,
                    pc.ProductCategory_Name
                from tbl_transferdetails td
                join tbl_transfermaster tm on tm.transfer_id = td.transfer_id
                join tbl_product p on p.Product_SlNo = td.product_id
                left join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
                where td.transfer_id = ?
            ", $data->transferId)->result();

            $transferDetails = array_map(function($product) {
                $product->serials = $this->db->query("
                    select 
                        ps.*
                    from tbl_product_serial_numbers ps 
                    where ps.ps_status = 'a'
                    and ps.ps_prod_id = ?
                    and ps.ps_transfer_to = ?
                ", [$product->product_id, $product->transfer_to])->result();
                return $product;
            }, $transferDetails);            

            echo json_encode($transferDetails);
        }

        public function getReceives(){

            $data = json_decode($this->input->raw_input_stream);

            $branchClause = "";
            if($data->branch != null && $data->branch != ''){
                $branchClause = " and tm.transfer_from = '$data->branch'";
            }

            $dateClause = "";
            if(($data->dateFrom != null && $data->dateFrom != '') && ($data->dateTo != null && $data->dateTo != '')){
                $dateClause = " and tm.transfer_date between '$data->dateFrom' and '$data->dateTo'";
            }

            $transfers = $this->db->query("
                select
                    tm.*,
                    b.Brunch_name as transfer_from_name,
                    e.Employee_Name as transfer_by_name
                from tbl_transfermaster tm
                join tbl_brunch b on b.brunch_id = tm.transfer_from
                join tbl_employee e on e.Employee_SlNo = tm.transfer_by
                where tm.transfer_to = ? $branchClause $dateClause
                and tm.status = 'a'
            ", $this->session->userdata('BRANCHid'))->result();

            echo json_encode($transfers);
        }

        public function getPendingList ()
        {
             $data = json_decode($this->input->raw_input_stream);

            $branchClause = "";
            if($data->branch != null && $data->branch != ''){
                $branchClause = " and tm.transfer_from = '$data->branch'";
            }

            $dateClause = "";
            if(($data->dateFrom != null && $data->dateFrom != '') && ($data->dateTo != null && $data->dateTo != '')){
                $dateClause = " and tm.transfer_date between '$data->dateFrom' and '$data->dateTo'";
            }

            $transfers = $this->db->query("
                select
                    tm.*,
                    b.Brunch_name as transfer_from_name,
                    e.Employee_Name as transfer_by_name
                from tbl_transfermaster tm
                join tbl_brunch b on b.brunch_id = tm.transfer_from
                join tbl_employee e on e.Employee_SlNo = tm.transfer_by
                where tm.transfer_to = ? $branchClause $dateClause
                and tm.status = 'p'
            ", $this->session->userdata('BRANCHid'))->result();

            echo json_encode($transfers);
        }

        public function transferInvoice($transferId){
            $data['title'] = 'Transfer Invoice';

            $data['transfer'] = $this->db->query("
                select
                    tm.*,
                    b.Brunch_name as transfer_to_name,
                    e.Employee_Name as transfer_by_name
                from tbl_transfermaster tm
                join tbl_brunch b on b.brunch_id = tm.transfer_to
                join tbl_employee e on e.Employee_SlNo = tm.transfer_by
                where tm.transfer_id = ?
            ", $transferId)->row();

            $data['transferDetails'] = $this->db->query("
                select
                    td.*,
                    p.Product_Code,
                    p.Product_Name,
                    pc.ProductCategory_Name
                from tbl_transferdetails td
                join tbl_product p on p.Product_SlNo = td.product_id
                join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
                where td.transfer_id = ?
            ", $transferId)->result();

             $data['transferDetails'] = array_map(function ($transferDetail) {
                $transferDetail->serial = $this->db->query("SELECT * FROM tbl_product_serial_numbers WHERE ps_transferDetails_id = ? GROUP BY ps_serial_number", $transferDetail->transferdetails_id)->result();
                return $transferDetail;
            }, $data['transferDetails']);

            $data['content'] = $this->load->view('Administrator/transfer/transfer_invoice', $data, true);
            $this->load->view('Administrator/index', $data);
        }

        public function deleteTransfer() {
            $res = ['success'=>false, 'message'=>''];
            try{
                $data = json_decode($this->input->raw_input_stream);
                $transferId = $data->transferId;

                $oldTransfer = $this->db->query("select * from tbl_transfermaster where transfer_id = ?", $transferId)->row();
                $oldTransferDetails = $this->db->query("select * from tbl_transferdetails where transfer_id = ?", $transferId)->result();
                

                
                foreach($oldTransferDetails as $oldDetails) {
                    $this->db->query("
                        update tbl_currentinventory 
                        set transfer_from_quantity = transfer_from_quantity - ? 
                        where product_id = ?
                        and branch_id = ?
                    ", [$oldDetails->quantity, $oldDetails->product_id, $this->session->userdata('BRANCHid')]);

                    // $this->db->query("
                    //     update tbl_currentinventory 
                    //     set transfer_to_quantity = transfer_to_quantity - ? 
                    //     where product_id = ?
                    //     and branch_id = ?
                    // ", [$oldDetails->quantity, $oldDetails->product_id, $oldTransfer->transfer_to]);

                    // old transfer 
                    $trans = $this->db->query("
                        select 
                            td.*,
                            tm.transfer_from
                        from tbl_transferdetails td 
                        join tbl_transfermaster tm on tm.transfer_id = td.transfer_id
                        where td.transferdetails_id = ?
                    ", $oldDetails->transferdetails_id)->row();

                    //update serial number
                    $serial = array( 
                        'ps_transfer_from '=> null,
                        'ps_transfer_to' => null,
                        'ps_brunch_id' => $trans->transfer_from
                    );
                    $this->db->where('ps_transferDetails_id', $oldDetails->transferdetails_id)->update('tbl_product_serial_numbers', $serial);
                }

                $this->db->query("delete from tbl_transfermaster where transfer_id = ?", $transferId);
                $this->db->query("delete from tbl_transferdetails where transfer_id = ?", $transferId);

                $res = ['success'=>true, 'message'=>'Transfer deleted'];
            } catch (Exception $ex){
                $res = ['success'=>false, 'message'=>$ex->getMessage];
            }

            echo json_encode($res);
        }


         // Cash Transfer 

         public function cashTransfer(){
            $access = $this->mt->userAccess();
            if(!$access){
                redirect(base_url());
            }
            $data['title'] = "Cash Transfer";
            $data['content'] = $this->load->view('Administrator/transfer/cash_transfer', $data, TRUE);
            $this->load->view('Administrator/index', $data);
        }


        public function addCashTransfer()
        {
            $res = ['success'=>false, 'message'=>''];
            try{
                $data = json_decode($this->input->raw_input_stream);
                $transfer = (array) $data->transfer;
                $transfer['transfer_from'] = $this->session->userdata('BRANCHid');
                $transfer['added_by'] = $this->session->userdata("FullName");
                $transfer['added_datetime'] = date("Y-m-d H:i:s");
                $transfer['status'] = 'p';

                $this->db->insert('tbl_cashtransfer', $transfer);

                $res = ['success'=>true, 'message'=>'Transfer success'];
            } catch (Exception $ex){
                $res = ['success'=>false, 'message'=>$ex->getMessage];
            }

            echo json_encode($res);
        }


        public function getCashTransfer()
        {
            $data = json_decode($this->input->raw_input_stream);

            if(isset($data->branchId) && $data->branchId != '')
            {
                $branchId = $data->branchId;
            }else {
                $branchId = $this->session->userdata('BRANCHid');
            }

            $clauses = "";
            if(isset($data->branch) && $data->branch != ''){
                $clauses .= " and tm.transfer_to = '$data->branch'";
            }

            if((isset($data->dateFrom) && $data->dateFrom != '') && (isset($data->dateTo) && $data->dateTo != '')){
                $clauses .= " and tm.transfer_date between '$data->dateFrom' and '$data->dateTo'";
            }
            
            if(isset($data->date) && $data->date != ''){
                $clauses .= " and tm.transfer_date = '$data->date'";
            }

            if(isset($data->userFullName) && $data->userFullName != ''){
                $clauses .= " and tm.added_by = '$data->userFullName'";
            }


            $transfers = $this->db->query("
                select
                    tm.*,
                    b.Brunch_name as transfer_to_name,
                    e.Employee_Name as transfer_by_name
                from tbl_cashtransfer tm
                join tbl_brunch b on b.brunch_id = tm.transfer_to
                left join tbl_employee e on e.Employee_SlNo = tm.transfer_by
                where tm.transfer_from = '$branchId' 
                and tm.status != 'd'
                $clauses
            ")->result();

            // $transfers = array_values($transfers);
            echo json_encode($transfers);
        } 

        public function getCashTransfersPending()
        {
            $data = json_decode($this->input->raw_input_stream);

            if(isset($data->branchId) && $data->branchId != '')
            {
                $branchId = $data->branchId;
            }else {
                $branchId = $this->session->userdata('BRANCHid');
            }

            $clauses = "";
            if(isset($data->branch) && $data->branch != ''){
                $clauses .= " and tm.transfer_to = '$data->branch'";
            }

            if((isset($data->dateFrom) && $data->dateFrom != '') && (isset($data->dateTo) && $data->dateTo != '')){
                $clauses .= " and tm.transfer_date between '$data->dateFrom' and '$data->dateTo'";
            }
            
            if(isset($data->date) && $data->date != ''){
                $clauses .= " and tm.transfer_date = '$data->date'";
            }


            $transfers = $this->db->query("
                select
                    tm.*,
                    b.Brunch_name as transfer_to_name,
                    e.Employee_Name as transfer_by_name
                from tbl_cashtransfer tm
                join tbl_brunch b on b.brunch_id = tm.transfer_to
                left join tbl_employee e on e.Employee_SlNo = tm.transfer_by
                where tm.transfer_to = '$branchId' 
                and tm.status = 'p'
                $clauses
            ")->result();

            // $transfers = array_values($transfers);
            echo json_encode($transfers);
        } 

        public function approveCashTransfer()
        {
            $res = ['success' => false, 'message' => ''];
            $data = json_decode($this->input->raw_input_stream);
            try{

                // $this->db->query("UPDATE TABLE tbl_cashtransfer set status = 'a' WHERE transfer_id = '$data->transferId' ");
                $this->db->set('status', 'a')->where('transfer_id', $data->transfer->transfer_id)->update('tbl_cashtransfer');

                $res = ['success' => true, 'message' => 'Cash Transfer Approved'];
            }catch (Exception $ex){
                $res = ['success' => false, 'message' => $ex->getMessage];
            }

            echo json_encode($res);
        }
        
        public function getCashTransferReceived()
        {
            $data = json_decode($this->input->raw_input_stream);

            $clauses = "";
          
            if((isset($data->dateFrom) && $data->dateFrom != '') && (isset($data->dateTo) && $data->dateTo != '')){
                $clauses .= " and tm.transfer_date between '$data->dateFrom' and '$data->dateTo'";
            }
            
            if(isset($data->date) && $data->date != ''){
                $clauses .= " and tm.transfer_date = '$data->date'";
            }

            if(isset($data->userFullName) && $data->userFullName != ''){
                $clauses .= " and tm.added_by = '$data->userFullName'";
            }


            $transfers = $this->db->query("
                select
                    tm.*,
                    b.Brunch_name as transfer_to_name,
                    e.Employee_Name as transfer_by_name
                from tbl_cashtransfer tm
                join tbl_brunch b on b.brunch_id = tm.transfer_to
                left join tbl_employee e on e.Employee_SlNo = tm.transfer_by
                where tm.transfer_to = ? $clauses
                and tm.status != 'd'
            ", $this->session->userdata('BRANCHid'))->result();

            echo json_encode($transfers);
        }

        public function updateCashTransfer()
        {
            $res = ['success'=>false, 'message'=>''];
            try{
                $data = json_decode($this->input->raw_input_stream);
                $transfer = (array) $data->transfer;
                unset($transfer['transfer_id']);
                $transfer['updated_by'] = $this->session->userdata('userId');
                $transfer['updated_datetime'] = date("Y-m-d H:i:s");

                $this->db->where('transfer_id', $data->transfer->transfer_id);
                $this->db->update('tbl_cashtransfer', $transfer);

                $res = ['success'=>true, 'message'=>'Updated success'];
            } catch (Exception $ex){
                $res = ['success'=>false, 'message'=>$ex->getMessage];
            }

            echo json_encode($res);
        }

        public function deleteCashTransfer()
        {
            $res = ['success'=>false, 'message'=>''];
            try{
                $data = json_decode($this->input->raw_input_stream);

                $this->db->query("DELETE from tbl_cashtransfer where transfer_id = $data");

                $res = ['success'=>true, 'message'=>'Transfer Deleted'];
            } catch (Exception $ex){
                $res = ['success'=>false, 'message'=>$ex->getMessage()];
            }

            echo json_encode($res);
        }


        public function cashTransferRecord()
        {
            $access = $this->mt->userAccess();
            if(!$access){
                redirect(base_url());
            }
            $data['title'] = "Cash Transfer List";
            $data['content'] = $this->load->view('Administrator/transfer/cash_transfer_record', $data, true);
            $this->load->view('Administrator/index', $data);
        }


        public function cashTransferPending()
        {
            $access = $this->mt->userAccess();
            if(!$access){
                redirect(base_url());
            }
            $data['title'] = "Cash Transfer Pending";
            $data['content'] = $this->load->view('Administrator/transfer/cash_transfer_pending', $data, true);
            $this->load->view('Administrator/index', $data);
        }


        public function cashTransferReceived()
        {
            $access = $this->mt->userAccess();
            if(!$access){
                redirect(base_url());
            }
            $data['title'] = "Cash Transfer List";
            $data['content'] = $this->load->view('Administrator/transfer/cash_received_record', $data, true);
            $this->load->view('Administrator/index', $data);
        }


         public function getCashReceives()
        {
            $data = json_decode($this->input->raw_input_stream);

            if(isset($data->branchId) && $data->branchId != '')
            {
                $branchId = $data->branchId;
            }else {
                $branchId = $this->session->userdata('BRANCHid');
            }
            

            $branchClause = "";
            if(isset($data->branch) && $data->branch != ''){
                $branchClause = " and tm.transfer_from = '$data->branch'";
            }

            $dateClause = "";
            if((isset($data->dateFrom) && $data->dateFrom != '') && (isset($data->dateTo) && $data->dateTo != '')){
                $dateClause = " and tm.transfer_date between '$data->dateFrom' and '$data->dateTo'";
            }

            $transfersData = $this->db->query("
                select
                    tm.*,
                    b.Brunch_name as transfer_from_name,
                    e.Employee_Name as transfer_by_name
                from tbl_cashtransfer tm
                join tbl_brunch b on b.brunch_id = tm.transfer_from
                left join tbl_employee e on e.Employee_SlNo = tm.transfer_by
                where tm.transfer_to = ? $branchClause $dateClause
                and tm.status != 'd'
            ",$branchId)->result();

            $transfers = array_values($transfersData);

            echo json_encode($transfers);
        }
    }