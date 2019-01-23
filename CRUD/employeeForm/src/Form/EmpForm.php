<?php
 
 namespace Drupal\employeeForm\Form;
 use Drupal\Core\Form\FormBase;
 use Drupal\Core\Form\FormStateInterface;
 use Drupal\Core\Database\Database;

 /**
	Simple Form Class
 */
 class EmpForm extends FormBase {
 	/**
   * {@inheritdoc}
   */
 	public function getFormId() {
 		return 'EmpForm';
 	}
 	/**
   * {@inheritdoc}
   */
 	public function buildForm(array $form, FormStateInterface $form_state) {

 		$form['first_name'] = [
 			'#type' => 'textfield',
      		'#title' => $this->t('First Name'),
      		'#required' => TRUE,
 		];

 		$form['last_name'] = [
 			'#type' => 'textfield',
      		'#title' => $this->t('Last Name'),
      		'#required' => TRUE,
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
		  '#default_value' => 2,
		  '#required' => TRUE,
 		];

 		$form['contact'] = [
 			'#type' => 'textfield',
 			'#title' => $this
        		->t('Contact Number'),
        	'#required' => TRUE,
 		];

 		$form['email'] = array(
		  '#type' => 'email',
		  '#title' => $this->t('Email'),
		  '#required' => TRUE,
		);

		$form['address'] = array(
		  '#type' => 'textarea',
		  '#title' => $this
		    ->t('Address'),
		);

		$form['gender'] = array(
		  '#type' => 'radios',
		  '#title' => $this
		    ->t('Gender'),
		  '#default_value' => 'FEMALE',
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

 		$form['register'] = [
	      '#type' => 'submit',
	      '#value' => 'REGISTER',
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
  	$register = $fields['register'];
  	
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
	   $result = $connection->insert('employeedata')
		  ->fields([
		    'first_name' => $fname,
		    'last_name' => $lname,
		    'mobilenumber' => $num,
		    'email' => $email,
		    'department' => $dept,
		    'gender' => $gender,
		    'address' => $address,
		  ])
		  ->execute();
		drupal_set_message("Inserted DATA");
		$form_state->setRedirect('employeeForm.display_controller');

	}

}