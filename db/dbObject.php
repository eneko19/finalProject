<?php

class dbObject {

    const MAX_BATCH_SIZE = 100;

    private $db;
    private $batchHolder     = [];
    private static $instance = NULL;
    private $tables          = [];

    // Getters and Setters

    function setDbCon($db) {
        /* @var $db mysqli */
        self::getInstance()->db = $db;
    }

    function getTables() {
        return self::getInstance()->tables;
    }

    function setTables($tables) {
        self::getInstance()->tables = $tables;
    }

    // Constructor

    private function __construct() {

    }

    // Functions
    /**
     *
     * @return \self
     */
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function escapeString($values) {
        if (is_array($values)) {
            echo '<pre>' . print_r($values, 1) . '</pre>';
        }
        return mysqli_real_escape_string(self::getInstance()->db->getMysqliObject(), $values);
    }

    public function insertRow($tableName, array $changes) {
        $consulta = "INSERT INTO {$tableName} (" . implode(", ", array_keys($changes)) . ") VALUES (" . "'" . implode("','", array_map(array(self::getInstance(), 'escapeString'), $changes)) . "'" . ");";

        if (self::getInstance()->db->query($consulta) === true) {
//            echo "OK.";
            return mysqli_insert_id(self::getInstance()->db);
        } else {
            echo "<br>Error INSERT INTO {$tableName} (" . implode(", ", array_keys($changes)) . ") VALUES (" . "'" . implode("','", $changes) . "'" . "); " . self::getInstance()->db->error;
        }
    }

// Save insert values into an array to make 1 query insert per 100 lines
    public function addToBatch($tableName, array $changes, $batchSize = null) {
        $values = array_values($changes);
        $fields = array_keys($changes);

        if (!array_key_exists($tableName, self::getInstance()->batchHolder)) {
            self::getInstance()->prepareBatchHolderForTable($tableName, $fields);
        }
        array_push(self::getInstance()->batchHolder[$tableName]['values'], "'" . implode("','", array_map(array(self::getInstance(), 'escapeString'), $changes)) . "'");

        if (!empty($batchSize)) {
            if (count(self::getInstance()->batchHolder[$tableName]['values']) >= $batchSize) {
                self::getInstance()->processBatch($tableName);
                self::getInstance()->prepareBatchHolderForTable($tableName, $fields);
            }
        } else {
            if (count(self::getInstance()->batchHolder[$tableName]['values']) >= self::MAX_BATCH_SIZE) {
                self::getInstance()->processBatch($tableName);
                self::getInstance()->prepareBatchHolderForTable($tableName, $fields);
            }
        }
    }

    // Saving fields and values on an associative array
    private function prepareBatchHolderForTable($tableName, $fields) {
        self::getInstance()->batchHolder[$tableName]           = [];
        self::getInstance()->batchHolder[$tableName]['fields'] = '(`' . implode('`,`', $fields) . '`)';
        self::getInstance()->batchHolder[$tableName]['values'] = [];
    }

    public function processBatch($tableNameParam = NULL) {
        $processData = is_null($tableNameParam) ? self::getInstance()->batchHolder : [$tableNameParam => self::getInstance()->batchHolder[$tableNameParam]];
        foreach ($processData as $tableName => $content) {
            $fields    = $content['fields'];
            $strFields = str_replace("Array", "", self::getInstance()->onDuplicateKeyFields($fields));
            $values    = implode('),(', $content['values']);
            if (!empty($values)) {
                $query        = "INSERT INTO " . Connection::getDatabase() . ".{$tableName} "
                        . "{$fields} VALUES "
                        . "({$values}) ON DUPLICATE KEY UPDATE "
                        . "{$strFields};";
                $insertedRows = self::getInstance()->executeQuery($query);
                $suppUrl      = PAGES . DS . 'suppliersStaticData' . DS . Connection::getDatabase() . '.txt';
                $fileSize     = 0;
                if (file_exists($suppUrl)) {
                    $fileSize = filesize($suppUrl);
                }
                if ($fileSize > 100000000) {
                    file_put_contents($suppUrl, "");
                }
                $suppStaticDataRegistry = fopen($suppUrl, 'a+');
                fwrite($suppStaticDataRegistry, "Affected rows: " . $insertedRows . " on {$tableName} " . PHP_EOL);
                fclose($suppStaticDataRegistry);
//                echo "Affected rows: " . $insertedRows . " on {$tableName} " . PHP_EOL;
            }
        }
        if (is_null($tableNameParam)) {
            self::getInstance()->batchHolder = [];
        }
    }

    public function executeQuery($query) {
        if (!self::getInstance()->db->doQuery($query)) {
            return mysqli_error(self::getInstance()->db->getMysqliObject());
        }
        return 'T: ' . date('Y-m-d H:i:s') . ' ' . self::getInstance()->db->getMysqliObject()->affected_rows;
    }

    public function doQuery($query) {
        $result = self::getInstance()->db->doQuery($query);
        $arrRes = [];
        if (!$result) {
            return mysqli_error(self::getInstance()->db->getMysqliObject());
        }
        while ($row = $result->fetch_row()) {
            array_push($arrRes, $row[0]);
        }
        return $arrRes;
    }

    public function queryAssoc($query) {
        $result = self::getInstance()->db->doQuery($query);
        $arrRes = [];
        if (!$result) {
            return mysqli_error(self::getInstance()->db->getMysqliObject());
        }
        while ($row = $result->fetch_assoc()) {
            array_push($arrRes, $row);
        }
        return $arrRes;
    }

    public function hotelQuery($supplier, $query) {
        $result = self::getInstance()->db->doQuery($query);
        $arrRes = [];
        if (!$result) {
            return mysqli_error(self::getInstance()->db->getMysqliObject());
        }
        while ($row = $result->fetch_assoc()) {
            $row['supplier'] = $supplier;
            array_push($arrRes, $row);
        }
        return $arrRes;
    }

    public function charactQuery($query) {
        $result = self::getInstance()->db->doQuery($query);
        $arrRes = [];
        if (!$result) {
            die('No hay resultados');
        }
        while ($row = $result->fetch_assoc()) {
            $group = [];
            if (!empty($row['charactType'])) {
                $group['charactType'] = $row['charactType'];
            }
            if (!empty($row['characteristic'])) {
                $group['characteristic'] = $row['characteristic'];
            }
            if (!empty($row['charactTypeId'])) {
                $group['charactTypeId'] = $row['charactTypeId'];
            }
            if (!empty($row['characteristicId'])) {
                $group['characteristicId'] = $row['characteristicId'];
            }
            array_push($arrRes, $group);
        }
        return $arrRes;
    }

    public function imageQuery($query) {
        $result = self::getInstance()->db->doQuery($query);
        $arrRes = [];
        if (!$result) {
            die('No hay resultados');
        }
        while ($row = $result->fetch_assoc()) {
            $group = [];
            if (!empty($row['imageType'])) {
                $group['imageType'] = $row['imageType'];
            }
            if (!empty($row['url'])) {
                $group['url'] = $row['url'];
            }
            array_push($arrRes, $group);
        }
        return $arrRes;
    }

    public function descQuery($query, $en = null) {
        $result = self::getInstance()->db->doQuery($query);
        $arrRes = [];
        if (!$result) {
            die('No hay resultados');
        }
        while ($row = $result->fetch_assoc()) {
            $group = [];
            if ($en) {
                if (!empty($row['desc_en'])) {
                    return $row;
                }
            } else {
                if (!empty($row['desc_es'])) {
                    return $row;
                }
            }
        }
    }

    public function queryEstablishments($query) {
        $result = self::getInstance()->db->doQuery($query);
        $arrRes = [];
        if (!$result) {
            return mysqli_error(self::getInstance()->db->getMysqliObject());
        }
        while ($row = $result->fetch_row()) {
            array_push($arrRes, ['CountryId' => $row[0], 'ProvinceId' => $row[1], 'LocationId' => $row[2], 'Language' => ['en', 'es']]);
        }
        return $arrRes;
    }

    public function saveHotelIds($hotel) {
        $queries  = Registry::get('SAVE_BIND_IDS');
        $bind_id  = $hotel->getBind_id();
        $name     = $hotel->getName();
        $address  = $hotel->getAddress();
        $country  = $hotel->getCountryId();
        $supplier = $hotel->getSupplier();
        $hotelId  = $hotel->getHotelId();
        $preQuery = $queries[$supplier];
        if ($supplier == 'travelgate') {
            $subSupp = $hotel->getSubsupplier();
            $query   = str_replace('hotelid', $hotelId, str_replace('bindid', $bind_id, str_replace('subsuppcode', $subSupp, $preQuery)));
        } else {
            $query = str_replace('hotelid', $hotelId, str_replace('bindid', $bind_id, $preQuery));
            if (empty($bind_id)) {
                $query = str_replace('hotelid', $hotelId, str_replace(NULL, $bind_id, $preQuery));
            }
        }

        echo dbObject::getInstance()->executeQuery($query);
    }

    private function onDuplicateKeyFields($fields) {
        $cleanFields  = substr(substr($fields, 2), 0, -2);
        $fieldsString = explode("`,`", $cleanFields);
        $fStr         = "";
        foreach ($fieldsString as $f) {
            $fStr .= $f . " = values({$f}),";
        }
        $fStr = substr($fStr, 0, -1);
        return $fStr;
    }

    public function deleteObsoleteData(array $tableName) {
        echo "Deleting old data";
        foreach ($tableName as $table) {
            $query  = "DELETE FROM " . Connection::getDatabase() . ".{$table} WHERE ACTIVE = 0";
            self::getInstance()->executeQuery($query);
            $result = self::getInstance()->executeQuery($query);
            if ($result != 0) {
                echo "{$result} rows deleted on {$table}";
            }
        }
    }

    public static function setActiveToZero(array $tableName, $subSupplier = false) {
        self::getInstance()->setTables($tableName);
        $condition = $subSupplier === false ? "" : "AND SUPPLIER = '{$subSupplier}'";
        $toZeroTxt = fopen(PAGES . DS . "tablesToZero.txt", "a+");
        foreach ($tableName as $table) {
            $query   = "UPDATE " . Connection::getDatabase() . ".{$table} SET ACTIVE = 0 WHERE 1=1 {$condition};";
            $result  = self::getInstance()->executeQuery($query);
            $message = PHP_EOL . $query;
            if (!$result && $result !== 0) {
                $message += mysqli_error(self::getInstance()->db->getMysqliObject()) . "<br>";
            }
            fwrite($toZeroTxt, $message);
        }
        fclose($toZeroTxt);
    }

    public static function updateNumActives() {
        $database       = Connection::getDatabase();
        $tablesModified = self::getInstance()->getTables();
        $dataSupplier   = [];
        foreach ($tablesModified as $table) {
            $query        = "SELECT sum(ACTIVE) as numActives, count(ACTIVE)-sum(ACTIVE) AS numInactives, LAST_UPDATE as lastUpdate, count(ACTIVE) as totalRes FROM {$database}.{$table} ORDER BY LAST_UPDATE DESC limit 1;";
            $result       = self::getInstance()->queryAssoc($query);
            $nActives     = $result[0]['numActives'];
            $nResults     = $result[0]['totalRes'];
            $perc         = $nResults && $nActives ? number_format(($nActives / $nResults) * 100, 2) : 0;
            $dataSupplier = [
                'DB_SUPP'      => $database,
                'TABLE_SUPP'   => $table,
                'N_ACTIVES'    => $result[0]['numActives'],
                'N_INACTIVES'  => $result[0]['numInactives'],
                'PERC_ACTIVES' => $perc . '%',
                'LAST_UPDATE'  => $result[0]['lastUpdate']
            ];
            Connection::setDatabase(DB_BINDR);
            self::getInstance()->addTobatch('active_supplier_data', $dataSupplier);
        }
        self::getInstance()->processBatch();
    }

    public static function updateRow($table, array $rows, $condition = "") {
        $str = "";
        foreach ($rows as $row => $value) {
            $str .= $row. " = \"" . $value . "\", ";
        }
        $values = substr($str, 0, -2);
        $query = "UPDATE {$table} SET {$values} {$condition};";
        echo self::getInstance()->db->doQuery($query);
    }

    public static function deleteRow($table, $condition = ""){
        $query = "DELETE FROM {$table} {$condition}";
        echo self::getInstance()->db->doQuery($query);
    }

    public static function updateMapping($data, $where) {
        self::getInstance()->updateRow('dataBindr.mapped_supplier', $data, $where);
    }

}
