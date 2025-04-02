import { apiRouter } from "./common";

interface Address {
	addId: number;
	street: string;
	city: string;
	postalCode: string;
	province?: string;
	region?: string;
	country: string;
}

export const addressRouter = apiRouter<Address>("Addresses", ["addId"]);
