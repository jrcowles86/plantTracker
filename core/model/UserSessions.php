<?php

namespace Core\Data\Model;

class UserSessions extends Model {

    public function __construct() {
        $table = 'user_sessions';
        parent::__construct($table);
    }

    /* Logic in method originally pulled from Users model. If user comes to our website with a matching cookie hash, use the 
       findFirst() method from Model to return an object with that user's data from table user_sessions. */
    public static function getFromCookie() {
        $userSession = new self();
        if (Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
            $userSession = $userSession->findFirst([
                'conditions' => "user_agent = ? AND session = ?",
                'bind' => [Session::userAgent(), Cookie::get(REMEMBER_ME_COOKIE_NAME)]
            ]);
        }
        if (!$userSession) {
            return false;
        }
        return $userSession;
    }

}
