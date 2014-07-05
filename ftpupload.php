<?php

require_once "./phing/Task.php";
require_once "ftp.php";

class FtpUpload extends Task {

    private $url;
    private $localDir = "./";

    public function setUrl($url) {
        $this->url = $url;
    }

    public function setLocalDir(PhingFile $dir) {
        $this->localDir = $dir;
    }

    /**
     * The init method: Do init steps.
     */
    public function init() {
        //overeni ftpsync
        if (!class_exists("Ftp")) {
            throw new Exception("neni trida ftpsync");
        }
    }

    /**
     * The main entry point method.
     */
    public function main() {
        $ftp = new Ftp($this->url);

        $absolutePath = $this->localDir->getAbsolutePath()."/";
        $records = $this->listDir($absolutePath);
        
        foreach ($records as $record) {
            if (is_dir($absolutePath.$record)) {
                $ftp->mkDirRecursive($record);
                continue;

            }

            //upload
            $remote_change = $ftp->mdtm($record);
            $local_change = filemtime($absolutePath.$record);
            if ($remote_change == $local_change) {
                $this->log("file ".$record." is same");
            } else if ($remote_change > $local_change) {
                $this->log("file ".$record." is newer on ftp");
            } else {
                $ftp->put($record, $absolutePath.$record, $ftp::BINARY);
                $this->log("upload file ".$record);
            }

        }
        
        //$count = $ftp->download(".", $this->localDir->getAbsolutePath());
        $ftp->close();
        //$this->log("All files (".$count.") has been copied");
    }

    private function listDir($dirPath, $basePath = "/") {
        $records = array();
        if ($handle = opendir($dirPath)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $records[] = ".".$basePath."$entry";

                    if (is_dir($dirPath."/".$entry)) {
                        $records = array_merge($records, $this->listDir($dirPath."/".$entry, $basePath.$entry."/"));
                    }
                }
            }
            closedir($handle);
        }

        return $records;
    }
}

?>