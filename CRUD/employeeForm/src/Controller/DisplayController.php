<?php
 namespace Drupal\employeeForm\Controller;

 use Drupal\Core\Controller\ControllerBase;
 use Drupal\Core\Database\Database;
 use Drupal\Core\Url;


 class DisplayController extends ControllerBase{

 	public function display() {

 		$header_table = array(
     		'id'=> t('ID'),
      		'fname' => t('First Name'),
      		'lname' => t('Last Name'),
        	'mobilenumber' => t('MobileNumber'),
	        'email' => t('Email'),
	        'department' => t('Department'),
	        'gender' => t('Gender'),
	        'address' => t('Address'),
	        'opt' => t('Delete'),
	        'opt1' => t('Edit'),
    	);
 		$query = \Drupal::database()->select('employeedata', 'm');
	    $query->fields('m', ['id','first_name','last_name','mobilenumber','email','department','gender','address']);
	    $results = $query->execute()->fetchAll();
	    $rows=array();


	    foreach($results as $data){

        	$delete = Url::fromUserInput('/crud/delete/'.$data->id);
        	$edit   = Url::fromUserInput('/crud/data/edit?num='.$data->id);

        	 $rows[] = array(
            	'id' =>$data->id,
   	    		'fname' => $data->first_name,
	      		'lname' => $data->last_name,
	        	'mobilenumber' => $data->mobilenumber,
		        'email' => $data->email,
		        'department' => $data->department,
		        'gender' => $data->gender,
		        'address' => $data->address,

                 \Drupal::l('Delete', $delete),
                 \Drupal::l('Edit', $edit),
            );
 		}
 		$form['table'] = [
            '#type' => 'table',
            '#header' => $header_table,
            '#rows' => $rows,
            '#empty' => t('No employees found'),
        ];
	return $form;  
 }
}