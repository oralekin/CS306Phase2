docker build -t cs306_db .
docker run -d -p 3307:3306 --name cs306_instance cs306_db
sleep 1
cd backend
npm run dev