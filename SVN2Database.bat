mysql -uroot -p -e "DROP DATABASE scsim_phoenix"
mysql -uroot -p -e "CREATE DATABASE scsim_phoenix"
mysql -uroot -p scsim_phoenix < "%~dp0\protected\data\scsim.sql"