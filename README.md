phing-ftp-up-down
=================
need specification require file phing/Task.php

example in build.xml

```<?xml version="1.0" encoding="UTF-8"?>
<project name="FtpDownUp" basedir="." default="download">
<taskdef name="ftpdownload" classname="ftpdownload"/>
<taskdef name="ftpupload" classname="ftpupload"/>

<target name="download">
    <ftpdownload url="ftp://user:pass@ftpserver/path" localdir="./dirToCopy" />
</target>

<target name="upload">
    <ftpupload url="ftp://user:pass@ftpserver/path" localdir="./dirToCopy" />
</target>

</project>```