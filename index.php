<?php
function queryExec($sql)
{
    $osquery = PHP_OS === 'WINNT' ? '"C:\Program Files\osquery\osqueryi"' : 'osqueryi';
    $file = fopen($sql, "r");
    $query = fread($file, filesize($sql));
    $query = preg_replace("/[\n\r]/", " ", $query);
    fclose($file);
    return shell_exec($osquery . ' --json "' . $query . '"');
}

$result = !empty($_GET["q"]) ? json_decode(queryExec("query/{$_GET['q']}.sql"), true) : [];
$options = ["os_version", "processes", "system_info", "certificates", "chrome_extensions", "firefox_addons"];
?>
<html>
    <head>
        <title>OSQuery Monitor</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
    </head>
    <body>
        <div style="padding: 10px;">
            <form method="GET">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">q</span>
                    </div>
                    <select name="q" onchange='if (this.value) { this.form.submit(); }'>
                        <option value="">-- choice query --</option>
                        <?php foreach ($options as $option) { ?>
                            <option value="<?= $option; ?>" <?= !empty($_GET["q"]) && $option == $_GET["q"] ? "selected" : null; ?>><?= $option; ?></option>
                        <?php } ?>
                    </select>
                    <div class="input-group-append">
                        <span class="input-group-text">download and install&nbsp;<a href="https://www.osquery.io/downloads" target="_blank">osquery</a></span>
                    </div>
                </div>
            </form>
            <?php if ($result) { ?>
                <table id="table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>no</th>
                            <?php foreach (array_keys(current($result)) as $column) { ?>
                                <th><?= $column; ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $key => $data) { ?>
                            <tr>
                                <td><?= $key + 1; ?></td>
                                <?php foreach (array_keys(current($result)) as $column) { ?>
                                    <td><?= $data[$column]; ?></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </body>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
    <script>
        $('#table').DataTable();
    </script>
</html>
