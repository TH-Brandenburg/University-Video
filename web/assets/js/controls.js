// Generated by CoffeeScript 1.8.0
(function() {
  define(["user_interface"], function(UI) {

    /*
        This class handles all the buttons/controls on the player.
        - Play / Pause button
        - Mute Button
        - Playback speed button
        - Fullscreen button
        - Progress bar
        - Volume bar
     */
    var Controls;
    return Controls = (function() {
      Controls.prototype.player = null;

      Controls.prototype.UI = null;

      function Controls(player, $baseElement) {
        this.isSingle = player.isSingle;
        this.player = player;
        this.UI = new UI(this.player, $baseElement);
        this.$controls = $baseElement.find('.controls');
        this.$playButton = $baseElement.find('a.play');
        this.$muteButton = $baseElement.find('a.mute');
        this.$chapterButton = $baseElement.find('a.chapter');
        this.$chapterContent = $baseElement.find('.chapterContent');
        this.$timer = $baseElement.find('.timer');
        this.$seeker = $baseElement.find('.seek');
        this.$seekSlider = $baseElement.find('.seek .slider');
        this.$bufferSlider = $baseElement.find('.seek .buffer');
        this.$volumeBox = $baseElement.find('.volume-box');
        this.$volume = $baseElement.find('.volume');
        this.$volumeSlider = $baseElement.find('.volume .slider');
        this.$fullscreenButton = $baseElement.find('a.fullscreen');
        this.$playbackRateButton = $baseElement.find('.playbackRate');
        this.$annotationsButton = $baseElement.find('.annotations');
        this.$annotationsMenu = $baseElement.find('.annotations_menu');
        this.$wikiLinksButton = $baseElement.find('.toggle_wiki_links');
        this.$webLinksButton = $baseElement.find('.toggle_web_links');
        this.$annotationsWikiOverlay = $baseElement.find('.wiki.overlay');
        this.$annotationsLinksOverlay = $baseElement.find('.link.overlay');
        this.$aspectRatioAbutton = $baseElement.find('div.aspectRatio.speaker');
        this.$aspectRatioBbutton = $baseElement.find('div.aspectRatio.slides');
        this.player.$videoA.on("play pause ended", (function(_this) {
          return function() {
            return _this.updatePlayButton();
          };
        })(this));
        this.player.$videoA.on("progress", (function(_this) {
          return function() {
            return _this.updateSeek();
          };
        })(this));
        this.player.$videoA.on("volumechange", (function(_this) {
          return function() {
            return _this.updateVolume();
          };
        })(this));
        this.player.$videoA.on("timeupdate", (function(_this) {
          return function() {
            _this.updateSeek();
            return _this.updateTime();
          };
        })(this));
        $(window).on("toggleFullscreen", (function(_this) {
          return function() {
            return _this.updateSeek();
          };
        })(this));
        this.updateTime();
        this.updateVolume();
        this.attachButtonHandlers();
        this.attachKeyboardHandlers();
        this.$aspectRatioAbutton.click();
      }

      Controls.prototype.attachButtonHandlers = function() {
        this.$annotationsButton.click((function(_this) {
          return function() {
            _this.$annotationsButton.toggleClass("active");
            return _this.$annotationsMenu.toggleClass("active");
          };
        })(this));
        this.$wikiLinksButton.click((function(_this) {
          return function() {
            _this.$wikiLinksButton.toggleClass("active");
            return _this.$annotationsWikiOverlay.toggleClass("visible");
          };
        })(this));
        this.$webLinksButton.click((function(_this) {
          return function() {
            _this.$webLinksButton.toggleClass("active");
            return _this.$annotationsLinksOverlay.toggleClass("visible");
          };
        })(this));
        this.$playButton.click((function(_this) {
          return function() {
            if (_this.player.videoA.paused) {
              return _this.player.play();
            } else {
              return _this.player.pause();
            }
          };
        })(this));
        this.$chapterButton.click((function(_this) {
          return function() {
            _this.$chapterButton.toggleClass("active");
            if (_this.$chapterContent.hasClass("visible")) {
              return _this.$chapterContent.removeClass("visible");
            } else {
              return _this.$chapterContent.addClass("visible");
            }
          };
        })(this));
        this.$muteButton.click((function(_this) {
          return function() {
            if (!_this.player.muted) {
              return _this.player.mute(true);
            } else {
              return _this.player.mute(false);
            }
          };
        })(this));
        this.$playbackRateButton.click((function(_this) {
          return function() {
            var playbackRate;
            playbackRate = (function() {
              switch (this.player.playbackRate) {
                case 1.0:
                  return 1.3;
                case 1.3:
                  return 1.7;
                case 1.7:
                  return 0.7;
                case 0.7:
                  return 1.0;
              }
            }).call(_this);
            _this.$playbackRateButton.html(playbackRate.toFixed(1) + "x");
            return _this.player.changeSpeed(playbackRate);
          };
        })(this));
        this.$fullscreenButton.click((function(_this) {
          return function() {
            return _this.UI.toggleFullscreen();
          };
        })(this));
        this.$seeker.click((function(_this) {
          return function(event) {
            var pos, sec, vid;
            vid = _this.player.videoA;
            pos = (event.pageX - _this.$seeker.offset().left) / _this.$seeker.width();
            sec = Math.round(pos * vid.duration);
            return _this.player.seek(sec);
          };
        })(this));
        this.$volume.click((function(_this) {
          return function(event) {
            var vid, vol;
            vid = _this.player.videoA;
            vol = (event.pageX - _this.$volume.offset().left) / _this.$volume.width();
            return _this.player.videoA.volume = vol;
          };
        })(this));
        this.$aspectRatioAbutton.click((function(_this) {
          return function(event) {
            var btn, vid;
            vid = _this.UI.videoA;
            btn = _this.$aspectRatioAbutton;
            return _this.toggleAspectRatio(vid, btn);
          };
        })(this));
        return this.$aspectRatioBbutton.click((function(_this) {
          return function(event) {
            var btn, vid;
            vid = _this.UI.videoB;
            btn = _this.$aspectRatioBbutton;
            return _this.toggleAspectRatio(vid, btn);
          };
        })(this));
      };

      Controls.prototype.attachKeyboardHandlers = function() {
        var keyboardControls, player;
        keyboardControls = {
          " ": (function(_this) {
            return function() {
              return _this.player.togglePlay();
            };
          })(this)
        };
        $(window).on("keypress", function(evt) {
          var callback, key, _results;
          _results = [];
          for (key in keyboardControls) {
            callback = keyboardControls[key];
            if (evt.which === key.charCodeAt(0)) {
              _results.push(callback());
            } else {
              _results.push(void 0);
            }
          }
          return _results;
        });
        player = this.player;
        $(window).on("keydown", function(evt) {
          if (evt.which === 0) {
            evt.preventDefault();
          }
          if (evt.which === 37) {
            player.seekBack(10);
          }
          if (evt.which === 39) {
            return player.seekForward(10);
          }
        });
      };

      Controls.prototype.updatePlayButton = function() {
        var vid;
        vid = this.player.videoA;
        if (vid.paused) {
          return this.$playButton.removeClass("pause");
        } else {
          return this.$playButton.addClass("pause");
        }
      };

      Controls.prototype.updateSeek = function() {
        var bufIdA, bufIdB, bufferEnd, bufferWidth, seekWidth, vid;
		
		if(this.UI.isSingle)
		{
			bufIdA = this.player.videoA.buffered.length - 1;
			vid = this.player.videoA;
			seekWidth = (vid.currentTime / vid.duration) * 100;
			if (bufIdA >= 0) {
			  bufferEnd = this.player.videoA.buffered.end(bufIdA);
			  bufferWidth = (bufferEnd / vid.duration) * 100;
			} else {
			  bufferWidth = 0;
			}
			this.$bufferSlider.width("" + bufferWidth + "%");
			return this.$seekSlider.width("" + seekWidth + "%");
		}
		else
		{
			bufIdA = this.player.videoA.buffered.length - 1;
			bufIdB = this.player.videoB.buffered.length - 1;
			vid = this.player.videoA;
			seekWidth = (vid.currentTime / vid.duration) * 100;
			if (bufIdA >= 0 && bufIdB >= 0) {
			  bufferEnd = this.player.videoA.buffered.end(bufIdA);
			  if (bufferEnd > this.player.videoB.buffered.end(bufIdB)) {
				bufferEnd = this.player.videoB.buffered.end(bufIdB);
			  }
			  bufferWidth = (bufferEnd / vid.duration) * 100;
			} else {
			  bufferWidth = 0;
			}
			this.$bufferSlider.width("" + bufferWidth + "%");
			return this.$seekSlider.width("" + seekWidth + "%");
		}
      };

      Controls.prototype.updateTime = function() {
        var hours, minutes, seconds, time;
        seconds = Math.floor(this.player.videoA.currentTime);
        hours = Math.floor(seconds / 3600);
        minutes = Math.floor(seconds / 60) % 60;
        seconds = seconds % 60;
        if (hours > 0) {
          time = hours + ":" + this.zeroPadInt(minutes);
        } else {
          time = minutes;
        }
        time += ":" + this.zeroPadInt(seconds);
        return this.$timer.text(time);
      };

      Controls.prototype.updateVolume = function() {
        var vid;
        vid = this.player.videoA;
        if (this.player.muted) {
          this.$volumeSlider.width("0%");
          return this.$muteButton.addClass("muted");
        } else {
          this.$volumeSlider.width("" + (vid.volume * 100) + "%");
          return this.$muteButton.removeClass("muted");
        }
      };

      Controls.prototype.toggleAspectRatio = function(vid, btn) {
        if (vid.hasClass('aspect-ratio-ws')) {
          vid.removeClass('aspect-ratio-ws');
          btn.text("4:3");
        } else {
          vid.addClass('aspect-ratio-ws');
          btn.text("16:9");
        }
        if (this.isSingle) {
          return this.UI.updateAspectRatio();
        }
      };

      Controls.prototype.zeroPadInt = function(value) {
        if (value < 10) {
          value = "0" + value;
        }
        return value;
      };

      return Controls;

    })();
  });

}).call(this);
