import { apiRouter } from "./common";

interface PlayedScore {
	jId: number;
	mId: number;
	ippon?: number;
	wazari?: number;
	yuko?: number;
	kScore?: number;
	forfeit?: boolean;
}

export const scoreRouter = apiRouter<PlayedScore>("PlayedScore", [
	"jId",
	"mId",
]);
