import { Router, Request, Response } from "express";
import { connection } from "..";

interface IdType {
	max: number;
}

export function errFunction(res: Response) {
	return (err: any) => {
		console.log(err);
		return res.status(400).json(err);
	};
}

/*get the names of ids attributes and return the condition to get the specific element*/
function getIds(req: Request, keys: string[]) {
	const ids = Object.entries(req.params).filter((entry) =>
		keys.includes(entry[0]) ? entry[1] : null
	);
	if (ids.length == 0) throw new Error("Error on keys");
	//get the string for the condition to get the right elem by ids es [[jid,1] [ mid,2]] => ["jid = 1", "mid = 2"] => "jid = 1 AND mid=2 "
	const whereQuery = ids.map((id) => `${id[0]} = ${id[1]}`).join(" AND ");

	return { ids, whereQuery };
}

/*add '' if the value is a string*/
function toSqlValue<T>(value: T) {
	if (value == null) return "NULL";
	var isStr = typeof value == "string";
	return !isStr ? value : `'${value}'`;
}

export function restApi<T extends object>(tableName: string, keys: string[]) {
	function getAll(req: Request, res: Response) {
		connection
			.promise()
			.query(`SELECT * FROM ${tableName}`)
			.then((result) => res.status(200).json(result[0]))
			.catch(errFunction(res));
	}

	function get(req: Request, res: Response) {
		const { whereQuery } = getIds(req, keys);
		connection
			.promise()
			.query(`SELECT * FROM ${tableName} where ${whereQuery}`)
			.then((result) => res.status(200).json(result[0]))
			.catch(errFunction(res));
	}

	function post(req: Request, res: Response) {
		const entity: T = req.body;
		//return a string with all keys like "(jId, jName, canTeach ....)"
		const headerStr = `(${Object.keys(entity)
			.map((key) => `${key}`)
			.join(", ")})`;

		if (keys.length == 1) {
			connection
				.promise()
				.query(`SELECT max(${keys[0]}) as max FROM ${tableName}`)
				.then((maxQuery) => {
					const newId = (maxQuery[0] as IdType[])[0].max + 1;
					const valuesStr = `(${Object.entries(entity)
						.map((entry) =>
							entry[0] == keys[0] ? newId : toSqlValue(entry[1])
						)
						.join(", ")})`;

					connection
						.promise()
						.query(
							`INSERT INTO ${tableName} ${headerStr} VALUES
                            ${valuesStr}`
						)
						.then((result) => res.status(200).json(result[0]))
						.catch(errFunction(res));
				})
				.catch(errFunction(res));
		} else {
			//SUPER KEY CASE
			const valuesStr = `(${Object.entries(entity)
				.map((val) => toSqlValue(val[1]))
				.join(", ")})`;
			connection
				.promise()
				.query(
					`INSERT INTO ${tableName} ${headerStr} VALUES
            ${valuesStr}`
				)
				.then((result) => res.status(200).json(result[0]))
				.catch(errFunction(res));
		}
	}

	function put(req: Request, res: Response) {
		const { whereQuery } = getIds(req, keys);
		const entity: Partial<T> = req.body;

		const updateStr = Object.entries(entity)
			.filter((entry) => !keys.includes(entry[0]))
			.map((entry) => `${entry[0]} = ${toSqlValue(entry[1])}`)
			.join(", ");

		const query = `UPDATE ${process.env.DB_NAME}.${tableName}
            SET ${updateStr}
            WHERE ${whereQuery};`;

		connection
			.promise()
			.query(query)
			.then((result) => res.status(200).json("Success"))
			.catch(errFunction(res));
	}

	function remove(req: Request, res: Response) {
		const { whereQuery } = getIds(req, keys);
		connection
			.promise()
			.query(`DELETE FROM ${tableName} WHERE ${whereQuery};`)
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
