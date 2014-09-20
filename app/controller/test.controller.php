<?php

/**
 *  Test controller.
 */
class TestController extends BaseController {

    public function index() {
        
    }
    
    public function user() {
        $this->registry->template->testCase = 'UserDAO->getUser()';
        $userDao = new UserDAO();
        try {
            $user = $userDao->getUser("admin", "d033e22ae348aeb5660fc2140aec35850c4da997");
            $this->registry->template->testResult = json_encode($user);
        } catch (Exception $e) {
            $this->registry->template->testResult = $e->getMessage();
        }
        $this->registry->template->show('test');
    }
    
    public function userdetail() {
        $this->registry->template->testCase = 'UserDAO->getUserDetail()';
        $userDao = new UserDAO();
        try {
            $user = $userDao->getUserDetail("admin", "d033e22ae348aeb5660fc2140aec35850c4da997");
            $this->registry->template->testResult = json_encode($user);
        } catch (Exception $e) {
            $this->registry->template->testResult = $e->getMessage();
        }
        $this->registry->template->show('test');
    }
    
    public function updateuser() {
        $this->registry->template->testCase = 'UserDAO->updateUser()';
        $user = new User("admin", "d033e22ae348aeb5660fc2140aec35850c4da997");
        $user->setEmail("ithinkisam@gmail.com");
        $user->setDisplayName("Sam");
        $user->setWelcomePage("Test");
        $user->setShareKey("admin");
    
        $userDao = new UserDAO();
        try {
            $result = $userDao->updateUser($user);
            $this->registry->template->testResult = $result;
        } catch (Exception $e) {
            $this->registry->template->testResult = $e->getMessage();
        }
        $this->registry->template->show('test');
    }
    
    public function adduser() {
        $this->registry->template->testCase = 'Add User';
        try {
            $username = $this->registry->request->getParam("username");
            if (empty($username)) {
                throw new Exception("Missing 'username' parameter");
            }
            $user = new User($username, $username);
            $user->setEmail($username . "@gmail.com");
            $user->setDisplayName($username);
            $user->setWelcomePage("Home");
            $user->setShareKey($username);
            
            $userDao = new UserDAO();
            $result = $userDao->addUser($user);
            $this->registry->template->testResult = "Result: " . $result;
        } catch (Exception $e) {
            $this->registry->template->testResult = $e->getMessage();
        }
        $this->registry->template->show('test');
    }
    
    public function deleteuser() {
        $this->registry->template->testCase = 'Delete User';
        try {
            $username = $this->registry->request->getParam("username");
            if (empty($username)) {
                throw new Exception("Missing 'username' parameter");
            }
            $user = new User($username, $username);
            
            $userDao = new UserDAO();
            $result = $userDao->deleteUser($user);
            $this->registry->template->testResult = "Result: " . $result;
        } catch (Exception $e) {
            $this->registry->template->testResult = $e->getMessage();
        }
        $this->registry->template->show('test');
    }
    
    public function message() {
        $this->registry->template->testCase = 'Test Case';
        try {
            $messageId = $this->registry->request->getParam("messageId");
            if (empty($messageId)) {
                throw new Exception("Missing 'messageId' parameter");
            }
            
            $messageDao = new MessageDAO();
            $result = $messageDao->getMessage($messageId);
            $this->registry->template->testResult = "Message: " . $result;
        } catch (Exception $e) {
            $this->registry->template->testResult = $e->getMessage();
        }
        $this->registry->template->show('test');
    }
    
    public function test() {
        $this->registry->template->testCase = 'Test Case';
        try {
            // TODO
            $this->registry->template->testResult = "No test performed.";
        } catch (Exception $e) {
            $this->registry->template->testResult = $e->getMessage();
        }
        $this->registry->template->show('test');
    }

}
