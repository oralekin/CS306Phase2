import { createConnection, createPool, QueryResult } from "mysql2";
import { connection } from ".";

export function connect() {
	if (
		!process.env.DB_HOST ||
		!process.env.DB_USR ||
		!process.env.DB_PSW ||
		!process.env.DB_NAME
	)
		throw new Error("Env not complete for database connection");

	const connection = createConnection({
		host: process.env.DB_HOST,
		port: parseInt(process.env.DB_PORT ?? "3306"),
		user: process.env.DB_USR,
		password: process.env.DB_PSW,
	});

	connection.connect((e) => {
		if (e) {
			throw new Error(e.message);
		}
		console.log("Connected to " + process.env.DB_NAME);
	});

	// const exists = connection.query(
	// 	"SHOW  databases LIKE '" + process.env.DB_NAME + "'",
	// 	(err, res, fields) => {
	// 		// if(!res)
	// 		//     connection.query(`CREATE DATABASE '${process.env.DB_NAME}'`)
	// 		// console.log(res);
	// 		const result = res as object[];
	// 		return res;
	// 	}
	// );

	console.log("exists: ");
	// console.log(exists);
	return connection;
}

export function check() {
	// const rows = connection.query(
	// 	`SELECT *
	//     FROM Judoka`,
	// 	(err, results, fields) => {
	// 		console.log(results);
	// 	}
	// );
}
