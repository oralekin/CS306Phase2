import { apiRouter } from "./common";

enum AccountType {
	Family,
	Individual,
}

interface Account {
	accId: number;
	email: string;
	aPassword: string;
	aType: AccountType;
}

export const accountRouter = apiRouter<Account>("Accounts", ["accId"]);
