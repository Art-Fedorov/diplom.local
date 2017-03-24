
window.shuffle = require('lodash.shuffle');
window.clone = require('lodash.clone');
window.clonedeep = require('lodash.clonedeep');
window.isEqual = require('lodash.isequal');
/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');
require('vue-resource');
//require('vue2-filters');
//window.VueRouter = require('vue-router');
require('jquery-mask-plugin');
//import VeeValidate from 'vee-validate';
const validateConfig={

};
//Vue.use(VeeValidate,validateConfig);
/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);

    next();
});


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });

$(function(){
  var activeSidebar=false;
  $('.sidebar-button').on('click',function(){
    $(".xs-comeout").toggleClass('active');
    $(this).text($(this).text()=="Показать сайдбар" ? "Скрыть сайдбар" : "Показать сайдбар");
    activeSidebar=!activeSidebar;
  });
  $('.main').on('click','.js-main-content',function(event) {
    if (activeSidebar) $('.sidebar-button').click();
  });
  function onResize(){
    //console.log($('.main').find('sidebar'));
    if ($(window).width()>991){
      $('.sidebar-button').hide();
    } else {
      $('.sidebar-button').show();
    }
  }
  onResize();
  $(window).on('resize',function(){
    onResize();
  });
});