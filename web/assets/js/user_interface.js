var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

define(["../vendor/screenfull/dist/screenfull.min"], function(screenful) {

  /*
      This class is in charge of the user interface. It handles:
      - resizing bar between videos
      - toggle fullscreen mode
   */
  var UserInterface;
  return UserInterface = (function() {
    function UserInterface(player, $baseElement) {
      this.fullscreenOnchange = __bind(this.fullscreenOnchange, this);
      this.isSingle = player.isSingle;
      this.videoA = player.$videoA;
      if (!this.isSingle) {
        this.videoB = player.$videoB;
      }
      this.$videoPlayer = $baseElement.find(".videoPlayer");
      this.$chapterContent = $baseElement.find(".chapterContent");
      this.$resizer = this.$videoPlayer.find(".resizer");
      this.$resizer.mousedown((function(_this) {
        return function(event) {
          event.preventDefault();
          _this.lastPageX = event.pageX;
          return _this.$videoPlayer.on("mousemove", function(event) {
            return _this.resizeVideo(event);
          });
        };
      })(this));
      $("body").mouseup((function(_this) {
        return function(event) {
          event.preventDefault();
          return _this.$videoPlayer.off("mousemove");
        };
      })(this));
      $(window).bind("hashchange", (function(_this) {
        return function() {
          return player.seek(jQuery.deparam(window.location.hash.substring(1))["t"]);
        };
      })(this));
      this.originalWidth = this.$videoPlayer.width();
      this.originalHeight = this.$videoPlayer.height();
      this.ratioA = this.videoA.width() / this.originalWidth;
      if (!this.isSingle) {
        this.ratioB = this.videoB.width() / this.originalWidth;
      }
      this.controlsHeight = $baseElement.find(".controlsBox").height();
    }

    UserInterface.prototype.toggleFullscreen = function() {
      if (screenfull.isFullscreen) {
        screenfull.exit();
        return;
      }
      screenfull.onchange = this.fullscreenOnchange;
      screenfull.request(this.$videoPlayer[0]);
    };

    UserInterface.prototype.setFullscreenCss = function() {
      var aHeight, aWidth, bHeight, bWidth, ratio, screenHeight, screenWidth;
      this.$videoPlayer.find(".button.fullscreen").addClass("active");
      this.$chapterContent.height(screen.height);
      this.$videoPlayer.width('100%');
      this.$videoPlayer.height(screen.height);
      screenWidth = screen.width;
      screenHeight = screen.height - this.controlsHeight;
      if (this.isSingle) {
        this.videoA.parent().width(screenWidth);
        if (this.videoA.parent().height() > screenHeight) {
          this.videoA.parent().height(screenHeight);
        }
      } else {
        aWidth = this.videoA.width();
        bWidth = this.videoB.width();
        if (aWidth > bWidth) {
          ratio = aWidth / this.videoA.height();
          aHeight = screenHeight;
          aWidth = aHeight * ratio;
          this.videoA.parent().width(aWidth);
          this.videoB.parent().width(screenWidth - aWidth);
        } else {
          ratio = bWidth / this.videoB.height();
          bHeight = screenHeight;
          bWidth = bHeight * ratio;
          this.videoA.parent().width(screenWidth - bWidth);
          this.videoB.parent().width(bWidth);
        }
      }
      return this.$resizer.css("left", this.videoA.parent().width());
    };

    UserInterface.prototype.setNormalCss = function() {
      this.$videoPlayer.find(".button.fullscreen").removeClass("active");
      this.$chapterContent.height(this.originalHeight);
      this.$videoPlayer.width(this.originalWidth);
      this.$videoPlayer.height(this.originalHeight);
      if (this.isSingle) {
        this.videoA.parent().width(this.originalWidth);
        this.$videoPlayer.height(this.videoA.parent().height() + this.controlsHeight);
      } else {
        this.videoA.parent().width(this.originalWidth * this.ratioA);
        this.videoB.parent().width(this.originalWidth * this.ratioB);
      }
      return this.$resizer.css("left", this.videoA.parent().width());
    };

    UserInterface.prototype.fullscreenOnchange = function() {
      if (screenfull.isFullscreen) {
        this.setFullscreenCss();
      } else {
        this.setNormalCss();
      }
      return $(window).trigger("toggleFullscreen");
    };

    UserInterface.prototype.updateAspectRatio = function() {
      if (screenfull.isFullscreen) {
        return this.setFullscreenCss();
      } else {
        return this.setNormalCss();
      }
    };

    UserInterface.prototype.resizeVideo = function(event) {
      var aHeight, aHeightRatio, aWidth, bHeight, bHeightRatio, bWidth, delta, screenHeight, screenWidth, videoHeight;
      if (screenfull.isFullscreen) {
        screenWidth = screen.width;
        screenHeight = screen.height;
      } else {
        screenWidth = this.originalWidth;
        screenHeight = this.originalHeight;
      }
      if (this.isSingle) {
        if (screenfull.isFullscreen) {
          this.setFullscreenCss();
        } else {
          this.setNormalCss();
        }
      } else {
        aWidth = this.videoA.width();
        bWidth = this.videoB.width();
        aHeightRatio = this.videoA.height() / aWidth;
        bHeightRatio = this.videoB.height() / bWidth;
        delta = event.pageX - this.lastPageX;
        aWidth += delta;
        bWidth = screenWidth - aWidth;
        aHeight = aWidth * aHeightRatio;
        bHeight = bWidth * bHeightRatio;
        videoHeight = screenHeight - this.controlsHeight;
        if (aHeight > videoHeight) {
          aWidth = videoHeight / aHeightRatio;
          bWidth = screenWidth - aWidth;
        }
        if (bHeight > videoHeight) {
          bWidth = videoHeight / bHeightRatio;
          aWidth = screenWidth - bWidth;
        }
        this.videoA.parent().width(aWidth);
        this.videoB.parent().width(bWidth);
        this.$resizer.css("left", aWidth);
      }
      this.lastPageX = event.pageX;
      if (screenfull.isFullscreen) {
        screenWidth = screen.width;
      } else {
        screenWidth = this.originalWidth;
      }
      this.ratioA = aWidth / screenWidth;
      return this.ratioB = 1 - this.ratioA;
    };

    return UserInterface;

  })();
});