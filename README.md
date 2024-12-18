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

# SOME NOTES THE STARTING BOILERPLATE tailwind-wp-theme

Based on
https://github.com/cobianzo/tailwind-wp-theme

Which is A fork of twentytwentyfive, with tailwind and linting, precommit check.
I admit that `tailwind-wp-theme` had still some bugs which have been fixed on the developemnt of this theme. (commit 'Lookup ticker working ok - some more lint setup'), which can be a better starting point
for future projects.

You can use tailwind styles in your templates.

Reccomended VSCode extensions
phpcs, phpcbf, eslint, stylelint, prettier

---

- Start creating your theme: your colours, install fonts, build your page templates, menus, header...
- Delete AI-AGENT.md, and delete this README.md file as well to create your own.
- use the dynamic-partials-plugin/blocks/<your-template-part>.php to create new tempalte parts.
	- they will look like a placeholder in the editor
	- in the frontend, the php will be run
	- you can include

---

To use custom php, don't create files like `front-page.php`,
And we don't use shortcodes anymore, so use template parts inserted as patterns (under /patterns), or as blocks if they have js in frontend (using our dynamic-partials-plugin/blocks/ setup)

---

Then follow the intructions in **Start to work** and **Browser Sync** sections


# Dynamic Template Parts as blocks.

I have developed a fast way to include template parts. In the Editor they are playholders, inthe frontend you use a .php template. It's a replacemente of using template-parts or shortcodes in php, whenever you need to add js to the php code. If it's just php, you can create a php patter under /patterns.

Just include the template part inside ./dynamic-partials-plugin/<your-partial>.php

The system will create a block automatically and you will be able to insert it in the editor.

You can include some js to your partial. Just follow the convention of calling the .js with the same name
as the block. It will be compiled by wp-scripts into **/build** (thanks to a modification in `webpack.config.js`)
and it will be enqueued with the block as the view_script.
