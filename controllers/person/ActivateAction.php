<?php
/**
* upon Registration a email is send to the new user's email 
* he must click it to activate his account
* This is cleared by removing the tobeactivated field in the pixelactifs collection
*/
class ActivateAction extends CAction
{
    public function run($user) {
    	$controller=$this->getController();
	    $account = Person::getById($user);
	    //TODO : move code below to the model Person
	    if($account){
	        Person::saveUserSessionData( $user, $account["email"],array("name"=>$account["name"]));
	        //remove tobeactivated attribute on account
	        PHDB::update(PHType::TYPE_CITOYEN,
	                            array("_id"=>new MongoId($user)), 
	                            array('$unset' => array("tobeactivated"=>""))
	                            );
	        /*Notification::saveNotification(array("type"=>NotificationType::NOTIFICATION_ACTIVATED,
	                      "user"=>$account["_id"]));*/
	    }
	    //TODO : add notification to the cities,region,departement info panel
	    //TODO : redirect to monPH page , inciter le rezotage local
	    $controller->redirect(Yii::app()->homeUrl);
    }
}