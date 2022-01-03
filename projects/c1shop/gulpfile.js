var elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix.sass('app.scss')
    .webpack('app.js')
    .webpack('app_compare.js')
    .webpack('app_admin.js');
});

// plugins for development
var gulp = require('gulp'),
    sass = require('gulp-sass'),
    inlineimage = require('gulp-inline-image'),
    prefix = require('gulp-autoprefixer'),
    plumber = require('gulp-plumber'),
    browserSync = require('browser-sync').create(),
    concat = require('gulp-concat'),
    sourcemaps = require('gulp-sourcemaps'),
    postcss = require('gulp-postcss'),
    rigger = require('gulp-rigger'),
    assets  = require('postcss-assets');

// plugins for build
var purify = require('gulp-purifycss'),
    uglify = require('gulp-uglify'),
    csso = require('gulp-csso');

var assetsDir = 'resources/assets/';
var viewDir = 'resources/views/';
var outputDir = 'public/';
var buildDir = 'build/';


//----------------------------------------------------Compiling

// Компиляция SASS -> CSS
gulp.task('sass', function () {
    gulp.src([assetsDir + 'sass/**/*.sass', '!' + assetsDir + 'sass/**/_*.sass', assetsDir + 'sass/**/*.scss', '!' + assetsDir + 'sass/**/_*.scss'])
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(inlineimage())
        .pipe(prefix('last 3 versions'))
        .pipe(postcss([assets({
            basePath:outputDir,
            loadPaths: ['i/']
        })]))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(outputDir + 'css/'))
        .pipe(browserSync.stream());
});

gulp.task('blade', function () {
    gulp.src([viewDir + '**/*.blade.php'])
        .pipe(plumber())
        .pipe(browserSync.stream());
});

// Сборка всех библеотек js
gulp.task('jsConcat', function () {
    return gulp.src(assetsDir + 'js/all/**/*.js')
        .pipe(concat('all.js', {newLine: ';'}))
        .pipe(gulp.dest(outputDir + 'js/'))
        .pipe(browserSync.stream());
});


// модульная сборка основного файла main.js
gulp.task('jsMainModules', function () {
    return gulp.src([assetsDir + 'js/**/*.js', '!' + assetsDir + 'js/all/**/*.js'])
        .pipe(rigger())
        .pipe(gulp.dest(outputDir + 'js/'))
        .pipe(browserSync.stream());
});

// Копирование js из assets в app
gulp.task('jsSync', function () {
    return gulp.src(assetsDir + 'js/*.js')
        .pipe(plumber())
        .pipe(gulp.dest(outputDir + 'js/'))
        .pipe(browserSync.stream());
});

//----------------------------------------------------Compiling###


//-------------------------------------------------Synchronization###

//watching files and run tasks
gulp.task('watch__laravel', function () {
    gulp.watch(viewDir + '**/*.blade.php', ['blade']);
    gulp.watch(assetsDir + 'sass/**/*.scss', ['sass']);
    gulp.watch(assetsDir + 'sass/**/*.sass', ['sass']);
});

var siteDomain = 'dev.laundrypro.ru/';

//livereload and open project in browser (for backend)
gulp.task('browser-sync', function() {
    browserSync.init({
        proxy: siteDomain
    });
});


//---------------------------------building final project folder

//copy, minify css
gulp.task('cssBuild', function () {
    return gulp.src(outputDir + 'css/**/*')
        .pipe(purify([outputDir + 'js/**/*', outputDir + '**/*.html']))
        .pipe(csso())
        .pipe(gulp.dest(buildDir + 'css/'));
});

//copy and minify js
gulp.task('jsBuild', function () {
    return gulp.src(outputDir + 'js/**/*')
        .pipe(uglify())
        .pipe(gulp.dest(buildDir + 'js/'));
});

//--------------------------------------------If you need svg sprite
var svgSprite = require('gulp-svg-sprite'),
    svgmin = require('gulp-svgmin'),
    cheerio = require('gulp-cheerio'),
    replace = require('gulp-replace');

gulp.task('svgSpriteBuild', function () {
    return gulp.src(outputDir + 'img/icons/*.svg')
    // minify svg
        .pipe(svgmin({
            js2svg: {
                pretty: true
            }
        }))
        // remove all fill and style declarations in out shapes
        .pipe(cheerio({
            run: function ($) {
                $('[fill]').removeAttr('fill');
                $('[stroke]').removeAttr('stroke');
                $('[style]').removeAttr('style');
            },
            parserOptions: {xmlMode: true}
        }))
        // cheerio plugin create unnecessary string '&gt;', so replace it.
        .pipe(replace('&gt;', '>'))
        // build svg sprite
        .pipe(svgSprite({
            mode: {
                symbol: {
                    sprite: "../sprite.svg",
                    render: {
                        scss: {
                            dest:'../../../sass/base/_sprite.scss',
                            template: assetsDir + "sass/extra/_sprite_template.scss"
                        }
                    },
                    example: true
                }
            }
        }))
        .pipe(gulp.dest(outputDir + 'img/sprite/'));
});

gulp.task('laravel', ['sass', 'svgSpriteBuild', 'watch__laravel', 'browser-sync']);
