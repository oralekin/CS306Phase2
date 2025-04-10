import { createConnection } from "mysql2";

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
		database: process.env.DB_NAME,
	});

	connection.connect((e) => {
		console.log("Connected to " + process.env.DB_NAME);
	});

	return connection;
}
