import { RowDataPacket } from "mysql2";
import { connection } from "..";
import { apiRouter, errFunction } from "./common";
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
	const query = `CALL check_winner(${mId});`;
	//[[[list], ],[]]
	connection
		.promise()
		.query(query)
		.then((result) =>
			res.status(200).json((result[0] as RowDataPacket[][])[0])
		)
		.catch(errFunction(res));
});

matchRouter.get("/all/vs", (req: Request, res: Response) => {
	const query = `CALL versus();`;

	connection
		.promise()
		.query(query)
		.then((result) =>
			res.status(200).json((result[0] as RowDataPacket[][])[0])
		)
		.catch(errFunction(res));
});
