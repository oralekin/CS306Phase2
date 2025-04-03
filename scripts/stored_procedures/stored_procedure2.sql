DELIMITER //
CREATE PROCEDURE check_winner(IN curr_id INT)
BEGIN
    SELECT PS.mId, ippon*10 + wazari*5 + yuko as Points, ippon, wazari, yuko, J.jName   
    FROM PlayedScore PS, JudoMatch JM, Judoka J
    WHERE PS.mId = curr_id AND PS.forfeit <> curr_id AND PS.mId = JM.mId AND J.jId = PS.jId 
    ORDER BY Points DESC LIMIT 1;
END //

CREATE PROCEDURE versus()
BEGIN
    SELECT P1.mId, J1.jName as player1, J2.jName as player2
    FROM PlayedScore P1, PlayedScore P2, Judoka J1, Judoka J2
    WHERE J1.jId < J2.jId AND P1.jId < P2.jId AND P1.mId = P2.mId AND P1.jId = J1.jId AND P2.jId = J2.jId AND P1.kScore IS NULL;
END//
DELIMITER;
