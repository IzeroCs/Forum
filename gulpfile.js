var gulp       = require("gulp");
var gutil      = require("gulp-util");
var sass       = require("gulp-sass");
var plumber    = require("gulp-plumber");
var concat     = require("gulp-concat");
var rename     = require("gulp-rename");
var livereload = require("gulp-livereload");
var minifyCss  = require("gulp-cssnano");
var minifyJs   = require("gulp-uglify");

gulp.task("compress", function() {
    gutil.log("Js is change");

    return gulp.src("assets/js/**/*")
               .pipe(minifyJs())
               .pipe(rename("app.min.js"))
               .pipe(gulp.dest("assets/min"));
});

gulp.task("sass", function() {
    gutil.log("Css is change");

    return gulp.src("assets/sass/*.scss")
               .pipe(plumber({
                    errorHandler: function(error) {
                        gutil.log(error.toString());
                        this.emit("end");
                    }
               }))
               .pipe(sass())
               .pipe(minifyCss())
               .pipe(rename("theme.min.css"))
               .pipe(gulp.dest("assets/min"))
               .pipe(livereload());
});

gulp.task("watch", function() {
    gutil.log("Gulp watch");
    livereload.listen();

    gulp.watch([ "assets/sass/*.scss" ], [ "sass" ]);
    gulp.watch([ "assets/js/*.js" ], [ "compress" ]);
});

gulp.task("default", [
    "sass",
    "compress",
    "watch"
]);