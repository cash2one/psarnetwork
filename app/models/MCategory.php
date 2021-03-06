<?php

class MCategory extends Eloquent{
	const IS_PUBLISH = 1;
	
	/**
	 *
	 * fetchCategoryTreeList: this function using for listing sub category
	 * @return array category tree list
	 * @param integer $parent: the parent id of category
	 * @param array $treeArray:the array tree for listing category
	 * @param integer $level: the level of listing category
	 * @access public
	 */
	function fetchCategoryTreeList($parent = 0, $treeArray = '',$level=0) {
		try {
			$filterNameEn = Input::get('filter_name_en');
			$filterNameKm = Input::get('filter_name_km');
			$filterStatus = Input::get('filter_status');
		if(!is_array($treeArray)){
				$treeArray = array();
			}
			$query = DB::table(Config::get('constants.TABLE_NAME.M_CATEGORY'));
			$query->select('id','name_en','name_km','status','parent_id');
			if(!empty($filterNameEn)){
				$query->where('name_en','LIKE', '%'. $filterNameEn.'%');
			}
			if(!empty($filterNameKm)){
				$query->where('name_km','LIKE', '%'. $filterNameKm.'%');
			}
			if(!empty($filterStatus)){
				$query->where('status','=', $filterStatus);
			}
			$query->where('parent_id','=',$parent);
			$query->orderBy('id','asc');
			$result = $query->get();
			if(count($result) > 0){

				foreach ($result as $row) {
					$statusImage = ($row->status == 1) ? 'icon-ok success':'icon-remove danger';
					$treeArray[] = '<tr>';
						$treeArray[] = '<td>' . $row->id . '</td>';
						$treeArray[] = '<td>' . str_repeat ( '&#8212;&nbsp;', $level ) . $row->name_en . "</td>";
						$treeArray[] = '<td>' . str_repeat ( '&#8212;&nbsp;', $level ) . $row->name_km . "</td>";
						$treeArray[] = '<td align="center">' . str_repeat ( '&#8212;&nbsp;', $level ) ."<a href='".URL::to('admin/status-category/'.$row->id.'/'.$row->status)."' class='".$statusImage."'></a></td>";
						$treeArray[] = '<td align="center"><a href="'.URL::to('admin/edit-category/'.$row->id).'"><i class="icon-edit primary"></i></a> <a href="'.URL::to('admin/delete-category/'.$row->id).'" ><i class="icon-trash danger"></a></i></td>';
					$treeArray[] = '</tr>';
					$treeArray = self::fetchCategoryTreeList($row->id,$treeArray,$level+1);
				}
			}
		}catch (\Exception $e){
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $treeArray;
	}

	/**
	 *
	 * fetchCategoryTree: this function using for list dropdown
	 * @param integer $parent: the parent id
	 * @param string $spacing:The space for indent child
	 * @param array $treeArray: the array tree for category
	 * @return array
	 * @access public
	 */
	public function fetchCategoryTree($parent = 0, $spacing = '', $treeArray = ''){
		try {
			if(!is_array($treeArray)){
				$treeArray = array();
			}
			$result = DB::table(Config::get('constants.TABLE_NAME.M_CATEGORY'))
					->select('id','name_en','name_km','status','parent_id')
					->where('parent_id','=',$parent)
					->orderBy('id','asc')
					->get();
			if(count($result) > 0){
				foreach ($result as $row) {
					$treeArray[] = array(
							'id' => $row->id,
							'parent_id' => $row->parent_id, 
							'name_en' => $spacing . $row->name_en,
							'name_km' => $spacing . $row->name_km
						);
					$treeArray = self::fetchCategoryTree($row->id, $spacing . '&nbsp;&nbsp;',$treeArray);
				}
			}
		}catch (\Exception $e){
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $treeArray;
	}

	/**
	 *
	 * getCategoryById: the function using for category by id
	 * @param integer $id: the id of category
	 * @return array category
	 * @access public
	 */
	public function getCategoryById($id){
		$response = new stdClass();
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.M_CATEGORY'))
					->select('id','name_en','name_km','status','parent_id')
					->where('id','=',$id)
					->orderBy('id','asc')
					->first();
			$response->data = $result;
			$response->result = 1;

		}catch (\Exception $e){
			$response->result = 0;
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $response;
	}
	/**
	 *
	 * findUserCategoryBy: the function using for category by name
	 * @param string $name: the name of category
	 * @return array category
	 * @access public
	 */
	public function findUserCategoryBy($name='',$user=''){
		$status = 1;
		$response = new stdClass();
		try {
			$query = DB::table(Config::get('constants.TABLE_NAME.S_CATEGORY'));
			$query->select('name_en','name_km', 'm_cat_id');
			if(!empty($user)) {
				$query->where('user_id', '=', $user);
				$query->where(function ($query) use ($name, $status) {
				    return $query->where('name_en', 'like', "%$name%")
				    	->where('is_publish','=', $status)
				    	->orWhere('name_en', 'like', "%$name")
						->orWhere('name_en', 'like', "$name%")
						->orWhere('name_en', '=', $name)
						->orWhere('name_km', 'like', "%$name%")
						->orWhere('name_km', 'like', "%$name")
						->orWhere('name_km', 'like', "$name%")
						->orWhere('name_km', '=', $name);
					});
			}
			$query->orderBy('name_en','asc');
			$result = $query->get();
			$response->data = $result;
			$response->result = 1;
	
		}catch (\Exception $e){
			$response->result = 0;
			$response->error = 'Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine();
			//Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $response;
	}

	/**
	 *
	 * getCategoryById: the function using for category by id
	 * @param integer $id: the id of category
	 * @return array category
	 * @access public
	 */
	public function findMainCategoryBy($name=''){
		$response = new stdClass();
		try {
			$query = DB::table(Config::get('constants.TABLE_NAME.M_CATEGORY'));
			$query->select('name_en','name_km', 'id');
			if(!empty($name)) {
				$field = 'name_'.Session::get('lang');
				$query->where($field, '=', $name);
			}
			$query->orderBy('name_en','asc');
			$result = $query->first();
			$response->data = $result;
			$response->result = 1;
	
		}catch (\Exception $e){
			$response->result = 0;
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $response;
	}
	/**
	 *
	 * getCategoryById: the function using for category by id
	 * @param integer $id: the id of category
	 * @return array category
	 * @access public
	 */
	public function findCategoryBy($name=''){
		$response = new stdClass();
		try {
			$query = DB::table(Config::get('constants.TABLE_NAME.M_CATEGORY'));
			$query->select('name_en','name_km', 'id');
			if(!empty($name)) {
				$field = 'name_'.Session::get('lang');
				$query->where($field, 'like', "%$name%");
				$query->orWhere($field, 'like', "%$name");
				$query->orWhere($field, 'like', "$name%");
				$query->orWhere($field, '=', $name);
			}
			$query->orderBy('name_en','asc');
			$result = $query->get();
			$response->data = $result;
			$response->result = 1;
	
		}catch (\Exception $e){
			$response->result = 0;
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $response;
	}
	/**
	 *
	 * getCategoryById: the function using for category by id
	 * @param integer $id: the id of category
	 * @return array category
	 * @access public
	 */
	public function getCategoryByName($Name, $user){
		$response = new stdClass();
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.S_CATEGORY'))
					->select('*')
					->where('name_en','=',$Name)
                    ->where('user_id','=',$user)
					->orderBy('id','asc')
					->first();
			$response->data = $result;
            
			$response->result = 1;

		}catch (\Exception $e){
			$response->data = 0;
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $response;
	}

	/**
	 *
	 * getCategoryById: the function using for category by id
	 * @param integer $id: the id of category
	 * @return array category
	 * @access public
	 */
	public function getUserCategory($userID,$id=null){
		$response = new stdClass();
		try {
            if(!is_null($id)) {
                $where = array(
                    'user_id' => $userID,
                    'm_cat_id' => $id
                );
            } else {
                $where = array(
                    'user_id' => $userID
                );
            }
            
			$result = DB::table(Config::get('constants.TABLE_NAME.S_CATEGORY'))
					->where($where)
                    //->where('user_id','=',$userID)
					->orderBy('id','desc')
					->first();
			$response->data = $result;
			$response->result = 1;

		}catch (\Exception $e){
			$response->result = 0;
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $response;
	}
    
    
	/**
	 *
	 * getCategoryById: the function using for category by id
	 * @param integer $id: the id of category
	 * @return array category
	 * @access public
	 */
	public function getUserCategoryById($id,$userID){
		$response = new stdClass();
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.S_CATEGORY'))
					->where('m_cat_id','=',$id)
                    ->where('user_id','=',$userID)
					->orderBy('id','asc')
					->first();
			$response->data = $result;
			$response->result = 1;

		}catch (\Exception $e){
			$response->result = 0;
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $response;
	}
	
	/**
	 *
	 * addSaveCategory: this function using for saving new category
	 * @param array $data: this data holding all data from posting
	 * @return true if the data has been saved successfully
	 * @access public
	 */
	public function addSaveCategory($data){

		$response = new stdClass();
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.M_CATEGORY'))->insertGetId($data);
			$response->result = $result;
		}catch (\Eexception $e){
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
			$response->result = 0;
		}

		return $response;
	}

	public function addProductCategory($data){
	
		$response = new stdClass();
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.PRODUCT_IN_CATEGORY'))->insertGetId($data);
			$response->result = $result;
		}catch (\Eexception $e){
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
			$response->result = 0;
		}
	
		return $response;
	}
	/**
	 *
	 * editSaveCategory: this function using for edit saved for category
	 * @param integer $id: the id of category
	 * @param array $data: The data of holding for category
	 * @return true: if the category has been updated successfully
	 * @access public
	 */
	public function editSaveCategory($id,$data){
		$response = new stdClass();
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.M_CATEGORY'))->where('id','=',$id)->update($data);
			$response->result = $result;
		}catch (\Eexception $e){
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
			$response->result = 0;
		}

		return $response;
	}

	/**
	 *
	 * deleteCategory: this function using for deleting category by id
	 * @param integer $id: the id of category
	 * @return true: if the category has been deleted successfully
	 * @access public
	 */
	public function deleteCategory($id=null){
		$response = new stdClass();
		try{
			$response = $this->deleteChildByParentId($id);
			$response->result = 1;
		}catch (\Exception $e){
			$response->result = 0;
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
	}

	/**
	 *
	 * deleteChildByParentId: this function using for delete child of category depending on parent id
	 * @param integer $id: the id of category
	 * @return true: if the child category has been deleted
	 * @access public
	 */
	public function deleteChildByParentId($id) {
		$result = DB::table(Config::get('constants.TABLE_NAME.M_CATEGORY'))->where('parent_id','=', $id)->get();
		DB::table(Config::get('constants.TABLE_NAME.M_CATEGORY'))->where('id','=', $id)->delete();
		if (count($result) > 0) {
			foreach ($result as $category) {
				$this->findChildByParentId($category->id);
			}
		}
	}

	/**
	 *
	 * isStatusPublic: this function uisng for enable or disable status
	 * @param integer $id: the id of category
	 * @param integer $status: the status of category
	 * @return true: if the category status has been changed
	 * @access public
	 */
	public function isStatusPublic($id, $status){

		$response = new stdClass();
		try{
			$status = ($status == 1) ? 0: 1;
			$result = DB::table(Config::get('constants.TABLE_NAME.M_CATEGORY'))->where('parent_id','=', $id)->get();
			 DB::table(Config::get('constants.TABLE_NAME.M_CATEGORY'))->where('id','=',$id)->update(array('status'=>$status));
			if (count($result) > 0) {
			foreach ($result as $category) {
				$this->isStatusPublic($category->id, $category->status);
			}
		}
		$response->result = 1;
		}catch (\Exception $e){
			$response->result = 0;
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}

		return $response;
	}

	/**
	 *
	 * getsubCategories: this function is used for get sub categories to front page
	 * @param integer $parent: parent id of the category
	 * @return true: if the sub categories is selected
	 * @access public
	 */

	public function getSubCategories($parent=0){
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.M_CATEGORY'))
			->select('id','name_en','name_km','status','parent_id')
			->where('parent_id','=',$parent)
			->where('status','=',1)
			->orderBy('name_en','asc')
			->get();
		}catch (\Exception $e){
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $result;
	}

	/**
	 *
	 * getsubCategories: this function is used for get sub categories to front page
	 * @param integer $parent: parent id of the category
	 * @return true: if the sub categories is selected
	 * @access public
	 */

	public function getSubUserCategories($user='', $parent=0){
		try {
			if(!empty($user)) {
				$query = DB::table(Config::get('constants.TABLE_NAME.S_CATEGORY'));
				$query->select('*');
				$query->where('is_publish','=',1);
				$query->where('user_id','=',$user);
			} else {
				$query = DB::table(Config::get('constants.TABLE_NAME.M_CATEGORY'));
				$query->select('*');
				$query->where('status','=',1);
			}
			$query->where('parent_id','=',$parent);
			$query->orderBy('name_en','asc');
			$result = $query->get();
		}catch (\Exception $e){
		  $result = array();
		  ECHO 'Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine();
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $result;
	}



	/**
	*
	* getSubCategoriesDropdown: this function is used for selecting sub menu for homepage
	* @param integer $mainID: is Top parent ID to be active menu
	* @param integer $parent : is the parent ID
	* @return string: if menu selected will display as HTML format
	* @access public
	*
	*/
	public function getSubCategoriesDropdown($mainID, $parent){
		try {
			$results = DB::table(Config::get('constants.TABLE_NAME.M_CATEGORY'))
			->select('id','name_en','name_km','status','parent_id')
			->where('parent_id','=',$parent)
			->where('status','=',1)
			->orderBy('name_en','asc')
 			->get();
			if(count($results)>0){
				foreach ($results as $dropdownlist){
					echo '<ul style="float:left;" class="item_menu">';
						echo '<li>';
							echo '<b>';
								echo $dropdownlist->{'name_'.Session::get('lang')};
							echo '</b>';
						echo '</li>';
						$this->getLastFinalCategories($mainID, $dropdownlist->id);
					echo '</ul>';
					?>
					<script>
						jQuery(document).ready(function(){
							jQuery(".show_more<?php echo $dropdownlist->id?>, .less_view<?php echo $dropdownlist->id?>, #less_view<?php echo $dropdownlist->id?>").hide();
							jQuery("#more_view<?php echo $dropdownlist->id?>").hover(function(){
								jQuery(".show_more<?php echo $dropdownlist->id?>").slideDown();
								jQuery(".less_view<?php echo $dropdownlist->id?>, #less_view<?php echo $dropdownlist->id?>").show();
								jQuery(".more_view<?php echo $dropdownlist->id?>").hide();
							});
							jQuery("#less_view<?php echo $dropdownlist->id?>").hover(function(){
								jQuery(".show_more<?php echo $dropdownlist->id?>").slideUp();
								jQuery(".less_view<?php echo $dropdownlist->id?>").hide();
								jQuery(".more_view<?php echo $dropdownlist->id?>").show();
							});	
						});
					</script>
					<?php
				}
			}
		}catch (\Exception $e){
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $results;
	}

	public function getLastFinalCategories($id){
		try {
			$results = DB::table(Config::get('constants.TABLE_NAME.M_CATEGORY'))
			->select('id','name_en','name_km','status','parent_id')
			->where('parent_id','=',$id)
			->where('status','=',1)
			->orderBy('id','asc')
 			->get();
			if(count($results)>0){
					$i = 1;
					foreach ($results as $dropdownlist){
						if($i<=10){
							?>
							<li>
								<a href="<?php echo URL::to('products/productbycategories/'.$id.'/'.$dropdownlist->id); ?>" >
									<?php
									$finalCateName = $dropdownlist->{'name_'.Session::get('lang')};
									echo str_limit($finalCateName, $limit = 20, $end = '...');
									?>
								</a>
							</li>
						<?php 
						}
						$i++;
					}
			}
			if(count($results)>10){
				?>
				<li>
					<a href="<?php echo URL::to('products/productbycategories/'.$id.'/1'); ?>" >
						More...
					</a>
				</li>
				<?php		
			}
		}catch (\Exception $e){
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $results;
	}
	
	
	/**
	 *
	 * getMainCategories : is a function for getting Main categories to display front page
	 * @param
	 * @return true : if it main categories is selected sucessfully
	 * @access public
	 * @author kimhim
	 */

	public function getMainCategories($parentid = 0){
		$response = new stdClass();
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.M_CATEGORY'))
			->select('*')
			->where('status','=', 1)
			->where('parent_id','=',$parentid)->get();
			$response->result = $result;
		}catch (\Exception $e){
			$response->result = 0;
			$response->errorMsg = $e->getMessage();
		}

		return $response;
	}

	/**
	 *
	 * getMainCategories : is a function for getting Main categories to display front page
	 * @param
	 * @return true : if it main categories is selected sucessfully
	 * @access public
	 * @author kimhim
	 */	
	public function getRelatedCategoriesProduct($pro_id = 0, $user_id=null){
		$response = new stdClass();
		try {
			$query = DB::table(Config::get('constants.TABLE_NAME.PRODUCT_IN_CATEGORY'));
			$query->select('*');
			$query->where('product_id','=',$pro_id);
			if($user_id) {
				$query->where('user_id','=',$user_id);
			}
			$response = $query->get();
		}catch (\Exception $e){
			$response = array();
			$response->errorMsg = $e->getMessage();
		}
	
		return $response;
	}
	
	
	/**
	* getMainCategoriesForDetail is function for getting menu in detail page of khmerabba
	*
	*/
	public function getMainCategoriesForDetail($parent_id){
		$response = new stdClass();
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.M_CATEGORY'))
			->select('*')
			->where('status','=', 1)
			->where('id','=',$parent_id)->get();
			$response->result = $result;
		}catch (\Exception $e){
			$response->result = 0;
			$response->errorMsg = $e->getMessage();
		}

		return $response;
	}


	public function countCategory($categoryid){
		$response = new stdClass();
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.M_CATEGORY'))
			->select('*')
			->where('status','=', 1)
			->where('parent_id','=',$categoryid)->count();
		}catch (\Exception $e){
			$result = 0;
			$result->errorMsg = $e->getMessage();
		}
		return $result;
	}



    /**
     * Getting menu
     *
     * @method userCategory
     * @return array
     */
    public function userCategory($jsonArray, $parentID = 0) {
        if (!empty($jsonArray)) {
            $return = array();
            foreach ($jsonArray as $subArray) {
                $returnSubSubArray = array();
                if (!empty($subArray['children'])) {
                    $returnSubSubArray = $this->userCategory($subArray['children'], $subArray['id']);
                }
                $return[] = array('id' => $subArray['id'], 'parentID' => $parentID);
                $return = array_merge($return, $returnSubSubArray);
            }
            return $return;
        }
    }
    
     /**
     * Add or Update menu
     *
     * @method addUserCategory
     * @return void
     */
    public function addUserCategory($jsonArray,$userID) {
        if (!empty($jsonArray)) {
            foreach ($jsonArray as $key => $value) {
                if (is_array($value)) {
                    $checkMenu = $this->getCategoryById($value['id']);
                    
                    /*check for exist category of user*/
                    $checkExistMeun = $this->getUserCategoryById($value['id'],$userID);
                    if(empty($checkExistMeun->data)) {
                        /*add new*/
                        $data = array(
                            'order' => $key,
                            'name_en' => $checkMenu->data->name_en,
                            'name_km' => $checkMenu->data->name_km,
                            'm_cat_id' => $value['id'],
                            'user_id' => $userID,
                            'is_publish' => 1,
                            'parent_id' => $value['parentID']
                        );
                        DB::table(Config::get('constants.TABLE_NAME.S_CATEGORY'))->insertGetId($data);
                    } else {
                        /*UPDATE*/
                        $data = array(
                            'order' => $key,
                            'parent_id' => $value['parentID']
                        );
                        var_dump($data);
                        $whereData = array(
                            'user_id' => $userID,
                            'id' => $value['id'],
                        );
                        var_dump($whereData);
                        DB::table(Config::get('constants.TABLE_NAME.S_CATEGORY'))->where($whereData)->update($data);
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }
    
     /**
     * Delete all for User category
     *
     * @method DelUserCategory
     * @return void
     */
    public function DelUserCategory($userID) {
        try {
            if(!empty($userID)) {
                $data = array(
                    'user_id' => $userID,
                );
                DB::table(Config::get('constants.TABLE_NAME.S_CATEGORY'))->where($data)->delete();
            }
            return true;
        } catch (Exception $e) {
            return $e;
        }
    }
    
     /**
     * for User category
     * @method menuShowNested
     * @return void
     * @author Socheat Ngann
     */
    public function menuShowNested($userID, $parent=0,$level=0) {
        $response = new stdClass();
		try {
            $where = array(
                'is_publish' => 1,
                'user_id' => $userID,
                'parent_id' => $parent
            );
			$result = DB::table(Config::get('constants.TABLE_NAME.S_CATEGORY'))
            ->select('*')
			->where($where)
			->get();
            $userMenus = "";
			$userMenus .= '<ol id="result" class="dd-list mainsub">';
            if(!empty($result)) {
    			foreach($result as $userMenu){
                    if($level ==0) {
                        $id = 'item-'.$userMenu->m_cat_id.$userMenu->m_cat_id;
                    } else {
                        $id = 'item-'.$userMenu->m_cat_id;
                    }
    				$userMenus .= "<li class='dd-item dd3-item' data-id='{$userMenu->m_cat_id}' id='{$id}'>\n";
                        $userMenus .= "<div class='remove-div'></div>\n";
    					$userMenus .= "<div class='dd-handle dd3-handle'>Drag</div>\n";
                        $menuName = $userMenu->{'name_'.Session::get('lang')};                        
    					$userMenus .= "<div class='dd3-content item-{$userMenu->m_cat_id}'>{$menuName}</div>\n";
    
    					// Run this function again (it would stop running when the mysql_num_result is 0
    					$userMenus .= $this->menuShowNestedList($userID, $userMenu->m_cat_id,$level+1);
    				$userMenus .= "</li>\n";
    			} 
            }
            
            $userMenus .= "</ol>\n";
            return $userMenus;
		}catch (\Exception $e){
			$response->result = 0;
			$response->errorMsg = $e->getMessage();
		}
        return $response;
    }
    
    /**
     * Get sub User category
     * @method menuShowNestedList
     * @return void
     * @author Socheat Ngann
     */
    public function menuShowNestedList($userID, $parent=0,$level=0) {
        $response = new stdClass();
		try {
            $where = array(
                'is_publish' => 1,
                'user_id' => $userID,
                'parent_id' => $parent
            );
			$result = DB::table(Config::get('constants.TABLE_NAME.S_CATEGORY'))
            ->select('*')
			->where($where)
			->get();
            $userMenus = "";
			$userMenus .= "<ol class='dd-list' id='sub{$level}-{$parent}'>\n";
            if(!empty($result)) {
    			foreach($result as $userMenu){
                    if($level ==0) {
                        $id = 'item-'.$userMenu->m_cat_id.$userMenu->m_cat_id;
                    } else {
                        $id = 'item-'.$userMenu->m_cat_id;
                    }
                    $id_level = $level+1;
    				$userMenus .= "<li class='dd-item dd3-item' data-id='{$userMenu->m_cat_id}' id='{$id}'>\n";
    					$userMenus .= "<div class='remove-div'></div>\n";
    					$userMenus .= "<div class='dd-handle dd3-handle'>Drag</div>\n";
                        $menuName = $userMenu->{'name_'.Session::get('lang')}; 
    					$userMenus .= "<div class='dd3-content item-{$userMenu->m_cat_id}'>{$menuName}</div>\n";
    					$userMenus .= "<ol class='dd-list' id='sub{$id_level}-{$userMenu->m_cat_id}'></ol>\n";
    
    					// Run this function again (it would stop running when the mysql_num_result is 0
    					$userMenus .= $this->menuShowNestedList($userID, $userMenu->m_cat_id,$level+1);
    				$userMenus .= "</li>\n";
    			} 
            }
            $userMenus .= "</ol>\n";
            return $userMenus;
		}catch (\Exception $e){
			$response->result = 0;
			$response->errorMsg = $e->getMessage();
		}
        return $response;
    }
    
     /**
     * for User category
     * @method menuUserList
     * @return String
     * @author Socheat Ngann
     */
    public function menuUserList($userID, $parent=0,$level=0,$userHome='') {
        $response = new stdClass();
		try {
            $where = array(
                'is_publish' => 1,
                'user_id' => $userID,
                'parent_id' => $parent
            );
			$result = DB::table(Config::get('constants.TABLE_NAME.S_CATEGORY'))
            ->select('*')
			->where($where)
			->get();
            $userMenus = "";
			$userMenus .= "<ul class='sf-menu' id='menunav'>";
            $homeUrl = $userHome;
			if($level==0) {
                $userMenus .= "<li><a class='home' href='{$homeUrl}'>Home</a></li>";
            }
            if(!empty($result)) {
    			foreach($result as $userMenu){
                    if($level ==0) {
                        $id = 'item-'.$userMenu->m_cat_id.$userMenu->m_cat_id;
                    } else {
                        $id = 'item-'.$userMenu->m_cat_id;
                    }
    				$userMenus .= "<li>\n";
                        $menuName = $userMenu->{'name_'.Session::get('lang')};
                        $menuEnName = $userMenu->{'name_en'};
    					$userMenus .= "<a href='{$homeUrl}/search/{$menuEnName}'>{$menuName}</a>\n";
    
    					// Run this function again (it would stop running when the mysql_num_result is 0
    					$userMenus .= $this->menuUserSubList($userID, $userMenu->m_cat_id,$level+1,$userHome);
    				$userMenus .= "</li>\n";
    			} 
            }
            /*get static page for each user*/
            $userMenus .= $this->menuUserPage($userID,1,$userHome);
            $userMenus .= "</ul>\n";
            return $userMenus;
		}catch (\Exception $e){
			$response->result = 0;
			$response->errorMsg = $e->getMessage();
		}
        return $response;
    }

     /**
     * for User category
     * @method menuUserList
     * @return String
     * @author Socheat Ngann
     */
    public function menuUserFree($userID, $parent=0,$level=0,$getUserUrl='') {
        $response = new stdClass();
		try {
			$userMenus = '';
            $where = array(
                'status' => 1,
                'parent_id' => $parent
            );
			// $result = DB::table(Config::get('constants.TABLE_NAME.M_CATEGORY'))
   //         ->select('*')
			// ->where($where)
			// ->get();
            $userMenus = "";
			$userMenus .= "<ul class='sf-menu' id='menunav'>";
            $homeUrl = $getUserUrl;
            if($level==0) {
                $userMenus .= "<li><a class='home' href='{$homeUrl}'>Home</a></li>";
            }
      //      if(!empty($result)) {
   			// foreach($result as $userMenu){
      //              if($level ==0) {
      //                  $id = 'item-'.$userMenu->id.$userMenu->id;
      //              } else {
      //                  $id = 'item-'.$userMenu->id;
      //              }
   			// 	$userMenus .= "<li>\n";
      //                  $menuName = $userMenu->{'name_'.Session::get('lang')};                        
   			// 		$userMenus .= "<a href='#'>{$menuName}</a>\n";
   
   			// 		// Run this function again (it would stop running when the mysql_num_result is 0
   			// 		$userMenus .= $this->menuUserFree($userID, $userMenu->id,$level+1);
   			// 	$userMenus .= "</li>\n";
   			// } 
      //      }
            /*get static page for each user*/
            $userMenus .= $this->menuUserPage($userID,1,$getUserUrl);
            $userMenus .= "</ul>\n";
            return $userMenus;
		}catch (\Exception $e){
			$response->result = 0;
			$response->errorMsg = $e->getMessage();
		}
        return $response;
    }    
    /**
     * Get User sub category
     * @method menuUserList
     * @return string
     * @author Socheat Ngann
     */
    public function menuUserSubList($userID, $parent=0,$level=0,$homeUrl='') {
        $response = new stdClass();
		try {
            $where = array(
                'is_publish' => 1,
                'user_id' => $userID,
                'parent_id' => $parent
            );
			$result = DB::table(Config::get('constants.TABLE_NAME.S_CATEGORY'))
            ->select('*')
			->where($where)
			->get();
            $userMenus = "";
			$userMenus .= "<ul>\n";
            if(!empty($result)) {
    			foreach($result as $userMenu){
                    if($level ==0) {
                        $id = 'item-'.$userMenu->m_cat_id.$userMenu->m_cat_id;
                    } else {
                        $id = 'item-'.$userMenu->m_cat_id;
                    }
                    $id_level = $level+1;
    				$userMenus .= "<li>\n";
                        $menuName = $userMenu->{'name_'.Session::get('lang')};
                        $menuEnName = $userMenu->{'name_en'};
    					$userMenus .= "<a href='{$homeUrl}/search/{$menuEnName}'>{$menuName}</a>\n";
    
    					// Run this function again (it would stop running when the mysql_num_result is 0
    					$userMenus .= $this->menuUserSubList($userID, $userMenu->m_cat_id,$level+1,$homeUrl);
    				$userMenus .= "</li>\n";
    			} 
            }
            $userMenus .= "</ul>\n";
            return $userMenus;
		}catch (\Exception $e){
			$response->result = 0;
			$response->errorMsg = $e->getMessage();
		}
        return $response;
    }
    
    /**
     * Get User Page
     * @method menuUserList
     * @return string
     * @author Socheat Ngann
     */
     public function menuUserPage($userID, $position=1,$getUserUrl='') {
        $response = new stdClass();
		try {
            $where = array(
                'status' => 1,
                'user_id' => $userID,
                'type' => 'static',
                'position' => $position
            );
			$result = DB::table(Config::get('constants.TABLE_NAME.S_PAGE'))
            ->select('*')
			->where($where)
			->get();
            $userMenus = "";
            if(!empty($result)) {
    			foreach($result as $userMenu){
    				$userMenus .= "<li class='pp-item pp3-item item-{$userMenu->id}' data-id='{$userMenu->id}'>\n";
                        $menuName = $userMenu->title; 
    					$userMenus .= "<a href='{$getUserUrl}/p/{$userMenu->id}'>{$menuName}</a>\n";
    				$userMenus .= "</li>\n";
    			} 
            }
            return $userMenus;
		}catch (\Exception $e){
			$response->result = 0;
			$response->errorMsg = $e->getMessage();
		}
        return $response;
    } 


    public function getClientType(){
    	try {
			$result = DB::table(Config::get('constants.TABLE_NAME.CLIENT_TYPE'))
			->select('*')
			->orderBy('id','DESC')
			->get();
		}catch (\Exception $e){
		  $result = array();
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $result;
    }

    public function countProductByClientType($client_type_id){
      	$results = DB::table(Config::get('constants.TABLE_NAME.USER'))
			->select('*')
			->where('client_type','=',$client_type_id)
			->get();

			$client = array();
			foreach($results as $results){
				array_push($client,$results->id);
			}
			$countpro = DB::table(Config::get('constants.TABLE_NAME.PRODUCT'))
			->select('*')
			->whereIn('user_id',$client)
			->count();
			echo $countpro;
			// $product = Config::get ( 'constants.TABLE_NAME.PRODUCT' );
			// $product_in_category = Config::get ( 'constants.TABLE_NAME.PRODUCT_IN_CATEGORY' );
			// $store = Config::get ( 'constants.TABLE_NAME.STORE' );
			// $productTransferType = Config::get('constants.TABLE_NAME.PRODUCT_TRANSFER_TYPE');
			// $productCondition = Config::get ( 'constants.TABLE_NAME.PRODUCT_CONDITION' );
			// $user = Config::get ( 'constants.TABLE_NAME.USER' );
			// $accountRole = Config::get ( 'constants.TABLE_NAME.ACCOUNT_ROLE' );
			// $clientType = Config::get ( 'constants.TABLE_NAME.CLIENT_TYPE' );
			
			// $query =  DB::table ( $product . ' AS p' );
			// $query->join ( $store.' AS st','st.id','=','p.store_id');
			// $query->join ($product_in_category.' AS pro', 'pro.product_id','=','p.id');
			// $query->join ($productTransferType.' AS pt','pt.ptt_id','=','p.pro_transfer_type_id');
			// $query->join ($productCondition.' AS proc','proc.id','=','p.pro_condition_id');
			// $query->join ($user.' AS u','u.id','=','p.user_id');
			// $query->join ($accountRole.' AS accr','accr.rol_id','=','u.account_role');
			// $query->join($clientType.' AS ctype','ctype.id','=','u.client_type');
			// $query->where('u.client_type','=',$client_type_id);
			// $query->whereIn('u.id',$client);
			// $query->where( 'p.publish_date','<=',date('Y-m-d'));
			// $query->where('p.is_publish', '=', self::IS_PUBLISH);
			// $query->groupby('pro.product_id');
			// echo $query->count();
    }


    public function getProductTransfterType(){
    	$results = DB::table(Config::get('constants.TABLE_NAME.PRODUCT_TRANSFER_TYPE'))
			->select('*')
			->get();
		return $results;
    }



    public function getMainCategoriesSupermarket($parent_id){
    	$response = new stdClass();
		try {
			$result = DB::table(Config::get('constants.TABLE_NAME.MARKET'))
			->select('*')
			->where('market_type','=', $parent_id)->get();
			$response->result = $result;
		}catch (\Exception $e){
			$response->result = 0;
			$response->errorMsg = $e->getMessage();
		}
		return $response;
    }


    public function listSellerType(){
		$result = DB::table(Config::get('constants.TABLE_NAME.ACCOUNT_ROLE'))
			->select('*')
			->orderBy('rol_id','ASC')
			->get();
		return $result;
    }

    public function countProductBySellerType($seller_type_id){
      	$results = DB::table(Config::get('constants.TABLE_NAME.USER'))
			->select('id')
			->where('account_role','=',$seller_type_id)
			->get();

			$client = array();
			foreach($results as $results){
				array_push($client,$results->id);
			}

			$countpro = DB::table(Config::get('constants.TABLE_NAME.PRODUCT'))
			->select('*')
			->where ('is_publish', '=', self::IS_PUBLISH )
			->where ('publish_date', '<=',date("Y-m-d"))
			->whereIn('user_id',$client)
			->count();
			echo $countpro;
    }

    public function countProductByProvince($province_id){
      	$results = DB::table(Config::get('constants.TABLE_NAME.USER'))
			->select('*')
			->where('province_id','=',$province_id)
			->get();

			$user= array();
			foreach($results as $results){
				array_push($user,$results->id);
			}

			$countpro = DB::table(Config::get('constants.TABLE_NAME.PRODUCT'))
			->select('*')
			->whereIn('user_id',$user)
			->count();
			echo $countpro;
    }


    /**
	* getAllChildCategories() is the function is used to select all child cateogries of parent categories
	* @param : $parent_id is the main categories id to get all its child categories
	* @return : array() as id of the categories
	* @author : kimhim
	* @
	*
	*
    */
    public function getAllChildCategories($parent_id,$categories = ''){
    	try {
    		if(!is_array($categories)){
				$categories = array();
			}
			$results = DB::table(Config::get('constants.TABLE_NAME.M_CATEGORY'))
						->select('id')
						->where('parent_id','=', $parent_id)
						->get();
			if(count($results) > 0){
				array_push($categories,(int)$parent_id);
				foreach($results as $result){
					$categories[] = array($result->id);
					$categories = self::getAllChildCategories($result->id,$categories);
				}
			}
		}catch (\Exception $e){
			Log::error('Message: '.$e->getMessage().' File:'.$e->getFile().' Line'.$e->getLine());
		}
		return $categories;
    }


}
