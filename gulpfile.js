var gulp       = require("gulp");
var gutil      = require("gulp-util");
var sass       = require("gulp-sass");
var plumber    = require("gulp-plumber");
var concat     = require("gulp-concat");
var rename     = require("gulp-rename");
var livereload = require("gulp-livereload");
var minifyCss  = require("gulp-cssnano");
var minifyJs   = require("gulp-uglify");
var cssbeautify = require('gulp-cssbeautify');

gulp.task("compress", function() {
    gutil.log("Js is change");

    return gulp.src("app/res/default/js/app.js")
               .pipe(rename("app.js"))
               .pipe(gulp.dest("public/default"))
               .pipe(minifyJs())
               .pipe(rename("app.min.js"))
               .pipe(gulp.dest("public/default"));
});

gulp.task("sass", function() {
    gutil.log("Css is change");

    return gulp.src("app/res/default/sass/app.scss")
               .pipe(plumber({
                    errorHandler: function(error) {
                        gutil.log(error.toString());
                        this.emit("end");
                    }
               }))
               .pipe(sass())
               .pipe(cssbeautify())
               .pipe(rename("app.css"))
               .pipe(gulp.dest("public/default"))
               .pipe(minifyCss())
               .pipe(rename("app.min.css"))
               .pipe(gulp.dest("public/default"))
               .pipe(livereload());
});

gulp.task("watch", function() {
    gutil.log("Gulp watch");
    livereload.listen();

    gulp.watch([ "app/res/default/sass/**/*.scss" ], [ "sass" ]);
    gulp.watch([ "app/res/default/js/**/*.js" ], [ "compress" ]);
});

gulp.task("default", [
    "sass",
    "compress",
    "watch"
]);