import { apiRouter } from "./common";

enum EAgeType {
	Kids,
	Intermediate,
	Elderly,
}
enum ELevelype {
	Beginner,
	Intermediate,
	Advanced,
}

interface TeachIn {
	jId: number;
	dId: number;
	cAge?: EAgeType;
	cLevel?: ELevelype;
}

export const teachInRouter = apiRouter<TeachIn>("TeachIn", ["jId", "eId"]);
