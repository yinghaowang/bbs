<?php
class DB
{
    public function connect($host, $host_user, $host_pass, $host_dbname, $host_code, $connect = false)
    {
        if ($connect == false) {
            $conn = @mysql_connect("$host", "$host_user", "$host_pass") or die(Error::debug('MYSQL连接错误,请检查config.php配置文件！'));
        } else {
            $conn = @mysql_pconnect("$host", "$host_user", "$host_pass") or die(Error::debug('MYSQL连接错误,请检查config.php配置文件！'));
        }
        mysql_select_db("$host_dbname", $conn);
        mysql_query("set names '$host_code'");
    }
    public function fetchArray($query)
    {
        return mysql_fetch_array($query, MYSQL_ASSOC);
    }
    public function fetchRow($query)
    {
        $query = mysql_fetch_row($query);
        return $query;
    }
    public function selectOneArray($query)
    {
        $result = $this->query($query);
        $record = $this->fetchArray($result);
        return $record;
    }
    public function selectOne($query)
    {
        $result = $this->query($query);
        $record = $this->fetchRow($result);
        return $record[0];
    }
    public function selectAll($sql)
    {
        $arr   = array();
        $query = $this->query($sql);
        while ($rows = $this->fetchArray($query)) {
            $arr[] = $rows;
        }
        unset($rows);
        return $arr;
    }
    public function query($sql, $type = MYSQL_DEBUG)
    {
        $query = mysql_query($sql);
        if (!$query && $type == true) {
            Error::debug('MySQL Query Error: ' . $sql);
        }
        return $query;
    }
    public function compile_db_insert_string($data)
    {
        $field_names  = '';
        $field_values = '';
        foreach ($data as $k => $v) {
            $field_names .= "{$k},";
            $field_values .= "'{$v}',";
        }
        $field_names  = preg_replace('/,$/', '', $field_names);
        $field_values = preg_replace('/,$/', '', $field_values);
        return array(
            'FIELD_NAMES'   => $field_names,
            'FIELD_VALUES'  => $field_values
        );
    }
    public function compile_db_update_string($data)
    {
        $return_string = '';
        foreach ($data as $k => $v) {
            if (is_array($v)) {
                $return_string .= (($k . '=') . $v['0']) . ',';
            } else {
                $return_string .= (($k . '=\'') . $v) . '\',';
            }
        }
        $return_string = preg_replace('/,$/', '', $return_string);
        return $return_string;
    }
    public function insert($tbl, $arr)
    {
        $dba = $this->compile_db_insert_string($arr);
        $sql = "INSERT INTO {$tbl} ({$dba['FIELD_NAMES']}) VALUES ({$dba['FIELD_VALUES']})";
        return $sql;
    }
    public function update($tbl, $arr, $where = '')
    {
        $dba   = $this->compile_db_update_string($arr);
        $query = "UPDATE {$tbl} SET {$dba}";
        if ($where) {
            $query .= ' WHERE ' . $where;
        }
        return $query;
    }
    public function affectedRows($sql)
    {
        $this->query($sql);
        return mysql_affected_rows();
    }
    public function lastInsertId()
    {
        return mysql_insert_id();
    }
    public function mysql_colse()
    {
        mysql_close();
    }
    public function __destruct()
    {
        $this->mysql_colse();
    }
}
?>