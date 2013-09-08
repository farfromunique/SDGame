<?php
    class DB {
        private $dbName;
        private $dbType;
        private $dbServer;
        public $User;
        public $Chat;
        public $Display;
        public $Guide;
        public $Maintenance;

        public function __construct() {
            $this->dbName = 'Characters';
            $this->dbType = 'mysql';
            $this->dbServer = 'sdgame.db';
        }

        public function CloseConnection($ConnName) {
            if (isset($$ConnName)) {
                unset($$ConnName);
            }
        }

        public function UserConnect() {
            $PDO_command = $this->dbType . ':host=' . $this->dbServer . ';dbname=' . $this->dbName;
            $this->User = new PDO($PDO_command,'UserStuff','77QFuuMbZLT6uC7T');
        }

        public function ChatConnect() {
            $PDO_command = $this->dbType . ':host=' . $this->dbServer . ';dbname=' . $this->dbName;
            $this->Chat = new PDO($PDO_command,'Chat','pSUPtTSdY6bQXWyD');
        }

        public function DisplayConnect() {
            $PDO_command = $this->dbType . ':host=' . $this->dbServer . ';dbname=' . $this->dbName;
            $this->Display = new PDO($PDO_command,'Display','qSYxRtSJHmWP32vz');
        }

        public function GuideConnect() {
            $PDO_command = $this->dbType . ':host=' . $this->dbServer . ';dbname=' . $this->dbName;
            $this->Guide = new PDO($PDO_command,'Guide','qSYxRtSJHmWP32vz');
        }

        public function MaintenanceConnect() {
            $PDO_command = $this->dbType . ':host=' . $this->dbServer . ';dbname=' . $this->dbName;
            $this->Maintenance = new PDO($PDO_command,'sdgame_maintain','XHjJDRwhVLSh6KQD');
        }
    }