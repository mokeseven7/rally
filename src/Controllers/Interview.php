<?php 

namespace Shop\Site\Controllers;

use Dsc\Controller as BaseController;

class Interview extends BaseController {
	
	public function model($lastname = null){
		if($lastname){
			return new \Humans\Candidates\Male; 
		}
	}
	
	
	public function interview(){
		//--MM: Simple, clever. 
        $this->registerName(__METHOD__);
		
		//Retrieve input params from some kind of global request object
		$lastname = $this->inputfilter->clean($this->app->get('PARAMS.lastname'), 'string');

		//Search the database for the person via lastname
		$currentCandidate = $model->getPersonByLastName();
		
		//If we cant find a user with that lastname, throw
		if (empty($currentCandidate)) {
            return $this->app->error('404', 'Candidate Not Found');
        }

		$this->app->set('meta.description', 'Hi!'. $currentCandidate->fullname . ' Please follow the instructions in the readme:');
        $this->app->set('meta.title', 'Thanks For Your Interest ' . $currentCandidate->firstname . $currentCandidate->lastname);


		//Pass Data to the view:
		$this->app->set('activeUser', $currentCandidate);

		//Get theme. 
		$view = \Dsc\System::instance()->get('theme');

        //--MM: return view
        echo $view->render('Humans/Candidates/Views::interview/index.php');
	}
}
