<?php
use Illuminate\Redis\Database;
class Market extends Eloquent{
	const IS_PUBLISH = 1;
	
	/**
	 *
	 * listingMarkets: this function using for listing all markets
	 * @return array
	 * @access public
	 */
	public function listingMarkets(){
		$filterNameEn = Input::get('filter_name_en');
		$filterNameKm = Input::get('filter_name_km');
		$filterStair = Input::get('filter_stair');
		$filterMarketType = Input::get('filter_market_type');
		$response = new stdClass();
		$arr = array();
		try {
			$query = DB::table(Config::get('constants.TABLE_NAME.MARKET'));
			$query->select('*');
			if(!empty($filterNameEn)){
				$query->where('title_en','LIKE','%'.trim($filterNameEn).'%');
			}
			if(!empty($filterNameKm)){
				$query->where('title_km','LIKE','%'.trim($filterNameKm).'%');
			}
			if(!empty($filterStair)){
				$query->where('amount_stair','=', $filterStair);
			}
			if(!empty($filterMarketType)){
				$query->where('market_type','=', $filterMarketType);
			}
			$query->orderBy('id','desc');
			$result = $query->paginate(Config::get('constants.BACKEND_PAGINATION_MARKET'));

			$response->data = $result;
		}catch (\Exception $e){
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $response;
	}

	/**
	 *
	 * listingEditData: this function using for listing market by id
	 * @param integer $id: the id of market
	 * @return array object of Market
	 * @access public
	 */
	public function listingEditData($id = null){
		$response = new stdClass();
		$arr = array();
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.MARKET'))
			->select('*')
			->where('id', '=', $id)
			->first();

			$response->data = $result;
		}catch (\Exception $e){
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $response;
	}

	/**
	 *
	 * listingProvinces: this function using for listing all provinces
	 * @return stdClass
	 * @access public
	 */
	public function listingProvinces(){
		$response = new stdClass();
		$arr = array();
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.PROVINCE'))
			->select('province_id','province_name_en', 'province_name_km')
			->get();
			$arr[''] = 'Select Province';
			foreach ($result as $provinces) {
				$arr[$provinces->province_id] = $provinces->{'province_name_'.Session::get('lang')};
			}
			$response->data = $arr;
		}catch (\Exception $e){
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $response;
	}

	/**
	 *
	 * listingDistricts: this function using for listing all districts
	 * @return array: the object provinces
	 * @access public
	 */
	public function listingDistricts($id){
		$response = new stdClass();
		$arr = array();
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.DISTRICT'))
			->select('id','dis_name_en', 'dis_name_km')
			->where('province_id','=', $id)
			->get();
			foreach ($result as $districts) {
				$arr[$districts->id] = $districts->{'dis_name_'.Session::get('lang')};
			}
			$response->data = $arr;
		}catch (\Exception $e){
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $response;
	}

	/**
	 *
	 * listingAllDistricts: this function using for listing all districts
	 * @return array: the object provinces
	 * @access public
	 */
	public static function listingAllDistricts(){
		$response = new stdClass();
		$arr = array();
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.DISTRICT'))
			->select('id','dis_name_en', 'dis_name_km')
			->get();
			$response->data = $result;
		}catch (\Exception $e){
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $response;
	}

/**
	 *
	 * listingMarketsType: this function using for listing all market types
	 * @return array: the object market types
	 * @access public
	 */
	public function listingMarketsType(){
		$response = new stdClass();
		$arr = array();
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.CLIENT_TYPE'))
			->select('id','name_en', 'name_km', 'account_type_id')
			->where('id','!=', 1)
			->where('id','!=', 2)
			->get();
			foreach ($result as $marketType) {
				$arr[$marketType->id] = $marketType->name_en;
			}
			$response->data = $arr;
		}catch (\Exception $e){
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $response;
	}
/**
	 *
	 * listingMarketsType: this function using for listing all market types
	 * @return array: the object market types
	 * @access public
	 */
	public function dataListingMarketsType(){
		$response = new stdClass();
		//$arr = array(''=>'Market Type');
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.CLIENT_TYPE'))
			->select('id','name_en','name_km','account_type_id')
			->where('account_type_id','!=',1)
			->get();
			$response->data = $result;
		}catch (\Exception $e){
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $response;
	}
	/**
	 *
	 * saveAddMarket: this function using for saving data into market
	 * @param array $data: handle all data for preparing data
	 * @return boolean: true if the data has been saved successfully
	 * @access public
	 */
	public function saveAddMarket($data){

		$response = new stdClass();
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.MARKET'))->insertGetId($data);
			$response->result = $result;
		}catch (\Exception $e){
			$response->result = 0;
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $response;
	}

	/**
	 *
	 * saveEditMarket: this function using for save existing data
	 * @param integer $id: the id of market
	 * @param array $data: handle all data for preparing saving into market
	 * @param string $file: the file name
	 * @return boolean: true if the existing data has been saved successfully
	 * @access public
	 */
	public function saveEditMarket($id,$data,$file=null){
		$response = new stdClass();
		try {

			if(!empty($file)){
				$fileName = DB::table(Config::get('constants.TABLE_NAME.MARKET'))->select('image') ->where('id','=',$id)->first();
				if(!empty($fileName->image)){
					$destinationPath = base_path() . '/public/upload/market/';
					$destinationPathThumb = base_path() . '/public/upload/market/thumb/';
					File::delete($destinationPath . $fileName->image);
					File::delete($destinationPathThumb . $fileName->image);
				}
			}
			$result = DB::table(Config::get('constants.TABLE_NAME.MARKET'))->where('id','=',$id)->update($data);
			$response->result = 1;
		}catch (\Exception $e){
			$response->result = 0;
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $response;
	}


	/**
	 *
	 * deleteMarket: this function using for deleting an existing Market
	 * @param id: the id of slideshow
	 * @return true: if an existing Market has been deleted
	 * @access public
	 * @throws Exception
	 */
	public function deleteMarket($id){
		$response = new stdClass();
		try {
			$fileName = DB::table(Config::get('constants.TABLE_NAME.MARKET'))->select('image') ->where('id','=',$id)->first();
			if(!empty($fileName->image)){
				$destinationPath = base_path() . '/public/upload/market/';
				$destinationPathThumb = base_path() . '/public/upload/market/thumb/';
				File::delete($destinationPath . $fileName->image);
				File::delete($destinationPathThumb . $fileName->image);
			}
			$result = DB::table(Config::get('constants.TABLE_NAME.MARKET'))->where('id','=',$id)->delete();
			$response->result =$result;
			if(0==$result){
				$response->errorMsg = 'Can not delete market';
			}
		}catch (\Exception $e){
			$response->result = 0;
			$response->errorMsg = $e->getMessage();
		}
		return $response;
	}
	
	/**
	 *
	 * getMarketTofrontend: this function is used for selecting all supper market to front end
	 * @param id: is id the market weather it is supper market, homeshop, individual or ...
	 * @access: public
	 * @author: KIMHIM HOM
	 * @return true: if have supper markets in Database
	 * @throws Exception
	 */
	
	public function getMarketTofrontend(){
		$response = new stdClass();
		$arr = array();
		try {
			$query = DB::table(Config::get('constants.TABLE_NAME.MARKET'));
			$query->select('*');
			$query->where('market_type','=', 5);
			foreach ($result as $marketType) {
				$arr[$marketType->id] = $marketType->name;
			}
			
			$query->orderBy('id','desc');
			$result = $query->paginate(Config::get('constants.BACKEND_PAGINATION_MARKET'));
			$response->data = $arr;
		}catch (\Exception $e){
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $response;
	}

	public function findAllBusinessTypes() {
		$response = new stdClass();

		try {
			$query = DB::table(Config::get('constants.TABLE_NAME.ACCOUNT_ROLE'))->get();
			$response->data = $query;
		} catch (\Exception $e) {
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}

		return $response;
	}

	public function findAllProvinces(){
		$response = new stdClass();

		try {
			$query = DB::table(Config::get('constants.TABLE_NAME.PROVINCE'))->get();
			$response->data = $query;
		} catch (\Exception $e) {
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}

		return $response;
	}


	public function mainMarket($id){
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.CLIENT_TYPE'))
			->select('*')
			->where('id','=', $id)
			->take(1)
			->get();
		} catch (\Exception $e) {
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}

		return $result;
	}

	public function listsupermarketfront($parent_id){
		$response = new stdClass();

		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.MARKET'))
			->select('*')
			->where('market_type','=', $parent_id)->get();
			$response = $result;
		} catch (\Exception $e) {
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}

		return $response;
	}

	public function listproductofsupermarket($client_type_id){
		// try {
		// 	$result = DB::table(Config::get('constants.TABLE_NAME.PRODUCT'))
		// 	->select('*')
		// 	//->where('id','=', $id)
		// 	->take(1)
		// 	->get();
		// } catch (\Exception $e) {
		// 	Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		// }
		// var_dump($result);die;
		$productTable = Config::get ( 'constants.TABLE_NAME.PRODUCT' );
		$userTable = Config::get ( 'constants.TABLE_NAME.USER' );
		$storeTable = Config::get ( 'constants.TABLE_NAME.STORE' );

		try {
			$data = DB::table ( $userTable . ' AS user' )
			->join ( $productTable . ' AS pro', 'user.id', '=', 'pro.user_id' )
			->where ( 'pro.is_publish', '=', self::IS_PUBLISH )
			->orderBy ('pro.id', 'DESC' )
			->select ( '*' )
			->where('user.client_type','=', $client_type_id)
			->get();
		} catch (\Exception $e) {
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $data;
	}

	public static function findMarketTypeById($marketTypeId) {
		$result = DB::table(Config::get('constants.TABLE_NAME.CLIENT_TYPE'))
			->select('name_en')
			->where('id','=', $marketTypeId)
			->first();

		return !empty($result->name_en) ? $result->name_en : null;
	}

}
