import { apiRouter } from "./common";

enum RequestState {
	Submitted,
	Rejected,
	Approved,
}

interface Request {
	jId: number;
	eId: number;
	rStatus: RequestState;
	rDate: string;
}

export const requestRouter = apiRouter<Request>("Request", [
	"jId",
	"eId",
]);
