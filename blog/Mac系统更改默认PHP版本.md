Mac系统会预置PHP,但是一般版本较旧.
当我们需要升级PHP版本,并在新版本上安装依赖时,或者使用的是MAMP这样的集成环境,但是需要为MAMP中的PHP添加依赖的时候,就需要更改系统默认php.
步骤如下:

1. 打开环境变量文件.bash_profile

````
vim ~/.bash_profile
````
2. 添加php默认启动程序
```
export PATH="/Applications/MAMP/bin/php/php7.1.13/bin:$PATH"
```
3. 保存退出文件,并使更改立即生效
```
source ~/.bash_profile
```
4. 查看当前PHP版本及启动地址
```
php -v 

which php
```

同样的方法也适用于其他软件
