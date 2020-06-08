<?php
namespace App\Controller;

use App\Controller\AppController;

include_once "Captcha/ReCaptcha.php";
use ReCaptchaResponse;
use ReCaptcha;
use Cake\Validation\Validator;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->deny();
        $this->Auth->allow(['logout','add']);
    }

    public function logout()
    {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $users = $this->paginate($this->Users);
        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Articles'],
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $filename = null;
            $formData = $this->request->getData();
            if (
                !empty($formData['user_image']['tmp_name'])
                && is_uploaded_file($formData['user_image']['tmp_name'])
            ) {
                // Strip path information
                $filename = basename($formData['user_image']['name']); 
                move_uploaded_file(
                    $formData['user_image']['tmp_name'],
                    WWW_ROOT . 'documents' . DS . $filename
                );
            }
            $userData = array();
            $userData['email'] = $formData['email'];
            $userData['password'] = $formData['password'];
            if($filename){
                $userData['user_image'] = $filename;
            }
            $user = $this->Users->patchEntity($user, $userData);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $filename = null;
            $formData = $this->request->getData();
            if (
                !empty($formData['user_image']['tmp_name'])
                && is_uploaded_file($formData['user_image']['tmp_name'])
            ) {
                // Strip path information
                $filename = basename($formData['user_image']['name']); 
                move_uploaded_file(
                    $formData['user_image']['tmp_name'],
                    WWW_ROOT . 'documents' . DS . $filename
                );
            }
            $userData = array();
            $userData['email'] = $formData['email'];
            if($formData['password']){
                $userData['password'] = $formData['password'];
            }
            if($filename){
                $userData['user_image'] = $filename;
            }

            $user = $this->Users->patchEntity($user, $userData);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        $user = $this->Auth->user();
        if(!empty($user)){
            $this->redirect(array("controller" => "Articles", "action" => "index"));
        }else{
            if ($this->request->is('post')) {
                $validator = new Validator();
                $validator->notEmpty('email', 'We need email.')
                ->notEmpty('g-recaptcha-response', 'Select if you not a robot.')
                ->add('email', 'validFormat', ['rule' => 'email','message' => 'E-mail must be valid']);

                $validator->notEmpty('password', 'We need password.');
                $errors = $validator->errors($this->request->data());
                if($errors){
                    $response = [
                        'success' => false,
                        'invalid' => true,
                        'errors' => $errors,
                    ];
                    return $this->response->withType("application/json")->withStringBody(json_encode($response));
                }


                $data =  $this->request->getData();

                $secret  = "6LeI8AAVAAAAAFS4zMrAZGlBtfmrUbznTvFcqTdC";
                $reCaptcha = new ReCaptcha($secret);
                // Was there a reCAPTCHA response?
                if (!empty($data["g-recaptcha-response"])) {
                    $resp = $reCaptcha->verifyResponse(
                        $_SERVER["REMOTE_ADDR"],
                        $data["g-recaptcha-response"]
                    );
                    if ($resp != null && $resp->success) {
                        $user = $this->Auth->identify();
                        if ($user) {
                            $this->Auth->setUser($user);
                            $response = [
                                'success' => true,
                                'invalid' => false,
                                'return_url' => $this->Auth->redirectUrl(),
                            ];
                            //return $this->redirect($this->Auth->redirectUrl());
                        }else{
                            $response = [
                                'success' => false,
                                'invalid' => false,
                                'error' => 'Your username or password is incorrect.',
                            ];
                        }
                        return $this->response->withType("application/json")->withStringBody(json_encode($response));
                    }else{
                        $this->Flash->error('Wrong Captcha Settings.');    
                    }
                }else{
                    $this->Flash->error('Captcha is incorrect.');
                }
                $this->Flash->error('Your username or password is incorrect.');
            }
        }
    }

}


