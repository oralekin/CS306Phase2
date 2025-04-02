import { apiRouter } from "./common";

interface Guardian {
	gId: number;
	accId: number;
	gRole?: string;
	gName: string;
	email: string;
	phone: string;
}

export const guardianRouter = apiRouter<Guardian>("Guardians", [
	"gId",
	"accId",
]);
