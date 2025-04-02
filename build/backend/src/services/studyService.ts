import { apiRouter } from "./common";

interface StudyIn {
	jId: number;
	dId: number;
}

export const studyInRouter = apiRouter<StudyIn>("StudyIn", ["dId", "jId"]);
