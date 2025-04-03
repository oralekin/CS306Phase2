import express, { NextFunction, Response, Request } from "express";
import dotenv from "dotenv";
import { connect } from "./database";
import { judokaRouter } from "./services/judokaService";
import { eventsRouter } from "./services/eventService";
import { matchRouter } from "./services/matchService";
import { scoreRouter } from "./services/scoreService";
import { addressRouter } from "./services/addressService";
import { accountRouter } from "./services/accountService";
import { guardianRouter } from "./services/guardiansService";
import { associationRouter } from "./services/associationService";
import { dojoRouter } from "./services/dojoService";
import { requestRouter } from "./services/requestService";
import { studyInRouter } from "./services/studyService";
import { teachInRouter } from "./services/teachService";
import cors from "cors";

const app = express();
const PORT = process.env.PORT || 3000;
dotenv.config();

app.use(cors());
app.use(express.json());

export const connection = connect();

app.use(logger);


app.use("/judoka", judokaRouter);
app.use("/event", eventsRouter);
app.use("/match", matchRouter);
app.use("/score", scoreRouter);
app.use("/address", addressRouter);
app.use("/account", accountRouter);
app.use("/guardian", guardianRouter);
app.use("/association", associationRouter);
app.use("/dojo", dojoRouter);
app.use("/request", requestRouter);
app.use("/study", studyInRouter);
app.use("/teach", teachInRouter);

function logger(req: Request, res: Response, next: NextFunction) {
	console.log(`\t${req.url}`);
	next();
}

app.listen(PORT, () => {
	console.log(`Server is running on url http://localhost:${PORT}`);
});
