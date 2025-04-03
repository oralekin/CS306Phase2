import { RowDataPacket } from "mysql2";
import { connection } from "..";
import {
	apiRouter,
	errFunction,
} from "./common";
import { Router, Request, Response } from "express";

enum EGender {
	Female,
	Male,
}
enum EBelt {
	White,
	Yellow,
	Orange,
	Green,
	Blue,
	Brown,
	Black,
}

interface User {
	jId: number;
	jName: string;
	gender: EGender;
	birthday: Date;
	jWeight: number;
	canTeach: boolean;
	belt: EBelt;
	startDate: Date;
	addId: number;
	accId?: number;
	ascId: number;
}

export const judokaRouter = apiRouter<User>("Judoka", ["jId"]);

judokaRouter.get("/subscription/:year", (req: Request, res: Response) => {
	const { year } = req.params;
	if (year) {
		const yearVal = parseInt(year);
		const startDate = new Date(yearVal, 1, 1).toISOString().slice(0, 10);
		const endDate = new Date(yearVal + 1, 1, 1).toISOString().slice(0, 10);
		const query = `CALL yearly_subs("${startDate}", "${endDate}");`;

		connection
			.promise()
			.query(query)
			.then((result) => {
				res.status(200).json((result[0] as RowDataPacket[][])[0]);
			})
			.catch(errFunction(res));
	}
});


