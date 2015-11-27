<?php
function file_to_array($file_name)
{
    $files = array();
    $file = fopen($file_name, "r");
    while (!feof($file)) {
        $files [] = trim(fgets($file));
    }
    fclose($file);
    return $files;
}

function is_Mobile($user_agent)
{
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $user_agent);
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LOG MONITOR</title>
    <link rel="stylesheet" type="text/css"
          href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8"
            src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>

</head>
<style>
    /*.demo {*/
    /*border: 1px solid #C0C0C0;*/
    /*border-collapse: collapse;*/
    /*padding: 5px;*/
    /*}*/

    /*.demo th {*/
    /*border: 1px solid #C0C0C0;*/
    /*padding: 5px;*/
    /*background: #F0F0F0;*/
    /*}*/

    /*.demo td {*/
    /*border: 1px solid #C0C0C0;*/
    /*padding: 5px;*/
    /*}*/
</style>

<body>
<script>
    $(document).ready(function() {

        $('#example').DataTable();

    } );
</script>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && array_key_exists("password", $_POST) && $_POST["password"] == 'salakala') { ?>
    <table class="demo" id="example">
        <caption></caption>
        <thead>
        <tr>
            <th>IP</th>
            <th>USER-AGENT</th>
            <th>ISP</th>
            <th>TIMESTAMP</th>


        </tr>
        </thead>
        <tbody>

        <?php

        if (file_exists('visitor.log')) {
            $log = array_reverse(file_to_array('visitor.log'));

            foreach ($log as $value) {
                $row = (array)json_decode($value);
                echo '<tr>', '<td>&nbsp;', $row['ip'], '</td>', '<td>&nbsp;', (is_Mobile($row['browser'])) ? "<p style='color: red'>" . $row['browser'] . "</p>" : $row['browser'], '</td>',
                '<td>&nbsp;', $row['origin'], '</td>', '<td>&nbsp;', $row['timestamp'], '</td>', '</tr>';
            }
            echo "<h3>", count($log), " visitors so far</h3>";
        }
        ?>
        <tbody>
    </table>


<?php }; ?>
<?php if (!array_key_exists("password", $_POST) || $_POST["password"] != 'salakala') { ?>
    <form action="monitor.php" id="login" method="post">

        <label for="key">How can I help You? </label>
        <input id="key" name="password" type="password" required>
        <br/>
        <input type="submit" value="Ok">
    </form>
<?php }; ?>


</html>