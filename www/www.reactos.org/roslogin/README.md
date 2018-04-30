# RosLogin - A simple Self-Service and Single-Sign-On around an LDAP user directory

RosLogin is a simple user Self-Service and Single-Sign-On system for a single site
(such as *.reactos.org) written in PHP and licensed under AGPLv3 or later.

## Distinct Features

In contrast to CAS, OAuth, SAML or Shibboleth-based solutions, RosLogin is much more
lightweight due to its focus on a single site.
Each login sets a site-wide cookie, which is sufficient to identify a user on every
page of the domain and subdomains.
No Public-Key-Infrastructure or XML message passing needs to be set up for this.

While many Single-Sign-On solutions only provide Login and Logout functionality,
RosLogin also comes with a Self-Service that handles registrations, user data changes,
and forgotten credentials.

Finally, PHP web applications like MediaWiki are first-class citizens for RosLogin.
They can easily get information about the currently logged in user by instantiating
`RosLogin` and calling the `isLoggedIn` and `getUserInformation` methods, thereby
implementing SSO functionality.
RosLogin also takes care to only allow user names that do not conflict with the user
name constraints of popular PHP applications.

By managing the entire user information in an LDAP directory (inetOrgPerson schema),
RosLogin additionally allows a basic integration of applications without writing any
custom code.

## Requirements

* PHP 7.x
* MySQL
* OpenLDAP (with cn=config)
* An operating system with a crypt() function supporting Salted SHA-512 hashes (every Linux with a modern glibc)

## Installation

1. Import *roslogin.sql* into a MySQL database *roslogin*.
   Fill *forbidden_usernames* and *forbidden_maildomains* with some (lowercase) forbidden entries if you like.
2. Initialize a fresh OpenLDAP installation with *reactos-website-config.ldif*.
   Then restart OpenLDAP and fill the directory with *reactos-website.ldif*. See both files for more information.
3. Set up *roslogin-connect.php*.

## Technical Details

* *RosLogin.php* implements all Single-Sign-On and Self-Service functions internally.
  It can be included by a third-party PHP application to implement SSO functionality.
  All other files are responsible for the RosLogin user interface.
* *index.php* is the entry point for each user interface action or page.
  It checks the requested action or page and loads the relevant class.
* Login Sequence: LoginPage --> LoginAction --> SelfServicePage (unless a redirect is given)
* Logout Sequence: LogoutAction --> LoginPage (unless a redirect is given)
* Self-Service Sequence: SelfServicePage --> SelfServiceSaveAction
   * If the E-Mail address has been changed, a confirmation mail contains a link: --> ConfirmPage
* Register Sequence: RegisterPage --> RegisterAction --> MessagePage
   * A confirmation mail contains a link: --> ConfirmPage --> RegisterCompleteAction --> MessagePage
* Forgotten Password Sequence: ForgotPage --> ResetPasswordAction
   * A confirmation mail contains a link: --> ConfirmPage --> ResetPasswordCompleteAction --> MessagePage
* Forgotten Username Sequence: ForgotPage --> SendUsernameAction --> MessagePage

## Contact

RosLogin has been written by Colin Finck <colin@reactos.org>.
