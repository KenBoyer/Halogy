VROOM CMS 1.0 INSTALLATION GUIDE
================================

Thank you for downloading VROOM CMS. VROOM CMS is... the Vizlogix Responsive bOOtstrap Multisite Content Management System. VROOM is based on the solid [Halogy CMS](http://www.halogy.com), extended by Vizlogix to (optionally) utilize the Twitter Bootstrap responsive framework on the front-end code as well as in the administration dashboard. This guide provides the basic steps needed in order to get VROOM CMS running on your server.

QUICK START GUIDE
-----------------

1. Download the latest repository from GitHub.
2. Extract the contents and upload them to your web root folder (including the '/static' folder and the 'index.php' and '.htaccess' files).
3. Create a new MySQL database (and record the hostname, username, password, and database name, and run the provided SQL dump on it.
4. Configure your database settings in the '/halogy/config/database.php' file.

NOTE: At this point, VROOM should run on your domain, but for security reasons, we suggest you continue.

5. Move the '/halogy' folder to a location outside of the web root; for example, to the parent directory or a code repository folder.
6. Edit the 'index.php' file, go to line 63, and change the path to point to the CMS root folder (e.g. '../halogy').

-- TESTING A NEW SITE --

7. Go to 'your-domain.com/admin'.
8. Login with the default superuser account: (superuser / super123).
9. Change your superuser password to a more secure password, then create a website administrator by clicking on Users.

You should now be good to go.

CUSTOMIZING VROOM
-----------------

Because VROOM CMS is built upon the amazing CodeIgniter framework (http://codeigniter.com), you can easily extend and modify VROOM CMS to
your heart's content. There are also configurations you can set up in VROOM CMS using the standard CodeIgniter configuration files; for
example, database.php (in /halogy/config), config.php (for character encoding and compression settings), etc.

MODULES
-------

We hope you'll find the built-in modules everything you'll need for your sites; however, you are free to build your own modules by
just building mini-applications (see the CodeIgniter and HMVC documentation) and placing them in the Modules folder inside the
Application. You can then access the modules by going to yoursite.com/module.

For additional documentation, please go to (http://www.vroomcms.com).
