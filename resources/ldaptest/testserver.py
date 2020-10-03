"""
Code from https://ldaptor.readthedocs.io/en/latest/quickstart.html#ldap-server-quick-start

"""

import sys

try:
    from cStringIO import StringIO as BytesIO
except ImportError:
    from io import BytesIO

from twisted.application import service
from twisted.internet.endpoints import serverFromString
from twisted.internet.protocol import ServerFactory
from twisted.python.components import registerAdapter
from twisted.python import log
from ldaptor.inmemory import fromLDIFFile
from ldaptor.interfaces import IConnectedLDAPEntry
from ldaptor.protocols.ldap.ldapserver import LDAPServer

LDIF = b"""\
dn: o=ReactOS Website
objectClass: organization
o: ReactOS Website

dn: ou=People,o=ReactOS Website
objectClass: organizationalUnit
ou: People

dn: ou=Groups,o=ReactOS Website
objectClass: organizationalUnit
ou: Groups

dn: cn=Moderators,ou=Groups,o=ReactOS Website
objectClass: groupOfNames
cn: Moderators
member: cn=testmod,ou=People,o=ReactOS Website
member: cn=testadmin,ou=People,o=ReactOS Website

dn: cu=Administrators,ou=Groups,o=ReactOS Website
objectClass: groupOfNames
cn: Administrators
member: cn=testadmin,ou=People,o=ReactOS Website

dn: ou=Service Accounts,o=ReactOS Website
objectClass: organizationalUnit
ou: Service Accounts

dn: uid=roslogin,ou=Service Accounts,o=ReactOS Website
objectClass: account
objectClass: simpleSecurityObject
uid: roslogin
userPassword: test

# Users:
dn: cn=test,ou=People,o=ReactOS Website
objectClass: inetOrgPerson
cn: test
sn: test
mail: test@test.com
displayName: test
userPassword: test12

dn: cn=test2,ou=People,o=ReactOS Website
objectClass: inetOrgPerson
cn: test2
sn: test2
mail: test2@test.com
displayName: test 2
userPassword: test12

dn: cn=test3,ou=People,o=ReactOS Website
objectClass: inetOrgPerson
cn: test3
sn: test3
mail: test3@test.com
displayName: test3
userPassword: test12

dn: cn=test_banned1,ou=People,o=ReactOS Website
objectClass: inetOrgPerson
cn: test_banned1
sn: test_banned1
mail: test3@test.com.disabled
displayName: test banned1
userPassword: test12

dn: cn=test_banned2,ou=People,o=ReactOS Website
objectClass: inetOrgPerson
cn: test_banned2
sn: test_banned2
mail: test3@test.com.disabled
displayName: test banned2
userPassword: test12

dn: cn=testmod,ou=People,o=ReactOS Website
objectClass: inetOrgPerson
cn: testmod
sn: testmod
mail: testmod@test.com
displayName: test mod
userPassword: test12
memberOf: cn=Moderators,ou=Groups,o=ReactOS Website

dn: cn=testadmin,ou=People,o=ReactOS Website
objectClass: inetOrgPerson
cn: testadmin
sn: testadmin
mail: testadmin@test.com
displayName: test admin
userPassword: test12
memberOf: cn=Moderators,ou=Groups,o=ReactOS Website
memberOf: cn=Administrators,ou=Groups,o=ReactOS Website

"""

class Tree:
    def __init__(self):
        global LDIF
        self.f = BytesIO(LDIF)
        d = fromLDIFFile(self.f)
        d.addCallback(self.ldifRead)

    def ldifRead(self, result):
        self.f.close()
        self.db = result


class LDAPServerFactory(ServerFactory):
    protocol = LDAPServer

    def __init__(self, root):
        self.root = root

    def buildProtocol(self, addr):
        proto = self.protocol()
        proto.debug = self.debug
        proto.factory = self
        return proto


if __name__ == "__main__":
    from twisted.internet import reactor

    if len(sys.argv) == 2:
        port = int(sys.argv[1])
    else:
        port = 389
    # First of all, to show logging info in stdout :
    log.startLogging(sys.stderr)
    # We initialize our tree
    tree = Tree()
    # When the LDAP Server protocol wants to manipulate the DIT, it invokes
    # `root = interfaces.IConnectedLDAPEntry(self.factory)` to get the root
    # of the DIT.  The factory that creates the protocol must therefore
    # be adapted to the IConnectedLDAPEntry interface.
    registerAdapter(lambda x: x.root, LDAPServerFactory, IConnectedLDAPEntry)
    factory = LDAPServerFactory(tree.db)
    factory.debug = True
    application = service.Application("ldaptor-server")
    myService = service.IServiceCollection(application)
    serverEndpointStr = "tcp:{}".format(port)
    e = serverFromString(reactor, serverEndpointStr)
    d = e.listen(factory)
    reactor.run()