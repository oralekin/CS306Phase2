delimiter $$

CREATE TRIGGER Check_date BEFORE INSERT ON JudoMatch
FOR EACH ROW
BEGIN
  DECLARE start_event DATE;
  DECLARE end_event DATE;
  
  SELECT startDate INTO start_event FROM JudoEvents WHERE eId = NEW.eId LIMIT 1;
  SELECT endDate INTO end_event FROM JudoEvents WHERE eId = NEW.eId LIMIT 1;
  
  IF (NEW.mDate NOT BETWEEN start_event AND end_event) THEN
    SIGNAL SQLSTATE '45000' 
    SET MESSAGE_TEXT = 'Match date is incorrect. Please ensure the date is within the event range.';
  END IF;
END $$
DELIMITER;

delimiter $$
CREATE TRIGGER Check_date_upd BEFORE UPDATE ON JudoMatch
FOR EACH ROW
BEGIN
  DECLARE start_event DATE;
  DECLARE end_event DATE;
  
  SELECT startDate INTO start_event FROM JudoEvents WHERE eId = NEW.eId LIMIT 1;
  SELECT endDate INTO end_event FROM JudoEvents WHERE eId = NEW.eId LIMIT 1;
  
  IF (NEW.mDate NOT BETWEEN start_event AND end_event) THEN
    SIGNAL SQLSTATE '45000' 
    SET MESSAGE_TEXT = 'Match date is incorrect. Please ensure the date is within the event range.';
  END IF;
END $$
DELIMITER;

