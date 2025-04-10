import { RowDataPacket } from "mysql2";
import { connection } from "..";
import { apiRouter, errFunction, logQuery } from "./common";
import { Request, Response } from "express";

enum EEventType {
	Competition,
	Stage,
	Event,
}

interface JudoEvent {
	eId: number;
	eName: string;
	price?: number;
	eType: EEventType;
	startDate: Date;
	endDate: Date;
	addId: number;
	ascId: number;
}

export const eventsRouter = apiRouter<JudoEvent>("JudoEvents", ["eId"]);

eventsRouter.get("/max/profit", (req: Request, res: Response) => {
	connection
		.promise()
		.execute(logQuery(`CALL maxProfitEvent();`))
		.then((result) => {
			res.status(200).json((result[0] as RowDataPacket[][])[0]);
		})
		.catch(errFunction(res));
});
