import { apiRouter } from "./common";

interface Dojo {
	dId: number;
	dName: string;
	addId: number;
	ascId: number;
}

export const dojoRouter = apiRouter<Dojo>("Dojo", ["dId"]);
