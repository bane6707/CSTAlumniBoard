<?php

require_once('../common/connection.php');
require_once('ModelInterface.php');
/**
 *
 */

class Thread implements ModelInterface
    {
        private $threadID;
        private $topic;
        private $isPinned;
        private $userID;
        private $forumID;

        public function __construct($topic, $userID, $forumID)
        {
            $this->topic = $topic;
            $this->isPinned = 0;
            $this->userID = $userID;
            $this->forumID = $forumID;
        }

        public function queryThread()
        {
            if(!$this->threadID)
            {
                return false;
            }
            global $connection;
            $sql = "SELECT *
                    FROM THREAD
                    WHERE threadID = ?
                    ";
            $stmt = $connection -> prepare($sql);
            $stmt->bindParam(1, $this->threadID, PDO::PARAM_INT);
            $stmt -> execute();
            return $stmt->fetch();
        }

        public function loadThreadByID($threadID)
        {
            global $connection;
            $sql = "SELECT *
                    FROM THREAD
                    WHERE threadID = ?
                    ";
            $stmt = $connection -> prepare($sql);
            $stmt->bindParam(1, $threadID, PDO::PARAM_INT);
            $stmt -> execute();
            $result = $stmt->fetch();
            if(!empty($result))
            {
                $this->threadID = $result['threadID'];
                $this->topic = $result['topic'];
                $this->isPinned = $result['isPinned'];
                $this->userID = $result['userID'];
                $this->forumID = $result['forumID'];
                return true;
            }
            return false;
        }

        public function createThread()
        {
            global $connection;
            $sqli = "INSERT INTO THREAD (topic, isPinned, userID, forumID) VALUES (?, 0, ?, ?)";
            $stmti = $connection->prepare($sqli);
            $stmti->bindParam(1, $this->topic, PDO::PARAM_STR);
            $stmti->bindParam(2, $this->userID, PDO::PARAM_INT);
            $stmti->bindParam(3, $this->forumID, PDO::PARAM_INT);
            if (!$stmti->execute()) {
                exit ("Error.  Unable to create thread." . $connection->error);
                return false;
            }

            $this->threadID = $connection->lastInsertId();
            $result = $this->queryThread();
            $this->topic = $result['topic'];
            $this->isPinned = $result['isPinned'];
            $this->userID = $result['userID'];
            $this->forumID = $result['forumID'];
            return true;
        }

        public function deleteThread()
        {
            if(!$this->threadID)
            {
                return false;
            }
            global $connection;
            $sqli = "DELETE FROM THREAD WHERE threadID = ?"; //Delete record
            $stmti = $connection->prepare($sqli);
            $stmti -> bindParam(1, $this->threadID, PDO::PARAM_INT);
            $stmti -> execute();
            $result = $this->queryThread();
            if (!empty($result))
            {
                exit ("Error.  Unable to DELETE record.  Check that record exists!" . $connection->error);
                return false;
            }
            return true;
        }

        public function pinThread()
        {
            if(!$this->threadID)
            {
                return false;
            }
            global $connection;
            $sqli = "UPDATE THREAD SET isPinned = 1 WHERE threadID = ? ";
            $stmti = $connection->prepare($sqli);
            $stmti->bind_param("i", $this->threadID);

            // Check if isPinned value was changed to 1
            $result = $this->queryThread();
            if(!empty($result))
            {
                if($result['isPinned'] === 1)
                {
                    $this->isPinned = 1;
                    return true;
                }
            }
            return false;
        }

        public function unpinThread()
        {
            if(!$this->threadID)
            {
                return false;
            }
            global $connection;
            $sqli = "UPDATE THREAD SET isPinned = 0 WHERE threadID = ? ";
            $stmti = $connection->prepare($sqli);
            $stmti->bind_param("i", $this->threadID);

            // Check if isPinned value was changed to 0
            $result = $this->queryThread();
            if(!empty($result))
            {
                if($result['isPinned'] === 0)
                {
                    $this->isPinned = 0;
                    return true;
                }
            }
            return false;
        }

        public function getThreadID()
        {
            return $threadID;
        }

        public function getTopic()
        {
            return $topic;
        }

        public function getTimeCreated()
        {
            return $timeCreated;
        }
        public function getIsPinned()
        {
            return $isPinned;
        }
        public function getUserID()
        {
            return $userID;
        }
        public function getForumID()
        {
            return $forumID;
        }
    }

?>
