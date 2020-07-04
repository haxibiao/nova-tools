Nova.booting((Vue, router) => {
    Vue.component("index-VueEditor", require("./components/IndexEditor"));
    Vue.component("detail-VueEditor", require("./components/DetailEditor"));
    Vue.component("form-VueEditor", require("./components/FormEditor"));
});
