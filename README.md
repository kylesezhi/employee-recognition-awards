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

## Regular User Interface
1. Login as a regular user (see above).
2. Try the functionality in the Generate Award section:
![screenshot](https://raw.githubusercontent.com/kylesezhi/bolero-web3/master/images/image03.png "screenshot")
  1. The form allows you to enter desired information, including custom award titles and proclamations. Try entering award information into the form and sending the award with the “Submit” button. You’ll be taken to a confirmation page where you can view the sent award.
    * NOTE: When testing this feature please enter an email address that you have access to as the recipient’s address. The award will be generated and sent to that email address. The email will have an HTML body that displays the content of the award, and the actual award certificate will be a PDF attachment.
  2. This button will log you out and take you back to the main login screen.
  3. This link takes you to the Award History section, described below in step 2.
  4. This link takes you to the Account Information section, described below in step 3. Clicking on the username in the top navigation bar will also take you there.
2. Try the functionality in the Award History section:

  1. Here you can view a list of all the awards sent by the logged-in user. If no awards have been sent, a message would be displayed inviting the user to send an award.
  2. The View Award button allows you to view a re-creation of the selected award.
  3. The Delete Award button allows you to delete the selected award.
3. Try the functionality in the Account Information section:
![screenshot](https://raw.githubusercontent.com/kylesezhi/bolero-web3/master/images/image04.png "screenshot")
  1. Here you can view the data stored in the database for the logged-in user.
  2. Here you can edit the user’s name and state.
  3. Here you can change the user’s password.
  4. Here you can change the signature image stored in the database for the user, as discussed below in step 4.
4. Try the functionality on the Change Signature page:

  1. Here you can upload a .png file of the user’s signature, if you have one. It will be resized and the image data will be stored in the database, and the new signature will be viewable on the Account Information page.
  2. Here you can draw in a signature with your mouse. The drawn signature will be resized and saved in the database, and the new signature will be viewable on the Account Information page.

## Technologies Used
* MySQL - used to store data about users and award
* PHP - used to interface with the database and dynamically build pages based on stored content, as well as tracking session variables to determine which user was logged in and what type of user they were
* Google Charts - used to visually display the analytics query system
* Bootstrap - used to visually style the site
* Javascript - used for creating CSV files 
* PHP Mailer - library that expands on php’s existing mail library that makes it less cumbersome for programmers to send email as HTML and to send attachment 
* TEX Live - used to build the actual award certificates
* Signature Pad (https://github.com/szimek/signature_pad) - used to allow users to draw in their own signature images for the award certificates
* PHP Image Magician (http://phpimagemagician.jarrodoberto.com/) - used to resize uploaded or drawn signature images to ensure they fit in the award certificate template
