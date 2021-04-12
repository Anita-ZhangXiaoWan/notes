# 安装Gitlab CE Omnibus包
gitlab有两种安装方式：源码安装和Omnibus包安装，本文采用后一种方式

1. 进入[官方网站](https://about.gitlab.com/installation/)，选择对应的操作系统，按照官方的提示进行安装：

    1.安装并配置必要的依赖
	
	```
	sudo yum install -y curl policycoreutils-python openssh-server
	sudo systemctl enable sshd
	sudo systemctl start sshd

	sudo firewall-cmd --permanent --add-service=http
	sudo systemctl reload firewalld

	sudo yum install postfix
	sudo systemctl enable postfix
	sudo systemctl start postfix
	```	
	
2. 下载Omnibus包并安装

	1.Omnibus包分为ce(社区版)和ee(企业版)，根据现在的需求选择ce版。由于通过官方地址下载速度较慢，所以使用[国内镜像](https://mirrors.tuna.tsinghua.edu.cn/gitlab-ce/yum/el7/)的包，打开链接，找到需要下载的版本，右击选择“复制链接地址”即可获得下载地址,本文下载的是10.3.3的包。在服务器执行：

	```
	wget https://mirrors.tuna.tsinghua.edu.cn/gitlab-ce/yum/el7/gitlab-ce-10.3.3-ce.0.el7.x86_64.rpm
	```
	2.安装
	
	```
	yum localinstall gitlab-ce-10.3.3-ce.0.el7.x86_64.rpm -y
	```
	3.配置并启动
	
	修改配置文件`/etc/gitlab/gitlab.rb`，将	`external_url = 'http://git.example.com'`修改为自己的ip地址：`external_url = http://xxx.xx.xxx.xx`（必须是http开头），然后启动gitlab:
	
	`sudo gitlab-ctl reconfigure`
		 
		
# 汉化
1.下载[汉化补丁包](https://github.com/marbleqi/gitlab-ce-zh),要注意补丁包和gitlab安装包版本一致，在服务器中执行：

```
yum install git   

git clone https://github.com/marbleqi/gitlab-ce-zh.git
```

2.停止Gitlab服务。

`sudo gitlab-ctl stop`

3.备份服务器上的`/opt/gitlab/embedded/service/gitlab-rails`目录。

4.将解压后的汉化包覆盖服务器上的`/opt/gitlab/embedded/service/gitlab-rails`目录,执行:

`sudo cp -rf /path to gitlab-ce-zh/. /opt/gitlab/embedded/service/gitlab-rails`

5.启动Gitlab服务。

`sudo gitlab-ctl start`

6.重新执行配置命令。

`sudo gitlab-ctl reconfigure`
	

# 配置
#### 配置邮箱。

1. 首先，你需要有一个企业邮箱，[注册地址](https://exmail.qq.com/onlinesell/intro)，我采用的是腾讯的企业邮箱。
2. 由于postfix服务器配置比较复杂，所以采用smpt服务器发送邮件。打开配置文件`/etc/gitlab/gitlab.rb`,参照[官方文档](https://docs.gitlab.com/omnibus/settings/smtp.html)中腾讯企业邮箱的配置方法修改以下配置项：

```
gitlab_rails['smtp_enable'] = true
gitlab_rails['smtp_address'] = "smtp.exmail.qq.com"
gitlab_rails['smtp_port'] = 465
gitlab_rails['smtp_user_name'] = "邮箱账号"
gitlab_rails['smtp_password'] = "邮箱密码"
gitlab_rails['smtp_authentication'] = "login"
gitlab_rails['smtp_enable_starttls_auto'] = true
gitlab_rails['smtp_tls'] = true
gitlab_rails['gitlab_email_from'] = '邮箱账号'
	
```
#### 更多配置说明参考[官方文档](https://docs.gitlab.com/omnibus/README.html)

# 卸载

1. 停止gitlab
`sudo gitlab-ctl stop`
2. 卸载gitlab
`sudo rpm -e gitlab-ce`
3. 查看gitlab进程 
`ps -ef|grep gitlab`
4. 杀死gitlab进程
`kill -9 ****`
5. 删除相关文件 
`find / -name gitlab|xargs rm -rf`


		
		 