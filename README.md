# Start to work:

```
npm i
composer install
npm run prepare
npm run start
```

## Developing

You will normally have one or two terminal windows running:

`npm run start` > runs the tailwind compilation on every change, and if you are writing js in /src, it will compile it into /build with wp-scripts

`npm run browser-sync` > if you want to work on localhost:3000 and have the hot reload. See below:

### Browser Sync

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
composer analyze .
(or > npm run lint:php)
composer format .
```

# ABOUT THE STARTING BOILERPLATE

Based on
https://github.com/cobianzo/tailwind-wp-theme

A fork of twentytwentyfive, with tailwind and linting, precommit check.
I admit that `tailwind-wp-theme` had still some bugs which have been fixed on the developemnt of this theme. (commit 'Lookup ticker working ok - some more lint setup'), which can be a better starting point
for future projects.

You can use tailwind styles in your templates.

Reccomended VSCode extensions
phpcs, phpcbf, eslint, stylelint, prettier

---

- Start creating your theme: your colours, install fonts, build your page templates, menus, header...
- Delete AI-AGENT.md, and delete this README.md file as well to create your own.
- use the parts/dynamic-partials/blocks/<your-template-part>.php to create new tempalte parts.
	- they will look like a placeholder in the editor
	- in the frontend, the php will be run
	- you can include

---

To use custom php, don't create files like `front-page.php`,
And we don't use shortcodes anymore, so use template parts inserted as blocks (parts/dynamic-partials/blocks/).

---

Then follow the intructions in **Start to work** and **Browser Sync** sections

---