import { Doughnut } from "vue-chartjs";
export default {
    extends: Doughnut,
    props: {
        chartData: null,
        chartOptions: null
    },
    mounted: function mounted() {
        this.renderChart(
            {
                labels: this.chartOptions,
                datasets: this.chartData
            },
            {
                responsive: true,
                maintainAspectRatio: false
            }
        );
    }
};
