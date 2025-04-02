CREATE PROCEDURE yearly_subs
(@Start_date DATE, @End_date @DATE)

AS 


BEGIN

    SELECT * FROM Judoka WHERE startDate BETWEEN @Start_date AND @End_date ;

END
