const gulp       = require('gulp');
const notify     = require('gulp-notify');
const sass       = require('gulp-sass');
const concat     = require('gulp-concat');
const rename     = require('gulp-rename');
const cleanCSS   = require('gulp-clean-css');
const uglify     = require('gulp-uglify');
const sourcemaps = require('gulp-sourcemaps');

//https://hackersandslackers.com/upgrading-to-gulp-4/

var paths = {
    styles: {
        name: 'main',
        main: './src/sass/main.scss',
        src: './src/sass/**/*',
        dest: 'site/templates/styles/'
    },
    images: {
        src: './site/assets/files/**/*',
        dest: './site/assets/files-optimized/'
    },
    build: './src/build/',
};


var jsStream = [
    'src/js/base.js',
    'src/js/home-header.js',
    'src/js/stakeholders.js',
    'src/js/menu.js',
    'src/js/parallax.js'
];

function styles() {
    return gulp
    .src(paths.styles.main)
    .pipe(sourcemaps.init())
    .pipe(sass({
        style: "expanded",
    }))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(paths.styles.dest))
    .pipe(notify({ message : "sass build complete"}));
}

function scripts() {
    return gulp
        .src(jsStream)
        .pipe(concat('main.js'))
        .pipe(gulp.dest('site/templates/scripts/'))
        .pipe(notify({ message : 'all done with js files concatting'}));
}

function watch() {
    gulp.watch('./src/sass/**/*', styles);
    gulp.watch('./src/js/**/*', scripts);
}

exports.styles = styles;
exports.watch = watch;
exports.scripts = scripts;
