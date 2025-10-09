# Author Management with Symfony

A simple web application developed with the Symfony PHP framework to manage a list of authors and display their information. This project demonstrates the core features of Symfony, including routing, controllers, the Doctrine ORM, and the Twig templating engine.

---

## ✨ Features

* **Display Author List**: Shows all authors in a table with their basic information (ID, picture, username, email) and the number of books they have published.
* **Add an Author**: A form allows for creating and adding a new author to the database.
* **Edit an Author**: Allows for updating the information of an existing author.
* **Delete an Author**: Removes an author from the list.
* **View Author Details**: A dedicated page displays all information for a single author.
* **Simple Calculations**: Calculates and displays the total number of authors and the total number of books from all authors combined.

---

## 🛠️ Technologies Used

* **Symfony**: The main PHP framework used to build the application.
* **PHP**: The primary programming language.
* **Twig**: The template engine for rendering HTML pages.
* **Doctrine ORM**: For database management and entities (like the `Author` entity).
* **HTML / CSS**: For the basic structure and styling of the pages.

---

## 🚀 Installation and Setup

Follow these steps to get the project running on your local machine.

### **Prerequisites**

* PHP 8.1 or higher
* Composer
* Symfony CLI
* A database (e.g., MySQL, MariaDB, PostgreSQL)

### **Installation Steps**

1.  **Clone the repository**
    ```bash
    git clone [https://github.com/mednourchrif/Tech-Web-Symfony.git](https://github.com/mednourchrif/Tech-Web-Symfony.git)
    cd Tech-Web-Symfony
    ```

2.  **Install PHP dependencies**
    ```bash
    composer install
    ```

3.  **Configure your database**
    * Copy the `.env` file to `.env.local`.
    * Edit the `DATABASE_URL` line in your `.env.local` file with your database credentials.
    ```
    # .env.local (example for MySQL)
    DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=8.0.32&charset=utf8mb4"
    ```

4.  **Create and update the database**
    ```bash
    # Creates the database
    php bin/console doctrine:database:create

    # Runs the migrations to create tables (e.g., the 'author' table)
    php bin/console doctrine:migrations:migrate
    ```

5.  **Run the local server**
    ```bash
    symfony server:start
    ```

The application should now be accessible at `http://127.0.0.1:8000`.

---

## 📄 License

This project is licensed under the MIT License. See the `LICENSE` file for more details.

---

## 📧 Contact

Your Name – [@Mohamed Nour Cherif](https://www.linkedin.com/in/mohamed-nour-cherif) – nourchrif004@gmail.com

Project Link: [https://github.com/mednourchrif/Tech-Web-Symfony](https://github.com/mednourchrif/Tech-Web-Symfony)
