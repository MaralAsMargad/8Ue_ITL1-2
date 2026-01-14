<?php

class MessageModel
{
    public static function sendMessage($sender_id, $receiver_id, $message_text)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO messages (sender_id, receiver_id, message_text)
                VALUES (:sender_id, :receiver_id, :message_text)";

        $query = $database->prepare($sql);
        $query->execute([
            ':sender_id' => $sender_id,
            ':receiver_id' => $receiver_id,
            ':message_text' => $message_text
        ]);
    }

    public static function getAllOtherUsersWithUnreadCount()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "
        SELECT 
            u.user_id,
            u.user_name,
            u.user_email,
            u.user_has_avatar,
            COUNT(m.message_text) AS unread_count
        FROM users u
        LEFT JOIN messages m 
            ON m.sender_id = u.user_id
            AND m.receiver_id = :my_id
            AND m.is_read = 0
        WHERE u.user_id != :my_id
        GROUP BY u.user_id
    ";

        $query = $database->prepare($sql);
        $query->execute([
            ':my_id' => Session::get('user_id')
        ]);

        $users = [];

        foreach ($query->fetchAll() as $user) {

            $user->user_avatar_link =
                (Config::get('USE_GRAVATAR')
                    ? AvatarModel::getGravatarLinkByEmail($user->user_email)
                    : AvatarModel::getPublicAvatarFilePathOfUser(
                        $user->user_has_avatar,
                        $user->user_id
                    )
                );

            $users[] = $user;
        }

        return $users;
    }

    public static function getChatMessages($my_id, $other_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "
        SELECT sender_id, receiver_id, message_text, created_at
        FROM messages
        WHERE 
            (sender_id = :me AND receiver_id = :other)
            OR
            (sender_id = :other AND receiver_id = :me)
        ORDER BY created_at ASC
    ";

        $query = $database->prepare($sql);
        $query->execute([
            ':me' => $my_id,
            ':other' => $other_id
        ]);

        return $query->fetchAll();
    }

    public static function markMessagesAsRead($sender_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "
        UPDATE messages 
        SET is_read = 1
        WHERE sender_id = :sender_id
          AND receiver_id = :my_id
    ";

        $query = $database->prepare($sql);
        $query->execute([
            ':sender_id' => $sender_id,
            ':my_id' => Session::get('user_id')
        ]);
    }


}
