## About Ultimate POS

Ultimate POS is a POS application by [Ultimate Fosters](http://ultimatefosters.com), a brand of [The Web Fosters](http://thewebfosters.com).

## Installation & Documentation
You will find installation guide and documentation in the downloaded zip file.
Also, For complete updated documentation of the ultimate pos please visit online [documentation guide](http://ultimatefosters.com/ultimate-pos/).

### cPanel Hosting Installation

To deploy the application on a typical cPanel shared hosting environment:

1. **Upload the project** using the File Manager or Git. Ensure the entire repository (including `vendor` and `public` folders) is uploaded.
2. **Point your domain to the `public` folder.** If you cannot change the document root, keep the repository in the root and rely on the provided `.htaccess` to rewrite requests to `public/`.
3. **Create a MySQL database and user** from the cPanel dashboard and grant the user full privileges on the database.
4. **Run the installer** by visiting `http://your-domain.example/install-start` in your browser. Follow the on‑screen steps to generate the `.env` file and create the super admin account.
5. After installation completes, log in at `http://your-domain.example/login` using the credentials you provided to access the admin panel as a super admin.

## Security Vulnerabilities

If you discover a security vulnerability within ultimate POS, please send an e-mail to support at thewebfosters@gmail.com. All security vulnerabilities will be promptly addressed.

## License

The Ultimate POS software is licensed under the [Codecanyon license](https://codecanyon.net/licenses/standard).

## Docker Development

Build and start the application using Docker Compose:

```bash
docker-compose up --build
```

The application will be available at [http://localhost:8000](http://localhost:8000).

## Debugging

Debugging is disabled by default. To enable detailed error output, set `APP_DEBUG=true` in your `.env` file or appropriate environment variable and reload the application.

## Two-Factor Authentication

To protect accounts, users may enable two-factor authentication. While logged in visit `/two-factor` to generate a secret key and recovery codes. After enabling, the login process will ask for a time based one-time password from your authenticator app. Two-factor authentication can be disabled at any time from the same page.

## Forecast Service

The reporting module includes a simple forecast calculator that divides total available stock by total sales.

- **Sales** are read from the existing `transactions` table using the `Transaction` model and include rows of type `sell`.
- **Inventory** levels are obtained from the `variation_location_details` table via the `VariationLocationDetails` model.
- Ensure these tables are migrated before invoking `Modules\Reporting\Services\ForecastService`.
