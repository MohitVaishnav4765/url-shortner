<h1 align="center">Sembark URL Shortener</h1>
<h2>Setup Project Locally</h2>
<p>This is a Laravel project. Below is the guide for setting up the project on your local machine for development and testing.</p>
<h2>Prerequisites</h2>
<p>Before you begin, ensure you have the following installed on your system:</p>
<ul>
    <li>PHP 8.4</li>
    <li>Composer</li>
    <li>MySQL</li>
</ul>
<h2>Steps</h2>
<ol type="1">
    <li>
        <p>Clone the repository to your local machine.</p>
        <p><code>git clone https://github.com/MohitVaishnav4765/url-shortner.git</code></p>
        <p><code>cd url-shortner</code></p>
    </li>
    <li>
        <p>Once you have the project cloned, you need to install all the PHP dependencies via Composer.</p>
        <p><code>composer install</code></p>
    </li>
    <li>
        <p>Copy the .env file</p>
        <p><code>cp .env.example .env</code></p>
    </li>
    <li>
        <p>Generate Application key</p>
        <p><code>php artisan key:generate</code></p>
    </li>
    <li>
        <p>Set up Database</p>
        <p>In the .env file, set up your database connection. For example, for MySQL:</p>
        <p><code>
        DB_CONNECTION=mysql<br/>
        DB_HOST=127.0.0.1<br/>
        DB_PORT=3306<br/>
        DB_DATABASE=your_database_name<br/>
        DB_USERNAME=your_database_username<br/>DB_PASSWORD=your_database_password
        </code></p>
    </li>
    <li>
        <p>Run the migrations</p>
        <p><code>php artisan migrate</code></p>
    </li>
    <li>
        <p>Create Roles & SuperAdmin User</p>
        <p><code>php artisan db:seed</code></p>
    </li>
    <li>
        <p>Run the Application</p>
        <p><code>php artisan serve</code></p>
    </li>
</ol>
<h2>Additional Resources</h2>
<ul>
    <li><a href="https://www.php.net/manual/en/">PHP Documentation</a></li>
    <li><a href="https://laravel.com/docs/12.x">Laravel Documentation</a></li>
    <li><a href="https://getcomposer.org/doc/">Composer Documentation</a></li>
    <li><a href="https://spatie.be/docs/laravel-permission/v6/introduction">Spatie Laravel Permission</a> for Role based access control</li>
    <li><a href="https://yajrabox.com/docs/laravel-datatables/12.0">Yajra Laravel Datatables</a> for records listing,sorting & pagination</li>
    <li><a href="https://github.com/proengsoft/laravel-jsvalidation">proengsoft/laravel-jsvalidation</a> for client side validation</li>
    <li><a href="https://chatgpt.com/">ChatGPT</a> for syntax & brain storming</li>
</ul>