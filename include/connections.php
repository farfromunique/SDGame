<?php
    $con = new PDO('mysql:host=sdgame.db;dbname=Characters','sdgame','Read_It');
    $ud = new PDO('mysql:host=sdgame.db;dbname=Characters','sdgame_add','WriteIt');
    $pw = new PDO('mysql:host=sdgame.db;dbname=Characters','sdgame_pw','safetyFirst');
    $optimize = new PDO('mysql:host=sdgame.db;dbname=Characters','sdgame_maintain','janitor');

    $time = new DateTime('now',new DateTimeZone('UTC'));
    //debugging
    $tu = '2013-08-14 05:00:00';
    $tfOld = '2013-08-14 00:00:00';
    $loc = 1;

    $specificLocation = $con->prepare("SELECT * FROM Locations WHERE UID = ?");
    $specificLocation->bindParam(1, $_SESSION["CurrLoc"]);

    $allLocations = $con->prepare("SELECT * FROM Locations");

    $conversation = $con->prepare("SELECT Conversations.UID, Conversations.Location, Conversations.TDS,
                                    Character_Details.Name, Conversations.Comment, Character_Details.UID AS CharUID
                                    FROM Conversations
                                    INNER JOIN Character_Details ON Conversations.Char_num = Character_Details.UID
                                    WHERE TDS >= :tds AND Location = :location ORDER BY UID DESC LIMIT 0, 10");
    $conversation->bindParam(":tds", $tfOld);
    $conversation->bindParam(":location",$loc);
    //$conversation->bindParam(":location", $_SESSION["CurrLoc"]);

    $messageCount = $con->prepare("SELECT MAX(UID) FROM Conversations WHERE Location = :loc");

    $charactersHere = $con->prepare("SELECT UID, Name, Rank FROM Character_Details WHERE Current_Location_W = ?");
    $charactersHere->bindParam(1, $_SESSION["CurrLoc"]);

    $allCharacters = $con->prepare("SELECT Character_Details.UID, Character_Details.Name, Character_Details.Rank,
                                            Locations.LocationName_W AS Location, Locations.UID AS LocUID
                                    FROM Character_Details
                                    JOIN Locations ON Character_Details.Current_Location_W=Locations.UID
                                    ORDER BY Locations.UID ASC");

    $sendChat = $ud->prepare("INSERT INTO Conversations (Location, TDS, Char_num, Comment)
                              VALUES (:location,:updateTime,:charUID,:message)");
    //$sendChat->bindParam(":location",$_SESSION["CurrLoc"]);
    $sendChat->bindParam(":location",$loc); // using debug variable
    $sendChat->bindParam(":updateTime",$time->format('Y-m-d G:i:s'));

    $lastActive = $pw->prepare("UPDATE Logins SET LastLogin=:tds WHERE CharUID=:uid");
    $lastActive->bindParam(":tds",$time->format('Y-m-d'));
    $lastActive->bindparam(":uid",$you->Character);
?>