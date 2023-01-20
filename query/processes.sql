SELECT
  disk_bytes_read,
  disk_bytes_written,
  name,
  path,
  percent_processor_time,
  datetime(start_time, 'unixepoch', 'localtime') as start_time,
  state,
  total_size
FROM processes
WHERE
  state = 'STILL_ACTIVE'
ORDER BY total_size DESC
