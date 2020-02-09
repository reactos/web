# ReactOS Website Subsystems

This repository contains all subsystems of the ReactOS Website (www.reactos.org).
This includes third-party components such as the phpBB forum and MediaWiki Wiki, but also custom developments like GetBuilds, RosLogin, RosWeb, and Testman.

If you are looking for the content of the ReactOS Website, check out the [web-content](https://github.com/reactos/web-content) repository.

## Folder structure
* **resources**  
  Contains additional resources for the subsystems (like graphics templates or SQL schemas).
  These won't end up on the web server.

* **web**  
  Everything in here will end up on the web server, resembling the exact directory structure.

  * **web/www.reactos.org**  
    The document root of the web server for subsystems. All subfolders in here will be visible to the public through HTTPS URLs.

  * **web/www.reactos.org_config**  
    Internal config files that also end up on the web server, but will only be available to the subsystems and not through public HTTPS URLs.

  * **web/www.reactos.org_content**  
     The document root of the web server for Hugo-generated content of the [web-content](https://github.com/reactos/web-content) repository.
     All files and folders in here will be visible to the public through HTTPS URLs.

## Web Server Configuration
The nginx web server of reactos.org is configured to check the URL for the few subfolders of *web/www.reactos.org*.
If one of these folders is requested, it will look inside *web/www.reactos.org* and enable PHP.
For all other requests, the content will be fetched from *web/www.reactos.org_content* (without any PHP support).
