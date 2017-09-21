<?php
/*
 * PROJECT:     ReactOS Testman
 * LICENSE:     GPL-2.0+ (https://spdx.org/licenses/GPL-2.0+)
 * PURPOSE:     Health Indicator
 * COPYRIGHT:   Copyright 2009 Alwyn Tan (alwyn.tan@gmail.com)
 *              Copyright 2011-2017 Colin Finck (colin@reactos.org)
 */

	class Indicator
	{
		// Member Constants
		private $_HEIGHT = 20;
		private $_RESULTWIDTH = 1;
		private $_WIDTH = 334;

		// Member Variables
		private $_id;
		private $_image_path;

		// Private Functions
		private function _doColour(&$status, &$tests, &$failures)
		{
			if ($status !== 'ok')
			{
				return array(0, 0, 0);
			}
			else if ($failures >= $tests)
			{
				return array(255, 0, 0);
			}
			else if ($failures == 0 || $tests == 0)
			{
				return array(0, 255, 0);
			}

			$offset = intval($failures * 255 / $tests);
			return array(255, 255 - $offset, 0);
		}

		private function _generateImage()
		{
			$dbh = new PDO("mysql:host=" . TESTMAN_DB_HOST . ";dbname=" . TESTMAN_DB_NAME, TESTMAN_DB_USER, TESTMAN_DB_PASS);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$i = 0;
			$image = imagecreatetruecolor($this->_WIDTH, $this->_HEIGHT);
			$colour = imagecolorallocate($image, 255, 255, 255);
			imagefill($image, 0, 0, $colour);

			$stmt = $dbh->prepare("SELECT status, count, failures FROM winetest_results WHERE test_id = :test_id");
			$stmt->bindParam(":test_id", $this->_id);
			$stmt->execute();

			while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== FALSE)
			{
				$result = $this->_doColour($row["status"], $row["count"], $row["failures"]);
				$offset = $i * $this->_RESULTWIDTH;
				$colour = imagecolorallocate($image, $result[0], $result[1], $result[2]);
				imagefilledrectangle($image, $offset, 0, $offset + ($this->_RESULTWIDTH - 1), $this->_HEIGHT - 1, $colour);

				$i++;
			}

			imagepng($image, $this->_image_path);
			imagedestroy($image);
		}

		// Public Functions
		public function __construct($id)
		{
			if($id <= 0)
				throw new RuntimeException("Invalid ID");

			$this->_id = $id;
			$this->_image_path = INDICATORS_PATH . "$id.png";

			if (file_exists($this->_image_path))
				return;

			$this->_generateImage();
		}

		public function getImagePath()
		{
			return $this->_image_path;
		}
	}
