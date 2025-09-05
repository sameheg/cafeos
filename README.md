## About Ultimate POS

Ultimate POS is a POS application by [Ultimate Fosters](http://ultimatefosters.com), a brand of [The Web Fosters](http://thewebfosters.com).

## Installation & Documentation
You will find installation guide and documentation in the downloaded zip file.
Also, For complete updated documentation of the ultimate pos please visit online [documentation guide](http://ultimatefosters.com/ultimate-pos/).

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
