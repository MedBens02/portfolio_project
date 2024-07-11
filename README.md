# E-tude

## Introduction

E-tude is a customizable digital school platform solution designed for schools and universities. It allows educational institutions to create and manage their own digital learning environments. This repository includes the landing page for E-tude and a demo directory with an example of an educational platform.

[Deployed Site](https://github.com/MedBens02/Web_proj)  
[Final Project Blog Article]([https://www.your-blog-article.com](https://medium.com/@medbens/e-tude-transforming-education-for-the-digital-age-a4c3be99268a))  
[Author's LinkedIn](https://www.linkedin.com/in/mohamedbensaddik/)

## Installation

### Prerequisites

- Web server with PHP support (e.g., Apache, Nginx)
- MySQL Server

### Steps to Install

#### Using a Script

Download the `config.sh` script, modify the database credentials and the path to your web server's root directory, and execute it.

```bash
sudo chmod +x config.sh
./config.sh
```

#### Manual Installation

1. **Clone the Repository**

   Clone this repository into the directory named `proj` located at the root of your web server.

   ```bash
   git clone https://github.com/MedBens02/Web_proj.git /path/to/server/root/proj
   ```

2. **Configure the Database**

   Create a MySQL database named `plateforme_scolaire`. Use the MySQL root user with an empty password. Update the database configuration file located at `database/DB.php`.

   ```php
   <?php
   class DB {
       static public function connect() {
           $pdo = new PDO('mysql:host=localhost;dbname=plateforme_scolaire', 'root', '');
           $pdo->exec("set names utf8");
           $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           return $pdo;
       }
   }
   ?>
   ```

3. **Import the Database Structure**

   Import the database structure by executing the provided SQL scripts in the `database/` directory.

   ```bash
   mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS plateforme_scolaire"
   mysql -u root -p plateforme_scolaire < database/plateforme_scolaire.sql
   ```

4. **Launch the Application**

   Once the configuration is complete, open your browser and access the application via `http://localhost/proj`.

5. **User Accounts**

   - **Professor**  
     Email: `test@gmail.com`  
     Password: `test`

   - **Student**  
     Email: `test@gmail.com`  
     Password: `test`

   - **Admin**  
     Username: `admin`  
     Password: `admin`

## Usage

Access the application via the deployed site link provided above. The platform allows administrators to manage user accounts, professors to upload educational materials, and students to access and interact with the provided content.

## Contributing

We welcome contributions from the community. If you would like to contribute, please fork the repository, create a new branch for your feature or bug fix, and submit a pull request. Ensure your code follows our coding standards and includes appropriate tests.
