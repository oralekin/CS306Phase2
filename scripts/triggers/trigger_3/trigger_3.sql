delimiter $$
CREATE TRIGGER check_correctness BEFORE INSERT ON PlayedScore

FOR EACH ROW
BEGIN

IF NEW.kScore IS NOT NULL  AND (NEW.ippon IS NOT NULL OR NEW.wazari IS NOT NULL OR NEW.yuko IS NOT NULL) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "ERROR: Score format is incorrect try checking if the score is a kata or 1v1 and if the attributes are according";
END IF;

IF NEW.kScore IS NULL  AND NEW.ippon IS NULL AND NEW.wazari IS NULL AND NEW.yuko IS NULL THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "ERROR: Score format is incorrect try checking if the score is a kata or 1v1 and if the attributes are according";
END IF;

END; $$
delimiter;

delimiter $$
CREATE TRIGGER check_correctness_upd BEFORE UPDATE ON PlayedScore

FOR EACH ROW
BEGIN

IF NEW.kScore IS NOT NULL  AND (NEW.ippon IS NOT NULL OR NEW.wazari IS NOT NULL OR NEW.yuko IS NOT NULL) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "ERROR: Score format is incorrect try checking if the score is a kata or 1v1 and if the attributes are according";
END IF;

IF NEW.kScore IS NULL  AND NEW.ippon IS NULL AND NEW.wazari IS NULL AND NEW.yuko IS NULL THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "ERROR: Score format is incorrect try checking if the score is a kata or 1v1 and if the attributes are according";
END IF;

END; $$
delimiter;
