<?php
/**
   * Register a new user for the application
   * Data expected in the post : name, email, postalCode and pwd
   * @return Array as json with result => boolean and msg => String
   */
class RegisterAction extends CAction
{
    public function run()
    {
        $name = (!empty($_POST['name'])) ? $_POST['name'] : "";
		$email = (!empty($_POST['email'])) ? $_POST['email'] : "";
		$postalCode = (!empty($_POST['cp'])) ? $_POST['cp'] : "";
		$pwd = (!empty($_POST['pwd'])) ? $_POST['pwd'] : "";
		$city = (!empty($_POST['city'])) ? $_POST['city'] : "";

		//Get the person data
		$newPerson = array(
			'name'=> $name,
			'email'=>$email,
			'postalCode'=> $postalCode,
			'pwd'=>$pwd,
			'city'=>$city);

		try {
			$res = Person::insert($newPerson, false);

			Person::saveUserSessionData($res["id"],$email,array("name"=>$name));

		} catch (CTKException $e) {
			$res = array("result" => false, "msg"=>$e->getMessage());
		}

		Rest::json($res);
		exit;
    }
}