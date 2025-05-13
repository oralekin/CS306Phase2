DELIMITER //
CREATE PROCEDURE yearly_subs(IN Start_date DATE, IN End_date DATE)
BEGIN
    SELECT * 
    FROM Judoka
    WHERE startDate BETWEEN Start_date AND End_date ;
END //
DELIMITER ;