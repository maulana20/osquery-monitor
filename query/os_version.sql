SELECT *,
  datetime(install_date, 'unixepoch', 'localtime') as install_date
FROM os_version
