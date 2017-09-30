#!/bin/bash
# PostgreSQL
#sudo sed -i 's/\(all *\)\(md5\|peer\)/\1trust/' /etc/postgresql/9.4/main/pg_hba.conf;
#sudo sed -i "/^#listen_addresses/i listen_addresses='*'" /etc/postgresql/9.4/main/postgresql.conf;

# Create DB
sudo -u postgres psql --command="CREATE USER pgadmin WITH PASSWORD '123456';"
sudo -u postgres psql --command="CREATE DATABASE gisunesp OWNER pgadmin;"
sudo -u postgres psql --dbname=gisunesp --command="CREATE EXTENSION adminpack;CREATE EXTENSION postgis;CREATE EXTENSION postgis_topology;"