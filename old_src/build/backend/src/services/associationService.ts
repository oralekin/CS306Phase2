import { apiRouter } from "./common";

interface Association {
	ascId: number;
	ascName: string;
	email: string;
	phone?: string;
	addId: number;
}

export const associationRouter = apiRouter<Association>("Association", [
	"ascId",
]);
