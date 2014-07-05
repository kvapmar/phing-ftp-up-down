<?php

require_once "./phing/Task.php";
require_once "ftp.php";

class FtpDownLoad extends Task {

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
        $count = $ftp->download(".", $this->localDir->getAbsolutePath());
        $ftp->close();
        $this->log("All files (".$count.") has been copied");
    }
}

?>