# LAB-MSERRANO

# install node
```shell
sudo apt install nodejs
node -v
```
* NOTE
*  yarn requires node >= v6.11.5
*  17.10 (Artful Aardvark) was released with node v6.11.4
*  below will upgrade node to v8.x
```shell
sudo apt install curl
curl -sL https://deb.nodesource.com/setup_8.x | sudo -E bash -
sudo apt remove nodejs && sudo apt install nodejs
```

# install yarn (debian)
```shell
sudo apt install curl
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
sudo apt update && sudo apt install yarn
```

# setup alias
```shell
echo alias y=yarn >> /home/ {{YOUR USER}}/.bashrc
```

# install composer
https://getcomposer.org/download/
```shell
mv composer.phar /usr/local/bin/composer
composer install
```

# install xdebug
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


# restart shell
```shell
exec bash
```

# install JS dependencies
```shell
y install
```

# install PHP dependencies
```shell
composer install
```

# watch changes (unminified)
```shell
y dev
```

# build for production (minified)
```shell
y prod
```

# watch JS tests
```shell
y js
```

# watch PHP tests
```shell
y php
```

# watch SASS tests
```shell
y css
```

# run JS coverage tests
```shell
y js:cov
```

# run PHP coverage tests
```shell
y php:cov
```

# run JS & PHP coverage tests
```shell
y test
```

# build info (webpack --verbose)
```shell
y ? 
```

# Recommended .gitignore
```
/nbproject/**
/.gitignore
/node_modules/**
/tmp/**
yarn-error.log
/vendor/**
```