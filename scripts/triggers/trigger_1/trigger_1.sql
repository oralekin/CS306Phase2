delimiter $$
CREATE TRIGGER Check_date BEFORE INSERT ON JudoMatch
FOR EACH ROW

BEGIN
SET start_event = SELECT startDate FROM JudoEvents JE WHERE NEW.eid = JE.eid;
SET end_event = SELECT endDate FROM JudoEvents JE WHERE NEW.eid = JE.eid;

IF (NEW.mDate NOT BETWEEN start_event AND end_event) THEN

    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Match date is incorrect please put a correct date before the insert";
END IF;

END;$$
delimiter
