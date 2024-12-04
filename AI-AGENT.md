# Prompt to Claude.ai

This is the context of a web development project, inside of the Wordpress framework. I want to create a boilerplate, a blueprint for future proyects, but developing my own theme. I want it to be test ready with playwright and phpunit, I want it to be linteable in php with phpcs and phpstan, in js with eslint and css with stylelint. I want to use husky to lint everything before I commit anything. In that Husky setup , I will want to use lint only for the files that have been modifying since last commit. Then I will want a set up with circle CI to run lintings on every push and in every push request.
The boilerplate will have a /src section where we will define any custom script. By default, it will have a subfolder src/blocks/test-block with a simple block. We will use @wordpress/scripts for that, and we will modify the input and outputs in a custom webpack.config.js.
One of the main reasons to use this setup is because I also want to use Tailwind CSS.
This theme can be a clone of twentytwentyfive.

# Response

.
├── .circleci
│ └── config.yml
├── .husky
│ ├── \_
│ │ └── .gitignore
│ ├── pre-commit
│ └── commit-msg
├── src
│ ├── blocks
│ │ └── test-block
│ │ ├── block.json
│ │ ├── edit.js
│ │ ├── editor.scss
│ │ ├── index.js
│ │ ├── save.js
│ │ └── style.scss
│ ├── js
│ │ └── index.js
│ └── css
│ └── style.scss
├── tests
│ ├── e2e
│ │ └── basic.spec.js
│ └── php
│ └── test-sample.php
├── .eslintrc.js
├── .stylelintrc.js
├── .phpcs.xml
├── phpstan.neon
├── phpunit.xml
├── composer.json
├── package.json
├── webpack.config.js
├── tailwind.config.js
├── postcss.config.js
└── functions.php

# Por partes

-   husky ✅
-   tailwind ✅
-   wp-scripts and new block ✅
-   phpcs cbf ✅
-   php stan ✅
-   eslint / stylelint ✅
-   browsersync ✅
