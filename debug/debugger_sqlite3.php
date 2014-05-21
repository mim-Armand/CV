
<?php
$db = new SQLite3('mysqlitedb.db');

$db->exec('CREATE TABLE foo (bar STRING)');
$db->exec("INSERT INTO foo (bar) VALUES ('This is a test')");

$result = $db->query('SELECT bar FROM foo');
var_dump($result->fetchArray());
?>




<div class="panel panel-default">
  <div class="panel-heading">
  Settings and variables:
  </div>
  <div class="panel-body">
    <a href="http://www.php.net/manual/en/sqlite3.constants.php">SQLite3 Predefined Constants:</a>
  </div>
  <table class="table table-striped table-bordered table table-hover table table-condensed">
    <th>Constant</th><th>Value</th>
    <tr>
      <td>SQLITE3_ASSOC</td>
      <td><?php echo SQLITE3_ASSOC; ?></td>
    </tr>
    <tr>
      <td>SQLITE3_NUM</td>
      <td><?php echo SQLITE3_NUM; ?></td>
    </tr>
    <tr>
      <td>SQLITE3_BOTH</td>
      <td><?php echo SQLITE3_BOTH; ?></td>
    </tr>
    <tr>
      <td>SQLITE3_INTEGER</td>
      <td><?php echo SQLITE3_INTEGER; ?></td>
    </tr>
    <tr>
      <td>SQLITE3_FLOAT</td>
      <td><?php echo SQLITE3_FLOAT; ?></td>
    </tr>
    <tr>
      <td>SQLITE3_TEXT</td>
      <td><?php echo SQLITE3_TEXT; ?></td>
    </tr>
    <tr>
      <td>SQLITE3_BLOB</td>
      <td><?php echo SQLITE3_BLOB; ?></td>
    </tr>
    <tr>
      <td>SQLITE3_NULL</td>
      <td><?php echo SQLITE3_NULL; ?></td>
    </tr>
    <tr>
      <td>SQLITE3_OPEN_READONLY</td>
      <td><?php echo SQLITE3_OPEN_READONLY; ?></td>
    </tr>
    <tr>
      <td>SQLITE3_OPEN_READWRITE</td>
      <td><?php echo SQLITE3_OPEN_READWRITE; ?></td>
    </tr>
    <tr>
      <td>SQLITE3_OPEN_CREATE</td>
      <td><?php echo SQLITE3_OPEN_CREATE; ?></td>
    </tr>
  </table>
</div>