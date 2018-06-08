# LAB-MSERRANO  
<p align="left">
    <img src="https://avatars2.githubusercontent.com/u/30729323?s=200&v=4" title="mserrano-dev (LAB-MSERRANO)"></img>
</p>  

__Javascript (AngularJS) + PHP + CSS (Sass) + WebPack + Yarn + Unit Tests__  
A seed for the other mserrano-dev frontend apps.

---
__install node__
```shell
# use combination of webpack and node scripts for our build-process.
sudo apt install nodejs
node -v
```
* NOTE  
⋅⋅⋅yarn requires node >= v6.11.5  
⋅⋅⋅17.10 (Artful Aardvark) was released with node v6.11.4  
⋅⋅⋅below will upgrade node to v8.x  
```shell
sudo apt install curl
curl -sL https://deb.nodesource.com/setup_8.x | sudo -E bash -
sudo apt remove nodejs && sudo apt install nodejs
```

__install xdebug__
```shell
git clone git://github.com/xdebug/xdebug.git
sudo apt install php7.1-dev
cd xdebug
phpize
./configure --enable-xdebug
sudo make
sudo make install
```
remove xdebug folder
take note of the path it spits out after make install and add line to php.ini
```shell
zend_extension={{YOUR LINE=/usr/lib/php/20160303}}/xdebug.so
```

__install PHP dependencies__
```shell
# install composer via https://getcomposer.org/download/
mv composer.phar /usr/local/bin/composer
# install deps
composer install
```

__install JS dependencies__
```shell
# install yarn
sudo apt install curl
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
sudo apt update && sudo apt install yarn
# setup alias, restart shell
echo alias y=yarn >> /home/ {{YOUR USER}}/.bashrc
exec bash
# install deps
y install
```

---
| Command      | Description                     |
| :----------- | :------------------------------ |
| y dev        | watch for changes (unminified)  |
| y prod       | build for production (minified) |
| y js         | watch JS tests                  |
| y php        | watch PHP tests                 |
| y css        | watch SASS tests                |
| y php:cov    | run PHP coverage tests          |
| y test:php   | run PHP coverage tests          |
| y js:cov     | run JS coverage tests           |
| y test:js    | run JS coverage tests           |
| y test       | run JS & PHP coverage tests     |
| y ?          | build info (webpack --verbose)  |
