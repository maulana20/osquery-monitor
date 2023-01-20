SELECT
  creator,
  description,
  identifier,
  location,
  name,
  type,
  version,
  CASE WHEN disabled = 1 THEN 'true' ELSE 'false' END AS disabled,
  CASE WHEN active = 1 THEN 'true' ELSE 'false' END AS active
FROM firefox_addons
