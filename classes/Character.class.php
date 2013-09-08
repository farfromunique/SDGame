<?php

class Character {
    /** @var  int the UID of this character. Corresponds to User->Character */
    public $UID;
    /** @var string The Character's name  */
    protected $Name;
    /** @var  int Character's Age in years */
    protected $Age;
    /** @var  string Character's Gender: M, F, or Other */
    protected $Gender;
    /** @var  int Character's rank (game term) */
    protected $Rank;
    /** @var  int Character's height in CM */
    protected $Height;
    /** @var  string Descriptor of height in relative terms (Very Short, short, average, tall, very tall) */
    protected $Height_Category;
    /** @var  string description of the character's skin */
    protected $Skin;
    /** @var  string description of the character's eyes */
    protected $Eyes;
    /** @var  string description of the character's hair */
    protected $Hair;
    /** @var  string description of any distinguishing marks the character may have (may be blank) */
    protected $Distinguishing_Marks;
    /** @var  int character's current XP */
    protected $XP;
    /** @var  string array of character's powers */
    protected $Powers;
    /** @var  string array of pronouns to use based on character's gender */
    protected $Pronouns;
    public $LastGood;

    /** @param string $name The name the user wishes to check availability of
     * @return bool true = name is free or error; false = name is taken */
    public function nameAvailable($name) {
        global $con;
        $check = $con->prepare("SELECT COUNT(*) FROM Character_Details WHERE Name = :name");
        $check->bindParam(':name',$name);
        if ( ! $check->execute() || $check->fetchColumn() == 0 ) {
            return true; // returning true if 0 results are returned, or there is an error
        }
        return false; // returning false if more than 0 results
    }

    /** Sets the list of pronouns to use for the character */
    public function setPronouns() {
        switch ($this->Gender) {
            case "M":
                $this->Pronouns=array("Male","guy","dude","He","His");
                break;
            case "F":
                $this->Pronouns=array("Female","gal","chick","She","Her");
                break;
            case "Other":
                $this->Pronouns=array("Individual","person","person",$this->Name,"Their");
                break;
        }
        return;
    }

    /** Sets the height category for the character, based on average heights by age and gender. */
    public function setHeightCategory() {
        $heightCat = array();
        $heightCat[0] = 'very short';
        $heightCat[1] = 'short';
        $heightCat[2] = 'average';
        $heightCat[3] = 'tall';
        $heightCat[4] = 'very tall';

        $heightCutoff = array();
        $heightCutoff['M'][0][0] = 146;
        $heightCutoff['M'][0][1] = 153;
        $heightCutoff['M'][0][2] = 158;
        $heightCutoff['M'][0][3] = 163;
        $heightCutoff['M'][0][4] = 171;

        $heightCutoff['M'][1][0] = 150;
        $heightCutoff['M'][1][1] = 158;
        $heightCutoff['M'][1][2] = 163;
        $heightCutoff['M'][1][3] = 169;
        $heightCutoff['M'][1][4] = 176;

        $heightCutoff['M'][2][0] = 155;
        $heightCutoff['M'][2][1] = 163;
        $heightCutoff['M'][2][2] = 168;
        $heightCutoff['M'][2][3] = 173;
        $heightCutoff['M'][2][4] = 180;

        $heightCutoff['M'][3][0] = 159;
        $heightCutoff['M'][3][1] = 167;
        $heightCutoff['M'][3][2] = 171;
        $heightCutoff['M'][3][3] = 177;
        $heightCutoff['M'][3][4] = 183;

        $heightCutoff['M'][4][0] = 162;
        $heightCutoff['M'][4][1] = 168;
        $heightCutoff['M'][4][2] = 173;
        $heightCutoff['M'][4][3] = 178;
        $heightCutoff['M'][4][4] = 185;

        $heightCutoff['M'][5][0] = 163;
        $heightCutoff['M'][5][1] = 169;
        $heightCutoff['M'][5][2] = 173;
        $heightCutoff['M'][5][3] = 179;
        $heightCutoff['M'][5][4] = 185;


        $heightCutoff['F'][0][0] = 145;
        $heightCutoff['F'][0][1] = 151;
        $heightCutoff['F'][0][2] = 156;
        $heightCutoff['F'][0][3] = 162;
        $heightCutoff['F'][0][4] = 167;

        $heightCutoff['F'][1][0] = 148;
        $heightCutoff['F'][1][1] = 154;
        $heightCutoff['F'][1][2] = 159;
        $heightCutoff['F'][1][3] = 164;
        $heightCutoff['F'][1][4] = 170;

        $heightCutoff['F'][2][0] = 150;
        $heightCutoff['F'][2][1] = 156;
        $heightCutoff['F'][2][2] = 161;
        $heightCutoff['F'][2][3] = 166;
        $heightCutoff['F'][2][4] = 171;

        $heightCutoff['F'][3][0] = 151;
        $heightCutoff['F'][3][1] = 157;
        $heightCutoff['F'][3][2] = 162;
        $heightCutoff['F'][3][3] = 166;
        $heightCutoff['F'][3][4] = 172;

        $heightCutoff['F'][4][0] = 152;
        $heightCutoff['F'][4][1] = 157;
        $heightCutoff['F'][4][2] = 162;
        $heightCutoff['F'][4][3] = 166;
        $heightCutoff['F'][4][4] = 172;

        $heightCutoff['F'][5][0] = 152;
        $heightCutoff['F'][5][1] = 158;
        $heightCutoff['F'][5][2] = 162;
        $heightCutoff['F'][5][3] = 166;
        $heightCutoff['F'][5][4] = 172;


        $heightCutoff['Other'][0][0] = 145;
        $heightCutoff['Other'][0][1] = 152;
        $heightCutoff['Other'][0][2] = 157;
        $heightCutoff['Other'][0][3] = 163;
        $heightCutoff['Other'][0][4] = 169;

        $heightCutoff['Other'][1][0] = 149;
        $heightCutoff['Other'][1][1] = 156;
        $heightCutoff['Other'][1][2] = 161;
        $heightCutoff['Other'][1][3] = 166;
        $heightCutoff['Other'][1][4] = 173;

        $heightCutoff['Other'][2][0] = 153;
        $heightCutoff['Other'][2][1] = 159;
        $heightCutoff['Other'][2][2] = 164;
        $heightCutoff['Other'][2][3] = 169;
        $heightCutoff['Other'][2][4] = 176;

        $heightCutoff['Other'][3][0] = 155;
        $heightCutoff['Other'][3][1] = 162;
        $heightCutoff['Other'][3][2] = 166;
        $heightCutoff['Other'][3][3] = 171;
        $heightCutoff['Other'][3][4] = 177;

        $heightCutoff['Other'][4][0] = 157;
        $heightCutoff['Other'][4][1] = 163;
        $heightCutoff['Other'][4][2] = 167;
        $heightCutoff['Other'][4][3] = 172;
        $heightCutoff['Other'][4][4] = 178;

        $heightCutoff['Other'][5][0] = 157;
        $heightCutoff['Other'][5][1] = 163;
        $heightCutoff['Other'][5][2] = 167;
        $heightCutoff['Other'][5][3] = 172;
        $heightCutoff['Other'][5][4] = 178;

        $age = $this->Age - 13;
        $height = $this->Height;

        for ($i=0;$i<4;$i++) {
            if ($height <= $heightCutoff[$this->Gender][$age][$i]) {
                $this->Height_Category = $heightCat[$i];
                return;
            }
        }
        $this->Height_Category = $heightCat[4];
        return;
    }

    /** @param int $UID The UID of the character data to load.  */
    public function load($UID) {
        global $pw;
        $this->UID = $UID;
        /** @noinspection PhpUndefinedMethodInspection */
        $details = $pw->prepare("SELECT * FROM Character_Details WHERE UID = :uid");
        /** @noinspection PhpUndefinedMethodInspection */
        $details->bindParam(':uid', $UID);
        /** @noinspection PhpUndefinedMethodInspection */
        $details->execute();
        /** @noinspection PhpUndefinedMethodInspection */
        $myDetails = $details->fetch();
        $this->Name = $myDetails['Name'];
        $this->Age = $myDetails['Age'];
        $this->Gender = $myDetails['Gender'];
        $this->Rank = $myDetails['Rank'];
        $this->Height = $myDetails['Height'];
        $this->Skin = $myDetails['Skin'];
        $this->Eyes = $myDetails['Eyes'];
        $this->Hair = $myDetails['Hair'];
        $this->Distinguishing_Marks = $myDetails['Distinguishing_Marks'];
        $this->XP = $myDetails['XP'];
        $this->setPronouns();
        // debugging
        $this->LastGood = 'Load Variables';
        if ($this->Height_Category == "") {
            $this->setHeightCategory();
        }
    }

    /** @return string An HTML chunk describing the relevant character. */
    public function DescribeMe() {
        $output = "<h2>Character Description for: {$this->Name}</h2>
        <h3>{$this->Age} year-old {$this->Pronouns[0]} of Rank {$this->Rank}</h3>
		<p>{$this->Name} is a {$this->Height_Category} {$this->Pronouns[1]},
			with {$this->Hair} hair and eyes of {$this->Eyes}.
			{$this->Pronouns[4]} skin is {$this->Skin}";
        if($this->Distinguishing_Marks) {
            $output .= " and " . lcfirst($this->Pronouns[3]) . " has " . lcfirst($this->Distinguishing_Marks) . ".";
        } else {
            $output .= ".";
        }
        return $output;
    }

    public function makeMe($name,$age,$gender,$height,$skin,$eyes,$hair,$distinguishingMarks) {
        $this->Name = $name;
        $this->Age = $age;
        $this->Gender = $gender;
        $this->Height = $height;
        $this->Skin = $skin;
        $this->Eyes = $eyes;
        $this->Hair = $hair;
        $this->Distinguishing_Marks = $distinguishingMarks;
        // debugging
        $this->LastGood = 'object variables set (makeMe)';
        if ( ! isset($this->UID)) {
            if ($this->CreateInDB() > 0) {
                // debugging
                $this->LastGood = 'CreateInDB succeeded (makeMe)';
                if ($this->UpdateInDB()) {
                    // debugging
                    $this->LastGood = 'UpdateInDB succeeded (makeMe:UID not Set)';
                    return $this->DescribeMe();
                }
            }
        }
        if ($this->UpdateInDB()) {
            // debugging
            $this->LastGood = 'UpdateInDB succeeded (makeMe: UID Set)';
            return $this->DescribeMe();
        }
        return false;
    }

    public function CreateInDB() {
        global $ud;
        $insertSQL = $ud->prepare("INSERT INTO Character_Details (`Name`,`XP_Current`,`XP_Total`) VALUES (:name,1,1)");
        $insertSQL->bindParam(":name",$this->Name);
        if ($insertSQL->execute()) {
            // debugging
            $this->LastGood = 'InsertSQL succeeded (CreateInDB)';
            $findMe = $ud->prepare("SELECT `UID` FROM `Character_Details` WHERE `Name` = :me");
            $findMe->bindParam(":me",$this->Name);
            $findMe->execute();
            // debugging
            $this->LastGood = 'findMe succeeded (CreateInDB)';
            $found = $findMe->fetch(PDO::FETCH_ASSOC);
            $this->UID = $found['UID'];
            return $this->UID;
        }
        // debugging
        $this->LastGood = 'InsertSQL failed (CreateInDB)';
        return 0;
    }

    public function UpdateInDB() {
        global $pw;
        global $ud;
        global $you;
        $update = $ud->prepare("UPDATE Character_Details SET Age = :age, Gender = :gender," .
            "Height = :height, Skin = :skin, Eyes = :eyes, Hair = :hair, Distinguishing_Marks = :marks," .
            " Height_Category = :hc" .
            " WHERE UID = :uid");
        $update->bindParam(":age",$this->Age);
        $update->bindParam(":gender",$this->Gender);
        $update->bindParam(":height",$this->Height);
        $this->setHeightCategory();
        // debugging
        $this->LastGood = 'setHeightCategory succeeded (UpdateInDB)';
        $update->bindParam(":hc",$this->Height_Category);
        $update->bindParam(":skin",$this->Skin);
        $update->bindParam(":eyes",$this->Eyes);
        $update->bindParam(":hair",$this->Hair);
        $update->bindParam(":marks",$this->Distinguishing_Marks);
        $update->bindParam(":uid",$this->UID);

        if ($update->execute()) {
            // debugging
            $this->LastGood = 'update succeeded (UpdateInDB)';
            $UpdateYou = $pw->prepare("UPDATE Logins SET CharUID = :CUID WHERE UID = :PUID");
            $UpdateYou->bindParam(":CUID", $this->UID);
            $UpdateYou->bindParam(":PUID",$you->UID);
            if ($UpdateYou->execute()) {
                // debugging
                $this->LastGood = 'UpdateYou succeeded (UpdateInDB)';
                $you->Character = $this->UID;
                return true;
            }
            // debugging
            $this->LastGood = 'UpdateYou failed (UpdateInDB)';
            print_r($UpdateYou->errorInfo());
            return false;
        }
        // debugging
        $this->LastGood = print_r($update->errorInfo());
        return false;
    }
}