# sae23
Creation of an IT solution. IPAM solution.

# explications
Programming an addressing platform for a fictitious company. The platform is divided into three sites with 3 administrators.

# administrators 
The administrators can create clients, delete them and consult a list of the clients on their sites. 
As soon as a client is created, it is assigned an IP address and a VLAN.

# clients
The clients can assign IP addresses to their machines according to the network. They can also consult a list of the machines on their VLANS,
and delete the machines. 

# php files
#form-connexion.php
The page named form-connexion.php is used as a connection form. You can log in as an administrator or as a client.
To make the connection more secure, the password entered by a user is displayed in the form of dots.
You can contact support by clicking on Contact Support, which redirects the user to their mailbox via a mailto:
link followed by the recipient's email address. When we log in, we are redirected to the connexion.php page.

# menu.php
If the user has logged in as an administrator, they have the choice of:
- add a customer
- view the list of customers
- log out
If the administrator user chooses to add a customer by pressing the "Add a customer" button, they are redirected to the following page:

# form-ajout-client.php
On this page, the administrator can add a customer with the following characteristics:
- customer name
- login
- password
- e-mail

# liste_client.php
By pressing the "Customer list" button to display the list of customers. We can see the customer we created earlier. 
Knowing that it was the administrator of group 1 who created the client, it belongs to site 1. It has a client ID,
and a network address according to the addressing requested in the specifications. It also has a Distinguisher Route,
and the information entered in the form when it was added. 
We can add other clients until we reach the limit of 16 clients.

# menu_client.php
As specified at the time of connection, the client can access the menu_client.php file to add a machine, list the various machines and delete machines. 

Let's say we add a machine named p2021 to room P202. All we have to do is fill in the fields in question.

# tools 
#postgres
to use the sql file we can use postgreSQL

# wamp
to access to the platform we can use wamp or xamp
