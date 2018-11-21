# Give - Addon Boilerplate
A demo plugin to serve as a boilerplate for developers to understand how to extend the Give Donation plugin for WordPress

#### Note for developers
If running `npm run dev` throws an error then check whether the `images` folder exists in your addon directory under `assets > src`. 
1. If `images` folder doesn't exists then create one. 
2. If `images` folder is not required for any add-on then remove code from `webpack.config.js`.
