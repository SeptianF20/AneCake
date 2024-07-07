/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ (() => {

/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Version: 4.0.0.
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Main Js File
*/

(function ($) {
  'use strict';

  var language = localStorage.getItem('language');
  // Default Language
  var default_lang = 'en';
  function setLanguage(lang) {
    if (document.getElementById('header-lang-img')) {
      if (lang == 'en') {
        document.getElementById('header-lang-img').src = 'assets/images/flags/us.jpg';
      } else if (lang == 'sp') {
        document.getElementById('header-lang-img').src = 'assets/images/flags/spain.jpg';
      } else if (lang == 'gr') {
        document.getElementById('header-lang-img').src = 'assets/images/flags/germany.jpg';
      } else if (lang == 'it') {
        document.getElementById('header-lang-img').src = 'assets/images/flags/italy.jpg';
      } else if (lang == 'ru') {
        document.getElementById('header-lang-img').src = 'assets/images/flags/russia.jpg';
      } else if (lang == 'id') {
        document.getElementById('header-lang-img').src = 'assets/images/flags/indonesia.png';
      }
      localStorage.setItem('language', lang);
      language = localStorage.getItem('language');
      getLanguage();
    }
  }

  // Multi language setting
  function getLanguage() {
    language == null ? setLanguage(default_lang) : false;
    $.getJSON('assets/lang/' + language + '.json', function (lang) {
      $('html').attr('lang', language);
      $.each(lang, function (index, val) {
        index === 'head' ? $(document).attr('title', val['title']) : false;
        $("[key='" + index + "']").text(val);
      });
    });
  }
  function initMetisMenu() {
    //metis menu
    $('#side-menu').metisMenu();
  }
  function initLeftMenuCollapse() {
    $('#vertical-menu-btn').on('click', function (event) {
      event.preventDefault();
      $('body').toggleClass('sidebar-enable');
      if ($(window).width() >= 992) {
        $('body').toggleClass('vertical-collpsed');
      } else {
        $('body').removeClass('vertical-collpsed');
      }
    });
  }
  function initActiveMenu() {
    // === following js will activate the menu in left side bar based on url ====
    $('#sidebar-menu a').each(function () {
      var pageUrl = window.location.href.split(/[?#]/)[0];
      if (this.href == pageUrl) {
        $(this).addClass('active');
        $(this).parent().addClass('mm-active'); // add active to li of the current link
        $(this).parent().parent().addClass('mm-show');
        $(this).parent().parent().prev().addClass('mm-active'); // add active class to an anchor
        $(this).parent().parent().parent().addClass('mm-active');
        $(this).parent().parent().parent().parent().addClass('mm-show'); // add active to li of the current link
        $(this).parent().parent().parent().parent().parent().addClass('mm-active');
      }
    });
  }
  function initMenuItemScroll() {
    // focus active menu in left sidebar
    $(document).ready(function () {
      if ($('#sidebar-menu').length > 0 && $('#sidebar-menu .mm-active .active').length > 0) {
        var activeMenu = $('#sidebar-menu .mm-active .active').offset().top;
        if (activeMenu > 300) {
          activeMenu = activeMenu - 300;
          $('.vertical-menu .simplebar-content-wrapper').animate({
            scrollTop: activeMenu
          }, 'slow');
        }
      }
    });
  }
  function initHoriMenuActive() {
    $('.navbar-nav a').each(function () {
      var pageUrl = window.location.href.split(/[?#]/)[0];
      if (this.href == pageUrl) {
        $(this).addClass('active');
        $(this).parent().addClass('active');
        $(this).parent().parent().addClass('active');
        $(this).parent().parent().parent().addClass('active');
        $(this).parent().parent().parent().parent().addClass('active');
        $(this).parent().parent().parent().parent().parent().addClass('active');
        $(this).parent().parent().parent().parent().parent().parent().addClass('active');
      }
    });
  }
  function initFullScreen() {
    $('[data-bs-toggle="fullscreen"]').on('click', function (e) {
      e.preventDefault();
      $('body').toggleClass('fullscreen-enable');
      if (!document.fullscreenElement && /* alternative standard method */!document.mozFullScreenElement && !document.webkitFullscreenElement) {
        // current working methods
        if (document.documentElement.requestFullscreen) {
          document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
          document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
      } else {
        if (document.cancelFullScreen) {
          document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
          document.webkitCancelFullScreen();
        }
      }
    });
    document.addEventListener('fullscreenchange', exitHandler);
    document.addEventListener('webkitfullscreenchange', exitHandler);
    document.addEventListener('mozfullscreenchange', exitHandler);
    function exitHandler() {
      if (!document.webkitIsFullScreen && !document.mozFullScreen && !document.msFullscreenElement) {
        console.log('pressed');
        $('body').removeClass('fullscreen-enable');
      }
    }
  }
  function initRightSidebar() {
    // right side-bar toggle
    $('.right-bar-toggle').on('click', function (e) {
      $('body').toggleClass('right-bar-enabled');
    });
    $(document).on('click', 'body', function (e) {
      if ($(e.target).closest('.right-bar-toggle, .right-bar').length > 0) {
        return;
      }
      $('body').removeClass('right-bar-enabled');
      return;
    });
  }
  function initDropdownMenu() {
    if (document.getElementById('topnav-menu-content')) {
      var elements = document.getElementById('topnav-menu-content').getElementsByTagName('a');
      for (var i = 0, len = elements.length; i < len; i++) {
        elements[i].onclick = function (elem) {
          if (elem.target.getAttribute('href') === '#') {
            elem.target.parentElement.classList.toggle('active');
            elem.target.nextElementSibling.classList.toggle('show');
          }
        };
      }
      window.addEventListener('resize', updateMenu);
    }
  }
  function updateMenu() {
    var elements = document.getElementById('topnav-menu-content').getElementsByTagName('a');
    for (var i = 0, len = elements.length; i < len; i++) {
      if (elements[i].parentElement.getAttribute('class') === 'nav-item dropdown active') {
        elements[i].parentElement.classList.remove('active');
        if (elements[i].nextElementSibling !== null) {
          elements[i].nextElementSibling.classList.remove('show');
        }
      }
    }
  }
  function initComponents() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
      return new bootstrap.Popover(popoverTriggerEl);
    });
    var offcanvasElementList = [].slice.call(document.querySelectorAll('.offcanvas'));
    var offcanvasList = offcanvasElementList.map(function (offcanvasEl) {
      return new bootstrap.Offcanvas(offcanvasEl);
    });
  }
  function initPreloader() {
    $(window).on('load', function () {
      $('#status').fadeOut();
      $('#preloader').delay(350).fadeOut('slow');
    });
  }
  function initSettings() {
    if (window.sessionStorage) {
      var alreadyVisited = sessionStorage.getItem('is_visited');
      if (!alreadyVisited) {
        if ($('html').attr('dir') === 'rtl' && $('body').attr('data-layout-mode') === 'dark') {
          $('#dark-rtl-mode-switch').prop('checked', true);
          $('#light-mode-switch').prop('checked', false);
          sessionStorage.setItem('is_visited', 'dark-rtl-mode-switch');
          updateThemeSetting(alreadyVisited);
        } else if ($('html').attr('dir') === 'rtl') {
          $('#rtl-mode-switch').prop('checked', true);
          $('#light-mode-switch').prop('checked', false);
          sessionStorage.setItem('is_visited', 'rtl-mode-switch');
          updateThemeSetting(alreadyVisited);
        } else if ($('body').attr('data-layout-mode') === 'dark') {
          $('#dark-mode-switch').prop('checked', true);
          $('#light-mode-switch').prop('checked', false);
          sessionStorage.setItem('is_visited', 'dark-mode-switch');
          updateThemeSetting(alreadyVisited);
        } else {
          sessionStorage.setItem('is_visited', 'light-mode-switch');
        }
      } else {
        $('.right-bar input:checkbox').prop('checked', false);
        $('#' + alreadyVisited).prop('checked', true);
        updateThemeSetting(alreadyVisited);
      }
    }
    $('#light-mode-switch, #dark-mode-switch, #rtl-mode-switch, #dark-rtl-mode-switch').on('change', function (e) {
      updateThemeSetting(e.target.id);
    });

    // show password input value
    $('#password-addon').on('click', function () {
      if ($(this).siblings('input').length > 0) {
        $(this).siblings('input').attr('type') == 'password' ? $(this).siblings('input').attr('type', 'input') : $(this).siblings('input').attr('type', 'password');
      }
    });
  }
  function updateThemeSetting(id) {
    if ($('#light-mode-switch').prop('checked') == true && id === 'light-mode-switch') {
      $('html').removeAttr('dir');
      $('#dark-mode-switch').prop('checked', false);
      $('#rtl-mode-switch').prop('checked', false);
      $('#dark-rtl-mode-switch').prop('checked', false);
      $('#bootstrap-style').attr('href', 'assets/css/bootstrap.min.css');
      $('body').attr('data-layout-mode', 'light');
      $('#app-style').attr('href', 'assets/css/app.min.css');
      sessionStorage.setItem('is_visited', 'light-mode-switch');
    } else if ($('#dark-mode-switch').prop('checked') == true && id === 'dark-mode-switch') {
      $('html').removeAttr('dir');
      $('#light-mode-switch').prop('checked', false);
      $('#rtl-mode-switch').prop('checked', false);
      $('#dark-rtl-mode-switch').prop('checked', false);
      $('body').attr('data-layout-mode', 'dark');
      sessionStorage.setItem('is_visited', 'dark-mode-switch');
    } else if ($('#rtl-mode-switch').prop('checked') == true && id === 'rtl-mode-switch') {
      $('#light-mode-switch').prop('checked', false);
      $('#dark-mode-switch').prop('checked', false);
      $('#dark-rtl-mode-switch').prop('checked', false);
      $('#bootstrap-style').attr('href', 'assets/css/bootstrap-rtl.min.css');
      $('#app-style').attr('href', 'assets/css/app-rtl.min.css');
      $('html').attr('dir', 'rtl');
      $('body').attr('data-layout-mode', 'light');
      sessionStorage.setItem('is_visited', 'rtl-mode-switch');
    } else if ($('#dark-rtl-mode-switch').prop('checked') == true && id === 'dark-rtl-mode-switch') {
      $('#light-mode-switch').prop('checked', false);
      $('#rtl-mode-switch').prop('checked', false);
      $('#dark-mode-switch').prop('checked', false);
      $('#bootstrap-style').attr('href', 'assets/css/bootstrap-rtl.min.css');
      $('#app-style').attr('href', 'assets/css/app-rtl.min.css');
      $('html').attr('dir', 'rtl');
      $('body').attr('data-layout-mode', 'dark');
      sessionStorage.setItem('is_visited', 'dark-rtl-mode-switch');
    }
  }
  function initLanguage() {
    // Auto Loader
    if (language != null && language !== default_lang) setLanguage(language);
    $('.language').on('click', function (e) {
      setLanguage($(this).attr('data-lang'));
    });
  }
  function initCheckAll() {
    $('#checkAll').on('change', function () {
      $('.table-check .form-check-input').prop('checked', $(this).prop('checked'));
    });
    $('.table-check .form-check-input').change(function () {
      if ($('.table-check .form-check-input:checked').length == $('.table-check .form-check-input').length) {
        $('#checkAll').prop('checked', true);
      } else {
        $('#checkAll').prop('checked', false);
      }
    });
  }
  function init() {
    initMetisMenu();
    initLeftMenuCollapse();
    initActiveMenu();
    initMenuItemScroll();
    initHoriMenuActive();
    initFullScreen();
    initRightSidebar();
    initDropdownMenu();
    initComponents();
    initSettings();
    initLanguage();
    initPreloader();
    Waves.init();
    initCheckAll();
  }
  init();
})(jQuery);

/***/ }),

/***/ "./resources/scss/bootstrap.scss":
/*!***************************************!*\
  !*** ./resources/scss/bootstrap.scss ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/scss/icons.scss":
/*!***********************************!*\
  !*** ./resources/scss/icons.scss ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/scss/app.scss":
/*!*********************************!*\
  !*** ./resources/scss/app.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/css/style.css":
/*!*********************************!*\
  !*** ./resources/css/style.css ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/app": 0,
/******/ 			"css/style": 0,
/******/ 			"assets/css/app": 0,
/******/ 			"assets/css/icons": 0,
/******/ 			"assets/css/bootstrap": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkbackoffice_anecake"] = self["webpackChunkbackoffice_anecake"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/style","assets/css/app","assets/css/icons","assets/css/bootstrap"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	__webpack_require__.O(undefined, ["css/style","assets/css/app","assets/css/icons","assets/css/bootstrap"], () => (__webpack_require__("./resources/scss/bootstrap.scss")))
/******/ 	__webpack_require__.O(undefined, ["css/style","assets/css/app","assets/css/icons","assets/css/bootstrap"], () => (__webpack_require__("./resources/scss/icons.scss")))
/******/ 	__webpack_require__.O(undefined, ["css/style","assets/css/app","assets/css/icons","assets/css/bootstrap"], () => (__webpack_require__("./resources/scss/app.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/style","assets/css/app","assets/css/icons","assets/css/bootstrap"], () => (__webpack_require__("./resources/css/style.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;