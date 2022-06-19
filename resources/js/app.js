/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
toastr.options = {
    positionClass: 'toast-bottom-right',
    showDuration: '300',
    hideDuration: '1000',
    timeOut: '10000',
    extendedTimeOut: '1000',
    showEasing: 'swing',
    hideEasing: 'linear',
    showMethod: 'fadeIn',
    hideMethod: 'fadeOut',
    closeButton: false,
    newestOnTop: true
  }
  $(document).ajaxStart(() => {
    // show loader
    $.blockUI({
      fadeIn: 200,
      fadeOut: 400,
      timeout: 0,
      message: $(
        '<div class="loader bg-transparent no-shadow mx-auto">\n' +
        '<div class="ball-spin-fade-loader">\n' +
        '<div class="bg-sunny-morning"></div>\n' +
        '<div class="bg-sunny-morning"></div>\n' +
        '<div class="bg-sunny-morning"></div>\n' +
        '<div class="bg-sunny-morning"></div>\n' +
        '<div class="bg-sunny-morning"></div>\n' +
        '<div class="bg-sunny-morning"></div>\n' +
        '<div class="bg-sunny-morning"></div>\n' +
        '<div class="bg-sunny-morning"></div>\n' +
        '</div>\n' +
        '</div>\n'
      )
    });
  });
  $(document).ajaxError((event, jqxhr, settings, thrownError) => {
    // hide loader
    $.unblockUI();
    console.error(jqxhr.responseText);
    notify('error', 'Ralat', thrownError);
  });
  $(document).ajaxSuccess((event, jqxhr, settings, data) => {
    // hide loader
    $.unblockUI();
    if (settings.dataType === 'json') {
      if (! data.success) {
        if (data.msg)
          notify('warning', 'Amaran', data.msg);
      }
      else {
        if (settings.url === '/login')
          window.location.replace('/');
        if (data.msg)
          notify('success', 'Mesej', data.msg);
      }
    }
    else {
      if (jqxhr.getResponseHeader('X-AUTHENTICATED') === '0')
        window.location.reload();
    }
  });