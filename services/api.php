<?php
 	require_once("Rest.inc.php");
	require_once("../api/db.php");

	class API extends REST {
	
		public $data = "";
		

		private $db = NULL;
		private $mysqli = NULL;
		public function __construct(){
			parent::__construct();				// Init parent contructor
			$this->dbConnect();					// Initiate Database connection
		}
		
		/*
		 *  Connect to Database
		*/
		private function dbConnect(){
			$this->mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB);
			$this->mysqli->set_charset("utf8");
		}
		
		/*
		 * Dynmically call the method based on the query string
		 */
		public function processApi(){
			$func = strtolower(trim(str_replace("/","",$_REQUEST['x'])));
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',404); // If the method not exist with in this class "Page not found".
		}
				
		/*private function login(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}
			$email = $this->_request['email'];		
			$password = $this->_request['pwd'];
			if(!empty($email) and !empty($password)){
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					//$query="SELECT user_id, user_email, user_password FROM users WHERE user_email = '$email' AND user_password = '".md5($password)."' LIMIT 1";
					$query="SELECT user_id, user_email, user_password FROM users WHERE user_email = '$email' AND user_password = '".$password."' LIMIT 1";
					$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);

					if($r->num_rows > 0) {
						$result = $r->fetch_assoc();	
						// If success everythig is good send header as "OK" and user details
						$this->response($this->json($result), 200);
					}
					$this->response('', 204);	// If no records "No Content" status
				}
			}
			
			$error = array('status' => "Failed", "msg" => "Invalid Email address or Password");
			$this->response($this->json($error), 400);
		}*/
		
		private function categories() {	
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$query="SELECT distinct c.categorie_id, c.categorie_label, c.categorie_label_fr, c.categorie_description, c.categorie_description_fr, c.categorie_image_path FROM reading_challenge_categorie c";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);

			if($r->num_rows > 0){
				$result = array();
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				$this->response($this->json($result), 200); // send user details
			}
			// If no records "No Content" status
			$this->response('',204);	
		}

		private function categorie(){	
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$id = (int)$this->_request['id'];
			if($id > 0){	
				$query="SELECT distinct c.categorie_id, c.categorie_label, c.categorie_label_fr, c.categorie_description, c.categorie_description_fr, c.categorie_image_path FROM reading_challenge_categorie c where c.categorie_id=$id";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				if($r->num_rows > 0) {
					$result = $r->fetch_assoc();	
					$this->response($this->json($result), 200); // send user details
				}
			}
			$this->response('',204);	// If no records "No Content" status
		}
		
		private function insertCategorie(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}

			$categorie = json_decode(file_get_contents("php://input"),true);
			$column_names = array('categorie_label', 'categorie_label_fr', 'categorie_description', 'categorie_description_fr', 'categorie_image_path');
			$keys = array_keys($categorie);
			$columns = '';
			$values = '';
			foreach($column_names as $desired_key){ // Check the categorie received. If blank insert blank into the array.
			   if(!in_array($desired_key, $keys)) {
			   		$$desired_key = '';
				}else{
					$$desired_key = $categorie[$desired_key];
				}
				$columns = $columns.$desired_key.',';
				$values = $values."'".$$desired_key."',";
			}
			$query = "INSERT INTO reading_challenge_categorie(".trim($columns,',').") VALUES(".trim($values,',').")";
			if(!empty($categorie)){
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Categorie Created Successfully.", "data" => $categorie);
				$this->response($this->json($success),200);
			}else
				$this->response('',204);	//"No Content" status
		}
		
		private function updateCategorie(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}
			$categorie = json_decode(file_get_contents("php://input"),true);
			$id = (int)$categorie['id'];
			$column_names = array('categorie_label', 'categorie_label_fr', 'categorie_description', 'categorie_description_fr');
			$keys = array_keys($categorie['categorie']);
			$columns = '';
			$values = '';
			foreach($column_names as $desired_key){ // Check the categorie received. If key does not exist, insert blank into the array.
			   if(!in_array($desired_key, $keys)) {
			   		$$desired_key = '';
				}else{
					$$desired_key = $categorie['categorie'][$desired_key];
				}
				$columns = $columns.$desired_key."='".$$desired_key."',";
			}
			$query = "UPDATE reading_challenge_categorie SET ".trim($columns,',')." WHERE categorie_id=$id";
			if(!empty($categorie)){	
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Categorie ".$id." Updated Successfully.", "data" => $categorie);
				$this->response($this->json($success),200);
			}else
				$this->response('',204);	// "No Content" status
		}
		
		private function deleteCategorie(){
			if($this->get_request_method() != "DELETE"){
				$this->response('',406);
			}
			$id = (int)$this->_request['id'];
			if($id > 0){				
				$query="DELETE FROM reading_challenge_categorie WHERE categorie_id = $id";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Successfully deleted one record.");
				$this->response($this->json($success),200);
			}else
				$this->response('',204);	// If no records "No Content" status
		}
		
		/*
		 *	Encode array into JSON
		*/
		private function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
		}
	}
	
	// Initiiate Library
	
	$api = new API;
	$api->processApi();
?>