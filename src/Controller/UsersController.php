<?php
namespace App\Controller;

use App\Controller\AppController;


/*class ReCaptchaResponse
{
    public $success;
    public $errorCodes;
}

class ReCaptcha
{
    private static $_signupUrl = "https://www.google.com/recaptcha/admin";
    private static $_siteVerifyUrl =
        "https://www.google.com/recaptcha/api/siteverify?";
    private $_secret;
    private static $_version = "php_1.0";

    function ReCaptcha($secret)
    {
        if ($secret == null || $secret == "") {
            die("To use reCAPTCHA you must get an API key from <a href='"
                . self::$_signupUrl . "'>" . self::$_signupUrl . "</a>");
        }
        $this->_secret=$secret;
    }
    private function _encodeQS($data)
    {
        $req = "";
        foreach ($data as $key => $value) {
            $req .= $key . '=' . urlencode(stripslashes($value)) . '&';
        }

        // Cut the last '&'
        $req=substr($req, 0, strlen($req)-1);
        return $req;
    }
    private function _submitHTTPGet($path, $data)
    {
        $req = $this->_encodeQS($data);
        $response = file_get_contents($path . $req);
        return $response;
    }
    public function verifyResponse($remoteIp, $response)
    {
        // Discard empty solution submissions
        if ($response == null || strlen($response) == 0) {
            $recaptchaResponse = new ReCaptchaResponse();
            $recaptchaResponse->success = false;
            $recaptchaResponse->errorCodes = 'missing-input';
            return $recaptchaResponse;
        }

        $getResponse = $this->_submitHttpGet(
            self::$_siteVerifyUrl,
            array (
                'secret' => $this->_secret,
                'remoteip' => $remoteIp,
                'v' => self::$_version,
                'response' => $response
            )
        );
        $answers = json_decode($getResponse, true);
        $recaptchaResponse = new ReCaptchaResponse();

        if (trim($answers['success']) == true) {
            $recaptchaResponse->success = true;
        } else {
            $recaptchaResponse->success = false;
            $recaptchaResponse->errorCodes = $answers['error-codes'];
        }

        return $recaptchaResponse;
    }
}*/




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
                //dd($_SERVER["REMOTE_ADDR"]);
                $data =  $this->request->getData();

                $secret  = "6LeI8AAVAAAAAFS4zMrAZGlBtfmrUbznTvFcqTdC";
                $reCaptcha = new ReCaptcha($secret);
                // Was there a reCAPTCHA response?
                if (!empty($data["g-recaptcha-response"])) {
                    /*$resp = $reCaptcha->verifyResponse(
                        $_SERVER["REMOTE_ADDR"],
                        $data["g-recaptcha-response"]
                    );
                    if ($resp != null && $resp->success) {
                        echo "Captcha Verified !";exit;
                    }*/
                    $user = $this->Auth->identify();
                    if ($user) {
                        $this->Auth->setUser($user);
                        return $this->redirect($this->Auth->redirectUrl());
                    }
                }else{
                    $this->Flash->error('Captcha is incorrect.');
                }
                $this->Flash->error('Your username or password is incorrect.');
            }
        }
    }

}


