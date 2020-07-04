Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: "question-viewer",
            path: "/question-viewer",
            component: require("./components/QViewer")
        }
    ]);
});
