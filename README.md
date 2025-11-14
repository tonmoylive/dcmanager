
# Customer Balance Manager

A simple and effective web-based application to manage customer debit and credit balances. This tool is designed for small businesses to easily track customer transactions, view balance summaries, and maintain a history of all financial interactions.

## Features

- **Customer Management:** Add, edit, and delete customer profiles.
- **Balance Tracking:** Record debit and credit transactions for each customer.
- **Balance Summary:** View a clear summary of total debit, total credit, and the resulting due balance.
- **Transaction History:** Maintain a chronological history of all balance updates.
- **Search Functionality:** Quickly find customers by name.
- **Secure Access:** Passkey protection to ensure data privacy.
- **Bilingual Support:** Switch between English and Bengali for a localized experience.

## Directory Structure

```
.
├── backend/
│   ├── add_customer.php
│   ├── add_edit_balance.php
│   ├── auth.php
│   ├── check_auth.php
│   ├── db.php
│   ├── delete_customer.php
│   ├── edit_customer.php
│   ├── get_balance_history.php
│   ├── get_customer_balance.php
│   ├── get_customer_info.php
│   ├── logout.php
│   └── search_customer.php
├── balance.php
├── index.php
├── passkey.php
└── store_db.sql
```

## Database Schema

The application uses a MySQL database with the following tables:

### `customers`

| Column      | Type         | Description                  |
|-------------|--------------|------------------------------|
| `id`        | `INT(11)`    | Primary Key, Auto-increment  |
| `name`      | `VARCHAR(100)`| Customer's name              |
| `phone`     | `VARCHAR(20)`| Customer's phone number (optional) |
| `created_at`| `DATETIME`   | Timestamp of customer creation |

### `balance_history`

| Column         | Type                  | Description                  |
|----------------|-----------------------|------------------------------|
| `id`           | `INT(11)`             | Primary Key, Auto-increment  |
| `customer_id`  | `INT(11)`             | Foreign Key to `customers.id`|
| `balance_type` | `ENUM('debit','credit')`| Type of transaction          |
| `amount`       | `DECIMAL(10,2)`       | Transaction amount           |
| `action_type`  | `ENUM('add','edit')`  | Type of action (add or edit) |
| `timestamp`    | `DATETIME`            | Timestamp of the transaction |

## API Endpoints

The `backend/` directory contains the following PHP scripts that serve as API endpoints:

- **`add_customer.php`**: Adds a new customer.
- **`add_edit_balance.php`**: Adds or edits a balance transaction.
- **`auth.php`**: Handles passkey authentication.
- **`check_auth.php`**: Checks if the user is authenticated.
- **`db.php`**: Handles the database connection.
- **`delete_customer.php`**: Deletes a customer.
- **`edit_customer.php`**: Edits a customer's profile.
- **`get_balance_history.php`**: Retrieves the balance history for a customer.
- **`get_customer_balance.php`**: Retrieves the balance summary for a customer.
- **`get_customer_info.php`**: Retrieves a customer's information.
- **`logout.php`**: Logs the user out.
- **`search_customer.php`**: Searches for customers by name.

## Getting Started

### Prerequisites

- A web server with PHP support (e.g., Apache, Nginx).
- A MySQL database.

### Installation

1.  **Clone the repository or download the files.**
2.  **Import the database:**
    - Create a new database in your MySQL server.
    - Import the `store_db.sql` file to set up the necessary tables.
3.  **Configure the database connection:**
    - Open `backend/db.php`.
    - Update the `$host`, `$db`, `$user`, and `$pass` variables with your database credentials.
4.  **Set the passkey:**
    - Open `backend/auth.php`.
    - Change the value of `$correct_passkey` to your desired passkey.
5.  **Deploy the files:**
    - Upload all the files to your web server's root directory (e.g., `htdocs` or `www`).

## Usage

1.  **Login:**
    - Access the `passkey.php` page in your web browser.
    - Enter the passkey you set in `backend/auth.php` to log in.
2.  **Manage Customers:**
    - The `index.php` page displays a list of all customers.
    - You can add new customers using the form at the top of the page.
    - Use the search bar to find specific customers.
3.  **Manage Balances:**
    - Click the "Manage" button next to a customer's name to go to the `balance.php` page.
    - On this page, you can:
        - Add new debit or credit transactions.
        - View the customer's balance summary.
        - See a history of all transactions.
        - Edit or delete the customer's profile.

---

&copy; 2025 [MD ANIK BISWAS](https://mdanikbiswas.rf.gd/). All rights reserved.
