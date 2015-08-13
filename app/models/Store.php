<?php
class Store extends Eloquent {

    protected $table = "store";
    public $timestamps = false;

    /**
     * getUserStore : is a function for get user store to display front page
     * @param
     * @return true : if it user store is get sucessfully
     * @access public
     * @author Socheat
     */
    public function getUserStore($userID, $where=array()) {
        $response = new stdClass();
        try {
            if (!empty($where)) {
                $where = $where;
            } else {
                $where = array('user_id' => $userID);
            }
            $result = DB::table(Config::get('constants.TABLE_NAME.STORE'))->select('*')->
                where($where)->first();
            return $result;
        }
        catch (\Exception $e) {
            $response->result = 0;
            $response->errorMsg = $e->getMessage();
        }
    }

    /**
     * getUserStore : is a function for get user store to display front page
     * @param
     * @return true : if it user store is get sucessfully
     * @access public
     * @author Socheat
     */
    public function doUpoad($file, $destinationPath,$width=100, $height=100) {
        /*upload logo image*/
        $destinationPathThumb = $destinationPath . 'thumb/';
        self::generateFolderUpload($destinationPath);
        if(is_array($file)) {
            $fileName = $this->normalize_str($file['name']);
            if(move_uploaded_file($file['tmp_name'], $destinationPath . basename($fileName))) {
                $fileName = $fileName;
            } else {
                $error = true;
                $fileName = array(
                    'message' => 'uploadError',
                );
            }
        } else {
            $fileName = $file->getClientOriginalName();
            $fileName = self::generateFileName($destinationPath, $fileName);
            $file->move($destinationPath, $fileName);    
            Image::make($destinationPath . $fileName)->resize($width,$height)->save($destinationPathThumb . $fileName);
        }
        /*end upload logo image*/

        $images = array('image' => $fileName);
        return $images;
    }

    /**
     * Generation fileName when uploading file
     * @return filename by generation
     * @access public
     * @method generateFileName
     * @throws Exception
     */
    public static function generateFileName($pathName, $fileName = null) {

        $temp = explode(".", $fileName);
        $fileName = end($temp);
        $fileName = time() . '.' . $fileName;
        if (file_exists($pathName . $fileName)) {
            return generateFileName($pathName);
        }

        return $fileName;
    }

    /**
     * Generation folder when uploading file doesnot exist
     *
     * @return boolean
     * @access private
     * @method generateFolderUpload
     * @throws ErrorException
     */
    private static function generateFolderUpload($destinationPath) {
        $destinationPathThumb = $destinationPath . '/thumb/';
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
            if (!file_exists($destinationPathThumb)) {
                mkdir($destinationPathThumb, 0777, true);
            }
        }
    }

    public static function findStoreByUser($userId) {
        $result = DB::table(Config::get('constants.TABLE_NAME.STORE'))
            ->select('*')
            ->where('user_id', '=', $userId)
            ->first();
        return ($result->id) ? $result->id : null;
    }
    
    public function getStoreUrl($id){
        $result = DB::table(Config::get('constants.TABLE_NAME.STORE'))
            ->select('*')
            ->where('id', '=', $id)
            ->first();
            if(!empty($result->sto_url)) {
                return Config::get('app.url').'page/'.$result->sto_url;
           } else {
                return Config::get('app.url').'page/store-'.$id;
                //Config::get('app.url').'page/'.$dataStore->id;
           }
    }

    /**
     * Get latest store
     * 
     * @author vibol
     * @return Store
     */
    public static function getLatestStores()
    {
        $response = new stdClass();
        try {
            $result = DB::table(Config::get('constants.TABLE_NAME.STORE') . ' AS st')->select('*')
            ->orderBy('st.id', 'DESC')
            ->take(12)
            ->get();

            return $result;
        }
        catch (\Exception $e) {
            $response->result = 0;
            $response->errorMsg = $e->getMessage();
        }
    }
    
    /**
     * Get store banner
     * 
     * @author Socheat
     * @return banner
     */
    public function getStoreBanner($id)
    {
        $response = new stdClass();
        try {
            $where = array('ban_store_id'=>$id,'ban_status'=>1);
            $result = DB::table(Config::get('constants.TABLE_NAME.USER_BANNER'))->select('*')
            ->where($where)
            ->orderBy('ban_id', 'DESC')
            ->get();

            return $result;
        }
        catch (\Exception $e) {
            $response->result = 0;
            $response->errorMsg = $e->getMessage();
        }
    }

    
    /**
     * Get store by condition
     *
     * @author Socheat
     * @return array()
     */    
    public function getStore($where){
    	$result = DB::table(Config::get('constants.TABLE_NAME.STORE'))
    	->select('*')
    	->where($where)
    	->first();
    	if(!empty($result)) {
    		return $result;
    	} else {
    		return false;
    	}
    }
    
    function normalize_str($str) {
        $invalid = array(
            '�' => '&Scaron;',
            '�' => '&scaron;',
            '�' => '&ETH;',
            '�' => '&#381;',
            '�' => '&#382;',
            '�' => '&Agrave;',
            '�' => '&Aacute;',
            '�' => '&Acirc;',
            '�' => '&Atilde;',
            '�' => '&Auml;',
            '�' => '&Aring;',
            '�' => '&AElig;',
            '�' => '&Ccedil;',
            '�' => '&Egrave;',
            '�' => '&Eacute;',
            '�' => '&Ecirc;',
            '�' => '&Euml;',
            '�' => '&Igrave;',
            '�' => '&Iacute;',
            '�' => '&Icirc;',
            '�' => '&Iuml;',
            '�' => '&Ntilde;',
            '�' => '&Ograve;',
            '�' => '&Oacute;',
            '�' => '&Ocirc;',
            '�' => '&Otilde;',
            '�' => '&Ouml;',
            '�' => '&Oslash;',
            '�' => '&Ugrave;',
            '�' => '&Uacute;',
            '�' => '&Ucirc;',
            '�' => '&Uuml;',
            '�' => '&Yacute;',
            '�' => '&THORN;',
            '�' => '&szlig;',
            '�' => '&agrave;',
            '�' => '&aacute;',
            '�' => '&acirc;',
            '�' => '&atilde;',
            '�' => '&auml;',
            '�' => '&aring;',
            '�' => '&aelig;',
            '�' => '&ccedil;',
            '�' => '&egrave;',
            '�' => '&eacute;',
            '�' => '&ecirc;',
            '�' => '&euml;',
            '�' => '&igrave;',
            '�' => '&iacute;',
            '�' => '&icirc;',
            '�' => '&iuml;',
            '�' => '&eth;',
            '�' => '&ntilde;',
            '�' => '&ograve;',
            '�' => '&oacute;',
            '�' => '&ocirc;',
            '�' => '&otilde;',
            '�' => '&ouml;',
            '�' => '&oslash;',
            '�' => '&ugrave;',
            '�' => '&uacute;',
            '�' => '&ucirc;',
            '�' => '&yacute;',
            '�' => '&yacute;',
            '�' => '&thorn;',
            '�' => '&yuml;',
            '�' => '&fnof;',
            "`" => "-",
            "�" => "-",
            "�" => "-",
            "`" => "-",
            "�" => "-",
            "�" => "-",
            "�" => "-",
            "�" => "-",
            "&acirc;��" => "-",
            "{" => "-",
            "~" => "-",
            "�" => "-",
            "�" => "-",
            "�" => "-",
            "�" => "-",
        	" " => "",
        );
    
        $str = str_replace(array_keys($invalid), array_values($invalid), $str);
    
        return $str;
    }   
}
