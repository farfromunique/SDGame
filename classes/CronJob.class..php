<?php
echo '<!-- classes/CronJob.class..php loaded -->';
class CronJob {
	protected $progress = 'Status: ';
	
	/** @param mixed $connection  A PDO object with SELECT and DELETE access to table Conversations, INSERT access to table Conversations_bkup,
	 * and OPTIMIZE TABLE access to Conversations and Conversations_bkup.
	 * @return string Details progress made in the archiver */
	public function runDaily($connection) {
		$this->progress = '(Archive: ';
		$weekly = $connection->prepare("INSERT INTO Conversations_bkup SELECT * FROM Conversations WHERE Conversations.TDS < now()-86400");
        /** @noinspection PhpUndefinedMethodInspection */
        if ( ! $weekly->execute()) {
			$this->progress .= 'Failed).';
			return $this->progress;
		}
		$this->progress .= 'Done | Delete: ';
		
		$weekly = $connection->prepare("DELETE FROM Conversations WHERE Conversations.TDS < Now()-86400");
        /** @noinspection PhpUndefinedMethodInspection */
        if ( ! $weekly->execute()) {
			$this->progress .= 'Failed).';
			return $this->progress;
		}
		$this->progress .= 'Done | Optimize Conversations: ';
		
		$weekly = $connection->prepare("OPTIMIZE TABLE Conversations");
        /** @noinspection PhpUndefinedMethodInspection */
        if ( ! $weekly->execute()) {
			$this->progress .= 'Failed).';
			return $this->progress;
		}
		$this->progress .= 'Done | Optimize Conversations_bkup: ';
		
		$weekly = $connection->prepare("OPTIMIZE TABLE Conversations_bkup");
        /** @noinspection PhpUndefinedMethodInspection */
        if ( ! $weekly->execute()) {
			$this->progress .= 'Failed).';
			return $this->progress;
		}
		$this->progress .= 'Done) Weekly done with no errors.';
		return $this->progress;
	}
	
	/** @param mixed $connection  A PDO object with OPTIMIZE TABLE access to all tables.
	 * @return string Details progress made in the archiver */
	public function runWeekly($connection) {
        /** @noinspection PhpUnusedLocalVariableInspection */
        $optimizeBase = 'OPTIMIZE TABLE ';
		$tablesList = array();
		
		$tablesList[] = 'Character_Details';
		$tablesList[] = 'Conversations';
		$tablesList[] = 'Conversations_bkup';
		$tablesList[] = 'Locations';
		$tablesList[] = 'Logins';
		$tablesList[] = 'Powers';
		$tablesList[] = 'PowersLink';
		
		foreach ($tablesList as $table) {
			$optimizeBase = 'OPTIMIZE TABLE ' . $table;
			$optimize = $connection->prepare($optimizeBase);
            /** @noinspection PhpUndefinedMethodInspection */
            if ( ! $optimize->execute()) {
				$this->progress .= $table . ' failed';
				return $this->progress;
			}
			$this->progress .= $table . ' Done. ';
		}
		return $this->progress;
	}
}
?>