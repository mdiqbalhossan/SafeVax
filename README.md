# Project Details

This project is a web application designed to manage vaccine registrations and scheduling for individuals. It allows users to register for vaccination, schedule appointments, and search for their vaccination status.

# How to Run the Project

To run this project, follow these steps:

1. **Clone the repository**: Clone this repository to your local machine using Git by running `git clone https://github.com/your-username/your-repo-name.git`. Place the cloned repository in your computer's xampp or wampp web directory.
2. **Install dependencies**: Navigate to the project directory and run `composer install` to install all the required dependencies.
3. **Set Up Environment Variables**: Duplicate the `.env.example` file and rename it to `.env`. This file contains environment variables for your Laravel application. You can modify the variables as needed.
4. **Generate application key**: Run `php artisan key:generate` to generate a unique application key.
5. **Database Setup**: Ensure the `DB_CONNECTION` in the `.env` file is set to `sqlite`. If you're using an existing database, no migration is required. If you're creating a new database, update the database configuration in the `.env` file. Then, run `php artisan migrate:fresh --seed` to set up the database schema and seed the database with initial data.

6. **Access the application**: Open a web browser and navigate to `http://localhost/safevax` to access the application. Note that `safevax` is the folder name of the project.

# Email Configuration

To enable email sending capabilities, you need to configure the email settings in the `.env` file. Here's how:

1. **Set the `MAIL_DRIVER`**: Update the `MAIL_DRIVER` to your preferred email service provider, such as `smtp`, `sendmail`, or `mailgun`.
2. **Specify the `MAIL_HOST`**: Enter the hostname of your email service provider's SMTP server.
3. **Set the `MAIL_PORT`**: Specify the port number used by your email service provider's SMTP server.
4. **Provide `MAIL_USERNAME` and `MAIL_PASSWORD`**: Enter your email service provider's username and password for authentication.
5. **Set the `MAIL_ENCRYPTION`**: Specify the encryption method used by your email service provider, such as `tls` or `ssl`.
6. **Set the `MAIL_FROM_ADDRESS` and `MAIL_FROM_NAME`**: Specify the email address and name that will be used as the sender's information.

Here's an example configuration for a Gmail account:
```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME=Your Name
```
Remember to update the `MAIL_USERNAME` and `MAIL_PASSWORD` with your actual Gmail account credentials.

**Important:** Without proper email configuration, automatic reminder emails will not be sent.

# Automatic Mail Sending and Cron Job Setup

To enable automatic mail sending and schedule tasks, you need to set up a cron job on your server. Here's how to do it:

**Local Development Environment**

For local development, you can use the `schedule:run` command to simulate the execution of scheduled tasks. To do this, run the following command in your terminal:

```
php artisan schedule:run
```

This command will execute all scheduled tasks defined in the `routes/console.php` file.

**CPanel**

For a production environment using cPanel, follow these steps to set up a cron job:

1. Log in to your cPanel account.
2. Navigate to the **Cron Jobs** section.
3. Click on **Add New Cron Job**.
4. In the **Minute** field, select `*/5` to run the job every 5 minutes.
5. In the **Command** field, enter the following command:
```
php /path/to/your/project/artisan schedule:run
```
Replace `/path/to/your/project/` with the actual path to your project directory.
6. Click **Add New Cron Job** to save the changes.

This will execute the `schedule:run` command every 5 minutes, which will in turn execute all scheduled tasks defined in the `routes/console.php` file.

**Note:** Make sure to update the path to your project directory in the cron job command to match your actual project location.



# Testing the Application

To run the tests for this project, follow these steps:

1. **Run the tests**: Run `phpunit` in the project directory to execute all the tests.
2. **View test results**: The test results will be displayed in the terminal, indicating which tests passed or failed.

# Performance Optimization

To optimize the performance of user registration and search, we can implement the following strategies:

1. **Caching**: We can use caching to store frequently accessed data, reducing the need to fetch it from the database each time. For example, in Laravel, we can use the `remember` method to cache the results of a query.

2. **Database Indexing**: We can create indexes on the columns used in the search and registration operations. This will speed up the data retrieval process. For example, in MySQL, we can use the `CREATE INDEX` statement to create an index on a column.

3. **Query Optimization**: We can optimize the database queries to make them more efficient. This can be done by avoiding unnecessary joins, using appropriate data types, and limiting the number of rows returned. For example, in Laravel, we can use the `select` method to specify the columns to be retrieved.

4. **Load Balancing**: If the application experiences high traffic, we can use load balancing to distribute the load across multiple servers, improving the response time. For example, in AWS, we can use an Elastic Load Balancer to distribute traffic across multiple EC2 instances.

5. **Code Optimization**: We can optimize the code to reduce the number of database calls and improve the overall performance. For example, in PHP, we can use the `with` method in Eloquent to eager load relationships and reduce the number of queries.

### Specific Code Optimizations

- **MemberController**: In the `store` method, consider using `firstOrCreate` for the member creation to avoid duplicate checks and streamline the process.
- **SearchController**: In the `result` method, eager load the `schedule` and `vaccineCenter` relationships to minimize the number of queries executed when accessing related data.

By implementing these optimizations, we can enhance the performance of the application significantly.

**
**Note:** If an additional requirement of sending ‘SMS’ notification along with the email notification for vaccine schedule date is given in the future, the following changes need to be made in the code:
# SMS Send
1. Integrate an SMS API into the project.
2. Update `handle` method in the `App\Console\Commands\SendVaccinationReminder.php` command to handle sending SMS reminders.
3. Update the `handle` method in the `App\Console\Commands\SendVaccinationReminders.php` command to include the following code for sending SMS:
```
use Twilio\Rest\Client;

// ...

public function handle()
{
    $members = Member::whereHas('schedule', function ($query) {
        $query->where('date', Carbon::tomorrow());
    })->get();
    foreach ($members as $member) {
        Mail::to($member->email)->send(new VaccinationReminder($member));
        $this->sendSMS($member->phone, 'Your vaccination schedule is tomorrow.');
    }
}

private function sendSMS($to, $message)
{
    $sid = 'your_twilio_account_sid';
    $token = 'your_twilio_auth_token';
    $twilio = new Client($sid, $token);
    $twilio->messages->create($to, [
        'from' => 'your_twilio_phone_number',
        'body' => $message,
    ]);
}
```
