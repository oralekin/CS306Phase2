CREATE PROCEDURE check_winner(IN curr_id INT)
BEGIN
    SELECT ippon*10 + wazari*5 + yuko as Points, PS.mId  
    FROM PlayedScore PS, JudoMatch JM 
    WHERE PS.mId = 1 AND PS.forfeit <> curr_id AND PS.mId = JM.mId 
    ORDER BY Points DESC LIMIT 1;
END;
