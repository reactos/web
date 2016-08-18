phpBBforum Integration module
==============================================================================
phpBBforum Integration module (C) 2007-2012 by Vadim G.B. (http://vgb.org.ru)
==============================================================================

phpBBforum Integration module provides integration with phpBB3 Forum
http://www.phpbb.com/.

The module requires php5 to run.

The following blocks are provided to integrate phpBB with your Drupal site:

1) phpBBforum: Hidden authentication
   Allows forum users to login to your Drupal site and provides advanced
   authentication and synchronyzation with the forum.

2) phpBBforum: Recent forum topics
   Display a list of the latest updated forum topics.

3) phpBBforum: New forum posts
   Display a list of the latest forum messages.

4) phpBBforum: Online forum users
   Display a list of all on-line forum users.

5) phpBBforum: Forum statistics
   Display forum statistics including: number of users, threads, messages,
   newest member, etc.

6) phpBBforum: Personal messages
   Display your forum personal messages if you are logged in.

7) phpBBforum: Top posters
   Display a list of the top posters.

8) phpBBforum: New forum topics
   Display a list of the new forum topics.
   

Installation
------------------------------------------------------------------------------

The phpBB Drupal bridge consits of two parts:

  I. phpBB phpbbdrupalbridge MOD;
  II. Drupal phpBBforum module.

I. phpbbdrupalbridge MOD installation

  1) Install phpbbdrupalbridge MOD with AutoMOD or manually;
  2) Configure phpBB settings.

1.1. Installing phpbbdrupalbridge MOD with AutoMOD

  1) Download the phpbbdrupalbridge-3.0.10.zip MOD from http://phpbb.drupalbridge.org/download;
  2) In phpBB ACP go to tab AUTOMOD and upload phpbbdrupalbridge-3.0.10.zip MOD or
     Unpack the phpbbdrupalbridge-3.0.10.zip archive and copy it to the /phpBB3/store/mods/ directory.
  3) In phpBB ACP AUTOMOD tab press Intall.

1.2. Manual phpbbdrupalbridge MOD installation

  1) Download the phpbbdrupalbridge-3.0.10.zip MOD from http://phpbb.drupalbridge.org/download;
  2) Unpack the phpbbdrupalbridge-3.0.10.zip archive directory.
  3) Copy directory and files according instructions in install_phpbb.xml and the scheme below.
   
  +/root ---------------------> +(phpBB root path: /home/vb/www/example.com/public_html/phpBB3/)
    +/images -------------------> +/images (/home/vb/www/example.com/public_html/images)
        
    +/includes -----------------> +/includes
      +/phpbbdrupalbridge
        phpbb_api.php             phpBB api file name: phpbb_api.php
  
    +/styles -------------------> +/styles
      +/prosilver ----------------> +/prosilver
      +/prosilver-embed ----------> +/prosilver-embed
      +/subsilver2-embed ---------> +/subsilver2-embed
      +/subsilver2 ---------------> +/subsilver2

    functions_user-embed-3.0.10.patch  --> +/phpBB3/functions_user-embed-3.0.10.patch
    (for functions_user.php only)
    phpBB-embed-3.0.10.patch ------------> +/phpBB3/phpBB-embed-3.0.10.patch
    (for the whole phpBB including patch for functions_user.php)

  4) Apply patch to phpBB
    
    1. If you do not want to use embedded mode "In the Drupal page", you should apply functions_user-embed-3.0.10.patch only

    copy ... root/functions_user-embed-3.0.10.patch  to  .../phpBB3/functions_user-embed-3.0.10.patch
    
    2. If you want to use embedded mode, you should apply phpBB-embed-3.0.10.patch
 
    The patch is made from clean phpBB3-3.0.10.
    All changes made by the patch do not affect the standalone behavior of phpBB3.

    3. Go to phpBB directory.

      cd /phpBB3

    4. If you are upgrading from previous version of the module, you may wat to restore the original 
    phpBB source files from previous patch.

      patch -p0 -R < phpBB-embed-3.0.8.patch    
      
    5. Patch phpBB. Choose appropriate filename for your patch and version of phpBB.

      patch -p0 < phpBB-embed-3.0.10.patch
      
    See http://drupal.org/patch/apply for details or if something is wrong.

    6. Remove patch from phpBB root directory  
 
  5) Copy .../root/images directory to Drupal directory.

     If you do not want it, you will have to edit phpBB file editor.js for your phpBB theme
     (/phpBB3/styles/prosilver-embed/template/editor.js) and enter the url, 
     where the file spacer.gif resides.
     
     (function colorPalette(dir, width, height) line 335)
     
     The relative path img src="/images/spacer.gif" provides access to spacer.gif both in standalone an inside Drupal mode 
     only if you copy /images directory to Drupal directory.
     
     Do not forget to add a line 
     
     Disallow: /images/
     
     to your robots.txt file.

  6) If you cannot patch the phpBB files you may download patched phpBB files from http://phpbb.drupalbridge.org/download.

3. Configuration of the phpBB forum
  
  1) Go to phpBB Administration Control Panel > General > Server URL settings

    Server URL settings
    Domain name:
    The domain name this board runs from (for example: www.example.com).
     
    In drupal settings.php variable $base_url and Domain name must be both with or without www.
    
    Domain name: www.example.com
    $base_url = 'http://www.example.com';
    or
    Domain name: example.com
    $base_url = 'http://example.com';
    
    Script path: /phpBB3
    The path where phpBB is located relative to the domain
    name, e.g. /phpBB3.
    If you have drupal and phpBB3 installed in subdirectory you must enter

    Script path: /subdirectory/phpBB3

    Force server URL settings.
    
    Force server URL settings: (*) Yes  () No.
   
  2) Cookie settings

    Cookie domain: .example.com
    Cookie name: [random name]
    Cookie path: /

    Note: your domain name .example.com with leading dot.
   
  3) User registration settings

    Account activation:       () Disable (*) None () By User () By Admin
    
    Choose () None or () By User
    If you set By User, user must to login first to phpBB and after that you will see that he is registered.
    Set to None for test purposes.

    Username length:
    Minimum and maximum number of characters in usernames.   [1]    [30]

    Password length:
    Minimum and maximum number of characters in passwords.   [5]    [30]

  4) Security settings

    Check IP against DNS Blackhole List: () Yes (*) No

    You may switch off
    Check e-mail domain for valid MX record: () Yes (*) No
    If enabled, the e-mail domain provided on registration and profile changes is checked for a valid MX record.

  5) Go to phpBB Administration Control Panel > General > Load settings

    Session length: 86400
    Sessions will expire after this time, in seconds. 

    Set this value according your needs.

  6) Go to phpBB Administration Control Panel > Styles and install needed embed styles

    prosilver-embed
    Copyright: (C) phpBB Group, 2007 	Install
    or/and
    subsilver2-embed
    Copyright: (C) 2005 phpBB Group 	Install

    In the Install style make sure that the style is active. Do not make it default.

  7). Clear phpBB cache.
  
  You should revise all settings that may affect the behavior of the module.

II. Installing phpBBforum module

1. Download the phpBBforum module from http://drupal.org/project/phpbbforum
   
  Unpack the archive.

  By default, the phpbbdrupalbridge MOD installs phpbbdrupalbridge api files
  into the phpBB3/includes/phpbbdrupalbridge/ directory.
  If you want, you may move it to the sites/all/modules/phpbbforum/includes/ directory.
  You should use only one copy of /phpbbdrupalbridge directory.
  
  Module -------------------------> Your site paths
                                     (Drupal base path: /home/vb/www/example.com/public_html)
+/phpbbforum ----------------------> +/sites/all/modules/phpbbforum
                                     (phpBB root path: /home/vb/www/example.com/public_html/phpBB3/)
  +/includes                         (Path to phpBB api file: sites/all/modules/phpbbforum/includes/)  
    +/phpbbdrupalbridge
    phpbb_api.php                    phpBB api file name: phpbb_api.php

  or
  
  MOD -----------------------------> Your site paths
  +/root -------------------------> +(phpBB root path: /home/vb/www/example.com/public_html/phpBB3/)
    +/includes -------------------> +/includes
      +/phpbbdrupalbridge
        phpbb_api.php                phpBB api file name: phpbb_api.php
  
2.  Copy phpbbforum directory and files
          
  1) Copy phpbbforum directory to your modules directory.
  
     sites/all/modules/phpbbforum

3. Install and setup phpbbforum module        

  1) To test how you will be authenticated, login to your phpBB forum as admin.

  2) Install phpbbforum module as usual.
     Open new window in browser with your Drupal site, login as admin,
     navigate to Administer >> modules and enable the phpBBforum and profile module.

  3) Updating from the previous version

     0. Backup
     1. Disable the module
     2. Remove sites/all/modules/phpbbforum directory
     3. Copy the new phpbbforum directory to your modules directory
     4. Enable the module
     5. If Drupal Database updates is not up to date, run update.php
     6. Go to Administer >> Site configuration >> phpBBforum settings
     7. Clear Path to phpBB api file and Save configuration
        The module will find the new location of phpbb_api.php in /phpbbdrupalbridge directory.
  
  4) Go to Administer >> Site configuration >> phpBBforum settings.
  
     Navigate to phpBBforum settings and enter the path to
     phpBB root (path to forum's config.php file).
     (phpBB root path: /home/vb/www/example.com/public_html/phpBB3/)
     
     Save settings and ensure that phpBBforum successfully connected
     to the phpBB database and you are authenticated.

     Your path settings should look like this
     
     phpBB forum root path:
     /home/vb/www/example.com/public_html/phpBB3/ 
     Path to forum directory. Enter the full directory path where phpBB is installed.

     Path to phpBB api file:
     sites/all/modules/phpbbforum/includes/
     Enter the full directory path where phpBB api file is located.

     Leave blank or clear for standard location.

     phpBB api file name:
     phpbb_api.php
     Enter phpBB api file name.

  5) In order to run phpBB inside of drupal page select appropriate mode:
     (To run correctly clean URLs must be enabled.) 
   
     phpBB display way:
     In the window
     In frame inside Drupal page
   X In the Drupal page
  
     Set other settings and Save configuration.
            
  6) Ensure that corresponding profile.module fields exist.
     If necessary create profile.module fields that match with
     phpBB profile fields.

  7) Navigate to Blocks.
     Enable phpBBforum: Hidden authentication block.
     Configure its visibility settings

     Show block on specific pages:
     * Show on every page except the listed pages.
     Pages:
     user/reset/*
     user/password
 
     Do not disable it in the future if you want advanced synchronization.
     Enable the phpBBforum blocks you want to use (optional).
   
  8) Setup link to phpbbforum page.

    1. Try link http://example.com/phpbbforum

    2. If page phpbbforum is not found, Go to Administer >> Site configuration > Performance

       Press Clear cached data
    
    3. Go to Administer >> Site building > Menus > Navigation
    See Menu item with blank title in state (Disabled)
    You may enable it if you do not want phpbbforum in Primary links

    If you enable it your forum page will be with title.
    Reset will help to remove the page title if you disable it back.

    4. Go to Administer >> Site building >> Menus >> Primary links
    Enter Menu item phpbbforum.

    Main page and link to phpBB in page is

    phpbbforum

    To change this name you may add URL aliases.
    
    Add next URL aliases (System path -> URL Alias)
    
    For the path 'forums'
    
    phpbbforum -> forums
    phpbbforum/index.php -> forums/index.php
    phpbbforum/viewtopic.php -> forums/viewtopic.php
    phpbbforum/viewforum.php -> forums/viewforum.php
    phpbbforum/viewonline.php -> forums/viewonline.php
    phpbbforum/memberlist.php -> forums/memberlist.php  
    phpbbforum/posting.php -> forums/posting.php
    phpbbforum/search.php -> forums/search.php
    phpbbforum/ucp.php -> forums/ucp.php
    phpbbforum/mcp.php -> forums/mcp.php
    phpbbforum/faq.php -> forums/faq.php
    phpbbforum/report.php -> forums/report.php
    phpbbforum/adm/index.php -> forums/adm/index.php
    
    Administer >> Site building >> URL aliases >> Add alias
    
    Existing system path: http://example.com/phpbbforum
    
    Specify the existing path you wish to alias. For example: node/28, forum/1, taxonomy/term/1+2.

    http://example.com/forums

    Specify an alternative path by which this data can be accessed. 
    For example, type "about" when writing an about page. 
    Use a relative path and don't add a trailing slash or the URL alias won't work.
    
    All links from blocks will have that path 'forums' instead of system phpbbforum.
    
    It works with or without Clean URLs enabled.
  
  9) To setup content submission to phpBB forum

    1. Go to Content types > Edit your content type
      
      Set in section phpBBforum submission settings
      
      Drupal to phpBB submission:
      ( ) Disabled
      (*) Enabled
      
    2. (Drupal 6 only) To enable phpBB comments in the node, set Display below the post in the setting:
      
      Location of phpBB topic comments:
      ( ) Display only on the phpBBforum page
      (*) Display below the post
        
      If you want to display both Drupal and phpBB comments, you should change the setting:
      
      Display Drupal comments:
      (*) Display only phpBB comments
      ( ) Display both Drupal and phpBB comments

    3. (Drupal 6 only) To display the phpBB topic comments in the node,
      you should insert in your theme in node-your_content_type.tpl.php these lines
    
      <?php if ($phpbbforum_comments): ?>
        <div id="phpbbforum-node-comments"><?php print $phpbbforum_comments; ?></div>
      <?php endif; ?>
      
      For the Garland theme you can use the example file garland.node-story.tpl.php.
      Rename it to node-story.tpl.php and copy to the themes/garland directory.
  
4. Theming  
  
  You should realize that on phpbbforum page there will be css conflicts 
  between Drupal and phpBB css files.
  The module is not responsible for that. You will have to resolve the css issues yourself.
  
  For the theming of the phpbbforum page the module provides:

  1) two starter phpBB styles:
  
    prosilver-embed
    subsilver2-embed
    
  2) file phpbbforum.css
  
  3) default starter css files for your drupal theme for phpBB styles:
  
    garland-phpbbforum-prosilver.css
    garland-phpbbforum-subsilver2.css

    bartik-phpbbforum-prosilver.css   (Drupal 7 only)
    bartik-phpbbforum-subsilver2.css  (Drupal 7 only)
    
    phpbbforum-prosilver.css
    phpbbforum-subsilver2.css
    
    You can copy this files to the drupal theme directory and customize them individually for the pariticular theme.
    In this case these default css files is not used.  
    
  4) file phpbbforum.theme.custom-sample.inc and two functions in it
  
    phpbbforum_set_style_example_embed
    phpbbforum_style_example_embed
    
    If you use your own phpBB style then:
    
    a) rename phpbbforum.theme.custom-sample.inc to phpbbforum.theme.custom.inc

    b) Replace 'example' with the name of your phpBB theme
    
    c) uncomment the suggested lines according your theme origin (prosilver or subsilver2)
    or write your own code.
  
    If you do not provide these function the module analyzes style name.
    If your phpBB style is created from prosilver and its name contains string "prosilver" 
    or starts with "pro" the module treats this style as prosilver.
    In other cases the module treats this style as subsilver2.
    In these cases you do not need to create and edit these functions.
    
  The styles prosilver-embed and subsilver2-embed are used only running phpBB inside Drupal page.
  The phpBB administrators or phpBB users should select only original styles prosilver or subsilver2.
  If you have your own custom style example, you should provide the style example-embed (or example_embed) 
  and it should be active in order to run inside Drupal.
  
5. Miscellaneous
  
  Need to set manually define('PHPBB_SEO_TOOLKIT', 1); in phpbb_api.php if you use this modification of phpBB3.

6. Hints  

  Your phpBB forum should be installed in subdirectory of Drupal installation directory 
  in order to run inside Drupal page. 
  For example, it is /phpBB3. But you may use your own name, but not /phpbbforum.
    
  Do not think that the embedded inside Drupal phpBB will work for your themes right out of the box.

  Install first locally and ensure that with your settings it works as you expect.

  Setting up the module for the first time use Garland (Bartik) in Drupal and prosilver in phpBB themes 
  instead of your custom themes.

  Do not use exotic layout you will never use on the production site just to test the module.

  Do not use symlinks to phpBB root if you use "In the Drupal page" mode.

  Do not use domain name with localhost http://localhost.example.com.
  
  Start learning and testing the module with layout that is similiar to your layout on production site.

  Use at you risk on production site.

------------------------------------------------------------------------------
Module written by Vadim G.B. vb on http://drupal.org, http://drupal.ru
------------------------------------------------------------------------------
