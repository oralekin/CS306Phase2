FROM mysql:latest

ENV MYSQL_ROOT_PASSWORD=Group_22_CS306
ENV MYSQL_DATABASE=judo_federation

COPY createQueries.sql /docker-entrypoint-initdb.d/

EXPOSE 3306

