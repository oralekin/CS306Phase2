DELIMITER //
CREATE PROCEDURE maxProfitEvent()
BEGIN
    SELECT R.eId, COUNT(R.rStatus) * JE.price as gain, JE.eName
    FROM Request R, JudoEvents JE
    WHERE R.rStatus = 'approved' AND JE.eId = R.eId
    GROUP BY R.eId, JE.eName
    ORDER BY gain DESC
    LIMIT 1;
END //

DELIMITER ;