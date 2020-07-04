<template>
    <a :href="link"
    	class="cursor-pointer dim no-underline text-primary inline-flex items-center"
        target="_blank">查看详情</a>
</template>
<script>
export default {
    props: ['resourceName', 'field'],
    computed: {
        link() {
            return this.resourceName + '/' + this.field.id;
        }
    },
}

</script>
