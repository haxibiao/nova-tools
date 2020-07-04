Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: "shuazi-viewer",
            path: "/shuazi-viewer",
            component: require("./components/Shuazi")
        }
    ]);
});
