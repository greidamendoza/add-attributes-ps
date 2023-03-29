<?php 
class Csv{

	private $csv_file_name;

	public function __construct($csv_file_name)
	{
		$this->csv_file_name = $csv_file_name;
	}

	private function checkDelimiter()
	{
		$delimiters = [";" => 0, "," => 0, "\t" => 0, "|" => 0];

		$handle = fopen($this->csv_file_name, "r");
		$firstLine = fgets($handle);
		fclose($handle); 
		foreach ($delimiters as $delimiter => &$count) {
			$count = count(str_getcsv($firstLine, $delimiter));
		}

		return array_search(max($delimiters), $delimiters);
	}

	public function csvToArray()
	{
		$result = array();
		$csv = file($this->csv_file_name);
		foreach($csv as $line) {
			$result[] =  str_getcsv($line, $this->checkDelimiter());  
		}

		return $result;
	}

}
?>