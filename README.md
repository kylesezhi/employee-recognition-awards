# Employee Recognition Awards
Web app that allows users to create, email and analyze employee awards.
## Introduction
Our project is a web application for the management and creation of employee award certificates. The application has a front end that interfaces with a database that stores information about registered users, as well information about individual awards created with the application. The application has a login and authentication system to control access. Employee award certificates are sent by email to the recipients. Data about users, regions, and awards sent can be analyzed in the Analytics section. Our application requires a modern browser such as Chrome or Firefox.

The completed project can be accessed at the following URL:
[http://web.engr.oregonstate.edu/~pikec/bolero/index.php](http://web.engr.oregonstate.edu/~pikec/bolero/index.php)
## Usage
As mentioned above, the application supports two user types: regular users and admin users. Regular users are envisioned as managers in a company that can give awards to their employees. Admin users are envisioned as individuals responsible for administering the system, such as performing business intelligence analytics and granting access to regular users.

To login as either a regular user or an admin user for testing or evaluation purposes, go to [http://web.engr.oregonstate.edu/~pikec/bolero/index.php](http://web.engr.oregonstate.edu/~pikec/bolero/index.php) and enter the following credentials into the login screen:
### Regular User
Username: user@gmail.com

Password: a
### Admin User
Username: admin@gmail.com

Password: a

![screenshot](https://raw.githubusercontent.com/kylesezhi/bolero-web3/master/images/image00.png "screenshot")

If you’ve created a user account for your own email address (see below on how to create new accounts), you can also try the “I forgot my password” link on the login page. There you can enter your email address, and you will be sent a link where you can reset your password.

## Admin Interface
1. Login as an administrative user (see above).
2. Try the functionality available in the Users section:
![screenshot](https://raw.githubusercontent.com/kylesezhi/bolero-web3/master/images/image01.png "screenshot")
  1. Add User - allows you to add regular or admin users.
    * NOTE: When adding a new user, please provide an email address you can access. The site will send an email with a temporary password to that address.
  2. Search - allows you to filter the table of users by any column.
  3. Download CSV - allows you to download the unfiltered table as a CSV file.
  4. Edit - allows you to edit the given user's account information. The logged-in admin user can also change their password via the edit button for their account.
  5. Delete - allows you to delete a given user.
  6. Analytics - more on this in step 3.
3. Click on the Analytics link (f) and you are presented a chart that represents some of the award data:
![screenshot](https://raw.githubusercontent.com/kylesezhi/bolero-web3/master/images/image02.png "screenshot")
  1. These two dropdown menus allow you to look at different variables from the database in a variety of views.
  2. Each of the view has a series of filters which act on both the chart above them and the table below them.
  3. As with the users in the previous view, you can download the unfiltered table as a CSV file by clicking this button.
  4. Click this link to logout of the site.
