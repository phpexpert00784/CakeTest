<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9a
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Rest\Controller\RestController;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3/en/controllers/pages-controller.html
 */
class ContactsController extends RestController
{
    /**
     * Displays a view
     *
     * @param array ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found
     * @throws \Cake\View\Exception\MissingTemplateException In debug mode.
     */
    public function index()
    {
    	$this->request->allowMethod('get');
    	$contacts = $this->Contacts->find('all', array(
    		'fields' => array('Contacts.id','Contacts.first_name','Contacts.last_name','Contacts.phone_number'),
   		));
       	
       	$this->set(compact('contacts'));
    }


    public function indexExt()
    {
    	$this->request->allowMethod('get');
    	$contacts = $this->Contacts->find('all', array(
    		'contain' => array('Companies'),
    		'fields' => array('Contacts.id','Contacts.first_name','Contacts.last_name','Contacts.phone_number', 'Companies.id','Companies.company_name','Companies.address'),
   
		));

		$this->set(compact('contacts'));
    }

    public function create()
    {
    	$this->request->allowMethod(['post', 'put']);
       // $contacts = $this->Contacts->newEntity($this->request->getData());
            $contacts = $this->Contacts->newEntity();
            $contacts  = $this->Contacts->patchEntity($contacts , $this->request->getData());
        if ($contacts = $this->Contacts->save($contacts)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }

        $array['message'] = $message;
        $array['contacts'] = $contacts;
		$this->set(compact('array'));
    	
    }


    
}
