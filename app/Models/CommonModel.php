<?php
namespace App\Models;

use CodeIgniter\Model;

class CommonModel extends Model
{
    var $table;
    function  __construct(){
        parent::__construct();
        $db = \Config\Database::connect();
        $session = \Config\Services::session();
        $uri = new \CodeIgniter\HTTP\URI();
        helper('form');
        helper('cookie');
        $email = \Config\Services::email();
    }

    // find data
    function find_data($table,$return_type='array',$conditions='',$select='*',$join='',$group_by='',$order_by='',$limit=0,$offset=0,$orConditions='')
    {
        $result = array();
        $builder = $this->db->table($table);
        $builder->select($select);
        if($conditions != '')$builder->where($conditions);
        if($orConditions != '')$builder->orWhere($orConditions);

        //$this->db->from($table_name);
        if(is_array($join))
        {
            for($j=0;$j<count($join);$j++)
            {
                if($join[$j]['table'])
                {
                    /*$table_join = $join[$j]['table'].' as '.$join[$j]['table_alias']*/;
                    //$table_join_name = $join[$j]['table_alias'];
                    $table_join = $join[$j]['table'];
                    $table_join_name = $join[$j]['table'];
                }
                else
                {
                    /*$table_join = $join[$j]['table'];
                    $table_join_name = $join[$j]['table'];*/
                }
                if(!empty($join[$j]['table_master_alias']))
                {
                    $table_master_join = $join[$j]['table_master_alias'];
                }
                else
                {
                    $table_master_join = $join[$j]['table_master'];
                }
                $builder->join($table_join,$table_join_name.'.'.$join[$j]['field'].'='.$table_master_join.'.'.$join[$j]['field_table_master']/*.$join[$j]['and']*/,$join[$j]['type']);
            }
        }


        if(is_array($group_by))
        {
            for($g=0;$g<count($group_by);$g++)
            {
                $builder->groupBy($group_by[$g]);
            }
        }

        if(is_array($order_by))
        {
            for($o=0;$o<count($order_by);$o++)
            {
                $builder->orderBy($order_by[$o]['field'],$order_by[$o]['type']);
            }
        }

        if($limit != 0)$builder->limit($limit,$offset);
        $query = $builder->get();

        switch ($return_type)
        {
            case 'array':
            case '':
                if($query->getNumRows() > 0){$result = $query->getResult();}
                break;
            case 'row':
                if($query->getNumRows() > 0){$result = $query->getRow();}
                break;
            case 'row-array':
                if($query->getNumRows() > 0){$result = $query->getRowArray();}
                break;
            case 'count':
                $result = $query->getNumRows();
                break;
        }
        // echo $this->db->getLastQuery();die;
        return $result;

    }

    // save or update data
    function save_data($table,$postdata = array(),$id,$field)
    {
    	$builder = $this->db->table($table);
    	if($id == '')
		{
			$builder->insert($postdata);
            return $this->db->insertID();
		}
		else
		{			
			$builder->where($field, $id);
			$builder->update($postdata);
            return $this->db->affectedRows();
		}
    }

    function save_batchdata($table,$postdata = array(),$id,$field)
    {
    	$builder = $this->db->table($table);
    	$builder->insertBatch($postdata);
    }

    function update_batchdata($table,$postdata = array(),$conditions='')
    {
        $builder = $this->db->table($table);
        $builder->where($conditions);
        $builder->update($postdata);
        return $this->db->affectedRows();
    }

    // delete data
    function delete_data($table,$id,$field)
    {
        $builder = $this->db->table($table);
        $builder->where($field,$id);
        $builder->delete();
        return true;
    }

    // single file upload
    function upload_single_file($fieldName,$fileName,$uploadedpath='',$uploadType)
    {
        $imge = $fileName;
        if($imge == '')
        {
            $slider_image = 'no-user-image.jpg';
        }
        else
        {
            $imageFileType1 = pathinfo($imge, PATHINFO_EXTENSION);
            if($uploadType=='image') {
                if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" && $imageFileType1 != "JPG" && $imageFileType1 != "PNG" && $imageFileType1 != "JPEG" && $imageFileType1 != "GIF" && $imageFileType1 != "ico" && $imageFileType1 != "ICO")
                {
                    $message = 'Sorry, only JPG, JPEG, ICO, PNG & GIF files are allowed';
                    $status = 0;
                }
                else
                {
                    $message = 'Upload ok';
                    $status = 1;
                }
            } elseif($uploadType=='pdf') {
                if($imageFileType1 != "pdf" && $imageFileType1 != "PDF")
                {
                    $message = 'Sorry, only PDF files are allowed';
                    $status = 0;
                }
                else
                {
                    $message = 'Upload ok';
                    $status = 1;
                }
            } elseif($uploadType=='word') {
                if($imageFileType1 != "doc" && $imageFileType1 != "DOC" && $imageFileType1 != "docx" && $imageFileType1 != "DOCX")
                {
                    $message = 'Sorry, only DOC files are allowed';
                    $status = 0;
                }
                else
                {
                    $message = 'Upload ok';
                    $status = 1;
                }
            } elseif($uploadType=='excel') {
                if($imageFileType1 != "xls" && $imageFileType1 != "XLS" && $imageFileType1 != "xlsx" && $imageFileType1 != "XLSX" && $imageFileType1 != "csv" && $imageFileType1 != "CSV")
                {
                    $message = 'Sorry, only EXCEl files are allowed';
                    $status = 0;
                }
                else
                {
                    $message = 'Upload ok';
                    $status = 1;
                }
            } elseif($uploadType=='csv') {
                if($imageFileType1 != "csv" && $imageFileType1 != "CSV")
                {
                    $message = 'Sorry, only CSV files are allowed';
                    $status = 0;
                }
                else
                {
                    $message = 'Upload ok';
                    $status = 1;
                }
            } elseif($uploadType=='powerpoint') {
                if($imageFileType1 != "ppt" && $imageFileType1 != "PPT" && $imageFileType1 != "pptx" && $imageFileType1 != "PPTX")
                {
                    $message = 'Sorry, only PPT files are allowed';
                    $status = 0;
                }
                else
                {
                    $message = 'Upload ok';
                    $status = 1;
                }
            } elseif($uploadType=='audio') {
                if($imageFileType1 != "mp3" && $imageFileType1 != "mp4" && $imageFileType1 != "mid" && $imageFileType1 != "ogg" && $imageFileType1 != "wav" && $imageFileType1 != "MP3" && $imageFileType1 != "MP4" && $imageFileType1 != "MID" && $imageFileType1 != "OGG" && $imageFileType1 != "WAV")
                {
                    $message = 'Sorry, only mp3, mp4, mid, ogg & wav files are allowed';
                    $status = 0;
                }
                else
                {
                    $message = 'Upload ok';
                    $status = 1;
                }
            }
            
            $newFilename = time().$imge;
            $temp = $_FILES[$fieldName]["tmp_name"];
            if($uploadedpath=='') {
                $upload_path = 'public/uploads/';
            } else {
                $upload_path = 'public/uploads/'.$uploadedpath.'/';
            }

            if($status) {                
                move_uploaded_file($temp,$upload_path.$newFilename);
                $return_array = array('status'=>1, 'message'=>$message, 'newFilename'=>$newFilename);
            } else {
                $return_array = array('status'=>0, 'message'=>$message, 'newFilename'=>'');
            }
            return $return_array;
        }
    }

    function upload_multiple_file($fieldName,$fileName,$uploadedpath='',$uploadType,$tempName)
    {
        $imge = $fileName;
        if($imge == '')
        {
            $slider_image = 'no-user-image.jpg';
        }
        else
        {
            $imageFileType1 = pathinfo($imge, PATHINFO_EXTENSION);
            if($uploadType=='image') {
                if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" && $imageFileType1 != "JPG" && $imageFileType1 != "PNG" && $imageFileType1 != "JPEG" && $imageFileType1 != "GIF" && $imageFileType1 != "ico" && $imageFileType1 != "ICO")
                {
                    $message = 'Sorry, only JPG, JPEG, ICO, PNG & GIF files are allowed';
                    $status = 0;
                }
                else
                {
                    $message = 'Upload ok';
                    $status = 1;
                }
            } elseif($uploadType=='pdf') {
                if($imageFileType1 != "pdf" && $imageFileType1 != "PDF")
                {
                    $message = 'Sorry, only PDF files are allowed';
                    $status = 0;
                }
                else
                {
                    $message = 'Upload ok';
                    $status = 1;
                }
            } elseif($uploadType=='word') {
                if($imageFileType1 != "doc" && $imageFileType1 != "DOC" && $imageFileType1 != "docx" && $imageFileType1 != "DOCX")
                {
                    $message = 'Sorry, only DOC files are allowed';
                    $status = 0;
                }
                else
                {
                    $message = 'Upload ok';
                    $status = 1;
                }
            } elseif($uploadType=='excel') {
                if($imageFileType1 != "xls" && $imageFileType1 != "XLS" && $imageFileType1 != "xlsx" && $imageFileType1 != "XLSX")
                {
                    $message = 'Sorry, only EXCEl files are allowed';
                    $status = 0;
                }
                else
                {
                    $message = 'Upload ok';
                    $status = 1;
                }
            } elseif($uploadType=='powerpoint') {
                if($imageFileType1 != "ppt" && $imageFileType1 != "PPT" && $imageFileType1 != "pptx" && $imageFileType1 != "PPTX")
                {
                    $message = 'Sorry, only PPT files are allowed';
                    $status = 0;
                }
                else
                {
                    $message = 'Upload ok';
                    $status = 1;
                }
            }
            //echo $status;die;
            $newFilename = time().$imge;
            $temp = $tempName;
            if($uploadedpath=='') {
                $upload_path = 'public/uploads/';
            } else {
                $upload_path = 'public/uploads/'.$uploadedpath.'/';
            }
            if($status==1) {
                move_uploaded_file($temp,$upload_path.$newFilename);
                $return_array = array('status'=>1, 'message'=>$message, 'newFilename'=>$newFilename);
            } else {
                $return_array = array('status'=>0, 'message'=>$message, 'newFilename'=>'');
            }
            return $return_array;
        }
    }

    // upload multiple files
    function commonFileArrayUpload($path = '', $images = array(),$uploadType = '')
    {
        $apiStatus = FALSE;
        $apiMessage = [];
        $apiResponse = [];
        // pr($images);
        if(count($images)>0){
            for($p=0;$p<count($images);$p++){
                $imge = $images[$p]->getClientName();
                if($imge == '')
                {
                    $slider_image = 'no-user-image.jpg';
                }
                else
                {
                    $imageFileType1 = pathinfo($imge, PATHINFO_EXTENSION);                    
                    if($uploadType=='image') {
                        if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" && $imageFileType1 != "JPG" && $imageFileType1 != "PNG" && $imageFileType1 != "JPEG" && $imageFileType1 != "GIF" && $imageFileType1 != "ico" && $imageFileType1 != "ICO")
                        {
                            $message = 'Sorry, only JPG, JPEG, ICO, PNG & GIF files are allowed';
                            $status = 0;
                        }
                        else
                        {
                            $message = 'Upload ok';
                            $status = 1;
                        }
                    } elseif($uploadType=='pdf') {
                        if($imageFileType1 != "pdf" && $imageFileType1 != "PDF")
                        {
                            $message = 'Sorry, only PDF files are allowed';
                            $status = 0;
                        }
                        else
                        {
                            $message = 'Upload ok';
                            $status = 1;
                        }
                    } elseif($uploadType=='word') {
                        if($imageFileType1 != "doc" && $imageFileType1 != "DOC" && $imageFileType1 != "docx" && $imageFileType1 != "DOCX")
                        {
                            $message = 'Sorry, only DOC files are allowed';
                            $status = 0;
                        }
                        else
                        {
                            $message = 'Upload ok';
                            $status = 1;
                        }
                    } elseif($uploadType=='excel') {
                        if($imageFileType1 != "xls" && $imageFileType1 != "XLS" && $imageFileType1 != "xlsx" && $imageFileType1 != "XLSX")
                        {
                            $message = 'Sorry, only EXCEl files are allowed';
                            $status = 0;
                        }
                        else
                        {
                            $message = 'Upload ok';
                            $status = 1;
                        }
                    } elseif($uploadType=='powerpoint') {
                        if($imageFileType1 != "ppt" && $imageFileType1 != "PPT" && $imageFileType1 != "pptx" && $imageFileType1 != "PPTX")
                        {
                            $message = 'Sorry, only PPT files are allowed';
                            $status = 0;
                        }
                        else
                        {
                            $message = 'Upload ok';
                            $status = 1;
                        }
                    }                    
                    $newFilename = time().$imge;
                    $temp = $images[$p]->getTempName();
                    if($path=='') {
                        $upload_path = 'public/uploads/';
                    } else {
                        $upload_path = 'public/uploads/'.$path;
                    }
                    if($status) {
                        move_uploaded_file($temp,$upload_path.$newFilename);
                        //$apiStatus      = TRUE;
                        //$apiMessage     = $message;
                        $apiResponse[]  = $newFilename;                        
                    } else {
                        //$apiStatus      = FALSE;
                        //$apiMessage     = $message;
                    }                    
                }
            }
        }
        //$return_array = array('status'=> $apiStatus, 'message'=> $apiMessage, 'newFilename'=> $apiResponse);
        return $apiResponse;
    }

    function clean($string) 
    {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       $string2 = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
       $string3 = preg_replace('/-+/', '-', $string2);
       return $string3;
    }
    function create_field($string) 
    {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       $string2 = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
       $string3 = preg_replace('/-+/', '_', $string2);
       return $string3;
    }

    function weekdays($dayNo) {
        if($dayNo==0) {
            $day_name = 'Sunday';
        }
        if($dayNo==1) {
            $day_name = 'Monday';
        }
        if($dayNo==2) {
            $day_name = 'Tuesday';
        }
        if($dayNo==3) {
            $day_name = 'Wednesday';
        }
        if($dayNo==4) {
            $day_name = 'Thursday';
        }
        if($dayNo==5) {
            $day_name = 'Friday';
        }
        if($dayNo==6) {
            $day_name = 'Saturday';
        }
        return $day_name;
    }
    function monthName($monthNo) {
        if($monthNo==1) {
            $month_name = 'January';
        }
        if($monthNo==2) {
            $month_name = 'February';
        }
        if($monthNo==3) {
            $month_name = 'March';
        }
        if($monthNo==4) {
            $month_name = 'April';
        }
        if($monthNo==5) {
            $month_name = 'May';
        }
        if($monthNo==6) {
            $month_name = 'June';
        }
        if($monthNo==7) {
            $month_name = 'July';
        }
        if($monthNo==8) {
            $month_name = 'August';
        }
        if($monthNo==9) {
            $month_name = 'September';
        }
        if($monthNo==10) {
            $month_name = 'October';
        }
        if($monthNo==11) {
            $month_name = 'November';
        }
        if($monthNo==12) {
            $month_name = 'December';
        }
        return $month_name;
    }
    function financialyear($year){
        return substr_replace($year, '-', 2, 0);
    }

    function format_date($dt)
    {
        return date_format(date_create($dt), "h:i A");
    }

    function format_date2($dt)
    {
        return date_format(date_create($dt), "d-m-Y");
    }

    function total_address($a,$b,$c,$d,$e)
    {
        return $a.' '.$b.' '.$c.' '.$d.' '.$e;
    }

    function time_difference($to_time)
    {
        $to_time = strtotime($to_time);
        $from_time = strtotime(date('Y-m-d H:i:s'));
        $time_diff = round(abs($to_time - $from_time) / 60,0);

        if($time_diff>1440) {
            if($time_diff>525600){
                $totalYears = ($time_diff/1440)/365;
                //echo $totalDays;die;
                $day_diff = round($totalYears,0)." years";
            } else {
                $day_diff = round(($time_diff/1440),0)." days";
            }            
        } else {
            if($time_diff>60){
                $hours = round(($time_diff/60),0);
                $mins = round(($time_diff%60),0);
                $day_diff = $hours." hours ".$mins." mins";
            } else {
                $day_diff = $time_diff. " mins";
            }            
        }
        return $day_diff;
    }

    function page_content($pageID)
    {
        $conditions = array('static_id'=>$pageID);
        $static_page = $this->find_data('sms_static_content','row',$conditions);
        $content = $static_page->description;
        return $content;
    }

    function review_star_show($rating)
    {
        if($rating==0) {
            $star_count = '';
        } elseif($rating>=1 && $rating<2) {
            $star_count = '<span class="fa fa-star checked"></span>';
        } elseif($rating>=2 && $rating<3) {
            $star_count = '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span>';
        } elseif($rating>=3 && $rating<4) {
            $star_count = '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span>';
        } elseif($rating>=4 && $rating<5) {
            $star_count = '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span>';
        } elseif($rating>=5) {
            $star_count = '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span>';
        }
        return $star_count;
    }

    function calculate_average_rating($provider_id, $subcat, $review_count)
    {
        $db = \Config\Database::connect();
        $total_rating_value = $db->query("SELECT sum(rating) as tot_rating FROM `sms_reviews` WHERE `parent_id` = 0 AND `provider_id` = '$provider_id' and subcat='$subcat' and published=1")->getRow();
        if($review_count>0) {
            $avarage_rating = $total_rating_value->tot_rating/$review_count;
        } else {
            $avarage_rating = 0; 
        }
        
        return $avarage_rating;
    }

    public function sendMail($to_email, $email_subject, $mailbody, $attachment = '')
    {
        $siteSetting        = $this->find_data('general_settings', 'row');
        $email              = \Config\Services::email();        
        $from_email         = 'no-reply@market.ecoex.market';
        $from_name          = $siteSetting->site_name;
        $email->setFrom($from_email, $from_name);
        $email->setTo($to_email);
        $email->setCC('subhomoy@keylines.net', 'Ecoex Commodity Trading');
        // $email->setCC('info@ecoex.market', 'Ecoex Portal');
        $email->setSubject($email_subject);
        $email->setMessage($mailbody);
        if($attachment != ''){
            $email->attach($attachment);
        }
        $email->send();
        return true;
    }

    public function sendSMS($mobileNo,$messageBody){
        $siteSetting    = $this->find_data('general_settings', 'row');
        $authKey        = $siteSetting->authentication_key;        
        $senderId       = $siteSetting->sender_id;        
        $route          = "4";
        $postData = array(
            'apikey'        => $authKey,
            'number'        => $mobileNo,
            'message'       => $messageBody,
            'senderid'      => $senderId,
            'format'        => 'json'
        );
        //pr($output); 
        //API URL
        $url            = $siteSetting->base_url;
        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => false,
            CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
        ));
        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //get response
        $output = curl_exec($ch);
        //pr($output);        
        //Print error if any
        if(curl_errno($ch))
        {
            //echo 'error:' . curl_error($ch);
            return FALSE;
        } else {
            return TRUE;
        }
        curl_close($ch);
    }

    function get_user($user_type, $user_id)
    {
        $conditions = array('user_type'=>$user_type, 'user_id'=>$user_id);
        $user_detail = $this->find_data('users','row',$conditions);
        return $user_detail;
    }
    function get_user_detail($user_id)
    {
        $conditions = array('user_id'=>$user_id);
        $user_detail = $this->find_data('users','row',$conditions);
        return $user_detail;
    }

    function get_category($parent_id, $cat_id)
    {
        $conditions = array('parent_id'=>$parent_id, 'cat_id'=>$cat_id);
        $category_detail = $this->find_data('sms_category','row',$conditions);
        return $category_detail;
    }

    function get_business_primary_address($user_id)
    {
        $conditions = array('user_id'=>$user_id, 'is_primary_location'=>1);
        $businessAddress = $this->find_data('sms_business_details','row',$conditions);
        if($businessAddress) {
            $address = $businessAddress->bs_address;
        } else {
            $conditions = array('user_id'=>$user_id, 'is_primary_location'=>1);
            $businessAddress2 = $this->find_data('sms_business_details','row',$conditions);
            if($businessAddress2) {
                $address = $businessAddress2->bs_address;
            } else {
                $address = "";
            }
        }
        return $address;
    }

    function getParentChildTableField($typeId){
        if($typeId == 1){ //Brand
            $returnData['parentTable']          = 'ecoex_target';
            $returnData['parentField']          = 'target_id';
            $returnData['childTable']           = 'ecoex_target_by_state';
            $returnData['childField']           = 'target_id';
            $returnData['inventorySource']      = 'Brand';
            $returnData['inventoryId']          = 'id';
        } elseif($typeId == 2){ //Recycler
            $returnData['parentTable']          = 'ecoex_inventory';
            $returnData['parentField']          = 'inventory_id';
            $returnData['childTable']           = 'ecoex_inventory_by_state';
            $returnData['childField']           = 'inventory_id';
            $returnData['inventorySource']      = 'Recycler';
            $returnData['inventoryId']          = 'id';
        } elseif($typeId == 3){ //End of Life Processor
            $returnData['parentTable']          = 'ecoex_inventory';
            $returnData['parentField']          = 'inventory_id';
            $returnData['childTable']           = 'ecoex_inventory_by_state';
            $returnData['childField']           = 'inventory_id';
            $returnData['inventorySource']      = 'ELP';
            $returnData['inventoryId']          = 'id';
        } elseif($typeId == 4){ //Collector
            $returnData['parentTable']          = 'ecoex_inventory';
            $returnData['parentField']          = 'inventory_id';
            $returnData['childTable']           = 'ecoex_inventory_by_state';
            $returnData['childField']           = 'inventory_id';
            $returnData['inventorySource']      = 'Collector';
            $returnData['inventoryId']          = 'id';
        } elseif($typeId == 5){ //Urban Local Body
            $returnData['parentTable']          = 'ecoex_inventory';
            $returnData['parentField']          = 'inventory_id';
            $returnData['childTable']           = 'ecoex_inventory_by_state';
            $returnData['childField']           = 'inventory_id';
            $returnData['inventorySource']      = 'ULB';
            $returnData['inventoryId']          = 'id';
        } elseif($typeId == 9){ //MRF Operator
            $returnData['parentTable']          = 'ecoex_inventory';
            $returnData['parentField']          = 'inventory_id';
            $returnData['childTable']           = 'ecoex_inventory_by_state';
            $returnData['childField']           = 'inventory_id';
            $returnData['inventorySource']      = 'MRF';
            $returnData['inventoryId']          = 'id';
        } elseif($typeId == 12){ //WMA
            $returnData['parentTable']          = 'ecoex_inventory';
            $returnData['parentField']          = 'inventory_id';
            $returnData['childTable']           = 'ecoex_inventory_by_state';
            $returnData['childField']           = 'inventory_id';
            $returnData['inventorySource']      = 'WMA';
            $returnData['inventoryId']          = 'id';
        } elseif($typeId == 14){ //Trader
            $returnData['parentTable']          = 'ecoex_inventory';
            $returnData['parentField']          = 'inventory_id';
            $returnData['childTable']           = 'ecoex_inventory_by_state';
            $returnData['childField']           = 'inventory_id';
            $returnData['inventorySource']      = 'Trader';
            $returnData['inventoryId']          = 'id';
        } elseif($typeId == 15){ //PIBO
            $returnData['parentTable']          = 'ecoex_inventory';
            $returnData['parentField']          = 'inventory_id';
            $returnData['childTable']           = 'ecoex_inventory_by_state';
            $returnData['childField']           = 'inventory_id';
            $returnData['inventorySource']      = 'PIBO';
            $returnData['inventoryId']          = 'id';
        }
        return $returnData;
    }

    function getUserByUserId($id){
        $join[0]                = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'c_id', 'type' => 'INNER'];
        $join[1]                = ['table' => 'ecoex_member_category', 'field' => 'member_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'user_membership_type', 'type' => 'INNER'];
        $condition              = ['ecoex_user_table.user_id' => $id];
        $select                 = 'ecoex_user_table.*,ecoex_company.c_name,ecoex_member_category.member_type,ecoex_member_category.short_name,ecoex_member_category.is_unit_module';
        $user                   = $this->find_data('ecoex_user_table', 'row', $condition, $select, $join, $select);
        return $user;
    }
    function getUserByCompanyId($id){
        $join[0]                = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'c_id', 'type' => 'INNER'];
        $join[1]                = ['table' => 'ecoex_member_category', 'field' => 'member_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'user_membership_type', 'type' => 'INNER'];
        $condition              = ['ecoex_company.c_id' => $id];
        $select                 = 'ecoex_user_table.*,ecoex_company.c_name,ecoex_member_category.member_type,ecoex_member_category.short_name,ecoex_member_category.is_unit_module';
        $user                   = $this->find_data('ecoex_user_table', 'row', $condition, $select, $join, $select);
        return $user;
    }
    function checkSellerBuyer($uid){
        $this->session  = \Config\Services::session();
        $userId         = $this->session->get('userId');
        if($userId == $uid){
            return true;
        } else {
            return false;
        }
    }
    /* check document upload */
    public function checkDocumentUpload($inquiryId, $attr_id){
        $checkDocs = $this->find_data('ecoex_business_inquiry_excel_data', 'count', ['inquiry_id' => $inquiryId, 'attr_id' => $attr_id, 'attr_value' => '']);
        if($checkDocs<=0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    /* check document upload */
    function pagination($page=0, $perPage=0, $total=0){
        // $pager = \Config\Services::pager();
        $pager = service('pager');
        // Call makeLinks() to make pagination links.
        $pager_links = $pager->makeLinks($page, $perPage, $total);
        return $pager_links;
    }
    /* get bulk lead header value */
    public function getBulkLeadValueByHeader($leadSl, $headerId){
        $leadInfo = $this->find_data('crm_bulk_leads', 'row', ['sl_no' => $leadSl, 'header_id' => $headerId]);
        if($leadInfo){
            $leadData = $leadInfo->header_value;
        } else {
            $leadData = '';
        }
        return $leadData;
    }
    /* check module access */
        public function checkModuleAccess($id){
            $this->common_model = new CommonModel();
            $this->session      = \Config\Services::session();
            $userId             = $this->session->get('user_id');
            $adminUser          = $this->common_model->find_data('ecoex_admin_user', 'row', ['id' => $userId]);
            $checkExist         = $this->common_model->find_data('ecoex_role_module_function', 'count', ['module_id' => $id, 'role_id' => $adminUser->role_id, 'published' => 1]);
            if($checkExist>0){
                return TRUE;
                // $checkExistFunction         = $this->common_model->find_data('ecoex_role_module_function', 'count', ['role_id' => $adminUser->role_id, 'module_id' => $id, 'function_id' => 9, 'published' => 1]);
                // echo $checkExistFunction;die;
                // if($checkExistFunction > 0){
                //     return TRUE;
                // } else {
                //     return FALSE;
                // }
            } else {
                return FALSE;
            }
        }
    /* check module access */
    /* check module function access */
        public function checkModuleFunctionAccess($module_id, $function_id){
            $this->db           = \Config\Database::connect();
            $this->common_model = new CommonModel();
            $this->session      = \Config\Services::session();
            $userId             = $this->session->get('user_id');
            $adminUser          = $this->common_model->find_data('ecoex_admin_user', 'row', ['id' => $userId]);        
            $role_id = $adminUser->role_id;
            $checkExist         = $this->common_model->find_data('ecoex_role_module_function', 'count', ['role_id' => $role_id, 'module_id' => $module_id, 'function_id' => $function_id, 'published' => 1]);
            if($checkExist>0){
                return TRUE;
            } else {
                return FALSE;
            }
        }
    /* check module function access */
}