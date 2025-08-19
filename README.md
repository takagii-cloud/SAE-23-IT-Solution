# SAE23 – IT Solution Creation (IPAM Platform)
<img width="1919" height="899" alt="Capture d'écran 2025-08-19 231739" src="https://github.com/user-attachments/assets/15ff2fdd-09bd-460d-8642-08129d2dbf61" />

## Project Overview
The goal is to create an **IP Address Management (IPAM) platform** for a fictitious company.  
The platform is divided into **three sites**, each with its own **administrator**.  

---

## Administrators
- Can **create clients**, **delete clients**, and **view the list of clients** for their site.  
- When a **client is created**, the platform automatically assigns:
  - An **IP address**
  - A **VLAN**

---

## Clients
- Can **assign IP addresses** to their machines according to the network.  
- Can **view the list** of the machines in their VLAN.  
- Can **delete machines**.  

---

## PHP Files

### `form-connexion.php`
- Provides the **login form**.  
- Users can log in as **administrator** or **client**.  
- Passwords are hidden (displayed as dots).  
- Contains a **"Contact Support"** link (`mailto:` with predefined email).  
- After login, redirects to **`connexion.php`**.  

---

### `menu.php` (Administrator Menu)
If the user is an **administrator**, they have the following options:
- **Add a customer**
- **View the list of customers**
- **Log out**

When choosing **"Add a customer"**, the administrator is redirected to:

---

### `form-ajout-client.php`
Allows the administrator to create a **new client** with the following details:
- Customer name  
- Login  
- Password  
- Email  

---

### `liste_client.php`
- Displays the **list of clients** created.  
- Example: if the **Administrator of Site 1** creates a client, it will:
  - Belong to **Site 1**
  - Have a **Client ID**
  - Receive a **network address** according to the specifications
  - Have a **Route Distinguisher**
  - Display the **info entered in the creation form**  

Limit: **16 clients per site**.  

---

### `menu_client.php` (Client Menu)
When logged in as a **client**, the menu provides options to:
- **Add a machine**
- **List machines**
- **Delete machines**

Example: adding a machine named `p2021` in room `P202` simply requires filling in the form.  

---

## Tools and Technologies
- **PostgreSQL** → To manage the database (SQL file).  
- **WAMP / XAMPP** → To host and run the PHP platform locally.  
