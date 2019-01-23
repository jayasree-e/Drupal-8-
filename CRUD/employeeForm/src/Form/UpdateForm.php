<?php
 
 namespace Drupal\employeeForm\Form;
 use Drupal\Core\Form\FormBase;
 use Drupal\Core\Form\FormStateInterface;
 /**
	Simple Form Class
 */
 class UpdateForm extends FormBase {
 	/**
   * {@inheritdoc}
   */
 	public function getFormId() {
 		return 'update_form';
 	}
 	/**
   * {@inheritdoc}
   */
 	public function buildForm(array $form, FormStateInterface $form_state) {
 		$num=$_GET['num'];
 		$connection = \Drupal::database();
 		$query = $connection->select('employeedata', 'e')
		  ->condition('e.id',$num, '=')
		  ->fields('e', ['id', 'first_name','last_name','mobilenumber','email', 'department', 'gender', 'address']);
		$result = $query->execute()->fetchObject();
		
 		$form['first_name'] = [
 			'#type' => 'textfield',
      		'#title' => $this->t('First Name'),
      		'#required' => TRUE,
      		'#default_value' => $result->first_name,
 		];

 		$form['last_name'] = [
 			'#type' => 'textfield',
      		'#title' => $this->t('Last Name'),
      		'#required' => TRUE,
      		'#default_value' => $result->last_name,
 		];

 		$form['department'] = [
 			'#type' => 'select',
      		'#title' => $this->t('Department'),
      		'#options' => [
		    'MANAGEMENT' => $this
		      ->t('Management'),
		    'SOFTWARE DEVELOPMENT' => $this
		      ->t('Software Development'),
		    'SOFTWARE TESTING' => $this
		      ->t('Software Testing'),
		  ],
		  '#default_value' => $result->department,
		  '#required' => TRUE,
 		];

 		$form['contact'] = [
 			'#type' => 'textfield',
 			'#title' => $this
        		->t('Contact Number'),
        	'#required' => TRUE,
        	'#default_value' => $result->mobilenumber,
 		];

 		$form['email'] = array(
		  '#type' => 'email',
		  '#title' => $this->t('Email'),
		  '#required' => TRUE,
		  '#default_value' => $result->email,
		);

		$form['address'] = array(
		  '#type' => 'textarea',
		  '#title' => $this
		    ->t('Address'),
		   '#default_value' => $result->address,
		);

		$form['gender'] = array(
		  '#type' => 'radios',
		  '#title' => $this
		    ->t('Gender'),
		  '#default_value' => $result->gender,
		  '#options' => array(
		    'FEMALE' => $this
		      ->t('Female'),
		    'MALE' => $this
		      ->t('Male'),
		    'OTHER' => $this
		      ->t('Other'),
		  ),
		  '#required' => TRUE,
		);

 		$form['update'] = [
	      '#type' => 'submit',
	      '#value' => $this->t('UPDATE'),
	    ];
	   
	    
	    return $form;

 	}
 	/**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  	$fields = $form_state->getValues();
  	$fname = $fields['first_name'];
  	$lname = $fields['last_name'];
  	$dept = $fields['department'];
  	$num = $fields['contact'];
  	$email = $fields['email'];
  	$address = $fields['address'];
  	$gender = $fields['gender'];
  	//$update = $fields['update'];
  	
	   /*drupal_set_message($fname);
	   drupal_set_message((string)$lname);
	   drupal_set_message((string)$dept);
	   drupal_set_message($num);
	   drupal_set_message((string)$email);
	   drupal_set_message((string)$address);
	   drupal_set_message((string)$gender);
	   drupal_set_message((string)$register);
	   drupal_set_message((string)$update);*/

	   $connection = \Drupal::database();
	   $result = $connection->update('employeedata')
		  ->fields([
		    'first_name' => $fname,
		    'last_name' => $lname,
		    'mobilenumber' => $num,
		    'email' => $email,
		    'department' => $dept,
		    'gender' => $gender,
		    'address' => $address,
		  ])
		   ->condition('id',$_GET['num'] , '=')
		  ->execute();
		drupal_set_message("Updated DATA");
		$form_state->setRedirect('employeeForm.display_controller');

	}

}