# Tutor Certificate Builder

Certificate Builder Plugin for Tutor LMS

## Installation

Use the package manager [Composer](https://getcomposer.org/) to install the plugin.

```bash
composer init-project
```

## Requirements
Make sure all dependencies have been installed before moving on:

```
→ WordPress
→ PHP >= 7.0
→ DOM extension
→ CURL extension
→ Composer
→ Node.js
→ npm
```

## For Development
Please enable ```SCRIPT_DEBUG``` - ``true`` in wp-config.php

```bash
define('SCRIPT_DEBUG', true);
```

then run `composer install`
### JavaScript/Reactjs
- `npm install`
- `npm run watch`


## PHP Coding Standard
To Test PHP Coding Standard (PHPCS) using a CLI:

```
composer phpcs
```

## PHP Unit Tests
For running PHP Unit tests use a CLI command:

```
composer test
```

## JS Coding Standard
To Test JS Coding Standard (JSCS) using a CLI: We use a default WordPress JSCS, but you can modify it in the .eslintrc file.

```
npm run eslint
```
## Developer Documentation
 [Developer doc link](./docs/readme.md)
## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)