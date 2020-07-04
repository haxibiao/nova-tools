<template>
    <div>
        <heading class="mb-6">刷子查询</heading>

        <div class="relative w-3/3 mx-auto">
          <input type="search" class="bg-purple-white shadow rounded border-0 p-3" placeholder="请输入刷子账号或提现账号" id="search-input" autocomplete="off" v-model="keywords" @keyup.enter="search">
           <div class="absolute pin-r pin-t mt-3 mr-4 text-purple-lighter" id="search-btn" @click="search">
            <svg version="1.1" class="h-4 text-dark" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 52.966 52.966" style="enable-background:new 0 0 52.966 52.966;" xml:space="preserve">
                <path d="M51.704,51.273L36.845,35.82c3.79-3.801,6.138-9.041,6.138-14.82c0-11.58-9.42-21-21-21s-21,9.42-21,21s9.42,21,21,21
                c5.083,0,9.748-1.817,13.384-4.832l14.895,15.491c0.196,0.205,0.458,0.307,0.721,0.307c0.25,0,0.499-0.093,0.693-0.279
                C52.074,52.304,52.086,51.671,51.704,51.273z M21.983,40c-10.477,0-19-8.523-19-19s8.523-19,19-19s19,8.523,19,19
                S32.459,40,21.983,40z"/></svg>

            </div>
        </div>

        <div class="w-3/3 mx-auto">
          <div class="bg-white shadow-md rounded my-6">
            <table class="text-left w-full border-collapse" v-show="users.length > 0"> 
              <thead>
                <tr align="center">
                  <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">ID</th>
                  <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">账号</th>
                  <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">昵称</th>
                  <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">使用状态</th>
                  <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">提现账号</th>
                  <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">操作</th>
                </tr>
              </thead>
              <tbody>
                <tr class="hover:bg-grey-lighter" align="center" v-for="user of users">
                  <td class="py-4 px-6 border-b border-grey-light">{{ user.id }}</td>
                  <td class="py-4 px-6 border-b border-grey-light">{{ user.account }}</td>
                  <td class="py-4 px-6 border-b border-grey-light">{{ user.name }}</td>
                  <td class="py-4 px-6 border-b border-grey-light">
                    <span :class="'inline-block rounded-full w-2 h-2 mr-1 bg-'+ (user.status == 0 ? 'success' : 'danger')"></span>
                    {{ user.status == 0 ? '正常' : '封号' }}
                </td>
                  <td class="py-4 px-6 border-b border-grey-light">{{ user.pay_account ? user.pay_account : '未绑定' }}</td>
                  <td class="py-4 px-6 border-b border-grey-light">
                    <a class="btn btn-default btn-primary" :href="resourcePath+user.id" target="_blank">查看</a>
                </td> 
                </tr>
              </tbody>
            </table>
          </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            keywords:null,
            users:[],
            api:'/nova-vendor/shuazi-viewer/search-users',
            resourcePath:Nova.config.base + '/resources/users/',
        }
    },

    mounted(){
        if(this.$route.query.keywords){
            this.keywords = this.$route.query.keywords;
            this.search();
        }
    },

    methods:{
        search:function(){
            var vm = this;
            if(vm.keywords){
                var requestAddress = vm.api + '?account='+vm.keywords;
                Nova.request().get(requestAddress).then(response => {
                    vm.users = response.data;
                })

                if(vm.users.length == 0){
                    return this.$toasted.show('未搜索到任何用户', { type: 'success' });
                }

                return this.$toasted.show('搜索成功', { type: 'success' });
            }
            return this.$toasted.show('账号不能为空', { type: 'error' });
        }
    },
}
</script>

<style lang="scss">
*, :after, :before{
    border: 0 solid #e3e7eb;
}
#search-input{
    width: 100%;
}
#search-btn{
    cursor: pointer;
}
</style>
