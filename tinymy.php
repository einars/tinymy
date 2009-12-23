<?php
#
#
#  tinyMy http://spicausis.lv/tinymy/
#  small mysql management console
#  (c) 2005-2008, Einar Lielmanis <einars@gmail.com>
#
#

error_reporting(E_ALL);
ini_set('display_errors', 'on');

# which host to connect to?
$db_host = 'localhost';


# if you don't have SHOW DATABASES privilege and are unable to
# see accessible databases, set this to your default db
$default_database = 'some_db';

# how many characters to display for blob/text fields?
define('BLOB_MAX_SIZE', 128);

# should non-ASCII characters be skipped?
# you can probably try to use this with non-utf-8 databases
define('BLOB_SKIP_NON_ASCII', false);


# text to display for blob and null fields (boring)
$null_text = '<em>NULL</em>';



// tinymy starts here, you don't want to read further

// ob_start();
process_tinyadm();
$content = ob_get_contents();
ob_end_clean();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css" media="all"><?php echo css_compact(css_default()) ?></style>
<title><?php
if ($db->is_connected()) {
    // you may want to change these lines to display something more meaningful, if
    // you have multiple sites to manage and the default title is not meaningful enough
    $host_to_show = $db_host;
    if (strtolower($host_to_show) == 'localhost' || $host_to_show == '127.0.0.1') {
        $host_to_show = $_SERVER['SERVER_ADDR'];
    }
    printf("%s@%s - tinyMy", $_SESSION['user'], $host_to_show);
} else {
    echo 'tinyMy';
}
?></title><script type="text/javascript"><!--
function ctrl_enter(evt) {
if (!evt || !document.getElementById('sqlarea')) return;
if (evt.keyCode==13 && evt.ctrlKey) {
    document.getElementById('sqlarea').submit();
    evt.preventDefault();
}
if ((evt.keyCode==13 && evt.altKey) || (evt.keyCode==32 && evt.ctrlKey)) {
    var sql = document.getElementById('sqlarea').sql;
    sql.focus();
    var sel = sql.selectionStart;
<?php $auto_text = $_SESSION['table'] ? "$_SESSION[database].$_SESSION[table] " : $_SESSION['database']; ?>
    sql.value = sql.value.substring(0, sel) + '<?php echo $auto_text ?>' + sql.value.substring(sql.selectionEnd);
    sql.setSelectionRange(sel + <?php echo strlen($auto_text) ?>, sel + <?php echo strlen($auto_text) ?>);
    evt.preventDefault();
}
}
--></script></head>
    <body onkeydown="ctrl_enter(event)"><?php echo $content?></body></html><?php

function css_default() {
    return <<<CSS
* {
    margin:0;
    padding:0;
}
pre {
    font-family: courier, monospace;
}
textarea {
    font-family: andale mono, courier, monospace;
}
body {
    font-family: verdana, arial, sans-serif;
    font-size: 14px;
    padding-bottom: 30px;
}
a {
    color: #33c;
}
textarea {
    height: 200px;
    width: 530px;
    font-size: 12px;
    padding: 4px;
}
input {
    padding: 2px 0 2px 3px;
}
input, textarea {
    border: 1px solid #666;
    border-bottom: 1px solid #ccc;
    border-right: 1px solid #ccc;
    margin-bottom: 2px;
}
button {
    width: 538px;
    border: 1px solid #ccc;
    border-bottom: 1px solid #666;
    border-right: 1px solid #666;
    padding: 3px 20px 3px 20px;
}
pre {
    margin-left: 20px;
}
form#sqlarea {
    width: 545px;
    margin-bottom: 10px;
}
p#historyurl {
    text-align:right;
    padding: 0 10px 3px 0;
    font-size: 80%;
}

#login h2 {
    background-color: #999;
    padding: 2px;
    font-size: 12px;
    margin-bottom: 4px;
}
form#login {
    margin: 20px auto 0 auto;
    border: 1px solid #999;
    width: 174px;
    padding-bottom: 6px;
    text-align: center;
}
form#login input {
    width: 150px;
}
form#login button {
    width: 155px;
    padding: 3px 0 3px 0;
}

div.history {
    font-size: 80%;
    padding: 3px 0 3px 0;
    margin: 3px 0 3px 0;
    font-family: andale mono, courier new, courier;
}
div.history h2 {
    font-size: 12px;
}

form#export {
    padding: 20px;
    border:1px solid #666;
    margin-top: 0;
}
form#export h2 {
    font-size: 12px;
    margin: 0;
    padding: 5px 35px 5px 5px;
    background-color: #666;
    color: #fff;
}
form#export button {
    width: 200px;
}
form#export input {
    border:auto;
    padding: 0;
}

ul#dbmenu {
    list-style: none;
    border-right: 1px solid #666;
    border-bottom: 1px solid #666;
    position: absolute;
    left: 0;
    top: 0;
    width: 200px;
    overflow: hidden;
}
li {
    margin-left: 3px;
}
li.title {
    background-color: #669;
    font-weight: bold;
    color: #fff;
    margin-left: 0;
    padding: 3px;
}
.selected {
    font-weight: bold;
}
.pad {
    margin-left: 10px;
}
li.actions {
    border-top: 1px solid #999;
    margin-top: 2px;
    margin-right: 5px;
}
li.footer {
    font-size: 70%;
    font-style: italic;
    text-align: right;
    color: #666;
}
li.footer a {
    color: #666;
}
div#content {
    margin-left: 220px;
    margin-right: 20px;
    padding-top: 10px;
}

table {
    border: 1px solid #ccc;
    border-collapse: collapse;
    font-size: 90%;
    margin-bottom: 10px;
}
th {
    border: 1px solid #ccc;
    background-color: #666;
    color: #fff;
    text-align: left;
    padding: 0 3px 0 3px;
}
tr.odd {
    background-color: #eee;
}
td {
    border: 1px solid #ccc;
    padding: 0 3px 0 3px;
    vertical-align: top;
}
td em {
    color: #aaa;
}
th.primary {
    color: #fef;
}

div.sql {
    font-family: courier, monospace;
    background-color: #eee;
    padding: 5px;
    border: 1px solid #999;
    width: 528px;
    margin-bottom: 2px;
    margin-top: 6px;
}
div.sql em {
    font-family: verdana, arial, sans-serif;
    font-size: 70%;
    font-style: normal;
    color: #777;
}

div.error {
    color: #933;
    font-weight: bold;
    padding: 0;
    border:0;
    background-color: transparent;
    margin-top: 5px;
    font-size: 80%;
}
div.startup_error {
    font-family: verdana, arial, sans-serif;
    width: 548px;
    margin: 10px 0 0 220px;
    background-color: #fee;
    border: 1px solid #933;
    padding: 5px;
}

ul.pager {
    height: 16px;
    list-style: none;
}
ul.pager li {
    float: left;
    padding-right: 4px;
    font-size: 11px;
}
ul.pager li {
    padding: 0 3px 3px 3px;
}
ul.pager li.selected {
    font-weight: bold;
    background-color: #ccc;
}
div.afterpgr {
    clear: both;
    height: 1px;
    overflow: hidden;
}
CSS;
}



function css_compact($css)
{
    $css = preg_replace('/ +/', ' ', $css);
    $css = preg_replace('/(\s*\r?\n)+\s*/m', ' ', $css);
    $css = preg_replace('/([{:;]) /', '\1', $css);
    $css = str_replace(';} ', "}", $css);
    return $css;
}

function process_tinyadm() {
    global $db;
    @session_start();
    remove_magic_quotes();
    if (!isset($_SESSION['user']))          $_SESSION['user'] = '';
    if (!isset($_SESSION['password']))      $_SESSION['password'] = '';
    if (!isset($_SESSION['database']))      $_SESSION['database'] = '';
    if (!isset($_SESSION['table']))          $_SESSION['table'] = '';
    if (!isset($_SESSION['last_sql']))      $_SESSION['last_sql'] = '';
    if (!isset($_SESSION['sql_history'])) $_SESSION['sql_history'] = array();

    $act = get_var('act');

    if ($act == 'login') {
        setcookie('tinymy_user', get_var('user'), time() + 5184000); // 2 months
        $_SESSION['user']      = addslashes(get_var('user'));
        $_SESSION['password'] = addslashes(get_var('password'));
    }

    $db = new sqldb($_SESSION['user'], $_SESSION['password'], $_SESSION['database']);

    if (!$db->is_connected()) {
        return draw_login_form();
    }

    if ($act == 'login') {// switch to default databas
        if (get_cookie('tinymy_database')) {
            $_SESSION['database'] = get_cookie('tinymy_database');
        }
    }

    switch($act) {
    case 'sel_db':
        $_SESSION['database'] = get_var('d');
        $_SESSION['table'] = '';
        setcookie('tinymy_database', get_var('d'), time() + 5184000); // 2 months
        redirect_self();
        exit();
    case 'use_history':
        $idx = (int)get_var('idx');
        if (isset($_SESSION['sql_history'][$idx])) {
            $_SESSION['database'] = $_SESSION['sql_history'][$idx]['db'];
            $_SESSION['last_sql'] = $_SESSION['sql_history'][$idx]['sql'];
        }
        redirect_self();
        exit();
    case 'sel_table':
        $_SESSION['table'] = get_var('table');
        break;
    case 'do_export':
        ob_end_clean(); // we need to pass through the following output from export immediately, without caching
        do_export();
        break;
    case 'logout':
        session_unset();
        session_destroy();
        redirect_self();
        exit();
    case 'exec_sql':
        history_add(get_var('sql'));
    }

    ob_start();// menu needs to be created after the possible sql has executed
    echo '<div id="content">';

    if ($act != 'export' && $act != 'do_export') {
        draw_sqlarea();
    }

    switch($act) {
    case 'history':
        draw_history();
        break;
    case 'export':
        draw_export();
        break;
    case 'sel_db':
        break;
    case 'sel_table':
    case 'show_structure':
        printf('<p style="margin-bottom: 8px;"><a href="?act=show_contents">Show contents of %s</a></p>', htmlspecialchars($_SESSION['table']));
        exec_sql_internal(sprintf('desc `%s`', mysqli_escape_string($db->conn_id, $_SESSION['table'])));
        exec_sql_singlerow(sprintf('show create table `%s`', mysqli_escape_string($db->conn_id, $_SESSION['table'])));

        break;
    case 'show_contents':
        printf('<p style="margin-bottom: 8px;"><a href="?act=show_structure">Show structure of %s</a></p>', htmlspecialchars($_SESSION['table']));
        list($reccount) = mysqli_fetch_row(mysqli_query($db->conn_id, sprintf("select count(*) from `%s`", mysqli_escape_string($db->conn_id, $_SESSION['table']) )));
        pager($reccount);
        exec_sql_internal(sprintf('select * from `%s` %s', mysqli_escape_string($db->conn_id, $_SESSION['table']), pager_limits()));
    case 'exec_sql':
        exec_sql();
        // in case the query changed the database, switch to it
        $cur_database = $db->get_current_database();
        if ($cur_database != $_SESSION['database']) {
            $_SESSION['database'] = $cur_database;
            setcookie('tinymy_database', $cur_database, time() + 5184000); // 2 months
        }
        break;
    }
    echo '</div>'; // content
    $content = ob_get_contents();
    ob_end_clean();

    // menu needs to be created after all the sql has executed
    draw_db_menu();
    echo $content;
}


function remove_magic_quotes()
{
    if( get_magic_quotes_gpc() ) {
        if (is_array($_GET)) {
            foreach($_GET as $k=>$v) {
                $_GET[$k] = stripslashes($v);
            }
        }
        if (is_array($_POST)) {
            foreach($_POST as $k=>$v) {
                $_POST[$k] = stripslashes($v);
            }
        }
    }
}



class sqldb {
    var $conn_id = 0;
    var $serverinfo = '';


    function is_connected()
    {
        return !! $this->conn_id;
    }



    function error($error_text = '')
    {
        if ($error_text == '') {
            printf('<div class="error">%d: %s</div>', @mysqli_errno($this->conn_id), htmlspecialchars(@mysqli_error($this->conn_id)));
        } else {
            printf('<div class="startup_error"><strong>%d: %s</strong><br />%s</div>', @mysqli_errno($this->conn_id), $error_text, htmlspecialchars(@mysqli_error($this->conn_id)));
        }
    }



    function sqldb($user, $password, $dbase)
    {
        global $db_host;
        if ($user != '') {
            $this->conn_id = @mysqli_connect($db_host, $user, $password);
            mysqli_set_charset($this->conn_id, 'utf-8');
            if ($this->conn_id) {
                $this->serverinfo = 'NONE';
                if ($dbase != '') {
                    if (!@mysqli_select_db($this->conn_id, $dbase)) {
                        $this->error("Cannot select database ". htmlspecialchars($dbase));
                        $_SESSION['database'] = '';
                    }
                } else {
                    $dbs = $this->get_databases();
                    if (sizeof($dbs)==1) {
                        if (@mysqli_select_db($this->conn_id, $dbs[0])) {
                            $_SESSION['database'] = $dbs[0];
                        } else {
                            $_SESSION['database'] = '';
                        }
                    }
                }
            }
        }
    }



    function exp_get_row($sql)
    {
        $res = @mysqli_query($this->conn_id, $sql);
        if (!$res) {
            $this->error();
        } else {
            $row = @mysqli_fetch_array($res, MYSQLI_ASSOC);
            @mysqli_free_result($res);
            return $row;
        }
    }


    function get_array($query)
    {
        $output = array();
        if ($this->is_connected()) {
            $list = mysqli_query($this->conn_id, $query);
            while ($row = mysqli_fetch_row($list)) {
                $output[] = $row[0];
            }
        }
        return $output;
    }

    function get_databases()
    {
        $output = $this->get_array('show databases');
        if (!$output) {
            global $default_database;
            if (isset($default_database) and $default_database) {
                $output[] = $default_database;
            }
        }
        return $output;
    }



    function get_tables($database)
    {
        return $this->get_array("show tables from $database");
    }



    function get_current_database()
    {
        $row = $this->get_array('select database()');
        return $row[0];
    }


    function print_blob(&$contents)
    {
        $blob_length = strlen($contents);
        if ($blob_length == 0) {
            return NULL;
        }

        if (BLOB_SKIP_NON_ASCII) {
            $contents = preg_replace('/[^ -~]/', '?', $contents);
        }
        if ($blob_length > BLOB_MAX_SIZE) {

            // we may want to try to find a space to break on it
            $space_found = false;
            for ($i = BLOB_MAX_SIZE - 10; $i < BLOB_MAX_SIZE + 10; $i++) {
                if ($contents[$i] == ' ') {
                    $contents = substr($contents, 0, $i);
                    $space_found = true;
                    break;
                }
            }
            if (!$space_found) {
                $contents = substr($contents, 0, BLOB_MAX_SIZE);
            }
            return sprintf('%s... (%.2fk)', $contents, $blob_length / 1024);
        } else {
            return $contents;
        }

    }


    function query($sql, $process_blob = true) {
        # sure enough, this sucks heavily when blobs are used in resultset, as they are retrieved anyway,
        # but usually I know what I'm doing, and I don't want to do any query preprocessing anyway

        $result = array('failed'=>false, 'rows'=>0, 'rows_affected'=>0, 'result'=>array(), 'field_types'=>array(), 'field_names'=>array(), 'time'=>0);
        if ($this->is_connected()) {

            $start_time = microtime_float();
            $res = @mysqli_query($this->conn_id, $sql);
            $result['time'] = max(microtime_float() - $start_time, 0);

            if (!$res) {
                $this->error();
                $result['failed'] = true;
                return $result;
            }
            $nr = @mysqli_num_rows($res);
            $result['rows'] = $nr ? $nr : 0;
            $result['rows_affected'] = mysqli_affected_rows($this->conn_id);
            for ($i = 0 ; $i < $result['rows']; $i++) {
                $row = mysqli_fetch_row($res);
                if($i == 0) { // populate field_flags
                    $fields = mysqli_fetch_fields($res);
                    for ($j = 0; $j < sizeof($fields); $j++) {
                        $f = $fields[$j];
                        $field_name = $f->name;
                        $field_type = $f->type;
                        $result['field_types'][$field_name] = $field_type;
                        $result['field_types'][$j] = $field_type;
                        $result['field_names'][$j] = $field_name;
                    }
                }
                for($j = 0 ; $j < sizeof($row); $j++) {
                    if ($process_blob) {
                        if ($result['field_types'][$j] == 'blob') {
                            $row[$j] = $this->print_blob($row[$j]);
                        }
                    }
                    if ($result['field_types'][$j] == 'datetime') {
                        if (substr($row[$j], -8) == '00:00:00') {
                            $row[$j] = substr($row[$j], 0, -8);
                        }
                    }
                }
                $result['result'][] = $row;
            }

        }
        return $result;
    }
}


function get_var($name)
{
    return    trim(!empty($_GET[$name]) ? $_GET[$name] : ( !empty($_POST[$name]) ? $_POST[$name] : '' ));
}


function get_cookie($name)
{
    return isset($_COOKIE[$name]) ? htmlspecialchars($_COOKIE[$name]) : '';
}


function draw_login_form()
{
    printf('<form id="login" method="post" action="?"><h2><a style="color:#fff;text-decoration:none;" href="http://elfz.laacz.lv/tinymy/">tinyMy</a></h2><p style="margin:0"><input type="hidden" name="act" value="login" />
        <input id="u" name="user" value="%s"/><input id="p" type="password" name="password" /><button type="submit">Login</button>
        </p></form>
        <script type="text/javascript">
var u = document.getElementById(\'u\');
if (u.value == \'\') u.focus(); else document.getElementById(\'p\').focus();</script>', htmlspecialchars(get_var('user')) ? htmlspecialchars(get_var('user')) : get_cookie('tinymy_user'));
}


function draw_db_menu()
{
    global $db;
    echo '<ul id="dbmenu"><li class="title">' . $db->serverinfo . '</li>';
    $databases = $db->get_databases();
    foreach ($databases as $d) {
        echo '<li' . ($d == $_SESSION['database'] ? ' class="selected"':'') . '><a href="?act=sel_db&amp;d=' . urlencode($d) . '">' . htmlspecialchars($d) . '</a></li>';
        if ($d == $_SESSION['database']) {
            $tables = $db->get_tables($d);
            foreach ($tables as $t) {
                printf('<li class="%s"><a title="%s" href="?act=sel_table&amp;table=%s">%s</a></li>', ($t == $_SESSION['table'] ? 'selected pad':'pad'), htmlspecialchars($t), urlencode($t), htmlspecialchars($t));
            }
        }
    }
    if ($_SESSION['database'] != '') {
        echo '<li class="actions"><a href="?act=export">Export ' . htmlspecialchars($_SESSION['database']) . '</a></li>';
    }
    echo '<li class="actions"><a href="?act=logout">Logout ' . htmlspecialchars($_SESSION['user']) . '</a></li>';
    echo '<li class="footer">Powered by <a href="http://elfz.laacz.lv/tinymy/">tinyMy</a></li>';
    echo '</ul>';
}


function draw_export()
{
    global $db;
    $tables = $db->get_tables($_SESSION['database']);
    echo '<h2>Exporting tables from ' . htmlspecialchars($_SESSION['database']) . '</h2><form id="export" method="post" action="?"><p><input type="hidden" name="act" value="do_export" />';

    $checked_tables = $tables;
    if (get_cookie('tinymy_tables_' . $_SESSION['database'])) {
        $checked_tables = explode(',',get_cookie('tinymy_tables_' . $_SESSION['database']));
    }

    foreach($tables as $table) {
        printf('<label><input type="checkbox" %sname="e_%s" /> %s</label><br />', (FALSE!==array_search($table, $checked_tables)?'checked="checked" ':''), mysqli_escape_string($db->conn_id, $table), htmlspecialchars($table));
    }
    echo '<br /><label><input type="checkbox" checked="checked" name="drop" /> add <em>drop</em> statements</label><br /><br /><button type="submit">Export</button></p></form>';
}


function do_export()
{
    global $db;
    $file_name = $_SESSION['database'] . '_' . date('Ymd') . '.sql';
    header('Content-Type: text/sql');
    $attachment = strstr($_SERVER['HTTP_USER_AGENT'],'MSIE')?'':' attachment;';
    header("Content-Disposition:$attachment filename=$file_name");
    header('Content-Transfer-Encoding: binary');
    $drops = isset($_POST['drop']) && $_POST['drop'] == 'on';

    $tables = array();
    foreach($_POST as $post=>$var) {
        if (substr($post, 0, 2) == 'e_' && $var == 'on') {
            $tables[] = substr($post, 2);
        }
    }

    setcookie('tinymy_tables_' . $_SESSION['database'], implode(',', $tables), time() + 5184000); // 2 months

    echo "-- generated by tinyMy\n\nset names utf8;\n";


    foreach($tables as $table) {
        $table_ue = mysqli_escape_string($db->conn_id, $table);
        echo "\n--\n-- $table\n--\n";

        $test = mysqli_query($db->conn_id, "select 1 from `$table_ue` where 1=0");
        if ($test === FALSE) {
            echo "\n-- unable to access the table $table\n-- ";
            echo str_replace("\n", "\n -- ", mysqli_error());
            echo "\n\n";
        } else {


            if ($drops) {
                echo "\ndrop table if exists $table;";
            }
            $row = $db->exp_get_row("show create table `$table_ue`");
            echo "\n\n{$row['Create Table']};\n\n";

            $res = mysqli_query($db->conn_id, "select * from `$table_ue`");
            while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                $values = array();
                foreach($row as $value) {
                    if ($value === NULL) {
                        $values[] = 'null';
                    } elseif (preg_match('/^\d+(\.\d+)?$/', $value)) {
                        $values[] = $value;
                    } else {
                        $values[] = "'" . mysqli_escape_string($db->conn_id, $value) . "'";
                    }
                }
                printf("insert into %s values (%s);\n", $table, implode(',', $values));
            }
        }
    }
    die();
}


function draw_sqlarea()
{
    $sqltext = get_var('sql');
    if('' == $sqltext) {
        $sqltext = $_SESSION['last_sql'];
    }
    echo '<form id="sqlarea" method="post" action="?">';
    if (sizeof($_SESSION['sql_history'])) {
        echo '<p id="historyurl"><a href="?act=history">History</a></p>';
    }
    printf('<p><input type="hidden" name="act" value="exec_sql" /><textarea id="sql" rows="0" cols="0" name="sql">%s</textarea><br /><button type="submit">Execute SQL%s</button></p></form><script type="text/javascript">document.getElementById(\'sql\').focus();</script>',
        htmlspecialchars($sqltext),
        $_SESSION['database'] == ''?'':htmlspecialchars(" [$_SESSION[database]]"));
}


function format_val($value)
{
    global $null_text;
    if ($value === NULL) return $null_text;
    $value = htmlspecialchars($value);
    $value = str_replace(' ', '&nbsp;', $value);
    if ($value == '') $value = '&nbsp;';
    return $value;
}


function exec_sql()
{
    $sql = get_var('sql');
    if ('' == $sql) return;

    $_SESSION['last_sql'] = $sql;

    // check if the sql is multipart
    // correct the probable formatting errors induced by explode as well i.e. ... where a= ";";
    $now_running = '';
    foreach(explode(';', $sql) as $single_sql) {
        $now_running .= ($now_running == '' ? '' : ';') . $single_sql;
        preg_match_all('/[^\\\\]\'/', $now_running, $matches_sq);
        preg_match_all('/[^\\\\]\"/', $now_running, $matches_dq);
        if ((!isset($matches_sq[0]) || sizeof($matches_sq[0]) % 2 == 0) && (!isset($matches_dq[0]) || sizeof($matches_dq[0]) % 2 == 0)) {
            exec_sql_internal($now_running, true, true);
            $now_running = '';
        }
    }
    if ($now_running != '') {
        exec_sql_internal($now_running, true, true);
    }
}


function exec_sql_singlerow($sql_text = '', $show_stats = false)
{
    global $db;
    $res = $db->query($sql_text);
    if ($res['rows'] > 0) {
        printf('<pre>%s</pre>', htmlspecialchars($res['result'][0][1]));
    }
}


function exec_sql_internal($sql_text = '', $show_stats = false, $show_query = false)
{
    global $db;

    $sql_text = trim($sql_text);

    if (!$sql_text || ';' == $sql_text || substr($sql_text, 0, 2) == '--') return;

    if ($show_query || $show_stats) {
        echo '<div class="sql">';
    }

    if ($show_query) echo nl2br(htmlspecialchars($sql_text)) . '<br />';

    $res = $db->query($sql_text);

    if ($show_stats && !$res['failed']) {
        echo '<em>Ok';
        if ($res['rows']) {
            if ($res['rows'] != $res['rows_affected']) {
                printf(', rows: %d', $res['rows']);
            }
        }
        if ($res['rows_affected']) {
            printf(', rows affected: %d', $res['rows_affected']);
        }
        if ($res['time']) {
            printf(', time: %.3f s', $res['time']);
        }
        echo '</em>';
    }


    if ($show_query || $show_stats) {

        echo '</div>';
    }

    if (!$res['failed']) {

        if ($res['rows'] != 0) {
            echo '<table class="result"><tr>';
            foreach($res['field_names'] as $title) {
                echo '<th>' . htmlspecialchars($title) . '</th>';
            }
            echo '</tr>';

            $odd = true;
            for ($i = 0 ; $i < $res['rows']; $i++) {
                printf('<tr%s>', $odd ? ' class="odd"':'');
                $odd = !$odd;
                foreach($res['result'][$i] as $title=>$value) {
                    printf('<td>%s</td>', format_val($value));
                }
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p style="font-size: 70%;padding-left: 5px; margin-bottom: 10px;">Query executed, but returned no result.</p>';
        }
    }
}


function pager($records, $records_pp = 50, $break_on_page = 15)
{
    if ($records == 0) return;

    $cur = (int)get_var('p');

    $uri = '?';
    foreach($_GET as $var=>$val) {
        if ($var != 'p') {
            $uri .= $var . '=' . urlencode($val) . '&amp;';
        }
    }

    if ($records < $records_pp) return;
    echo '<ul class="pager">';

    // adjust start page, if neccessary
    $total_pages = (int)($records / $records_pp + 0.5);
    $start_page = 0;
    if ($total_pages > $break_on_page) {
        if ($total_pages - $cur < $break_on_page / 2) {
            $start_page = $total_pages - $break_on_page;
        } else {
            $start_page = $cur - (int)($break_on_page / 2);
            if ($start_page < 0) {
                $start_page = 0;
            }
        }
    }

    $page = $start_page;
    $start_rec = $page * $records_pp + 1;

    $broken = false;
    while ($start_rec < $records + 1) {
        printf('<li%s><a href="%sp=%d">%d</a></li>', ($page == $cur ? ' class="selected"':''), $uri, $page, $page + 1);
        $start_rec += $records_pp;
        $page++;
        if ($page == $break_on_page + $start_page + 1) {
            $broken = true;
            break;
        }

    }
    if ($broken) {
        echo "<li class=\"recordcount\">" . (1 + $total_pages) . ' ' . format_numeric(1 + $total_pages, "page", "pages") . ", $records " . format_numeric($records, 'record', 'records') . "</li>";
    } else {
        echo "<li class=\"recordcount\">$records " . format_numeric($records, 'record', 'records') . "</li>";
    }

    echo '</ul>';
    echo '<div class="afterpgr">&nbsp;</div>';

}


function pager_limits($records_pp = 50)
{
    $cur = (int)get_var('p');
    if ($cur == 0) return " limit $records_pp ";
    return ' limit ' . $records_pp . ' offset ' . $records_pp * $cur . ' ';
}


function format_numeric($num, $single, $multiple)
{
    return sprintf(($num % 10 == 1 && $num % 100 != 11) ? $single : $multiple, $num);
}


function history_add($sql)
{
    if ($sql) {
        $item = array('sql'=>$sql, 'db'=>$_SESSION['database']);
        $idx = array_search($item, $_SESSION['sql_history']);
        if ($idx !== FALSE) {
            unset($_SESSION['sql_history'][$idx]);
        }
        $_SESSION['sql_history'][] = $item;
    }
}


function draw_history()
{
    $n = sizeof($_SESSION['sql_history']) - 1;
    $lastdb = NULL;
    foreach(array_reverse($_SESSION['sql_history']) as $sql) {
        echo '<div class="history">';
        $db = $sql['db'] ? $sql['db'] : 'no database';
        if ($db == $lastdb) {
            printf('<a href="?act=use_history&amp;idx=%d">%s</a>', $n, nl2br(htmlspecialchars($sql['sql'])));
        } else {
            printf('<h2>%s</h2><a href="?act=use_history&amp;idx=%d">%s</a>', $db, $n, nl2br(htmlspecialchars($sql['sql'])));
        }
        $lastdb = $db;
        --$n;
        echo '</div>';
    }
}
function redirect_self()
{
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

?>
