<?php
// include_once($_SERVER['DOCUMENT_ROOT'] . '/proj/database/DB.php');
require_once "../database/DB.php";


//TODO remove table prof_to_etd, remove table etd_to_prof  and replace with table chat_logs or chat 
class Chat
{
    public static function getMsgs($secondParty, $firstParty)
    {
        $db = DB::connect();
        $sql = "SELECT * FROM chat_logs WHERE
        (recipient_id = :first AND sender_id = :second)
        OR (recipient_id = :second AND sender_id = :first) 
        OR recipient_id = -1
        ORDER BY time_stamp DESC";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':first', $firstParty, PDO::PARAM_INT);
        $stmt->bindParam(':second', $secondParty, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function SendMessage($sender_id, $recipient_id, $message)
    {
        $db = DB::connect();

        // Prepare the SQL statement
        $sql = "INSERT INTO chat_logs (sender_id, recipient_id, msg, time_stamp) 
                VALUES (:sender_id, :recipient_id, :message, NOW())"; // Assuming time_stamp is the timestamp column

        $stmt = $db->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':sender_id', $sender_id, PDO::PARAM_INT);
        $stmt->bindParam(':recipient_id', $recipient_id, PDO::PARAM_INT);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);

        // Execute the statement
        $stmt->execute();

        // Check if the execution was successful
        if ($stmt->rowCount() > 0) {
            return true; // Message sent successfully
        } else {
            return false; // Failed to send message
        }
    }
}
