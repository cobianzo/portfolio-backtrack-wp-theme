# Start to work:

```
npm i
composer install
npm run prepare
npm run start
```

# Browser Sync

If you are using Local WP, your url will be something like
`http://mysite.local`.
Edit `package.json`,
replace `"browser-sync": "browser-sync start --proxy \"http://portfolio-theme.local\" ...
changing `http://portfolio-theme.local` for `http://mysite.local`

Run
`npm run browser-sync`

And use the `http://localhost:3000` for developing.



## After making changes in js, css and php files

Linting formatting js, css, and php files.

```
npm run format
composer lint .
composer analyze
(or > npm run lint:php)
composer format .
```

# ABOUT THE STARTING BOILERPLATE

Based on
https://github.com/cobianzo/portfolio-theme

A fork of twentytwentyfive, with tailwind and linting, precommit check.

You can use tailwind styles in your templates.

Reccomended VSCode extensions
phpcs, phpcbf, eslint, stylelint,

---

- Download the plugin and run `rm -rf node_modules package-lock.json; npm i`
and `rm -rf vendor composer.lock; composer install`
- search and replace in all the theme the occurrence `portfolio-theme` with your theme name
- edit the "browser-sync" script in `package.json`
- Install **Create Block Theme** plugin and activate it. It will help you to save changes in your files.
- Use the .php files in 'patterns' as a template to create your own.
- Start creating your theme: your colours, install fonts, build your page templates, menus, header...
- Delete AI-AGENT.md, and delete this README.md file as well to create your own.

---

To use custom php, don't create files like `front-page.php`,
And we don't use shortcodes anymore, so use template parts inserted as patters.
Create your own template part inside `patterns/` that you can insert in the
editor.

---

Then follow the intructions in **Start to work** and **Browser Sync** sections

---

- Always use `composer run lint`, `composer run analyze` and `composer run format` when working in php files
- When working in .js files, use
