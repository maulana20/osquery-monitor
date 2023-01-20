SELECT
  author,
  browser_type,
  from_webstore,
  description,
  name,
  optional_permissions,
  profile,
  version,
  datetime(install_timestamp, 'unixepoch', 'localtime') as install_timestamp
FROM chrome_extensions
