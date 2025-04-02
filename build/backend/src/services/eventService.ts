import { apiRouter } from "./common";

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
