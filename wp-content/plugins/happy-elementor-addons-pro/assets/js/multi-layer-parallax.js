"use strict";

(function ($, w) {
  "use strict";

  var $window = $(w);
  $.fn.smoothParallaxMotion = function (options) {
    var instance = this,
      $target = $(this),
      scrollEffects = $target.data("scrolls"),
      config = options,
      elementType = config.elType;
    instance.transformRules = {};
    instance.isScrolling = false;

    // Public methods
    instance.initialize = function () {
      if (scrollEffects || 'SECTION' === elementType) {
        if (!config.effects.length) {
          return instance;
        }
        instance.setupDefaultSettings();
        instance.bindScrollEvents();
      } else {
        instance.unbindScrollEvents();
        return instance;
      }
      return instance;
    };
    instance.setupDefaultSettings = function () {
      config.defaults = $.extend({
        axis: 'y',
        unit: 'px'
      }, config.defaults || {});
    };
    instance.bindScrollEvents = function () {
      if (typeof elementorFrontend !== 'undefined' && elementorFrontend.elements && elementorFrontend.elements.$window) {
        elementorFrontend.elements.$window.on('scroll.parallax load.parallax', instance.handleScrollThrottled);
      } else {
        $(window).on('scroll.parallax load.parallax', instance.handleScrollThrottled);
      }
    };
    instance.unbindScrollEvents = function () {
      if (typeof elementorFrontend !== 'undefined' && elementorFrontend.elements && elementorFrontend.elements.$window) {
        elementorFrontend.elements.$window.off('scroll.parallax load.parallax', instance.handleScrollThrottled);
      } else {
        $(window).off('scroll.parallax load.parallax', instance.handleScrollThrottled);
      }
    };
    instance.handleScrollThrottled = function () {
      if (!instance.isScrolling) {
        requestAnimationFrame(instance.processScrollEffects);
        instance.isScrolling = true;
      }
    };
    instance.processScrollEffects = function () {
      if (config.effects.includes('translateY')) {
        instance.applyVerticalTransform();
      }
      if (config.effects.includes('translateX')) {
        instance.applyHorizontalTransform();
      }
      if (config.effects.includes('rotate')) {
        instance.applyRotationTransform();
      }
      instance.isScrolling = false;
    };
    instance.applyVerticalTransform = function () {
      var scrollProgress = instance.calculateScrollProgress();
      instance.executeTransform('translateY', scrollProgress, config.vscroll);
    };
    instance.applyHorizontalTransform = function () {
      var scrollProgress = instance.calculateScrollProgress();
      instance.executeTransform('translateX', scrollProgress, config.hscroll);
    };
    instance.applyRotationTransform = function () {
      var scrollProgress = instance.calculateScrollProgress();
      instance.executeTransform('rotate', scrollProgress, config.rotation || {});
    };
    instance.executeTransform = function (transformType, progressPercent, transformData) {
      if (!transformData) return;

      // Handle direction
      if ("down" === transformData.direction) {
        progressPercent = 100 - progressPercent;
      }

      // Apply range constraints
      if (transformData.range) {
        progressPercent = Math.max(transformData.range.start || 0, Math.min(transformData.range.end || 100, progressPercent));
      }

      // Set appropriate unit
      var unit = instance.getTransformUnit(transformType);
      var transformValue = instance.calculateTransformStep(progressPercent, transformData) + unit;
      instance.applyElementTransform('transform', transformType, transformValue);
    };
    instance.getTransformUnit = function (transformType) {
      switch (transformType) {
        case 'rotate':
          return 'deg';
        case 'scale':
          return '';
        default:
          return config.defaults.unit || 'px';
      }
    };
    instance.calculateScrollProgress = function () {
      var viewport = instance.getViewportDimensions();
      var windowHeight = window.innerHeight;
      var elementTopRelativeToWindow = viewport.elementTop - window.pageYOffset;
      var elementEntryPoint = elementTopRelativeToWindow - windowHeight;
      var progressPercent = 100 / viewport.scrollRange * (elementEntryPoint * -1);

      // Clamp between 0 and 100
      return Math.max(0, Math.min(100, progressPercent));
    };
    instance.getViewportDimensions = function () {
      if (!$target.length) return {};
      var elementOffset = $target.offset();
      var dimensions = {
        elementHeight: $target.outerHeight() || 0,
        elementWidth: $target.outerWidth() || 0,
        elementTop: elementOffset ? elementOffset.top : 0,
        elementLeft: elementOffset ? elementOffset.left : 0
      };
      dimensions.scrollRange = dimensions.elementHeight + window.innerHeight;
      return dimensions;
    };
    instance.calculateTransformStep = function (progressPercent, transformOptions) {
      var speed = transformOptions.speed || 1;
      var offset = transformOptions.offset || 50;
      return -(progressPercent - offset) * speed;
    };
    instance.applyElementTransform = function (cssProperty, transformKey, transformValue) {
      if (!instance.transformRules[cssProperty]) {
        instance.transformRules[cssProperty] = {};
      }
      if (!instance.transformRules[cssProperty][transformKey]) {
        instance.transformRules[cssProperty][transformKey] = true;
        instance.buildTransformRule(cssProperty);
      }
      var cssVariableName = '--' + transformKey;
      $(this)[0].style.setProperty(cssVariableName, transformValue);
    };
    instance.buildTransformRule = function (cssProperty) {
      var transformString = '';
      $.each(instance.transformRules[cssProperty], function (transformFunction) {
        transformString += transformFunction + '(var(--' + transformFunction + ')) ';
      });
      $target.css(cssProperty, transformString.trim());
    };
    instance.checkElementVisibility = function () {
      if (!$target.length) return false;
      var elementOffset = $target.offset();
      if (!elementOffset) return false;
      var elementTop = elementOffset.top;
      var elementBottom = elementTop + $target.outerHeight();
      var windowTop = $(window).scrollTop();
      var windowBottom = windowTop + $(window).height();
      return elementBottom > windowTop && elementTop < windowBottom;
    };
    instance.destroy = function () {
      instance.unbindScrollEvents();
      instance.transformRules = {};
      $target.css('transform', '');
      return instance;
    };
    instance.refresh = function () {
      instance.processScrollEffects();
      return instance;
    };

    // Auto-initialize
    return instance.initialize();
  };

  // Usage wrapper function for backward compatibility
  w.smoothParallaxMotion = function (element, settings) {
    return $(element).smoothParallaxMotion(settings);
  };
  $window.on("elementor/frontend/init", function () {
    var MultiLayerParallaxHandler = function MultiLayerParallaxHandler($scope) {
      if (!$scope.hasClass("ha-multi-layer-parallax--yes")) return;
      var target = $scope,
        widget_id = target.data("id"),
        editor_target = target.find('#ha-multi-layer-parallax--' + widget_id),
        editMode = elementorFrontend.isEditMode() && editor_target.length > 0,
        target_dom = editMode ? editor_target : target;
      var layerSettings = target_dom.data("ha-multi-layer-parallax");
      if (!layerSettings && 0 == Object.keys(layerSettings).length && !layerSettings["items"]) {
        return false;
      }
      var currentDevice = elementorFrontend.getCurrentDeviceMode();
      generateMultiLayers(currentDevice);
      function generateMultiLayers(currentDevice) {
        var mouseParallax = "",
          deviceSuffix = 'desktop' === currentDevice ? '' : '_' + currentDevice,
          mouseRate = "";
        target.find(".ha-multi-layer-parallax").remove();
        $.each(layerSettings.items, function (index, layout) {
          if (!layout.show_layer_on.includes(currentDevice)) {
            return;
          }
          var layerHTML = '',
            imgID = '' != layout.ha_multi_layer_parallax_id ? 'id="' + layout.ha_multi_layer_parallax_id + '"' : '';
          if ('img' === layout.layer_type && null !== layout["ha_multi_layer_parallax_image"]["url"] && "" !== layout["ha_multi_layer_parallax_image"]["url"]) {
            var backgroundImage = layout["ha_multi_layer_parallax_image"]["url"],
              alt = layout['alt'];
            layerHTML = '<img ' + imgID + ' class="ha-multi-layer-parallax-img" src="' + backgroundImage + '" alt="' + alt + '">';
          }
          if ('' == layerHTML) {
            return;
          }
          var layerID = 'ha-multi-layer-parallax-' + layout._id,
            layerPosition = ' ha-multi-layer-parallax-' + layout.ha_multi_layer_parallax_hor + ' ha-multi-layer-parallax-' + layout.ha_multi_layer_parallax_ver,
            layerType = ' ha-multi-layer-parallax-' + layout.layer_type;
          if ("mouse_track" === layout.ha_multi_layer_parallax_effect_type && "" !== layout.ha_multi_layer_parallax_rate) {
            mouseParallax = ' data-parallax="true" ';
            mouseRate = ' data-rate="' + layout.ha_multi_layer_parallax_rate + '" ';
          } else {
            mouseParallax = ' data-parallax="false" ';
          }
          if ('img' === layout.layer_type) {
            var width = 'undefined' != typeof layout["ha_multi_layer_parallax_width" + deviceSuffix] ? layout["ha_multi_layer_parallax_width" + deviceSuffix].size : layout["ha_multi_layer_parallax_width"].size;
          }
          $('<div id="' + layerID + '"' + mouseParallax + mouseRate + ' class="ha-multi-layer-parallax elementor-repeater-item-' + layout._id + layerPosition + layerType + '">' + layerHTML + '</div>').prependTo(target).css({
            "z-index": layout["ha_multi_layer_parallax_z_index"],
            "background-size": layout["ha_multi_layer_parallax_back_size"],
            "width": 'img' === layout.layer_type ? width + "%" : "auto"
          });
          var $layer = target.find('#' + layerID);
          if ('custom' === layout.ha_multi_layer_parallax_hor) {
            var left = 'undefined' != typeof layout["ha_multi_layer_parallax_hor_pos" + deviceSuffix] ? layout["ha_multi_layer_parallax_hor_pos" + deviceSuffix].size : layout["ha_multi_layer_parallax_hor_pos"].size;
            $layer.css('left', left + '%');
          }
          if ('custom' === layout.ha_multi_layer_parallax_ver) {
            var top = 'undefined' != typeof layout["ha_multi_layer_parallax_ver_pos" + deviceSuffix] ? layout["ha_multi_layer_parallax_ver_pos" + deviceSuffix].size : layout["ha_multi_layer_parallax_ver_pos"].size;
            $layer.css('top', top + '%');
          }
          if (layerSettings.devices.includes(currentDevice) && 'scroll_parallax' === layout['ha_multi_layer_parallax_effect_type']) {
            if ('yes' === layout['ha_multi_layer_parallax_scroll_hor']) {
              $layer.attr({
                'data-parallax-scroll': 'yes',
                'data-parallax-hscroll': 'yes',
                'data-parallax-hscroll_speed': layout['ha_multi_layer_parallax_speed_hor']['size'],
                'data-parallax-hscroll_start': layout['ha_multi_layer_parallax_view_hor']['sizes']['start'],
                'data-parallax-hscroll_end': layout['ha_multi_layer_parallax_view_hor']['sizes']['end'],
                'data-parallax-hscroll_direction': layout['ha_multi_layer_parallax_direction_hor']
              });
            }
            if ('yes' === layout['ha_multi_layer_parallax_scroll_ver']) {
              $layer.attr({
                'data-parallax-scroll': 'yes',
                'data-parallax-vscroll': 'yes',
                'data-parallax-speed': layout['ha_multi_layer_parallax_speed']['size'],
                'data-parallax-start': layout['ha_multi_layer_parallax_view']['sizes']['start'],
                'data-parallax-end': layout['ha_multi_layer_parallax_view']['sizes']['end'],
                // 'data-parallax-end': 200,
                'data-parallax-direction': layout['ha_multi_layer_parallax_direction']
              });
            }
          }
        });
        if (-1 !== layerSettings.devices.indexOf(currentDevice)) {
          target.find('.ha-multi-layer-parallax').each(function (index, layer) {
            var data = $(layer).data();
            if ('yes' === data.parallaxScroll) {
              var effects = [],
                vScrollSettings = {},
                hScrollSettings = {},
                settings = {};
              if ('yes' === data.parallaxVscroll) {
                effects.push('translateY');
                vScrollSettings = {
                  speed: data.parallaxSpeed,
                  direction: data.parallaxDirection,
                  range: {
                    start: data.parallaxStart,
                    end: data.parallaxEnd
                  }
                };
              }
              if ('yes' === data.parallaxHscroll) {
                effects.push('translateX');
                hScrollSettings = {
                  speed: data.parallaxHscroll_speed,
                  direction: data.parallaxHscroll_direction,
                  range: {
                    start: data.parallaxHscroll_start,
                    end: data.parallaxHscroll_end
                  }
                };
              }
              settings = {
                elType: 'SECTION',
                vscroll: vScrollSettings,
                hscroll: hScrollSettings,
                effects: effects
              };
              w.smoothParallaxMotion(layer, settings);
            }
          });
        }
        target.mousemove(function (e) {
          $(this).find('.ha-multi-layer-parallax[data-parallax="true"]').each(function () {
            var $this = $(this),
              resistance = $(this).data("rate");
            TweenLite.to($this, 0.2, {
              x: -((e.clientX - window.innerWidth / 2) / resistance),
              y: -((e.clientY - window.innerHeight / 2) / resistance)
            });
          });
        });
      }
    };
    elementorFrontend.hooks.addAction("frontend/element_ready/section", MultiLayerParallaxHandler);
    elementorFrontend.hooks.addAction("frontend/element_ready/container", MultiLayerParallaxHandler);
  });
})(jQuery, window);