SELECT
  common_name,
  issuer,
  datetime(not_valid_after, 'unixepoch') as not_valid_after,
  datetime(not_valid_before, 'unixepoch') as not_valid_before,
  path,
  serial,
  username
FROM certificates
