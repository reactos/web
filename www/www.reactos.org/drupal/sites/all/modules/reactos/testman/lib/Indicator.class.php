<?php
/*
  PROJECT:    ReactOS Web Test Manager
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Health indicator
  COPYRIGHT:  Copyright 2009 Alwyn Tan <alwyn.tan@gmail.com>
*/

	require_once("config.inc.php");
    require_once("connect.db.php");
    
    class Indicator
    {
        public $imagePath;
        private $id;
        
        public function __construct($id)
        {
            if($id <= 0)
                die("invalid id");
                
            $this->id = $id;
        
            $this->imagePath = INDICATORS_PATH."$id.png";
            
            if(file_exists($this->imagePath))
                return;

            $this->generateImage();
        }
    
        private function doColour(&$status, &$tests, &$failures)
        {
            if($status !== 'ok')
            {
                return array(0, 0, 0);
            }
            else if($failures >= $tests)
            {
                return array(255, 0, 0);
            }
            else if($failures == 0 || $tests == 0)
            {
                return array(0, 255, 0);
            }

            $offset = intval($failures * 255 / $tests);

            return array(255, 255 - $offset, 0);
        }
        
        private function generateImage()
        {
            try
            {
                $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_TESTMAN, DB_USER, DB_PASS);
            }
            catch(PDOException $e)
            {
                // Give no exact error message here, so no server internals are exposed
                die("<error>Could not establish the DB connection</error>");
            }

            $height = 20;
            $resultwidth = 1;
            $width = 334;

            $i = 0;
            $image = imagecreatetruecolor($width, $height);
            $colour = imagecolorallocate($image, 255, 255, 255);
            imagefill($image, 0, 0, $colour);

            $stmt = $dbh->prepare("SELECT status, count, failures FROM winetest_results WHERE test_id = :test_id");
            $stmt->bindParam(":test_id", $this->id, PDO::PARAM_INT);
            $stmt->execute() or die("indicator DB error #1");

            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $result = $this->doColour($row["status"], $row["count"], $row["failures"]);
                $offset = $i * $resultwidth;
                $colour = imagecolorallocate($image,$result[0],$result[1],$result[2]);
                imagefilledrectangle($image,$offset,0,$offset + ($resultwidth-1),$height-1,$colour);

                ++$i;
            }

            imagepng($image, $this->imagePath);
            imagedestroy($image);
        }
    }
?>
