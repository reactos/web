# -*- Mode: perl; indent-tabs-mode: nil -*-
#
# The contents of this file are subject to the Mozilla Public
# License Version 1.1 (the "License"); you may not use this file
# except in compliance with the License. You may obtain a copy of
# the License at http://www.mozilla.org/MPL/
#
# Software distributed under the License is distributed on an "AS
# IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or
# implied. See the License for the specific language governing
# rights and limitations under the License.
#
# The Original Code is the Bugzilla Bug Tracking System.
#
# The Initial Developer of the Original Code is Netscape Communications
# Corporation. Portions created by Netscape are
# Copyright (C) 1998 Netscape Communications Corporation. All
# Rights Reserved.
#
# Contributor(s): Terry Weissman <terry@mozilla.org>
#                 Dan Mosedale <dmose@mozilla.org>
#                 Joe Robins <jmrobins@tgix.com>
#                 Dave Miller <justdave@syndicomm.com>
#                 Christopher Aillon <christopher@aillon.com>
#                 Gervase Markham <gerv@gerv.net>
#                 Christian Reis <kiko@async.com.br>
#                 Bradley Baetz <bbaetz@acm.org>
#                 Erik Stambaugh <erik@dasbistro.com>
#                 Max Kanat-Alexander <mkanat@bugzilla.org>

# Auth::Login class for RosCMS
# based on the former class for Bugzilla 2.x by Gé van Geldorp and Michael Wirth and the Auth::Login::CGI class
# improved and made compatible with Bugzilla 3.x and Deskzilla by Colin Finck (2007-08-06)
# modified for Drupal by Maciej Bialas (2010)

package Bugzilla::Auth::Login::Drupal;
use strict;
use base qw(Bugzilla::Auth::Login);
use constant can_logout => 0;						# The Bugzilla Logout feature has to be disabled, so the user can only log out with the RosCMS Logout feature

use URI;
use URI::Escape;

use Bugzilla::Constants;
use Bugzilla::WebService::Constants;
use Bugzilla::User;
use Bugzilla::Util;
use Bugzilla::Error;
use Bugzilla::Install::Localconfig;

sub get_login_info {
	my ($self) = @_;
	my $cgi = Bugzilla->cgi;
	
	my $lc = Bugzilla->localconfig;
	my $session_cookie_name = $lc->{session_cookie_name};
	my $drupal_db_name      = $lc->{drupal_db_name};
	my $drupal_prefix      = $lc->{drupal_prefix};
	my $bz_db_name      = $lc->{db_name};	
	
	# Check if we have username and password given (usual CGI method for apps like Deskzilla)
	my $username = trim($cgi->param("Bugzilla_login"));
	my $password = $cgi->param("Bugzilla_password");
	$cgi->delete('Bugzilla_login', 'Bugzilla_password');
	
	if(defined $username && defined $password) {
		return { username => $username, password => $password };
	}
	
	# No, then check for the RosCMS Login cookie
	my $dbh = Bugzilla->dbh;
	my $user_id;
	my $roscms_user_id;
	my $session_id = $cgi->cookie($session_cookie_name);

	#die ($session_id);
	if ( defined $session_id ) {
		my $session_id_clean = $session_id;
		trick_taint($session_id_clean);
		
		my $ip_clean;
		if ($ENV{'HTTP_X_FORWARDED_FOR'}) {
			my @proxies = split(/,/, $ENV{'HTTP_X_FORWARDED_FOR'});
			$ip_clean = $proxies[0];
		} else {
			$ip_clean = $ENV{'REMOTE_ADDR'};
		}
		
		if ($ip_clean =~ m/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})/) {
			$ip_clean = $1;
		} else {
			$ip_clean = 'invalid';
		}
		
		my $browser_agent_clean = $ENV{'HTTP_USER_AGENT'};
		trick_taint($browser_agent_clean);
		
    my $query = "SELECT us.uid " .
				"  FROM $drupal_db_name.${drupal_prefix}users us" .
				"  JOIN ${drupal_db_name}.${drupal_prefix}sessions sess ON us.uid = sess.uid " .
				" WHERE sess.sid = ? " .
				"   AND (UNIX_TIMESTAMP()-sess.timestamp < 10*60) " .
			  "   AND (sess.hostname = 0 OR sess.hostname = ?) ";
				
				
		#my @params = ($session_id_clean, $ip_clean, $browser_agent_clean);
		my @params = ($session_id_clean, $ip_clean);
		($user_id) = $dbh->selectrow_array($query, undef, @params);

		if ($user_id) {
			# Update time of last session use
			$query = "UPDATE $drupal_db_name.${drupal_prefix}sessions " .
					"   SET timestamp = UNIX_TIMESTAMP()" .
					" WHERE sid = ? ";
					
			@params = ($session_id_clean);
			$dbh->do($query, undef, @params);
			
			# Get the user name and the MD5 password from the database
			# We don't check the password explicitly here as we only deal with the session cookie.
			# To show the Verify module that it should trust us, we pass the MD5 password hash to it. This should be secure as long as we're the only one who knows this MD5 hash.
			# my $username = user_id_to_login($user_id);
		#	(my $md5_password) = $dbh->selectrow_array("SELECT password FROM $roscms_db_name.roscms_accounts WHERE id = ?", undef, $roscms_user_id);
				(my $md5_password,my $username) = $dbh->selectrow_array("SELECT pass,mail FROM $drupal_db_name.${drupal_prefix}users WHERE uid = ?", undef, $user_id);
			
			# We need to set a parameter for the Auth::Persist::ROSCMS module
			$cgi->param('ROSCMS_login', 1);
	#		die($username.":".$md5_password.", stopped");
  #    print $username.":".$md5_password;
			return { username => $username, md5_password => $md5_password };
		}
	}
	
	return { failure => AUTH_NODATA };
}

sub fail_nodata {
	my ($self) = @_;
	my $cgi = Bugzilla->cgi;
	my $drupal_login_page   = Bugzilla->localconfig->{drupal_login_page};
	
	# Throw up the login page
#my $this_uri = uri_escape($cgi->url(-absolute=>1, -path_info=>1, -query=>1));
	print $cgi->redirect($drupal_login_page);
	exit;
}

1;
