# How to Use This Project

Follow these steps to get started with this project:

1. **Clone the Repository**
   - Use `git clone https://github.com/fazaimron27/botika-backend` to clone the project to your local machine.

2. **Install Dependencies**
   - Navigate to the project directory and run `composer install` and `npm install` to install all required dependencies.

3. **Configure Environment**
   - Copy the `.env.example` file to a new file named `.env` and update the variables to match your environment.

4. **Generate Application Key**
   - Run `php artisan key:generate` to generate a new application key.

5. **Migrate Database**
   - Run `php artisan migrate --seed` to migrate the database and seed it with dummy data.

4. **Run the Application**
   - start the application with `php artisan serve`.

5. **Access the Application**
   - Open your web browser and go to `http://localhost:<your-port>` to view the application.

## Default Account Credentials
    - Email: admin@mail.com
    - Password: password
