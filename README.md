# haxibiao-nova 

> haxibiao-nova 扩展Nova里的tools的功能(sass,vue,api等)的插件库(目前答赚已全面使用)

## 安装步骤
1. `composer.json`改动如下：
    1. 在`require`中加入`"haxibiao/nova": "*"`
    2. 在`repositories`中添加远程仓库指向`http://code.haxibiao.cn/composer/haxibiao-nova.git` 
2. 执行`composer update haxibiao/nova --lock --ignore-platform-reqs`

### 如何完成更新？
> 远程仓库的composer package发生更新时如何进行更新操作呢？
1. 执行`composer update haxibiao/nova`
