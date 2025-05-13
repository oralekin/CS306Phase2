#must be launched from build
docker build -t cs306_db .
docker start cs306_instance || docker run -d -p 3307:3306 --name cs306_instance cs306_db
cd backend
npm i
npm run dev