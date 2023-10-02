const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
  .webpackConfig({
    module: {
      rules: [
        {
          test: /\.(mp4|webm|ogg|mp3|wav|flac|aac)(\?.*)?$/,
          use: [
            {
              loader: "file-loader",
              options: {
                name: "videos/[name].[ext]",
              },
            },
          ],
        },
      ],
    },
  })
  .js("resources/js/app.js", "public/js")
  .vue()
  .sass("resources/sass/app.scss", "public/css", []);

// mix
//   .extend("addWebpackLoaders", (webpackConfig, loaderRules) => {
//     loaderRules.forEach((loaderRule) => {
//       webpackConfig.module.rules.push(loaderRule);
//     });
//   })
//   .vue();

// mix.addWebpackLoaders([
//   {
//     test: /jQuery[\/\\]chosen\.jquery\.js$/,
//     use: "imports-loader?this=>window",
//   },
//   {
//     test: /jQuery[\/\\]alertify\.js$/,
//     use: "imports-loader?define=>false,this=>window",
//   },
// ]);
