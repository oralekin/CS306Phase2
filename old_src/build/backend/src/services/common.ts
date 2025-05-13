import { Router, Request, Response } from "express";
import { connection } from "..";
import { escape, FieldPacket, QueryResult, RowDataPacket } from "mysql2";

export function errFunction(res: Response) {
	return (err: any) => {
		console.log(err);
		return res.status(400).json(err);
	};
}

/*get the names of ids attributes and return the condition to get the specific element*/
function getIdsQuery(req: Request, keys: string[]) {
	const ids = Object.entries(req.params).filter((entry) =>
		keys.includes(entry[0]) ? entry[1] : null
	);
	if (ids.length == 0) throw new Error("Error on keys");
	//get the string for the condition to get the right elem by ids es [[jid,1] [ mid,2]] => ["jid = 1", "mid = 2"] => "jid = 1 AND mid=2 "
	const queryObj = ids.map((id) => {
		return { query: `${id[0]} = ?`, value: id[1] };
	});

	return {
		ids,
		whereQuery: queryObj.map((x) => x.query).join(" AND "),
		values: queryObj.map((x) => x.value),
	};
}

export function logQuery(str: string, values: number[] | string[] = []) {
	console.log(
		`\t\t${str}\t` + (values.length ? `[${values.join(", ")}]` : "")
	);
	return str;
}

export function restApi<T extends object>(tableName: string, keys: string[]) {
	function getAll(req: Request, res: Response) {
		connection
			.promise()
			.execute(logQuery(`SELECT * FROM ${tableName}`))
			.then((result) => res.status(200).json(result[0]))
			.catch(errFunction(res));
	}

	function get(req: Request, res: Response) {
		const { whereQuery, values } = getIdsQuery(req, keys);

		connection
			.promise()
			.execute(
				logQuery(
					`SELECT * FROM ${tableName} WHERE ${whereQuery}`,
					values
				),
				values
			)
			.then((result) => res.status(200).json(result[0]))
			.catch(errFunction(res));
	}

	async function post(req: Request, res: Response) {
		const entity: T = req.body;
		const bodyKeys = Object.keys(entity);
		let values = Object.entries(entity).map((val) => val[1]);
		console.log(keys.length);
		if (keys.length == 1) {
			const maxId: any = (
				(
					await connection
						.promise()
						.execute(
							logQuery(
								`SELECT max(${bodyKeys[0]}) as max FROM ${tableName};`
							),
							[bodyKeys[0]]
						)
				)[0] as RowDataPacket[][]
			)[0];
			console.log(maxId);

			const newId: number = (maxId.max as number) + 1;
			values = Object.entries(entity).map((entry) =>
				entry[0] == keys[0] ? newId : entry[1]
			);
			console.log(values);
		}

		connection
			.promise()
			.query(
				logQuery(
					`INSERT INTO ${tableName} (${bodyKeys.map((x) =>
						escape(x).replace(/'/g, "")
					)}) VALUES (?);`,
					values
				),
				[values]
			)
			.then((result) => res.status(200).json(result[0]))
			.catch(errFunction(res));
	}

	function put(req: Request, res: Response) {
		const { whereQuery, values: whereValues } = getIdsQuery(req, keys);
		const entity: Partial<T> = req.body;
		const filteredEntries = Object.entries(entity).filter(
			(entry) => !keys.includes(entry[0])
		);

		const updateObj = filteredEntries.map(
			(entry) => `${escape(entry[0]).replace(/'/g, "")} = ?`
		);

		const values: any[] = filteredEntries.map((x) => x[1]);

		connection
			.promise()
			.execute(
				logQuery(
					`UPDATE ${tableName} SET ${updateObj} WHERE ${whereQuery};`,
					values
				),
				values.concat(whereValues)
			)
			.then((result) => res.status(200).json("Success"))
			.catch(errFunction(res));
	}

	function remove(req: Request, res: Response) {
		const { whereQuery, values } = getIdsQuery(req, keys);
		connection
			.promise()
			.execute(
				logQuery(
					`DELETE FROM ${tableName} WHERE ${whereQuery};`,
					values
				),
				values
			)
			.then((result) => res.status(200).json(result[0]))
			.catch(errFunction(res));
	}

	return { getAll, get, post, put, remove };
}

export function apiRouter<T extends object>(
	tableName: string,
	keys: string[]
): Router {
	const api = restApi<T>(tableName, keys);
	const router = Router();

	const params = (keys as string[]).map((x) => `:${x}`).join("/");

	router.get("/", api.getAll);
	router.get(`/${params}`, api.get);
	router.post("/", api.post);
	router.put(`/${params}`, api.put);
	router.delete(`/${params}`, api.remove);

	return router;
}
