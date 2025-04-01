delimiter $$
CREATE TRIGGER check_teach BEFORE INSERT ON TeachIn
FOR EACH ROW

BEGIN

SET belt_check = SELECT J.belt FROM Judoka J where J.jId = NEW.jId;

IF  belt_check <> "black" THEN 
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "This Judoka cannot be inert into the teachers, since they don't have a black belt";

END; $$
delimiter;
