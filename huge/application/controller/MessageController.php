<?php

class MessageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::checkAuthentication();
    }

    public function index()
    {
        $this->View->render('message/index', [
            'users' => MessageModel::getAllOtherUsersWithUnreadCount()
        ]);
    }

    public function chat($user_id)
    {
        $this->View->render('message/chat', [
            'users' => MessageModel::getAllOtherUsersWithUnreadCount(),
            'chatUser' => UserModel::getPublicProfileById($user_id),
            'markMsgAsRead' => MessageModel::markMessagesAsRead($user_id),
            'messages' => MessageModel::getChatMessages(
                Session::get('user_id'),
                $user_id
            )
        ]);
    }

    // Test: Nachricht per URL senden
    public function send()
    {
        MessageModel::sendMessage(
            Session::get('user_id'),
            Request::post('receiver_id'),
            Request::post('message_text')
        );

        Redirect::to('message/chat/' . Request::post('receiver_id'));
    }

}
