#!/bin/bash
# PostgreSQL
# ==========================================
sudo service postgresql status > /dev/null 2>&1;
if [ "$?" -gt "0" ]; then
  sudo apt-get install -y postgresql-9.4 postgresql-contrib-9.4;
  echo "Postgres successfully installed.";
else
  echo "Postgres already installed.";
fi

sudo sed -i 's/\(all *\)\(md5\|peer\)/\1trust/' /etc/postgresql/9.4/main/pg_hba.conf;
sudo sed -i "/^#listen_addresses/i listen_addresses='*'" /etc/postgresql/9.4/main/postgresql.conf;

# Create DB
sudo -u postgres psql --command="CREATE USER pgadmin WITH PASSWORD '123456';"  > /dev/null 2>&1;
sudo -u postgres psql --command="CREATE DATABASE sigunesp OWNER pgadmin;"  > /dev/null 2>&1;

# PostGIS
# ==========================================
#
# @TODO: Não é uma boa forma de checar se o PostGIS está instalado,
# pois é apenas a pasta utilizada para instalar. Eu particularmente
# excluo essa pasta após instalar na minha máquina.
if [ -d ~/postgis-2.2.2  ]; then
  echo 'PostGIS already installed.';
else
  sudo apt-get install -y build-essential \
    postgresql-server-dev-9.4 \
    libxml2-dev \
    libproj-dev \
    libjson0-dev \
    libgeos-dev \
    xsltproc \
    docbook-xsl \
    docbook-mathml \
    libgdal-dev

  cd ~/
  wget http://download.osgeo.org/postgis/source/postgis-2.2.2.tar.gz > /dev/null 2>&1;
  tar -zxvf postgis-2.2.2.tar.gz  > /dev/null 2>&1;
  rm -rf postgis-2.2.2.tar.gz
  cd postgis-2.2.2
  ./configure > /dev/null 2>&1;
  make  > /dev/null 2>&1;
  sudo make install  > /dev/null 2>&1;
  sudo ldconfig
  sudo -u postgres psql --dbname=sigarteris --command="CREATE EXTENSION adminpack;CREATE EXTENSION postgis;CREATE EXTENSION postgis_topology;"  > /dev/null 2>&1;
  sudo make comments-install  > /dev/null 2>&1;
  sudo ln -sf /usr/share/postgresql-common/pg_wrapper /usr/local/bin/shp2pgsql
  sudo ln -sf /usr/share/postgresql-common/pg_wrapper /usr/local/bin/pgsql2shp
  sudo ln -sf /usr/share/postgresql-common/pg_wrapper /usr/local/bin/raster2pgsql

  echo 'Postgis successfully installed.';
fi
