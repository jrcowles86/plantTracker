<?php

class Users extends Model {

    private $_isLoggedIn, $_sessionName, $_cookieName;
    public static $currentLoggedInUser = null;     /* Will be used to enforce a singleton pattern with model Users. */

    public function __construct($user = '') {
        $table = 'users';
        parent::__construct($table);   /* Call the constructor for parent Model, provide Model with $table name. */
        $this->_sessionName = CURRENT_USER_SESSION_NAME;
        $this->_cookieName = REMEMBER_ME_COOKIE_NAME;
        $this->_softDelete = true;     /* Helps to ensure that users are not ever permanently deleted from the database. */
        if ( !empty($user) && $user != '') {
            if (is_int($user)) {
                $match = $this->_database->findFirst('users', ['conditions' => 'user_id = ?', 'bind' => [$user]]);
            } else {
                $match = $this->_database->findFirst('users', ['conditions' => 'username', 'bind' => [$user]]);
            }
            if ($match) {
                foreach ($match as $key => $value) {
                    $this->$key = $value;
                }
            }
        }
    }

    public function findByUsername($username) {
        if (strstr($username, '@')) {
            /* If true, $username contains an email. Search against the email database column for a matching user. */
            return $this->findFirst(['conditions' => "email = ?", 'bind' => [$username]]);
        } else {
            /* If false, $username contains a simple username. Check for a match against username database column. */
            return $this->findFirst(['conditions' => "username = ?", 'bind' => [$username]]);
        }
        return false;
    }

    /* Method defined as static as the User object may not be instantiated by the time this method needs to be run. The 
       primary goal is to set and get the static User property $currentLoggedInUser. Method enforces singleton pattern by 
       first checking if the $currentLoggedInUser property is already populated. */
    public static function currentLoggedInUser() {
        if (!isset(self::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME)) {
            $user = new Users(is_int(Session::get(CURRENT_USER_SESSION_NAME)));
            self::$currentLoggedInUser = $user;
            }
            return self::$currentLoggedInUser;
        }

    /* The login() method's primary purpose is to create a session. */
    public function login($rememberMe = false) {
        Session::set($this->_sessionName, $this->user_id);    /* Note that $user_id is inherited as a public property from Model. */
        if ($rememberMe) {
            /* Note! Evidence exists online that uniqid() is not secure/truly random. Explore other options, including PHP 
               function openssl_random_pseudo_bytes() instead. */
            $hash = md5(uniqid());
            $user_agent = Session::userAgent();
            Cookie::set($this->_cookieName, $hash, REMEMBER_ME_COOKIE_EXPIRY);
            /* Set-up the $fields to be inserted into the new 'user_sessions' database row. */
            $params = ['session' => $hash, 'user_agent' => $user_agent, 'user_id' => $this->user_id];
            /* Query user_sessions table and delete any record that matches current user's ID or user_agent values. This is 
               to ensure users never have more than one session open at any given time. */
            $this->_database->query("DELETE FROM user_sessions WHERE user_id = ? AND user_agent = ?", [$this->user_id, $user_agent]);
            /* Once sure there are no existing sessions for this user, insert a new row in table 'user_sessions' per the 
               query() method defined in class Database. */
            $this->_database->insert('user_sessions', $params);
        }
    }

    /* Logs in a user automatically based on a cookie stored on user's browser. Generate a new UserSessions Model  */
    public static function loginUserFromCookie() {
        $userSession = UserSessions::getFromCookie();
        /* Check if we have a matching user_id. */
        if ($userSession->user_id != '') {
            $user = new self(is_int($userSession->user_id));
        }
        if ($user) {
            $user->login();
        }
        return $user;
    }

    public function logout() {
        $userSession - UserSessions::getFromCookie();
        if ($userSession) {
            $userSession->delete();
        }
        Session::delete(CURRENT_USER_SESSION_NAME);
        if (Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
            Cookie::delete(REMEMBER_ME_COOKIE_NAME);
        }
        /* On user logout, reset the $currentLoggedInUser static property to null. */
        self::$currentLoggedInUser = NULL;
        return true;
    }

    public function registerNewUser($params) {
        $this->assign($params);
        /* At this point, the password is plain text. We need to hash it before storing. */
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->save();
    }

}
