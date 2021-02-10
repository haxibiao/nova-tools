Nova.booting((Vue) => {
    Vue.component('index-select-auto-complete', () =>
        import(/* webpackChunkName: "index-select-auto-complete" */ './components/SelectAutoComplete/Index')
    );
    Vue.component('detail-select-auto-complete', () =>
        import(/* webpackChunkName: "detail-select-auto-complete" */ './components/SelectAutoComplete/Detail')
    );
    Vue.component('form-select-auto-complete', () =>
        import(/* webpackChunkName: "form-select-auto-complete" */ './components/SelectAutoComplete/Form')
    );
});
