import { apiRouter } from "./common";

interface JudoMatch {
	mId: number;
	mTime: number;
	mDate: Date;
	eId: number;
}

export const matchRouter = apiRouter<JudoMatch>("JudoMatch", ["mId"]);
