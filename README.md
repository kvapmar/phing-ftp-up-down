phing-ftp-up-down
=================
need specification require file phing/Task.php

example in build.xml

```xml
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;project name="FtpDownUp" basedir="." default="download"&gt;
&lt;taskdef name="ftpdownload" classname="ftpdownload"/&gt;
&lt;taskdef name="ftpupload" classname="ftpupload"/&gt;

&lt;target name="download"&gt;
    &lt;ftpdownload url="ftp://user:pass@ftpserver/path" localdir="./dirToCopy" /&gt;
&lt;/target&gt;

&lt;target name="upload"&gt;
    &lt;ftpupload url="ftp://user:pass@ftpserver/path" localdir="./dirToCopy" /&gt;
&lt;/target&gt;

&lt;/project&gt;
```