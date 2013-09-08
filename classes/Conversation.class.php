<?php
require_once('Parser.class.php');
class Conversation {
    protected $lastMessage; // UID of last message displayed
    protected $location; // UID of location
    protected $allChat = array(); // Contents of query for last up to 10 messages, ending at $lastMessage

    public function __toString() {
    	global $you;
    	$tz = 'UTC';
    	if (isset($you->timezone)) {
    		$tz = $you->timezone;
    	}
        return $this->output($tz);
    }

    public function output() {
        global $parser;
        global $you;

        $gm_stuff = "";
        if ($_SESSION["IsGM"]) {
            $gm_stuff = "<input type='submit' class='GM_Button' value='Delete' onClick='removeRecord(::UID::)'>";
        }

        $discussion = '';
        for ($i=0;$i<count($this->allChat);$i++) {
        	$uid = $this->allChat[$i]["UID"];
            $beginning = "<div class='comment' id=" . $uid . ">";
            $attribution = "<span class='attribution'><a href='show.php?id=" . $this->allChat[$i]["CharUID"] . "'>" .
                $this->allChat[$i]["Name"] . "</a> wrote, at ";
            $tds = ':-:UTC:-:' . $this->allChat[$i]["TDS"] . ':-:';
            $tds = $parser->fixUTC($tds,$you->TimeZoneOffset,'g:i A') . ':</span><br /> ';
            $ending = "</div>";
            $discussion = $discussion . $gm_stuff . $beginning . $attribution . $tds . $this->allChat[$i]["Comment"]
                . $ending;
        }
        return $discussion;
    }

    public function Send($chatVar,$character,$message) {
        /** @noinspection PhpUndefinedMethodInspection */
        $chatVar->bindParam(":charUID",$character);
        /** @noinspection PhpUndefinedMethodInspection */
        $chatVar->bindParam(":message",$message);
        /** @noinspection PhpUndefinedMethodInspection */
        $chatVar->execute();
    }

    public function getAllNewChats() {
        global $conversation;
        /** @noinspection PhpUndefinedMethodInspection */
        if ($conversation->execute()) {
            /** @noinspection PhpUndefinedMethodInspection */
            $this->allChat = $conversation->fetchAll(PDO::FETCH_ASSOC);
            $this->lastMessage = $this->allChat[0]["UID"];
        }
    }

    public function getChatLog() {
        global $conversation;
        global $messageCount;

        $defaultMessage = 'Nobody seems to have said anything for a while...';
        /** @noinspection PhpUndefinedMethodInspection */
        $messageCount->bindParam(":loc",$this->location);
        /** @noinspection PhpUndefinedMethodInspection */
        $messageCount->execute();
        /** @noinspection PhpUndefinedMethodInspection */
        $newest = $messageCount->fetch(PDO::FETCH_ASSOC);
        if ($newest === false) {
            $this->allChat = $defaultMessage;
            return $this->allChat;
        }
        if ($newest == $this->lastMessage) {
            $this->allChat = 'No change';
            return $this->allChat;
        }
        $this->lastMessage = $newest['MAX(UID)'];
        $this->getAllNewChats($conversation);
        return $this->allChat;
    }

    public function __construct($converseVar,$locationUID) {
        $this->location = $locationUID;
        $this->lastMessage = 0;
        $displayChat = $this->GetChatLog();
        switch ($displayChat) {
            case 'Nobody seems to have said anything for a while...':
                return $displayChat;
                break;

            default:
                $this->getAllNewChats($converseVar);
                global $you;
		    	$tz = 'UTC';
		    	if (isset($you->timezone)) {
		    		$tz = $you->timezone;
		    	}
		        return $this->output($tz);
                break;
        }
    }
}