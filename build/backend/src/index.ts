import express, { Request, Response } from "express";
import mysql, { Pool } from "mysql2";
import dotenv from "dotenv";
import { createPool } from "mysql2/promise";
import { check, connect } from "./database";

const app = express();
const PORT = process.env.PORT || 3000;
dotenv.config();

app.use(express.json());

console.log(process.env.DB_HOST);
export const connection = connect();
check();

// console.log(connection);

app.get("/", (req: Request, res: Response) => {
	res.send("Welcome to the Node.js + TypeScript API!");
});

app.listen(PORT, () => {
	console.log(`Server is running on port ${PORT}`);
});
