<?php
require($_SERVER['DOCUMENT_ROOT'].'/system/includes/dboperations.php');
class MySQLDump {


	/**
	 * Dump data and structure from MySQL database
	 *
	 * @param string $db
	 * @return string
	 */
	function dumpDatabase($db) {

		// Set content-type and charset
		header ('Content-Type: text/html; charset=iso-8859-1');		

		// Connect to database
		$db = @mysql_select_db($db);
                $data = "";
                $structure = "";
		if (!empty($db)) {

			// Get all table names from database
			$c = 0;
			$result = mysql_list_tables($db);
			for($x = 0; $x < mysql_num_rows($result); $x++) {
				$table = mysql_tablename($result, $x);
				if (!empty($table)) {
					$arr_tables[$c] = mysql_tablename($result, $x);
					$c++;
				}
			}

			// List tables
			$dump = '';
			for ($y = 0; $y < count($arr_tables); $y++){

				// DB Table name
				$table = $arr_tables[$y];
                                
				// Structure Header
				$structure .= "-- \n";
				$structure .= "-- Table structure for table `{$table}` \n";
				$structure .= "-- \n\n";

				// Dump Structure
				$structure .= "DROP TABLE IF EXISTS `{$table}`; \n";
				$structure .= "CREATE TABLE `{$table}` (\n";
				$result = mysql_db_query($db, "SHOW FIELDS FROM `{$table}`");
				while($row = mysql_fetch_object($result)) {

					$structure .= "  `{$row->Field}` {$row->Type}";
					$structure .= (!empty($row->Default)) ? " DEFAULT '{$row->Default}'" : false;
					$structure .= ($row->Null != "YES") ? " NOT NULL" : false;
					$structure .= (!empty($row->Extra)) ? " {$row->Extra}" : false;
					$structure .= ",\n";

				}

				$structure = ereg_replace(",\n$", "", $structure);

				// Save all Column Indexes in array
				unset($index);
				$result = mysql_db_query($db, "SHOW KEYS FROM `{$table}`");
				while($row = mysql_fetch_object($result)) {

					if (($row->Key_name == 'PRIMARY') AND ($row->Index_type == 'BTREE')) {
						$index['PRIMARY'][$row->Key_name] = $row->Column_name;
					}

					if (($row->Key_name != 'PRIMARY') AND ($row->Non_unique == '0') AND ($row->Index_type == 'BTREE')) {
						$index['UNIQUE'][$row->Key_name] = $row->Column_name;
					}

					if (($row->Key_name != 'PRIMARY') AND ($row->Non_unique == '1') AND ($row->Index_type == 'BTREE')) {
						$index['INDEX'][$row->Key_name] = $row->Column_name;
					}

					if (($row->Key_name != 'PRIMARY') AND ($row->Non_unique == '1') AND ($row->Index_type == 'FULLTEXT')) {
						$index['FULLTEXT'][$row->Key_name] = $row->Column_name;
					}

				}

				// Return all Column Indexes of array
				if (is_array($index)) {
					foreach ($index as $xy => $columns) {

						$structure .= ",\n";

						$c = 0;
						foreach ($columns as $column_key => $column_name) {

							$c++;

							$structure .= ($xy == "PRIMARY") ? "  PRIMARY KEY  (`{$column_name}`)" : false;
							$structure .= ($xy == "UNIQUE") ? "  UNIQUE KEY `{$column_key}` (`{$column_name}`)" : false;
							$structure .= ($xy == "INDEX") ? "  KEY `{$column_key}` (`{$column_name}`)" : false;
							$structure .= ($xy == "FULLTEXT") ? "  FULLTEXT `{$column_key}` (`{$column_name}`)" : false;

							$structure .= ($c < (count($index[$xy]))) ? ",\n" : false;

						}

					}

				}

				$structure .= "\n);\n\n";

				// Header
				$structure .= "-- \n";
				$structure .= "-- Dumping data for table `$table` \n";
				$structure .= "-- \n\n";

				// Dump data
				unset($data);
				$result     = mysql_query("SELECT * FROM `$table`");
				$num_rows   = mysql_num_rows($result);
				$num_fields = mysql_num_fields($result);
                                $data = "";
				for ($i = 0; $i < $num_rows; $i++) {
                                        
					$row = mysql_fetch_object($result);
					$data .= "INSERT INTO `$table` (";

					// Field names
					for ($x = 0; $x < $num_fields; $x++) {

						$field_name = mysql_field_name($result, $x);

						$data .= "`{$field_name}`";
						$data .= ($x < ($num_fields - 1)) ? ", " : false;

					}

					$data .= ") VALUES (";

					// Values
					for ($x = 0; $x < $num_fields; $x++) {
						$field_name = mysql_field_name($result, $x);

						$data .= "'" . str_replace('\"', '"', mysql_escape_string($row->$field_name)) . "'";
						$data .= ($x < ($num_fields - 1)) ? ", " : false;

					}

					$data.= ");\n";
				}

				$data.= "\n";

				$dump .= $structure . $data;
				$dump .= "-- --------------------------------------------------------\n\n";

			}

			return $dump;

		}

	}

}

?>
