db = new Mongo().getDB("app");

db.createUser({
    user: 'db',
    pwd: 'db',
    roles: [
      {
        role: 'readWrite',
        db: 'app',
      },
    ],
  });
  db.createCollection('app', { capped: false });