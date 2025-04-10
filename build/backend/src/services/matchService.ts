import { RowDataPacket } from "mysql2";
import { connection } from "..";
import { apiRouter, errFunction, logQuery } from "./common";
import { Request, Response } from "express";

interface JudoMatch {
	mId: number;
	mTime: number;
	mDate: Date;
	eId: number;
}

export const matchRouter = apiRouter<JudoMatch>("JudoMatch", ["mId"]);

matchRouter.get("/winner/:mId", (req: Request, res: Response) => {
	const { mId } = req.params;
	connection
		.promise()
		.execute(logQuery(`CALL check_winner(?);`, [mId]), [mId])
		.then((result) =>
			res.status(200).json((result[0] as RowDataPacket[][])[0])
		)
		.catch(errFunction(res));
});

matchRouter.get("/all/vs", (req: Request, res: Response) => {
	connection
		.promise()
		.execute(logQuery(`CALL versus();`))
		.then((result) =>
			res.status(200).json((result[0] as RowDataPacket[][])[0])
		)
		.catch(errFunction(res));
});
