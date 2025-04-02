DELIMITER //

CREATE TRIGGER check_teach BEFORE INSERT ON TeachIn
FOR EACH ROW
BEGIN
  DECLARE belt_check ENUM("white","yellow","orange","green", "blue","brown", "black");
  SELECT J.belt into belt_check FROM Judoka J where J.jId = NEW.jId;

  IF  belt_check <> "black" THEN 
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "This Judoka cannot be inert into the teachers, since they don't have a black belt";
  END IF;
END//


CREATE TRIGGER check_teach_upd BEFORE UPDATE ON TeachIn
FOR EACH ROW
BEGIN
  DECLARE belt_check ENUM("white","yellow","orange","green", "blue","brown", "black");
  SELECT J.belt into belt_check FROM Judoka J where J.jId = NEW.jId;

  IF  belt_check <> "black" THEN 
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "This Judoka cannot be inert into the teachers, since they don't have a black belt";
  END IF;
END//

DELIMITER ;