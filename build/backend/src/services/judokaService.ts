import { apiRouter } from "./common";

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
