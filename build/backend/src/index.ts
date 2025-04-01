import express from "express";
import dotenv from "dotenv";
import { connect } from "./database";
import { judokaRouter } from "./services/judokaService";
import { eventsRouter } from "./services/eventService";
import { matchRouter } from "./services/matchService";
import { scoreRouter } from "./services/scoreService";

const app = express();
const PORT = process.env.PORT || 3000;
dotenv.config();

app.use(express.json());

export const connection = connect();


app.use("/judoka", judokaRouter);
app.use("/event", eventsRouter);
app.use("/match", matchRouter);
app.use("/score", scoreRouter);

app.listen(PORT, () => {
	console.log(`Server is running on port ${PORT}`);
});
