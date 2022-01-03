var gulp = require("./node_modules/gulp"),
  plumber = require("./node_modules/gulp-plumber"),
  sass = require("./node_modules/gulp-sass"), // compile sass
  sourcemaps = require("./node_modules/gulp-sourcemaps"),
  prefix = require("./node_modules/gulp-autoprefixer"),
  rename = require("./node_modules/gulp-rename"), // compile js
  uglify = require("./node_modules/gulp-uglify-es/lib").default,
  webpack = require("./node_modules/webpack/lib/webpack"),
  webpackStream = require("./node_modules/webpack-stream"),
  browserSync = require("./node_modules/browser-sync/dist").create(),
  csso = require("./node_modules/gulp-csso"),
  purify = require("./node_modules/gulp-purifycss");

var assetsDir = "assets/";
var outputDir = "./";
var siteDomain = "vetlavka.ru";

gulp.task("browser-sync", function () {
  browserSync.init({
    proxy: siteDomain
  });
});

gulp.task("sass", function () {
  gulp.src([
    assetsDir + "sass/**/*.sass",
    "!" + assetsDir + "sass/**/_*.sass",
    assetsDir + "sass/**/*.scss",
    "!" + assetsDir + "sass/**/_*.scss"
  ])
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(sass())
    .pipe(prefix("last 3 versions"))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(outputDir + "css/"))
    .pipe(browserSync.stream());
});

gulp.task("js", function () {
  return gulp
    .src(assetsDir + "js/app.js")
    .pipe(
      webpackStream({
        mode: 'development',
        output: {
          filename: "app.js"
        },
        module: {
          rules: [
            {
              test: /\.vue$/,
              loader: "vue-loader"
            },
            {
              test: /\.(js)$/,
              exclude: /(node_modules)/,
              loader: "babel-loader",
              query: {
                presets: ["env"]
              }
            }
          ]
        },
        resolve: {
          alias: {
            vue$: "vue/dist/vue.common.js"
          }
        }
      })
    )
    .pipe(rename({ suffix: ".min" }))
    .pipe(gulp.dest(outputDir + "js/"))
    .pipe(browserSync.stream());
});

gulp.task("watch", function () {
  gulp.watch(assetsDir + "sass/**/*.scss", ["sass"]);
  gulp.watch(assetsDir + "sass/**/*.sass", ["sass"]);
  gulp.watch(assetsDir + "js/**/*.js", ["js"]);
  gulp.watch(assetsDir + "js/**/*.vue", ["js"]);
});

gulp.task("html-php-wather", function () {
  gulp.src([outputDirBackend + "/**/*.php", outputDirBackend + "/**/*.html"])
    .pipe(plumber())
    .pipe(browserSync.stream());
});

gulp.task("default", ["sass", "js", "watch", "browser-sync"]);

/**
 * BUILD PROJECT
 */
gulp.task("buildCss", function () {
  return gulp
    .src([
      assetsDir + "sass/**/*.sass",
      "!" + assetsDir + "sass/**/_*.sass",
      assetsDir + "sass/**/*.scss",
      "!" + assetsDir + "sass/**/_*.scss"
    ])
    .pipe(plumber())
    .pipe(sass())
    .pipe(prefix("last 3 versions"))
    .pipe(csso())
    .pipe(gulp.dest(outputDir + "css/"));
});

gulp.task("buildJs", function () {
  return gulp
    .src(assetsDir + "js/app.js")
    .pipe(
      webpackStream({
        output: {
          filename: "app.js"
        },
        module: {
          rules: [
            {
              test: /\.vue$/,
              loader: "vue-loader"
            },
            {
              test: /\.(js)$/,
              exclude: /(node_modules)/,
              loader: "babel-loader",
              query: {
                presets: ["env"]
              }
            }
          ]
        },
        resolve: {
          alias: {
            vue$: "vue/dist/vue.common.js"
          }
        }
      })
    )
    .pipe(uglify())
    .pipe(rename({ suffix: ".min" }))
    .pipe(gulp.dest(outputDir + "js/"));
});

gulp.task("build", function () {
  gulp.start("buildJs", "buildCss");
});

/**
 * BUILD PROJECT
 */

/**
 * SVG
 */
var svgSprite = require("./node_modules/gulp-svg-sprite"),
  svgmin = require("./node_modules/gulp-svgmin/dist"),
  cheerio = require("./node_modules/gulp-cheerio/lib"),
  replace = require("./node_modules/gulp-replace");

var image_path = "./../../../";
gulp.task("svgRun", function () {
  return (
    gulp
      .src(image_path + "img/icons/*.svg")
      .pipe(
        svgmin({
          js2svg: {
            pretty: true
          }
        })
      )
      .pipe(
        cheerio({
          run: function ($) {
            $("[fill]").removeAttr("fill");
            $("[stroke]").removeAttr("stroke");
            $("[style]").removeAttr("style");
          },
          parserOptions: { xmlMode: true }
        })
      )
      .pipe(replace("&gt;", ">"))

      .pipe(
        svgSprite({
          mode: {
            symbol: {
              sprite: "../sprite.svg",
              render: {
                scss: {
                  dest:
                    image_path +
                    "local/templates/main/assets/sass/base/_sprite.scss",
                  template:
                    assetsDir +
                    "sass/helpers/_sprite_template.scss"
                }
              },
              example: true
            }
          }
        })
      )
      .pipe(gulp.dest(image_path + "img/sprite/"))
  );
});
/**
 * SVG
 */
