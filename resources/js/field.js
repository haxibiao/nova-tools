Nova.booting((Vue, router) => {
    Vue.component('index-vue-multiselect', require('./components/IndexField'));
    Vue.component('detail-vue-multiselect', require('./components/DetailField'));
    Vue.component('form-vue-multiselect', require('./components/FormField'));
})
