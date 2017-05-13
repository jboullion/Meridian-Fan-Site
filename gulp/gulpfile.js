//THIS SHOULD MATCH YOUR THEME NAME
var THEME = 'meridian';

var gulp = require('gulp');
var uglify = require('gulp-uglify');
//var livereload = require('gulp-livereload');
var concat = require('gulp-concat');
var minifycss = require('gulp-minify-css');
var autoprefixer = require('gulp-autoprefixer');
var plumber = require('gulp-plumber');
var sourcemaps = require('gulp-sourcemaps');
var rename = require('gulp-rename');
var browserSync = require('browser-sync').create();

var sass = require('gulp-sass');

//var babel = require('gulp-babel');

//var handlebars = require('gulp-handlebars');
//var handlebarsLib = require('handlebars');
//var declare = require('gulp-declare');
//var wrap = require('gulp-wrap');

//Image Compression
var imagemin = require('gulp-imagemin');
var imageminPngquant = require('imagemin-pngquant');
var imageminJpegRecompress = require('imagemin-jpeg-recompress');

//delete
//var del = require('del');

//zip
//var zip = require('gulp-zip');

/*
var less = require('gulp-less');
var LessAutoprefixer = require('less-plugin-autoprefix');
var lessAutoprefixer = new LessAutoprefixer({
  browsers: ['last 2 versions']
})
*/
//var pump = require('pump'); //this is an error handling plugin. Not needed yet

//file paths
var SRC_PATH = './';
var THEME_PATH = '../wp-content/themes/'+THEME+'/';
var SCRIPTS_PATH = SRC_PATH+'scripts/*.js';
var SCRIPTS_WATCH_PATH = SRC_PATH+'scripts/**/*.js';

//var CSS_PATH = 'src-files/css/**/*.css';
var SCSS_PATH = SRC_PATH+'scss/styles.scss';
var SCSS_WATCH_PATH = SRC_PATH+'scss/**/*.scss';
//var LESS_PATH = 'less/styles.less';
//var TEMPLATES_PATH = 'templates/**/*.hbs';
var IMAGES_PATH = SRC_PATH+'images/**/*.{jpg,png,jpeg,svg,gif}';
var UPLOAD_PATH = '../wp-content/uploads/**/*.{jpg,png,jpeg,svg,gif}';


// Styles
/**
 * Plain CSS task
 */
// gulp.task('styles', function() {
//     console.log('Styling...');
//
//     return gulp.src(['src-files/css/reset.css', CSS_PATH]) //always get reset.css first, then glob all others
//         .pipe(plumber(function(err){
//           console.log('Styles Task Error');
//           console.log(err);
//           this.emit('end'); //this line will stop this task chain but continue running gulp
//         }))
//         .pipe(sourcemaps.init())
//         .pipe(autoprefixer({
//           browsers: ['last 2 versions']
//         }))
//         .pipe(concat('live.css')) //take all stylesheets and put them into live.css
//         .pipe(minifycss())
//         .pipe(sourcemaps.write())
//         .pipe(gulp.dest(THEME_PATH + '/css'))
//         .pipe(livereload());
// });

/**
 * SCSS/SASS task
 */

gulp.task('sass-styles', function() {
    console.log('Styling...');

    return gulp.src(SCSS_PATH)
        .pipe(plumber(function(err){
          //this function will run WHEN an error occurs in this task
          console.log('Styles Task Error');
          console.log(err);
          this.emit('end'); //this line will stop this task chain but continue running gulp
        }))
        .pipe(sourcemaps.init())
        .pipe(autoprefixer({
          browsers: ['last 2 versions']
        }))
        .pipe(sass({
          outputStyle: 'compressed'
        })
          .on('error', sass.logError))
        .pipe(rename({
            basename: "live"
          }))
        .pipe(gulp.dest(THEME_PATH + '/styles'))
        .pipe(sourcemaps.write())
        .pipe(rename({
            basename: "dev"
          }))
        .pipe(gulp.dest(THEME_PATH + '/styles'));
        //.pipe(livereload());
});

/**
 * LESS task
 */
/*
gulp.task('less-styles', function() {
    console.log('Styling...');

    return gulp.src(LESS_PATH)
        .pipe(plumber(function(err){
          //this function will run WHEN an error occurs in this task
          console.log('Styles Task Error');
          console.log(err);
          this.emit('end'); //this line will stop this task chain but continue running gulp
        }))
        .pipe(sourcemaps.init())
        .pipe(less({
          plugins: [lessAutoprefixer]
        }))
        .pipe(minifycss())
        .pipe(rename({
            basename: "live"
          }))
        .pipe(gulp.dest(THEME_PATH + '/styles'))
        .pipe(sourcemaps.write())
        .pipe(rename({
            basename: "dev"
          }))
        .pipe(gulp.dest(THEME_PATH + '/styles'));

        //.pipe(livereload());
});
*/

// Scripts
gulp.task('scripts', function() {
    console.log('Scripting...');

    return gulp.src([SRC_PATH+'scripts/variables.js',SRC_PATH+'scripts/functions.js',SRC_PATH+'scripts/site.js', SCRIPTS_PATH])
        .pipe(plumber(function(err){
          //this function will run WHEN an error occurs in this task
          console.log('Styles Task Error');
          console.log(err);
          this.emit('end'); //this line will stop this task chain but continue running gulp
        }))
        .pipe(uglify())
        .pipe(concat('live.js'))
        .pipe(gulp.dest(THEME_PATH + '/js'));
        //.pipe(livereload());
});

//Handlebars Templates
/*
gulp.task('templates', function(){
    console.log('Templating...');

    return gulp.src(TEMPLATES_PATH)
      .pipe(handlebars({
        handlebars: handlebarsLib
      }))
      .pipe(wrap('Handlebars.template(<%= contents %>)'))
      .pipe(declare({
        namespace: 'templates',
        noRedeclare: true
      }))
      .pipe(concat('templates.js'))
      .pipe(gulp.dest(THEME_PATH + '/scripts'))
      .pipe(livereload());

});
*/

// Images
gulp.task('images', ['uploads'], function() {
    console.log('Imaging...');

    return gulp.src(IMAGES_PATH)
      .pipe(imagemin(
        [
          imagemin.gifsicle(),
          imagemin.jpegtran(),
          imagemin.optipng(),
          imagemin.svgo(),
          imageminJpegRecompress(),
          imageminPngquant(),
        ]
      ))
      .pipe(gulp.dest(THEME_PATH + '/images'));

});

// Uploads
gulp.task('uploads', function() {
    console.log('Uploaded Image...');

    return gulp.src(UPLOAD_PATH)
      .pipe(imagemin(
        [
          imagemin.gifsicle(),
          imagemin.jpegtran(),
          imagemin.optipng(),
          imagemin.svgo(),
          imageminJpegRecompress(),
          imageminPngquant(),
        ]
      ))
      .pipe(gulp.dest(function(file) {
        return file.base;
      }));

});

//Clean workspace
/**
 * CRAZY DANGEROUS. DO NOT USE UNLESS YOU HAVE A VERY GOOD REASON.
 */
/*
gulp.task('clean', function(){
  console.log('Cleaning...');
  return del.sync([
    THEME_PATH+'/**', '!'+THEME_PATH //You have to explicitly ignore the parent directories. /** also matches parent directory
  ]);
});
*/

//Export src files to zip

// gulp.task('export', function(){
//   console.log('Exporting...');
//   return gulp.src('**/*')
//     .pipe(zip('website.zip'))
//     .pipe(gulp.dest('./'));
// });

gulp.task('browser-sync', function(){
    console.log('Syncing...');
    browserSync.init({
        proxy: "http://localhost/meridian"
  });

    gulp.watch(THEME_PATH + "/styles/*.css").on('change', browserSync.reload);
    gulp.watch(THEME_PATH + "/js/*.js").on('change', browserSync.reload);
    gulp.watch(THEME_PATH + "/**/*.php").on('change', browserSync.reload);
});

// Default task, will run all common tasks at once
gulp.task('default', ['sass-styles','scripts','browser-sync'], function() { //
    console.log('Gulping...');
});

// Setup gulp dev server
gulp.task('watch', ['default'], function() {
    console.log('Watching you...');
    //require('./server'); //used only on node servers
    //livereload.listen(); //used only on node servers
    gulp.watch(SCRIPTS_WATCH_PATH, ['scripts']);
    //gulp.watch(CSS_PATH, ['styles']);
    gulp.watch(SCSS_WATCH_PATH, ['sass-styles']);
    //gulp.watch(LESS_PATH, ['less-styles']);
    //gulp.watch(TEMPLATES_PATH, ['templates']);
    //gulp.watch(IMAGES_PATH, ['images']);
    //gulp.watch(UPLOAD_PATH, ['uploads']); //this can get stuck on an infinite loop :(
});
